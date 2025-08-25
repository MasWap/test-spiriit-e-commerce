<?php

namespace App\Controller\Admin;

use App\Entity\Panier;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class PanierCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Panier::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Article du panier')
            ->setEntityLabelInPlural('Articles du panier')
            ->setPageTitle('index', 'Articles dans les paniers')
            ->setPageTitle('new', 'Ajouter un article au panier')
            ->setPageTitle('edit', 'Modifier l\'article')
            ->setPageTitle('detail', 'Détails de l\'article');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('produit', 'Produit'),
            IntegerField::new('quantite', 'Quantité'),
            // DateTimeField::new('dateAjout', 'Date d\'ajout')
            //     ->hideOnForm(),
            TextField::new('sessionId', 'ID de session')
                ->hideOnIndex()
                ->setDisabled(),
        ];
    }
}
