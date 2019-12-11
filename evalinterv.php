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
$query1 = "SELECT id, username FROM users WHERE admin='0'";

//query to get data from the table
$query2 = "SELECT id, username FROM users";

//execute query
$interv1 = mysqli_query($connection, $query1) or die(mysqli_error());
$interv2 = mysqli_query($connection, $query2) or die(mysqli_error());

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
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-confirm.min.js"></script>
</head>
<script>
    if ('<?php echo $_SESSION['addeval']?>' == 1) {
        $.alert({
            title: 'Notification!',
            icon: 'fa fa-warning',
            type: 'orange',
            animation: 'rotate',
            content: 'Évaluation Ajoutée!',
            buttons: {
                Fermer: function () {
                    this.setCloseAnimation('rotate');
                }
            }
        });
        <?php $_SESSION['addeval'] = 0 ?>
    }
    if ('<?php echo $_SESSION['existeval']?>' == 1) {
        $.alert({
            title: 'Notification!',
            icon: 'fa fa-warning',
            type: 'orange',
            animation: 'rotate',
            content: 'Évaluation déjà existante!',
            buttons: {
                Fermer: function () {
                    this.setCloseAnimation('rotate');
                }
            }
        });
        <?php $_SESSION['existeval'] = 0 ?>
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
                    <li><a href="delete.php">Suppression</a></li>
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
    <h2>Évaluation du personnel</h2>
    <div class="container">
        <br/>
        <div class="floatLeft">
            <table class="choice">
                <tr>
                    <td>
                        <label>Choisissez un intervenant :</label>
                        <select name="interv" id="interv">
                            <option value="0">---</option>
                            <?php while($row = mysqli_fetch_array($interv1))
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
                <tr>
                    <td>
                        <button type="button" name="evaluate" data-toggle="modal" data-target="#addevalmodal" class="btn btn-primary evaluate">Ajouter une évaluation</button>
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

<!-- Modal -->
<div class="modal fade bd-example-modal-xl" id="addevalmodal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:700px; height:700px;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Ajouter une Évaluation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="addeval.php" method="post">
                <div class="modal-body">
                    <table id="eval" class="eval" style="width:50%" align="center">
                        <!-- Row 1 -->
                        <tr>
                            <td><label>Intervenant:</label></td>
                            <td><select name="interv" id="interv">
                                    <option value="0">---</option>
                                        <?php while($row = mysqli_fetch_array($interv2))
                                        {
                                            echo "<option value=" .$row['id'] . ">" . $row['username'] . "</option>";
                                        }
                                            echo "</select>"
                                ?>
                            </td>
                        </tr>
                        <!-- Row 2 -->
                        <tr>
                            <td><label>Trimestre courant:</label></td>
                            <td>
                                <select name="trim" id="trim" readonly="">
                                    <?php if( $today >= $date1 AND $today <= $date2) {?>
                                        <option value="1">Avril <---> Juin <?=$year_combo?></option>
                                    <?php }?>
                                    <?php if( $today >= $date2 AND $today <= $date3) {?>
                                        <option value="2">Juillet <---> Septembre <?=$year_combo?></option>
                                    <?php }?>
                                    <?php if( $today >= $date3 AND $today <= $date4) {?>
                                        <option value="3">Octobre <---> Decembre <?=$year_combo?></option>
                                    <?php }?>
                                    <?php if( $today >= $date4) {?>
                                        <option value="4">Janvier <---> Mars <?=$year_combo + 1?></option>
                                    <?php }?>
                                </select>
                            </td>
                        </tr>
                        <!-- Row 3 -->
                        <tr>
                            <td><label>Note:</label></td>
                            <td><input type="number" id="note" name="note" min="0" max="100" ></td>
                        </tr>
                        <!-- Row 4 -->
                        <tr>
                            <td><label>Commmentaire:</label></td>
                            <td><textarea rows = "3" cols = "50" id="comment" name = "comment"></textarea></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <!-- Row7 buttons -->
                    <table id="button" class="evalbutton" style="width:15%" align="right">
                        <tr>
                            <td>
                                <input type="submit" name="addeval" value="Ajouter" class="btn btn-primary" />
                            </td>
                            <td>
                                <input type="button" name="cancel" value="Annuler" class="btn btn-secondary"  data-dismiss="modal" />
                            </td>
                        </tr>
                    </table>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>
<script src="js/dataTables.checkboxes.min.js"></script>
<script src="js/Chart.bundle.js"></script>

<script>

    function isNumber(event) {

        var keycode=event.keyCode;
        if(keycode >= 0 && keycode <= 100) {

            return true;
        }
        return false;
    }

    $(document).ready(function () {

        var myChart=null;
        var ctx = document.getElementById('myChart').getContext("2d");

        $(document).on('click', '.evaluate', function() {

            var rdv_id = $(this).attr("id");

            $.ajax({
                url:"rdvfetchupdate.php",
                method:"POST",
                data:{rdv_id:rdv_id},
                dataType:"json",
                success:function(data){
                    $('#id_rdv').val(data.id);
                    $('#interv').val(data.interv);
                    $('#id_cli').val(data.id_cli);
                    $('#date_rdv').val(data.date_rdv);
                    $('#type').val(data.type);
                }
            });
        });

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
