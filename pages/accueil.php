<?php
session_start();
if (!isset($_SESSION["nom"])) {
    echo '<h1>Connectez-vous</h1>';
    header('Location: ../index.php');
    exit();
}
$_SESSION["actif"] = "accueil";
?>
<!DOCTYPE html>
<html lang="FR-fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/MonStyle.css">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/circle.css">
    <title>Accueil</title>
</head>

<body>
    <?php
    include("nav.php");
    ?>
    <header></header>
    <section class="container-fluid">
        <h1 class="textAccueil">Répartition de l'effectif par promo</h1>
        <?php
        $total=0;
        $n=0;
         $fichier = fopen('etudiants.txt', 'r');
        while (!feof($fichier)) {
            $line = fgets($fichier);
            $etudiant = explode('|', $line);
            if ($etudiant[6] != "Expulser") {
                $total++;
            }
        }
        fclose($fichier);

        $monfichier = fopen('promos.txt', 'r');
            while (!feof($monfichier)) {
                $ligne = fgets($monfichier);
                $promo = explode('|', $ligne);
                //////------compter effectif---//////
                $effectif = 0;
                $fichier = fopen('etudiants.txt', 'r');
                while (!feof($fichier)) {
                    $line = fgets($fichier);
                    $etudiant = explode('|', $line);
                    if ($promo[1] == $etudiant[1] && $etudiant[6] != "Expulser") {
                        $effectif++;
                    }
                }
                fclose($fichier);
                ######-------fin compter effectif####
                $p=intval(($effectif/$total)*100);
                if (!isset($_POST["recherche"]) || isset($_POST["recherche"]) && !empty($_POST["aRechercher"]) && strstr(strtolower($ligne), strtolower($_POST["aRechercher"])) || isset($_POST["recherche"]) && empty($_POST["aRechercher"])) {
                echo'  
                   <a href="ListerEtudiant.php?promo=' . $promo[1]  . ' ">
                        <div class="c100 p'.$p.' big">
                            <span>'.$p.'% <br>'.$promo[1].'</span>
                            <div class="slice">
                                <div class="bar"></div>
                                <div class="fill"></div>
                            </div>
                        </div>  
                    </a>';
                    $n++;
                }
            }
            fclose($monfichier); 
        
        echo "<h2 class='bienv'></h2>
        </section>
            <footer class='piedPageaccueil"; if($n>5){echo" margTopAcc80 ";}else{echo" margTopAcc20 ";} echo"'>
                <p class='cpr'>Copyright 2019 Sonatel Academy</p>
            </footer>";
        ?>
    
</body>

</html>