<?php
include_once($_SERVER['DOCUMENT_ROOT']."/HUMAN_HELP/Security/config.php");
session_start();
include_once(PATH_BASE . "/Services/ServiceUtilisateur.php");
include_once(PATH_BASE . "/Services/ServicePays.php");
include_once(PATH_BASE . "/Exceptions/ServiceException.php");
include_once(PATH_BASE . "/Presentation/PresentationUtilisateur.php");
include_once(PATH_BASE . "/Presentation/PresentationAccueil.php");
include_once(PATH_BASE . "/Presentation/PresentationEtablissement.php");
$_GET = array_map('htmlentities',$_GET); 
$_COOKIE = array_map('htmlentities',$_COOKIE);
$_REQUEST = array_map('htmlentities',$_REQUEST);
$_POST = array_map('htmlentities',$_POST);

/************************** AJOUT UTILISATEUR ***************************/
if(!empty($_GET['action']) && isset($_GET['action']))
{
    $serviceUtilisateur = new ServiceUtilisateur();

    if ($_GET['action'] == 'add')
    {
        if (!empty($_POST) && isset($_POST)) 
        {         
            $civilite = $_POST['civilite'];
            $pseudo = $_POST['pseudo'];
            $nomUtil = utf8_decode($_POST['nomUtil']);
            $prenomUtil = $_POST['prenomUtil'];           
            $adresseUtil = $_POST['adresseUtil'];
            $codePostalUtil = $_POST['codePostalUtil'];
            $villeUtil = $_POST['villeUtil'];
            $mailUtil = $_POST['mailUtil'];
            $telUtil = $_POST['telUtil'];
            $passwordUtil = $_POST['passwordUtil'];
            $dateNaissance = new DateTime($_POST['dateNaissance']);
            $dateInscriptionUtil = date("Y-m-d");
            $idRole = $_POST['idRole'];
            $idPays = $_POST['idPays'];
            
            $utilisateur = new Utilisateur();

            $utilisateur->setCivilite($civilite)
                        ->setPseudo($pseudo)
                        ->setNomUtil($nomUtil)
                        ->setPrenomUtil($prenomUtil)
                        ->setAdresseUtil($adresseUtil)
                        ->setCodePostalUtil($codePostalUtil)
                        ->setVilleUtil($villeUtil)
                        ->setMailUtil($mailUtil)
                        ->setTelUtil($telUtil)
                        ->setPasswordUtil($passwordUtil)
                        ->setDateNaissance($dateNaissance)
                        ->setDateInscriptionUtil($dateInscriptionUtil)
                        ->setIdRole($idRole)
                        ->setIdPays($idPays);
            try {
                $serviceUtilisateur->add($utilisateur);
    
                if ($idRole==1) {     //Particulier
                    header("location: ../../index.php?action=ajout");
                    die;
                }
                elseif($idRole==2) {  //Professionnel => ADD ETABLISSEMENT  
                    
                    // header("location: Controller/EtablissementsController/formulaireEtablissementController.php?action=add&mail=$mailUtil");
                    // die;
                    $servicePays = new ServicePays();
                    $user = $serviceUtilisateur->searchUserbyMail($mailUtil);
                    $tabAffichFormAddEtab = array(
                        'title' => "Ajouter votre établissement",
                        'titleBtn' => "Ajouter l'établissement",
                        'action' => 'addEtablissement',
                        'idEtablissement' => null,
                        'idUtilisateur' => $user->getIdUtilisateur(),
                        'allPays' => $servicePays->searchAll(),
                    );

                    $_SESSION['mailUtil'] = $mailUtil;
                    $_SESSION['idUtil'] = $idUtil;
                    $_SESSION['role'] = nameRole($idRole);
    
                    $professionnel = isset($_SESSION['mailUtil']) && isset($_SESSION['idUtil']) && $_SESSION['role'] == 'professionnel';
                    
                    if ($professionnel) 
                    {
                        echo formulairesEtablissement($tabAffichFormAddEtab,null);
                        die;           
                    }
                    else {
                        header("Location: ../../index.php");
                        die;
                    }
                }
            } 
            catch (ServiceException $se) {
                header("Location: ../../index.php");
                die;
            }
        }
    }

    /************************** MODIFIER UN UTILISATEUR ***************************/
    else if($_GET['action'] == 'update' && isset($_GET['idUtilisateur']))
    {
        if(!empty($_POST) && isset($_POST))
        {
            $idUtilisateur = $_POST['idUtilisateur'];
            $civilite = $_POST['civilite'];
            $pseudo = $_POST['pseudo'];
            $nomUtil = $_POST['nomUtil'];
            $prenomUtile = $_POST['prenomUtil'];           
            $adresseUtil = $_POST['adresseUtil'];
            $codePostalUtil = $_POST['codePostalUtil'];
            $villeUtil = $_POST['villeUtil'];
            $mailUtil = $_POST['mailUtil'];
            $telUtil = $_POST['telUtil'];
            $passwordUtil = $_POST['passwordUtil'];
            $datenaissance = new DateTime($_POST['dateNaissance']);
            $dateInscriptionUtil = $_POST['dateInscriptionUtil'];
            $idRole = $_POST['idRole'];
            $idPays = $_POST['idPays'];

            $utilisateur = new Utilisateur();
            $utilisatueur->setIdUtilisateur($idUtilisateur)
                         ->setCivilite($civilite)
                         ->setPseudo($pseudo)
                         ->setNomUtil($nomUtil)
                         ->setPrenomUtil($prenomUtil)
                         ->setAdresseUtil($adresseUtil)
                         ->setCodePostalUtil($codePostalUtil)
                         ->setVilleUtil($villeUtil)
                         ->setMailUtil($mailUtil)
                         ->setTelUtil($telUtil)
                         ->setPasswordUtil($passwordUtil)
                         ->setDateNaissance($dateNaissance)
                         ->setDateInscriptionUtil($dateInscriptionUtil)
                         ->setIdRole($idRole)
                         ->setIdPays($idPays);
            try {
                $serviceUtilisateur->update($utilisateur);
    
                //echo detailsCompte();
                header("location: ../../index.php");
                die;  
            } 
            catch (ServiceException $se) {
                header("Location: ../../index.php");
                die;
            }
        }
    }
    /**************************************** SUPPRIME UTILISATEUR ************************/
    elseif ($_GET['action'] == 'delete') 
    {
        if (!empty($_GET['idUtilisateur'])) 
        {   
            try {
                $serviceUtilisateur->delete($_GET['idUtilisateur']);
                header("location: ../../index.php");
                die;
            } 
            catch (ServiceException $se) {
                header("Location: ../../index.php");
                die;
            }       
        }
    }
    elseif ($_GET['action'] == 'connexion') 
    {      
        try 
        {
            $objectUser = $serviceUtilisateur->searchUserbyMail($_POST['mailUtil']);
            $password = $_POST['password'];
            if (!empty($objectUser) && password_verify($password,$objectUser->getPasswordUtil()))
            {
                $_SESSION['mailUtil'] = $_POST['mailUtil'];
                $_SESSION['idUtil'] = $objectUser->getIdUtilisateur();
                $_SESSION['role'] = nameRole($objectUser->getIdRole());

                // $professionnel = isset($_SESSION['mailUtil']) && isset($_SESSION['idUtil']) && $_SESSION['role'] == 'professionnel';
                // $admin = isset($_SESSION['mailUtil']) && isset($_SESSION['idRole']) && $_SESSION['role'] == 'admin';  

                header("Location: ../../index.php");
                die;
            }
        } 
        catch (ServiceException $se) {
            echo connexion($se->getMessage(),$se->getCode());
            die;
        }
    }
    
    elseif ($_GET['action'] == 'detailUtilisateur'){
        if(!$_SESSION) 
            header('location: FormulairesUtilisateurController.php?action=connexion');
        // var_dump($_SESSION);
        $utilisateur = $serviceUtilisateur->searchUserbyMail($_SESSION['mailUtil']);
        echo detailUtilisateur($utilisateur);

    }
}