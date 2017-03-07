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
    if ($conn->connect_error)
        throw new Exception($conn->connect_error);

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

    $userName           = isset($_POST["username"]) ? $_POST["username"] : "";
    // $uTimeStamp         = ""; //This doesn't matter
    $passwordHash       = isset($_POST["password"]) ? hash("sha521", $_POST["password"], true )   : "";
    $realName           = isset($_POST["realName"]) ? $_POST["realName"] : "";
    $emailAddress       = isset($_POST["emailAddress"]) ? $_POST["emailAddress"] : "";
    $phoneNumber        = isset($_POST["phoneNumber"]) ? $_POST["phoneNumber"] : "";
    $avatarImage        = isset($_POST["avatarImage"]) ? $_POST["avatarImage"] : "";


} catch (Exception $e) {

    echo '<h1>The server is currently experiencing difficulties connecting to the database.</h1>';
}