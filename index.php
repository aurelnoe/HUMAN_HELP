<?php
include_once("Controller/AccueilController.php");
include_once("Presentation/PresentationAccueil.php");
include_once("Presentation/PresentationCommun.php");
?>
<!DOCTYPE html>
<html lang="en">    
<head>
    <?php include("head.php"); ?>
    <title>ACCUEIL</title>
</head>
<body>
    <?php
    echo navbar();
    
    echo (isset($_GET['action']) && $_GET['action']=='ajout') ? '<div class="alert alert-success text-center">L\'utilisateur a été ajouté avec succès !</div>': '';
    
    echo accueil($articles,$missionsADistance,$allMissions); 
         
    echo footer(); 
    ?>
</body>
</html>