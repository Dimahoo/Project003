<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
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
<div class="createfirstadmin">
    <h1>Nouveau profil administrateur</h1>
    <form action="logincreateadmincheck.php" method="post">
        <input type="text" name="username" placeholder="Nom utilisateur" id="username" required>
        <label for="username">
            <i class="fas fa-user"></i>
        </label>
        <input type="email" name="email" placeholder="email" id="email" required>
        <label for="email">
            <i class="fas fa-at"></i>
        </label>
        <input type="password" name="password" placeholder="Mot de passe" id="new-password1" required>
        <label for="new-password1">
            <i class="fas fa-lock"></i>
        </label>
        <input type="password" name="confpassword" placeholder="Confirmer le mot de passe" id="new-password2" required>
        <label for="new-password2">
            <i class="fas fa-lock"></i>
        </label>
        <input type="submit" value="Créer">
    </form>
</div>
</body>
</html>