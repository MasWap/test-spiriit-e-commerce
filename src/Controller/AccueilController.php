<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(ProduitRepository $produitRepository): Response
    {
        $produits = $produitRepository->findAll();
        
        return $this->render('accueil/index.html.twig', [
            'produits' => $produits,
        ]);
    }

    #[Route('/produit/{slug}', name: 'app_produit_show')]
    public function show(Produit $produit): Response
    {
        return $this->render('produit/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    #[Route('/json', name: 'app_produit_json_all')]
    public function jsonAll(ProduitRepository $produitRepository): Response
    {
        $produits = $produitRepository->findAll();

        return $this->json($produits);
    }
}
