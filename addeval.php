<?php
session_start();
$connection = mysqli_connect("localhost","root","");
$db = mysqli_select_db($connection,'accounts');

$year = date('Y');

if(isset($_POST['addeval'])) {

    $id_interv = $connection->real_escape_string($_POST["interv"]);
    $trim = $connection->real_escape_string($_POST['trim']);
    $note = $connection->real_escape_string($_POST['note']);
    $comment = $connection->real_escape_string($_POST['comment']);

    $query = "SELECT username FROM users WHERE id='$id_interv'";
    $result = mysqli_query($connection, $query);
    $row = $result->fetch_assoc();
    $interv = $row["username"];

    $query = "INSERT INTO eval (id_interv,
                                interv,
                                trim,
                                year,
                                note,
                                com)
                              VALUES ('$id_interv',
                                      '$interv', 
                                      '$trim',
                                      '$year',
                                      '$note',
                                      '$comment')";

    $query_run = mysqli_query($connection,$query);

    if ($query_run) {
        $_SESSION['addeval'] = 1;
        header("location:evalinterv.php");
    } else {
        echo "Error: " . $query . "<br>" . $connection->error;
        //echo '<script> alert("Fiche non ajoutee"); </script>';
    }
}
?>