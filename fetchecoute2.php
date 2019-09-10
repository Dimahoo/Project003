<?php
$con=mysqli_connect("localhost", "root", "", "accounts")
or die("connection failed".mysqli_errno());
$columns = array('id','id_interv','id_cli','date_inscription','description','type_appelant','mode_interv','type_interv','langue','duree','ref_par','date_arrivee','sexe','age','situ_finance','origine','status_canada','prob_mentale','etat_civil','nbr_enfant','psy_apres_interv','psy_avant_interv','motif_consult');
$request=$_REQUEST;
$col =array(
    0   =>  'id',
    1   =>  'id_interv',
    2   =>  'id_cli',
    3   =>  'date_inscription',
    4   =>  'description',
    5   =>  'type_appelant',
    6   =>  'mode_interv',
    7   =>  'type_interv',
    8   =>  'langue',
    9   =>  'duree',
    10   =>  'ref_par',
    11   =>  'date_arrivee',
    12   =>  'sexe',
    13   =>  'age',
    14   =>  'situ_finance',
    15   =>  'origine',
    16   =>  'status_canada',
    17   =>  'prob_mentale',
    18   =>  'etat_civil',
    19   =>  'nbr_enfant',
    20   =>  'psy_apres_interv',
    21   =>  'psy_avant_interv',
    22   =>  'motif_consult'

);  //create column like table in database
$sql ="SELECT * FROM rdv";
$query=mysqli_query($con,$sql);
$totalData=mysqli_num_rows($query);
$totalFilter=$totalData;
//Search
$sql ="SELECT * FROM rdv WHERE 1=1";
if(isset($_POST["search"]["value"])){
    $sql.=" AND (id Like '".$_POST["search"]["value"]."%' ";
    $sql.=" OR id_interv Like '".$_POST["search"]["value"]."%' ";
    $sql.=" OR id_cli Like '".$_POST["search"]["value"]."%' ";
    $sql.=" OR date_inscription Like '".$_POST["search"]["value"]."%' ";
    $sql.=" OR description Like '".$_POST["search"]["value"]."%' ";
    $sql.=" OR type_appelant Like '".$_POST["search"]["value"]."%' ";
    $sql.=" OR mode_interv Like '".$_POST["search"]["value"]."%' ";
    $sql.=" OR type_interv Like '".$_POST["search"]["value"]."%' ";
    $sql.=" OR langue Like '".$_POST["search"]["value"]."%' ";
    $sql.=" OR duree Like '".$_POST["search"]["value"]."%' ";
    $sql.=" OR ref_par Like '".$_POST["search"]["value"]."%' ";
    $sql.=" OR date_arrivee Like '".$_POST["search"]["value"]."%' ";
    $sql.=" OR sexe Like '".$_POST["search"]["value"]."%' ";
    $sql.=" OR age Like '".$_POST["search"]["value"]."%' ";
    $sql.=" OR situ_finance Like '".$_POST["search"]["value"]."%' ";
    $sql.=" OR origine Like '".$_POST["search"]["value"]."%' ";
    $sql.=" OR status_canada Like '".$_POST["search"]["value"]."%' ";
    $sql.=" OR prob_mentale Like '".$_POST["search"]["value"]."%' ";
    $sql.=" OR etat_civil Like '".$_POST["search"]["value"]."%' ";
    $sql.=" OR nbr_enfant Like '".$_POST["search"]["value"]."%' ";
    $sql.=" OR psy_apres_interv Like '".$_POST["search"]["value"]."%' ";
    $sql.=" OR psy_avant_interv Like '".$_POST["search"]["value"]."%' ";
    $sql.=" OR motif_consult Like '".$_POST["search"]["value"]."%' )";
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
    $subdata[]=$row[0]; //id
    $subdata[]=$row[1]; //name
    $subdata[]=$row[2]; //salary
    $subdata[]=$row[3]; //age
    $subdata[]=$row[4]; //age
    $subdata[]=$row[5]; //age
    $subdata[]=$row[6]; //age
    $subdata[]=$row[7]; //age
    $subdata[]=$row[8]; //age
    $subdata[]=$row[9]; //age
    $subdata[]=$row[10]; //age
    $subdata[]=$row[11]; //age
    $subdata[]=$row[12]; //age
    $subdata[]=$row[13]; //age
    $subdata[]=$row[14]; //age
    $subdata[]=$row[15]; //age
    $subdata[]=$row[16]; //age
    $subdata[]=$row[17]; //age
    $subdata[]=$row[18]; //age
    $subdata[]=$row[19]; //age
    $subdata[]=$row[20]; //age
    $subdata[]=$row[21]; //age
    $subdata[]=$row[22]; //age
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