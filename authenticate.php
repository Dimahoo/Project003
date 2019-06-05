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
if ( !isset($_POST['username'], $_POST['password']) ) {
    // Could not get the data that should have been sent.
    die ('Please fill both the username and password field!');
}

$username = $mysqli->real_escape_string($_POST['username']);
$password = md5($_POST['password']); //md5 hash password security
//Query the database for user
$sql = $mysqli->query("SELECT * FROM users WHERE username = '$username' AND password = '$password'") or die($mysqli->error);

if ($sql->num_rows > 0) {

            // Verification success! User has loggedin!
            // Create sessions so we know the user is logged in, they basically act like cookies but remember the data on the server.
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['create'] = 0;
            $_SESSION['update'] = 0;
            $_SESSION['delete'] = 0;
            header('Location: home.php');
} else {
            $_SESSION['message'] = 'Username / Password is incorrect!';
            header("location:errorlogin.php");
}
?>