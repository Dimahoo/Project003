<?php
$connect = mysqli_connect("localhost", "root", "", "accounts");
if(isset($_POST["rdv_id"]))
{
    $query = "SELECT * FROM rdv WHERE id = '".$_POST["rdv_id"]."'";
    $result = mysqli_query($connect, $query);
    $row = mysqli_fetch_array($result);
    echo json_encode($row);
}
?>