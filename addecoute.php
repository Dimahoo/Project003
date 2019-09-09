<?php
session_start();

// Change this to your connection info.
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'accounts';
// connect using the info above.
$mysqli = new mysqli($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysql->connect_error);
}



if(isset($_POST['validate'])) {

// Now we check if the data from the create form was submitted, isset() will check if the data exists.

    $id_interv = $_SESSION['id'];
    $date_inscription = $mysqli->real_escape_string($_POST['date_inscription']);
    $description = $mysqli->real_escape_string($_POST['description']);
    $type_appelant = $mysqli->real_escape_string($_POST['type_appelant']);
    $mode_interv = $mysqli->real_escape_string($_POST['mode_interv']);
    $type_interv = $mysqli->real_escape_string($_POST['type_interv']);
    $langue = $mysqli->real_escape_string($_POST['langue']);
    $duree = $mysqli->real_escape_string($_POST['duree']);
    $ref_par = $mysqli->real_escape_string($_POST['ref_par']);
    $date_arrivee = $mysqli->real_escape_string($_POST['date_arrivee']);
    $sexe = $mysqli->real_escape_string($_POST['sexe']);
    $age = $mysqli->real_escape_string($_POST['age']);
    $situ_finance = $mysqli->real_escape_string($_POST['situ_finance']);
    $origine = $mysqli->real_escape_string($_POST['origine']);
    $status_canada = $mysqli->real_escape_string($_POST['status_canada']);
    $prob_mentale = $mysqli->real_escape_string($_POST['prob_mentale']);
    $etat_civil = $mysqli->real_escape_string($_POST['etat_civil']);
    $nbr_enfant = $mysqli->real_escape_string($_POST['nbr_enfant']);
    $psy_apres_interv = $mysqli->real_escape_string($_POST['psy_apres_interv']);
    $psy_avant_interv = $mysqli->real_escape_string($_POST['psy_avant_interv']);
    $motif_consult = $mysqli->real_escape_string($_POST['motif_consult']);

    $query = "INSERT INTO rdv (id_interv,
                               date_inscription,
                               description,
                               type_appelant,
                               mode_interv,
                               type_interv,
                               langue,
                               duree,
                               ref_par,
                               date_arrivee,
                               sexe,
                               age,
                               situ_finance,
                               origine,
                               status_canada,
                               prob_mentale,
                               etat_civil,
                               nbr_enfant,
                               psy_apres_interv,
                               psy_avant_interv,
                               motif_consult)
                       VALUES ('$id_interv',
                               '$date_inscription',
                               '$description',
                               '$type_appelant',
                               '$mode_interv',
                               '$type_interv',
                               '$langue',
                               '$duree',
                               '$ref_par',
                               '$date_arrivee',
                               '$sexe',
                               '$age',
                               '$situ_finance',
                               '$origine',
                               '$status_canada',
                               '$prob_mentale',
                               '$etat_civil',
                               '$nbr_enfant',
                               '$psy_apres_interv',
                               '$psy_avant_interv',
                               '$motif_consult')";

    $query_run = mysqli_query($mysqli, $query);

    if ($query_run) {
        $_SESSION['addecoute'] = 1;
        header("location:home.php");
    } else {
         echo "Error: " . $query . "<br>" . $mysqli->error;
        //echo '<script> alert("Fiche non ajoutee"); </script>';
    }
}