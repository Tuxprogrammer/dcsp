<?php
/**
 * Created by PhpStorm.
 * User: spencer
 * Date: 3/7/17
 * Time: 5:20 PM
 */
require_once 'mysql_login.php';

try {
    $conn = new mysqli($hostname, $username, $password, $db);
    unset($hostname, $username, $password, $db);

    if ($conn->connect_error)
        throw new Exception("The server is currently experiencing difficulties connecting to the database. ".$conn->connect_error);

    /*
     * userId BIGINT UNSIGNED UNIQUE NOT NULL,
     * uTimeStamp TIMESTAMP,
     * userName VARCHAR(32),
     * realName VARCHAR(128),
     * emailAddress VARCHAR(128),
     * phoneNumber VARCHAR(15),
     * passwordHash VARCHAR(128),
     * avatarImage VARCHAR(255),
     * banned TINYINT(1),
     * admin TINYINT(1),
    */

    $userName           = isset($_POST["username"]) ? (string)$_POST["username"] : "";
    // $uTimeStamp         = ""; //This doesn't matter
    $passwordHash       = isset($_POST["password"]) ? hash("sha521", $_POST["password"], true )   : "";
    $realName           = isset($_POST["realName"]) ? (string)$_POST["realName"] : "";
    $emailAddress       = isset($_POST["emailAddress"]) ? (string)$_POST["emailAddress"] : "";
    $phoneNumber        = isset($_POST["phoneNumber"]) ? (string)$_POST["phoneNumber"] : "";
    $avatarImage        = isset($_POST["avatarImage"]) ? (string)$_POST["avatarImage"] : "";

    // DATA VALIDATION
    // check for blank parameters
    if ($userName == "" || $realName == "" || $emailAddress == "") {
        throw new Exception("Error: Invalid field.");
    }

    //TODO: Add check for username not containing weird symbols, string escaping, also check email and phone number ...
    // for correct format.

    $query = "SELECT DISTINCT userName FROM users";

    //Check if username exists already
    $result = $conn->query($query);
    if (!$result)
        throw new Exception("Error checking for existing username. ".($conn->error));

    $rows = $result->num_rows;

    for ($j = 0; $j < $rows; ++$j) {
        $result->data_seek($j);
        $row = $result->fetch_array(MYSQLI_ASSOC);

        if($userName == $row['userName']) {
            throw new Exception("Error, username matches a user already on file.");
        }
    }


    // ADDING NEW USER

    // query to add new user
    $query = "INSERT INTO users (uTimeStamp, userName, realName, emailAddress, phoneNumber, passwordHash,
                avatarImage, banned, admin)
              VALUES (NOW(), \"$userName\", \"$realName\", \"$emailAddress\", \"$phoneNumber\", \"$passwordHash\", \"$avatarImage\",
              0, 0)";
    echo $query;
    $result = $conn->query($query);
    if (!$result)
        throw new Exception("Error adding new user to database. ".($conn->error));

    // Done
    echo "<h1>User added successfully. Thanks!";

} catch (Exception $e) {
    echo "<h1>$e</h1>";
}