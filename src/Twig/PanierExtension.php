<?php

namespace App\Twig;

use App\Repository\PanierRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class PanierExtension extends AbstractExtension
{
    private PanierRepository $panierRepository;
    private RequestStack $requestStack;

    public function __construct(PanierRepository $panierRepository, RequestStack $requestStack)
    {
        $this->panierRepository = $panierRepository;
        $this->requestStack = $requestStack;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('panier_count', [$this, 'getPanierCount']),
        ];
    }

    # Récupérer le nombre d'articles dans le panier
    public function getPanierCount(): int
    {
        $request = $this->requestStack->getCurrentRequest();
        if (!$request) {
            return 0;
        }

        $session = $request->getSession();
        if (!$session->isStarted()) {
            $session->start();
        }

        $sessionId = $session->getId();
        return $this->panierRepository->getCountBySession($sessionId);
    }
}
