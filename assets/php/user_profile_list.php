<?php
/**
 * Created by PhpStorm.
 * User: Rob Harris
 * Date: 4/11/2017
 * Time: 5:31 PM
 */


require_once __DIR__.'/mysql_login.php';
require_once __DIR__.'/check_login.php';

$query = "SELECT userId FROM member_of WHERE groupId = \"".$_SESSION['groupId']."\"";

$result = $conn->query($query);
if (!$result) {
    throw new Exception('Error collecting user profiles from database.' . $conn->error);
}

//$result->data_seek(0);
//$row = $result->fetch_array(MYSQLI_ASSOC);

//$words = print_r($row,true);

//echo "<ul>".$words."</ul>";


$rows = $result->num_rows;
$row = 0;
$thisuser = "a";
echo "<ul>";
for ($j=0; $j<$rows; ++$j)
    {
        $result->data_seek($j);
        $row = $result->fetch_row();
        $thisuser = print_r($row,false);
        echo "<li>".$thisuser."</li>";

    }
echo "</ul>";
?>