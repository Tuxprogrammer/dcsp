<?php
/**
 * Created by PhpStorm.
 * User: spencer
 * Date: 3/7/17
 * Time: 6:25 PM
 */

//TODO: Script to append messages to the group's message table.

// Should have some sort of spam checking such that if the last x messages have been sent by the same user in a short
// timespan, an alert is appended to the admin table.

if(!empty($_POST)) {
    require_once __DIR__.'/mysql_login.php';
    require_once __DIR__.'/check_login.php';

    $conn = new mysqli($hostname, $username, $password, $db);
    unset($hostname, $username, $password, $db);

    if ($conn->connect_error)
        throw new Exception("The server is currently experiencing difficulties connecting to the database. " . $conn->connect_error);


    /*
     * messageId BIGINT UNSIGNED UNIQUE NOT NULL,
     * fromUser BIGINT UNSIGNED,
     * mTimeStamp TIMESTAMP,
     * upvotes INT,
     * downvotes INT,
     * message VARCHAR(255)
     *
     */

    $message = isset($_POST["message"]) ? (string)$_POST["message"] : "";

    $fromUser = $_COOKIE["userId"];

    // Insert New Group into groups table
    $query = "INSERT INTO groups (fromUser, mTimeStamp, upvotes, downvotes, message)
              VALUES (\"$fromUser\", NOW(), \"0\", \"0\", \"$message\")";

    echo $query;
    $result = $conn->query($query);
    if (!$result)
        throw new Exception("Error adding new message to database. " . ($conn->error));

}