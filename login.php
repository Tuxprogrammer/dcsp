<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css"
        integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  <link rel="stylesheet" href="./assets/css/login-style.css">
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

  <div class="bg-pageheader">
    <div class="container">
      <h1>Login to cHat</h1>
      <h3>cause its what cool kids do</h3>
    </div>
  </div>

  <?php require_once __DIR__.'/assets/php/login.php' ?>

  <div class="container" id="login-form">
    <div class="row justify-content-center">
      <form class="form-horizontal col-xs-12 col-lg-8" method="POST" action="login.php">
        <div class="form-group">
          <input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username"
                 value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>">
        </div>
        <div class="form-group">
          <input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password">
        </div>
        <div class="form-group text-center">
          <input type="checkbox" tabindex="3" class="" name="remember" id="remember">
          <label for="remember"> Remember Me</label>
        </div>
        <div class="form-group">
          <div class="row justify-content-center">
            <div class="col-sm-6">
              <input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login"
                     value="Log In">
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-lg-12">
              <div class="text-center">
                <a href="#" tabindex="5" class="forgot-password">Forgot Password?</a>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
