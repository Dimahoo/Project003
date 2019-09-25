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
    <link href="css/chart.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script src="js/dataTables.checkboxes.min.js"></script>
    <script src="js/chart.js"></script>
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
    <canvas id="myChart"></canvas>
</div>

<script>

        var ctx = document.getElementById('myChart').getContext("2d");
        Chart.defaults.global.animation.duration = 3000;
        var myChart = new Chart(ctx, {

            type: 'doughnut',
            data: {
                labels: ["Africa", "Asia", "Europe", "Latin America", "North America"],
                datasets: [
                    {
                        label: "Population (millions)",
                        backgroundColor: ["#3e95cd", "#8e5ea2", "#3cba9f", "#e8c3b9", "#c45850"],
                        data: [2478, 5267, 734, 784, 433]
                    }
                ]
            },
            options: {
                responsive: false,
                title: {
                    display: true,
                    text: 'Predicted world population (millions) in 2050'
                },
                animation: true,
                animationEasing: 'easeInOutQuart',
                animationSteps: 80
            }
        });
</script>
</body>
</html>
