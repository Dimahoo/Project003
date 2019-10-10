<?php
session_start();

$connection = mysqli_connect("localhost", "root", "", "accounts");
$db = mysqli_select_db($connection,'accounts');


if(isset($_POST["list"])) {

    $id_list_clients = explode(',', $_POST["list"]);
    $id_interv = $connection->real_escape_string($_POST['interv']);
    $data = '';

    $query = "SELECT username FROM users WHERE id='$id_interv'";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_array($result);
    $username = $row["username"];


    for ($i = 0; $i < count($id_list_clients); $i++) {

        $data = $id_list_clients[$i];
        $query = "UPDATE client SET id_interv='$id_interv', interv='$username' WHERE id='$data'";
        $query_run = mysqli_query($connection,$query)or die(mysqli_error());
    }


}

?>