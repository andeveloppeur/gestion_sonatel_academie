<?php
echo '<nav class="navbar navbar-expand-lg navbar-light row fixed-top" style="background-color: #007bffb9;">
  <a class="navbar-brand" href="#"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item  ';if ($_SESSION["actif"] == "accueil") {echo 'active';}echo '">
        <a class="nav-link" href="accueil.php">Accueil<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item ';if ($_SESSION["actif"] == "ModifierEtudiant") {echo 'active';}echo '">
        <a class="nav-link" href="ModifierEtudiant.php">Gestion des étudiants</a>
      </li>
      <li class="nav-item ';if ($_SESSION["actif"] == "ModifierPromo") {echo 'active';}echo '">
        <a class="nav-link" href="ModifierPromo.php">Gestion des promos</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="deconnexion.php">Déconnexion</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0" method="POST" action="">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="aRechercher"';
      if(isset($_POST[ "recherche"]) && !empty($_POST[ "aRechercher"])){echo'value="'.$_POST["aRechercher"].'"'; } echo'>
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="recherche">Search</button>';
      if(isset($_POST[ "recherche"]) && !empty($_POST[ "aRechercher"])){echo'<button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="finRecherche">Fin</button>';}
    echo'</form>
  </div>
</nav>';
?>
