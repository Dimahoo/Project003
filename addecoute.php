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

$month = date('m');
$day = date('d');
$year = date('Y');

$today = $year . '-' . $month . '-' . $day;

if(!isset($_POST['new_client']))
{
    $new_client = 'yes';
    $id_client = '';
} else {
    $new_client = 'no';
    $id_client = $_POST['id_client'];
}

// Get id & Name of the intervenant
$id_interv = $_SESSION['id'];
$query = "SELECT username FROM users WHERE id='$_SESSION[id]'";
$result = mysqli_query($mysqli, $query);
$row = $result->fetch_assoc();
$name_interv = $row["username"];

if(isset($_POST['validate'])) {

// Now we check if the data from the create form was submitted, isset() will check if the data exists.

    if ($new_client == 'no') {

        // Check if ID_CLIENT exist in CLIENT table
        $id_client = $_POST['id_client'];
        $query = "SELECT id FROM client WHERE id=$id_client AND id_interv='$id_interv'";
        $result = mysqli_query($mysqli, $query);
        if(mysqli_num_rows($result) == 0){

            $_SESSION['cli_exist'] = 1;
            header("location:ecoute.php");
        } else {

            // Check if ID_CLIENT exist in RDV table
            $query = "SELECT id_cli FROM rdv WHERE id_cli='$id_client'";
            $result = mysqli_query($mysqli, $query);
            if(mysqli_num_rows($result) == 0){

                $_SESSION['cli_exist'] = 2;
                header("location:ecoute.php");
            }
        }
    } else {

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



        $query = "INSERT INTO client (date_creation, 
                                      id_interv, 
                                      interv,
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
                              VALUES ('$today',
                                      '$id_interv',
                                      '$name_interv',
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
        $id_client = mysqli_insert_id($mysqli);
    }


    if ($_SESSION['cli_exist'] != 1) {

        $query = "SELECT username FROM users WHERE id='$_SESSION[id]'";
        $result = mysqli_query($mysqli, $query);
        $row = $result->fetch_assoc();

        $id_cli = $id_client;
        $date_rdv = $mysqli->real_escape_string($_POST['date_rdv']);
        if ($_POST['ecoute'] == 'yes') {

            $type = 'Ecoute';
        } else {

            $type = 'Suivi';
        }


        $query = "INSERT INTO rdv (id_interv,
                                   interv,
                                   id_cli,
                                   date_rdv,
                                   type)
                           VALUES ('$id_interv',
                                   '$name_interv', 
                                   '$id_cli',
                                   '$date_rdv',
                                   '$type')";

        $query_run = mysqli_query($mysqli, $query);

        if ($query_run) {
            $_SESSION['addecoute'] = 1;
            header("location:home.php");
        } else {
            echo "Error: " . $query . "<br>" . $mysqli->error;
            //echo '<script> alert("Fiche non ajoutee"); </script>';
        }
    }
}
?>