<?php
include_once($_SERVER['DOCUMENT_ROOT']."/HUMAN_HELP/Security/config.php");
session_start();
include_once(PATH_BASE . "/Services/ServiceBlog.php");
include_once(PATH_BASE . "/Presentation/PresentationBlog.php");
include_once(PATH_BASE . "/Presentation/PresentationUtilisateur.php");

$_GET = array_map('htmlentities',$_GET); 
$_COOKIE = array_map('htmlentities',$_COOKIE);
$_REQUEST = array_map('htmlentities',$_REQUEST);
$_POST = array_map('htmlentities',$_POST);


$service = new ServiceBlog();
$admin = isset($_SESSION['mailUtil']) && isset($_SESSION['idUtil']) && $_SESSION['role'] == 'admin';
$page = (!empty($_GET['page']) ? $_GET['page'] : 1);
$pages = $service->countPageArticles();
/************************** AJOUT ARTICLE ***************************/
if (!empty($_GET['action']) && isset($_GET['action'])) {

    if (!empty($_POST) && isset($_POST) && !empty($_FILES)) 
    {
        if ($_GET['action'] == 'add' && !empty($_POST['titreArticle'] && !empty($_POST['descriptionArticle']) )) 
        {
            // echo'<pre>';
            // var_dump($_POST);
            // echo '</pre>';
            // if (getimagesize($_FILES['imageArticle']['tmp_name']) == False) {
            //     $service = new ServiceBlog();
            //     $articles = $service->searchAllArticle($page);
            //     $admin = isset($_SESSION['mailUtil']) && isset($_SESSION['idUtil']) && $_SESSION['role'] == 'admin';
            //     echo listeArticle($articles,$admin,$page,$pages);
            //     die;
            // }
            $imageArticle = $_FILES['imageArticle']['tmp_name'];
            $imageArticle = file_get_contents($imageArticle);
            $imageArticle = base64_encode($imageArticle);

            $titreArticle = utf8_decode(($_POST['titreArticle']));
            $descriptionArticle = ($_POST['descriptionArticle']);
            $dateArticle = ($_POST['dateArticle']);
            $dateAjoutArticle = date("Y-m-d");

            $article = new Blog();

            $article->setTitreArticle($titreArticle)
                ->setDescriptionArticle($descriptionArticle)
                ->setDateArticle($dateArticle)
                ->setDateAjout($dateAjoutArticle)
                ->setImageArticle($imageArticle);

            try{ 
                if($admin){
                    $service->add($article);
                    $successCode = 15000;
                    $articles = $service->searchAllArticle($page);
                    echo listeArticle($articles,$admin,$page,$pages,null,null,$successCode);
                    die;
                }
            }
            catch (ServiceException $se) {
                if($admin){
                    $service = new ServiceBlog();
                    $articles = $service->searchAllArticle($page);
                    echo listeArticle($articles,$admin,$page,$pages,$se->getCode(),$se->getMessage());
                    die;
                
                }else {
                    header("Location: ../../index.php");
                    die;
                }
            }
        }
 
        /************************** MODIFIE ARTICLE ***************************/
        elseif ($_GET['action'] == 'update' && isset($_POST['idArticle']) && !empty($_POST['titreArticle'] && !empty($_POST['descriptionArticle']))) 
        { 

            if (getimagesize($_FILES['imageArticle']['tmp_name']) == False) {
                echo "Veulliez ajouter une image";
            }
            $imageArticle = $_FILES['imageArticle']['tmp_name'];
            $imageArticle = file_get_contents($imageArticle);
            $imageArticle = base64_encode($imageArticle);

            $idArticle = ($_POST['idArticle']);
            $titreArticle = utf8_decode(($_POST['titreArticle']));
            $descriptionArticle = ($_POST['descriptionArticle']);
            $dateArticle = ($_POST['dateArticle']);
            $dateAjoutArticle = date("Y-m-d");
            // $imageArticle = is_null($_POST['imageArticle']) ? 'NULL' : ($_POST['imageArticle']);

            $article = new Blog();

            $article->setIdArticle($idArticle)
                    ->setTitreArticle($titreArticle)
                    ->setDescriptionArticle($descriptionArticle)
                    ->setDateArticle($dateArticle)
                    ->setDateAjout($dateAjoutArticle)
                    ->setImageArticle($imageArticle);

            $service = new ServiceBlog();
            try{
                if($admin){
                    $service->update($article);
                    $successCode = 15001;
                    $articles = $service->searchAllArticle($page);
                    echo listeArticle($articles,$admin,$page,$pages,null,null,$successCode);
                    die;
                }
            }
            catch (ServiceException $se) {
                $service = new ServiceBlog();
                $articles = $service->searchAllArticle($page);
                echo listeArticle($articles,$admin,$page,$pages,$se->getCode(),$se->getMessage());
                die;
            }
        }
    }
    /**************************************** SUPPRIME ARTICLE ************************/
    elseif ($_GET['action'] == 'delete') {
        if (!empty($_GET['idArticle'])) {
            $service = new ServiceBlog();
            try{
                if($admin){
                    $service->delete($_GET['idArticle']);
                    $successCode = 15002;
                    $articles = $service->searchAllArticle($page);
                    echo listeArticle($articles,$admin,$page,$pages,null,null,$successCode);
                    die;
                }
                // else{
                //     header('Location: ../../index.php');
                // }
            }
            catch (ServiceException $se) {
                $service = new ServiceBlog();
                $articles = $service->searchAllArticle($page);
                echo listeArticle($articles,$admin,$page,$pages,$se->getCode(),$se->getMessage());
            }
            
        }
    }
}

/******************************************** Afficher tous les articles ***********************************************/
try{
    $articles = $service->searchAllArticle($page);
    echo listeArticle($articles,$admin,$page,$pages);
}
catch (ServiceException $se) {
    header('Location: ../../index.php');
}
