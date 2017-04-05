<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Log in to cHat</title>
    <style>
        input {
            margin-bottom: 0.5em;
        }
    </style>
</head>
<body>
<?php

require_once 'assets/php/login.php';
?>
<h1>Welcome to <span style="font-style:italic; font-weight:bold; color: maroon">
            cHat</span>!</h1>

<p style="color: red">
    <!--Placeholder for error messages-->
</p>

<form method="post" action="login.php">
    <label>Username: </label>
    <input type="text" name="userName" value=""> <br>
    <label>Password: </label>
    <input type="password" name="password" value=""> <br>
    <input type="submit" value="Log in">
</form>

<p style="font-style:italic">
    BROOO<br><br>
    create account link
</p>
</body>
</html>