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
    <link href="css/jquery-confirm.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script src="js/jquery-confirm.min.js"></script>
</head>
<script>
    if (<?php echo $_SESSION['cli_exist'] ?> == 1) {
        $.alert({
            title: 'Alerte!',
            icon: 'fa fa-warning',
            type: 'orange',
            animation: 'rotate',
            content: 'Identifiant client non existant ou non appartenant a votre liste de clients!',
            buttons: {
                Fermer: function () {
                    this.setCloseAnimation('rotate');
                }
            }
        });
        <?php $_SESSION['cli_exist'] = 0 ?>
    }
</script>
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
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
        </li>
    </ul>
</nav>
<div class="content">
    <h2>Fiche d'Écoute et Suivi</h2>
</div>
<div class="container box">
    <table id="" class="table table-striped table-bordered">
        <thead>
        <tr>
            <form action="addecoute.php" method="post">
                    <table id="example" class="ecoute" style="width:100%">
                        <!-- Row 1 -->
                        <tr>
                            <td><label>Cocher si le client est déjà existant:</label></td>
                            <td style="text-align:center;"><input type="checkbox" name="new_client" id="new_client" value="no" ></td>
                            <td><label name="label_id_client" id="label_id_client">ID Client:</label></td>
                            <td><input type="number" name="id_client" id="id_client" disabled required></td>
                            <td><button type="button" name="load" class="btn btn-primary load">Afficher client</button></td>
                        </tr>
                        <!-- Row 2 -->
                        <tr>
                            <td><label>Date rendez-vous:</label></td>
                            <td><input id="date_rdv" name="date_rdv" type="date" value="<?php echo $today; ?>"></td>
                            <td><label>Description:</label></td>
                            <td>
                                <select name="description" id="description">
                                    <option>test1</option>
                                    <option>test2</option>
                                </select>
                            </td>
                            <td><label>Type d'appelant:</label></td>
                            <td>
                                <select name="type_appelant" id="type_appelant">
                                    <option>test1</option>
                                </select>
                            </td>
                        </tr>
                        <!-- Row3 -->
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
                            <td><label>Langue utilisée:</label></td>
                            <td>
                                <select name="langue" id="langue">
                                    <option>test1</option>
                                </select>
                            </td>
                        </tr>
                        <!-- Row4 -->
                        <tr>
                            <td><label>Durée:</label></td>
                            <td>
                                <select name="duree" id="duree">
                                    <option>test1</option>
                                </select>
                            </td>
                            <td><label>Réferée Par:</label></td>
                            <td>
                                <select name="ref_par" id="ref_par">
                                    <option>test1</option>
                                </select>
                            </td>
                            <td><label >Date arrivée au canada:</label></td>
                            <td><input id="date_arrivee" name="date_arrivee" type="date"></td>
                        </tr>
                        <!-- Row5 -->
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
                            <td><label>Situation Financière:</label></td>
                            <td>
                                <select name="situ_finance" id="situ_finance">
                                    <option>test1</option>
                                </select>
                            </td>
                        </tr>
                        <!-- Row6 -->
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
                            <td><label>Problème au sante mentale:</label></td>
                            <td>
                                <select name="prob_mentale" id="prob_mentale">
                                    <option>test1</option>
                                </select>
                            </td>
                        </tr>
                        <!-- Row7 -->
                        <tr>
                            <td><label>État civil:</label></td>
                            <td>
                                <select name="etat_civil" id="etat_civil">
                                    <option>test1</option>
                                </select>
                            </td>
                            <td><label>Nombre enfants:</label></td>
                            <td>
                                <input id="nbr_enfant" name="nbr_enfant" type="number">
                            </td>
                            <td><label>État psychologique après l'intervention:</label></td>
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
                        <!-- Row8 -->
                        <tr>
                            <td><label>État psychologique au debut de l'intervention:</label></td>
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
                    </table>
                    <!-- Row9 buttons -->
                    <table id="example" class="button" style="width:15%" align="right">
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

<script>

$(document).ready(function () {

        $('#new_client').click(function(){

            if ($(this).is(":checked")) {

                $('#id_client').attr('disabled',false);
            }
            else {

                $('#id_client').attr('disabled',true);
            }
        });

    $(document).on('click', '.load', function() {

        if ($('#new_client').is(":checked")) {

            var id_client = $('#id_client').val();

            $.ajax({
                url: "fetchoneclient.php",
                method: "POST",
                data: {id_client: id_client},
                dataType: "json",
                success: function (data) {
                    if (data != null) {

                        $('#description').val(data.description);
                        $('#type_appelant').val(data.type_appelant);
                        $('#mode_interv').val(data.mode_interv);
                        $('#type_interv').val(data.type_interv);
                        $('#langue').val(data.langue);
                        $('#duree').val(data.duree);
                        $('#ref_par').val(data.ref_par);
                        $('#sexe').val(data.sexe);
                        $('#age').val(data.age);
                        $('#situ_finance').val(data.situ_finance);
                        $('#origine').val(data.origine);
                        $('#status_canada').val(data.status_canada);
                        $('#prob_mentale').val(data.prob_mentale);
                        $('#etat_civil').val(data.etat_civil);
                        $('#nbr_enfant').val(data.nbr_enfant);
                        $('#psy_apres_interv').val(data.psy_apres_interv);
                        $('#psy_avant_interv').val(data.psy_avant_interv);
                        $('#motif_consult').val(data.motif_consult);
                    } else {

                        $.alert({
                            title: 'Alerte!',
                            icon: 'fa fa-warning',
                            type: 'orange',
                            animation: 'rotate',
                            content: 'Identifiant client inexistant !!!',
                            buttons: {
                                Fermer: function () {
                                    this.setCloseAnimation('rotate');
                                }
                            }
                        });
                    }
                }
            });
        } else {

            $.alert({
                title: 'Alerte!',
                icon: 'fa fa-warning',
                type: 'orange',
                animation: 'rotate',
                content: 'Identifiant du client doit etre saisi !!!',
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