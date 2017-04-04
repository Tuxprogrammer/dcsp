<!DOCTYPE html>
<html>
<head>
    <title>Inventory</title>
    <style>
        td {
            border: 1px solid black;
            padding: 1em 1em 1em 1em;
        }
    </style>
</head>
<body>
<?php

if(!isset($_COOKIE['groupId'])) {
    header("Location: groups.php");
    die;
}

require_once 'assets/php/get_messages.php';
?>
</body>
</html>