<?php

namespace App\Tests\Entity;

use App\Entity\ForgotPassword;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class UserTest extends TestCase
{
	public function testEmail() {
		$forgotPassword = new ForgotPassword();
		$forgotPassword->setEmail("me@aurimasrimkus.eu");
        $this->assertEquals("me@aurimasrimkus.eu", $forgotPassword->getEmail());
	}
}