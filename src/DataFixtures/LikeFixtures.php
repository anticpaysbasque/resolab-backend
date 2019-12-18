<?php

namespace App\DataFixtures;

use App\Entity\Likes;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class LikeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->getLikes() as $like) {
            $manager->persist($like);
        }

        $manager->flush();
    }

    private function getLikes()
    {
        $choices = ['comment', 'post'];
        $likes = [];
        $posts = $this->getPosts();
        $users = $this->getUsers();
        $comments = $this->getComments();

        $faker = Faker\Factory::create();
        for($i = 0; $i < 200; $i++) {
            $like = new Likes();
            $like->setUser($this->getReference($faker->randomElement($users)));
            switch ($faker->randomElement($choices)) {
                case 'comment':
                    $like->setComment($this->getReference($faker->randomElement($comments)));
                    break;
                case 'post':
                    $like->setPost($this->getReference($faker->randomElement($posts)));
                    break;
            }

            $likes[] = $like;
        }

        return $likes;
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
            PostFixtures::class,
            CommentFixtures::class,
        );
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
        $likes = [];
        for($i = 0; $i < 50; $i++) {
            $likes[] = "post_$i";
        }

        return $likes;
    }

    private function getComments()
    {
        $comments = [];
        for($i = 0; $i < 100; $i++) {
            $comments[] = "comment_$i";
        }

        return $comments;
    }
}
