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

$connection = mysqli_connect("localhost","root","");
$db = mysqli_select_db($connection,'accounts');

//query to get data from the table
$query = "select id, username from users";

//execute query
$result = mysqli_query($connection, $query) or die(mysqli_error());

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
    <link href="migrateclient.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/dataTables.bootstrap.min.css" rel="stylesheet" />
    <link href="css/dataTables.checkboxes.css" rel="stylesheet" />
    <link href="css/jquery-confirm.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" />
    <link href="css/font-awesome.css" rel="stylesheet" />
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script src="js/dataTables.checkboxes.min.js"></script>
    <script src="js/popper.min.js"></script>
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
    <form id="myform" method="post">
        <div class="card">
            <h2 align="left">Migration des Clients</h2>
        </div>
        <div class="card">
            <div class="card-body">
                <hr width="100%">
                <label>Choisissez Intervenant :</label>
                <select name="interv" id="interv">
                    <?php while($row = mysqli_fetch_array($result))
                    {
                        echo "<option value=" .$row['id'] . ">" . $row['username'] . "</option>";
                    }
                echo "</select>"
                ?>
                <hr width="100%">
                <table id="datatableid" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th></th>
                        <th>ID client</th>
                        <th>ID intervenant</th>
                        <th>Intervenant</th>
                        <th>Date creation</th>
                        <th>Date cloture</th>
                    </tr>
                    </thead>
                </table>
                    <p class="submit"><button type="button" name="migrate" class="btn btn-primary migrate">Migrer la selection</button></p>
            </div>
        </div>
    </form>
</div>

<script>

    $(document).ready(function () {

        fetch_data();

        function fetch_data() {

            var dataTable = $('#datatableid').DataTable({
                ajax: 'fetchmigrateclient.php',
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                columnDefs: [{
                    targets: 0,
                    checkboxes: {
                        seletRow: true
                    }
                }],
                select: {
                    style: 'multi'
                },
                order: [[1, 'asc']]
            });
        }


        $(document).on('click', '.migrate', function() {

            var form = this;
            var rowsel = $('#datatableid').DataTable().column(0).checkboxes.selected();
            var interv = $('#interv');
            var selection = rowsel.join(",");
            console.log(rowsel.join(","));

            var send = {
                interv: interv.val(),
                list: selection,
            };

            $.confirm({
                title: 'Notification!',
                icon: 'fa fa-warning',
                type: 'orange',
                animation: 'rotate',
                closeAnimation: 'rotate',
                content: 'Vous etes sur de vouloir faire cette migration ?',
                buttons: {
                    Confirmer: function () {
                        $.ajax({
                            url:"domigration.php",
                            method:"POST",
                            data:send,
                            success:function(){
                                $.alert({
                                    title: 'Notification!',
                                    icon: 'fa fa-warning',
                                    type: 'orange',
                                    animation: 'rotate',
                                    content: 'Migration effectuee!',
                                    buttons: {
                                        Fermer: function () {
                                            this.setCloseAnimation('rotate');
                                        }
                                    }
                                });
                                $('#datatableid').DataTable().destroy();
                                fetch_data();
                            },
                            error:function () {
                                alert('error loading orders');
                            }
                        })
                    },
                    Annuler: function () {
                    }
                }
            });
        });


    })

</script>

</body>
</html>
