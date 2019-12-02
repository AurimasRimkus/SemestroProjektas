<?php

namespace App\Tests\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Order;
use App\Entity\Repair;
use PHPUnit\Framework\TestCase;

class RepairTest extends TestCase
{
    public function testName(){
        $repair = new Repair();
        $repair->setName("Varyklio valymas");
        $this->assertEquals("Varyklio valymas", $repair->getName());
    }

    public function testCost() {
        $repair = new Repair();
        $repair->setCost(10);
        $this->assertEquals(10, $repair->getCost());
    }

    public function testDuration() {
        $repair = new Repair();
        $repair->setDuration(10);
        $this->assertEquals(10, $repair->getDuration());
    }

    public function testIsDone() {
        $repair = new Repair();
        $repair->setIsDone(true);
        $this->assertEquals(true, $repair->getIsDone());
        $repair->setIsDone(false);
        $this->assertEquals(false, $repair->getIsDone());
    }

    public function testOrder() {
        $repair = new Repair();
        $order = new Order();
        $repair->setCost($order);
        $this->assertEquals($order, $repair->getOrder());
    }
}