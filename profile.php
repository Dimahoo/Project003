<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit();
}
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'accounts';

// connect using the info above.
$mysqli = new mysqli($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

$username = $mysqli->real_escape_string($_SESSION['name']);

//Query the database for user
$sql = $mysqli->query("SELECT * FROM users WHERE username = '$username'") or die($mysqli->error);

$row = $sql->fetch_row();
$password = $row[3];
$email = $row[2];
$admin = $row[5]
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Profile Page</title>
    <link href="style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
</head>
<body class="loggedin">
<nav class="navtop">
    <div>
        <label for="home">
            <a href="home.php"><i class="fas fa-home"></i></a>
        </label>
        <h1>Website Title</h1>
        <a href="profile.php"><i class="fas fa-user-circle"></i><?=$username?> Profile</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
    </div>
</nav>
<div class="content">
    <h2>Profile Page</h2>
    <div>
        <p>Your account details are below:</p>
        <table>
            <tr>
                <td>Username:</td>
                <td><?=$_SESSION['name']?></td>
            </tr>
            <tr>
                <td>Password:</td>
                <td><?=$password?></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><?=$email?></td>
            </tr>
            <?php if ($admin == 1) {?>
            <tr>
                <td>Admin</td>
            </tr>
            <?php }?>
        </table>
    </div>
</div>
</body>
</html>
