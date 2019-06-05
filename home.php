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
        <a href="profile.php"><i class="fas fa-user-circle"></i><?=$_SESSION['name']?> Profile</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
    </div>
</nav>
<div class="content">
    <h2>Home Page</h2>
    <p>Welcome back, <?=$_SESSION['name']?>!</p>
    <?php if($_SESSION['create'] == 1) {?>
    <div class="alert alert-error">New user created successfully<?=$_SESSION['create']?></div>
    <?php $_SESSION['create'] = 0;}?>
    <a href="create.php"><i class="fas fa-user-circle"></i>Create new Profile</a>
</div>
</body>
</html>
