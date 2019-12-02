<?php

namespace App\Tests\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Car;
use App\Entity\Order;
use App\Entity\Profile;
use App\Entity\Repair;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class ProfileTest extends TestCase
{
//    private $em;
//    private $doctrine;

    public function testId(){
        $profile = new Profile();
        $profile->setId("1");
        $this->assertEquals("1", $profile->getId());
    }
	
	public function testName(){
        $profile = new Profile();
        $profile->setName("asd");
        $this->assertEquals("asd", $profile->getName());
    }
	
	public function testSecondName(){
        $profile = new Profile();
        $profile->setSecondName("Paulius");
        $this->assertEquals("Paulius", $profile->getSecondName());
    }
	
	public function testEmail(){
        $profile = new Profile();
        $profile->setEmail("me@aurimasrimkus.eu");
        $this->assertEquals("me@aurimasrimkus.eu", $profile->getEmail());
    }
	
	public function testPhoneNumber(){
        $profile = new Profile();
        $profile->setPhoneNumber("861212124");
        $this->assertEquals("861212124", $profile->getPhoneNumber());
    }
	
	public function testBirthDate(){
        $profile = new Profile();
        $profile->setBirthDate(new \DateTime('2011-10-10'));
        $this->assertEquals(new \DateTime('2011-10-10'), $profile->getBirthDate());
    }
	
	public function testCars(){
        $profile = new Profile();
		$car = new Car();
		$car2 = new Car();
        $profile->addCar($car);
		$profile->addCar($car2);
		$list = new ArrayCollection();
		$list->add($car);
		$list->add($car2);
        $this->assertEquals($profile->getCars(), $list);
    }
	
	public function testOrders(){
        $profile = new Profile();
		$order = new Order();
		$order2 = new Order();
        $profile->addOrder($order);
		$profile->addOrder($order2);
		$list = new ArrayCollection();
		$list->add($order);
		$list->add($order2);
        $this->assertEquals($profile->getOrders(), $list);
    }
	
	public function testUser() {
		$profile = new Profile();
		$user = new User();
		$profile->setUser($user);
        $this->assertEquals($user, $profile->getUser());
	}
}