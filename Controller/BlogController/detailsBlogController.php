<?php


include_once($_SERVER['DOCUMENT_ROOT'] . "/HUMAN_HELP/config.php");
session_start();
include_once(PATH_BASE . "/Services/ServiceBlog.php");
include_once(PATH_BASE . "/Services/ServiceAvis.php");
include_once(PATH_BASE . "/Services/ServiceUtilisateur.php");
include_once(PATH_BASE . "/Presentation/PresentationBlog.php");
include_once(PATH_BASE . "/Exceptions/ServiceException.php");

$_GET = array_map('htmlentities',$_GET); 
$_COOKIE = array_map('htmlentities',$_COOKIE);
$_REQUEST = array_map('htmlentities',$_REQUEST);
$_POST = array_map('htmlentities',$_POST);
if (!empty($_GET)) {

    $service = new ServiceBlog();
    $avisService = new ServiceAvis();
    $utilisateurService = new ServiceUtilisateur();

    if (!empty($_GET) && isset($_GET['idArticle'])) {
        try {
            $article = $service->searchById($_GET['idArticle']);
            $avis = $avisService->searchByIdArticle($_GET['idArticle']);
            $pseudoUser = $utilisateurService->searchUserNameById($_SESSION['idUtil']);
            $idUser = $_SESSION['idUtil'];
            $admin = isset($_SESSION['mailUtil']) && isset($_SESSION['idUtil']) && $_SESSION['role'] == 'admin';
            echo detailArticle($article, $avis,$admin,$idUser,$pseudoUser);
            
        } catch (ServiceException $se) {
            echo listeArticle($article,$admin,$se->getCode());
        }
    }
}
