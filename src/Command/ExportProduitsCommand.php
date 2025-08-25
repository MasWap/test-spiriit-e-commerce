<?php

namespace App\Command;

use App\Repository\ProduitRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:export-produits',
    description: 'Exporte tous les produits au format CSV',
)]
class ExportProduitsCommand extends Command
{
    private ProduitRepository $produitRepository;

    public function __construct(ProduitRepository $produitRepository)
    {
        $this->produitRepository = $produitRepository;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('filename', InputArgument::OPTIONAL, 'Nom du fichier CSV (sans extension)', 'produits')
            ->addOption('output-dir', 'o', InputOption::VALUE_OPTIONAL, 'Répertoire de sortie', 'var/export')
            ->setHelp('Cette commande exporte tous les produits de la base de données au format CSV.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        
        // Récupération des paramètres
        $filename = $input->getArgument('filename');
        $outputDir = $input->getOption('output-dir');
        
        // Création du répertoire si nécessaire
        if (!is_dir($outputDir)) {
            mkdir($outputDir, 0755, true);
        }
        
        $filepath = $outputDir . '/' . $filename . '.csv';
        
        $io->title('Export des produits LAYRAC Guitar Shop au format CSV');
        $io->text('Récupération des produits depuis la base de données...');
        
        // Récupération de tous les produits
        $produits = $this->produitRepository->findAll();
        
        if (empty($produits)) {
            $io->warning('La base de donnée produit est vide.');
            return Command::SUCCESS;
        }

        $io->text(sprintf('%d produit(s) vont être exportés.', count($produits)));
        $io->text('Génération du fichier CSV...');
        
        // Ouverture du fichier CSV
        $file = fopen($filepath, 'w');
        
        if (!$file) {
            $io->error('Impossible de créer le fichier : ' . $filepath);
            return Command::FAILURE;
        }
        
        // Ajout de l'en-tête CSV
        fputcsv($file, ['ID', 'Nom', 'Description', 'Prix (€)'], ';');
        
        // Ajout des données
        foreach ($produits as $produit) {
            fputcsv($file, [
                $produit->getId(),
                $produit->getNom(),
                $produit->getDescription() ?? '',
                number_format($produit->getPrix(), 2, ',', ' ')
            ], ';');
        }
        
        fclose($file);
        
        $io->success([
            'Export terminé avec succès !',
            'Fichier généré : ' . realpath($filepath),
            'Nombre de produits exportés : ' . count($produits)
        ]);
        
        return Command::SUCCESS;
    }
}
