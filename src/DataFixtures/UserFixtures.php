<?php


namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
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
        $manager->persist($this->getStudent());

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

    private function getStudent()
    {
        $user = new User('student');
        $user
            ->setFirstname('john')
            ->setLastname('doe')
            ->setRoles(['ROLE_STUDENT'])
            ->setGender('male')
        ;
        $user->setPassword($this->encoder->encodePassword($user, 'antic'));

        return $user;
    }
}