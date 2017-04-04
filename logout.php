<?php
/**
 *
 * User: tuxpr
 * Date: 4/4/2017
 * Time: 5:59 PM
 */

// TODO: Add stuff to do the logout thing here.

session_start();
session_unset();
session_destroy();