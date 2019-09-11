<?php
session_start();
$connection = mysqli_connect("localhost","root","");
$db = mysqli_select_db($connection,'accounts');

if(isset($_POST['updatedata'])) {

    $id = $_POST['rdv_id'];

    //$id_interv = $_POST['id_interv'];
    //$id_cli = $_POST['id_cli'];
    $date_inscription = $_POST['date_inscription'];
    $description = $_POST['description'];
    $type_appelant = $_POST['type_appelant'];
    $mode_interv = $_POST['mode_interv'];
    $type_interv = $_POST['type_interv'];
    $langue = $_POST['langue'];
    $duree = $_POST['duree'];
    $ref_par = $_POST['ref_par'];
    $date_arrivee = $_POST['date_arrivee'];
    $sexe = $_POST['sexe'];
    $age = $_POST['age'];
    $situ_finance = $_POST['situ_finance'];
    $origine = $_POST['origine'];
    $status_canada = $_POST['status_canada'];
    $prob_mentale = $_POST['prob_mentale'];
    $etat_civil = $_POST['etat_civil'];
    $nbr_enfant = $_POST['nbr_enfant'];
    $psy_apres_interv = $_POST['psy_apres_interv'];
    $psy_avant_interv = $_POST['psy_avant_interv'];
    $motif_consult = $_POST['motif_consult'];


    $query = "UPDATE rdv SET date_inscription='$date_inscription', description='$description', type_appelant='$type_appelant', mode_interv='$mode_interv', type_interv='$type_interv', langue='$langue', duree='$duree', ref_par='$ref_par', date_arrivee='$date_arrivee', sexe='$sexe', age='$age', situ_finance='$situ_finance', origine='$origine', status_canada='$status_canada', prob_mentale='$prob_mentale', etat_civil='$etat_civil', nbr_enfant='$nbr_enfant', psy_apres_interv='$psy_apres_interv', psy_avant_interv='$psy_avant_interv', motif_consult='$motif_consult' WHERE id='$id'";
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