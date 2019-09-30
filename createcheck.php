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

// Now we check if the data from the create form was submitted, isset() will check if the data exists.
if (!isset($_POST['username'], $_POST['email'], $_POST['password'], $_POST['confpassword'])) {
    // Could not get the data that should have been sent.
    $_SESSION['message'] = 'Please fill the missing fields!';
    header('Location: create.php');
    }

// Now we check if the data from the create form was submitted, empty() will check if the data exists.
if (empty($_POST['username']) || $_POST['username'] == '') {
    // Could not get the data that should have been sent.
    $_SESSION['message'] = 'Please fill the missing fields!';
    header('Location: create.php');
    }

$username = $mysqli->real_escape_string($_POST['username']);
$email = $mysqli->real_escape_string($_POST['email']);
$password = md5($_POST['password']); //md5 hash password security
$password2 = md5($_POST['confpassword']); //md5 hash password security

echo($password);
echo($password2);
// Check new entry is admin or not
$admin = 0;
if ($_POST['checkadmin'] == 'admin') {
    $admin = 1;
}
if ($_POST['checkadj'] == 'adj') {
    $admin = 2;
}


// Verification password confirmation
if ($_POST['password'] != $_POST['confpassword']) {

    $_SESSION['message'] = 'Passwords don\'t match!';
    header('Location: create.php');
} else {

    //Query the database for user
    $sql = $mysqli->query("SELECT count(*) as 'c' FROM users WHERE username = '$username' OR email = '$email'") or die($mysqli->error);
    $count = $sql->fetch_object()->c;
    // Verification user exist
    if ($count > 0) {

        $_SESSION['message'] = 'Username or email already used!';
        header('Location: create.php');
    } else {
        // Insert the new entry in the database table
        $sql = $mysqli->query("INSERT INTO users (username, email, password, admin) VALUES ('$username','$email','$password','$admin') ") or die($mysqli->error);
        // Create sessions so we know the user is logged in, they basically act like cookies but remember the data on the server.
        $_SESSION['addprof'] = 1;
        header('Location: home.php');
        }
    }
?>