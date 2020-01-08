<?php

namespace App\DataFixtures;

use App\Entity\School;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class SchoolFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->getSchools() as $school) {
            $manager->persist($school);
        }

        $manager->flush();
    }

    private function getSchools()
    {
        $schools = [];
        $faker = Faker\Factory::create();
        for ($i = 0; $i < 1; $i++) {
            $school = new School($faker->word);
            $this->addReference("school_$i", $school);
            $schools[] = $school;
        }

        return $schools;
    }
}
