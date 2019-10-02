<?php
session_start();
$con=mysqli_connect("localhost", "root", "", "accounts")
or die("connection failed".mysqli_errno());
$columns = array('id','date_entree','role','nom','prenom','sexe','tache');
$request=$_REQUEST;
$col =array(
    0   =>  'id',
    1   =>  'date_entree',
    2   =>  'role',
    3   =>  'nom',
    4   =>  'prenom',
    5   =>  'sexe',
    6   =>  'tache'
);  //create column like table in database

$sql = "SELECT * FROM benevole";

$query=mysqli_query($con,$sql);
$totalData=mysqli_num_rows($query);
$totalFilter=$totalData;
//Search

$sql = "SELECT * FROM benevole WHERE 1=1";

if(isset($_POST["search"]["value"])){
    $sql.=" AND (id Like '".$_POST["search"]["value"]."%' ";
    $sql.=" OR date_entree Like '".$_POST["search"]["value"]."%' ";
    $sql.=" OR role Like '".$_POST["search"]["value"]."%' ";
    $sql.=" OR nom Like '".$_POST["search"]["value"]."%' ";
    $sql.=" OR prenom Like '".$_POST["search"]["value"]."%' ";
    $sql.=" OR sexe Like '".$_POST["search"]["value"]."%' ";
    $sql.=" OR tache Like '".$_POST["search"]["value"]."%' )";
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
    $subdata[]=$row[1];  //date_entree
    $subdata[]=$row[2];  //role
    $subdata[]=$row[3];  //nom
    $subdata[]=$row[4];  //prenom
    $subdata[]=$row[5];  //sexe
    $subdata[]=$row[6];  //tache
    $subdata[]='<button type="button" name="edit" data-toggle="modal" data-target="#editbenemodal" class="btn btn-primary editbtn" id="'.$row["id"].'">Edit</button>
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