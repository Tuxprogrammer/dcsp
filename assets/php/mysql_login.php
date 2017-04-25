<?php

$hostname = 'pluto.cse.msstate.edu';
$db = 'dcsph';
$username = 'dcsph';
$password = 'joeisthebest123';

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