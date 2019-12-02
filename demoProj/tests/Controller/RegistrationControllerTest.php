<?php
/**
 * Created by PhpStorm.
 * User: Marius
 * Date: 02/12/2019
 * Time: 01:58
 */

namespace App\Tests\Controller;


use App\Controller\RegistrationController;
use App\Entity\Profile;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class RegistrationControllerTest extends TestCase
{
    public function testUpdateInfoForNewUser(){
        $controller = new RegistrationController();
        $user = new User();
		
		$dateTime = new \DateTime();
		$controller->updateInfoForNewUser($user);

        $this->assertEquals($user->getRegistrationDate(), $dateTime));
        $this->assertEquals($user->getLastLoginTime(), $dateTime);
        $this->assertEquals($user->getIsActive(), false);
        $this->assertEquals($user->getIsDeleted(), false);
        $this->assertEquals($user->getRole(), 1);
    }

    public function testGetRegistrationTokenFromSeed(){
        $controller = new RegistrationController();
		$seed = random_bytes(20);
		$registrationToken = base64_encode($seed);
        $registrationToken = str_replace("/","",$registrationToken); // because / will make errors with routes
		$this->assertEquals($controller->createRegistrationTokenFromSeed($seed), $registrationToken);
    }
	
	public function testMakeUserActivated() {
		$controller = new RegistrationController();
		$user = new User();
		$controller->makeUserActivated($user);
		$this->assertEquals($user->getIsActive(), true);
		$this->assertNull($user->getRegistrationToken());
	}
}