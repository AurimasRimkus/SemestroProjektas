<?php
/**
 * Created by PhpStorm.
 * User: Marius
 * Date: 02/12/2019
 * Time: 01:58
 */

namespace App\Tests\Controller;


use App\Controller\ProfileController;
use App\Entity\Profile;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class ProfileControllerTest extends TestCase
{
    public function testUpdateUserProfile(){
        $controller = new ProfileController();
        $profile = new Profile();
        $newProfile = new Profile();

        $newProfile->setName("vardas");
        $newProfile->setSecondName("pavardas");
        $newProfile->setPhoneNumber("861234567");
        $newProfile->setBirthDate(new \DateTime('2000-01-01'));

        $controller->updateUserProfile($profile, $newProfile);

        $this->assertEquals($newProfile->getName(), $profile->getName());
        $this->assertEquals($newProfile->getSecondName(), $profile->getSecondName());
        $this->assertEquals($newProfile->getPhoneNumber(), $profile->getPhoneNumber());
        $this->assertEquals($newProfile->getBirthDate(), $profile->getBirthDate());
    }

    public function testUpdateUserEmail(){
        $controller = new ProfileController();
        $profile = new Profile();
        $newProfile = new Profile();
        $user = new User();

        $newProfile->setName("vardas");
        $newProfile->setEmail("mail@mail.com");
        $newProfile->setSecondName("pavardas");
        $newProfile->setPhoneNumber("861234567");
        $newProfile->setBirthDate(new \DateTime('2000-01-01'));

        $controller->updateUserEmail($profile, $newProfile, $user);

        $this->assertEquals($newProfile->getEmail(), $profile->getEmail());
        $this->assertEquals($newProfile->getEmail(), $user->getEmail());
        $this->assertEquals(false, $user->getIsActive());
        $this->assertNotEmpty($user->getRegistrationToken());
    }
}