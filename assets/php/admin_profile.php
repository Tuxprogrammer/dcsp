<?php
require_once __DIR__ . '/mysql_login.php';
require_once __DIR__ . '/check_login.php';
require_once __DIR__ . '/common.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['action'])) {}
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
        throw new RuntimeException("Error checking for existing username. " . ($conn->error));
    $result2->data_seek(0);
    $row2 = $result2->fetch_array(MYSQLI_ASSOC);

    echo '<td>' . $row2['message'] . '</td>';

    echo '<td>' . "<a href=\"admin_profile.php?g=" . $row['groupId'] . "\">Delete</a>" . '</td>';
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
    echo '<td>' . "<a href=\"admin_profile.php?g=" . $row['userId'] . "\">Delete</a>" . '</td>';
    echo '</tr>';
}
echo "</table>";