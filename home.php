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
    <script src="js/chart.js"></script>
</head>
<script>
    if ('<?php echo $_SESSION['addprof']?>' == 1) {
        alert("Nouvel utilisateur cree!");
        <?php $_SESSION['addprof'] = 0 ?>
    }
    if ('<?php echo $_SESSION['addecoute']?>' == 1) {
        alert("nouvelle fiche ecoute cree!");
        <?php $_SESSION['addecoute'] = 0 ?>
    }
    if ('<?php echo $_SESSION['addstatis']?>' == 1) {
        alert("nouvelle fiche statistique cree!");
        <?php $_SESSION['addstatis'] = 0 ?>
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
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i>  Logout</a>
        </li>
    </ul>
</nav>
<div class="content">
    <h2>Home Page</h2>
</div>
<div class="container">
    <br/>
    <br/>
    <table>
        <tr>
            <td>
            <table class="menu">
                <tr>
                    <?php if($_SESSION['admin'] == 0 OR $_SESSION['admin'] == 1) {?>
                        <td><button onclick="window.location.href = 'ecoute.php';" name="ecoute" class="btn btn-primary">Fiche d'Ecoute & Suivi</button></td>
                    <?php }?>
                    <?php if($_SESSION['admin'] == 2 OR $_SESSION['admin'] == 1) {?>
                        <td><button onclick="window.location.href = 'statistic.php';" name="statistic" class="btn btn-primary">Fiche des Statistiques</button></td>
                    <?php }?>
                </tr>
                <tr>
                    <?php if($_SESSION['admin'] == 0 OR $_SESSION['admin'] == 1) {?>
                        <td><button onclick="window.location.href = 'listecoute.php';" name="listecoute" class="btn btn-primary">Liste d'Ecoute & Suivi</button></td>
                    <?php }?>
                    <?php if($_SESSION['admin'] == 2 OR $_SESSION['admin'] == 1) {?>
                        <td><button onclick="window.location.href = 'liststatis.php';" name="liststatis" class="btn btn-primary">Liste des statistiques</button></td>
                    <?php }?>
                </tr>
                <tr>
                    <?php if($_SESSION['admin'] == 0 OR $_SESSION['admin'] == 1) {?>
                        <td><button onclick="window.location.href = 'serverecoute.php';" name="exportecoute" class="btn btn-success">Exporter sous Excel</button></td>
                    <?php }?>
                    <?php if($_SESSION['admin'] == 2 OR $_SESSION['admin'] == 1) {?>
                        <td><button onclick="window.location.href = 'serverstatis.php';" name="exportecoute" class="btn btn-success">Exporter sous Excel</button></td>
                    <?php }?>
                </tr>
            </table>
            </td>
            <td>
            <table class="dashbord">
                <tr>
                    <td><canvas id="myChart1"></canvas></td>
                    <td><canvas id="myChart2"></canvas></td>
                </tr>
            </table>
            </td>
        </tr>
    </table>
</div>
<script>

    var ctx1 = document.getElementById('myChart1').getContext("2d");
    var ctx2 = document.getElementById('myChart2').getContext("2d");
    Chart.defaults.global.animation.duration = 3000;
    var myChart1 = new Chart(ctx1, {

        type: 'doughnut',
        data: {
            labels: ["Africa", "Asia", "Europe", "Latin America", "North America"],
            datasets: [
                {
                    label: "Population (millions)",
                    backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
                    data: [2478,5267,734,784,433]
                }
            ]
        },
        options: {
            title: {
                display: true,
                text: 'Predicted world population (millions) in 2050'
            }
        }
    });
    var myChart2 = new Chart(ctx2, {

        type: 'line',
        data: {
            labels: [1500,1600,1700,1750,1800,1850,1900,1950,1999,2050],
            datasets: [{
                data: [86,114,106,106,107,111,133,221,783,2478],
                label: "Africa",
                borderColor: "#3e95cd",
                fill: false
            }, {
                data: [282,350,411,502,635,809,947,1402,3700,5267],
                label: "Asia",
                borderColor: "#8e5ea2",
                fill: false
            }, {
                data: [168,170,178,190,203,276,408,547,675,734],
                label: "Europe",
                borderColor: "#3cba9f",
                fill: false
            }, {
                data: [40,20,10,16,24,38,74,167,508,784],
                label: "Latin America",
                borderColor: "#e8c3b9",
                fill: false
            }, {
                data: [6,3,2,2,7,26,82,172,312,433],
                label: "North America",
                borderColor: "#c45850",
                fill: false
            }
            ]
        },
        options: {
            title: {
                display: true,
                text: 'World population per region (in millions)'
            }
        }
    });

</script>

</body>
</html>
