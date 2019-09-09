<?php

$server = "localhost";
$username = "root";
$password = "";
$dbname = "accounts";

//create connection
$conn = new mysqli($server, $username, $password, $dbname);

// check connection
if($conn->connect_error){
	die("Connection fail:". $conn->connect_error);
}

?>