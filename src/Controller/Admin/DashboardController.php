<?php

namespace App\Controller\Admin;

use App\Entity\Produit;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // Redirection vers la liste des produits (car on gère uniquement les produits sur l'interface Admin)
        return $this->redirect($this->generateUrl('admin', [
            'crudAction' => 'index',
            'crudControllerFqcn' => 'App\\Controller\\Admin\\ProduitCrudController'
        ]));
    }

    # Configuration du titre de la sidebar
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('<i class="fas fa-guitar"></i> LAYRAC Guitar Shop Admin');
    }

    # Configuration des éléments dans la sidebar
    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Mes Produits', 'fas fa-box', Produit::class);
        yield MenuItem::linkToUrl('Retour au site', 'fas fa-arrow-left', $this->generateUrl('app_accueil'));
    }
}
