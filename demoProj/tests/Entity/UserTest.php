<?php

namespace App\Tests\Entity;

use App\Entity\Order;
use App\Entity\Profile;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class UserTest extends TestCase
{
    public function testUserEntity(){
        $profile = new Profile();
        $order = new Order();

        $user = new User();
        $user->setId("99");
        $user->setUsername("Name");
        $user->setEmail("mail@mail.com");
        $user->setPassword("pass");
        $user->setNewPassword("pass2");
        $user->setPasswordResetToken("token");
        $user->setRole(3);
        $user->setRegistrationDate(new \DateTime('2000-10-10'));
        $user->setLastLoginTime(new \DateTime('2011-10-10'));
        $user->setIsActive(true);
        $user->setIsDeleted(true);
        $user->setRegistrationToken("tokenreg");
        $user->setProfile($profile);
        $user->setOrders($order);

        $this->assertEquals("99", $user->getId());
        $this->assertEquals("Name", $user->getUsername());
        $this->assertEquals("mail@mail.com", $user->getEmail());
        $this->assertEquals("pass", $user->getPassword());
        $this->assertEquals("pass2", $user->getNewPassword());
        $this->assertEquals("token", $user->getPasswordResetToken());
        $this->assertEquals(3, $user->getRole());
        $this->assertEquals(new \DateTime('2000-10-10'), $user->getRegistrationDate());
        $this->assertEquals(new \DateTime('2011-10-10'), $user->getLastLoginTime());
        $this->assertEquals(true, $user->getIsActive());
        $this->assertEquals(true, $user->getIsDeleted());
        $this->assertEquals("tokenreg", $user->getRegistrationToken());
        $this->assertEquals($profile, $user->getProfile());
        $this->assertEquals($order, $user->getOrders());
        $this->assertEquals(null, $user->getSalt());
        $this->assertEquals(array ('ROLE_USER'), $user->getRoles());
        $this->assertEquals(null,  $user->eraseCredentials());
    }
}