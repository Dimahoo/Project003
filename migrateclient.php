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
    <link href="migrateclient.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/dataTables.bootstrap.min.css" rel="stylesheet" />
    <link href="css/dataTables.checkboxes.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" />
    <link href="css/font-awesome.css" rel="stylesheet" />
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script src="js/dataTables.checkboxes.min.js"></script>


</head>
<script>
    if ('<?php echo $_SESSION['editclient']?>' == 1) {
        alert("Modification effectuee!");
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
        <div class="card">
            <h2 align="left">Migration des Clients</h2>
        </div>
        <div class="card">
            <div class="card-body">
                <form id="myform" action="domigration.php" method="post">
                <pre id="view-rows"></pre>
                <pre id="view-form"></pre>
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
                    <p><button class="btn btn-primary">View Selected</button></p>
                </form>
            </div>
        </div>
</div>

<script>

    $(document).ready(function () {

        var dataTable = $("#datatableid").DataTable({
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
        })

        $("#myform").on('submit', function(e){

            var form = this;
            var rowsel = dataTable.column(0).checkboxes.selected();
            $.each(rowsel, function(index, rowId){

                $(form).append(

                    $('<input>').attr('type','hidden').attr('name','id[]').val(rowId)
                )
            })



            $("#view-rows").text(rowsel.join(","))
            $("#view-form").text($(form).serialize())
            $('input[name="id\[\]"]', form).remove()
            e.preventDefault()
        })

    })

</script>

</body>
</html>
