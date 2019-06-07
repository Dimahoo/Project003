<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'accounts';

// connect using the info above.
$mysqli = new mysqli($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);


//Query the database for user
$sql = $mysqli->query("SELECT count(*) as 'c' FROM users") or die($mysqli->error);
$count = $sql->fetch_object()->c;
// check table is empty
if ($count > 0)
{
    // Redirect to the create form page:
    header('Location: login.php');
}
else
{
    // Redirect to the login form page
    header('Location: logincreateadmin.php');
}
?>