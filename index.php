<?php
include_once($_SERVER['DOCUMENT_ROOT']."/HUMAN_HELP/Security/config.php");
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
    include("Controller/HeaderController/headerController.php");
    
    echo (isset($_GET['action']) && $_GET['action']=='ajout') ? '<div class="alert alert-success text-center">L\'utilisateur a été ajouté avec succès !</div>': '';
    
    //ACTUELLEMENT EN COUR D'AMELIORATION
    
    if(empty($_GET['q'])) 
        {
            include("./Controller/AccueilController.php");        
        }
        else {
            if (empty($_GET['action'])) {
                include(getcwd().'/Controller/'.$_GET['q'].'.php');
                if (!empty($_GET['idMission'])) {
                    include(getcwd().'/Controller/'.$_GET['q'].'.php?idMission='.$_GET['idMission']);
                }
            } elseif(!empty($_GET['action']) && empty($_GET['idMission'])) {
                echo 'CONNEXION';
                include(getcwd().'/Controller/'.$_GET['q'].'.php?action='.$_GET['action']);
            } elseif(!empty($_GET['action']) && !empty($_GET['idMission'])) {
                include(getcwd().'/Controller/'.$_GET['q'].'.php?action='.$_GET['action'].'&idMission='.$_GET['idMission']);
            } elseif(!empty($_GET['action']) && !empty($_GET['idUtilisateur'])) {
                include(getcwd().'/Controller/'.$_GET['q'].'.php?action='.$_GET['action'].'&idMission='.$_GET['idUtilisateur']);
            }
        } 
         
    echo footer(); 
    ?>
</body>
</html>