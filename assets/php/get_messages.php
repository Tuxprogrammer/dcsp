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
    header("Location: groups.php");
    die;
}

if(isset($_POST['action']) && $_POST['action'] == "reset") {
    $_SESSION["groupId"] = "";
    header("Location: groups.php");
    die();
}

try {
    unset($hostname, $username, $password, $db);

    if ($conn->connect_error)
        throw new Exception("The server is currently experiencing difficulties connecting to the database. " . $conn->connect_error);

    echo "<h1>Logged in to group " . $_SESSION["groupId"] . "</h1>";

    echo "<h1>Messages:</h1>";

    echo '<form action="messages.php" method="post">
            <input type="hidden" name="action" value="reset">
            <button type="submit" class="btn-link" name="">Back</button>
          </form>';

    $groupId = $_SESSION["groupId"];

    $query = "SELECT * from messages_$groupId";

    $result = $conn->query($query);
    if (!$result)
        die($conn->error);

    $rows = $result->num_rows;

    echo "<table><th>User</th><th>Message</th><th>up/down</th>";
    for ($j = 0; $j < $rows; ++$j) {
        $result->data_seek($j);
        $row = $result->fetch_array(MYSQLI_ASSOC);
        echo '<tr>';
        echo '<td>' . $row['fromUser'] . '</td>';
        echo '<td>' . $row['message'] . '</td>';
        echo '<td>' . $row['upvotes'] . '/' . $row['downvotes'] . '</td>';
        echo '</tr>';
    }
    echo "</table>";

} catch (Exception $e) {
    echo "<h1>$e</h1>";
}

