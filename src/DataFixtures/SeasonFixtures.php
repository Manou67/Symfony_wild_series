<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use App\Entity\Episode;
use App\Entity\Season;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use  Faker;


class SeasonFixtures extends Fixture  implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $seasondescription = array();
        for ($i = 0; $i < 10; $i++) {
            $faker  =  Faker\Factory::create('fr_FR');
            $faker = $faker->word;
            array_push ($seasondescription, $faker);

        }
        for ($i = 0; $i < count($seasondescription);$i++) {
            $season = new Season();
            $season->setNumber($i);
            $season->setYear(rand(1980,2010));
            $season->setDescription($seasondescription[$i]);
            $season->setProgram($this->getReference('program_0'));
            $this->addReference('season_' . $i, $season);
            $manager->persist($season);

        }
        $manager->flush();
    }

    public function getDependencies()

    {
        return [ProgramFixtures::class];
    }
}
