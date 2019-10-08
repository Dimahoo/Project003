<?php
$connect = mysqli_connect("localhost", "root", "", "accounts");
if(isset($_POST["client_id"]))
{
    $query = "SELECT * FROM client WHERE id = '".$_POST["client_id"]."'";
    $result = mysqli_query($connect, $query);
    $row = mysqli_fetch_array($result);
    echo json_encode($row);
}
?>