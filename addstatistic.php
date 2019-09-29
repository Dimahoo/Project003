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

        $date_ajout = $mysqli->real_escape_string($_POST['date_ajout']);
        $description = $mysqli->real_escape_string($_POST['description']);
        $sexe = $mysqli->real_escape_string($_POST['sexe']);
        $origine = $mysqli->real_escape_string($_POST['origine']);
        $langue = $mysqli->real_escape_string($_POST['langue']);
        $mode_interv = $mysqli->real_escape_string($_POST['mode_interv']);

        $query = "INSERT INTO statis (date_ajout,
                                      description,
                                      sexe,
                                      origine,
                                      langue,
                                      mode_interv)
                              VALUES ('$date_ajout',
                                      '$description', 
                                      '$sexe',
                                      '$origine',
                                      '$langue',
                                      '$mode_interv')";

        $query_run = mysqli_query($mysqli, $query);

        if ($query_run) {
            $_SESSION['addstatis'] = 1;
            header("location:home.php");
        } else {
            echo "Error: " . $query . "<br>" . $mysqli->error;
            //echo '<script> alert("Fiche non ajoutee"); </script>';
        }
}
?>