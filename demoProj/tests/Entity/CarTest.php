<?php

namespace App\Tests\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Car;
use App\Entity\Order;
use App\Entity\Profile;
use App\Entity\Repair;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class CarTest extends TestCase
{
    public function testNumberPlate() {
        $car = new Car();
        $car->setNumberPlate('WANT3D');
        $this->assertEquals('WANT3D', $car->getNumberPlate());
    }

    public function testModel() {
        $car = new Car();
        $car->setModel('AUDI');
        $this->assertEquals('AUDI', $car->getModel());
    }

    public function testEngineType() {
        $car = new Car();
        $car->setEngineType('TDI');
        $this->assertEquals('TDI', $car->getEngineType());
    }

    public function testTransmission() {
        $car = new Car();
        $car->setTransmission('Manual');
        $this->assertEquals('Manual', $car->getTransmission());
    }

    public function testPower() {
        $car = new Car();
        $car->setPower(100);
        $this->assertEquals('100', $car->getPower());
    }

    public function testProfile() {
        $car = new Car();
        $profile = new Profile();
        $car->setProfile($profile);
        $this->assertEquals($profile, $car->getProfile());
    }

    public function testOrders() {
        $car = new Car();
        $order = new Order();
        $car->addOrder($order);
        $this->assertEquals($order, $car->getOrders()[0]);
    }
}