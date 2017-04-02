<?php
/**
 * Created by PhpStorm.
 * User: spencer
 * Date: 3/7/17
 * Time: 9:37 PM
 */

require_once __DIR__.'assets/php/mysql_login.php';
try {
    $conn = new mysqli($hostname, $username, $password, $db);
    unset($hostname, $username, $password, $db);

    if ($conn->connect_error) {
        throw new Exception('The server is currently experiencing difficulties connecting to the database. ' . $conn->connect_error);
    }


    //TODO: REMOVE THIS HACK OF A "LOGIN SYSTEM".
    $query = 'SELECT userId FROM users LIMIT 1';

    $result = $conn->query($query);
    if (!$result) {
        throw new Exception('Error checking for existing username. ' . $conn->error);
    }

    $rows = $result->num_rows;

    $result->data_seek(0);
    $row = $result->fetch_array(MYSQLI_ASSOC);


    setcookie('userId', $row['userId'], time() + strtotime('+1 day'));

    echo '<h1>Logged in as ' .$_COOKIE['userId']. '</h1>';

} catch (Exception $e) {
    echo "<h1>$e</h1>";
}