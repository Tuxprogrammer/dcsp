<?php

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

  if (uidInGroup($_SESSION['userId'], $groupId)) {
    $groupNames[$groupId] = $row['groupName'];
  }
}

?>
<div class="bg-pageheader">
  <div class="container">
    <h1>Welcome, <?php echo $realName; ?></h1>
    <h3>this is your cHat dashboard</h3>
  </div>
</div>

<div class="container">
  <div class="row" id="dashboard">
    <div class="col-md-9">
      <div id="userinfo">

        <img src="<?php echo $avatarImage; ?>" alt="Image not found">
          <form action="user_profile.php" method="post"><input type="hidden" name="param" value="avatarImage"><button type="submit">Edit Avatar</button></form>
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

        <h2>Your cHats:</h2>
        <?php
        echo '<ul>';
        foreach ($groupNames as $id => $name) {
          echo '<li><a href="./groups.php?g=' . $id . '">' . $name . '</a></li>';
        }
        echo '</ul>';
        ?>
      </div>
    </div>
    <div class="col-md-3">
      <div class="btn-group-vertical">
        <a class="btn btn-primary" href="./groups.php" role="button">View Groups</a>
        <a class="btn btn-primary" href="./create_group.php" role="button">Create Group</a>
      </div>
    </div>
  </div>
</div>
