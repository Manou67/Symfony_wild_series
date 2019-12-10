<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use App\Entity\Season;
use Faker;
use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class FakerFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

       for($i = 1; $i <= 50; $i++) {
            $actor = new Actor();
            $actor->setName($faker->name());
            $actor->addProgram($this->getReference('program_0'));
            $manager->persist($actor);
       }

        for($i = 1; $i <= 30; $i++) {
            $season = new Season();
            $season->setNumber($faker->randomDigit)
                    ->setYear($faker->year($max = 'now'))
                    ->setDescription($faker->paragraph($nbSentences = 3, $variableNbSentences = true));

            $season->setProgram($this->getReference('program_0'));
            $manager->persist($season);

        }
        for($i = 1; $i <= 30; $i++) {
            $episode = new Episode();
            $episode->setTitle($faker->sentence($nbWords = 3, $variableNbWords = true))
                ->setNumber($faker->randomDigit)
                ->setSynopsis($faker->paragraph($nbSentences = 4, $variableNbSentences = true));
            $manager->persist($episode);

        }
        $manager->flush();
    }
}

