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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script src="js/dataTables.checkboxes.min.js"></script>
</head>
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
<br/>
<br/>
<br/>
<br/>
<div class="container">
    <h3>Delete profile</h3>
        <div class="table-responsive">
        <table id="employee_data" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <td>Select</td>
                    <td>Username</td>
                    <td>Email</td>
                    <td>Admin</td>
                </tr>
            </thead>
            <?php while($row = mysqli_fetch_array($sql)) { ?>
            <tr>
                <td><input class="checkbox" type="checkbox" id="<?=$row["id"] ?>"</td>
                <td><?=$row["username"]?></td>
                <td><?=$row["email"]?></td>
                <?php if($row["admin"] == 1) {?>
                    <td>Yes</td>
                <?php }else{ ?>
                    <td>No</td>
                <?php } ?>
            </tr>
            <?php } ?>
        </table>
            <button type="button" class="btn btn-danger" id="delete">Delete Selected</button>
        </div>
    </div>
</div>
</body>
</html>

<script>
    $(document).ready(function(){
        $('#employee_data').DataTable();
        $('#checkAll').click(function(){
            if(this.checked){
                $('.checkbox').each(function(){
                    this.checked = true;
                });
            }else{
                $('.checkbox').each(function(){
                    this.checked = false;
                });
            }
        });

        $('#delete').click(function(){
            var dataArr  = new Array();
            if($('input:checkbox:checked').length > 0){
                $('input:checkbox:checked').each(function(){
                    dataArr.push($(this).attr('id'));
                    $(this).closest('tr').remove();
                });
                sendResponse(dataArr)
                location.reload();
            }else{
                alert('No record selected ');
            }

        });

        function sendResponse(dataArr){
            $.ajax({
                type    : 'post',
                url     : 'function.php',
                data    : {'data' : dataArr},
                success : function(response){
                    alert(response);
                },
                error   : function(errResponse){
                    alert(errResponse);
                }
            });
        }
    });
</script>
