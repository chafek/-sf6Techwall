<?php

namespace App\DataFixtures;

use App\Entity\Hobby;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Hobbyfixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $data=[
            "Yoga",
            "Cuisine",
            "Patisserie",
            "Photographie",
            "Bloging",
            "Lecture",
            "Apprendre une langue",
            "Construction de leggo",
            "Dessin",
            "Coloriage",
            "Peinture",
            "Tissage de tapis",
            "Création de vetements",
            "Fabrication de bijoux",
            "Travail du métal",
            "Décoration de galets",
            "Faire des puzzles",
            "Création de miniatures",
            "Amélioration de l'espace de vie",
            "Apprendre à jongler",
            "Lecture",
            "Programmation informatique"
        ];

        for ($i=0; $i <count($data) ; $i++) { 
            $hobby = new Hobby();
            $hobby->setDesignation($data[$i]);
            $manager->persist($hobby);
        }
       
        $manager->flush();
    }
}
