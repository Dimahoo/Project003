<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link href="login.css" rel="stylesheet" type="text/css">
</head>
<body>
</br>
</br>
</br>
</br>
</br>
</br>
<div class="login">
    <h1>Identification</h1>
    <form action="authenticate.php" method="post">
        <div class="alert alert-error"><?= $_SESSION['message'] ?></div>
        <input type="text" name="username" placeholder="Nom utilisateur" id="username" required>
        <label for="username">
            <i class="fas fa-user"></i>
        </label>
        <input type="password" name="password" placeholder="mot de passe" id="password" required>
        <label for="password">
            <i class="fas fa-lock"></i>
        </label>
        <input type="submit" value="S'identifier">
    </form>
</div>
</body>
</html>