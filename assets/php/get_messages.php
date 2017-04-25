<?php
/**
 * Created by PhpStorm.
 * User: spencer
 * Date: 3/7/17
 * Time: 6:24 PM
 */

require_once __DIR__.'/mysql_login.php';
require_once __DIR__.'/check_login.php';

if(!isset($_SESSION['groupId'])) {
    header('Location: groups.php');
    die;
}

if(isset($_POST['action']) && $_POST['action'] === 'reset') {
    $_SESSION['groupId'] = '';
    header('Location: groups.php');
    die();
}

if(isset($_POST['action']) && $_POST['action'] === 'upvote') {
    if(!isset($_POST['id'])) {
        die();
    }

    //get old vote count
    $query = 'SELECT upvotes FROM messages_' .$_SESSION['groupId']. ' WHERE messageId="' .$_POST['id']. '" LIMIT 1';

    $result = $conn->query($query);
    if (!$result) {
        throw new Exception('Error checking for votes.' . $conn->error);
    }

    $result->data_seek(0);
    $row = $result->fetch_array(MYSQLI_ASSOC);

    //increment & update
    $votes = $row['upvotes'] + 1;

    $query = 'UPDATE messages_' .$_SESSION['groupId']." SET upvotes=\"$votes\" WHERE messageId=\"".$_POST['id']. '"';

    $result = $conn->query($query);
    if (!$result) {
        throw new Exception('Error updating votes.' . $conn->error);
    }

    header('Location: messages.php');
    die();
}

if(isset($_POST['action']) && $_POST['action'] === 'downvote') {
    if(!isset($_POST['id'])) {
        die();
    }

    //get old vote count
    $query = 'SELECT downvotes FROM messages_' .$_SESSION['groupId']. ' WHERE messageId="' .$_POST['id']. '" LIMIT 1';

    $result = $conn->query($query);
    if (!$result) {
        throw new Exception('Error checking for votes.' . $conn->error);
    }

    $result->data_seek(0);
    $row = $result->fetch_array(MYSQLI_ASSOC);

    //decrement & update
    $votes = $row['downvotes'] + 1;

    $query = 'UPDATE messages_' .$_SESSION['groupId']." SET downvotes=\"$votes\" WHERE messageId=\"".$_POST['id']. '"';

    $result = $conn->query($query);
    if (!$result) {
        throw new Exception('Error updating votes.' . $conn->error);
    }

    header('Location: messages.php');
    die();
}

if($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        unset($hostname, $username, $password, $db);

        if ($conn->connect_error) {
            throw new Exception('The server is currently experiencing difficulties connecting to the database. ' . $conn->connect_error);
        }

        $groupId = $_SESSION['groupId'];

        $query = "SELECT * from messages_$groupId ORDER BY messageId DESC";

        $result = $conn->query($query);
        if (!$result) {
            die($conn->error);
        }

        $rows = $result->num_rows;

        echo '<div class="col-md-12" id="messages-table">
                <div class="row">
                  <div class="col-md-2">User</div>
                  <div class="col-md-9">Message</div>
                  <div class="col-md-1"></div>
                </div>';
        for ($j = 0; $j < $rows; ++$j) {
            $result->data_seek($j);
            $row = $result->fetch_array(MYSQLI_ASSOC);
            echo '<div class="row">';
            echo '<div class="col-md-2">' . lookupUserName($row['fromUser']) . '</div>';
            echo '<div class="col-md-9">' . stripslashes($row['message']) . '</div>';
            echo '<div class="col-md-1">' .
                '<form action="messages.php" method="post">
            <input type="hidden" name="action" value="upvote">
            <input type="hidden" name="id" value="' . $row['messageId'] . '">
            <button type="submit" class="btn-link" name="">&#9650;</button>
          </form>' .
                $row['upvotes'] .
                '/' .
                $row['downvotes'] .
                '<form action="messages.php" method="post">
            <input type="hidden" name="action" value="downvote">
            <input type="hidden" name="id" value="' . $row['messageId'] . '">
            <button type="submit" class="btn-link" name="">&#9660;</button>
          </form>' . '</div>';
            echo '</div>';
        }
        echo '</div>';

    } catch (Exception $e) {
        echo "<h1>$e</h1>";
    }
}

