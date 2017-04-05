<?php
/**
 * This file checks if a user is properly logged in to the system and returns if not
 *
 *
 * User: spencer
 * Date: 4/4/2017
 * Time: 4:02 PM
 */

session_start();

require_once 'mysql_login.php';

echo $_SESSION['userName'] . "<br>" .
$_SESSION['realName'] . "<br>" .
$_SESSION['userId'] . "<br>" .
$_SESSION['admin'] . "<br>" .
$_SESSION['banned'] . "<br>" .
$_SESSION['avatarImage'] . "<br>" .
$_SESSION['phoneNumber'] . "<br>" .
$_SESSION['emailAddress'] . "<br>".
$_SESSION['groupId'] . "<br>";

if(!(isset($_SESSION['userId']) && (isset($_SESSION['userName'])))) {
    echo "Not Logged In, please login in <a href=\"login.php\">here</a>.";
    die();
}

