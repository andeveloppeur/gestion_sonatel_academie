<?php
session_start();
if (!isset($_SESSION["nom"])) {
    echo '<h1>Connectez-vous</h1>';
    header('Location: ../index.php');
    exit();
}
$_SESSION["actif"] = "ListerEtudiant";
if (isset($_GET["promo"])) {
    $Promo = $_GET["promo"];
} 
elseif (isset($_POST["promo"])) {
    $Promo = $_POST["promo"];
}
?>
<!DOCTYPE html>
<html lang="FR-fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/MonStyle.css">
    <title>>Liste des étudiants</title>
</head>

<body>
    <?php
    include("nav.php");
    ?>
    <header></header>
    <section class="container-fluid  cAuth">
        <form method="POST" action="ListerEtudiant.php" class="MonForm row insc">
            <div class="col-md-3"></div>
            <div class="col-md-6 bor">
                <?php
                ///////////////////////////-------Promo---------------------//////////////////////
                echo '<div class="row">
                        <div class="col-md-2"></div>
                        <select class="form-control col-md-8 espace" name="promo" >';
                $monfichier = fopen("promos.txt", "r");
                while (!feof($monfichier)) {
                    $ligne = fgets($monfichier);
                    $etudiants = explode("|", $ligne);
                    if ($Promo == $etudiants[1]) {
                        echo '<option value="' . $etudiants[1] . '" selected>' . $etudiants[1] . '</option>';
                    } 
                    else {
                        echo '<option value="' . $etudiants[1] . '">' . $etudiants[1] . '</option>';
                    }
                }
                fclose($monfichier);
                echo '</select>
                    </div>';
                ///////////////////////////-------Fin Promo---------------------//////////////////////
                echo '<div class="row">
                <div class="col-md-3"></div>
                <input type="submit" class="form-control col-md-6 espace" value="Lister" name="valider">
            </div>';
                ?>
            </div>
        </form>
        <?php
        if (isset($_POST["promo"]) || isset($_GET["promo"])) {
            echo '<table class="col-12 tabliste table">
            <thead class="thead-dark">
                <tr class="row">
                    <td class="col-md-1 text-center gras">Code</td>
                    <td class="col-md-2 text-center gras">Promo</td>
                    <td class="col-md-2 text-center gras">Nom</td>
                    <td class="col-md-2 text-center gras">Date de naissance</td>
                    <td class="col-md-2 text-center gras">Téléphone</td>
                    <td class="col-md-2 text-center gras">Email</td>
                    <td class="col-md-1 text-center gras">Statut</td>
                </tr>
            </thead>';
            ///////////////////////////////////------Debut Bloquer-----////////////////////////////
            $nouv = "";
            $monfichier = fopen('etudiants.txt', 'r');
            if (isset($_GET["code"])) {
                $aChanger = $_GET["code"];
                while (!feof($monfichier)) {
                    $ligne = fgets($monfichier);
                    $element = explode('|', $ligne);
                    if ($element[0] == $aChanger) {
                        if ($element[6] == "Accepter") { //si son statut est Accepter on le bloque
                            $nouv = $nouv . $element[0] . "|" . $element[1] . "|" . $element[2] . "|" . $element[3] . "|" . $element[4] . "|" . $element[5] . "|Expulser|";
                        } 
                        elseif ($element[6] == "Expulser") { //inversement
                            $nouv = $nouv . $element[0] . "|" . $element[1] . "|" . $element[2] . "|" . $element[3] . "|" . $element[4] . "|" . $element[5] . "|Accepter|";
                        }
                        $nouv = $nouv . "\n"; //pour gerer le retour à la ligne qui n est pas gerer par les 2 cas d en haut mais les autre de la variable $ligne le gere
                    } 
                    else {
                        $nouv = $nouv . $ligne; //on ne change pas la ligne si le login ne correspond pas à celui de la ligne
                    }
                }
                fclose($monfichier);
                if ($nouv != "") {
                    $monfichier = fopen('etudiants.txt', 'w+');
                    fwrite($monfichier, trim($nouv)); //on ecrit le fichier pour enregister la modification du statut de l utilisateur le trim est utiliser pour suprimer un eventuel retour à la ligne 
                    fclose($monfichier);
                    //header('Location: ListerEtudiant.php#' . $aChanger); ne pas mettre à cause de toutes les informations qui passent par l'url
                }
            }
            ####################################------Fin Bloquer-----##############################


            /////////////////////////////////////////------Debut Affichage-----///////////////////////// 
            $monfichier = fopen('etudiants.txt', 'r');
            while (!feof($monfichier)) {
                $ligne = fgets($monfichier);
                $etudiant = explode('|', $ligne);
                if ($etudiant[1] == $Promo && !isset($_POST["recherche"]) || isset($_POST["recherche"])  && !empty($_POST["aRechercher"]) && strstr(strtolower($ligne), strtolower($_POST["aRechercher"])) && !empty($_POST["aRechercher"]) || $etudiant[1] == $Promo && isset($_POST["recherche"]) && empty($_POST["aRechercher"])) {
                    echo
                        '<tr class="row">
                            <td class="col-md-1 text-center">' . $etudiant[0] . '</td>
                            <td class="col-md-2 text-center">' . $etudiant[1] . '</td>
                            <td class="col-md-2 text-center">' . $etudiant[2] . '</td>
                            <td class="col-md-2 text-center">' . $etudiant[3] . '</td>
                            <td class="col-md-2 text-center">' . $etudiant[4] . '</td>
                            <td class="col-md-2 text-center">' . $etudiant[5] . '</td>
                            <td class="col-md-1 text-center"><a href="ListerEtudiant.php?code=' . $etudiant[0] . '&promo=' . $Promo .  '"   id="' . $etudiant[0] . '" ><button class="form-control';
                    if ($etudiant[6] == "Expulser") {
                            echo " btn-outline-danger ";
                    }
                    else{
                        echo " btn-outline-success ";
                    }
                    echo  '" >' . $etudiant[6] . '</button></a></td>
                        </tr>';
                }
            }
            fclose($monfichier);
            ####################################------Fin Affichage-----#################################
        }
        ?>
        </table>
    </section>
    <?php
    include("piedDePage.php");
    ?>
</body>

</html>