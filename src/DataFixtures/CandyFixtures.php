<?php

namespace App\DataFixtures;

use App\Entity\Candy;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class CandyFixtures extends Fixture
{
    private $slugging;
    public function __construct(SluggerInterface $slugger)
    {
        $this->slugging = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 100; $i++) {
            $candy = new Candy();
            $candy->setName($faker->name());
            $candy->setDescription($faker->paragraph());
            $candy->setCreateAt(new DateTimeImmutable());
            $slug = $this->slugging->slug($candy->getName());
            $candy->setSlug(strtolower($slug));
            $manager->persist($candy);
        }

        $manager->flush();
    }
}
