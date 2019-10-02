<?php
session_start();
$connection = mysqli_connect("localhost","root","");
$db = mysqli_select_db($connection,'accounts');

if(isset($_POST['updatestatis'])) {

    $id = $_POST['statis_id'];

    $date_ajout = $_POST['date_ajout'];
    $description = $_POST['description'];
    $sexe = $_POST['sexe'];
    $origine = $_POST['origine'];
    $langue = $_POST['langue'];
    $mode_interv = $_POST['mode_interv'];

    $query = "UPDATE statis SET date_ajout='$date_ajout', description='$description', sexe='$sexe', origine='$origine', langue='$langue', mode_interv='$mode_interv' WHERE id='$id'";
    $query_run = mysqli_query($connection,$query);

    if ($query_run) {
        $_SESSION['editstatis'] = 1;
        header("location:liststatis.php");
    } else {
        echo "Error: " . $query . "<br>" . $mysqli->error;
        //echo '<script> alert("Fiche non ajoutee"); </script>';
    }
}
?>