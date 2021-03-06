<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New profile</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link href="createadmin.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="newprofile">
    <h1>New profile</h1>
    <form action="createadmin.php" method="post">
        <input type="text" name="username" placeholder="username" id="username" required>
        <label for="username">
            <i class="fas fa-user"></i>
        </label>
        <input type="email" name="email" placeholder="email" id="email" required>
        <label for="email">
            <i class="fas fa-at"></i>
        </label>
        <input type="password" name="password" placeholder="password" id="new-password1" required>
        <label for="new-password1">
            <i class="fas fa-lock"></i>
        </label>
        <input type="password" name="confirm password" placeholder="confirm password" id="new-password2" required>
        <label for="new-password2">
            <i class="fas fa-lock"></i>
        </label>
        <input type="submit" value="Create">
        <input type="submit" value="Create">
    </form>
</div>
</body>
</html>