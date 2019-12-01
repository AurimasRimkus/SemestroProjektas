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
//    private $em;
//    private $doctrine;

    public function testOrderEntity(){
        $user = new User();
        $car = new Car();
        $profile = new Profile();
        $repair = new Repair();

        $order = new Order();

        $order->addRepairs($repair);
        $order->setProfile($profile);
        $order->setDuration(10);
        $order->setCar($car);
        $order->setComment('comment');
        $order->setFinishDate(new \DateTime('2011-10-10'));
        $order->setIsDone(true);
        $order->setStartDate(new \DateTime('2000-10-10'));

        $this->assertContains($repair , $order->getRepairs());
        $this->assertEquals($profile, $order->getProfile());
        $this->assertEquals(10, $order->getDuration());
        $this->assertEquals($car, $order->getCar());
        $this->assertEquals('comment', $order->getComment());
        $this->assertEquals(new \DateTime('2011-10-10'), $order->getFinishDate());
        $this->assertEquals(true, $order->getIsDone());
        $this->assertEquals(new \DateTime('2000-10-10'), $order->getStartDate());

        $order->setUser($user);
        $this->assertEquals($user, $order->getUser());
    }

    public function testId(){
        $order = new Order();
        $order->setId("1");
        $this->assertEquals("1", $order->getId());
    }



}