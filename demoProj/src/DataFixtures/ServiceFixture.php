<?php

namespace App\DataFixtures;

use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ServiceFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $service = new Service();
        $service->setName('Washing');
        $service->setCost(14);
        $service->setDuration(2);
        $service->setIsActive(false);

        $manager->persist($service);

        $manager->flush();
    }
}
