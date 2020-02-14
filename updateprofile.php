<?php
session_start();
$connection = mysqli_connect("localhost","root","");
$db = mysqli_select_db($connection,'accounts');

if(isset($_POST['updatedata'])) {

    $id = $_POST['update_id'];

    $username = $_POST['username'];
    $email = $_POST['email'];
    if ($_POST['admin'] == 'Yes') {

        $admin = 1;
    } else {

        $admin = 0;
    }

    if ($_POST['adj'] == 'Yes') {

        $admin = 2;
    } else {

        $admin = 0;
    }

    if ($_POST['password'] != '') {

        $password = md5($_POST['password']);
        $query = "UPDATE users SET username='$username', email='$email', admin='$admin', password='$password' WHERE id='$id'";
    } else {

        $query = "UPDATE users SET username='$username', email='$email', admin='$admin' WHERE id='$id'";
    }

    $query_run = mysqli_query($connection,$query);

    if($query_run) {
        $_SESSION['editprof'] = 1;
        header("location:modify.php");
    } else {
        echo "Error: " . $query . "<br>" . $mysqli->error;
        //echo '<script> alert("Fiche non ajoutee"); </script>';
    }
}
?>