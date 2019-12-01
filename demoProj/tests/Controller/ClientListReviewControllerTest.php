<?php
/**
 * Created by PhpStorm.
 * User: Marius
 * Date: 02/12/2019
 * Time: 00:28
 */

namespace App\Tests\Controller;

use App\Entity\User;
use PHPUnit\Framework\TestCase;
use App\Controller\ClientListReviewController;

class ClientListReviewControllerTest extends TestCase
{
    public function testChangeUserActiveStatus(){
        $controller = new ClientListReviewController();
        $user = new User();
        $user->setIsActive(false);
        $controller->changeUserActiveStatus($user);

        $this->assertEquals($user->getIsActive(), true);
    }

    public function testSetUserDeleted(){
        $controller = new ClientListReviewController();
        $user = new User();
        $controller->setUserDeleted($user);

        $this->assertEquals($user->getIsDeleted(), true);
    }
}