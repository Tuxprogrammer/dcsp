<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css"
        integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  <link rel="stylesheet" href="./assets/css/admin-profile-style.css">

  <!-- TODO: GET RID OF THIS INLINE STYLE -->
  <style>
    td, th {
      border: 1px solid white;
      padding: 1em 1em 1em 1em;
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
            <a class="nav-link" href="#">Profile</a>
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
  </header>
  <div class="bg-pageheader">
    <div class="container">
      <h1>Admin Profile</h1>
    </div>
  </div>
  <div class="container">
    <?php require_once __DIR__ . '/assets/php/admin_profile.php'; ?>
  </div>
</body>
</html>
