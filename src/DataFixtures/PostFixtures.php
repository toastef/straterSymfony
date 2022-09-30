<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class PostFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
       $faker = Faker\Factory::create();
        $categories = $manager->getRepository(Category::class)->findAll(); // utilisation de la classe du manager getrepository qui va permettre de récup les donnée de l'antitée et le findall . va chercher toutes les infos et stocke les dans $categories
        $countCat = count($categories);
        for($i=1; $i<= 35 ; $i++)
        {
            $post = new Post();
            $post->setTitle($faker->words(3,true))// générer un titre de 3 mots avec faker
                ->setContent($faker->paragraphs(3,true))
                ->setCreatedAt(new \DateTimeImmutable())
                ->setImage($i.'.png')
                ->setIsPublished($faker->boolean(90))
                ->setCategory($categories [$faker->numberBetween(0,$countCat -1)]); // nombre aléatoire entre 0 et le nombre d"élément du tab -1 pour générer le numéro du tableau
            $manager->persist($post);

        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [CategoryFixture::class,
            ];
    }
}
