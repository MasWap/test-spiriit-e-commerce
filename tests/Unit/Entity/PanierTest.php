<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Panier;
use App\Entity\Produit;
use PHPUnit\Framework\TestCase;

class PanierTest extends TestCase
{
    # Test de la méthode getSousTotal()
    public function testGetSousTotal(): void
    {
        // Arrange
        $produit = new Produit();
        $produit->setNom('Test Guitar')
                ->setDescription('Test description')
                ->setPrix(1000.50);

        $panier = new Panier();
        $panier->setProduit($produit)
                ->setQuantite(2)
                ->setSessionId('test-session');

        // Act
        $sousTotal = $panier->getSousTotal();

        // Assert
        $this->assertEquals(2001.00, $sousTotal);
        $this->assertIsFloat($sousTotal);
    }

    # Test de la méthode getSousTotalAvecQuantiteZero()
    public function testGetSousTotalAvecQuantiteZero(): void
    {
        // Arrange
        $produit = new Produit();
        $produit->setNom('Test Guitar')
                ->setDescription('Test description')
                ->setPrix(500.00);

        $panier = new Panier();
        $panier->setProduit($produit)
                ->setQuantite(0)
                ->setSessionId('test-session');

        // Act
        $sousTotal = $panier->getSousTotal();

        // Assert
        $this->assertEquals(0.00, $sousTotal);
    }

    # Test de la méthode getSousTotalAvecPrixDecimal()
    public function testGetSousTotalAvecPrixDecimal(): void
    {
        // Arrange
        $produit = new Produit();
        $produit->setNom('Test Guitar')
                ->setDescription('Test description')
                ->setPrix(1234.99);

        $panier = new Panier();
        $panier->setProduit($produit)
                ->setQuantite(3)
                ->setSessionId('test-session');

        // Act
        $sousTotal = $panier->getSousTotal();

        // Assert
        # Utilisation de assertEquals avec arrondi pour éviter les problèmes d'arrondis
        $this->assertEquals(3704.97, round($sousTotal, 2));
    }
}