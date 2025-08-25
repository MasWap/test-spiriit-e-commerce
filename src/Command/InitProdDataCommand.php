<?php

namespace App\Command;

use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:init-prod-data',
    description: 'Initialise les données de base pour la production',
)]
class InitProdDataCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // Vérifier si des produits existent déjà
        $existingProducts = $this->entityManager->getRepository(Produit::class)->count([]);
        
        if ($existingProducts > 0) {
            $io->success('Des produits existent déjà en base de données.');
            return Command::SUCCESS;
        }

        $io->note('Initialisation des données de production...');

        // Créer quelques produits de base
        $produits = [
            [
                'nom' => 'Ltd LK-600 Luke Kilpatrick - black',
                'description' => "La LTD LK-600 est la guitare signature du Luke Kilpatrick, guitariste du groupe de metalcore Australien Parkway Drive. Cette guitare est particulièrement adaptée au metal et autres style énergiques.",
                'prix' => 1323.99,
                'photo' => 'ltd-lk600-black.png'
            ],
            [
                'nom' => 'PRS SE Mark Holcomb SVN - holcomb blue burst',
                'description' => "La PRS SE Mark Holcomb SVN est le modèle signature d'un des trois fantastiques guitaristes du groupe de Metal-Progressif-Djent Periphery qui s'est imposé à force d'excellence et de virtuosité comme un chef de file du genre.",
                'prix' => 1218.99,
                'photo' => 'prs-se-mark-holcomb.png'
            ],
            [
                'nom' => 'Fender Jim Root Stratocaster - flat white',
                'description' => "La Fender Jim Root Stratocaster est la guitare signature du guitariste de Slipknot et Stone Sour. Avec ses micros EMG actifs 60/81, son corps en aulne et son manche en érable, elle délivre un son agressif parfait pour le metal moderne.",
                'prix' => 1599.99,
                'photo' => 'fender-jim-root-strat.png'
            ],
            [
                'nom' => 'Gibson Les Paul Axe of Creation - ebony',
                'description' => "Modèle signature de Zakk Wylde (Black Label Society, Ozzy Osbourne), cette Gibson Les Paul arbore le design iconique 'bulls eye' en ébène. Équipée de micros EMG 81/85, elle offre un sustain légendaire et un son massif caractéristique du style de Zakk Wylde.",
                'prix' => 2899.99,
                'photo' => 'gibson-zakk-wylde.png'
            ],
            [
                'nom' => 'Ibanez RG550 Steve Vai - desert sun yellow',
                'description' => "L'Ibanez RG550 est l'instrument de prédilection de Steve Vai. Avec son manche ultra-fin Wizard, ses micros DiMarzio Evolution et son vibrato Edge, elle permet une virtuosité technique exceptionnelle. Un choix de référence pour le rock progressif et le shred.",
                'prix' => 1749.99,
                'photo' => 'ibanez-steve-vai.png'
            ],
            [
                'nom' => 'ESP Kirk Hammett KH-2 - vintage white',
                'description' => "Guitare signature du guitariste de Metallica, l'ESP KH-2 Kirk Hammett combine l'héritage du thrash metal avec une esthétique vintage. Ses micros EMG 81/60 et son corps en acajou délivrent le son tranchant caractéristique des riffs de Metallica.",
                'prix' => 2199.99,
                'photo' => 'esp-kirk-hammett.png'
            ],
            [
                'nom' => 'Schecter Synyster Gates Standard - black/silver',
                'description' => "Modèle signature de Synyster Gates (Avenged Sevenfold), cette Schecter arbore un design unique avec ses incrustations argentées. Équipée de micros Schecter Diamond et d'un vibrato Floyd Rose, elle excelle dans le metal mélodique et les solos techniques.",
                'prix' => 899.99,
                'photo' => 'schecter-synyster-gates.png'
            ],
            [
                'nom' => 'Jackson Randy Rhoads V - snow white',
                'description' => "Hommage au légendaire Randy Rhoads (Ozzy Osbourne), cette Jackson en forme de V est devenue iconique. Avec ses micros Seymour Duncan et son corps en acajou, elle délivre le son néo-classique qui a révolutionné le metal dans les années 80.",
                'prix' => 1449.99,
                'photo' => 'jackson-randy-rhoads.png'
            ],
            [
                'nom' => 'Ernie Ball Music Man JP15 - mystic dream',
                'description' => "Guitare signature de John Petrucci (Dream Theater), la JP15 combine innovation technique et polyvalence sonore. Ses micros DiMarzio LiquiFire/Crunch Lab et son manche compound radius permettent une expression musicale sans limite pour le metal progressif.",
                'prix' => 3299.99,
                'photo' => 'musicman-petrucci.png'
            ],
            [
                'nom' => 'Epiphone Slash AFD Les Paul - appetite amber',
                'description' => "Réplique de la Gibson Les Paul historique de Slash utilisée sur l'album Appetite for Destruction de Guns N' Roses. Cette Epiphone capture l'essence du rock classique avec ses micros Seymour Duncan et sa finition vieillie authentique.",
                'prix' => 999.99,
                'photo' => 'epiphone-slash-afd.png'
            ],
            [
                'nom' => 'Fender Dave Murray Stratocaster - 2-color sunburst',
                'description' => "Modèle signature de Dave Murray (Iron Maiden), cette Stratocaster combine l'héritage Fender avec les exigences du heavy metal. Ses micros Seymour Duncan Hot Rails et son vibrato vintage offrent la polyvalité nécessaire aux mélodies épiques d'Iron Maiden.",
                'prix' => 1399.99,
                'photo' => 'fender-dave-murray.png'
            ],
            [
                'nom' => 'Solar A1.6 Ola Englund - trans black burst',
                'description' => "Création d'Ola Englund (The Haunted, Six Feet Under), cette Solar A1.6 représente l'évolution moderne de la guitare metal. Avec ses micros Duncan Solar et sa construction scandinave, elle délivre un son contemporain parfait pour le metal extrême.",
                'prix' => 1099.99,
                'photo' => 'solar-ola-englund.png'
            ]
        ];

        foreach ($produits as $produitData) {
            $produit = new Produit();
            $produit->setNom($produitData['nom']);
            $produit->setDescription($produitData['description']);
            $produit->setPrix($produitData['prix']);
            $produit->setPhoto($produitData['photo']);

            $this->entityManager->persist($produit);
        }

        $this->entityManager->flush();

        $io->success('Données de production initialisées avec succès !');
        $io->note(sprintf('%d produits créés.', count($produits)));

        return Command::SUCCESS;
    }
}
