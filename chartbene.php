<?php
$connection = mysqli_connect("localhost","root","");
$db = mysqli_select_db($connection,'accounts');


//query to get data from the table
$query = "select role, count(*) as count from benevole group by role order by id asc";

//execute query
$result = mysqli_query($connection,$query) or die(mysqli_error());

//loop through the returned data
$rolevalues1 = array();
while($row = mysqli_fetch_array($result)) {
    $rolevalues[] = array(
      'label'   =>  $row["role"],
      'value'   =>  $row["count"]
    );
}

//free memory associated with result
$result->close();

//close connection
$connection->close();

//now print the data
echo json_encode($rolevalues1);