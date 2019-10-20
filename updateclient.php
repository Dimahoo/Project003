<?php
session_start();
$connection = mysqli_connect("localhost","root","");
$db = mysqli_select_db($connection,'accounts');

if(isset($_POST['updateclient'])) {

    $id = $_POST['client_id'];

    $date_creation = $connection->real_escape_string($_POST['date_creation']);
    $date_cloture = $connection->real_escape_string($_POST['date_cloture']);
    $description = $connection->real_escape_string($_POST['description']);
    $type_appelant = $connection->real_escape_string($_POST['type_appelant']);
    $mode_interv = $connection->real_escape_string($_POST['mode_interv']);
    $type_interv = $connection->real_escape_string($_POST['type_interv']);
    $langue = $connection->real_escape_string($_POST['langue']);
    $duree = $connection->real_escape_string($_POST['duree']);
    $ref_par = $connection->real_escape_string($_POST['ref_par']);
    $date_arrivee = $connection->real_escape_string($_POST['date_arrivee']);
    $sexe = $connection->real_escape_string($_POST['sexe']);
    $age = $connection->real_escape_string($_POST['age']);
    $situ_finance = $connection->real_escape_string($_POST['situ_finance']);
    $origine = $connection->real_escape_string($_POST['origine']);
    $status_canada = $connection->real_escape_string($_POST['status_canada']);
    $prob_mentale = $connection->real_escape_string($_POST['prob_mentale']);
    $etat_civil = $connection->real_escape_string($_POST['etat_civil']);
    $nbr_enfant = $connection->real_escape_string($_POST['nbr_enfant']);
    $psy_apres_interv = $connection->real_escape_string($_POST['psy_apres_interv']);
    $psy_avant_interv = $connection->real_escape_string($_POST['psy_avant_interv']);
    $motif_consult = $connection->real_escape_string($_POST['motif_consult']);

    if($date_cloture != '') {
        $query = "UPDATE client SET date_creation='$date_creation', date_cloture='$date_cloture', description='$description', type_appelant='$type_appelant', mode_interv='$mode_interv', type_interv='$type_interv', langue='$langue', duree='$duree', ref_par='$ref_par', date_arrivee='$date_arrivee', sexe='$sexe', age='$age', situ_finance='$situ_finance', origine='$origine', status_canada='$status_canada', prob_mentale='$prob_mentale', etat_civil='$etat_civil', nbr_enfant='$nbr_enfant', psy_apres_interv='$psy_apres_interv', psy_avant_interv='$psy_avant_interv', motif_consult='$motif_consult' WHERE id='$id'";
    } else {
        $query = "UPDATE client SET date_creation='$date_creation',  description='$description', type_appelant='$type_appelant', mode_interv='$mode_interv', type_interv='$type_interv', langue='$langue', duree='$duree', ref_par='$ref_par', date_arrivee='$date_arrivee', sexe='$sexe', age='$age', situ_finance='$situ_finance', origine='$origine', status_canada='$status_canada', prob_mentale='$prob_mentale', etat_civil='$etat_civil', nbr_enfant='$nbr_enfant', psy_apres_interv='$psy_apres_interv', psy_avant_interv='$psy_avant_interv', motif_consult='$motif_consult' WHERE id='$id'";
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