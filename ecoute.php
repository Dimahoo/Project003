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
            content: 'Identifiant client non existant ou non appartenant à votre liste de clients!',
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
                            <td><label>Écoute: </label></td>
                            <td style="text-align:center;"><input type="checkbox" name="ecoute" id="ecoute" value="yes" ></td>
                            <td><label>Suivi: </label></td>
                            <td style="text-align:center;"><input type="checkbox" name="suivi" id="suivi" value="yes" ></td>
                        </tr>
                        <!-- Row 2 -->
                        <tr>
                            <td><label>Date rendez-vous:</label></td>
                            <td><input id="date_rdv" name="date_rdv" type="date" value="<?php echo $today; ?>"></td>
                            <td><label>Description:</label></td>
                            <td>
                                <select name="description" id="description">
                                    <option>---</option>
                                    <option>Suivi</option>
                                    <option>Ecoute</option>
                                </select>
                            </td>
                            <td><label>Type d'appelant:</label></td>
                            <td>
                                <select name="type_appelant" id="type_appelant">
                                    <option>---</option>
                                    <option>Regulier</option>
                                    <option>General</option>
                                    <option>Tierce personne</option>
                                    <option>Autre</option>
                                </select>
                            </td>
                        </tr>
                        <!-- Row3 -->
                        <tr>
                            <td><label>Mode d'intervention:</label></td>
                            <td>
                                <select name="mode_interv" id="mode_interv">
                                    <option>---</option>
                                    <option>Face a face</option>
                                    <option>Telephone</option>
                                    <option>Autre</option>
                                </select>
                            </td>
                            <td><label>Type d'intervention:</label></td>
                            <td>
                                <select name="type_interv" id="type_interv">
                                    <option>---</option>
                                    <option>Ecoute</option>
                                    <option>Appel Obscene</option>
                                    <option>Raccrochage</option>
                                    <option>Intervention Psychosociale</option>
                                    <option>Autre</option>
                                </select>
                            </td>
                            <td><label>Langue utilisée:</label></td>
                            <td>
                                <select name="langue" id="langue">
                                    <option>---</option>
                                    <option>Arabe</option>
                                    <option>Anglais</option>
                                    <option>Espagnol</option>
                                    <option>Francais</option>
                                    <option>Persan</option>
                                    <option>Russe</option>
                                    <option>Autre</option>
                                </select>
                            </td>
                        </tr>
                        <!-- Row4 -->
                        <tr>
                            <td><label>Durée:</label></td>
                            <td>
                                <select name="duree" id="duree">
                                    <option>---</option>
                                    <option>< 5 min</option>
                                    <option>5-15 min</option>
                                    <option>15-30 min</option>
                                    <option>30-45 min</option>
                                    <option>45-60 min</option>
                                    <option>> 1h<option>
                                </select>
                            </td>
                            <td><label>Réferée Par:</label></td>
                            <td>
                                <select name="ref_par" id="ref_par">
                                    <option>---</option>
                                    <option>CLSC</option>
                                    <option>PRAIDA</option>
                                    <option>CLE</option>
                                    <option>CDN</option>
                                    <option>CLSC</option>
                                    <option>ORGANISME QUARTIER</option>
                                    <option>CLSC</option>
                                    <option>IMM CA</option>
                                    <option>MICC</option>
                                    <option>AUTRE CENTRE D ECOUTE</option>
                                    <option>AMI FAMILLE</option>
                                    <option>PROJET GENESE</option>
                                    <option>AUTRE</option>
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
                                    <option>---</option>
                                    <option>Homme</option>
                                    <option>Femme</option>
                                    <option>Autre</option>
                                </select>
                            </td>
                            <td><label>Age:</label></td>
                            <td>
                                <select name="age" id="age">
                                    <option>---</option>
                                    <option>15 - 24</option>
                                    <option>25 - 34</option>
                                    <option>35 - 44</option>
                                    <option>45 - 54</option>
                                    <option>55 - 64</option>
                                    <option>65 et +<option>
                                </select>
                            </td>
                            <td><label>Situation Financière:</label></td>
                            <td>
                                <select name="situ_finance" id="situ_finance">
                                    <option>---</option>
                                    <option>Aide sociale</option>
                                    <option>Chomage</option>
                                    <option>Salaire mininum</option>
                                    <option>Etudiant</option>
                                    <option>Sans revenu</option>
                                    <option>Pension Vieillesse</option>
                                    <option>Travail</option>
                                    <option>Autre</option>
                                </select>
                            </td>
                        </tr>
                        <!-- Row6 -->
                        <tr>
                            <td><label>Origine:</label></td>
                            <td>
                                <select name="origine" id="origine">
                                    <option>---</option>
                                    <option>Asiatique</option>
                                    <option>Moyen Orient</option>
                                    <option>Afrique</option>
                                    <option>Afrique du nord</option>
                                    <option>Afrique du sud et centrale</option>
                                    <option>Amerique du nord</option>
                                    <option>Europe de l est</option>
                                    <option>Europeen</option>
                                    <option>Latino et Caraibe</option>
                                    <option>Canadien</option>
                                    <option>Autre</option>
                                </select>
                            </td>
                            <td><label>Status au Canada:</label></td>
                            <td>
                                <select name="status_canada" id="status_canada">
                                    <option>---</option>
                                    <option>DA</option>
                                    <option>RA</option>
                                    <option>RP</option>
                                    <option>CIT</option>
                                    <option>ET</option>
                                    <option>T</option>
                                    <option>SS</option>
                                    <option>TT</option>
                                </select>
                            </td>
                            <td><label>Problème de sante mentale:</label></td>
                            <td>
                                <select name="prob_mentale" id="prob_mentale">
                                    <option>---</option>
                                    <option>OUI</option>
                                    <option>NON</option>
                                </select>
                            </td>
                        </tr>
                        <!-- Row7 -->
                        <tr>
                            <td><label>État civil:</label></td>
                            <td>
                                <select name="etat_civil" id="etat_civil">
                                    <option>---</option>
                                    <option>M</option>
                                    <option>C</option>
                                    <option>V</option>
                                    <option>S</option>
                                    <option>D</option>
                                    <option>CF</option>
                                </select>
                            </td>
                            <td><label>Nombre enfants:</label></td>
                            <td>
                                <input id="nbr_enfant" name="nbr_enfant" type="number">
                            </td>
                            <td><label>État psychologique après l'intervention:</label></td>
                            <td>
                                <select name="psy_apres_interv" id="psy_apres_interv">
                                    <option>---</option>
                                    <option>Soulagee</option>
                                    <option>Motivee</option>
                                    <option>Calme</option>
                                    <option>A de l espoir</option>
                                    <option>Pire</option>
                                    <option>Status quo</option>
                                    <option>Piste de solution</option>
                                    <option>Autre</option>
                                </select>
                            </td>
                        </tr>
                        <!-- Row8 -->
                        <tr>
                            <td><label>État psychologique au debut de l'intervention:</label></td>
                            <td>
                                <select name="psy_avant_interv" id="psy_avant_interv">
                                    <option>---</option>
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
                                    <option>---</option>
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

    $("#ecoute").prop("checked", true);

    $("#ecoute").click(function(){

        var ischecked = $(this).is(":checked");

        if (ischecked) {

            $("#suivi").prop("checked", false);
        }

        if (!ischecked) {

            $("#suivi").prop("checked", true);
        }
    });

    $("#suivi").click(function(){

        var ischecked = $(this).is(":checked");

        if (ischecked) {

            $("#ecoute").prop("checked", false);
        }

        if (!ischecked) {

            $("#ecoute").prop("checked", true);
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
                content: 'Identifiant du client doit être saisi !!!',
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