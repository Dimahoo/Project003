<?php
session_start();
$con=mysqli_connect("localhost", "root", "", "accounts")
or die("connection failed".mysqli_errno());
$columns = array('id','id_interv','interv','date_creation','date_cloture','description','type_appelant','mode_interv','type_interv','langue','duree','ref_par','date_arrivee','sexe','age','situ_finance','origine','status_canada','prob_mentale','etat_civil','nbr_enfant','psy_apres_interv','psy_avant_interv','motif_consult');
$request=$_REQUEST;
$col =array(
    0   =>  'id',
    1   =>  'id_interv',
    2   =>  'interv',
    3   =>  'date_creation',
    4   =>  'date_cloture',
    5   =>  'description',
    6   =>  'type_appelant',
    7   =>  'mode_interv',
    8   =>  'type_interv',
    9   =>  'langue',
    10   =>  'duree',
    11   =>  'ref_par',
    12   =>  'date_arrivee',
    13   =>  'sexe',
    14   =>  'age',
    15   =>  'situ_finance',
    16   =>  'origine',
    17   =>  'status_canada',
    18   =>  'prob_mentale',
    19   =>  'etat_civil',
    20   =>  'nbr_enfant',
    21   =>  'psy_apres_interv',
    22   =>  'psy_avant_interv',
    23   =>  'motif_consult'
);  //create column like table in database
if($_SESSION['admin'] == 1) {
    $sql = "SELECT * FROM client";
} else {
    $id_interv = $_SESSION['id'];
    $sql = "SELECT * FROM client WHERE id_interv = '$id_interv'";
}

$query=mysqli_query($con,$sql);
$totalData=mysqli_num_rows($query);
$totalFilter=$totalData;
//Search

if($_SESSION['admin'] == 1) {
    $sql = "SELECT * FROM client WHERE 1=1";
} else {
    $sql = "SELECT * FROM client WHERE 1=1 AND id_interv = '$id_interv'";
}

if(isset($_POST["search"]["value"])){
    $sql.=" AND (id Like '".$_POST["search"]["value"]."%' ";
    $sql.=" OR id_interv Like '".$_POST["search"]["value"]."%' ";
    $sql.=" OR interv Like '".$_POST["search"]["value"]."%' ";
    $sql.=" OR date_creation Like '".$_POST["search"]["value"]."%' ";
    $sql.=" OR date_cloture Like '".$_POST["search"]["value"]."%' ";
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
    $subdata[]=$row[0];  //id
    $subdata[]=$row[1];  //id_interv
    $subdata[]=$row[2];  //interv
    $subdata[]=$row[3];  //date_creation
    if($row[4] == '')
    {
        $subdata[]='N/A';  //date_cloture
    } else {
        $subdata[]=$row[4];  //date_cloture
    }
    $subdata[]=$row[5];  //description
    $subdata[]=$row[6];  //type_appelant
    $subdata[]=$row[7];  //mode_interv
    $subdata[]=$row[8];  //type_interv
    $subdata[]=$row[9];   //langue
    $subdata[]=$row[10]; //duree
    $subdata[]=$row[11]; //ref_par
    $subdata[]=$row[12]; //date_arrivee
    $subdata[]=$row[13]; //sexe
    $subdata[]=$row[14]; //age
    $subdata[]=$row[15]; //situ_finance
    $subdata[]=$row[16]; //origine
    $subdata[]=$row[17]; //status_canada
    $subdata[]=$row[18]; //prob_mentale
    $subdata[]=$row[19]; //etat_civil
    $subdata[]=$row[20]; //nbr_enfant
    $subdata[]=$row[21]; //psy_apres_interv
    $subdata[]=$row[22]; //psy_avant_interv
    $subdata[]=$row[23]; //motif_consult
    $subdata[]='<button type="button" name="edit" data-toggle="modal" data-target="#editclientmodal" class="btn btn-primary editbtn" id="'.$row["id"].'">Edit</button>
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