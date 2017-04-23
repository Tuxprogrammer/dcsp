<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css"
        integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  <link rel="stylesheet" href="./assets/css/register-style.css">
</head>
<body>
<?php require_once __DIR__ . '/assets/php/create_user.php' ?>
  <header>
    <div class="container">
      <nav class="navbar navbar-toggleable-md navbar-light bg-faded">
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="./index.html">cHat</a>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link" href="./">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="login.php">Login</a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="register.php">Register <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./about">About</a>
            </li>
          </ul>
        </div>
      </nav>
    </div>
  </header>

  <div class="bg-pageheader">
    <div class="container">
      <h1>Register for cHat</h1>
      <h3>pls.</h3>
    </div>
  </div>

  <div class="container" id="register-form">
    <div class="row justify-content-center">
      <form class="form-horizontal col-xs-12 col-lg-8" method="POST" action="register.php">
        <div class="form-group row">
          <label for="username-input" class="col-4 col-form-label">Username</label>
          <div class="col-8">
            <input class="form-control" type="text" name="username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>" >
          </div>
        </div>
        <div class="form-group row">
          <label for="password-input" class="col-4 col-form-label">Password</label>
          <div class="col-8">
            <input class="form-control" type="password" name="password">
          </div>
        </div>
        <div class="form-group row">
          <label for="realname-input" class="col-4 col-form-label">Real Name</label>
          <div class="col-8">
            <input class="form-control" type="text" name="realname" value="<?php echo isset($_POST['realname']) ? $_POST['realname'] : ''; ?>">
          </div>
        </div>
        <div class="form-group row">
          <label for="email-input" class="col-4 col-form-label">Email Address</label>
          <div class="col-8">
            <input class="form-control" type="email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
          </div>
        </div>
        <div class="form-group row">
          <label for="phone-number-input" class="col-4 col-form-label">Phone Number</label>
          <div class="col-8">
            <input class="form-control" type="tel" name="phone-number" value="<?php echo isset($_POST['phone-number']) ? $_POST['phone-number'] : ''; ?>">
          </div>
        </div>
        <div class="form-group row justify-content-center">
          <button type="submit" class="btn btn-primary">Submit</button>
          <button id="reset-btn" type="reset" class="btn btn-danger">Reset</button>
        </div>
      </form>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js"
          integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n"
          crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"
          integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb"
          crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"
          integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn"
          crossorigin="anonymous"></script>
</body>
</html>