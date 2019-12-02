<?php
/**
 * Created by PhpStorm.
 * User: Marius
 * Date: 02/12/2019
 * Time: 02:47
 */

namespace App\Tests\Controller;


use App\Controller\ServiceRegistrationController;
use App\Entity\Car;
use App\Entity\Order;
use App\Entity\Profile;
use PHPUnit\Framework\TestCase;

class ServiceRegistrationControllerTest extends TestCase
{
    public function testAddCarToOrder(){
        $controller = new ServiceRegistrationController();
        $car = new Car();
        $profile = new Profile();
        $order = new Order();

        $controller->addCarToOrder($car, $profile, $order);

        $testCar = new Car();
        $testCar->setProfile($profile);

        $testOrder = new Order();
        $testOrder->setCar($testCar);

        $this->assertEquals($testOrder, $order);
    }

    public function testUpdateCarInOrder(){
        $controller = new ServiceRegistrationController();
        $car = new Car();
        $order = new Order();

        $controller->updateCarInOrder($order, $car);

        $testCar = new Car();

        $testOrder = new Order();
        $testOrder->setCar($testCar);

        $this->assertEquals($testOrder, $order);
    }

    public function testRemoveTakeTimes(){
        $controller = new ServiceRegistrationController();
        $order = new Order();
        $order->setStartDate(new \DateTime('2011-10-10 10:10:00'));
        $order->setFinishDate(new \DateTime('2011-10-10 15:10:00'));

        $time = array (8, 9, 10, 11, 12, 13, 14, 15, 16);

        $result = $controller->removeTakeTimes($time, $order);

        $timeResult = array (8, 9, 17);

        $this->assertEquals($timeResult, $result);
    }

    public function testFindAvailableHours(){
        $controller = new ServiceRegistrationController();
        $order = new Order();
        $order->setStartDate(new \DateTime('2011-10-10 10:10:00'));
        $order->setFinishDate(new \DateTime('2011-10-10 15:10:00'));

        $time = array (8, 9, 11, 12, 14, 15, 16);

        $hours = $controller->findAvailableHours(3, array_values($time));

        $timeResult = "14:00 - 17:00";

        $this->assertContains($timeResult, $hours);
    }
}