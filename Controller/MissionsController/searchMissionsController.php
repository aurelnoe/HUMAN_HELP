<?php
include_once($_SERVER['DOCUMENT_ROOT']."/HUMAN_HELP/config.php");
session_start();
include_once(PATH_BASE . "/Services/ServiceMission.php");
include_once(PATH_BASE . "/Services/serviceTypeActivite.php");
include_once(PATH_BASE . "/Services/ServicePays.php");
include_once(PATH_BASE . "/Exceptions/ServiceException.php");
include_once(PATH_BASE . "/Presentation/PresentationMission.php");
$_GET = array_map('htmlentities',$_GET); 
$_COOKIE = array_map('htmlentities',$_COOKIE);
$_REQUEST = array_map('htmlentities',$_REQUEST);
$_POST = array_map('htmlentities',$_POST);

if (!empty($_GET)) 
{
    $serviceMission = new ServiceMission();
    $serviceTypeActivite = new ServiceTypeActivite();
    $servicePays = new ServicePays();

    //TRI PAR TYPE ACTIVITE  
    if (!empty($_GET['idTypeActivite'])) {
        try {
            $missions = $serviceMission->searchMissionByTypeActivite($_GET['idTypeActivite']);
            $typeActivite = $serviceTypeActivite->searchById($_GET['idTypeActivite']);
            $title = utf8_encode(ucfirst($typeActivite->getTypeActivite()));
            
            echo searchMission($missions,$title);   
        } 
        catch (ServiceException $se) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }
    //TRI PAR PAYS 
    else if (!empty($_GET['idPays'])) {
        try {
            $missions = $serviceMission->searchMissionByPays($_GET['idPays']);
            $pays = $servicePays->searchById($_GET['idPays']);
            $title = ucfirst($pays->getNomPays());
    
            echo searchMission($missions,$title);
        } 
        catch (ServiceException $se) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }
    //TRI PAR TYPE FORMATION 
    else if (!empty($_GET['typeFormation'])) {
        try {
            $missions = $serviceMission->searchMissionByTypeFormation($_GET['typeFormation']);
            if ($_GET['typeFormation']==0) {
                $title = 'Missions à distance';
            }
            else {
                $title = 'Missions sur le terrain';
            }
            echo searchMission($missions,$title);   
        }
        catch (ServiceException $se) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }

    // try { 
            
    //     if (!empty($_GET['idPays']) && empty($_GET['idTypeActivite'])){
    //         $pays = $servicePays->searchById($_GET['idPays']);
    //         $title = ucfirst($pays->getNomPays());  
    //         $missions = $serviceMission->searchMissions($_GET['idPays'],null,null);
    //     }
    //     else if (empty($_GET['idPays']) && !empty($_GET['idTypeActivite'])) {
    //         $typeActivite = $serviceTypeActivite->searchById($_GET['idTypeActivite']);
    //         $title = utf8_encode(ucfirst($typeActivite->getTypeActivite()));
    //         $missions = $serviceMission->searchMissions(null,$_GET['idTypeActivite'],null);
    //     }
    //     else if (!empty($_GET['idPays']) && !empty($_GET['idTypeActivite'])) {      
    //         $pays = $servicePays->searchById($_GET['idPays']);
    //         $typeActivite = $serviceTypeActivite->searchById($_GET['idTypeActivite']);
    //         $title = utf8_encode(ucfirst($typeActivite->getTypeActivite())) ." / " . ucfirst($pays->getNomPays());
    //         $missions = $serviceMission->searchMissions($_GET['idPays'],$_GET['idTypeActivite'],null);
    //     }
    //     else if (!empty($_GET['typeFormation'])){
    //         if ($_GET['typeFormation']==0) {
    //             $title = 'Missions à distance';
    //         }
    //         else {
    //             $title = 'Missions sur le terrain';
    //         }
    //         $missions = $serviceMission->searchMissions(null,null,$_GET['typeFormation']);
    //     }
    //     echo searchMission($missions,$title);    
    // }
    // catch (ServiceException $se) {
    //         header('Location: ' . $_SERVER['HTTP_REFERER']);
    // }
}
?>