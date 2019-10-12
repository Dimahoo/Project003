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
            content: 'Modification effectuee!',
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
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
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
                        <th>Date creation</th>
                        <th>Date cloture</th>
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
    <div class="modal-dialog" style="width:700px; height:700px;">
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
                        </tr>
                        <!-- Row 2 -->
                        <tr>
                            <td><label>Identifiant Intervenant:</label></td>
                            <td><input type="text" name="id_interv" id="id_interv" readonly></td>
                        </tr>
                        <!-- Row 3 -->
                        <tr>
                            <td><label>Date creation:</label></td>
                            <td><input id="date_creation" name="date_creation" type="date"></td>
                        </tr>
                        <!-- Row 4 -->
                        <tr>
                            <td><label>Date cloture:</label></td>
                            <td><input id="date_cloture" name="date_cloture" type="date"></td>
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
                "order": [],
                "columnDefs": [
                    { "orderable": false, "targets": 4 }
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
                    $('#id_interv').val(data.id_interv);
                    $('#date_creation').val(data.date_creation);
                    $('#date_cloture').val(data.date_cloture);
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
                            content: 'fiche supprimee!',
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
