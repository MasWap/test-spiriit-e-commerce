<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class LanguageController extends AbstractController
{
    #[Route('/language/{locale}', name: 'app_change_language', requirements: ['locale' => 'fr|en'])]
    public function changeLanguage(string $locale, Request $request): Response
    {
        // Stocker la langue dans la session
        $request->getSession()->set('_locale', $locale);
        
        // Rediriger vers la page précédente ou l'accueil
        $referer = $request->headers->get('referer');
        if ($referer) {
            return $this->redirect($referer);
        }
        
        return $this->redirectToRoute('app_accueil');
    }
}
