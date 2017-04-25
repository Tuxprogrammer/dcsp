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

require_once __DIR__.'/mysql_login.php';
require_once __DIR__.'/common.php';

//echo $_SESSION['userName'] . "<br>" .
//$_SESSION['realName'] . "<br>" .
//$_SESSION['userId'] . "<br>" .
//$_SESSION['admin'] . "<br>" .
//$_SESSION['banned'] . "<br>" .
//$_SESSION['avatarImage'] . "<br>" .
//$_SESSION['phoneNumber'] . "<br>" .
//$_SESSION['emailAddress'] . "<br>".
//$_SESSION['groupId'] . "<br>";

if(!isset($_SESSION['userId'], $_SESSION['userName'])) {
    echo 'Not Logged In, please login in <a href="login.php">here</a>.';
    die();
}

//TODO: ADD STUFF HERE TO CHECK IF THESE ARE THE USERS WE ARE LOOKING FOR
// ALSO, IF A USER IS VIEWING A GROUP, CHECK THAT THEY ARE A MEMBER OF THAT GROUP.

if(isset($_SESSION['groupId']) && !empty($_SESSION['groupId']) && $_SESSION['groupId'] !== '0' &&
    !uidInGroup($_SESSION['userId'], $_SESSION['groupId'])) {
    echo 'You are not a part of this group.';
    $_SESSION['groupId'] = '0';
    die();
}

if(checkBanned($_SESSION['userId'])) {
    require_once __DIR__.'../../logout.php';
}