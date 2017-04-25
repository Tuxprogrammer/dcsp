
<?php require_once __DIR__.'/assets/php/reset_password.php'; ?>

<form action="reset_password.php" method="post">
    <input placeholder="Username" name="userName" type="text">
    <input placeholder="Phone Number" name="phoneNumber" type="text">
    <input placeholder="New Password" name="password" type="password">
    <button type="submit">Reset Password</button>
</form>
