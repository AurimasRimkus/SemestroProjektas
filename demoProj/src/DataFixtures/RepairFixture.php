<?php

namespace App\DataFixtures;

use App\Entity\Repair;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

// bin/console doctrine:fixtures:load --append
class RepairFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
//        $service = new Repair();
//        $service->setName('Washing');
//        $service->setCost(14);
//        $service->setDuration(2);
//        $service->setIsActive(false);
//
//        $manager->persist($service);
//
//        $manager->flush();
    }
}
