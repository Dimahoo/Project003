<?php
session_start();
$connection = mysqli_connect("localhost","root","");
$db = mysqli_select_db($connection,'accounts');

if(isset($_POST['updatebene'])) {

    $id = $_POST['bene_id'];

    $date_entree = $connection->real_escape_string($_POST['date_entree']);
    $role = $connection->real_escape_string($_POST['role']);
    $nom = $connection->real_escape_string($_POST['nom']);
    $prenom = $connection->real_escape_string($_POST['prenom']);
    $sexe = $connection->real_escape_string($_POST['sexe']);
    $tache = $connection->real_escape_string($_POST['tache']);
    $domaine = $connection->real_escape_string($_POST['domaine']);
    $langue = $connection->real_escape_string($_POST['langue']);
    $date_sortie = $connection->real_escape_string($_POST['date_sortie']);
    $eval = $connection->real_escape_string($_POST['eval']);
    $comment = $connection->real_escape_string($_POST['comment']);

    if($date_sortie != '') {
        $query = "UPDATE benevole SET date_entree='$date_entree', role='$role', nom='$nom', prenom='$prenom', sexe='$sexe', tache='$tache',domaine='$domaine',langue='$langue', date_sortie='$date_sortie', eval='$eval', comment='$comment' WHERE id='$id'";
    } else {
        $query = "UPDATE benevole SET date_entree='$date_entree', role='$role', nom='$nom', prenom='$prenom', sexe='$sexe', tache='$tache',domaine='$domaine',langue='$langue', eval='$eval', comment='$comment' WHERE id='$id'";
    }

    $query_run = mysqli_query($connection,$query);

    if ($query_run) {
        $_SESSION['editbene'] = 1;
        header("location:listbenevole.php");
    } else {
        echo "Error: " . $query . "<br>" . $connection->error;
        //echo '<script> alert("Fiche non ajoutee"); </script>';
    }
}
?>