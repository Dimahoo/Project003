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

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile Page</title>
    <link href="modify.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.css" rel="stylesheet" />
    <link href="css/dataTables.bootstrap.min.css" rel="stylesheet" />
    <link href="css/jquery-confirm.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" />
    <link href="css/font-awesome.css" rel="stylesheet" />
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script src="js/jquery-confirm.min.js"></script>

</head>
<script>
    if ('<?php echo $_SESSION['editprof']?>' == 1) {
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
        <?php $_SESSION['editprof'] = 0 ?>
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
            <h2 align="left">Modification des profils</h2>
        </div>
        <div class="card">
            <div class="card-body">
                <table id="datatableid" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom utilisateur</th>
                            <th>Email</th>
                            <th>Admin</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Edit profile</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="updateprofile.php" method="post">
            <div class="modal-body">
                    <input type="hidden" name="update_id" id="update_id">
                    <div class="form-group">
                        <label>User name</label>
                        <input type="text" name="username" id="username" class="form-control" placeholder="User name" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" name="admin" id="admin" class="form-check-input" value="Yes">
                        <label class="form-check-label" for="exampleCheck1">Admin</label>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name="updatedata" class="btn btn-primary">Update changes</button>
            </div>
            </form>
        </div>
    </div>
</div>


<script>

    $(document).ready(function () {

        fetch_data();

        function fetch_data()
        {
            var dataTable = $('#datatableid').DataTable({
                "processing" : true,
                "serverSide" : true,
                "order" : [],
                "ajax" : {
                    url:"fetch2.php",
                    type:"POST"
                },
                "language": {
                    "url":'lang/French.json'
                }
            });
        }

    $(document).on('click', '.editbtn', function() {

            $('#editmodal').modal('show');

            $tr = $(this).closest('tr');
            var data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();

            console.log(data);

            $('#update_id').val(data[0]);
            $('#username').val($.trim(data[1]));
            $('#email').val(data[2]);
            if (data[3] == 1)
            {
                $("#admin").prop('checked', true);
            } else {
                $("#admin").prop('checked', false);
            }
        });
    });

</script>

</body>
</html>
