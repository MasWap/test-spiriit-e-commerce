<?php

namespace App\Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TranslationTest extends WebTestCase
{
    /**
     * Test de la traduction en français via la route /language/fr
     */
    public function testVraieTraductionFrancais(): void
    {
        $client = static::createClient();
        
        // Utiliser la vraie route de changement de langue vers le français
        $client->request('GET', '/language/fr');
        $this->assertResponseRedirects();
        
        // Suivre la redirection vers l'accueil
        $crawler = $client->followRedirect();
        
        $this->assertResponseIsSuccessful();
        // Vérifier traduction fr
        $this->assertSelectorTextContains('h1', 'Guitares de Légendes');
        $this->assertSelectorTextContains('h2', 'Notre Collection');
        $this->assertSelectorTextContains('.btn', 'Découvrir nos guitares');
    }

    /**
     * Test de la traduction en anglais via la route /language/en
     */
    public function testVraieTraductionAnglais(): void
    {
        $client = static::createClient();
        
        // Utiliser la vraie route de changement de langue vers l'anglais
        $client->request('GET', '/language/en');
        $this->assertResponseRedirects();
        
        // Suivre la redirection vers l'accueil
        $crawler = $client->followRedirect();
        
        $this->assertResponseIsSuccessful();
        // Vérifier traduction en
        $this->assertSelectorTextContains('h1', 'Legendary Guitars');
        $this->assertSelectorTextContains('h2', 'Our Collection');
        $this->assertSelectorTextContains('.btn', 'Discover our guitars');
    }

    /**
     * Test de la traduction sur la page panier
     */
    public function testTraductionPagePanier(): void
    {
        $client = static::createClient();
        
        // Français
        $client->request('GET', '/language/fr');
        $client->followRedirect();
        $crawler = $client->request('GET', '/panier');
        $this->assertResponseIsSuccessful();

        // Vérifier traduction fr
        $this->assertSelectorTextContains('h2', 'Votre panier est vide');
        $this->assertSelectorTextContains('.btn', 'Découvrir nos guitares');

        // Anglais
        $client->request('GET', '/language/en');
        $client->followRedirect();
        $crawler = $client->request('GET', '/panier');
        $this->assertResponseIsSuccessful();

        // Vérifier traduction en
        $this->assertSelectorTextContains('h2', 'Your cart is empty');
        $this->assertSelectorTextContains('.btn', 'Discover our guitars');
    }

    /**
     * Test que les routes de langue fonctionnent bien
     */
    public function testRoutesLangueFonctionnent(): void
    {
        $client = static::createClient();
        
        // Route française - elle redirige
        $client->request('GET', '/language/fr');
        $this->assertResponseRedirects();
        
        // Route anglaise - elle redirige
        $client->request('GET', '/language/en');
        $this->assertResponseRedirects();
        
        // Route invalide doit donner une erreur 404
        $client->request('GET', '/language/es');
        $this->assertResponseStatusCodeSame(404);
    }
}
