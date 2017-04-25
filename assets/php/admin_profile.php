<?php
require_once __DIR__ . '/mysql_login.php';
require_once __DIR__ . '/check_login.php';
require_once __DIR__ . '/common.php';

if (!checkAdmin($_SESSION['userId'])) {
    header("Location: user_profile.php");
    die();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['action']) && $_GET['action']==="del") {

        if (isset($_GET['g']) && !lookupGroupName($_GET['g'])) {
            echo "Invalid group.";
            die;
        } else {

            $query = 'DROP TABLE messages_' . $_GET['g'];
            $result = $conn->query($query);
            if (!$result) {
                throw new Exception('Error deleting group from database. ' . $conn->error);
            }
            $query = 'DELETE FROM groups WHERE groupId=' . $_GET['g'];
            $result = $conn->query($query);
            if (!$result) {
                throw new Exception('Error deleting group from database. ' . $conn->error);
            }
            $query = 'DELETE FROM member_of WHERE groupId=' . $_GET['g'];
            $result = $conn->query($query);
            if (!$result) {
                throw new Exception('Error deleting group from database. ' . $conn->error);
            }
        }

    } else if (isset($_GET['action']) && $_GET['action']==="ban") {
        if(isset($_GET['u']) && !lookupUserName($_GET['u'])) {
            echo "Invalid user.";
            die;
        } else {
            $query = 'UPDATE users SET banned=1 WHERE userId=' . $_GET['u'];
            $result = $conn->query($query);
            if (!$result) {
                throw new Exception('Error banning user. ' . $conn->error);
            }
        }
    } else if (isset($_GET['action']) && $_GET['action']==="unban") {
        if (isset($_GET['u']) && !lookupUserName($_GET['u'])) {
            echo "Invalid user.";
            die;
        } else {
            $query = 'UPDATE users SET banned=0 WHERE userId=' . $_GET['u'];
            $result = $conn->query($query);
            if (!$result) {
                throw new Exception('Error unbanning user. ' . $conn->error);
            }
        }
    }
}

$query = 'SELECT * FROM groups';

$result = $conn->query($query);
if (!$result)
    die($conn->error);

$rows = $result->num_rows;
echo "<h2>Groups:</h2>";
echo "<table><tr><th>Group Name</th><th>Group Description</th><th>Latest Message</th><th>Action</th></tr>";
for ($j = 0; $j < $rows; ++$j) {
    $result->data_seek($j);
    $row = $result->fetch_array(MYSQLI_ASSOC);
    echo '<tr>';
    echo '<td>' . $row['groupName'] . '</td>';
    echo '<td>' . $row['groupDesc'] . '</td>';

    $query2 = "SELECT message FROM messages_" . $row["groupId"] . " LIMIT 1";
    $result2 = $conn->query($query2);
    if (!$result2)
        throw new Exception("Error checking for existing username. " . ($conn->error));
    $result2->data_seek(0);
    $row2 = $result2->fetch_array(MYSQLI_ASSOC);

    echo '<td>' . $row2['message'] . '</td>';

    echo '<td>' . "<a href=\"admin_profile.php?action=del&g=" . $row['groupId'] . "\">Delete</a>" . '</td>';
    echo '</tr>';
}
echo "</table>";

$query = 'SELECT * FROM users';

$result = $conn->query($query);
if (!$result)
    die($conn->error);

$rows = $result->num_rows;
echo "<h2>Users:</h2>";
echo "<table><tr><th>User Name</th><th>User Real Name</th><th>Login</th></tr>";
for ($j = 0; $j < $rows; ++$j) {
    $result->data_seek($j);
    $row = $result->fetch_array(MYSQLI_ASSOC);
    echo '<tr>';
    echo '<td>' . $row['userName'] . '</td>';
    echo '<td>' . $row['realName'] . '</td>';
    echo '<td>' . "<a href=\"admin_profile.php?action=ban&u=" . $row['userId'] . "\">Ban</a>" . '</td><td><a href=\"admin_profile.php?action=unban?u=' . $row['userId'] . '>Unban</a></td>';
    echo '</tr>';
}
echo "</table>";