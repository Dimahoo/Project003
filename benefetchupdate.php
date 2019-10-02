<?php
$connect = mysqli_connect("localhost", "root", "", "accounts");
if(isset($_POST["bene_id"]))
{
    $query = "SELECT * FROM benevole WHERE id = '".$_POST["bene_id"]."'";
    $result = mysqli_query($connect, $query);
    $row = mysqli_fetch_array($result);
    echo json_encode($row);
}
?>