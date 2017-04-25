<?php
require_once __DIR__ . '/mysql_login.php';
require_once __DIR__ . '/check_login.php';
require_once __DIR__ . '/common.php';

if (!checkAdmin($_SESSION['userId'])) {
  header("Location: user_profile.php");
  die();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  if (isset($_GET['action']) && $_GET['action'] === "del") {

    if (isset($_GET['g']) && !lookupGroupName($_GET['g'])) {
      echo "Invalid group.";
      die;
    }
    else {

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

  }
  else if (isset($_GET['action']) && $_GET['action'] === "ban") {
    if (isset($_GET['u']) && !lookupUserName($_GET['u'])) {
      echo "Invalid user.";
      die;
    }
    else {
      $query = 'UPDATE users SET banned=1 WHERE userId=' . $_GET['u'];
      $result = $conn->query($query);
      if (!$result) {
        throw new Exception('Error banning user. ' . $conn->error);
      }
    }
  }
  else if (isset($_GET['action']) && $_GET['action'] === "unban") {
    if (isset($_GET['u']) && !lookupUserName($_GET['u'])) {
      echo "Invalid user.";
      die;
    }
    else {
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
if (!$result) {
  die($conn->error);
}

$rows = $result->num_rows;
echo "<section id='groups'>\n<h2>Delete Groups:</h2>";
echo '<div class="row row-header">
          <div class="col-3">Group Name</div>
          <div class="col-4">Group Description</div>
          <div class="col-5">Latest Message</div>
        </div>';
for ($j = 0; $j < $rows; ++$j) {
  $result->data_seek($j);
  $row = $result->fetch_array(MYSQLI_ASSOC);
  echo '<a href=\"admin_profile.php?action=del&g="' . $row['groupId'] . '"><div class="row group">';
  echo '<div class="col-3"><span>' . $row['groupName'] . '</span></div>';
  echo '<div class="col-4"><span>' . $row['groupDesc'] . '</span></div>';

  $query2 = 'SELECT message FROM messages_' . $row['groupId'] . ' LIMIT 1';
  $result2 = $conn->query($query2);
  if (!$result2) {
    throw new RuntimeException('Error checking for existing username. ' . $conn->error);
  }
  $result2->data_seek(0);
  $row2 = $result2->fetch_array(MYSQLI_ASSOC);

  echo '<div class="col-5"><span>' . $row2['message'] . '</span></div></div></a>';
}

$query = 'SELECT * FROM users';

$result = $conn->query($query);
if (!$result) {
  die($conn->error);
}

$rows = $result->num_rows;
echo "<section id='public'>\n<h2>Ban or Unban Users:</h2>";
echo '<div class="row row-header">
          <div class="col-12 col-md-5">User Name</div>
          <div class="col-12 col-md-5">User Real Name</div>
          <div class="col-12 col-md-2">Action</div>
        </div>';
for ($j = 0; $j < $rows; ++$j) {
  $result->data_seek($j);
  $row = $result->fetch_array(MYSQLI_ASSOC);
  echo '<div class="row group">';
  echo '<div class="col-12 col-md-5"><span>' . $row['userName'] . '</span></div>';
  echo '<div class="col-12 col-md-5"><span>' . $row['realName'] . '</span></div>';
  if (!lookupBanned($row['userId'])) {
    echo '<div class="col-2 col-md-2">' . "<a class='btn btn-danger' href=\"admin_profile.php?action=ban&u=" . $row['userId'] . "\">Ban</a>" . '</div>';
  }
  else {
    echo '<div class="col-2 col-md-2"><a class="btn btn-warning" href="admin_profile.php?action=unban&u=' . $row['userId'] . '">Unban</a></div>';
  }
  echo '</div>';
}
