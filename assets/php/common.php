<?php
/**
 *
 * User: tuxpr
 * Date: 4/4/2017
 * Time: 4:16 PM
 */
require_once __DIR__.'/mysql_login.php';

function lookupUserName($userId) {
    global $conn;
    $query = "SELECT userId, userName FROM users WHERE userId=".$userId." LIMIT 1";

    $result = $conn->query($query);
    if (!$result) {
        throw new Exception('Error checking for existing username. ' . $conn->error);
    }

    $result->data_seek(0);
    $row = $result->fetch_array(MYSQLI_ASSOC);

    return isset($row['userName']) ? $row['userName'] : "";
}

function lookupUserId($userName) {
    global $conn;
    $query = "SELECT userId, userName FROM users WHERE userName=\"".$userName."\" LIMIT 1";

    $result = $conn->query($query);
    if (!$result) {
        throw new Exception('Error checking for existing username. ' . $conn->error);
    }

    $result->data_seek(0);
    $row = $result->fetch_array(MYSQLI_ASSOC);

    return isset($row['userId']) ? $row['userId'] : "";
}

function mysql_entities_fix_string($connection, $string)
{
    return htmlentities(mysql_fix_string($connection, $string));
}

function mysql_fix_string($connection, $string)
{
    global $conn;
    if (get_magic_quotes_gpc()) $string = stripslashes($string);
    return $conn->real_escape_string($string);
}
