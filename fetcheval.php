<?php
session_start();
$con=mysqli_connect("localhost", "root", "", "accounts")
or die("connection failed".mysqli_errno());
$columns = array('id','id_interv','interv','trimestre','annee','note','comm');
$request=$_REQUEST;
$col =array(
    0   =>  'id',
    1   =>  'id_interv',
    2   =>  'interv',
    3   =>  'trimestre',
    4   =>  'annee',
    5   =>  'note',
    6   =>  'comm'
);  //create column like table in database

$sql = "SELECT * FROM evaluation";

$query=mysqli_query($con,$sql);
$totalData=mysqli_num_rows($query);
$totalFilter=$totalData;
//Search

$sql = "SELECT * FROM evaluation WHERE 1=1";

if(isset($_POST["search"]["value"])){
    $sql.=" AND (id Like '".$_POST["search"]["value"]."%' ";
    $sql.=" OR id_interv Like '".$_POST["search"]["value"]."%' ";
    $sql.=" OR interv Like '".$_POST["search"]["value"]."%' ";
    $sql.=" OR trimestre Like '".$_POST["search"]["value"]."%' ";
    $sql.=" OR annee Like '".$_POST["search"]["value"]."%' ";
    $sql.=" OR note Like '".$_POST["search"]["value"]."%' ";
    $sql.=" OR comm Like '".$_POST["search"]["value"]."%' )";
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
    $subdata[]=$row[1];  //id_interv
    $subdata[]=$row[2];  //interv
    $subdata[]=$row[3];  //trimestre
    $subdata[]=$row[4];  //annee
    $subdata[]=$row[5];  //note
    $subdata[]=$row[6];  //comm
    $subdata[]='<button type="button" name="edit" data-toggle="modal" data-target="#editevalmodal" class="btn btn-primary editbtn" id="'.$row["id"].'">Edit</button>
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