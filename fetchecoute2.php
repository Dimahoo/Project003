<?php
session_start();
$con=mysqli_connect("localhost", "root", "", "accounts")
or die("connection failed".mysqli_errno());
$columns = array('id','interv','id_cli','date_rdv');
$request=$_REQUEST;
$col =array(
    0   =>  'id',
    1   =>  'interv',
    2   =>  'id_cli',
    3   =>  'date_rdv'
);  //create column like table in database
if($_SESSION['admin'] == 1) {
    $sql = "SELECT * FROM rdv";
} else {
    $id_interv = $_SESSION['id'];
    $sql = "SELECT * FROM rdv WHERE id_interv = '$id_interv'";
}

$query=mysqli_query($con,$sql);
$totalData=mysqli_num_rows($query) - 1;
$totalFilter=$totalData;
//Search
if($_SESSION['admin'] == 1) {
    $sql = "SELECT * FROM rdv WHERE 1=1";
} else {
    $sql = "SELECT * FROM rdv WHERE 1=1 AND id_interv = '$id_interv'";
}
if(isset($_POST["search"]["value"])){
    $sql.=" AND (id Like '".$_POST["search"]["value"]."%' ";
    $sql.=" OR interv Like '".$_POST["search"]["value"]."%' ";
    $sql.=" OR id_cli Like '".$_POST["search"]["value"]."%' ";
    $sql.=" OR date_rdv Like '".$_POST["search"]["value"]."%' )";
}
$query=mysqli_query($con,$sql);
$totalData=mysqli_num_rows($query);
//Order
if(isset($_POST["order"]))
{
    $sql .= 'ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' 
 ';
}
else
{
    $sql .= 'ORDER BY id DESC ';
}

$sql1 = '';

if($_POST["length"] != -1)
{
    $sql1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}


$query=mysqli_query($con,$sql . $sql1);
$data=array();
while($row=mysqli_fetch_array($query)){
    $subdata=array();
    $subdata[]=$row[0];  //id
    $subdata[]=$row[2];  //interv
    $subdata[]=$row[3];  //id_cli
    $subdata[]=$row[4];  //date_rdv
    $subdata[]='<button type="button" name="edit" data-toggle="modal" data-target="#editecoutemodal" class="btn btn-primary editbtn" id="'.$row["id"].'">Edit</button>
                <button type="button" name="delete" class="btn btn-danger delete" id="'.$row["id"].'">Delete</button>';//buttons
    $data[]=$subdata;
}
$json_data=array(
    "draw"              =>  intval($_POST["draw"]),
    "recordsTotal"      =>  intval($totalData),
    "recordsFiltered"   =>  intval($totalFilter),
    "data"              =>  $data
);
echo json_encode($json_data);
?>