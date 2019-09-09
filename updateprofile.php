<?php
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

    $query = "UPDATE users SET username='$username', email='$email', admin='$admin' WHERE id='$id'";
    $query_run = mysqli_query($connection,$query);

    if($query_run) {
        echo '<script> alert("Data Updated"); </script>';
        header("location:modify.php");
    } else {
        echo '<script> alert("Data Not Updated"); </script>';
    }
}
?>