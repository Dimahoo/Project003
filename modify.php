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
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/bootstrap.css" rel="stylesheet" />
    <link href="css/dataTables.bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link href="css/font-awesome.css" rel="stylesheet" />
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script src="js/dataTables.checkboxes.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/jquery.tabledit.js"></script>
</head>
<body class="loggedin" onload="viewData()">
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
<br/>
<br/>
<br/>
<br/>
<div class="container box">
    <h3 align="left"><?php echo $title; ?></h3><br />
    <div class="table-responsive">
        <br /><br />
        <table id="user_data" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th width="35%">Username</th>
                <th width="35%">Email</th>
                <th width="10%">Admin</th>
                <th width="10%">Edit</th>
            </tr>
            </thead>
        </table>
    </div>
</div>
</body>
</html>
<div id="userModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="user_form">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Update User</h4>
                </div>
                <div class="modal-body">
                    <label>Enter Username</label>
                    <input type="text" name="username" id="username" class="form-control" />
                    <br />
                    <label>Enter email</label>
                    <input type="text" name="email" id="email" class="form-control" />
                    <br />
                    <label>Admin ?</label>
                    <input type="text" name="admin" id="admin" class="form-control" />
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="user_id" id="user_id" />
                    <input type="submit" name="action" id="action" class="btn btn-success" value="Add" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript" language="javascript" >
    $(document).ready(function(){
        $('#add_button').click(function(){
            $('#user_form')[0].reset();
            $('.modal-title').text("Add User");
            $('#action').val("Add");
            $('#user_uploaded_image').html('');
        })
        var dataTable = $('#user_data').DataTable({
            "processing":true,
            "serverSide":true,
            "order":[],
            "ajax":{
                url:"<?php echo base_url() . 'crud/fetch_user'; ?>",
                type:"POST"
            },
            "columnDefs":[
                {
                    "targets":[0, 3, 4],
                    "orderable":false,
                },
            ],
        });
        $(document).on('submit', '#user_form', function(event){
            event.preventDefault();
            var username = $('#username').val();
            var email = $('#email').val();
            if(username != '' && email != '')
            {
                $.ajax({
                    url:"<?php echo base_url() . 'crud/user_action'?>",
                    method:'POST',
                    data:new FormData(this),
                    contentType:false,
                    processData:false,
                    success:function(data)
                    {
                        alert(data);
                        $('#user_form')[0].reset();
                        $('#userModal').modal('hide');
                        dataTable.ajax.reload();
                    }
                });
            }
            else
            {
                alert("Bother Fields are Required");
            }
        });
        $(document).on('click', '.update', function(){
            var user_id = $(this).attr("id");
            $.ajax({
                url:"<?php echo base_url(); ?>crud/fetch_single_user",
                method:"POST",
                data:{user_id:user_id},
                dataType:"json",
                success:function(data)
                {
                    $('#userModal').modal('show');
                    $('#username').val(data.username);
                    $('#email').val(data.email);
                    $('#admin').val(data.admin);
                    $('.modal-title').text("Edit User");
                    $('#user_id').val(user_id);
                    $('#action').val("Edit");
                }
            })
        });
    });
</script>