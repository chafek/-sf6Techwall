<?php

namespace App\DataFixtures;

use App\Entity\Profile;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProfileFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $profile1=new Profile;
        $profile1->setRs("Facebook");
        $profile1->setUrl("https://fr-fr.facebook.com/");

        $profile2=new Profile;
        $profile2->setRs("whatsapp");
        $profile2->setUrl("https://web.whatsapp.com/");

        $profile3=new Profile;
        $profile3->setRs("twitter");
        $profile3->setUrl("https://twitter.com/");

        $manager->persist($profile1);
        $manager->persist($profile2);
        $manager->persist($profile3);
        $manager->flush();
    }
}
