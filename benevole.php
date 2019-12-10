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
    <link href="benevole.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/dataTables.bootstrap.min.css" rel="stylesheet" />
    <link href="css/jquery-confirm.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script src="js/jquery-confirm.min.js"></script>
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
    <h2>Fiche des benevoles et stagiaires</h2>
</div>
<div class="container box">
    <table id="" class="table table-striped table-bordered">
        <thead>
        <tr>
            <form action="addbenevole.php" method="post">
                    <table id="benevole" class="benevole" style="width:50%" align="center">
                        <!-- Row 1 -->
                        <tr>
                            <td><label>Date entree en vigueur:</label></td>
                            <td><input id="date_entree" name="date_entree" type="date" value="<?php echo $today; ?>"></td>
                        </tr>
                        <!-- Row2 -->
                        <tr>
                            <td><label>Role:</label></td>
                            <td>
                                <select name="role" id="role" required>
                                    <option>---</option>
                                    <option>Benevole</option>
                                    <option>Stagiaire</option>
                                </select>
                            </td>
                        </tr>
                        <!-- Row3 -->
                        <tr>
                            <td><label>Nom:</label></td>
                            <td><input type="text" name="nom" id="nom"></td>
                        </tr>
                        <!-- Row4 -->
                        <tr>
                            <td><label>Prenom:</label></td>
                            <td><input type="text" name="prenom" id="prenom"></td>
                        </tr>
                        <!-- Row5 -->
                        <tr>
                            <td><label>Sexe:</label></td>
                            <td>
                                <select name="sexe" id="sexe" required>
                                    <option>---</option>
                                    <option>Homme</option>
                                    <option>Femme</option>
                                    <option>Autre</option>
                                </select>
                            </td>
                        </tr>
                        <!-- Row6 -->
                        <tr>
                            <td><label>Langue:</label></td>
                            <td>
                                <select name="langue" id="langue" required>
                                    <option>---</option>
                                    <option>Arabe</option>
                                    <option>Anglais</option>
                                    <option>Espaniol</option>
                                    <option>Francais</option>
                                    <option>Person</option>
                                    <option>Russe</option>
                                </select>
                            </td>
                        </tr>
                        <!-- Row7 -->
                        <tr>
                            <td><label>Tache:</label></td>
                            <td>
                                <select name="tache" id="tache" required>
                                    <option>---</option>
                                    <option>Tache1</option>
                                    <option>Tache2</option>
                                    <option>Tache3</option>
                                    <option>Tache4</option>
                                    <option>Tache5</option>
                                </select>
                            </td>
                        </tr>
                        <!-- Row8 -->
                        <tr>
                            <td><label>Domaine:</label></td>
                            <td>
                                <select name="domaine" id="domaine" required>
                                    <option>---</option>
                                    <option>Domaine1</option>
                                    <option>Domaine2</option>
                                    <option>Domaine3</option>
                                    <option>Domaine4</option>
                                    <option>Domaine5</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                        <!-- Row9 buttons -->
                    <table id="example" class="button" style="width:15%" align="right" >
                        <tr><td>&nbsp;</td></tr>
                        <tr><td>&nbsp;</td></tr>
                        <tr><td>&nbsp;</td></tr>
                        <tr>
                            <td>
                                <input type="submit" name="validate" value="Ajouter" class="btn btn-primary" />
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