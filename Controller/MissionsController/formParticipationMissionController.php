<?php
session_start();
include_once(PATH_BASE . "/Services/ServiceMission.php");
include_once(PATH_BASE . "/Exceptions/ServiceException.php");
include_once(PATH_BASE . "/Presentation/PresentationMission.php");
$_GET = array_map('htmlentities',$_GET); 
$_COOKIE = array_map('htmlentities',$_COOKIE);
$_REQUEST = array_map('htmlentities',$_REQUEST);
$_POST = array_map('htmlentities',$_POST);

if ($_SESSION) {
    try {
        $serviceMission = new ServiceMission();
        $mission = $serviceMission->searchById($_GET['idMission']);
        
        echo formParticipationMission($mission);
        die;
    } 
    catch (ServiceException $se) {
        $serviceMission = new ServiceMission();
        $mission = $serviceMission->searchById($_GET['idMission']);
        
        echo formParticipationMission($mission,$se->getCode());
    }
}else {
    echo connexion('Vous devez être connecté pour vous inscrire à une mission',null);
    die;
}