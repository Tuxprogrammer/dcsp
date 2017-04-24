<?php
/**
 * Created by PhpStorm.
 * User: tuxpr
 * Date: 3/21/2017
 * Time: 4:53 PM
 */

require_once __DIR__.'/mysql_login.php';
require_once __DIR__.'/check_login.php';

if(isset($_GET['g']) && !empty($_GET['g']) && is_numeric($_GET['g'])) {
    $_SESSION['groupId'] = $_GET['g'];

    header('Location: messages.php');
}

try {
    if ($conn->connect_error) {
        throw new Exception('The server is currently experiencing difficulties connecting to the database. ' . $conn->connect_error);
    }

    $query = 'SELECT * from groups WHERE gType="2"';

    $result = $conn->query($query);
    if (!$result) {
        die($conn->error);
    }


    echo "<section id='private'>\n<h2>Private:</h2>";
    $rows = $result->num_rows;
    if($rows > 0) {
        echo '<table><tr><th>Group Name</th><th>Group Description</th><th>Latest Message</th><th>Login</th></tr>';
        for ($j = 0; $j < $rows; ++$j) {
            $result->data_seek($j);
            $row = $result->fetch_array(MYSQLI_ASSOC);
            if (uidInGroup($_SESSION['userId'], $row['groupId'])) {
                echo '<tr>';
                echo '<td>' . $row['groupName'] . '</td>';
                echo '<td>' . $row['groupDesc'] . '</td>';

                $query2 = 'SELECT message FROM messages_' . $row['groupId'] . ' LIMIT 1';
                $result2 = $conn->query($query2);
                if (!$result2) {
                    throw new Exception('Error checking for existing username. ' . $conn->error);
                }
                $result2->data_seek(0);
                $row2 = $result2->fetch_array(MYSQLI_ASSOC);

                echo '<td>' . $row2['message'] . '</td>';

                echo '<td>' . '<a href="groups.php?g=' . $row['groupId'] . '">Select</a>' . '</td>';
                echo '</tr>';
            }
        }
        echo "</table>\n";
    } else {
        echo "<p>There's nothing here right now. <a href='create_group.php'>Create a group.</a></p>";
    }
    echo "</section>";

    $query = 'SELECT * from groups WHERE gType="1"';

    $result = $conn->query($query);
    if (!$result) {
        die($conn->error);
    }

    $rows = $result->num_rows;
    echo "<section id='public'>\n<h2>Public:</h2>";
    echo '<table><tr><th>Group Name</th><th>Group Description</th><th>Latest Message</th><th>Login</th></tr>';
    for ($j = 0; $j < $rows; ++$j) {
        $result->data_seek($j);
        $row = $result->fetch_array(MYSQLI_ASSOC);
        echo '<tr>';
        echo '<td>' . $row['groupName'] . '</td>';
        echo '<td>' . $row['groupDesc'] . '</td>';

        $query2 = 'SELECT * FROM messages_'.$row['groupId'].' WHERE messageId=(SELECT MAX(messageId) FROM messages_'.$row['groupId'].')';
        $result2 = $conn->query($query2);
        if (!$result2) {
            throw new Exception('Error checking for existing username. ' . $conn->error);
        }
        $result2->data_seek(0);
        $row2 = $result2->fetch_array(MYSQLI_ASSOC);

        echo '<td>' . $row2['message'] . '</td>';

        echo '<td>' . '<a href="groups.php?g=' .$row['groupId']. '">Select</a>' . '</td>';
        echo '</tr>';
    }
    echo "</table>\n</section>";

} catch (Exception $e) {
    echo "<h1>$e</h1>";
}