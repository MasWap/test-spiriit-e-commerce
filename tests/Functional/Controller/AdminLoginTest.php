<?php

namespace App\Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminLoginTest extends WebTestCase
{
    /**
     * Vérifier que la page admin redirige vers login quand on n'est pas connecté
     */
    public function testPageAdminRedirigeVersLogin(): void
    {
        $client = static::createClient();
        $client->request('GET', '/admin');
        
        $this->assertResponseRedirects('/login');
    }

    /**
     * Vérifier que la page de login est accessible
     */
    public function testPageLoginEstAccessible(): void
    {
        $client = static::createClient();
        $client->request('GET', '/login');
        
        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('form');
    }

    /**
     * Vérifier que la page d'accueil est accessible
     */
    public function testPageAccueilEstAccessible(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');
        
        $this->assertResponseIsSuccessful();
    }

    /**
     * Vérifier que la page de panier est accessible
     */
    public function testPagePanierEstAccessible(): void
    {
        $client = static::createClient();
        $client->request('GET', '/panier');
        
        $this->assertResponseIsSuccessful();
    }

    /**
     * Vérifier la présence du lien panier
     */
    public function testLienPanierPresent(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        
        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('a[href="/panier"]'); // Lien panier existe
    }

    /**
     * Vérifier que la page change avec locale
     */
    public function testPageAvecLocale(): void
    {
        $client = static::createClient();
        
        // Test français
        $crawler = $client->request('GET', '/');
        $this->assertResponseIsSuccessful();
        
        // Test anglais
        $crawler = $client->request('GET', '/?_locale=en');
        $this->assertResponseIsSuccessful();
    }

    /**
     * Vérifier que l'on peut se connecter à l'admin avec les bons identifiants
     */
    public function testConnexionAdminFonctionne(): void
    {
        $client = static::createClient();
        
        // Aller sur la page de login
        $crawler = $client->request('GET', '/login');
        $this->assertResponseIsSuccessful();
        
        // Se connecter
        $form = $crawler->selectButton('Se connecter')->form();
        $form['username'] = 'admin';
        $form['password'] = 'password';
        $client->submit($form);
        
        // Vérifier qu'on est redirigé vers admin
        $this->assertResponseRedirects();
        $location = $client->getResponse()->headers->get('Location');
        $this->assertStringContainsString('/admin', $location);
    }

    /**
     * Vérifier que l'on ne peut pas se connecter à l'admin avec les mauvais identifiants 
    */
    public function testConnexionAdminEchoueAvecMauvaisIdentifiants(): void
    {
        $client = static::createClient();

        // Aller sur la page de login
        $crawler = $client->request('GET', '/login');
        $this->assertResponseIsSuccessful();

        // Se connecter avec de mauvais identifiants
        $form = $crawler->selectButton('Se connecter')->form();
        $form['username'] = 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $form['password'] = 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $client->submit($form);

        // Vérifier qu'on est redirigé vers login (connexion échouée)
        $this->assertResponseRedirects('/login');
    }
}
