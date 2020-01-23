<?php

namespace App\DataFixtures;

use App\Entity\Story;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class StoryFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->geStories() as $story) {
            $manager->persist($story);
        }

        $manager->flush();
    }

    private function geStories()
    {
        $stories = [];
        $users = $this->getUsers();

        $faker = Faker\Factory::create();
        for ($i = 0; $i < 50; $i++) {
            $story = new Story();
            $story
                ->setUser($this->getReference($faker->randomElement($users)))
            ;
            $stories[] = $story;
        }

        return $stories;
    }

    private function getUsers()
    {
        $users = [];
        for ($i = 0; $i < 10; $i++) {
            $users[] = "student_$i";
        }

        return $users;
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
        );
    }
}
