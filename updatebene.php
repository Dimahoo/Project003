<?php
session_start();
$connection = mysqli_connect("localhost","root","");
$db = mysqli_select_db($connection,'accounts');

if(isset($_POST['updatebene'])) {

    $id = $_POST['bene_id'];

    $date_entree = $_POST['date_entree'];
    $role = $_POST['role'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $sexe = $_POST['sexe'];
    $tache = $_POST['tache'];

    $query = "UPDATE benevole SET date_entree='$date_entree', role='$role', nom='$nom', prenom='$prenom', sexe='$sexe', tache='$tache' WHERE id='$id'";
    $query_run = mysqli_query($connection,$query);

    if ($query_run) {
        $_SESSION['editbene'] = 1;
        header("location:listbenevole.php");
    } else {
        echo "Error: " . $query . "<br>" . $mysqli->error;
        //echo '<script> alert("Fiche non ajoutee"); </script>';
    }
}
?>