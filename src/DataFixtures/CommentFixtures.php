<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->getComments() as $post) {
            $manager->persist($post);
        }

        $manager->flush();
    }

    private function getComments()
    {
        $comments = [];
        $posts = $this->getPosts();
        $users = $this->getUsers();

        $faker = Faker\Factory::create();
        for($i = 0; $i < 100; $i++) {
            $comment = new Comment();
            $comment
                ->setContent($faker->sentence)
                ->setPost($this->getReference($faker->randomElement($posts)))
                ->setUser($this->getReference($faker->randomElement($users)))
                ->setCreatedAt($faker->dateTimeBetween())
            ;

            $comments[] = $comment;
        }

        return $comments;
    }

    private function getUsers()
    {
        $users = [];
        for($i = 0; $i < 10; $i++) {
            $users[] = "student_$i";
        }

        return $users;
    }

    private function getPosts()
    {
        $posts = [];
        for($i = 0; $i < 50; $i++) {
            $posts[] = "post_$i";
        }

        return $posts;
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
            PostFixtures::class,
        );
    }
}
