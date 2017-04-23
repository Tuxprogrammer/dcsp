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

        if ($_POST['param'] === "avatarImage") {
            echo '<h1>Edit ' . $_POST['param'] . '</h1><form method="POST" action="user_profile.php" enctype=\'multipart/form-data\'><input type="file" name="upfile" size="10"><input type="hidden" name="param" value="' . $_POST['param'] . '"><input type="hidden" name="value" value="1"><button type="submit">Submit</button></form>';

            die;
        }
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

        echo '<h1>Edit ' . $_POST['param'] . '</h1><form method="POST" action="user_profile.php"><input type="' . $inputType . '" name="value"><input type="hidden" name="param" value="' . $_POST['param'] . '"><button type="submit">Submit</button></form>';
    } else {
        if ($_POST['param'] === "avatarImage") {
            if ($_FILES && $_FILES['upfile']['error'] !== UPLOAD_ERR_NO_FILE) {
                // Adopted from http://php.net/manual/en/features.file-upload.php
                // Check $_FILES['upfile']['error'] value.
                switch ($_FILES['upfile']['error']) {
                    case UPLOAD_ERR_OK:
                        break;
                    case UPLOAD_ERR_INI_SIZE:
                    case UPLOAD_ERR_FORM_SIZE:
                        throw new RuntimeException('Exceeded filesize limit.');
                    default:
                        throw new RuntimeException('Unknown errors.');
                }

                // You should also check filesize here.
                if ($_FILES['upfile']['size'] > 1000000) {
                    throw new RuntimeException('Exceeded filesize limit.');
                }

                // DO NOT TRUST $_FILES['upfile']['mime'] VALUE !!
                // Check MIME Type by yourself.
                $finfo = new finfo(FILEINFO_MIME_TYPE);
                if (false === $ext = array_search(
                        $finfo->file($_FILES['upfile']['tmp_name']),
                        array(
                            'jpg' => 'image/jpeg',
                            'png' => 'image/png',
                            'gif' => 'image/gif',
                        ),
                        true
                    )
                ) {
                    throw new RuntimeException('Invalid file format.');
                }

                $name = sha1_file($_FILES['upfile']['tmp_name']);

                // You should name it uniquely.
                // DO NOT USE $_FILES['upfile']['name'] WITHOUT ANY VALIDATION !!
                // On this example, obtain safe unique name from its binary data.
                if (!move_uploaded_file(
                    $_FILES['upfile']['tmp_name'],
                    sprintf('./media/%s.%s',
                        $name,
                        $ext
                    )
                )
                ) {
                    throw new RuntimeException('Failed to move uploaded file.');
                }

                echo 'File is uploaded successfully.';


                $query = 'SELECT avatarImage FROM users WHERE userId=' . $_SESSION['userId'] . ' LIMIT 1';
                $result = $conn->query($query);
                if (!$result) {
                    throw new Exception('Error deleting old avatar image.' . $conn->error);
                }
                $result->data_seek(0);
                $row = $result->fetch_array(MYSQLI_ASSOC);
                if (isset($row['avatarImage']) && !empty($row['avatarImage']) &&
                    realpath($row['avatarImage']) && is_writable($row['avatarImage'])
                ) {
                    unlink($row['avatarImage']);
                }


                $result = $conn->query($query);
                if (!$result) {
                    throw new Exception('Error editing avatar image url.' . $conn->error);
                }


                $imagePath = sprintf('media/%s.%s', $name, $ext);
                $query = 'UPDATE users SET avatarImage="' . $imagePath . '" WHERE userId=' . $_SESSION['userId'];

                $result = $conn->query($query);
                if (!$result) {
                    throw new Exception('Error editing avatar image url.' . $conn->error);
                }
            }

            die;
        }

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