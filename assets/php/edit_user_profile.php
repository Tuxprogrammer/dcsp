<?php
/**
 * Created by PhpStorm.
 * User: B1nary
 * Date: 4/22/2017
 * Time: 8:13 PM
 */

require_once __DIR__ . '/mysql_login.php';
require_once __DIR__ . '/check_login.php';
require_once __DIR__ . '/common.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['param'])) {

    if (!isset($_POST['value'])) {
        $inputType = '';
        switch ($_POST['param']) {
            case 'userName':
                $inputType = 'text';
                break;

            case 'realName':
                $inputType = 'text';
                break;

            case 'password':
                $inputType = 'password';
                break;

            case 'emailAddress':
                $inputType = 'text';
                break;

            case 'phoneNumber':
                $inputType = 'text';
                break;

            default:
                header('Location: user_profile.php');
                die;
        }

        echo '<form method="POST" action="user_profile.php"><input type="' . $inputType . '" name="value"><input type="hidden" name="param" value="' . $_POST['param'] . '"><button type="submit">Submit</button></form>';
    } else {
        $errors = validateField($_POST['value'], $_POST['param']);


        if ($errors['error']) {
            echo $_POST['value'];
            echo $errors['errorText'];
            die();
        }


        $query = 'UPDATE users SET ' . $_POST['param'] . '="' . $_POST['value'] . '" WHERE userId=' . $_SESSION['userId'];

        $result = $conn->query($query);
        if (!$result) {
            echo $query;
            throw new Exception('Error updaing database field. ' . $conn->error);
        }

        $_SESSION[$_POST['param']] = $_POST['value'];


    }
    die;
}