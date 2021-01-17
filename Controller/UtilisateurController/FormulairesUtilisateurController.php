<?php 
include_once($_SERVER['DOCUMENT_ROOT']."/HUMAN_HELP/config.php");
include_once(PATH_BASE . "/Services/ServiceUtilisateur.php");
include_once(PATH_BASE . "/Services/ServicePays.php");
include_once(PATH_BASE . "/Exceptions/ServiceException.php");
include_once(PATH_BASE . "/Presentation/PresentationAccueil.php");
include_once(PATH_BASE . "/Presentation/PresentationUtilisateur.php");

$_GET = array_map('htmlentities',$_GET); 
$_COOKIE = array_map('htmlentities',$_COOKIE);
$_REQUEST = array_map('htmlentities',$_REQUEST);
$_POST = array_map('htmlentities',$_POST);

/************************** AJOUT UTILISATEUR ***************************/
if(!empty($_GET['action']) && isset($_GET['action']))
{
    $servicePays = new ServicePays();
    $allPays = $servicePays->searchAll();
    
    if ($_GET['action'] == 'formAjout')  //ADD USER
    {
        try {
            $tabAffichageFormAddUser = array(
                'title' => 'Inscrivez vous',
                'titleBtn' => 'Ajouter',
                'action' => 'add',
                'allPays' => $allPays
            );

            echo formulairesUtilisateur($tabAffichageFormAddUser,'');
            die;       
        } 
        catch (ServiceException $se) {
            echo formulairesUtilisateur($tabAffichageFormAddUser,'',$se->getCode());
            die;
        }
    }
    elseif ($_GET['action'] == 'formModif')
    {   
        session_start();
        try {
            $tabAffichageFormUpdateUser = array(
                'title' => 'Modifier vos informations personnelles',
                'titleBtn' => 'Modifier',
                'action' => 'update',
                'allPays' => $allPays
            );
            $service = new ServiceUtilisateur();
            $utilisateur = $service->searchById(($_SESSION ['idUtil']));
    
            echo formulairesUtilisateur($tabAffichageFormUpdateUser,$utilisateur);
            die;
        } 
        catch (ServiceException $se) {
            $service = new ServiceUtilisateur();
            $utilisateur = $service->searchById(($_SESSION['idUtil']));
    
            echo formulairesUtilisateur($tabAffichageFormUpdateUser,$utilisateur,$se->getCode());
            die;
        }
    }
    elseif ($_GET['action'] == 'connexion') 
    {
        try {
            echo connexion();
            die;
        }
        catch (ServiceException $se) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }
    elseif ($_GET['action'] == 'modifMdp') {
        try {
            echo modifMotDePasse();
            die;
        }
        catch (ServiceException $se) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }
}

