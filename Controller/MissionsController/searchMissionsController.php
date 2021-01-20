<?php
include_once($_SERVER['DOCUMENT_ROOT']."/HUMAN_HELP/Security/config.php");
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

    $page = (!empty($_GET['page']) ? $_GET['page'] : 1);
    
    //TRI PAR TYPE ACTIVITE  
    if (!empty($_GET['idTypeActivite']) && empty($_GET['idPays'])) {
        try {
            $missions = $serviceMission->searchMissions(null,$_GET['idTypeActivite'],null,$page);
            $typeActivite = $serviceTypeActivite->searchById($_GET['idTypeActivite']);
            $title = utf8_encode(ucfirst($typeActivite->getTypeActivite()));
            $pages = $serviceMission->countPageMissions(null,$_GET['idTypeActivite'],null);
            $tabAffichSearchMission = array(
                'title' => $title,
                'page' => $page,
                'pages' => $pages,
            );
            
            echo searchMission($missions,$tabAffichSearchMission);   
        } 
        catch (ServiceException $se) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }
    //TRI PAR PAYS 
    else if (!empty($_GET['idPays']) && empty($_GET['idTypeActivite'])) {
        try {
            $missions = $serviceMission->searchMissions($_GET['idPays'],null,null,$page);
            $pays = $servicePays->searchById($_GET['idPays']);
            $title = ucfirst($pays->getNomPays());
            $pages = $serviceMission->countPageMissions($_GET['idPays'],null,null);
            $tabAffichSearchMission = array(
                'title' => $title,
                'page' => $page,
                'pages' => $pages,
            );
    
            echo searchMission($missions,$tabAffichSearchMission);
        } 
        catch (ServiceException $se) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }
    //TRI PAR PAYS 
    else if (!empty($_GET['idPays']) && !empty($_GET['idTypeActivite'])) {
        try {
            $missions = $serviceMission->searchMissions($_GET['idPays'],$_GET['idTypeActivite'],null,$page);
            $typeActivite = $serviceTypeActivite->searchById($_GET['idTypeActivite']);
            $pays = $servicePays->searchById($_GET['idPays']);
            $title = ucfirst($pays->getNomPays()) . ' / ' . utf8_encode(ucfirst($typeActivite->getTypeActivite()));
            $pages = $serviceMission->countPageMissions($_GET['idPays'],$_GET['idTypeActivite'],null);
            $tabAffichSearchMission = array(
                'title' => $title,
                'page' => $page,
                'pages' => $pages,
            );
    
            echo searchMission($missions,$tabAffichSearchMission);
        } 
        catch (ServiceException $se) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }
    //TRI PAR TYPE FORMATION 
    else if (!empty($_GET['typeFormation'])) {
        try {
            $missions = $serviceMission->searchMissions(null,null,$_GET['typeFormation'],$page);
            if ($_GET['typeFormation']==A_DISTANCE) {
                $title = 'Missions à distance';
            }
            else if ($_GET['typeFormation']==SUR_LE_TERRAIN) {
                $title = 'Missions sur le terrain';
            }
            $pages = $serviceMission->countPageMissions(null,null,$_GET['typeFormation']);
            $tabAffichSearchMission = array(
                'title' => $title,
                'page' => $page,
                'pages' => $pages,
            );

            echo searchMission($missions,$tabAffichSearchMission);   
        }
        catch (ServiceException $se) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }
}
?>