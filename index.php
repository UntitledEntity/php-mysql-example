<?php
session_start(); 

require 'includes/mysql_connect.php';
include 'includes/functions.php';



if (isset($_POST['login']))
{
    die(json_encode(login($_POST['user'], $_POST['pass'])));
}

if (isset($_POST['register']))
{
    die(register($_POST['user'], $_POST['pass']));
}


?>

<!DOCTYPE html>
<html>
    
<head>
	<title>LOGIN</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <form method="POST">
        <label>User Name</label>
     	<br><input type="text" name="user" placeholder="User Name"></input><br>

     	<label>Password</label>
     	<br><input type="password" name="pass" placeholder="Password"></input><br>

     	<br><button name="login">Login</button><br>
     	<br><button name="register">Register</button><br>
    </form>
</body>

</html>
