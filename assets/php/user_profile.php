<?php
/**
 *
 * User: tuxpr
 * Date: 4/11/2017
 * Time: 6:22 PM
 */

require_once __DIR__ . '/mysql_login.php';
require_once __DIR__ . '/check_login.php';

$userId = $_SESSION['userId'];
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['u'])) {
    $userId = $_GET['u'];
}

$query = 'SELECT * FROM users WHERE userId=' . $userId . ' LIMIT 1';

$result = $conn->query($query);
if (!$result) {
    throw new Exception('Error checking for existing user information. ' . $conn->error);
}

$result->data_seek(0);
$row = $result->fetch_array(MYSQLI_ASSOC);

$userName = $row['userName'];
$realName = $row['realName'];
$emailAddress = $row['emailAddress'];
$avatarImage = $row['avatarImage'];
$phoneNumber = $row['phoneNumber'];

$groupIds = array();


$query = 'SELECT groupId FROM member_of WHERE userId=' . $userId;

$result = $conn->query($query);
if (!$result) {
    throw new Exception('Error checking for existing user information. ' . $conn->error);
}
$rows = $result->num_rows;
$row = $result->fetch_array(MYSQLI_ASSOC);

for ($j = 0; $j < $rows; ++$j) {
    $result->data_seek($j);
    $row = $result->fetch_array(MYSQLI_ASSOC);

    $groupIds[] = $row['groupId'];
}

$groupNames = array();
foreach ($groupIds as $groupId) {
    $query = 'SELECT groupName, gType FROM groups WHERE groupId=' . $groupId . ' LIMIT 1';

    $result = $conn->query($query);
    if (!$result) {
        throw new Exception('Error checking for existing user information. ' . $conn->error);
    }

    $result->data_seek(0);
    $row = $result->fetch_array(MYSQLI_ASSOC);

    if ($row['gType'] === '1') {
        $groupNames [] = $row['groupName'];
    }
}

?>
<a href="groups.php">Back</a><br/>
<img src="<?php echo $avatarImage; ?>" alt="Image not found">
<form method="POST" action="user_profile.php">
    <button class="btn-link">Edit Avatar</button>
    <input type="hidden" name="param" value="avatarImage"/>
</form>
<table>
    <tr>
        <th>Username:</th>
        <td><?php echo $userName; ?></td>
        <td>
            <form method="POST" action="user_profile.php">
                <button class="btn-link">Edit</button>
                <input type="hidden" name="param" value="userName"/></form>
        </td>
    </tr>
    <tr>
        <th>Name:</th>
        <td><?php echo $realName; ?></td>
        <td>
            <form method="POST" action="user_profile.php">
                <button class="btn-link">Edit</button>
                <input type="hidden" name="param" value="realName"/></form>
        </td>
    </tr>
    <tr>
        <th>Email:</th>
        <td><?php echo $emailAddress; ?></td>
        <td>
            <form method="POST" action="user_profile.php">
                <button class="btn-link">Edit</button>
                <input type="hidden" name="param" value="emailAddress"/></form>
        </td>
    </tr>
    <tr>
        <th>Phone Number:</th>
        <td><?php echo $phoneNumber; ?></td>
        <td>
            <form method="POST" action="user_profile.php">
                <button class="btn-link">Edit</button>
                <input type="hidden" name="param" value="phoneNumber"/></form>
        </td>
    </tr>
</table>

<h2>My cHats:</h2>
<?php
echo '<ul>';
foreach ($groupNames as $name) {
    echo '<li>' . $name . '</li>';
}
echo '</ul>';
?>
