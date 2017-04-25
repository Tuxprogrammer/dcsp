<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="charset" content="UTF-8">
  <title>cHat</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css"
        integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
  <link rel="stylesheet" href="./assets/css/messages-style.css">
</head>
<body>
  <header>
    <div class="container">
      <nav class="navbar navbar-toggleable-md navbar-light bg-faded">
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="./index.html">cHat</a>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link" href="./user_profile.php">Profile</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./groups.php">View Groups</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./create_group.php">Create Group</a>
            </li>
          </ul>
          <form class="form-inline my-2 my-lg-0" action="./logout.php" method="post">
            <button class="btn btn-danger my-2 my-sm-0" type="submit">Logout</button>
          </form>
        </div>
      </nav>
    </div>
  </header>

  <?php require_once __DIR__.'/assets/php/check_login.php'?>
  <div class="bg-pageheader">
    <div class="container">
      <h1><?php echo lookupGroupName($_SESSION['groupId']);?></h1>
      <h3><?php echo lookupGroupDesc($_SESSION['groupId']);?></h3>
    </div>
  </div>


  <div class="">
    <div class="container">
      <div class="row" id="main-row">
        <div class="col-md-3 push-md-9" id="users-side">
          <h4>User List:</h4>
          <?php
          require_once __DIR__ . '/assets/php/user_profile_list.php'; ?>

          <h4>Actions:</h4>
          <?php
          require_once __DIR__ . '/assets/php/add_user.php';
          require_once __DIR__ . '/assets/php/remove_user.php';
          ?>
        </div>
        <div class="col-md-9 pull-md-3" id="message-side">
          <?php
          require_once __DIR__ . '/assets/php/send_message.php';
          require_once __DIR__ . '/assets/php/get_messages.php';
          ?>
        </div>
      </div>
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