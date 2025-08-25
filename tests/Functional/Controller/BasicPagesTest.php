<?php

namespace App\Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BasicPagesTest extends WebTestCase
{
    /**
     * Vérifier que toutes les pages principales sont accessibles
     */
    public function testPagesPrincipalesAccessibles(): void
    {
        $client = static::createClient();
        
        // Page d'accueil
        $client->request('GET', '/');
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
        
        // Page du panier
        $client->request('GET', '/panier');
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);

        // Page de login
        $client->request('GET', '/login');
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
    }

    /**
     * Vérifier que les images de produits sont présentes
     */
    public function testImagesProduitsPresentes(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        
        $this->assertResponseIsSuccessful();
        
        // Vérifier qu'il y a au moins une image de produit
        $images = $crawler->filter('img[src*="/images/products/"]');
        $this->assertGreaterThan(0, $images->count(), 'Aucune image de produit trouvée');
    }
}
