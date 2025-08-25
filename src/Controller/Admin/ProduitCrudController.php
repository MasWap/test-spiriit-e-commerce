<?php

namespace App\Controller\Admin;

use App\Entity\Produit;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProduitCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Produit::class;
    }

    # Configuration des options CRUD pour l'entitée Produit
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Produit')
            ->setEntityLabelInPlural('Produits')
            ->setPageTitle('index', 'Liste des produits')
            ->setPageTitle('new', 'Créer un produit')
            ->setPageTitle('edit', 'Modifier le produit')
            ->setPageTitle('detail', 'Détails du produit');
    }

    # Configuration des champs pour l'entitée Produit
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nom', 'Nom du produit')
                ->setMaxLength(50)
                ->setRequired(true),
            TextareaField::new('description', 'Description')
                ->setMaxLength(255)
                ->setNumOfRows(3)
                ->setRequired(false)
                ->hideOnIndex(),
            MoneyField::new('prix', 'Prix')
                ->setCurrency('EUR')
                ->setStoredAsCents(false)
                ->setRequired(true),
            TextField::new('imageFile', 'Photo')
                ->setFormType(VichImageType::class)
                ->setRequired(false)
                ->onlyOnForms(),
            ImageField::new('photo', 'Photo')
                ->setBasePath('/images/products')
                ->hideOnForm(),
        ];
    }
}
