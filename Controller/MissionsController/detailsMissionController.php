<?php
include_once($_SERVER['DOCUMENT_ROOT']."/HUMAN_HELP/config.php");
session_start();
include_once(PATH_BASE . "/Services/ServiceMission.php");
include_once(PATH_BASE . "/Services/ServicePays.php");
include_once(PATH_BASE . "/Services/ServiceTypeActivite.php");
include_once(PATH_BASE . "/Services/ServiceEtablissement.php");
include_once(PATH_BASE . "/Presentation/PresentationMission.php");
include_once(PATH_BASE . "/Exceptions/ServiceException.php");
$_GET = array_map('htmlentities',$_GET); 
$_COOKIE = array_map('htmlentities',$_COOKIE);
$_REQUEST = array_map('htmlentities',$_REQUEST);
$_POST = array_map('htmlentities',$_POST);

if(!empty($_GET))
{
    $serviceMission = new ServiceMission(); 
    $servicePays = new ServicePays();
    $serviceTypeActivite = new ServiceTypeActivite();
    $serviceEtablissement = new ServiceEtablissement();

    $professionnel = isset($_SESSION['mailUtil']) && isset($_SESSION['idUtil']) && $_SESSION['role'] == 'professionnel';
    
    if (isset($_GET['idMission']) && empty($_GET['action'])) 
    {
        try {
            $mission = $serviceMission->searchById($_GET['idMission']);
        
            echo detailsMission($mission,$servicePays,$serviceTypeActivite,$serviceEtablissement,$professionnel,null,null);       
        }
        catch (ServiceException $se) {
            echo listeMissions($serviceMission,$serviceTypeActivite,$servicePays,$professionnel,$se->getCode());
        }
    }
    elseif(!empty($_GET['action']) && isset($_GET['action']) && $professionnel)
    {
        if (!empty($_POST) && isset($_POST)) 
        {
            if($_GET['action'] == 'update' && isset($_POST['idMission']))
            {         
                $idMission = $_POST['idMission'];
                $titreMission = $_POST['titreMission'];
                $descriptionMission = $_POST['descriptionMission'];
                $typeFormation = $_POST['typeFormation'];
                $imageMission = is_null($_POST['imageMission']) ? 'NULL' : $_POST['imageMission'];
                $dateDebut = $_POST['dateDebut'];
                $duree = $_POST['duree'];
                $dateAjout = date("Y-m-d");
                $idPays = (int)$_POST['idPays'];
                $idEtablissement = (int)$_POST['idEtablissement'];
                $idTypeActivite = (int)$_POST['idTypeActivite'];

                $mission = new Mission();
                $mission->setIdMission($idMission)
                        ->setTitreMission($titreMission)
                        ->setDescriptionMission($descriptionMission)
                        ->setTypeFormation($typeFormation)
                        ->setImageMission($imageMission)
                        ->setDateDebut($dateDebut)
                        ->setDuree($duree)
                        ->setDateAjout($dateAjout);
                $mission->setIdPays($idPays)
                        ->setIdEtablissement($idEtablissement)
                        ->setIdTypeActivite($idTypeActivite);
                try {
                    $serviceMission->update($mission);
    
                    $mission = $serviceMission->searchById($_GET['idMission']);
        
                    echo detailsMission($mission,$servicePays,$serviceTypeActivite,$serviceEtablissement,$professionnel,null,null);       
                    die;
                }
                catch (ServiceException $se) {
                    $serviceMission->update($mission);
    
                    $mission = $serviceMission->searchById($_GET['idMission']);
        
                    echo detailsMission($mission,$servicePays,$serviceTypeActivite,$serviceEtablissement,$professionnel,$se->getCode(),$se->getMessage());       
                    die;
                }        
            }
        }
    }
}
