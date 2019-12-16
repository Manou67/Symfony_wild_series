<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use App\Entity\Program;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class EpisodeFixtures extends Fixture  implements DependentFixtureInterface
{
    CONST EPISODES = [
        'L\'épisode 1' => [
            'synopsis' => 'Summary ep 1 ',
        ],
        'L\'épisode 2' => [
            'synopsis' => 'Summary ep 2 ',
        ]
    ];
    public function load(ObjectManager $manager)
    {
        $i = 0;
        foreach (self::EPISODES as $title => $data) {
            $episode = new Episode();
            $episode->setTitle($title);
            $episode->setSynopsis($data['synopsis']);
            $episode->setSeason($this->getReference('season_0'));
            $episode->setNumber($i);
            $slugify = new Slugify();
            $episode->setSlug($slugify->generate($episode->getTitle()));
            $manager->persist($episode);
            $i++;
        }
        $manager->flush();
    }

    public function getDependencies()

    {
        return [SeasonFixtures::class];
    }
}
