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
<?php

require_once __DIR__ . '/mysql_login.php';

//Checks to see if session is already initiated (user is already logged in)
if (isset($_SESSION['userName'])) {
    if ($_SESSION['type'] == 'user') {
        header("Location: user_profile.php");
    } else {
        header("Location: admin_profile.php");
    }
} else {

    $conn = new mysqli($hostname, $username, $password, $db);
    unset($hostname, $username, $password, $db);

    if ($conn->connect_error)
        throw new Exception("The server is currently experiencing difficulties connecting to the database. " . $conn->connect_error);
//Checks if username and password have been set
    if (isset($_POST['userName']) &&
        isset($_POST['password'])
    ) {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $username = $_POST['username'];
            $password = $_POST['password'];
        }

        $un_temp = mysql_entities_fix_string($conn, $_POST['username']);
        $pw_temp = mysql_entities_fix_string($conn, $_POST['password']);
        $query = "SELECT * FROM users WHERE userName='$un_temp'";
        $result = $conn->query($query);
        if (!$result) die($conn->error);
        elseif ($result->num_rows) {
            $row = $result->fetch_array(MYSQLI_NUM);
            $result->close();


            $token = hash('sha512', "$pw_temp");

            if ($token == $row[6]) {
                session_start();

                $_SESSION['userName'] = $un_temp;
                $_SESSION['realName'] = $row["realName"];
                $_SESSION['userId'] = $row["userId"];
                $_SESSION['admin'] = $row["admin"];
                $_SESSION['banned'] = $row["banned"];
                $_SESSION['avatarImage'] = $row["avatarImage"];
                $_SESSION['phoneNumber'] = $row["phoneNumber"];
                $_SESSION['emailAddress'] = $row["emailAddress"];

                echo "Hi $row[3], you are now logged in as '$row[2]'";
                setcookie("userId", $row["userId"], time() + 24 * 60 * 60);
            } else {
                echo "<p>Invalid username/password comnination</p>";
            }
        }
    }
    $conn->close();
}

function mysql_entities_fix_string($connection, $string)
{
    return htmlentities(mysql_fix_string($connection, $string));
}

function mysql_fix_string($connection, $string)
{
    if (get_magic_quotes_gpc()) $string = stripslashes($string);
    return $connection->real_escape_string($string);
}

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
</html>
