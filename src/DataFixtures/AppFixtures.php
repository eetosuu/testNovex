<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('ru_RU');

        for ($i = 0; $i < 30; $i++) {
            $user = new User();
            $user->setEmail($faker->email);
            $user->setBirthday($faker->dateTime(new \DateTime('1999-12-12')));
            $user->setPhone('+7' . $faker->numerify('##########'));
            $user->setSex($faker->randomElement(['male', 'female']));
            $user->setName($faker->name);
            
            $manager->persist($user);
        }

        $manager->flush();
    }
}
