<?php
$connect = mysqli_connect("localhost", "root", "", "accounts");
if(isset($_POST["eval_id"]))
{
    $query = "SELECT * FROM evaluation WHERE id = '".$_POST["eval_id"]."'";
    $result = mysqli_query($connect, $query);
    $row = mysqli_fetch_array($result);
    echo json_encode($row);
}
?>