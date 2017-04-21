<?php
/**
 * Created by PhpStorm.
 * User: spencer
 * Date: 3/7/17
 * Time: 5:20 PM
 */


include 'common.php';

if(isset($_SESSION['userName'])){
            header("Location: assets/php/user_profile.php");
            echo "You are already logged in!" . "<br>";
          }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__.'/mysql_login.php';

    try {

        /*
         * userId BIGINT UNSIGNED UNIQUE NOT NULL,
         * uTimeStamp TIMESTAMP,
         * userName VARCHAR(32),
         * realName VARCHAR(128),
         * emailAddress VARCHAR(128),
         * phoneNumber VARCHAR(15),
         * passwordHash VARCHAR(128),
         * avatarImage VARCHAR(255),
         * banned TINYINT(1),
         * admin TINYINT(1),
        */

        $userName = isset($_POST['username']) ? (string)$_POST['username'] : "";
        // $uTimeStamp         = ""; //This doesn't matter
        if(isset($_POST['password'])){
          $errors = checkBlank($_POST['password'],'password');
          if ($errors['error']) {
              echo $errors['errorText'];
              die();
          }
        }
        $passwordHash = isset($_POST['password']) ? hash('sha512', $_POST['password'], true) : "";
        $realName = isset($_POST['realname']) ? (string)$_POST['realname'] : "";
        $emailAddress = isset($_POST['email']) ? (string)$_POST['email'] : "";
        $phoneNumber = isset($_POST['phone-number']) ? (string)$_POST['phone-number'] : "";
        $avatarImage = isset($_POST['avatarImage']) ? (string)$_POST['avatarImage'] : "";

        foreach (array('userName' => $userName,
                     'realName' => $realName,
                     'emailAddress' => $emailAddress,
                     'phoneNumber' => $phoneNumber
                     ) as $type => $field) {
            $errors = validateField($field, $type);
            if ($errors['error']) {
                echo $errors['errorText'];
                die();
            }
        }

        // DATA VALIDATION
        // check for blank parameters
        if ($userName === "" || $realName === "" || $emailAddress === "") {
            throw new Exception('Error: Invalid field.');
        }

        $query = 'SELECT DISTINCT userName FROM users';

        //Check if username exists already
        $result = $conn->query($query);
        if (!$result) {
            throw new Exception('Error checking for existing username. ' . $conn->error);
        }

        $rows = $result->num_rows;

        for ($j = 0; $j < $rows; ++$j) {
            $result->data_seek($j);
            $row = $result->fetch_array(MYSQLI_ASSOC);

            if ($userName === $row['userName']) {
                throw new Exception('Error, username matches a user already on file.');
            }
        }


        // ADDING NEW USER

        $passwordHex = bin2hex($passwordHash);

        // query to add new user
        $query = "INSERT INTO users (uTimeStamp, userName, realName, emailAddress, phoneNumber, passwordHash,
                avatarImage, banned, admin)
              VALUES (NOW(), \"$userName\", \"$realName\", \"$emailAddress\", \"$phoneNumber\", \"$passwordHex\", \"$avatarImage\",
              0, 0)";
        echo $query;

        /*
        $query = "INSERT INTO users (uTimeStamp, userName, realName, emailAddress, phoneNumber, passwordHash,
                avatarImage, banned, admin)
              VALUES (NOW(), \"$userName\", \"$realName\", \"$emailAddress\", \"$phoneNumber\", \"$passwordHash\", \"$avatarImage\",
              0, 0)";
        */

        $result = $conn->query($query);
        if (!$result) {
            throw new Exception('Error adding new user to database. ' . $conn->error);
        }

        // Done
        //echo '<h1>User added successfully. Thanks!';

        // TODO: Implement user profile page, and redirect user to there, as well as log them in
        header("Location: login.php");
    } catch (Exception $e) {
        echo "<h1>$e</h1>";
    }
}
