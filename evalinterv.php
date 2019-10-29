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

$month = date('m');
$day = date('d');
$year = date('Y');

$date1_comp = $year . "-01-01";
$date2_comp = $year . "-04-30";


$today = $year . '-' . $month . '-' . $day;

if($today >= $date1_comp AND $today <= $date2_comp) {

    $year_combo = $year - 1;
} else {

    $year_combo = $year;
}

$date1 = $year_combo . "-04-01";
$date2 = $year_combo . "-07-01";
$date3 = $year_combo . "-10-01";
$date4 = $year_combo + 1 . "-01-01";


$connection = mysqli_connect("localhost","root","");
$db = mysqli_select_db($connection,'accounts');

//query to get data from the table
$query = "SELECT id, username FROM users WHERE admin='0'";

//execute query
$interv = mysqli_query($connection, $query) or die(mysqli_error());

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Home Page</title>
    <link href="evalinterv.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/dataTables.bootstrap.min.css" rel="stylesheet" />
    <link href="css/jquery-confirm.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
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
<div class="content">
    <h2>Évaluation des intervenants</h2>
    <div class="container">
        <br/>
        <div class="floatLeft">
            <table class="choice">
                <tr>
                    <td>
                        <label>Choisissez un intervenant :</label>
                        <select name="interv" id="interv">
                            <option value="0">---</option>
                            <?php while($row = mysqli_fetch_array($interv))
                            {
                                echo "<option value=" .$row['id'] . ">" . $row['username'] . "</option>";
                            }
                            echo "</select>"
                            ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Choisissez le trimestre :</label>
                        <select name="trim" id="trim">
                            <option value="0">---</option>
                            <?php if( $today >= $date1) {?>
                                <option value="1">Avril <---> Juin <?=$year_combo?></option>
                            <?php }?>
                            <?php if( $today >= $date2) {?>
                            <option value="2">Juillet <---> Septembre <?=$year_combo?></option>
                            <?php }?>
                            <?php if( $today >= $date3) {?>
                            <option value="3">Octobre <---> Decembre <?=$year_combo?></option>
                            <?php }?>
                            <?php if( $today >= $date4) {?>
                            <option value="4">Janvier <---> Mars <?=$year_combo + 1?></option>
                            <?php }?>
                        </select>
                    </td>
                </tr>
            </table>
            <table align="center">
                <tr><td>&nbsp;</td></tr>
                <tr><td>&nbsp;</td></tr>
                <tr><td>&nbsp;</td></tr>
                <tr>
                    <td>
                        <button type="button" name="validate" class="btn btn-primary validate">Valider la sélection</button>
                    </td>
                </tr>
            </table>
        </div>
        <div class="floatRight">
            <table>
                <tr>
                    <td>
                        <table class="dashbord">
                            <tr>
                                <td id="statislabel"><label class="label2">Statistiques intervenant pour <?=$year?>/<?=$year + 1?></label></td>
                            </tr>
                            <tr>
                                <!--<td id="statischart"><div id="statisbarchart" class="statisbarchart"></div></td>-->
                                <td><canvas id="myChart" class="myChart" style="width: 100%; height: 40vh; border: 1px; margin-top: 10px;" ></canvas></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>
<script src="js/dataTables.checkboxes.min.js"></script>
<script src="js/Chart.bundle.js"></script>
<script src="js/jquery-confirm.min.js"></script>

<script>

    $(document).ready(function () {

        var myChart=null;
        var ctx = document.getElementById('myChart').getContext("2d");

        $(document).on('click', '.validate', function() {

            var interv = $('#interv');
            var trim = $('#trim');

            console.log(interv);

            if ( interv.val() != 0 && trim.val() != 0) {

                if(myChart!=null){
                    myChart.destroy();
                }

                var today = "<?php echo $today; ?>";
                var year = "<?php echo $year; ?>";
                var send = {
                    interv: interv.val(),
                    trim: trim.val(),
                    today: today,
                    year: year,
                };
                $.ajax({
                    url: "extracteval.php",
                    method: "POST",
                    data: send,
                    dataType: "json",
                    success: function (data) {

                        if (data != null) {

                            var labels = [];
                            var values = [];

                            for (var i in data) {
                                labels.push(data[i].label);
                                values.push(data[i].value);
                            }

                            myChart = new Chart(ctx, {

                                type: 'bar',
                                data: {
                                    labels: labels,
                                    datasets: [
                                        {
                                            barPercentage: 0.5,
                                            barThickness: 6,
                                            maxBarThickness: 8,
                                            minBarLength: 2,
                                            backgroundColor: ["#2868c7", "#8e5ea2", "#3cba9f"],
                                            data: values
                                        }
                                    ]
                                },
                                options: {
                                    responsive: true,
                                    title: {
                                        display: false
                                    },
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                beginAtZero: true
                                            }
                                        }]
                                    },
                                    legend: {
                                        display: false
                                    }
                                }
                            });
                        }
                    },
                    error: function () {

                        alert('error loading orders');
                    }
                });
            } else {

                $.alert({
                    title: 'Notification!',
                    icon: 'fa fa-warning',
                    type: 'orange',
                    animation: 'rotate',
                    content: 'Veuillez choisir l`intervenant et le trimestre.',
                    buttons: {
                        Fermer: function () {
                            this.setCloseAnimation('rotate');
                        }
                    }
                });
            }
        });
    });

</script>
</body>
</html>
