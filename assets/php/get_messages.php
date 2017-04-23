<?php
/**
 * Created by PhpStorm.
 * User: spencer
 * Date: 3/7/17
 * Time: 6:24 PM
 */

//TODO: File to convert message database into JSON or XML and echo it out.

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

        echo '<h1>Logged in to group ' . $_SESSION['groupId'] . '</h1>';

        echo '<h1>Messages:</h1>';

        echo '<form action="messages.php" method="post">
            <input type="hidden" name="action" value="reset">
            <button type="submit" class="btn-link" name="">Back</button>
          </form>';

        $groupId = $_SESSION['groupId'];

        $query = "SELECT * from messages_$groupId";

        $result = $conn->query($query);
        if (!$result) {
            die($conn->error);
        }

        $rows = $result->num_rows;

        echo '<table><tr><th>User</th><th>Message</th><th>up/down</th></tr>';
        for ($j = 0; $j < $rows; ++$j) {
            $result->data_seek($j);
            $row = $result->fetch_array(MYSQLI_ASSOC);
            echo '<tr>';
            echo '<td>' . $row['fromUser'] . '</td>';
            echo '<td>' . stripslashes($row['message']) . '</td>';
            echo '<td>' .
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
          </form>' . '</td>';
            echo '</tr>';
        }
        echo '</table>';

    } catch (Exception $e) {
        echo "<h1>$e</h1>";
    }
}

