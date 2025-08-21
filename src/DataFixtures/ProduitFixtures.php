<?php

namespace App\DataFixtures;

use App\Entity\Produit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProduitFixtures extends Fixture
{
    // Fixture permettant de charger des produits dans la base de données
    public function load(ObjectManager $manager): void
    {
        $produits = [
            [
                'nom' => 'Ltd LK-600 Luke Kilpatrick - black',
                'description' => "La LTD LK-600 est la guitare signature du Luke Kilpatrick, guitariste du groupe de metalcore Australien Parkway Drive. Cette guitare est particulièrement adaptée au metal et autres style énergiques.",
                'prix' => 1323.99
            ],
            [
                'nom' => 'PRS SE Mark Holcomb SVN - holcomb blue burst',
                'description' => "La PRS SE Mark Holcomb SVN est le modèle signature d'un des trois fantastiques guitaristes du groupe de Metal-Progressif-Djent Periphery qui s'est imposé à force d'excellence et de virtuosité comme un chef de file du genre.",
                'prix' => 1218.99
            ],
            [
                'nom' => 'Fender Jim Root Stratocaster - flat white',
                'description' => "La Fender Jim Root Stratocaster est la guitare signature du guitariste de Slipknot et Stone Sour. Avec ses micros EMG actifs 60/81, son corps en aulne et son manche en érable, elle délivre un son agressif parfait pour le metal moderne.",
                'prix' => 1599.99
            ],
            [
                'nom' => 'Gibson Les Paul Axe of Creation - ebony',
                'description' => "Modèle signature de Zakk Wylde (Black Label Society, Ozzy Osbourne), cette Gibson Les Paul arbore le design iconique 'bulls eye' en ébène. Équipée de micros EMG 81/85, elle offre un sustain légendaire et un son massif caractéristique du style de Zakk Wylde.",
                'prix' => 2899.99
            ],
            [
                'nom' => 'Ibanez RG550 Steve Vai - desert sun yellow',
                'description' => "L'Ibanez RG550 est l'instrument de prédilection de Steve Vai. Avec son manche ultra-fin Wizard, ses micros DiMarzio Evolution et son vibrato Edge, elle permet une virtuosité technique exceptionnelle. Un choix de référence pour le rock progressif et le shred.",
                'prix' => 1749.99
            ],
            [
                'nom' => 'ESP Kirk Hammett KH-2 - vintage white',
                'description' => "Guitare signature du guitariste de Metallica, l'ESP KH-2 Kirk Hammett combine l'héritage du thrash metal avec une esthétique vintage. Ses micros EMG 81/60 et son corps en acajou délivrent le son tranchant caractéristique des riffs de Metallica.",
                'prix' => 2199.99
            ],
            [
                'nom' => 'Schecter Synyster Gates Standard - black/silver',
                'description' => "Modèle signature de Synyster Gates (Avenged Sevenfold), cette Schecter arbore un design unique avec ses incrustations argentées. Équipée de micros Schecter Diamond et d'un vibrato Floyd Rose, elle excelle dans le metal mélodique et les solos techniques.",
                'prix' => 899.99
            ],
            [
                'nom' => 'Jackson Randy Rhoads V - snow white',
                'description' => "Hommage au légendaire Randy Rhoads (Ozzy Osbourne), cette Jackson en forme de V est devenue iconique. Avec ses micros Seymour Duncan et son corps en acajou, elle délivre le son néo-classique qui a révolutionné le metal dans les années 80.",
                'prix' => 1449.99
            ],
            [
                'nom' => 'Ernie Ball Music Man JP15 - mystic dream',
                'description' => "Guitare signature de John Petrucci (Dream Theater), la JP15 combine innovation technique et polyvalence sonore. Ses micros DiMarzio LiquiFire/Crunch Lab et son manche compound radius permettent une expression musicale sans limite pour le metal progressif.",
                'prix' => 3299.99
            ],
            [
                'nom' => 'Epiphone Slash AFD Les Paul - appetite amber',
                'description' => "Réplique de la Gibson Les Paul historique de Slash utilisée sur l'album Appetite for Destruction de Guns N' Roses. Cette Epiphone capture l'essence du rock classique avec ses micros Seymour Duncan et sa finition vieillie authentique.",
                'prix' => 999.99
            ],
            [
                'nom' => 'Fender Dave Murray Stratocaster - 2-color sunburst',
                'description' => "Modèle signature de Dave Murray (Iron Maiden), cette Stratocaster combine l'héritage Fender avec les exigences du heavy metal. Ses micros Seymour Duncan Hot Rails et son vibrato vintage offrent la polyvalité nécessaire aux mélodies épiques d'Iron Maiden.",
                'prix' => 1399.99
            ],
            [
                'nom' => 'Solar A1.6 Ola Englund - trans black burst',
                'description' => "Création d'Ola Englund (The Haunted, Six Feet Under), cette Solar A1.6 représente l'évolution moderne de la guitare metal. Avec ses micros Duncan Solar et sa construction scandinave, elle délivre un son contemporain parfait pour le metal extrême.",
                'prix' => 1099.99
            ]
        ];

        // Création des objets Produit et persistance dans la base de données
        foreach ($produits as $produitData) {
            $produit = new Produit();
            $produit->setNom($produitData['nom']);
            $produit->setDescription($produitData['description']);
            $produit->setPrix($produitData['prix']);
            
            $manager->persist($produit);
        }

        // Flush des changements pour les enregistrer dans la base de données
        $manager->flush();
    }
}
