<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $product1 = new \App\Entity\Product();
        $product1->setName('Laptop');
        $product1->setPrice('999.99');
        $product1->setDescription('High end gaming laptop');
        $manager->persist($product1);

        $product2 = new \App\Entity\Product();
        $product2->setName('Mouse');
        $product2->setPrice('49.99');
        $product2->setDescription('Wireless optical mouse');
        $manager->persist($product2);

        $product3 = new \App\Entity\Product();
        $product3->setName('Keyboard');
        $product3->setPrice('89.99');
        $product3->setDescription('Mechanical keyboard');
        $manager->persist($product3);

        $manager->flush();
    }
}
