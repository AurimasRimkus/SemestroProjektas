<?php
include "Models/Student.php";

use Models\Student;

$password = $_POST['pass'];

$newStudent = new Student();
$newStudent->username = $_POST['login'];
$newStudent->password = $password;

$existingStudent = new Student();
$existingStudent->username = "Dievas";
$existingStudent->password = "Aurimas";

if($newStudent->username === $existingStudent->username &&
    $newStudent->password === $existingStudent->password){
    echo "Sveikas prisijunges, " . $newStudent->username;
}else{
    echo "Blogi prisijungimo duomenys.";
}
