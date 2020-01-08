<?php


namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $manager->persist($this->getSuperAdmin());
        $manager->persist($this->getAdmin());
        $manager->persist($this->getModerator());
        foreach ($this->getStudents() as $student) {
            $manager->persist($student);
        }

        $manager->flush();
    }

    private function getSuperAdmin()
    {
        $user = new User('superadmin');
        $user
            ->setFirstname('super')
            ->setLastname('admin')
            ->setRoles(['ROLE_SUPER_ADMIN'])
            ->setGender('male')
        ;
        $user->setPassword($this->encoder->encodePassword($user, 'antic'));

        return $user;
    }

    private function getAdmin()
    {
        $user = new User('admin');
        $user
            ->setFirstname('admin')
            ->setLastname('doe')
            ->setRoles(['ROLE_ADMIN'])
            ->setGender('female')
        ;
        $user->setPassword($this->encoder->encodePassword($user, 'antic'));

        return $user;
    }

    private function getModerator()
    {
        $user = new User('moderator');
        $user
            ->setFirstname('jane')
            ->setLastname('doe')
            ->setRoles(['ROLE_MODERATOR'])
            ->setGender('female')
        ;
        $user->setPassword($this->encoder->encodePassword($user, 'antic'));

        return $user;
    }

    private function getStudents()
    {
        $users = [];
        $classRooms = $this->getClassRooms();
        $faker = Faker\Factory::create();
        for ($i = 0; $i < 10; $i++) {
            $user = new User("student_$i");
            $user
                ->setFirstname($faker->name)
                ->setLastname($faker->name)
                ->setRoles(['ROLE_STUDENT'])
                ->setGender($faker->randomElement(['male', 'female']))
                ->setClassRoom($this->getReference($faker->randomElement($classRooms)))
            ;
            $user->setPassword($this->encoder->encodePassword($user, 'antic'));
            $this->addReference("student_$i", $user);
            $users[] = $user;
        }


        return $users;
    }

    private function getClassRooms()
    {
        $classRooms = [];
        for ($i = 0; $i < 2; $i++) {
            $classRooms[] = "classroom_$i";
        }

        return $classRooms;
    }

    public function getDependencies()
    {
        return array(
            ClassRoomFixtures::class,
        );
    }
}
