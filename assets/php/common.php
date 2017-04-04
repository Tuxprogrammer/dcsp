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

