<?php
/**
 * This file checks if a user is properly logged in to the system and returns if not
 *
 *
 * User: spencer
 * Date: 4/4/2017
 * Time: 4:02 PM
 */

require_once 'mysql_login.php';

if(!(isset($_COOKIE['userId']) && (isset($_COOKIE['userName'])))) {
    echo "Not Logged In, please login in <a href=\"login.php\">here</a>.";
    die();
}
