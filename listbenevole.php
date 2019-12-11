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
    <link href="listbenevole.css" rel="stylesheet" type="text/css">
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
    if ('<?php echo $_SESSION['editbene']?>' == 1) {
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
        <?php $_SESSION['editbene'] = 0 ?>
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
            <li><a href="#"><i class="fa fa-arrow-down"></i> Manager les profils</a>
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
            <h2 align="left">Liste des Bénevoles et Stagiaires</h2>
        </div>
        <div class="card">
            <div class="card-body">
                <table id="datatableid" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date entree</th>
                        <th>Role</th>
                        <th>Nom</th>
                        <th>Prenom</th>
                        <th>Sexe</th>
                        <th>Tache</th>
                        <th>Domaine</th>
                        <th>Langue</th>
                        <th>Date_sortie</th>
                        <th style="width: 110px;">Action</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade bd-example-modal-xl" id="editbenemodal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:700px; height:700px;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Modifier fiche</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="updatebene.php" method="post">
                <div class="modal-body">
                    <input type="hidden" name="bene_id" id="bene_id">
                    <table id="benevole" class="benevole" style="width:50%" align="center">
                        <!-- Row 1 -->
                        <tr>
                            <td><label>Date Entrée:</label></td>
                            <td><input id="date_entree" name="date_entree" type="date"></td>
                        </tr>
                        <!-- Row2 -->
                        <tr>
                            <td><label>Rôle:</label></td>
                            <td>
                                <select name="role" id="role" required>
                                    <option>---</option>
                                    <option>Benevole</option>
                                    <option>Stagiaire</option>
                                </select>
                            </td>
                        </tr>
                        <!-- Row3 -->
                        <tr>
                            <td><label>Nom:</label></td>
                            <td><input type="text" name="nom" id="nom"></td>
                        </tr>
                        <!-- Row4 -->
                        <tr>
                            <td><label>Prénom:</label></td>
                            <td><input type="text" name="prenom" id="prenom"></td>
                        </tr>
                        <!-- Row5 -->
                        <tr>
                            <td><label>Sexe:</label></td>
                            <td>
                                <select name="sexe" id="sexe" required>
                                    <option>---</option>
                                    <option>Homme</option>
                                    <option>Femme</option>
                                    <option>Autre</option>
                                </select>
                            </td>
                        </tr>
                        <!-- Row6 -->
                        <tr>
                            <td><label>Langue:</label></td>
                            <td>
                                <select name="langue" id="langue" required>
                                    <option>---</option>
                                    <option>Arabe</option>
                                    <option>Anglais</option>
                                    <option>Espaniol</option>
                                    <option>Francais</option>
                                    <option>Person</option>
                                    <option>Russe</option>
                                    <option>Autre</option>
                                </select>
                            </td>
                        </tr>
                        <!-- Row7 -->
                        <tr>
                            <td><label>Tâche:</label></td>
                            <td><input type="text" name="tache" id="tache"></td>
                        </tr>
                        <!-- Row8 -->
                        <tr>
                            <td><label>Domaine:</label></td>
                            <td><input type="text" name="domaine" id="domaine"></td>
                        </tr>
                        <!-- Row9 -->
                        <tr>
                            <td><label>Date Sortie:</label></td>
                            <td><input id="date_sortie" name="date_sortie" type="date"></td>
                        </tr>
                    </table>
                </div>
                <!-- Row10 buttons -->
                <div class="modal-footer">
                    <table id="button" class="button" style="width:15%" align="right">
                        <tr>
                            <td>
                                <input type="submit" name="updatebene" value="Mettre a jour" class="btn btn-primary" />
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
                "order": [],
                "columnDefs": [
                    { "orderable": false, "targets": 10 }
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
                    "url": 'fetchbene.php',
                    "type": 'POST'
                },
                "language": {
                    "url":'lang/French.json'
                }
            });
        }

        $(document).on('click', '.editbtn', function() {

            var bene_id = $(this).attr("id");

            $.ajax({
                url:"benefetchupdate.php",
                method:"POST",
                data:{bene_id:bene_id},
                dataType:"json",
                success:function(data){
                    $('#bene_id').val(data.id);
                    $('#date_entree').val(data.date_entree);
                    $('#role').val(data.role);
                    $('#nom').val(data.nom);
                    $('#prenom').val(data.prenom);
                    $('#sexe').val(data.sexe);
                    $('#tache').val(data.tache);
                    $('#domaine').val(data.domaine);
                    $('#langue').val(data.langue);
                    $('#date_sortie').val(data.date_sortie);
                }
            });
        });

        $(document).on('click', '.delete', function(){
            var id = $(this).attr("id");
            $.confirm({
                title: 'Notification!',
                icon: 'fa fa-warning',
                type: 'orange',
                animation: 'rotate',
                closeAnimation: 'rotate',
                content: 'Vous êtes sur de vouloir continuer la suppression ?',
                buttons: {
                    Confirmer: function () {
                        $.ajax({
                            url:"listbeneerase.php",
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
                    },
                    Annuler: function () {
                    }
                }
            });
        });
    });

</script>

</body>
</html>
