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
if (isset($_GET['action']))
{ 
    $serviceTypeActivite = new ServiceTypeActivite();
    $servicePays = new ServicePays();
    $allPays = $servicePays->searchAll();
    $allTypeActivite = $serviceTypeActivite->searchAll();
    if ($_GET['action'] == 'add' && isset($_GET['idEtablissement'])) 
    {
        $tabAffichageFormAddMission = array(
            'title' => 'Ajouter une nouvelle mission',
            'titleBtn' => 'Ajouter la mission',
            'action' => 'add',
            'idMission' => null,
            'idEtablissement' => $_GET['idEtablissement'],
            'allPays' => $allPays,
            'allTypeActivite' => $allTypeActivite
        );
        try {
            echo formulairesMission($tabAffichageFormAddMission,null);
            die;
            
        } catch (ServiceException $se) {
            echo formulairesMission($tabAffichageFormAddMission,null,$se->getCode());
            die;
        }
    }
    else if ($_GET['action'] == 'update' && isset($_GET['idMission']) && !empty($_SESSION)) 
    {  
        try {
            $serviceMission = new ServiceMission();
            $mission = $serviceMission->searchById($_GET['idMission']);
            
            $tabAffichageFormUpdateMission = array(
                'title' => 'Modification de la mission',
                'titleBtn' => 'Modifier la mission',
                'action' => 'update',
                'idMission' => $_GET['idMission'],
                'idEtablissement' => $mission->getIdEtablissement(),
                'allPays' => $allPays,
                'allTypeActivite' => $allTypeActivite,
                'idMission' => $_GET['idMission']
            );

            $professionnel = isset($_SESSION['mailUtil']) && isset($_SESSION['idUtil']) && $_SESSION['role'] == 'professionnel';
            if ($professionnel) {
                echo formulairesMission($tabAffichageFormUpdateMission,$mission);
                die;         
            }else {
                header("Location: ../UtilisateurController/FormulairesUtilisateurController.php?action=formAjout");
                die;
            }
        } 
        catch (ServiceException $se) 
        {
            $serviceMission = new ServiceMission();
            $mission = $serviceMission->searchById($_GET['idMission']);

            $professionnel = isset($_SESSION['mailUtil']) && isset($_SESSION['idUtil']) && $_SESSION['role'] == 'professionnel';
            if ($professionnel) {
                echo formulairesMission($tabAffichageFormUpdateMission,$mission,$se->getCode());
                die;         
            }else {
                header("Location: ../UtilisateurController/FormulairesUtilisateurController.php?action=formAjout");
                die;
            }
        }
    }  
}