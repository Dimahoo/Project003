<?php
session_start();
$_SESSION['message'] = '';
// Change this to your connection info.
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'accounts';
// connect using the info above.
$mysqli = new mysqli($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

// Now we check if the data from the login form was submitted, isset() will check if the data exists.
if ( !isset($_POST['username'], $_POST['email'], $_POST['password'], $_POST['confirm password']) ) {
    // Could not get the data that should have been sent.
    die ('Please fill the missing fields!');
}

$username = $mysqli->real_escape_string($_POST['username']);
$email = $mysqli->real_escape_string($_POST['email']);
$password = md5($_POST['password']); //md5 hash password security
$password2 = md5($_POST['confirm password']); //md5 hash password security
// New entry is an admin
    $admin = 1;

// Verification password confirmation
if ($password != $password2) {

    $_SESSION['message'] = 'Username already used!';

} else {
    // Insert the new entry in the database table
    $sql = $mysqli->query("INSERT INTO users (username, email, password, admin) VALUES ('$username','email','password','admin') ") or die($mysqli->error);
    // Create sessions so we know the user is logged in, they basically act like cookies but remember the data on the server.
    $_SESSION['create'] = 1;
    header('Location: home.php');
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New profile</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="Newprofile">
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
    </form>
</div>
</body>
</html>