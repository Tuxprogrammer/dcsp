<?php require_once 'assets/php/create_user.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
    <h1>Register for cHatter</h1>
    <form method="POST" action="register.php">
        Username: <input name="username" type="text" required> <br>
        Password: <input name="password" type="password" required><br>
        Real Name: <input name="realName" type="text" required><br>
        Email Address: <input name="emailAddress" type="email" required><br>
        Phone Number: <input name="phoneNumber" type="text"><br>
        Avatar Image: <input name="avatarImage" type="url"><br>

        <input type="reset">
        <input type="submit">
    </form>
</body>
</html>