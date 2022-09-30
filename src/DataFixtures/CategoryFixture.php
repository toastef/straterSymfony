<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixture extends Fixture
{
    public function load(ObjectManager $manager): void // object manager sert a manipuler la base de donnée voir les méthodes injectée en dépendance
    {
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
