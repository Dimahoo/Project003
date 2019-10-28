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
    <link href="delete.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/dataTables.bootstrap.min.css" rel="stylesheet" />
    <link href="css/jquery-confirm.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script src="js/dataTables.checkboxes.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
    <script src="js/jquery-confirm.min.js"></script>

</head>
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
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Deconnexion</a>
        </li>
    </ul>
</nav>
<br/>
<br/>
<br/>
<br/>
<div class="container box">
    <h1>Delete profile</h1>
    <br/>
    <br/>
    <div id="alert_message"></div>
        <table id="user_data" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>User name</th>
                    <th>Email</th>
                    <th>Admin</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
        </div>
    </div>
</div>
</body>
</html>

<script type="text/javascript" language="javascript" >
    $(document).ready(function(){

        fetch_data();

        function fetch_data()
        {
            var dataTable = $('#user_data').DataTable({
                "processing" : true,
                "serverSide" : true,
                "order" : [],
                "ajax" : {
                    url:"fetch1.php",
                    type:"POST"
                },
                "language": {
                    "url":'lang/French.json'
                }
            });
        }

        $(document).on('click', '.delete', function(){
            var id = $(this).attr("id");
            $.confirm({
                title: 'Notification!',
                icon: 'fa fa-warning',
                type: 'orange',
                animation: 'rotate',
                closeAnimation: 'rotate',
                content: 'Vous etes sur de vouloir continuer la suppression ?',
                buttons: {
                    Confirmer: function () {

                        $.ajax({
                            url:"erase.php",
                            method:"POST",
                            data:{id:id},
                            success:function(data){
                                $.alert({
                                    title: 'Notification!',
                                    icon: 'fa fa-warning',
                                    type: 'orange',
                                    animation: 'rotate',
                                    content: 'Profile supprimé!',
                                    buttons: {
                                        Fermer: function () {
                                            this.setCloseAnimation('rotate');
                                        }
                                    }
                                });
                                $('#user_data').DataTable().destroy();
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