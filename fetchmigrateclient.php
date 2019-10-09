<?php
session_start();

$connection = mysqli_connect("localhost","root","");
$db = mysqli_select_db($connection,'accounts');


//query to get data from the table
$query = "select id, id_interv, interv, date_creation, date_cloture from client";

//execute query
$result = mysqli_query($connection, $query) or die(mysqli_error());

$data = array();

while($row = mysqli_fetch_array($result)) {

    if ($row['date_cloture'] == NULL) {

        $data [] = array(
            $row['id'], $row['id'], $row['id_interv'], $row['interv'], $row['date_creation'], 'NULL'
        );
    } else {
        $data [] = array(
            $row['id'], $row['id'], $row['id_interv'], $row['interv'], $row['date_creation'], $row['date_cloture']
        );
    }


}

$json_data=array(
    "data"  =>  $data
);

echo json_encode($json_data);
?>