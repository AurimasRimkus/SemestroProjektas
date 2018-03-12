<?php
include "Models/Student.php";

use Models\Student;
session_start();

if(isset($_SESSION['username'])){
    header("Location: index.php");
    die();
}

//Instead of using a database, we're creating a demo account.
//In a real-life application a database would be used which would select
//user from database with username that was inputted, and get password hash of that user.
$existingStudent = new Student();
$existingStudent->username = 'Dievas';
$existingStudent->setPassword('Aurimas');

if($_POST['username'] === $existingStudent->username &&
    $existingStudent->checkPassword($_POST['pass'])) {
    $_SESSION['username'] = $_POST['username'];
    header("Location: index.php");
}elseif(!($_POST['username'] === $existingStudent->username)){
    ?>
    There is no such username!
    <br /><br />
    <form action="index.php">
        <button>Try again</button>
    </form>
<?php
}else{
?>
    Password is incorrect!
    <br /><br />
    <form action="index.php">
        <button>Try again</button>
    </form>
    <?php
}
?>
