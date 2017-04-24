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
    <div class="col-md-4">
      <div id="userinfo">
        <img src="<?php if (!$avatarImage) {
          echo "media/default_avatar.png";
        }
        else {
          echo $avatarImage;
        } ?>" alt="default_avatar.png">
        <form action="user_profile.php" method="post"><input type="hidden" name="param" value="avatarImage">
          <button type="submit">Edit Avatar</button>
        </form>

        <div id="profile-form">
          <form action="" method="post">
            <div class="form-group row">
              <label for="username-input">Username</label>
              <input class="form-control" type="text" name="username" value="<?php echo $userName; ?>" >
            </div>
            <div class="form-group row">
              <label for="realname-input">Real Name</label>
              <input class="form-control" type="text" name="realname" value="<?php echo $realName; ?>">
            </div>
            <div class="form-group row">
              <label for="email-input">Email Address</label>
              <input class="form-control" type="email" name="email" value="<?php echo $emailAddress; ?>">
            </div>
            <div class="form-group row">
              <label for="phone-number-input">Phone Number</label>
              <input class="form-control" type="tel" name="phone-number" value="<?php echo $phoneNumber; ?>">
            </div>
            <div class="form-group row justify-content-left">
              <button type="submit" class="btn btn-primary">Submit</button>
              <button id="reset-btn" type="reset" class="btn btn-danger">Reset</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-3">
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
</div>
