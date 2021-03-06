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
    <link href="listclient.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <!--<link href="css/dataTables.bootstrap.min.css" rel="stylesheet" />-->
    <link href="css/fixedColumns.dataTables.min.css" rel="stylesheet" />
    <link href="css/fixedColumns.bootstrap.min.css" rel="stylesheet" />
    <link href="css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="css/buttons.dataTables.min.css" rel="stylesheet" />
    <link href="css/jquery-confirm.min.css" rel="stylesheet" />
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
    <script src="js/jquery-confirm.min.js"></script>


</head>
<script>
    if ('<?php echo $_SESSION['editclient']?>' == 1) {
        $.alert({
            title: 'Notification!',
            icon: 'fa fa-warning',
            type: 'orange',
            animation: 'rotate',
            content: 'Modification effectuée!',
            buttons: {
                Fermer: function () {
                    this.setCloseAnimation('rotate');
                }
            }
        });
        <?php $_SESSION['editclient'] = 0 ?>
    }
</script>
<body class="loggedin">
<nav class="navtop">
    <p>Multi-Écoute</p>
    <ul>
        <li><a href="home.php"><i class="fas fa-home"></i> Page d'acceuil</a></li>
        <li></li>
        <li></li>
        <?php if($_SESSION['admin'] == 1) {?>
            <li><a href="#"><i class="fa fa-arrow-down"></i> Manager les profiles</a>
                <ul>
                    <li><a href="create.php">Creation</a></li>
                    <li><a href="modify.php">Modification</a></li>
                    <li><a href="delete.php">Suppression</a></li>
                </ul>
            </li>
        <?php }?>
        <li>
            <a href="profile.php"><i class="fas fa-user-circle"></i> <?=$_SESSION['name']?>  Profil</a>
        </li>
        <li>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
        </li>
    </ul>
</nav>

</br>
<div class="container">
    <div class="jumbotron">
        <div class="card">
            <h2 align="left">Liste des Clients</h2>
        </div>
        <div class="card">
            <div class="card-body">
                <table id="datatableid" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>ID Client</th>
                        <th>ID intervenant</th>
                        <th>Intervenant</th>
                        <th>Date création</th>
                        <th>Date clôture</th>
                        <th>Description</th>
                        <th>Type d'appelant</th>
                        <th>Mode d'intervention</th>
                        <th>Type d'intervention</th>
                        <th>Langue</th>
                        <th>Durée</th>
                        <th>Date arrivée au Canada</th>
                        <th>Réferée par</th>
                        <th>Sexe</th>
                        <th>Âge</th>
                        <th>Situation financière</th>
                        <th>Origine</th>
                        <th>Status au Canada</th>
                        <th>Problème mentale</th>
                        <th>État civil</th>
                        <th>Nombre d'enfant</th>
                        <th>État psychologique avant intervention</th>
                        <th>État psychologique apres intervention</th>
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
<div class="modal fade bd-example-modal-xl" id="editclientmodal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:1300px; height:700px;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Modifier fiche</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="updateclient.php" method="post">
                <div class="modal-body">
                    <table id="client" class="benevole" style="width:50%" align="center">
                        <!-- Row 1 -->
                        <tr>
                            <td><label>Identifiant Client:</label></td>
                            <td><input type="text" name="client_id" id="client_id" readonly></td>
                            <td><label>Date creation:</label></td>
                            <td><input id="date_creation" name="date_creation" type="date"></td>
                            <td><label>Date cloture:</label></td>
                            <td><input id="date_cloture" name="date_cloture" type="date"></td>
                        </tr>
                        <!-- Row2 -->
                        <tr>
                            <td><label>Description:</label></td>
                            <td>
                                <select name="description" id="description">
                                    <option>---</option>
                                    <option>Suivi</option>
                                    <option>Ecoute</option>
                                </select>
                            </td>
                            <td><label>Type d'appelant:</label></td>
                            <td>
                                <select name="type_appelant" id="type_appelant">
                                    <option>---</option>
                                    <option>Regulier</option>
                                    <option>General</option>
                                    <option>Tierce personne</option>
                                    <option>Autre</option>
                                </select>
                            </td>
                        </tr>
                        <!-- Row3 -->
                        <tr>
                            <td><label>Mode d'intervention:</label></td>
                            <td>
                                <select name="mode_interv" id="mode_interv">
                                    <option>---</option>
                                    <option>Face a face</option>
                                    <option>Telephone</option>
                                    <option>Autre</option>
                                </select>
                            </td>
                            <td><label>Type d'intervention:</label></td>
                            <td>
                                <select name="type_interv" id="type_interv">
                                    <option>---</option>
                                    <option>Ecoute</option>
                                    <option>Appel Obscene</option>
                                    <option>Raccrochage</option>
                                    <option>Intervention Psychosociale</option>
                                    <option>Autre</option>
                                </select>
                            </td>
                            <td><label>Langue utilisée:</label></td>
                            <td>
                                <select name="langue" id="langue">
                                    <option>---</option>
                                    <option>Arabe</option>
                                    <option>Anglais</option>
                                    <option>Espagnol</option>
                                    <option>Francais</option>
                                    <option>Persan</option>
                                    <option>Russe</option>
                                    <option>Autre</option>
                                </select>
                            </td>
                        </tr>
                        <!-- Row3 -->
                        <tr>
                            <td><label>Durée:</label></td>
                            <td>
                                <select name="duree" id="duree">
                                    <option>---</option>
                                    <option>< 5 min</option>
                                    <option>5-15 min</option>
                                    <option>15-30 min</option>
                                    <option>30-45 min</option>
                                    <option>45-60 min</option>
                                    <option>> 1h<option>
                                </select>
                            </td>
                            <td><label>Réferée Par:</label></td>
                            <td>
                                <select name="ref_par" id="ref_par">
                                    <option>---</option>
                                    <option>CLSC</option>
                                    <option>PRAIDA</option>
                                    <option>CLE</option>
                                    <option>CDN</option>
                                    <option>CLSC</option>
                                    <option>ORGANISME QUARTIER</option>
                                    <option>CLSC</option>
                                    <option>IMM CA</option>
                                    <option>MICC</option>
                                    <option>AUTRE CENTRE D ECOUTE</option>
                                    <option>AMI FAMILLE</option>
                                    <option>PROJET GENESE</option>
                                    <option>AUTRE</option>
                                </select>
                            </td>
                            <td><label >Date arrivée au canada:</label></td>
                            <td><input id="date_arrivee" name="date_arrivee" type="date"></td>
                        </tr>
                        <!-- Row4 -->
                        <tr>
                            <td><label>Sexe:</label></td>
                            <td>
                                <select name="sexe" id="sexe">
                                    <option>---</option>
                                    <option>Homme</option>
                                    <option>Femme</option>
                                    <option>Autre</option>
                                </select>
                            </td>
                            <td><label>Âge:</label></td>
                            <td>
                                <select name="age" id="age">
                                    <option>---</option>
                                    <option>15 - 24</option>
                                    <option>25 - 34</option>
                                    <option>35 - 44</option>
                                    <option>45 - 54</option>
                                    <option>55 - 64</option>
                                    <option>65 et +<option>
                                </select>
                            </td>
                            <td><label>Situation Financière:</label></td>
                            <td>
                                <select name="situ_finance" id="situ_finance">
                                    <option>---</option>
                                    <option>Aide sociale</option>
                                    <option>Chomage</option>
                                    <option>Salaire mininum</option>
                                    <option>Etudiant</option>
                                    <option>Sans revenu</option>
                                    <option>Pension Vieillesse</option>
                                    <option>Travail</option>
                                    <option>Autre</option>
                                </select>
                            </td>
                        </tr>
                        <!-- Row5 -->
                        <tr>
                            <td><label>Origine:</label></td>
                            <td>
                                <select name="origine" id="origine">
                                    <option>---</option>
                                    <option>Asiatique</option>
                                    <option>Moyen Orient</option>
                                    <option>Afrique</option>
                                    <option>Afrique du nord</option>
                                    <option>Afrique du sud et centrale</option>
                                    <option>Amerique du nord</option>
                                    <option>Europe de l est</option>
                                    <option>Europeen</option>
                                    <option>Latino et Caraibe</option>
                                    <option>Canadien</option>
                                    <option>Autre</option>
                                </select>
                            </td>
                            <td><label>Status au Canada:</label></td>
                            <td>
                                <select name="status_canada" id="status_canada">
                                    <option>---</option>
                                    <option>DA</option>
                                    <option>RA</option>
                                    <option>RP</option>
                                    <option>CIT</option>
                                    <option>ET</option>
                                    <option>T</option>
                                    <option>SS</option>
                                    <option>TT</option>
                                </select>
                            </td>
                            <td><label>Problème de sante mentale:</label></td>
                            <td>
                                <select name="prob_mentale" id="prob_mentale">
                                    <option>---</option>
                                    <option>OUI</option>
                                    <option>NON</option>
                                </select>
                            </td>
                        </tr>
                        <!-- Row6 -->
                        <tr>
                            <td><label>État civil:</label></td>
                            <td>
                                <select name="etat_civil" id="etat_civil">
                                    <option>---</option>
                                    <option>M</option>
                                    <option>C</option>
                                    <option>V</option>
                                    <option>S</option>
                                    <option>D</option>
                                    <option>CF</option>
                                </select>
                            </td>
                            <td><label>Nombre enfants:</label></td>
                            <td>
                                <input id="nbr_enfant" name="nbr_enfant" type="number">
                            </td>
                            <td><label class="long">État psychologique après l'intervention:</label></td>
                            <td>
                                <select name="psy_apres_interv" id="psy_apres_interv">
                                    <option>---</option>
                                    <option>Soulagee</option>
                                    <option>Motivee</option>
                                    <option>Calme</option>
                                    <option>A de l espoir</option>
                                    <option>Pire</option>
                                    <option>Status quo</option>
                                    <option>Piste de solution</option>
                                    <option>Autre</option>
                                </select>
                            </td>
                        </tr>
                        <!-- Row7 -->
                        <tr>
                            <td ><label class="long" >État psychologique au debut de l'intervention:</label></td>
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
                    </table>
                </div>
                <!-- Row8 buttons -->
                <div class="modal-footer">
                    <table id="button" class="button" style="width:15%" align="right">
                        <tr>
                            <td>
                                <input type="submit" name="updateclient" value="Mettre a jour" class="btn btn-primary" />
                            </td>
                            <td>
                                <input type="button" name="cancel" value="Annuler" class="btn btn-secondary"  data-dismiss="modal" />
                            </td>
                        </tr>
                    </table>
                </div>
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
                    { "orderable": false, "targets": 24 }
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
                    "url": 'fetchclient.php',
                    "type": 'POST'
                },
                "language": {
                    "url":'lang/French.json'
                }
            });
        }

        $(document).on('click', '.editbtn', function() {

            var client_id = $(this).attr("id");

            $.ajax({
                url:"clientfetchupdate.php",
                method:"POST",
                data:{client_id:client_id},
                dataType:"json",
                success:function(data){
                    $('#client_id').val(data.id);
                    $('#date_creation').val(data.date_creation);
                    $('#date_cloture').val(data.date_cloture);
                    $('#description').val(data.description);
                    $('#type_appelant').val(data.type_appelant);
                    $('#mode_interv').val(data.mode_interv);
                    $('#type_interv').val(data.type_interv);
                    $('#langue').val(data.langue);
                    $('#duree').val(data.duree);
                    $('#ref_par').val(data.ref_par);
                    $('#date_arrivee').val(data.date_arrivee);
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
                    url:"listclienterase.php",
                    method:"POST",
                    data:{id:id},
                    success:function(data){
                        $.alert({
                            title: 'Notification!',
                            icon: 'fa fa-warning',
                            type: 'orange',
                            animation: 'rotate',
                            content: 'fiche supprimée!',
                            buttons: {
                                Fermer: function () {
                                    this.setCloseAnimation('rotate');
                                }
                            }
                        });
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
