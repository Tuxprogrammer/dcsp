<?php
/**
 *
 * User: spencer
 * Date: 4/4/2017
 * Time: 3:57 PM
 */

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'remove') {
    require_once __DIR__.'/mysql_login.php';
    require_once __DIR__.'/check_login.php';
    require_once __DIR__.'/common.php';

    // TODO: Remove a user from a group by username

    if(!isset($_POST['userName'])) {
        echo '<h1>Invalid Username</h1>';
    }

    if(!isset($_SESSION['groupId'])) {
        echo '<h1>Please select a <a href="groups.php">Group</a>.';
    }

    // Get userId

    $userId = lookupUserId($_POST['userName']);

    if (empty($userId)) {
        echo '<h1>Username not found.</h1>';
        die();
    }

    // Check if user is in the group
    $query = 'SELECT userId, groupId FROM member_of WHERE userId="'.$userId.'" AND groupId="'.$_SESSION['groupId'].'" LIMIT 1';

    $result = $conn->query($query);
    if (!$result) {
        throw new Exception('Error checking for existing username. ' . $conn->error);
    }

    $result->data_seek(0);
    $row = $result->fetch_array(MYSQLI_ASSOC);
    if(empty($row['userId'])) {
        echo '<h1>User is not a member of this group.</h1>';
        die();
    }

    // Add new user to the group
    $query = 'DELETE FROM member_of WHERE userId = "'.$userId.'" AND groupId = "'.$_SESSION['groupId'].'"';

    $result = $conn->query($query);
    if (!$result) {
        throw new Exception('Error removing user. ' . $conn->error);
    }

    //Put initial message in the group
    $fromUserId = $_SESSION['userId'];
    $fromUserName = $_SESSION['userName'];
    $message = $fromUserName . ' removed ' . $_POST['userName'] . ' from the group.';

    $query = 'INSERT INTO messages_' . $_SESSION['groupId'] . "(fromUser,
              mTimeStamp, upvotes, downvotes, message)
              VALUES (\"$fromUserId\", NOW(), 0, 0, \"$message\")";

    echo $query;
    $result = $conn->query($query);
    if (!$result) {
        throw new Exception('Error inserting removal message. ' . $conn->error);
    }

    header('Location: messages.php');
}
echo '<form action="messages.php" method="post">
            Remove a user from this group. <br />
            Username: <input type="text" name="userName" id="userName">
            <input type="hidden" name="action" value="remove">
            <button type="submit" class="btn-link" name="">Remove</button>
          </form>';