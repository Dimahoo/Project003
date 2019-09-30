<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
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
    <title>New profile</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link href="create.css" rel="stylesheet" type="text/css">
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
</head>
<body>
<div class="newprofile">
    <h1>New profile</h1>
    <form action="createcheck.php" method="post">
        <div class="alert alert-error"><?= $_SESSION['message'] ?></div>
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
        <input type="password" name="confpassword" placeholder="confirm password" id="new-password2" required>
        <label for="new-password2">
            <i class="fas fa-lock"></i>
        </label>
        <input type="text" name="admin" id="admin" placeholder="Cocher si le profil est un admin" readonly>
        <input type="checkbox" name="checkadmin" id="checkadmin" value="admin">
        <input type="text" name="adj" id="adj" placeholder="Cocher si le profil est un adjoint admin" readonly>
        <input type="checkbox" name="checkadj" id="checkadj" value="adj">
        <input type="submit" name="submit" value="create">
        <!-- <input type="submit" name="submitButton" value="Cancel"> -->
        <input type="button" name="cancel" value="cancel" onClick="window.location='home.php';" />
    </form>
</div>

<script>

    $(document).ready(function () {

        $("#checkadmin").click(function(){


            if ($(this).is(":checked")) {

                $("#checkadj").prop("checked", false);
            }
        });

        $("#checkadj").click(function(){

            if ($(this).is(":checked")) {

                $("#checkadmin").prop("checked", false);
            }
        });
    });

</script>
</body>
</html>