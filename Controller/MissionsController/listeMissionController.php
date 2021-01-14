<?php
include_once($_SERVER['DOCUMENT_ROOT']."/HUMAN_HELP/config.php");
session_start();
include_once(PATH_BASE . "/Services/ServiceMission.php");
include_once(PATH_BASE . "/Services/serviceTypeActivite.php");
require_once(PATH_BASE . "/Services/ServicePays.php");
include_once(PATH_BASE . "/Exceptions/ServiceException.php");
include_once(PATH_BASE . "/Presentation/PresentationMission.php");
$_GET = array_map('htmlentities',$_GET); 
$_COOKIE = array_map('htmlentities',$_COOKIE);
$_REQUEST = array_map('htmlentities',$_REQUEST);
$_POST = array_map('htmlentities',$_POST);

try {
    $serviceMission = new ServiceMission();
    $serviceTypeActivite = new ServiceTypeActivite();
    $servicePays = new ServicePays();  
    $professionnel = isset($_SESSION['mailUtil']) && isset($_SESSION['idUtil']) && $_SESSION['role'] == 'professionnel';
    
    echo listeMissions($serviceMission,$serviceTypeActivite,$servicePays,$professionnel);  
} 
catch (ServiceException $se) {
    $serviceMission = new ServiceMission();
    $serviceTypeActivite = new ServiceTypeActivite();
    $servicePays = new ServicePays();
    $professionnel = isset($_SESSION['mailUtil']) && isset($_SESSION['idUtil']) && $_SESSION['role'] == 'professionnel';
    
    echo listeMissions($serviceMission,$serviceTypeActivite,$servicePays,$professionnel,$se->getCode());  

}

?>