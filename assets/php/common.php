<?php
/**
 *
 * User: tuxpr
 * Date: 4/4/2017
 * Time: 4:16 PM
 */
require_once __DIR__ . '/mysql_login.php';

function lookupUserName($userId)
{
    global $conn;
    $query = 'SELECT userId, userName FROM users WHERE userId=' . $userId . ' LIMIT 1';

    $result = $conn->query($query);
    if (!$result) {
        throw new RuntimeException('Error checking for existing username. ' . $conn->error);
    }

    $result->data_seek(0);
    $row = $result->fetch_array(MYSQLI_ASSOC);

    return isset($row['userName']) ? $row['userName'] : '';
}

function lookupUserId($userName)
{
    global $conn;
    $query = 'SELECT userId, userName FROM users WHERE userName="' . $userName . '" LIMIT 1';

    $result = $conn->query($query);
    if (!$result) {
        throw new RuntimeException('Error checking for existing username. ' . $conn->error);
    }

    $result->data_seek(0);
    $row = $result->fetch_array(MYSQLI_ASSOC);

    return isset($row['userId']) ? $row['userId'] : '';
}

function lookupGroupName($groupId)
{
    global $conn;
    $query = 'SELECT groupName FROM groups WHERE groupId="' . $groupId . '" LIMIT 1';

    $result = $conn->query($query);
    if (!$result) {
        throw new RuntimeException('Error checking for existing username. ' . $conn->error);
    }

    $result->data_seek(0);
    $row = $result->fetch_array(MYSQLI_ASSOC);

    return isset($row['groupName']) ? $row['groupName'] : '';
}

function mysql_entities_fix_string($connection, $string)
{
    return htmlentities(mysql_fix_string($string));
}

function mysql_fix_string($string)
{
    global $conn;
    if (get_magic_quotes_gpc()) {$string = stripslashes($string);}
    return $conn->real_escape_string($string);
}

function send_message($userId, $groupId, $message)
{
    require_once __DIR__ . '/mysql_login.php';
    require_once __DIR__ . '/check_login.php';
    global $conn;

    if ($conn->connect_error) {
        throw new RuntimeException('The server is currently experiencing difficulties connecting to the database. ' . $conn->connect_error);
    }

    /*
     * messageId BIGINT UNSIGNED UNIQUE NOT NULL,
     * fromUser BIGINT UNSIGNED,
     * mTimeStamp TIMESTAMP,
     * upvotes INT,
     * downvotes INT,
     * message VARCHAR(255)
     *
     */

    $message = addslashes($message);

    // Insert New Group into groups table
    $query = 'INSERT INTO messages_' . $groupId . " (fromUser, mTimeStamp, upvotes, downvotes, message)
              VALUES (\"$userId\", NOW(), \"0\", \"0\", \"$message\")";

    echo $query;
    $result = $conn->query($query);
    if (!$result) {
        throw new RuntimeException('Error adding new message to database. ' . $conn->error);
    }

}

function checkBlank($field, $type)
{
    $errorText = '';
    $error = false;

    //name is blank
    if (empty($field)) {
        $errorText = $type . ' cannot be blank.';
        $error = true;
    }
    return array('error' => $error, 'errorText' => $errorText);
}

function checkInvalidChars($field, $type)
{
    $errorText = '';
    $error = false;
    switch ($type) {
        case ('userName'):
            if (!preg_match('/^[0-9a-zA-Z]*$/', $field)) {
                $errorText = 'Only letters and/or numbers are allowed';
                echo $type . '<br>';
                $error = true;
            }
            break;
        case ('realName'):
            if (!preg_match('/^[a-zA-Z ]*$/', $field)) {
                $errorText = 'Only letters and/or white space are allowed';
                echo $type . '<br>';
                $error = true;
            }
            break;
        case ('emailAddress'):
        echo 'YOU MADE IT!!' . '<br>';
            if (!filter_var($field, FILTER_VALIDATE_EMAIL)) {
                $errorText = 'Invalid email format';
                $error = true;
            }
            break;
        case ('phoneNumber'):
            $field = preg_replace('/\D+/', '', $field);
            if(strlen($field) > 12) {
                $errorText = 'Invalid phone number';
                $error = true;
            }

            break;
        default:
            break;
    }
    return array('error' => $error, 'errorText' => $errorText);
}

function validateField($field, $type = '')
{
    global $conn;
    $field = $conn->real_escape_string($field);
    $errorText = '';
    $error = false;

    switch ($type) {
        case 'userName' || 'realName' || 'emailAddress' || 'phoneNumber':
            //name is blank
            $errors = checkBlank($field, $type);
            if ($errors['error']) {return $errors;}

            //Name contains invalid characters
            $errors = checkInvalidChars($field, $type);
            if ($errors['error']) {return $errors;}

            break;

        case 'password':
            //passsword is blank
            $errors = checkBlank($field, $type);
            if ($errors['error']) {return $errors;}

            break;

        default:

            break;
    }

    return array('error' => $error, 'errorText' => $errorText);
}

function uidInGroup($userId, $groupId) {
    global $conn;
    $query = 'SELECT gType FROM groups WHERE groupId="'.$groupId.'" LIMIT 1';
    $result = $conn->query($query);
    $result->data_seek(0);
    $row = $result->fetch_array(MYSQLI_ASSOC);
    if(isset($row['gType']) && $row['gType'] === '1') {return 1;}

    $query = 'SELECT * FROM member_of WHERE userId="' . $userId . '" AND groupId='.$groupId.' LIMIT 1';

    $result = $conn->query($query);
    if (!$result) {
        throw new RuntimeException('Error checking for existing username. ' . $conn->error);
    }

    $result->data_seek(0);
    $row = $result->fetch_array(MYSQLI_ASSOC);

    return isset($row['userId']) ? $row['userId'] : '';
}

function groupPrivate($groupId) {
    global $conn;
    $query = 'SELECT gType FROM groups WHERE groupId="'.$groupId.'" LIMIT 1';

    $result = $conn->query($query);
    if (!$result) {
        throw new RuntimeException('Error checking for group type. ' . $conn->error);
    }

    $result->data_seek(0);
    $row = $result->fetch_array(MYSQLI_ASSOC);

    return ($row['gType'] == "1") ? false : true;
}