<?php
namespace Models;

class Student
{
    /**
     * @var string
     */
    public $username;

    /**
     * @var string
     */
    private $hashedPassword;

    public function setPassword($newPassword){
        $this->hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
    }

    public function checkPassword($password){
        return password_verify($password, $this->hashedPassword);
    }

}