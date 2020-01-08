<?php


namespace App\DataFixtures;

use App\Entity\ClassRoom;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ClassRoomFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->getClassRooms() as $classRoom) {
            $manager->persist($classRoom);
        }

        $manager->flush();
    }

    private function getClassRooms()
    {
        $classNames = ['cm1', 'cm2'];
        $classRooms = [];
        $schools = $this->getSchools();

        for ($i = 0; $i < 2; $i++) {
            $classRoom = new ClassRoom();
            $classRoom
                ->setName($classNames[$i])
                ->setSchool($this->getReference($schools[0]))
            ;
            $this->addReference("classroom_$i", $classRoom);
            $classRooms[] = $classRoom;
        }

        return $classRooms;
    }

    private function getSchools()
    {
        $schools = [];
        for ($i = 0; $i < 1; $i++) {
            $schools[] = "school_$i";
        }

        return $schools;
    }

    public function getDependencies()
    {
        return array(
            SchoolFixtures::class,
        );
    }
}
