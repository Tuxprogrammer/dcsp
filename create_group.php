<?php require_once __DIR__ . '/assets/php/create_group.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="charset" content="UTF-8">
  <title>cHat</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css"
        integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
  <link rel="stylesheet" href="./assets/css/create-group-style.css">
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
            <li class="nav-item active">
              <a class="nav-link" href="./create_group.php">Create Group<span class="sr-only">(current)</span></a>
            </li>
          </ul>
          <form class="form-inline my-2 my-lg-0" action="./logout.php" method="post">
            <button class="btn btn-danger my-2 my-sm-0" type="submit">Logout</button>
          </form>
        </div>
      </nav>
    </div>
  </header>

  <div class="bg-pageheader">
    <div class="container">
      <h1>Create a new group for cHatter</h1>
      <h3>cause it'd be cool</h3>
    </div>
  </div>

  <div class="container" id="create-group-form">
    <div class="row justify-content-center">
      <form class="form-horizontal col-xs-12 col-lg-8" method="POST" action="create_group.php">
        <div class="form-group row">
          <label for="group-type-input" class="col-4 col-form-label">Group Type</label>
          <div class="col-8">
            <select class="form-control" id="group-type-input" name="gType" required>
              <option value="1">Public</option>
              <option value="2">Private</option>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label for="group-name-input" class="col-4 col-form-label">Group Name</label>
          <div class="col-8">
            <input class="form-control" type="text" id="group-name-input" name="groupName" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="description-input" class="col-4 col-form-label">Description</label>
          <div class="col-8">
            <input class="form-control" type="text" id="description-input" name="groupDesc" required>
          </div>
        </div>
        <div class="form-group row justify-content-center">
          <button type="submit" class="btn btn-primary">Submit</button>
          <button id="reset-btn" type="reset" class="btn btn-danger">Reset</button>
        </div>
      </form>
    </div>
  </div>

</body>
</html>