<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
    
        for ($i = 0; $i < 28; $i++) {
            $user = new User();
    
            $user->setEmail($faker->email);
            $user->setPassword(password_hash($faker->password, PASSWORD_DEFAULT));
            $user->setFirstName($faker->firstName);
            $user->setLastName($faker->lastName);
    
            $manager->persist($user);
        }
    
        $manager->flush();
    }
}
