<?php
$connect = mysqli_connect("localhost", "root", "", "accounts");
if(isset($_POST["id"]))
{
    $query = "DELETE FROM rdv WHERE id = '".$_POST["id"]."'";
    if(mysqli_query($connect, $query))
    {
        echo 'Data Deleted';
    }
}
?>