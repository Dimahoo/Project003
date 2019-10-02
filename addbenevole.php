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

        $date_entree = $mysqli->real_escape_string($_POST['date_entree']);
        $role = $mysqli->real_escape_string($_POST['role']);
        $nom = $mysqli->real_escape_string($_POST['nom']);
        $prenom = $mysqli->real_escape_string($_POST['prenom']);
        $sexe = $mysqli->real_escape_string($_POST['sexe']);
        $tache = $mysqli->real_escape_string($_POST['tache']);

        $query = "INSERT INTO benevole (date_entree,
                                        role,
                                        nom,
                                        prenom,
                                        sexe,
                                        tache)
                               VALUES ('$date_entree',
                                       '$role', 
                                       '$nom',
                                       '$prenom',
                                       '$sexe',
                                       '$tache')";

        $query_run = mysqli_query($mysqli, $query);

        if ($query_run) {
            $_SESSION['addbene'] = 1;
            header("location:home.php");
        } else {
            echo "Error: " . $query . "<br>" . $mysqli->error;
            //echo '<script> alert("Fiche non ajoutee"); </script>';
        }
}
?>