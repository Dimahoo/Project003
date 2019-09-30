<?php
$connect = mysqli_connect("localhost", "root", "", "accounts");
if(isset($_POST["statis_id"]))
{
    $query = "SELECT * FROM statis WHERE id = '".$_POST["statis_id"]."'";
    $result = mysqli_query($connect, $query);
    $row = mysqli_fetch_array($result);
    echo json_encode($row);
}
?>