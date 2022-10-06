<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixture extends Fixture
{
    private array $categories = ['PHP 8', 'Symfony', 'Laravel', 'Security', 'DataBase',
        'JavaScript','Front End'];
    public function load(ObjectManager $manager): void // object manager sert a manipuler la base de donnée voir les méthodes injectée en dépendance
    {

        foreach($this->categories as $category) {
            $cat = new Category();  // creation d'une nouvelle classe basée sur l'entity
            $cat->setName($category); // setname des catégorie
            $manager->persist($cat); // on persist la $cat on fait un prepare
        }

        $manager->flush();
    }
}
