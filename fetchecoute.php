<?php
$connect = mysqli_connect("localhost", "root", "", "accounts");
$columns = array('id','id_interv','id_cli','date_inscription','description','type_appelant','mode_interv','type_interv','langue','duree','ref_par','date_arrivee','sexe','age','situ_finance','origine','status_canada','prob_mentale','etat_civil','nbr_enfant','psy_apres_interv','psy_avant_interv','motif_consult');

$query = "SELECT * FROM rdv";

if(isset($_POST["search"]["value"]))
{
    $query .= '
 WHERE id_interv LIKE "%'.$_POST["search"]["value"].'%" 
 OR id_cli LIKE "%'.$_POST["search"]["value"].'%"
 OR date_inscription LIKE "%'.$_POST["search"]["value"].'%"
 OR description LIKE "%'.$_POST["search"]["value"].'%"
 OR type_appelant LIKE "%'.$_POST["search"]["value"].'%"
 OR mode_interv LIKE "%'.$_POST["search"]["value"].'%"
 OR type_interv LIKE "%'.$_POST["search"]["value"].'%"
 OR langue LIKE "%'.$_POST["search"]["value"].'%"
 OR duree LIKE "%'.$_POST["search"]["value"].'%"
 OR ref_par LIKE "%'.$_POST["search"]["value"].'%"
 OR date_arrivee LIKE "%'.$_POST["search"]["value"].'%"
 OR sexe LIKE "%'.$_POST["search"]["value"].'%"
 OR age LIKE "%'.$_POST["search"]["value"].'%"
 OR situ_finance LIKE "%'.$_POST["search"]["value"].'%"
 OR origine LIKE "%'.$_POST["search"]["value"].'%"
 OR status_canada LIKE "%'.$_POST["search"]["value"].'%"
 OR prob_mentale LIKE "%'.$_POST["search"]["value"].'%"
 OR etat_civil LIKE "%'.$_POST["search"]["value"].'%"
 OR nbr_enfant LIKE "%'.$_POST["search"]["value"].'%"
 OR psy_apres_interv LIKE "%'.$_POST["search"]["value"].'%"
 OR psy_avant_interv LIKE"%'.$_POST["search"]["value"].'%"
 OR motif_consult LIKE "%'.$_POST["search"]["value"].'%"
 ';
}

if(isset($_POST["order"]))
{
    $query .= 'ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' 
 ';
}
else
{
    $query .= 'ORDER BY id DESC ';
}

$query1 = '';

if($_POST["length"] != -1)
{
    $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$number_filter_row = mysqli_num_rows(mysqli_query($connect, $query));

$result = mysqli_query($connect, $query . $query1);

$data = array();

while($row = mysqli_fetch_array($result))
{
    $sub_array = array();
    $sub_array[] = '<div class="update" data-id="'.$row["id"].'" data-column="id">' . $row["id"] . '</div>';
    $sub_array[] = '<div class="update" data-id="'.$row["id"].'" data-column="id_interv">' . $row["id_interv"] . '</div>';
    $sub_array[] = '<div class="update" data-id="'.$row["id"].'" data-column="id_cli">' . $row["id_cli"] . '</div>';
    $sub_array[] = '<div class="date" data-id="'.$row["id"].'" data-column="date_inscription">' . $row["date_inscription"] . '</div>';
    $sub_array[] = '<div class="update" data-id="'.$row["id"].'" data-column="description">' . $row["description"] . '</div>';
    $sub_array[] = '<div class="update" data-id="'.$row["id"].'" data-column="type_appelant">' . $row["type_appelant"] . '</div>';
    $sub_array[] = '<div class="update" data-id="'.$row["id"].'" data-column="mode_interv">' . $row["mode_interv"] . '</div>';
    $sub_array[] = '<div class="update" data-id="'.$row["id"].'" data-column="type_interv">' . $row["type_interv"] . '</div>';
    $sub_array[] = '<div class="update" data-id="'.$row["id"].'" data-column="langue">' . $row["langue"] . '</div>';
    $sub_array[] = '<div class="update" data-id="'.$row["id"].'" data-column="duree">' . $row["duree"] . '</div>';
    $sub_array[] = '<div class="update" data-id="'.$row["id"].'" data-column="ref_par">' . $row["ref_par"] . '</div>';
    $sub_array[] = '<div class="update" data-id="'.$row["id"].'" data-column="date_arrivee">' . $row["date_arrivee"] . '</div>';
    $sub_array[] = '<div class="update" data-id="'.$row["id"].'" data-column="sexe">' . $row["sexe"] . '</div>';
    $sub_array[] = '<div class="update" data-id="'.$row["id"].'" data-column="age">' . $row["age"] . '</div>';
    $sub_array[] = '<div class="update" data-id="'.$row["id"].'" data-column="situ_finance">' . $row["situ_finance"] . '</div>';
    $sub_array[] = '<div class="update" data-id="'.$row["id"].'" data-column="origine">' . $row["origine"] . '</div>';
    $sub_array[] = '<div class="update" data-id="'.$row["id"].'" data-column="status_canada">' . $row["status_canada"] . '</div>';
    $sub_array[] = '<div class="update" data-id="'.$row["id"].'" data-column="prob_mentale">' . $row["prob_mentale"] . '</div>';
    $sub_array[] = '<div class="update" data-id="'.$row["id"].'" data-column="etat_civil">' . $row["etat_civil"] . '</div>';
    $sub_array[] = '<div class="update" data-id="'.$row["id"].'" data-column="nbr_enfant">' . $row["nbr_enfant"] . '</div>';
    $sub_array[] = '<div class="update" data-id="'.$row["id"].'" data-column="psy_apres_interv">' . $row["psy_apres_interv"] . '</div>';
    $sub_array[] = '<div class="update" data-id="'.$row["id"].'" data-column="psy_avant_interv">' . $row["psy_avant_interv"] . '</div>';
    $sub_array[] = '<div class="update" data-id="'.$row["id"].'" data-column="motif_consult">' . $row["motif_consult"] . '</div>';
    $sub_array[] = '<button type="button" name="edit" class="btn btn-success editbtn" id="'.$row["id"].'">Edit</button>
                    <button type="button" name="Delete" class="btn btn-success deletebtn" id="'.$row["id"].'">Delete</button>';
    $data[] = $sub_array;
}

function get_all_data($connect)
{
    $query = "SELECT * FROM rdv";
    $result = mysqli_query($connect, $query);
    return mysqli_num_rows($result);
}

$output = array(
    "draw"    => intval($_POST["draw"]),
    "recordsTotal"  =>  get_all_data($connect),
    "recordsFiltered" => $number_filter_row,
    "data"    => $data
);

echo json_encode($output);

?>
