<?php
/**
 * Created by PhpStorm.
 * User: spencer
 * Date: 3/7/17
 * Time: 6:25 PM
 */

//TODO: Script to append messages to the group's message table.

// Should have some sort of spam checking such that if the last x messages have been sent by the same user in a short
// timespan, an alert is appended to the admin table.

require_once __DIR__ . '/mysql_login.php';
require_once __DIR__ . '/check_login.php';
require_once __DIR__ . '/common.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'send') {

    if (!isset($_POST['userId'], $_POST['groupId'], $_POST['message'])) {
        die();
    }

    $fromUserId = $_POST['userId'];
    $groupId = $_POST['groupId'];
    $message = $_POST['message'];

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
        try {
//            $finfo = finfo_open(FILEINFO_MIME_TYPE);
//            $finfo = mime_content_type($_FILES['upfile']['tmp_name']);
            $check = getimagesize($_FILES['upfile']['tmp_name']);
            $finfo = '';
            if($check !== false) {
                $finfo = $check['mime'];
            }

            if (false === $ext = array_search(
                    $finfo,
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

        } catch (Exception $e) {

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

        send_message($fromUserId, $groupId, '<img src=' . sprintf('./media/%s.%s',
                $name,
                $ext
            ) . ' alt="image">');
    }

    if (!empty($message)) {
        send_message($fromUserId, $groupId, $message);
    }

    header('Location: messages.php');
}


echo "<form action=\"messages.php\" method=\"post\" enctype='multipart/form-data'>
            <input type=\"hidden\" name=\"action\" value=\"send\">
            <input type=\"hidden\" name=\"userId\" value=\"" . $_SESSION['userId'] . '">
            <input type="hidden" name="groupId" value="' . $_SESSION['groupId'] . "\">
            <div class='row'>
              <div class=\"form-group col-md-12\">
                <textarea class=\"form-control\" name='message' id=\"inputText\" rows=\"3\"></textarea>
              </div>
              <div class=\"form-group col-md-6\">
                <input type='file' class='form-control-file' id='upfile' name='upfile' aria-describedby='fileHelp' size='10'>
                <small id='fileHelp' class='form-text text-muted'>Note: Max file size of 10MB</small>
              </div>
              <div class='form-group col-md-6'>
                <button type=\"submit\" class=\"btn btn-primary btn-lg\" name=\"\">Send</button>
              </div>
            </div>
          </form>";