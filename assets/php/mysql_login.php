<?php

$hostname = 'localhost';
$db = 'sc2257';
$username = 'sc2257';
$password = 'dcsp_chat_password00';

$conn = null;

try {
    $conn = new mysqli($hostname, $username, $password, $db);
    unset($hostname, $username, $password, $db);

    if ($conn->connect_error) {
        throw new Exception('The server is currently experiencing difficulties connecting to the database. ' . $conn->connect_error);
    }
} catch (Exception $e) {
    echo "<h1>$e</h1>";
    die();
}