<?php

namespace App\Tests\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Car;
use App\Entity\Order;
use App\Entity\Profile;
use App\Entity\Repair;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{

    public function testId(){
        $order = new Order();
        $order->setId("1");
        $this->assertEquals("1", $order->getId());
    }
	
	public function testRepairs() {
		$order = new Order();
		$repair = new Repair();
		$order->addRepairs($repair);
		$this->assertContains($repair , $order->getRepairs());
	}
	
	public function testProfile() {
		$order = new Order();
		$profile = new Profile();
		$order->setProfile($profile);
		$this->assertEquals($profile, $order->getProfile());
	}
	
	public function testOrderRepairs() {
		$order = new Order();
		$order->setDuration(10);
		$this->assertEquals(10, $order->getDuration());
	}
	
	public function testOrderDuration() {
		$order = new Order();
		$order->setDuration(10);
		$this->assertEquals(10, $order->getDuration());
	}
	
	public function testOrderCar() {
		$order = new Order();
		$car = new Car();
		$order->setCar($car);
		$this->assertEquals($car, $order->getCar());
	}
	
	public function testOrderComment() {
		$order = new Order();
		$order->setComment('comment');
		$this->assertEquals('comment', $order->getComment());
	}
	
	public function testOrderFinishDate() {
		$order = new Order();
		$order->setFinishDate(new \DateTime('2011-10-10'));
		$this->assertEquals(new \DateTime('2011-10-10'), $order->getFinishDate());
	}
	
	public function testOrderDoneStatus() {
		$order = new Order();
		$order->setIsDone(true);
		$this->assertEquals(true, $order->getIsDone());
		$order->setIsDone(false);
		$this->assertEquals(false, $order->getIsDone());
	}
	
	public function testOrderStartDate() {
		$order = new Order();
		$order->setStartDate(new \DateTime('2000-10-10'));
		$this->assertEquals(new \DateTime('2000-10-10'), $order->getStartDate());
	}
	
	public function testOrderUser() {
		$order = new Order();
		$user = new User();
		$order->setUser($user);
        $this->assertEquals($user, $order->getUser());
	}
}