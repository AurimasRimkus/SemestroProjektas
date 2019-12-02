<?php

namespace App\Tests\Controller;

use App\Controller\RegisteredCarsController;
use App\Controller\RemindPasswordController;
use App\Entity\Order;
use App\Entity\Repair;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class RemindPasswordControllerTest extends TestCase
{
    public function testSetAllRepairsAsDone(){
        $registeredCarsController = new RemindPasswordController();
        $token = $registeredCarsController->getPasswordResetToken();
        $this->assertNotEmpty($token);
    }

    public function testSetNewPasswordAfterReminding() {
        $registeredCarsController = new RemindPasswordController();
        $password = "qwerty";
        $user = new User();
        $user->setPasswordResetToken("empty");
        $registeredCarsController->setNewPasswordAfterReminding($user, $password);

        $this->assertEquals($user->getPassword(), true);
        $this->assertNull($user->getPasswordResetToken());
    }

}