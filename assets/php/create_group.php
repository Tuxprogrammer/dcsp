<?php
/**
 * Created by PhpStorm.
 * User: spencer
 * Date: 3/7/17
 * Time: 5:20 PM
 */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__.'/mysql_login.php';
    require_once __DIR__.'/check_login.php';
    require_once __DIR__.'/common.php';

    try {
//        $conn = new mysqli($hostname, $username, $password, $db);
//        unset($hostname, $username, $password, $db);
//
//        if ($conn->connect_error) {
//            throw new Exception('The server is currently experiencing difficulties connecting to the database. ' . $conn->connect_error);
//        }


        if (!isset($_SESSION['userId'])) {
            throw new Exception('Not Logged In, please login in <a href="login.php">here</a>.');
        }

        /*
         * groupId BIGINT UNSIGNED UNIQUE NOT NULL,
         * groupName VARCHAR(128),
         * gTimeStamp TIMESTAMP,
         * type INT,
         * creator BIGINT UNSIGNED,
         */

        $groupName = isset($_POST['groupName']) ? (string)$_POST['groupName'] : "";

        $gType = isset($_POST['gType']) ? $_POST['gType'] : "";
        $creator = $_SESSION['userId'];

        // Insert New Group into groups table
        $query = "INSERT INTO groups (groupName, groupDesc, gTimeStamp, gType, creator)
              VALUES (\"$groupName\", \"\", NOW(), \"$gType\", \"$creator\")";

        echo $query;
        $result = $conn->query($query);
        if (!$result) {
            throw new Exception('Error adding new group to database. ' . $conn->error);
        }
        $result = $conn->query('SELECT LAST_INSERT_ID()');
        if (!$result) {
            throw new Exception('Error adding new group to database. ' . $conn->error);
        }

        $result->data_seek(0);
        $row = $result->fetch_array(MYSQLI_ASSOC);

        // Get the new Group ID
        $groupId = $row['LAST_INSERT_ID()'];

        // Make a messages Table corresponding to the group
        $query = 'CREATE TABLE messages_' . $groupId . ' ( 
                messageId BIGINT UNSIGNED UNIQUE NOT NULL AUTO_INCREMENT,
                fromUser BIGINT UNSIGNED,
                mTimeStamp TIMESTAMP,
                upvotes INT,
                downvotes INT,
                message TEXT,
              PRIMARY KEY(messageId))';

        echo $query;
        $result = $conn->query($query);
        if (!$result) {
            throw new Exception('Error adding new group to database. ' . $conn->error);
        }

        // Set the current user as a member of the group
        $query = "INSERT INTO member_of (userId, groupId)
              VALUES (\"$creator\", \"$groupId\")";

        echo $query;
        $result = $conn->query($query);
        if (!$result) {
            throw new Exception('Error adding new group to database. ' . $conn->error);
        }


        $fromUserId = $_SESSION['userId'];
        $fromUserName = $_SESSION['userName'];
        $message = $fromUserName . ' created the group ' . $groupName . '.';

        send_message($fromUserId, $groupId, $message);

        // Done
        echo '<h1>Group added successfully. Thanks!';
        header("refresh:3; url=groups.php");
        die();

    } catch (Exception $e) {
        echo "<h1>$e</h1>";
    }


# There should be one of these queries executed when a new group is created, so that the group has a database to
# store its messages and members in. The name should be "message_$groupId"
#CREATE TABLE messages_template(
# messageId BIGINT UNSIGNED UNIQUE NOT NULL,
# from_USER BIGINT UNSIGNED,
# mTimeStamp TIMESTAMP,
# upvotes INT,
# downvotes INT,
# message VARCHAR(255),
# PRIMARY KEY(messageId)
#);
}