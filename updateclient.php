<?php
session_start();
$connection = mysqli_connect("localhost","root","");
$db = mysqli_select_db($connection,'accounts');

if(isset($_POST['updateclient'])) {

    $id = $_POST['client_id'];

    $date_creation = $connection->real_escape_string($_POST['date_creation']);
    $date_cloture = $connection->real_escape_string($_POST['date_cloture']);

    if($date_sortie != '') {
        $query = "UPDATE client SET date_creation='$date_creation', date_cloture='$date_cloture' WHERE id='$id'";
    } else {
        $query = "UPDATE client SET date_creation='$date_creation' WHERE id='$id'";
    }

    $query_run = mysqli_query($connection,$query);

    if ($query_run) {
        $_SESSION['editclient'] = 1;
        header("location:listclient.php");
    } else {
        echo "Error: " . $query . "<br>" . $connection->error;
        //echo '<script> alert("Fiche non ajoutee"); </script>';
    }
}
?>