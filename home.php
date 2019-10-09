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

$connection = mysqli_connect("localhost","root","");
$db = mysqli_select_db($connection,'accounts');

$data = '';
$data2 = '[]';
$data3 = '';


if($_SESSION['admin'] == 1) {

    //query to get data from the table
    $query = "select role, count(*) as count from benevole group by role order by id asc";

    //execute query
    $result1 = mysqli_query($connection, $query) or die(mysqli_error());

    //query to get data from the table
    $query = "select count(*) as count from client";

    //execute query
    $result2 = mysqli_query($connection, $query) or die(mysqli_error());

    //loop through the returned data
    $rolevalues1 = array();
    $rolevalues2 = '';
    $clientnumber = array();

    while($row = mysqli_fetch_array($result1)) {

        $rolevalues1[] = array(
            'label'   =>  $row["role"],
            'value'   =>  $row["count"]
        );
        $rolevalues2 .= "{ role:'".$row["role"]."', count:".$row["count"]."}, ";
    }

    while($row = mysqli_fetch_array($result2)) {

        $clientnumber[] = array(
            'label'   =>  "Nombre Clients",
            'value'   =>  $row["count"]
        );
    }

    //free memory associated with result
    $result1->close();
    $result2->close();

    //now print the data
    $data = json_encode($clientnumber);
    $data2 = json_encode($rolevalues1);
    $data3 = substr($rolevalues2, 0, -2);
}

if($_SESSION['admin'] == 0) {

    $id_interv = $_SESSION['id'];

    //query to get data from the table
    $query = "select count(*) as count from client where id_interv='$id_interv'";

    //execute query
    $result3 = mysqli_query($connection,$query) or die(mysqli_error());

    $clinumbinterv = array();

    while($row = mysqli_fetch_array($result3)) {

        $clinumbinterv[] = array(
            'label'   =>  "Nombre Clients",
            'value'   =>  $row["count"]
        );
    }

    //free memory associated with result
    $result3->close();

    $data = json_encode($clinumbinterv);
}

//close connection
$connection->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Home Page</title>
    <link href="home.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/dataTables.bootstrap.min.css" rel="stylesheet" />
    <link href="css/morris.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script src="js/dataTables.checkboxes.min.js"></script>
    <script src="js/chart.js"></script>
    <script src="js/morris.min.js"></script>
    <script src="js/raphael-min.js"></script>
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
    if ('<?php echo $_SESSION['addbene']?>' == 1) {
        alert("nouvelle fiche benevole cree!");
        <?php $_SESSION['addbene'] = 0 ?>
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
    <div>
    <table>
        <tr>
            <td>
            <table class="menu1">
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
                <tr>
                    <?php if($_SESSION['admin'] == 0 OR $_SESSION['admin'] == 1) {?>
                        <td><button onclick="window.location.href = 'Listclient.php';" name="listeclient" class="btn btn-primary">Liste des Clients</button></td>
                    <?php }?>
                </tr>
                <tr>
                    <?php if($_SESSION['admin'] == 1) {?>
                        <td><button onclick="window.location.href = 'migrateclient.php';" name="migrateclient" class="btn btn-primary">Migration des Clients</button></td>
                    <?php }?>
                </tr>
            </table>
            </td>
            <td>
            <table class="dashbord1">
                <tr>
                    <td><div id="clientNumber-chart" class="clientNumber-chart"></div></td>
                </tr>
            </table>
            </td>
        </tr>
    </table>
    </div>
    <hr style="width: 150%;">
    <div>
        <table>
        <tr>
            <td>
                <table class="menu2">
                    <tr>
                        <?php if($_SESSION['admin'] == 1) {?>
                            <td><button onclick="window.location.href = 'benevole.php';" name="benevole" class="btn btn-primary">Fiche des Benevoles</button></td>
                        <?php }?>
                    </tr>
                    <tr>
                        <?php if($_SESSION['admin'] == 1) {?>
                            <td><button onclick="window.location.href = 'listbenevole.php';" name="listebenevole" class="btn btn-primary">Liste des Benevoles</button></td>
                        <?php }?>
                    </tr>
                    <tr>
                        <?php if($_SESSION['admin'] == 1) {?>
                            <td><button onclick="window.location.href = 'serverbenevole.php';" name="exportbenevole" class="btn btn-success">Exporter sous Excel</button></td>
                        <?php }?>
                    </tr>
                </table>
            </td>
            <td>

                <table class="dashbord2">
                    <tr>
                        <?php if($_SESSION['admin'] == 1) {?>
                                <td><label>Nombre de benevoles et stagiaires</label></td>
                                <td><label>Nombre de benevoles et stagiaires</label></td>
                            </tr>
                            <tr>
                                <td><div id="numBeneStag-chart" class="numBeneStag-chart"></div></td>
                                <td><div id="bar-chart" class="bar-chart"></div></td>
                        <?php }?>
                    </tr>
                </table>
            </td>
        </tr>
        </table>
    </div>
</div>
<script>

    $(document).ready(function () {

        clientNumber();
        adminNumBeneStag();
        adminBarChart();

        function clientNumber() {

            var clientNumber = Morris.Donut({
                element: 'clientNumber-chart',
                data: <?php echo $data; ?>
            });
        }

        function adminNumBeneStag() {

            var numBeneStag = Morris.Donut({
                element: 'numBeneStag-chart',
                data: <?php echo $data2; ?>
            });
        }

        function adminBarChart() {

            var bar_chart = Morris.Bar({
                element: 'bar-chart',
                data: [<?php echo $data3; ?>],
                xkey: 'role',
                ykeys: ['count'],
                labels: ['count'],
                hideHover: 'auto',
                stacked: true
            });
        }
    });

</script>

</body>
</html>
