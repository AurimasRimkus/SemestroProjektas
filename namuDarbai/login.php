<?php
include "Models/Student.php";

use Models\Student;

//Instead of using a database, we're creating a demo account.
//In a real-life application a database would be used which would select
//user from database with username that was inputted, and get password hash of that user.
$existingStudent = new Student();
$existingStudent->username = 'Dievas';
$existingStudent->setPassword('Aurimas');

if($_POST['username'] === $existingStudent->username &&
    $existingStudent->checkPassword($_POST['pass'])){
    echo "Sveikas prisijunges, " . $existingStudent->username;
}else{
    echo "Bad credentials (TODO: check if there is no such username,
     or if the password was wrong <br /> ";
}
