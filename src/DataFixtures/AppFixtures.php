<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Loueur;
use App\Entity\Modele;
use App\Entity\Voiture;
use App\Entity\Location;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    // objectManager permet d'injecter les données dans la bd a l'aide de la methode "persist" et "flush" lui appartienent
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        // la class Factory est de type static=> :: = static 
        $faker = Factory::create();
        
        $locations = [];

        for ($i = 0; $i < 50; $i++) {
            $location = new Location();
            $location->setDateLocation(new \DateTime());
            $location->setNbJrLocation($faker->numberBetween($min = 1, $max = 30));
            $location->setPrixLocation($faker->numberBetween($min = 150, $max = 1600));
            $manager->persist($location);
            $locations[] = $location;
        }

        $voitures = [];

        for ($i = 0; $i < 20; $i++) {
            $voiture = new Voiture();
            $voiture->setNom($faker->name());
            $voiture->setImage($faker->imageUrl());
            $voiture->setNbKm($faker->numberBetween(0, 2000));
            $voiture->setCreateAt(new \DateTimeImmutable());
            $manager->persist($voiture);
            $voitures[] = $voiture;
        }

        $loueurs = [];

        for ($i = 0; $i < 50; $i++) {
            $loueur = new Loueur();
            $loueur->setNom($faker->lastName());
            $loueur->setPrenom($faker->firstName());
            $loueur->setAge($faker->numberBetween($min = 18, $max = 76));
            $loueur->setAdresse($faker->address());
            $loueur->setVoiture($voitures[$faker->numberBetween(0, 14)]);
            $manager->persist($loueur);
            $loueurs[] = $loueur;
        }

        $modeles = [];

        for ($i = 0; $i < 20; $i++) {
            $modele = new Modele();
            $modele->setTypeModele($faker->name());
            $modele->setAnneeModele($faker->numberBetween(1999, 2023));
            $modele->setConso($faker->numberBetween(2, 15));
            $modele->addLoueur($loueurs[$faker->numberBetween(0, 49)]);
            $modele->addLocation($locations[$faker->numberBetween(0, 49)]);
            $manager->persist($modele);
            $modeles[] = $modele;
        }
        // flush permet de recuperer toute les donnees en une seule fois a la fin de la boucle et envoie a la bd
        $manager->flush();
    }
}
