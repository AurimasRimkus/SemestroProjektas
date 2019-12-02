<?php

namespace App\Tests\Controller;

use App\Controller\RegisteredCarsController;
use App\Entity\Order;
use App\Entity\Repair;
use PHPUnit\Framework\TestCase;

class RegisteredCarsControllerTest extends TestCase
{
    public function testSetAllRepairsAsDone(){
        $registeredCarsController = new RegisteredCarsController();
        $repairs = array(new Repair(), new Repair(), new Repair(), new Repair());
        $size = 0;
        $registeredCarsController->setAllRepairsAsDone($repairs);
        foreach ($repairs as $repair) {
            if ($repair->getIsDone()) {
                $size++;
            }
        }

        $this->assertEquals($size, sizeof($repairs));
    }

    public function testUpdateOrderAsDone() {
        $registeredCarsController = new RegisteredCarsController();
        $order = new Order();
        $registeredCarsController->updateOrderAsDone($order);

        $this->assertEquals($order->getIsDone(), true);
    }

}