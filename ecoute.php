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

$today = $year . '-' . $month . '-' . $day;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Home Page</title>
    <link href="ecoute.css" rel="stylesheet" type="text/css">
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
    var create = '<?php echo $_SESSION['create']?>';
    console.log("voila " + create);
    if (create == 1) {
        alert("New user created successfully!");
        <?php $_SESSION['create'] = 0 ?>
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
    <h2>Fiche d'Ecoute et Suivi</h2>
</div>
<div class="container box">
    <table id="" class="table table-striped table-bordered">
        <thead>
        <tr>
            <form action="addecoute.php" method="post">
                    <table id="example" class="ecoute" style="width:100%">
                        <!-- Row 1 -->
                        <tr>
                            <td><label>Date inscription:</label></td>
                            <td><input id="date_inscription" name="date_inscription" type="date" value="<?php echo $today; ?>"></td>
                            <td><label>Description:</label></td>
                            <td>
                                <select name="description" id="description">
                                    <option>test1</option>
                                </select>
                            </td>
                            <td><label>Type d'appelant:</label></td>
                            <td>
                                <select name="type_appelant" id="type_appelant">
                                    <option>test1</option>
                                </select>
                            </td>
                        </tr>
                        <!-- Row2 -->
                        <tr>
                            <td><label>Mode d'intervention:</label></td>
                            <td>
                                <select name="mode_interv" id="mode_interv">
                                    <option>test1</option>
                                </select>
                            </td>
                            <td><label>Type d'intervention:</label></td>
                            <td>
                                <select name="type_interv" id="type_interv">
                                    <option>test1</option>
                                </select>
                            </td>
                            <td><label>Langue utilisee:</label></td>
                            <td>
                                <select name="langue" id="langue">
                                    <option>test1</option>
                                </select>
                            </td>
                        </tr>
                        <!-- Row3 -->
                        <tr>
                            <td><label>Duree:</label></td>
                            <td>
                                <select name="duree" id="duree">
                                    <option>test1</option>
                                </select>
                            </td>
                            <td><label>Referee Par:</label></td>
                            <td>
                                <select name="ref_par" id="ref_par">
                                    <option>test1</option>
                                </select>
                            </td>
                            <td><label >Date arrivee au canada:</label></td>
                            <td><input id="date_arrivee" name="date_arrivee" type="date"></td>
                        </tr>
                        <!-- Row4 -->
                        <tr>
                            <td><label>Sexe:</label></td>
                            <td>
                                <select name="sexe" id="sexe">
                                    <option>test1</option>
                                </select>
                            </td>
                            <td><label>Age:</label></td>
                            <td>
                                <select name="age" id="age">
                                    <option>test1</option>
                                </select>
                            </td>
                            <td><label>Situation Financiere:</label></td>
                            <td>
                                <select name="situ_finance" id="situ_finance">
                                    <option>test1</option>
                                </select>
                            </td>
                        </tr>
                        <!-- Row5 -->
                        <tr>
                            <td><label>Origine:</label></td>
                            <td>
                                <select name="origine" id="origine">
                                    <option>test1</option>
                                </select>
                            </td>
                            <td><label>Status au Canada:</label></td>
                            <td>
                                <select name="status_canada" id="status_canada">
                                    <option>test1</option>
                                </select>
                            </td>
                            <td><label>Probleme au sante mentale:</label></td>
                            <td>
                                <select name="prob_mentale" id="prob_mentale">
                                    <option>test1</option>
                                </select>
                            </td>
                        </tr>
                        <!-- Row6 -->
                        <tr>
                            <td><label>Etat civil:</label></td>
                            <td>
                                <select name="etat_civil" id="etat_civil">
                                    <option>test1</option>
                                </select>
                            </td>
                            <td><label>Nombre enfants:</label></td>
                            <td>
                                <input id="nbr_enfant" name="nbr_enfant" type="number">
                            </td>
                            <td><label>Etat psychologique apres l'intervention:</label></td>
                            <td>
                                <select name="psy_apres_interv" id="psy_apres_interv">
                                    <option>Joyeuse</option>
                                    <option>Colerique</option>
                                    <option>Deprimee</option>
                                    <option>Mal dans sa peau</option>
                                    <option>Angoissee</option>
                                    <option>Agressive</option>
                                    <option>Confuse</option>
                                    <option>Incoherante</option>
                                    <option>Triste</option>
                                    <option>Autre</option>
                                </select>
                            </td>
                        </tr>
                        <!-- Row7 -->
                        <tr>
                            <td><label>Etat psychologique au debut de l'intervention:</label></td>
                            <td>
                                <select name="psy_avant_interv" id="psy_avant_interv">
                                    <option>Joyeuse</option>
                                    <option>Colerique</option>
                                    <option>Deprimee</option>
                                    <option>Mal dans sa peau</option>
                                    <option>Angoissee</option>
                                    <option>Agressive</option>
                                    <option>Confuse</option>
                                    <option>Incoherante</option>
                                    <option>Triste</option>
                                    <option>Autre</option>
                                </select>
                            </td>
                            <td><label>Motif consultation:</label></td>
                            <td>
                                <select name="motif_consult" id="motif_consult">
                                    <option>Dependance</option>
                                    <option>Diff d'attaptation</option>
                                    <option>Problemes d'immigration</option>
                                    <option>Probleme materiel</option>
                                    <option>Probleme psychologique</option>
                                    <option>Probleme de sante</option>
                                    <option>Sexualite</option>
                                    <option>Solitude</option>
                                    <option>Suicide</option>
                                    <option>Violance</option>
                                    <option>Autre</option>
                                </select>
                            </td>
                        </tr>
                        <!-- Row7 buttons -->
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <input type="submit" name="validate" value="Valider" class="btn btn-primary" />
                            </td>
                            <td>
                                <input type="button" name="cancel" value="Annuler" class="btn btn-secondary" onClick="window.location='home.php';" />
                            </td>
                        </tr>
                    </table>
            </form>
        </tr>
        </thead>
    </table>
</div>
</div>
</div>

</body>
</html>