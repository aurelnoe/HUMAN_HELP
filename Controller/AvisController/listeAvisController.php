<?php
include_once($_SERVER['DOCUMENT_ROOT']."/HUMAN_HELP/config.php");
include_once(PATH_BASE . "/Services/ServiceAvis.php");
include_once(PATH_BASE . "/Services/ServiceBlog.php");
include_once(PATH_BASE . "/Presentation/PresentationBlog.php");

$_GET = array_map('htmlentities',$_GET); 
$_COOKIE = array_map('htmlentities',$_COOKIE);
$_REQUEST = array_map('htmlentities',$_REQUEST);
$_POST = array_map('htmlentities',$_POST);

/************************** AJOUT Avis ***************************/
if (!empty($_GET['action']) && isset($_GET['action'])) {

    if (!empty($_POST) && isset($_POST)) 
    {
        if ($_GET['action'] == 'add') 
        {
            $temoignage = ($_POST['temoignage']);
            $dateCommentaire = date("Y-m-d");
            $idUtilisateur =  ($_POST['idUtilisateur']);
            $idArticle = ($_POST['idArticle']);

            $avis = new Avis();

            $avis->setTemoignage($temoignage)
                ->setDateCommentaire($dateCommentaire)
                ->setIdUtilisateur($idUtilisateur)
                ->setIdArticle($idArticle);

            $newAdd = new ServiceAvis();
            try{
                $newAdd->add($avis);
            }
            catch (ServiceException $se) {
                header('Location: ../../index.php');
            }
        }
        /************************** MODIFIE AVIS ***************************/
        elseif ($_GET['action'] == 'update' && isset($_POST['idArticle']))
        { 
            
            $idAvis = ($_POST['idAvis']);
            $temoignage = ($_GET['temoignage']);
            $dateCommentaire = date("Y-m-d");
            $idUtilisateur =  ($_POST['idUtilisateur']);
            $idArticle = ($_POST['idArticle']);

            $avis = new Avis();

            $avis->setIdAvis($idAvis)
                    ->setTemoignage($temoignage)
                    ->setDateCommentaire($dateCommentaire)
                    ->setIdUtilisateur($idUtilisateur)
                    ->setIdArticle($idArticle);

            $newUpdate = new ServiceAvis();
            $service = new ServiceBlog();  
            try{
                $newUpdate->update($avis); 
                // $article = $service->searchById($_POST['idArticle']);
                // echo detailArticle($article,$avis);
                // die;
            }
            catch (ServiceException $se) {
                header('Location: ../../index.php');
            }
              
        }
    }
    /**************************************** SUPPRIME AVIS ************************/
    elseif ($_GET['action'] == 'delete') {
        if (!empty($_GET['idAvis'])) {
            $delete = new ServiceAvis();
            $delete->delete($_GET['idAvis']);

            $service = new ServiceBlog(); 
            $avisService = new ServiceAvis(); 
            try{
                $article = $service->searchById($_GET['idArticle']);
                $avis = $avisService->searchByIdArticle($_GET['idArticle']);
    
                echo detailArticle($article,$avis);
            }
            catch (ServiceException $se) {
                header('Location: ../../index.php');
            }
           
        }
    }
}

/******************************************** AFFICHER TOUS LES AVIS ***********************************************/
    
// $service = new ServiceAvis();
// $avis = $service->searchALL();
// echo listeAvis($avis);
    $service = new ServiceBlog(); 
    $avisService = new ServiceAvis();
    try{
        $article = $service->searchById($_GET['idArticle']);
        $avis = $avisService->searchByIdArticle($_GET['idArticle']);
        echo detailArticle($article,$avis);
        // var_dump($_POST) ;
        // var_dump($_GET) ;
    }
    catch (ServiceException $se) {
        header('Location: ../../index.php');
    }
    
     
    
    
    