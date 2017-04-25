<?php
/**
 *
 * User: tuxpr
 * Date: 4/24/2017
 * Time: 8:34 PM
 */

require_once __DIR__.'/mysql_login.php';
require_once __DIR__.'/common.php';

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['userName'], $_POST['phoneNumber'], $_POST['password'])) {
    global $conn;

    if (!lookupUserId($_POST['userName'])) {
        echo "Can't find user by that name.";
        header("Location: login.php");
        die;
    }

    $query = 'SELECT phoneNumber FROM users WHERE userId=' . lookupUserId($_POST['userName']) . ' LIMIT 1';

    $result = $conn->query($query);
    if (!$result) {
        throw new Exception('Error checking for existing username. ' . $conn->error);
    }

    $result->data_seek(0);
    $row = $result->fetch_array(MYSQLI_ASSOC);

    if ($row['phoneNumber'] !== $_POST['phoneNumber']) {
        echo "Invalid user data.";
        header("Location: login.php");
        die;
    }

    $passwordHash = isset($_POST['password']) ? hash('sha512', $_POST['password'], true) : '';

    $passwordHex = bin2hex($passwordHash);

    // query to add new user
    $query = 'UPDATE users SET passwordHash="'.$passwordHex.'" WHERE userId='.lookupUserId($_POST['userName']);

    $result = $conn->query($query);
    if (!$result) {
        throw new Exception('Error adding new user to database. ' . $conn->error);
    }

    header("Location: login.php");
    die;
}