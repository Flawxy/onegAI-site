<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Documentation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class DocFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr-FR');

        for($i = 0; $i < 4; $i++) {

            $category = new Category();

            $category->setName($faker->sentence(3, true))
                        ->setDescription($faker->sentence(20, true));

            for ($j = 0; $j < mt_rand(3, 5); $j++) {
                $doc = new Documentation();

                $command = $faker->word;
                while (strlen($command) < 8) {
                    $command .= $faker->word;
                }
                $syntax = 'o*' . $command;
                $shortcut = 'o*' . str_split($command)[0] . str_split($command)[4];
                $description = '<p>' . join('</p><p>', $faker->paragraphs(2)) . '</p>';
                $example = $syntax . ' ' . $faker->sentence;
                $wip = $faker->boolean;

                $doc->setCommand($command)
                    ->setSyntax($syntax)
                    ->setShortcut($shortcut)
                    ->setDescription($description)
                    ->setExample($example)
                    ->setWip($wip)
                    ->setCategory($category);

                $manager->persist($doc);
            }

            $manager->persist($category);
        }

        $manager->flush();
    }
}
