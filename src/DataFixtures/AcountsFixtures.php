<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Accounts;

class AcountsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        for($i = 0; $i< 5; $i++)
        {
            $account = new Accounts();
            $account->setEmail("email$i@email.com")
            ->setUsername("name$i")
            ->setPassword(password_hash("password$i",PASSWORD_DEFAULT));

            $manager->persist($account);
        }


        $manager->flush();
    }
}
