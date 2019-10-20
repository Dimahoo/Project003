<?php
$connect = mysqli_connect("localhost", "root", "", "accounts");
if(isset($_POST["id_client"]))
{
    $query = "SELECT * FROM client WHERE id = '".$_POST["id_client"]."'";
    $result = mysqli_query($connect, $query);
    $row = mysqli_fetch_array($result);
    echo json_encode($row);
}
?>