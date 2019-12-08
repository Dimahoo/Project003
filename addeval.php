<?php
session_start();
$connection = mysqli_connect("localhost","root","");
$db = mysqli_select_db($connection,'accounts');

$year = date('Y');

if(isset($_POST['addeval'])) {

    $id_interv = $_POST["interv"];
    $trim = $_POST['trim'];
    $note = $_POST['note'];
    $comm = $connection->real_escape_string($_POST['comment']);

    $query = "SELECT id FROM evaluation WHERE id_interv='$id_interv' AND trimestre='$trim' AND annee='$year'";
    $result = mysqli_query($connection, $query);
    if(mysqli_num_rows($result) == 0) {

        $query = "SELECT username FROM users WHERE id='$id_interv'";
        $result = mysqli_query($connection, $query);
        $row = $result->fetch_assoc();
        $interv = $row["username"];

        $query = "INSERT INTO evaluation (id_interv,
                                    interv,
                                    trimestre,
                                    Annee,
                                    note,
                                    comm)
                                  VALUES ('$id_interv',
                                          '$interv', 
                                          '$trim',
                                          '$year',
                                          '$note',
                                          '$comm')";

        $query_run = mysqli_query($connection, $query);

        if ($query_run) {

            $_SESSION['addeval'] = 1;
            header("location:evalinterv.php");
        } else {

            echo "Error: " . $query . "<br>" . $connection->error;
            //echo '<script> alert("Fiche non ajoutee"); </script>';
        }
    } else {

        $_SESSION['existeval'] = 1;
        header("location:evalinterv.php");

    }
}
?>