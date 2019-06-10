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
        <?php if($_SESSION['admin'] == 1) {?>
        <ul>
            <li><i class="fas fa-plus-square"></i> Manage profiles</li>
                <ul>
                    <a href="create.php">Create</a>
                </ul>
        </ul>
        <?php }?>
        <a href="profile.php"><i class="fas fa-user-circle"></i><?=$_SESSION['name']?> Profile</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
    </div>
</nav>
<div class="content">
    <h2>Home Page</h2>
    <?php if($_SESSION['create'] == 1) {?>
    <div class="alert alert-error">New user created successfully</div>
    <?php $_SESSION['create'] = 0;}?>
</div>
</body>
</html>
