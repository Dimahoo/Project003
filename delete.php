<?php
// We need to use sessions, so you should always start sessions using the below code.
include 'function.php';
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
$sql = $mysqli->query("SELECT * FROM users") or die($mysqli->error);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile Page</title>
    <link href="delete.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
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
                    <li><a href="create.php">Create</a></li>
                    <li><a href="delete.php">Delete</a></li>

                </ul>
            </li>
        <?php }?>
        <li style="padding-left:75em">
            <a href="profile.php"><i class="fas fa-user-circle"></i> <?=$_SESSION['name']?>  Profile</a>
        </li>
        <li>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
        </li>
    </ul>
</nav>
<div class="content">
    <h2>Delete profile</h2>
    <div>
        <p>List of users:</p>
        <table>
            <tr>
                <th><input type="checkbox" id="checkAll"></th>
                <th>Username</th>
                <th>Email</th>
            </tr>
            <?php while($row = mysqli_fetch_assoc($sql)) {?>
            <tr>
                <td><input class="checkbox" type="checkbox" id="<?=$row['id'] ?>"</td>
                <td><?=$row['username']?></td>
                <td><?=$row['email']?></td>
            </tr>
            <?php }?>
        </table>
    </div>
    <button type="button" class="btn btn-danger" id="delete">Delete Selected</button>
</div>
<script>
    jQuery(document).ready(function(){
        jQuery('#checkAll').click(function(){
            if(this.checked){
                jQuery('.checkbox').each(function(){
                    this.checked = true;
                });
            }else{
                jQuery('.checkbox').each(function(){
                    this.checked = false;
                });
            }
        });
</script>
</body>
</html>
