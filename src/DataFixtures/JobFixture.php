<?php

namespace App\DataFixtures;

use App\Entity\Job;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class JobFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $data=[
            "Data scientist",
            "Statisticien",
            "Analyse cyber-sécurité",
            "Medecin ORL",
            "Echographiste",
            "Mathematicien",
            "Ingénieur logiciel",
            "Analyste informatique",
            "Pathologiste du discours/language",
            "Actuaire",
            "Ergothérapeute",
            "Directeur des ressources humaines",
            "Higyeniste dentaire"
        ];

        for ($i=0; $i <count($data) ; $i++) { 
            $jobs = new Job();
            $jobs->setDesignation($data[$i]);
            $manager->persist($jobs);
        }
        

        $manager->flush();
    }
}
