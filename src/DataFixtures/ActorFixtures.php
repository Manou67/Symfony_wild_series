<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Actor;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ActorFixtures extends Fixture implements DependentFixtureInterface

{
    const ACTORS = [
        'Norman Reedus',
        'Lauren Cohan',
        'Danai Gurira',
        'Khary Payton',
        'Jeffrey Dean Morgan',
    ];

    public function getDependencies()
    {
        return [ProgramFixtures::class];
    }

    public function load(ObjectManager $manager)
    {
        foreach (self::ACTORS as $key => $actorName) {
            $actor = new Actor();
            $actor->setName($actorName);
            $manager->persist($actor);
            $this->addReference('acteur_' . $key, $actor);
            $actor->addProgram($this->getReference('walking'));
        }
        $manager->flush();
    }
}
