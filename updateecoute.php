<?php
session_start();
$connection = mysqli_connect("localhost","root","");
$db = mysqli_select_db($connection,'accounts');

if(isset($_POST['updateecoute'])) {

    $id = $_POST['id_rdv'];

    //$id_interv = $_POST['id_interv'];
    //$id_cli = $_POST['id_cli'];
    $date_rdv = $_POST['date_rdv'];
    $type = $_POST['type'];


    $query = "UPDATE rdv SET date_rdv='$date_rdv', type='$type' WHERE id='$id'";
    $query_run = mysqli_query($connection,$query);

    if ($query_run) {
        $_SESSION['editecoute'] = 1;
        header("location:listecoute.php");
    } else {
        echo "Error: " . $query . "<br>" . $mysqli->error;
        //echo '<script> alert("Fiche non ajoutee"); </script>';
    }
}
?>