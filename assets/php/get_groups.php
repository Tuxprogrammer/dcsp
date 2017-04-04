<?php
/**
 * Created by PhpStorm.
 * User: tuxpr
 * Date: 3/21/2017
 * Time: 4:53 PM
 */

//TODO: This file should get all of the available groups to a user and print them in a ul list

require_once __DIR__.'/mysql_login.php';
require_once __DIR__.'/check_login.php';

if(isset($_GET['g']) && !empty($_GET['g']) && is_numeric($_GET['g'])) {
    $_SESSION["groupId"] = $_GET["g"];

    header("Location: messages.php");
}

try {
    unset($hostname, $username, $password, $db);

    if ($conn->connect_error)
        throw new Exception("The server is currently experiencing difficulties connecting to the database. " . $conn->connect_error);

    $query = "SELECT * from groups";

    $result = $conn->query($query);
    if (!$result)
        die($conn->error);

    $rows = $result->num_rows;

    echo "<table><th>Group Name</th><th>Group Description</th><th>Latest Message</th><th>Login</th>";
    for ($j = 0; $j < $rows; ++$j) {
        $result->data_seek($j);
        $row = $result->fetch_array(MYSQLI_ASSOC);
        echo '<tr>';
        echo '<td>' . $row['groupName'] . '</td>';
        echo '<td>' . $row['groupDesc'] . '</td>';

        $query2 = "SELECT message FROM messages_".$row["groupId"]." LIMIT 1";
        $result2 = $conn->query($query2);
        if (!$result2)
            throw new Exception("Error checking for existing username. " . ($conn->error));
        $result2->data_seek(0);
        $row2 = $result2->fetch_array(MYSQLI_ASSOC);

        echo '<td>' . $row2['message'] . '</td>';

        echo '<td>' . "<a href=\"groups.php?g=".$row['groupId']."\">Select</a>" . '</td>';
        echo '</tr>';
    }
    echo "</table>";

} catch (Exception $e) {
    echo "<h1>$e</h1>";
}