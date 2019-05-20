<?php
session_start();
if ($_SESSION['ouvert'] == 1) {
    session_destroy(); /*lorsque la session est ouvert 
                    et qu on se deconnecte on revient sur cette page et la session est detruite*/
}
header("location: ../index.php");
?>