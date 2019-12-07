<?php
session_start();
$connection = mysqli_connect("localhost","root","");
$db = mysqli_select_db($connection,'accounts');

if(isset($_POST['updateval'])) {

    $id = $_POST['eval_id'];

    $note = $connection->real_escape_string($_POST['note']);
    $com = $connection->real_escape_string($_POST['com']);


    $query = "UPDATE eval SET note='$note', com='$com' WHERE id='$id'";


    $query_run = mysqli_query($connection,$query);

    if ($query_run) {
        $_SESSION['editeval'] = 1;
        header("location:listeval.php");
    } else {
        echo "Error: " . $query . "<br>" . $connection->error;
        //echo '<script> alert("Fiche non ajoutee"); </script>';
    }
}
?>