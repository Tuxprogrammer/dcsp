<?php
session_start();

require_once __DIR__ . '/mysql_login.php';
require_once __DIR__ . '/common.php';

//Checks to see if session is already initiated (user is already logged in)
if (isset($_SESSION['userName'])) {
    header('Location: groups.php');
} else {

    unset($hostname, $username, $password, $db);

    if ($conn->connect_error) {
        throw new RuntimeException('The server is currently experiencing difficulties connecting to the database. ' . $conn->connect_error);
    }
//Checks if username and password have been set
    if ($_SERVER['REQUEST_METHOD'] === 'POST' &&
        isset($_POST['username'], $_POST['password'])
    ) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $un_temp = mysql_entities_fix_string($username);
        $pw_temp = mysql_entities_fix_string($password);

        foreach (array('userName' => $username, 'password' => $password) as $type => $field) {
            $errors = validateField($field, $type);
            if ($errors['error']) {
                echo $errors['errorText'];
                die();
            }
        }

        $query = "SELECT * FROM users WHERE userName='$un_temp'";
        $result = $conn->query($query);
        if (!$result) {
            die($conn->error);
        }

        $result = $conn->query($query);
        if (!$result) {
            throw new RuntimeException('Error authenticating user information. ' . $conn->error);
        }

        $result->data_seek(0);
        $row = $result->fetch_array(MYSQLI_ASSOC);

        $token = hash('sha512', "$pw_temp");

        if ($token === $row['passwordHash']) {

            $_SESSION['userName'] = $un_temp;
            $_SESSION['realName'] = $row['realName'];
            $_SESSION['userId'] = $row['userId'];
            $_SESSION['admin'] = $row['admin'];
            $_SESSION['banned'] = $row['banned'];
            $_SESSION['avatarImage'] = $row['avatarImage'];
            $_SESSION['phoneNumber'] = $row['phoneNumber'];
            $_SESSION['emailAddress'] = $row['emailAddress'];

            //echo "Hi ".$row['realName'].", you are now logged in as ".$row['username'];

            header('Location: groups.php');
        } else {
            echo '<p>Invalid username/password combination</p>';
        }

    }
    $conn->close();
}
