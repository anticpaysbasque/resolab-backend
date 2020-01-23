<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class PostFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->getPosts() as $post) {
            $manager->persist($post);
        }

        $manager->flush();
    }

    private function getPosts()
    {
        $posts = [];
        $users = $this->getUsers();

        $faker = Faker\Factory::create();
        for ($i = 0; $i < 50; $i++) {
            $post = new Post();
            $post
                ->setDescription($faker->sentence)
                ->setPhoto($faker->imageUrl())
                ->setUser($this->getReference($faker->randomElement($users)))
            ;
            $this->addReference("post_$i", $post);
            $posts[] = $post;
        }

        return $posts;
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
