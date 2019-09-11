<?php
// We need to use sessions, so you should always start sessions using the below code.
include 'function.php';
//include 'config.php';
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit();
}
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'accounts';

// connect using the info above.
$mysqli = new mysqli($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

$username = $mysqli->real_escape_string($_SESSION['name']);

//Query the database for user
$sql = $mysqli->query("SELECT * FROM users") or die($mysqli->error);

$month = date('m');
$day = date('d');
$year = date('Y');

$today = $year . '-' . $month . '-' . $day;

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile Page</title>
    <link href="listecoute.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <!--<link href="css/dataTables.bootstrap.min.css" rel="stylesheet" />-->
    <link href="css/fixedColumns.dataTables.min.css" rel="stylesheet" />
    <link href="css/fixedColumns.bootstrap.min.css" rel="stylesheet" />
    <link href="css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="css/buttons.dataTables.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" />
    <link href="css/font-awesome.css" rel="stylesheet" />
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/popper.min.js"></script>
    <!--<script src="js/dataTables.bootstrap.min.js"></script>-->
    <script src="js/dataTables.fixedColumns.min.js"></script>
    <script src="js/dataTables.buttons.min.js"></script>
    <script src="js/buttons.flash.min.js"></script>
    <script src="js/jszip.min.js"></script>
    <script src="js/pdfmake.min.js"></script>
    <script src="js/vfs_fonts.js"></script>
    <!--<script src="js/buttons.html5.min.js"></script>-->
    <script src="js/buttons.print.min.js"></script>


</head>
<script>
    if ('<?php echo $_SESSION['editecoute']?>' == 1) {
        alert("Modification effectuee!");
        <?php $_SESSION['editecoute'] = 0 ?>
    }
</script>
<body class="loggedin">
<nav class="navtop">
    <p>Website Title</p>
    <ul>
        <li><a href="home.php"><i class="fas fa-home"></i> Home</a></li>
        <li></li>
        <li></li>
        <?php if($_SESSION['admin'] == 1) {?>
            <li><a href="#"><i class="fa fa-arrow-down"></i> Manage profile</a>
                <ul>
                    <li><a href="create.php">Create</a></li>
                    <li><a href="modify.php">Modify</a></li>
                    <li><a href="delete.php">Delete</a></li>
                </ul>
            </li>
        <?php }?>
        <li>
            <a href="profile.php"><i class="fas fa-user-circle"></i> <?=$_SESSION['name']?>  Profile</a>
        </li>
        <li>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
        </li>
    </ul>
</nav>

</br>
<div class="container">
    <div class="jumbotron">
        <div class="card">
            <h2 align="left">Liste des Ecoutes & Suivis</h2>
        </div>
        <div class="card">
            <div class="card-body">
                <table id="datatableid" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Intervenant</th>
                        <th>Client</th>
                        <th>Date d'inscription</th>
                        <th>Description</th>
                        <th>Type d'appelant</th>
                        <th>Mode d'intervention</th>
                        <th>Type d'intervention</th>
                        <th>Langue</th>
                        <th>Duree</th>
                        <th>Date arrivee au Canada</th>
                        <th>Referee par</th>
                        <th>Sexe</th>
                        <th>Age</th>
                        <th>Situation financiere</th>
                        <th>Origine</th>
                        <th>Status au Canada</th>
                        <th>Probleme mentale</th>
                        <th>Etat civil</th>
                        <th>Nombre d'enfant</th>
                        <th>Etat psychologique avant intervention</th>
                        <th>Etat psychologique apres intervention</th>
                        <th>Motif consultation</th>
                        <th style="width: 110px;">Action</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade bd-example-modal-xl" id="editecoutemodal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:1300px;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Modifier fiche</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="updateecoute.php" method="post">
                <input type="hidden" name="ecoute_id" id="ecoute_id">
                <table id="example" class="ecoute" style="width:100%">
                    <!-- Row 1 -->
                    <tr>
                        <td><label>Date inscription:</label></td>
                        <td><input type="date" id="date_inscription" name="date_inscription" /></td>
                        <td><label>Description:</label></td>
                        <td>
                            <select name="description" id="description">
                                <option>test1</option>
                                <option>test2</option>
                            </select>
                        </td>
                        <td><label>Type d'appelant:</label></td>
                        <td>
                            <select name="type_appelant" id="type_appelant">
                                <option>test1</option>
                            </select>
                        </td>
                    </tr>
                    <!-- Row2 -->
                    <tr>
                        <td><label>Mode d'intervention:</label></td>
                        <td>
                            <select name="mode_interv" id="mode_interv">
                                <option>test1</option>
                            </select>
                        </td>
                        <td><label>Type d'intervention:</label></td>
                        <td>
                            <select name="type_interv" id="type_interv">
                                <option>test1</option>
                            </select>
                        </td>
                        <td><label>Langue utilisee:</label></td>
                        <td>
                            <select name="langue" id="langue">
                                <option>test1</option>
                            </select>
                        </td>
                    </tr>
                    <!-- Row3 -->
                    <tr>
                        <td><label>Duree:</label></td>
                        <td>
                            <select name="duree" id="duree">
                                <option>test1</option>
                            </select>
                        </td>
                        <td><label>Referee Par:</label></td>
                        <td>
                            <select name="ref_par" id="ref_par">
                                <option>test1</option>
                            </select>
                        </td>
                        <td><label >Date arrivee au canada:</label></td>
                        <td><input id="date_arrivee" name="date_arrivee" type="date"></td>
                    </tr>
                    <!-- Row4 -->
                    <tr>
                        <td><label>Sexe:</label></td>
                        <td>
                            <select name="sexe" id="sexe">
                                <option>test1</option>
                            </select>
                        </td>
                        <td><label>Age:</label></td>
                        <td>
                            <select name="age" id="age">
                                <option>test1</option>
                            </select>
                        </td>
                        <td><label>Situation Financiere:</label></td>
                        <td>
                            <select name="situ_finance" id="situ_finance">
                                <option>test1</option>
                            </select>
                        </td>
                    </tr>
                    <!-- Row5 -->
                    <tr>
                        <td><label>Origine:</label></td>
                        <td>
                            <select name="origine" id="origine">
                                <option>test1</option>
                            </select>
                        </td>
                        <td><label>Status au Canada:</label></td>
                        <td>
                            <select name="status_canada" id="status_canada">
                                <option>test1</option>
                            </select>
                        </td>
                        <td><label>Probleme au sante mentale:</label></td>
                        <td>
                            <select name="prob_mentale" id="prob_mentale">
                                <option>test1</option>
                            </select>
                        </td>
                    </tr>
                    <!-- Row6 -->
                    <tr>
                        <td><label>Etat civil:</label></td>
                        <td>
                            <select name="etat_civil" id="etat_civil">
                                <option>test1</option>
                            </select>
                        </td>
                        <td><label>Nombre enfants:</label></td>
                        <td>
                            <input id="nbr_enfant" name="nbr_enfant" type="number">
                        </td>
                        <td><label class="long">Etat psychologique apres l'intervention:</label></td>
                        <td>
                            <select name="psy_apres_interv" id="psy_apres_interv">
                                <option>Joyeuse</option>
                                <option>Colerique</option>
                                <option>Deprimee</option>
                                <option>Mal dans sa peau</option>
                                <option>Angoissee</option>
                                <option>Agressive</option>
                                <option>Confuse</option>
                                <option>Incoherante</option>
                                <option>Triste</option>
                                <option>Autre</option>
                            </select>
                        </td>
                    </tr>
                    <!-- Row7 -->
                    <tr>
                        <td ><label class="long" >Etat psychologique au debut de l'intervention:</label></td>
                        <td>
                            <select name="psy_avant_interv" id="psy_avant_interv">
                                <option>Joyeuse</option>
                                <option>Colerique</option>
                                <option>Deprimee</option>
                                <option>Mal dans sa peau</option>
                                <option>Angoissee</option>
                                <option>Agressive</option>
                                <option>Confuse</option>
                                <option>Incoherante</option>
                                <option>Triste</option>
                                <option>Autre</option>
                            </select>
                        </td>
                        <td><label>Motif consultation:</label></td>
                        <td>
                            <select name="motif_consult" id="motif_consult">
                                <option>Dependance</option>
                                <option>Diff d'attaptation</option>
                                <option>Problemes d'immigration</option>
                                <option>Probleme materiel</option>
                                <option>Probleme psychologique</option>
                                <option>Probleme de sante</option>
                                <option>Sexualite</option>
                                <option>Solitude</option>
                                <option>Suicide</option>
                                <option>Violance</option>
                                <option>Autre</option>
                            </select>
                        </td>
                    </tr>
                    <!-- Row7 buttons -->
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <input type="submit" name="updateecoute" value="Mettre a jour" class="btn btn-primary" />
                        </td>
                        <td>
                            <input type="button" name="cancel" value="Annuler" class="btn btn-secondary"  data-dismiss="modal" />
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>


<script>

    $(document).ready(function () {

        fetch_data();

        function fetch_data() {
            var dataTable = $('#datatableid').DataTable({
                "processing": true,
                "serverSide": true,
                "scrollX": true,
                "order": [],
                "columnDefs": [
                    { "orderable": false, "targets": 23 }
                ],
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "fixedColumns": {
                    rightColumns: 1,
                    leftColumns: 0
                },
                "dom": 'lfrtip',
                "buttons": [
                    {
                        "extend": 'excel',
                        "text": 'Exporter dans Excel',
                        "exportOptions":
                            {
                                "columns": 'th:not(:last-child)'
                            }
                    }
                ],
                "ajax": {
                    "url": 'fetchecoute2.php',
                    "type": 'POST'
                }
            });
        }

        $(document).on('click', '.editbtn', function() {

            var rdv_id = $(this).attr("id");

            $.ajax({
                url:"rdvfetchupdate.php",
                method:"POST",
                data:{rdv_id:rdv_id},
                dataType:"json",
                success:function(data){
                    $('#ecoute_id').val(data.id);
                    $('#date_inscription').val(data.date_inscription);
                    $('#description').val(data.description);
                    $('#type_appelant').val(data.type_appelant);
                    $('#mode_interv').val(data.mode_interv);
                    $('#type_interv').val(data.type_interv);
                    $('#langue').val(data.langue);
                    $('#duree').val(data.duree);
                    $('#ref_par').val(data.ref_par);
                    $('#sexe').val(data.sexe);
                    $('#age').val(data.age);
                    $('#situ_finance').val(data.situ_finance);
                    $('#origine').val(data.origine);
                    $('#status_canada').val(data.status_canada);
                    $('#prob_mentale').val(data.prob_mentale);
                    $('#etat_civil').val(data.etat_civil);
                    $('#nbr_enfant').val(data.nbr_enfant);
                    $('#psy_apres_interv').val(data.psy_apres_interv);
                    $('#psy_avant_interv').val(data.psy_avant_interv);
                    $('#motif_consult').val(data.motif_consult);
                }
            });
        });

        $(document).on('click', '.delete', function(){
            var id = $(this).attr("id");
            if(confirm("Vous etes sur de vouloir supprimer la fiche ?"))
            {
                $.ajax({
                    url:"listecouteerase.php",
                    method:"POST",
                    data:{id:id},
                    success:function(data){
                        alert("fiche supprimee!");
                        $('#datatableid').DataTable().destroy();
                        fetch_data();
                    }
                });
                setInterval(function(){
                    $('#alert_message').html('');
                }, 5000);
            }
        });
    });

</script>

</body>
</html>
