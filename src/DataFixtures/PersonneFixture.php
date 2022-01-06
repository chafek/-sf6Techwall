<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Personne;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;


class PersonneFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        
        $faker=Factory::create('fr_FR');
    
        for ($i=0; $i <100; $i++) {
            $personne=new Personne();
            $personne->setName($faker->name);
            $personne->setFirstname($faker->firstName);
            $personne->setAge($faker->numberBetween(1,88));
            $manager->persist($personne);
        }

        $manager->flush();
    }
}
