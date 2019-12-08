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

$date1_comp = $year . "-01-01";
$date2_comp = $year . "-04-30";


if($today >= $date1_comp AND $today <= $date2_comp) {

    $year_combo = $year - 1;
} else {

    $year_combo = $year;
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile Page</title>
    <link href="listeval.css" rel="stylesheet" type="text/css">
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
    <script src="js/ellipsis.js"></script>


</head>
<script>
    if ('<?php echo $_SESSION['editeval']?>' == 1) {
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
        <?php $_SESSION['editeval'] = 0 ?>
    }
</script>
<body class="loggedin">
<nav class="navtop">
    <p>Website Title</p>
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
            <h2 align="left">Liste des Évaluations</h2>
        </div>
        <div class="card">
            <div class="card-body">
                <table id="datatableid" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>ID intervenant</th>
                        <th>Intervenant</th>
                        <th>Trimestre</th>
                        <th>Année</th>
                        <th>Note</th>
                        <th>Commentaire</th>
                        <th style="width: 110px;">Action</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade bd-example-modal-xl" id="editevalmodal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:700px; height:700px;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Modifier fiche</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="updateval.php" method="post">
                <div class="modal-body">
                    <input type="hidden" name="eval_id" id="eval_id">
                    <table id="eval" class="eval" style="width:50%" align="center">
                        <!-- Row 1 -->
                        <tr>
                            <td><label>ID intervenant:</label></td>
                            <td><input type="text" id="id_interv" name="id_interv" readonly></td>
                        </tr>
                        <!-- Row 2 -->
                        <tr>
                            <td><label>Intervenant:</label></td>
                            <td><input type="text" id="interv" name="interv" readonly></td>
                        </tr>
                        <!-- Row 3 -->
                        <tr>
                            <td><label>Trimestre:</label></td>
                            <td>
                                <input type="text" id="trimestre" name="trimestre" readonly>
                            </td>
                        </tr>
                        <!-- Row 4 -->
                        <tr>
                            <td><label>Année:</label></td>
                            <td><input type="text" id="annee" name="annee" readonly></td>
                        </tr>
                        <!-- Row 5 -->
                        <tr>
                            <td><label>Note:</label></td>
                            <td><input type="number" id="note" name="note" min="0" max="100"></td>
                        </tr>
                        <!-- Row 6 -->
                        <tr>
                            <td><label>Commentaire:</label></td>
                            <td><textarea rows = "3" cols = "50" id="comm" name = "comm"></textarea></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <!-- Row7 buttons -->
                    <table id="button" class="button" style="width:15%" align="right">
                        <tr>
                            <td>
                                <input type="submit" name="updateval" value="Mettre a jour" class="btn btn-primary" />
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
                    { "orderable": false, "targets": 7 },
                    { "targets": 6, "render": $.fn.dataTable.render.ellipsis(10) },
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
                    "url": 'fetcheval.php',
                    "type": 'POST'
                },
                "language": {
                    "url":'lang/French.json'
                }
            });

        }

        $.fn.dataTable.render.ellipsis = function ( cutoff ) {
            return function (data, type, row) {

                    return type === 'display' && data.length > cutoff ?
                        data.substr( 0, cutoff ) +'…' :
                        data;
            }
        };

        $(document).on('click', '.editbtn', function() {

            var eval_id = $(this).attr("id");

            $.ajax({
                url:"evalfetchupdate.php",
                method:"POST",
                data:{eval_id:eval_id},
                dataType:"json",
                success:function(data){
                    $('#eval_id').val(data.id);
                    $('#id_interv').val(data.id_interv);
                    $('#interv').val(data.interv);
                    $('#trimestre').val(data.trimestre);
                    $('#annee').val(data.annee);
                    $('#note').val(data.note);
                    $('#comm').val(data.comm);
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
                            url:"listevalerase.php",
                            method:"POST",
                            data:{id:id},
                            success:function(data){
                                $.alert({
                                    title: 'Notification!',
                                    icon: 'fa fa-warning',
                                    type: 'orange',
                                    animation: 'rotate',
                                    content: 'Évaluation supprimée!',
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
