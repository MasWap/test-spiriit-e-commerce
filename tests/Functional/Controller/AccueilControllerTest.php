<?php

namespace App\Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Produit;

class AccueilControllerTest extends WebTestCase
{
    public function testNombreProduits(): void
    {
        // Arrange
        $client = static::createClient();
        
        // Récupérer le nombre de produits en base de données
        $container = static::getContainer();
        $entityManager = $container->get('doctrine')->getManager();
        $produitRepository = $entityManager->getRepository(Produit::class);
        $nombreProduitsEnBase = $produitRepository->count([]);

        // Act
        $crawler = $client->request('GET', '/');

        // Assert
        $this->assertResponseIsSuccessful();
        
        // Compter le nombre de cartes produits affichées
        $productCards = $crawler->filter('.hover-card');
        $nombreCartesAffichees = $productCards->count();
        
        // Vérifier que le nombre de cartes correspond au nombre de produits en base
        $this->assertEquals(
            $nombreProduitsEnBase,
            $nombreCartesAffichees,
            sprintf(
                'Le nombre de cartes affichées (%d) ne correspond pas au nombre de produits en base (%d)',
                $nombreCartesAffichees,
                $nombreProduitsEnBase
            )
        );
    }
}
