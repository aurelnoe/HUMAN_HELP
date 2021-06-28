<?php 
session_start();
include_once(PATH_BASE . "Presentation/PresentationAccueil.php");
include_once(PATH_BASE . "/Services/serviceBlog.php");
include_once(PATH_BASE . "/Services/ServiceMission.php");
include_once(PATH_BASE . "/Services/ServicePays.php");
include_once(PATH_BASE . "/Services/serviceTypeActivite.php");
include_once(PATH_BASE . "/Services/ServiceUtilisateur.php");

if (isset($_GET['action']) && $_GET['action'] == 'deconnection') {
    session_destroy();
    header('Location: ../index.php');
}

$page = (!empty($_GET['page']) ? $_GET['page'] : 1);
$service = new ServiceBlog(); 
$mission = new ServiceMission();
$newPays = new ServicePays();
$newTypeActivite = new ServiceTypeActivite();

$missionsADistance = $mission->searchMissions(null,null,A_DISTANCE,$page);
$allMissions = $mission->searchAll();

$articles = $service->searchAll();

echo accueil($articles,$missionsADistance,$allMissions,$_SESSION);