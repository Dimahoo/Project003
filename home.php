<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// Reset error message
$_SESSION['message'] = '';
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Home Page</title>
    <link href="home.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/dataTables.bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script src="js/dataTables.checkboxes.min.js"></script>
</head>
<script>
    if ('<?php echo $_SESSION['addprof']?>' == 1) {
        alert("New user created successfully!");
        <?php $_SESSION['addprof'] = 0 ?>
    }
    if ('<?php echo $_SESSION['addecoute']?>' == 1) {
        alert("nouvelle fiche cree!");
        <?php $_SESSION['addecoute'] = 0 ?>
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
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
        </li>
    </ul>
</nav>
<div class="content">
    <h2>Home Page</h2>
</div>
<div class="container box">
    <br/>
    <br/>
    <table id="" class="menu">
        <thead>
        <tr>
            <td><button onclick="window.location.href = 'ecoute.php';" name="ecoute" class="btn btn-primary">Fiche d'Ecoute & Suivi</button></td>
            <td><button onclick="window.location.href = 'listecoute.php';" name="listecoute" class="btn btn-primary">Liste d'Ecoute & Suivi</button></td>
            <td><button onclick="window.location.href = 'serverecoute.php';" name="exportecoute" class="btn btn-success">Exporter sous Excel</button></td>
        </tr>
        <tr>
            <td><button onclick="window.location.href = 'statistics.php';" name="statistique" class="btn btn-primary">Statistiques</button></td>
            <td><button onclick="window.location.href = 'liststatistics.php';" name="liststatistics" class="btn btn-primary">Liste des statistiques</button></td>
            <td><button onclick="window.location.href = 'serverstats.php';" name="exportecoute" class="btn btn-success">Exporter sous Excel</button></td>
        </tr>
        </thead>
    </table>
</div>
</div>
</div>

</body>
</html>
