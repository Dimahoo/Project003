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

$data1 =  '[{"label":"","value":"0"}]';
$data2 =  '[{"label":" ","value":"0"}]';
$data3 = '{"description":" ", count:0}';


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
            'label'   =>  " ",
            'value'   =>  $row["count"]
        );
    }

    //free memory associated with result
    $result1->close();
    $result2->close();

    //now print the data
    $data1 = json_encode($clientnumber);
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
            'label'   =>  " ",
            'value'   =>  $row["count"]
        );
    }

    //free memory associated with result
    $result3->close();

    $data1 = json_encode($clinumbinterv);
}

if($_SESSION['admin'] == 1 or $_SESSION['admin'] == 2) {

    //query to get data from the table
    $query = "select description, count(*) as count from statis group by description order by id asc";

    //execute query
    $result4 = mysqli_query($connection, $query) or die(mysqli_error());

    $statistics = '';

    while($row = mysqli_fetch_array($result4)) {

        $statistics .= "{ description:'".$row["description"]."', count:".$row["count"]."}, ";
    }

    //free memory associated with result
    $result4->close();

    $data3 = substr($statistics, 0, -2);
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
    <link href="css/jquery-confirm.min.css" rel="stylesheet" />
    <link href="css/morris.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-confirm.min.js"></script>
</head>
<script>
    if ('<?php echo $_SESSION['addecoute']?>' == 1) {
        $.alert({
            title: 'Notification!',
            icon: 'fa fa-warning',
            type: 'orange',
            animation: 'rotate',
            content: 'Nouvelle fiche écoute & suivi crée!',
            buttons: {
                Fermer: function () {
                    this.setCloseAnimation('rotate');
                }
            }
        });
        <?php $_SESSION['addecoute'] = 0 ?>
    }
    if ('<?php echo $_SESSION['addstatis']?>' == 1) {
        $.alert({
            title: 'Notification!',
            icon: 'fa fa-warning',
            type: 'orange',
            animation: 'rotate',
            content: 'Nouvelle fiche statistique crée!',
            buttons: {
                Fermer: function () {
                    this.setCloseAnimation('rotate');
                }
            }
        });
        <?php $_SESSION['addstatis'] = 0 ?>
    }
    if ('<?php echo $_SESSION['addbene']?>' == 1) {
        $.alert({
            title: 'Notification!',
            icon: 'fa fa-warning',
            type: 'orange',
            animation: 'rotate',
            content: 'Nouvelle fiche bénevole crée!',
            buttons: {
                Fermer: function () {
                    this.setCloseAnimation('rotate');
                }
            }
        });
        <?php $_SESSION['addbene'] = 0 ?>
    }
    if ('<?php echo $_SESSION['addeval']?>' == 1) {
        $.alert({
            title: 'Notification!',
            icon: 'fa fa-warning',
            type: 'orange',
            animation: 'rotate',
            content: 'Nouvelle évaluation crée!',
            buttons: {
                Fermer: function () {
                    this.setCloseAnimation('rotate');
                }
            }
        });
        <?php $_SESSION['addeval'] = 0 ?>
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
                <li><a href="delete.php">suppression</a></li>
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
<div class="content">
    <h2>Page d'acceuil</h2>
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
                        <td><button onclick="window.location.href = 'ecoute.php';" name="ecoute" class="btn btn-primary">Fiche Écoute & Suivi</button></td>
                    <?php }?>
                    <?php if($_SESSION['admin'] == 2 OR $_SESSION['admin'] == 1) {?>
                        <td><button onclick="window.location.href = 'statistic.php';" name="statistic" class="btn btn-primary">Fiche des Statistiques</button></td>
                    <?php }?>
                </tr>
                <tr>
                    <?php if($_SESSION['admin'] == 0 OR $_SESSION['admin'] == 1) {?>
                        <td><button onclick="window.location.href = 'listecoute.php';" name="listecoute" class="btn btn-primary">Liste Écoute & Suivi</button></td>
                    <?php }?>
                    <?php if($_SESSION['admin'] == 2 OR $_SESSION['admin'] == 1) {?>
                        <td><button onclick="window.location.href = 'liststatis.php';" name="liststatis" class="btn btn-primary">Liste des Statistiques</button></td>
                    <?php }?>
                </tr>
                <tr>
                    <?php if($_SESSION['admin'] == 0 OR $_SESSION['admin'] == 1) {?>
                        <td><button onclick="window.location.href = 'serverecoute.php';" name="exportecoute" class="btn btn-success">Exporter Écoute & Suivi</button></td>
                    <?php }?>
                    <?php if($_SESSION['admin'] == 2 OR $_SESSION['admin'] == 1) {?>
                        <td><button onclick="window.location.href = 'serverstatis.php';" name="exportstatis" class="btn btn-success">Exporter Statistiques</button></td>
                    <?php }?>
                </tr>
                <tr>
                    <?php if($_SESSION['admin'] == 0 OR $_SESSION['admin'] == 1) {?>
                        <td><button onclick="window.location.href = 'listclient.php';" name="listeclient" class="btn btn-primary">Liste des Clients</button></td>
                    <?php }?>
                </tr>
                <tr>
                    <?php if($_SESSION['admin'] == 0 OR $_SESSION['admin'] == 1) {?>
                        <td><button onclick="window.location.href = 'serverclient.php';" name="exportclient" class="btn btn-success">Exporter Clients</button></td>
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
                        <td id="nbrclientlabel"><label class="label1">Nombre de clients</label></td>
                        <td id="statislabel"><label class="label2">Statistiques</label></td>
                </tr>
                <tr>
                        <td id="nbrclientchart"><div id="clientNumberchart" class="clientNumberchart"></div></td>
                        <td id="statischart"><div id="statisbarchart" class="statisbarchart"></div></td>
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
                            <td><button onclick="window.location.href = 'benevole.php';" name="benevole" class="btn btn-primary">Fiche des Bénevoles</button></td>
                        <?php }?>
                        <?php if($_SESSION['admin'] == 1) {?>
                            <td><button onclick="window.location.href = 'evalinterv.php';" name="benevole" class="btn btn-primary">Eval. Intervenants</button></td>
                        <?php }?>
                    </tr>
                    <tr>
                        <?php if($_SESSION['admin'] == 1) {?>
                            <td><button onclick="window.location.href = 'listbenevole.php';" name="listebenevole" class="btn btn-primary">Liste des Bénevoles</button></td>
                        <?php }?>
                        <?php if($_SESSION['admin'] == 1) {?>
                            <td><button onclick="window.location.href = 'listeval.php';" name="listeval" class="btn btn-primary">Liste des Évaluations</button></td>
                        <?php }?>
                    </tr>
                    <tr>
                        <?php if($_SESSION['admin'] == 1) {?>
                            <td><button onclick="window.location.href = 'serverbenevole.php';" name="exportbenevole" class="btn btn-success">Exporter Bénevoles</button></td>
                        <?php }?>
                        <?php if($_SESSION['admin'] == 1) {?>
                            <td><button onclick="window.location.href = 'servereval.php';" name="exporteval" class="btn btn-success">Exporter Évaluations</button></td>
                        <?php }?>
                    </tr>
                </table>
            </td>
            <td>
                <table class="dashbord2">
                    <tr>
                        <td id="benelabel"><label class="label3">Nombre de bénevoles et stagiaires</label></td>
                    </tr>
                    <tr>
                        <td id="benechart"><div id="numBeneStagchart" class="numBeneStagchart"></div></td>
                    </tr>
                </table>
            </td>
        </tr>
        </table>
    </div>
</div>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>
<script src="js/dataTables.checkboxes.min.js"></script>
<script src="js/chart.js"></script>
<script src="js/morris.min.js"></script>
<script src="js/raphael-min.js"></script>


<script>

    $(document).ready(function () {

        clientNumber();
        adminNumBeneStag();
        statistics();
        $("#benelabel").hide();
        $("#benechart").hide();
        $("#nbrclientlabel").hide();
        $("#nbrclientchart").hide();
        $("#statislabel").hide();
        $("#statischart").hide();

        if ('<?php echo $_SESSION['admin']?>' == 1)  {

            $("#benelabel").show();
            $("#benechart").show();
            $("#nbrclientlabel").show();
            $("#nbrclientchart").show();
            $("#statislabel").show();
            $("#statischart").show();
        }

        if ('<?php echo $_SESSION['admin']?>' == 0)  {

            $("#nbrclientlabel").show();
            $("#nbrclientchart").show();
        }

        if ('<?php echo $_SESSION['admin']?>' == 2)  {

            $("#statislabel").show();
            $("#statischart").show();
        }

        function clientNumber() {

            var cliNumber = Morris.Donut({
                element: 'clientNumberchart',
                data: <?php echo $data1; ?>
            });
        }

        function adminNumBeneStag() {

            var numBeneStag = Morris.Donut({
                element: 'numBeneStagchart',
                data: <?php echo $data2; ?>
            });
        }

        function statistics() {

            var statis_bar_chart = Morris.Bar({
                element: 'statisbarchart',
                data: [<?php echo $data3; ?>],
                xkey: 'description',
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
