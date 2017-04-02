<?php require_once __DIR__.'assets/php/create_group.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<h1>Create a new group for cHatter</h1>
<form method="POST" action="create_group.php">
    Group Type: <select name="gType" required>
    <option value="1">1 - Public</option>
    <option value="2">2 - Private</option>
</select><br>
    Group Name: <input name="groupName" type="text" required><br>

    Avatar Image: <input name="avatarImage" type="url"><br>

    <input type="reset">
    <input type="submit">
</form>
</body>
</html>