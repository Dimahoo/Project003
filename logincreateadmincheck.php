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
if ( !isset($_POST['username'], $_POST['email'], $_POST['password'], $_POST['confpassword']) ) {
    // Could not get the data that should have been sent.
    die ('Please fill the missing fields!');
}

$username = $mysqli->real_escape_string($_POST['username']);
$email = $mysqli->real_escape_string($_POST['email']);
$password = md5($_POST['password']); //md5 hash password security
$password2 = md5($_POST['confpassword']); //md5 hash password security
// New entry is an admin
$admin = 1;

// Verification password confirmation
if ($password != $password2) {

    $_SESSION['message'] = 'Passwords don\'t match!';
    header('Location: errorlogincreateadmin.php');

} else {
    // Insert the new entry in the database table
    $sql = $mysqli->query("INSERT INTO users (username, email, password, admin) VALUES ('$username','$email','$password','$admin') ") or die($mysqli->error);
    // Create sessions so we know the user is logged in, they basically act like cookies but remember the data on the server.
    $_SESSION['loggedin'] = TRUE;
    $_SESSION['name'] = $_POST['username'];
    $_SESSION['create'] = 0;
    $_SESSION['update'] = 0;
    $_SESSION['delete'] = 0;
    $_SESSION['admin'] = 1;
    header('Location: home.php');
}
?>