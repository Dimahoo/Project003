<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// Reset error message
$_SESSION['message'] = '';
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
    <title>Home Page</title>
    <link href="home.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
</head>
<body class="loggedin">
<nav class="navtop">
    <p>Website Title</p>
    <ul>
        <li><a href="home.php"><i class="fas fa-home"></i></a></li>
        <li></li>
        <li></li>
        <?php if($_SESSION['admin'] == 1) {?>
        <li><a href="#">Manage profile</a>
            <ul>
                <li><a href="createadmin.php">Create</a></li>

            </ul>
        </li>
        <?php }?>
        <li style="padding-left:80em">
            <a href="profile.php"><i class="fas fa-user-circle"></i> <?=$_SESSION['name']?> Profile</a>
        </li>
        <li>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
        </li>
    </ul>
</nav>
<div class="content">
    <h2>Home Page</h2>
    <?php if($_SESSION['create'] == 1) {?>
    <div class="alert alert-error">New user created successfully</div>
    <?php $_SESSION['create'] = 0;}?>
</div>
</body>
</html>
