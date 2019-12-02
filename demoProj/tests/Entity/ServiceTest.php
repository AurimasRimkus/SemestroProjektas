<?php

namespace App\Tests\Entity;

use App\Entity\Service;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class ServiceTest extends TestCase
{
    public function testId(){
        $service = new Service();
        $service->setId(10);
        $this->assertEquals(10, $service->getId());
    }

    public function testName(){
        $service = new Service();
        $service->setName("Valymas");
        $this->assertEquals("Valymas", $service->getName());
    }

    public function testCost() {
        $service = new Service();
        $service->setCost(10);
        $this->assertEquals(10, $service->getCost());
    }

    public function testDuration() {
        $service = new Service();
        $service->setDuration(10);
        $this->assertEquals(10, $service->getDuration());
    }

    public function testIsActive() {
        $service = new Service();
        $service->setIsActive(true);
        $this->assertEquals(true, $service->getIsActive());
        $service->setIsActive(false);
        $this->assertEquals(false, $service->getIsActive());
    }
}