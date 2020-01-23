<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class PostFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr-FR');

        for($i = 0; $i < 8; $i++) {
            $article = new Post();

            $article->setTitle($faker->sentence(mt_rand(3, 6)))
                ->setContent('<p>' . join('</p><p>', $faker->paragraphs(mt_rand(2,4))) . '</p>')
                ->setCreatedAt(new \DateTime())
                ->setImage(str_replace('pixel', 'flickr',$faker->imageUrl(600,400)))
                ->setIntroduction($faker->sentence(mt_rand(15,25)));

            $manager->persist($article);
        }

        $manager->flush();
    }
}
