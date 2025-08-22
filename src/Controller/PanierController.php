<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Entity\Produit;
use App\Repository\PanierRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class PanierController extends AbstractController
{
    # Afficher le panier
    #[Route('/panier', name: 'app_panier')]
    public function index(PanierRepository $panierRepository, SessionInterface $session): Response
    {
        $sessionId = $session->getId();
        $items = $panierRepository->findBySessionId($sessionId);
        $total = $panierRepository->getTotalBySession($sessionId);

        return $this->render('panier/index.html.twig', [
            'items' => $items,
            'total' => $total,
        ]);
    }

    # Ajouter un produit au panier
    #[Route('/panier/ajouter/{id}', name: 'app_panier_ajouter', methods: ['POST'])]
    public function ajouter(
        int $id,
        Request $request,
        ProduitRepository $produitRepository,
        PanierRepository $panierRepository,
        EntityManagerInterface $entityManager,
        SessionInterface $session
    ): Response {
        $produit = $produitRepository->find($id);
        
        if (!$produit) {
            $this->addFlash('error', 'Produit non trouvé');
            return $this->redirectToRoute('app_accueil');
        }

        $quantite = (int) $request->request->get('quantite', 1);
        $sessionId = $session->getId();

        // Vérifier si le produit existe déjà dans le panier
        $itemExistant = $panierRepository->findItemBySessionAndProduct($sessionId, $id);

        if ($itemExistant) {
            // Augmenter la quantité
            $itemExistant->setQuantite($itemExistant->getQuantite() + $quantite);
        } else {
            // Créer un nouvel item
            $nouveauItem = new Panier();
            $nouveauItem->setProduit($produit)
                        ->setQuantite($quantite)
                        ->setSessionId($sessionId);
            
            $entityManager->persist($nouveauItem);
        }

        $entityManager->flush();

        $this->addFlash('success', 'Produit ajouté au panier avec succès !');

        return $this->redirectToRoute('app_produit_show', ['id' => $id]);
    }

    # Modifier un produit dans le panier
    #[Route('/panier/modifier/{id}', name: 'app_panier_modifier', methods: ['POST'])]
    public function modifier(
        int $id,
        Request $request,
        PanierRepository $panierRepository,
        EntityManagerInterface $entityManager,
        SessionInterface $session
    ): Response {
        $sessionId = $session->getId();
        $item = $panierRepository->findItemBySessionAndProduct($sessionId, $id);

        if (!$item) {
            $this->addFlash('error', 'Item non trouvé dans le panier');
            return $this->redirectToRoute('app_panier');
        }

        $nouvelleQuantite = (int) $request->request->get('quantite', 1);
        
        if ($nouvelleQuantite <= 0) {
            $entityManager->remove($item);
        } else {
            $item->setQuantite($nouvelleQuantite);
        }

        $entityManager->flush();

        $this->addFlash('success', 'Panier mis à jour');

        return $this->redirectToRoute('app_panier');
    }

    # Supprimer un produit du panier
    #[Route('/panier/supprimer/{id}', name: 'app_panier_supprimer', methods: ['POST'])]
    public function supprimer(
        int $id,
        PanierRepository $panierRepository,
        EntityManagerInterface $entityManager,
        SessionInterface $session
    ): Response {
        $sessionId = $session->getId();
        $item = $panierRepository->findItemBySessionAndProduct($sessionId, $id);

        if ($item) {
            $entityManager->remove($item);
            $entityManager->flush();
            $this->addFlash('success', 'Produit supprimé du panier');
        }

        return $this->redirectToRoute('app_panier');
    }

    # Vider entièrement le panier
    #[Route('/panier/vider', name: 'app_panier_vider', methods: ['POST'])]
    public function vider(
        PanierRepository $panierRepository,
        EntityManagerInterface $entityManager,
        SessionInterface $session
    ): Response {
        $sessionId = $session->getId();
        $items = $panierRepository->findBySessionId($sessionId);

        foreach ($items as $item) {
            $entityManager->remove($item);
        }

        $entityManager->flush();

        $this->addFlash('success', 'Panier vidé');

        return $this->redirectToRoute('app_panier');
    }
}