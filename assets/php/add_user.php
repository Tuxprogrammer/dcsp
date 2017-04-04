<?php
/**
 *
 * User: spencer
 * Date: 4/4/2017
 * Time: 3:57 PM
 */

if (!empty($_POST)) {
    require_once 'mysql_login.php';
    require_once 'check_login.php';

    // TODO: Add a user to a group by username

    if(!isset($_POST['userName'])) {
        echo "<h1>Invalid Username</h1>";
    }

    if(!isset($_SESSION['groupId']));

}