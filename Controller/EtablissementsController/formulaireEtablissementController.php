<?php
include_once($_SERVER['DOCUMENT_ROOT']."/HUMAN_HELP/config.php");
session_start();
include_once(PATH_BASE . "/Services/ServiceEtablissement.php");
include_once(PATH_BASE . "/Services/ServiceUtilisateur.php");
include_once(PATH_BASE . "/Services/ServicePays.php");
include_once(PATH_BASE . "/Presentation/PresentationEtablissement.php");
$_GET = array_map('htmlentities',$_GET); 
$_COOKIE = array_map('htmlentities',$_COOKIE);
$_REQUEST = array_map('htmlentities',$_REQUEST);
$_POST = array_map('htmlentities',$_POST);

if (!empty($_GET) && isset($_GET['action'])) 
{
    //$serviceUtilisateur = new ServiceUtilisateur();

    if ($_GET['action'] == 'update' && isset($_GET['idEtablissement']))
    {  
        try { //UPDATE ETABLISSEMENT
            $serviceEtablissement = new ServiceEtablissement();
            $etablissement = $serviceEtablissement->searchById($_GET['idEtablissement']);
            $tabAffichageFormEtablissement = array(
                'title' => "Modification d'un établissement",
                'titleBtn' => "Modifier l'établissement",
                'action' => 'updateEtablissement',
                'idEtablissement' => $_GET['idEtablissement'],
                'idUtilisateur' => null,
                'allPays' => $servicePays->searchAll(),
            );
    
            echo formulairesEtablissement($tabAffichageFormEtablissement,$etablissement);
            die; 
        } 
        catch (ServiceException $se) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }
}

?>