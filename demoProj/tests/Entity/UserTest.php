<?php

namespace App\Tests\Entity;

use App\Entity\Order;
use App\Entity\Profile;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class UserTest extends TestCase
{
	public function testId () {
		$user = new User();
		$user->setId("99");
		$this->assertEquals("99", $user->getId());
	}
	
	public function testUsername () {
		$user = new User();
		$user->setUsername("Name");
		$this->assertEquals("Name", $user->getUsername());
	}
	
	public function testEmail () {
		$user = new User();
		$user->setEmail("mail@mail.com");
		$this->assertEquals("mail@mail.com", $user->getEmail());
	}
	
	public function testPassword () {
		$user = new User();
		$user->setPassword("pass");
		$this->assertEquals("pass", $user->getPassword());
	}
	
	public function testNewPassword () {
		$user = new User();
		$user->setNewPassword("pass2");
		$this->assertEquals("pass2", $user->getNewPassword());
	}
	
	public function testPasswordResetToken () {
		$user = new User();
		$user->setPasswordResetToken("token");
		$this->assertEquals("token", $user->getPasswordResetToken());
	}
	
	public function testRole () {
		$user = new User();
		$user->setRole(3);
		$this->assertEquals(3, $user->getRole());
	}
	
	public function testRegistrationDate () {
		$user = new User();
		$user->setRegistrationDate(new \DateTime('2000-10-10'));
		$this->assertEquals(new \DateTime('2000-10-10'), $user->getRegistrationDate());
	}
	
	public function testLastLoginTime () {
		$user = new User();
		$user->setLastLoginTime(new \DateTime('2011-10-10'));
		$this->assertEquals(new \DateTime('2011-10-10'), $user->getLastLoginTime());
	}
	
	public function testIsActive () {
		$user = new User();
		$user->setIsActive(true);
		$this->assertEquals(true, $user->getIsActive());
	}
	
	public function testIsDeleted () {
		$user = new User();
		$user->setIsDeleted(true);
		$this->assertEquals(true, $user->getIsDeleted());
	}
	
	public function testRegistrationToken () {
		$user = new User();
		$user->setRegistrationToken("tokenreg");
		$this->assertEquals("tokenreg", $user->getRegistrationToken());
	}
	
	public function testProfile() {
		$user = new User();
		$profile = new Profile();
		$user->setProfile($profile);
		$this->assertEquals($profile, $user->getProfile());
	}
	
	public function testOrder() {
		$user = new User();
		$order = new Order();
		$user->setOrders($order);
		$this->assertEquals($order, $user->getOrders());
	}
	
	public function testSalt() {
		$user = new User();
		$this->assertEquals(null, $user->getSalt());
	}
	
	public function testRoles() {
		$user = new User();
		$this->assertEquals(array ('ROLE_USER'), $user->getRoles());
	}
	
	public function testCredentials() {
		$user = new User();
		$this->assertEquals(null,  $user->eraseCredentials());
	}
}