<html>
<head>
    <?php
    session_start();
    if(isset($_SESSION['username'])) {
        echo "<title>Prisijungta</title>";
    }else {
        echo "<title>Login form</title>";
    }
    ?>
</head>
<body>
<?php
if(isset($_SESSION['username'])){
    echo "Jus esate prisijunges, " . $_SESSION['username'];
    ?>
    <br><br>
    <form action="logout.php">
        <button>Logout</button>
    </form>
    <?php
}else {
    ?>
    <strong><h1>Login</h1></strong> <br \>
    <form action="login.php" method="POST">
        Username: <br \>
        <input type="text" name="username"> <br \>
        Password: <br \>
        <input type="password" name="pass"> <br \>
        <input type="submit" value="Login">

    </form>
    <?php
    }
?>
</body>
</html>