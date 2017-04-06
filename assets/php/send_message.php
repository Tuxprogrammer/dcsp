<?php
/**
 * Created by PhpStorm.
 * User: spencer
 * Date: 3/7/17
 * Time: 6:25 PM
 */

//TODO: Script to append messages to the group's message table.

// Should have some sort of spam checking such that if the last x messages have been sent by the same user in a short
// timespan, an alert is appended to the admin table.

require_once __DIR__.'/mysql_login.php';
require_once __DIR__.'/check_login.php';
require_once __DIR__.'/common.php';

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === "send") {
    if(isset($_POST['userId']) && isset($_POST['groupId']) && isset($_POST['message'])) {
        $fromUserId = $_POST['userId'];
        $groupId = $_POST['groupId'];
        $message = $_POST['message'];

        send_message($fromUserId, $groupId, $message);

    }
    header('Location: messages.php');
}
echo "<form action=\"messages.php\" method=\"post\">
            <input type=\"hidden\" name=\"action\" value=\"send\">
            <input type=\"hidden\" name=\"userId\" value=\"".$_SESSION['userId']."\">
            <input type=\"hidden\" name=\"groupId\" value=\"".$_SESSION['groupId']."\">
            <input type=\"text\" name=\"message\" required>
            <button type=\"submit\" class=\"btn-link\" name=\"\">Send</button>
          </form>";