<?php
include_once(PATH_BASE . "/Services/ServiceBlog.php");
include_once(PATH_BASE . "/Presentation/PresentationBlog.php");

if (isset($_GET['action'])) 
{
    $newArticle = new ServiceBlog();

    if ($_GET['action'] == 'update' && isset($_GET['idArticle'])) 
    {  
        $tabAffichageFormModifArticle = array(
            'title' => "Modification de l'article",
            'titleBtn' => "Modifier l'article",
            'action' => 'update',
            'idArticle' => $_GET['idArticle']
        );
        try{
            $article = $newArticle->searchById($_GET['idArticle']);
        
            // $title = "Modification de l'article";
            // $titleBtn = "Modifier l'article";
            // $action = 'update';
            // $idArticle = $_GET['idArticle'];
            $admin = isset($_SESSION['mailUtil']) && isset($_SESSION['idUtil']) && $_SESSION['role'] == 'admin';
            if($admin){
            echo formulaireArticle($tabAffichageFormModifArticle,$article); 
            die;
            }else{
                header('Location: ../../index.php');
                die;
            }
        }
        catch (ServiceException $se) {
            header('Location: ../../index.php');
            die;
        }
       
        
        
    } 
    else if ($_GET['action'] == 'add') {

        $tabAffichageFormAddArticle = array(
            'title' => "Ajouter un article",
            'titleBtn' => "Ajouter l'article",
            'action' => 'add',
            'idArticle' => null
        );
        try{
            //  $title = "Ajouter un article";
            // $titleBtn = "Ajouter l'article";
            // $action = 'add';
            $admin = isset($_SESSION['mailUtil']) && isset($_SESSION['idUtil']) && $_SESSION['role'] == 'admin';
            if($admin){
                echo formulaireArticle($tabAffichageFormAddArticle,null);  
                die;
            }else{
                header('Location: ../../index.php');
                die;
            }
            
        }
        catch (ServiceException $se) {
            header('Location: ../../index.php');
            die;
        }
            
    }
}