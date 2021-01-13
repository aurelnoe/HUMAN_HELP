<?php
include_once("Controller/AccueilController.php");
include_once("Presentation/PresentationAccueil.php");
?>
<!DOCTYPE html>
<html lang="en">    
<head>
    <?php include("head.php"); ?>
    <title>ACCUEIL</title>
</head>
<body>
    <?php
    include("Templates/Bases/navbarDev.php");

    include("Templates/Bases/navbar.php");
    
    echo (isset($_GET['action']) && $_GET['action']=='ajout') ? '<div class="alert alert-success text-center">L\'utilisateur a été ajouté avec succès !</div>': '';
    
    echo accueil($articles,$missionsADistance,$allMissions,$newTypeActivite,$newPays); 
         
    include("Templates/Bases/footer.php") 
    ?>
</body>
</html>