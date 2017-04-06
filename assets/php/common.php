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

function send_message($userId, $groupId, $message) {
    require_once __DIR__.'/mysql_login.php';
    require_once __DIR__.'/check_login.php';
    global $conn;

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

    // Insert New Group into groups table
    $query = "INSERT INTO messages_".$groupId." (fromUser, mTimeStamp, upvotes, downvotes, message)
              VALUES (\"$userId\", NOW(), \"0\", \"0\", \"$message\")";

    echo $query;
    $result = $conn->query($query);
    if (!$result)
        throw new Exception("Error adding new message to database. " . ($conn->error));

}