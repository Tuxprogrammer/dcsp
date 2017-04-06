<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css"
          integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/login-style.css">

    <!-- TODO: GET RID OF THIS INLINE STYLE -->
    <style>
        td, th {
            border: 1px solid black;
            padding: 0;
        }

        a {
            color: #ffffff;
        }

        a:hover {
            color: #808080;
        }

        a:visited {
            color: #404040;
        }
    </style>
</head>
<body>
<header class="navbar navbar-toggleable-md navbar-light bg-faded">
    <nav class="container">
        <div class="d-flex justify-content-between hidden-lg-up">
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="#">cHat</a>
        </div>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="./">Home</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="login.php">Login <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="register.php">Register</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#">About</a>
                </li>
            </ul>
        </div>
    </nav>
</header>
<div class="">
    <div class="container">
        <?php
        require_once 'assets/php/get_messages.php';
        require_once 'assets/php/send_message.php';
        require_once 'assets/php/add_user.php';
        ?>
    </div>
</div>
</body>
</html>