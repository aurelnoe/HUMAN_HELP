<?php
include_once($_SERVER['DOCUMENT_ROOT']."/HUMAN_HELP/Security/config.php");
session_start();
include_once(PATH_BASE . "/Services/ServiceUtilisateur.php");
include_once(PATH_BASE . "/Services/ServicePays.php");
include_once(PATH_BASE . "/Services/ServiceTypeActivite.php");
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
    $servicePays = new ServicePays();

    if ($_GET['action'] == 'add')
    {
        if (!empty($_POST) && isset($_POST)) 
        {         
            // Controle des champs si javascript est desactive
            $message = '';
            if (isset($_POST['civilite']) && $_POST['civilite'] == "") {
                $message.= "Veuillez indiquer votre civilite !";
            } elseif ($_POST['pseudo'] == "") {
                $message.= "Veuillez indiquer votre pseudo !";
            } elseif ($_POST['nomUtil'] == "") {
                $message.= "Veuillez indiquer votre nom !";
            } elseif ($_POST['prenomUtil'] == "") {
                $message.= "Veulliez indiquer votre prénom !";
            } elseif ($_POST['adresseUtil'] == "") {
                $message.= "Veuillez indiquer le numéro et le libellé de votre voie !";
            } elseif ($_POST['codePostalUtil'] == "") {
                $message.= "Veuillez indiquer votre code postal !";
            } elseif ($_POST['villeUtil'] == "") {
                $message.= "Veuillez indiquer votre ville !";
            } elseif ($_POST['mailUtil'] == "") {
                $message.= "Veuillez indiquer votre adresse mail !";
            } elseif ($_POST['telUtil'] == "") {
                $message.= "Veuillez indiquer un numéro de téléphone !";
            } elseif ($_POST['passwordUtil'] == "") {
                $message.= "Veuillez indiquer votre mot de passe !";
            } elseif ($_POST['dateNaissance'] == "") {
                $message.= "Veuillez indiquer votre date de naissance !";
            } elseif (isset($_POST['idRole']) && $_POST['idRole'] == "") {
                $message.= "Veuillez indiquer votre status !";
            } elseif ($_POST['idPays'] == "") {
                $message.= "Veuillez indiquer votre pays !";
            }

            if ($message == "") 
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
                $dateNaissance = $_POST['dateNaissance'];
                $dateInscriptionUtil = date("Y-m-d");
                $idRole = isset($_POST['idRole']) ? $_POST['idRole'] : "";
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
                        
                        $utilisateur = $serviceUtilisateur->searchUserbyMail($mailUtil);
                        $_SESSION['mailUtil'] = $mailUtil;
                        $_SESSION['idUtil'] = $utilisateur->getIdUtilisateur();
                        $_SESSION['role'] = nameRole($idRole);
                        
                        $professionnel = isset($_SESSION['mailUtil']) && isset($_SESSION['idUtil']) && $_SESSION['role'] == 'professionnel';
                        
                        if ($professionnel) 
                        {
                            header("Location: ../EtablissementsController/formulaireEtablissementController.php?action=addEtablissement");  
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
               
            } else{
                $allPays = $servicePays->searchAll();
                $tabAffichageFormAddUser = array(
                    'title' => 'Inscrivez vous',
                    'titleBtn' => 'Ajouter',
                    'action' => 'add',
                    'allPays' => $allPays
                );
    
                echo formulairesUtilisateur($tabAffichageFormAddUser,'',$message);
                die;
            }
        }
    }

    /************************** MODIFIER UN UTILISATEUR ***************************/
    else if($_GET['action'] == 'update' && isset($_GET['idUtilisateur']))
    {
        if(!empty($_POST) && isset($_POST))
        {
            //var_dump($_POST);
            $message = '';
            if (isset($_POST['civilite']) && $_POST['civilite'] == "") {
                $message.= "Veuillez indiquer votre civilite !";
            } elseif ($_POST['pseudo'] == "") {
                $message.= "Veuillez indiquer votre pseudo !";
            } elseif ($_POST['nomUtil'] == "") {
                $message.= "Veuillez indiquer votre nom !";
            } elseif ($_POST['prenomUtil'] == "") {
                $message.= "Veulliez indiquer votre prénom !";
            } elseif ($_POST['adresseUtil'] == "") {
                $message.= "Veuillez indiquer le numéro et le libellé de votre voie !";
            } elseif ($_POST['codePostalUtil'] == "") {
                $message.= "Veuillez indiquer votre code postal !";
            } elseif ($_POST['villeUtil'] == "") {
                $message.= "Veuillez indiquer votre ville !";
            } elseif ($_POST['mailUtil'] == "") {
                $message.= "Veuillez indiquer votre adresse mail !";
            } elseif ($_POST['telUtil'] == "") {
                $message.= "Veuillez indiquer un numéro de téléphone !";
            } elseif ($_POST['passwordUtil'] == "") {
                $message.= "Veuillez indiquer votre mot de passe !";
            } elseif ($_POST['dateNaissance'] == "") {
                $message.= "Veuillez indiquer votre date de naissance !";
            } elseif (isset($_POST['idRole']) && $_POST['idRole'] == "") {
                $message.= "Veuillez indiquer votre status !";
            } elseif ($_POST['idPays'] == "") {
                $message.= "Veuillez indiquer votre pays !";
            }

            if ($message=="") 
            {
                $idUtilisateur = $_POST['idUtilisateur'];
                $civilite = $_POST['civilite'];
                $pseudo = $_POST['pseudo'];
                $nomUtil = $_POST['nomUtil'];
                $prenomUtil = $_POST['prenomUtil'];           
                $adresseUtil = $_POST['adresseUtil'];
                $codePostalUtil = $_POST['codePostalUtil'];
                $villeUtil = $_POST['villeUtil'];
                $mailUtil = $_POST['mailUtil'];
                $telUtil = $_POST['telUtil'];
                $passwordUtil = $_POST['passwordUtil'];
                $dateNaissance = $_POST['dateNaissance'];
                $dateInscriptionUtil = $_POST['dateInscriptionUtil'];
                $idRole = (int)$_POST['idRole'];
                $idPays = (int)$_POST['idPays'];
    
                $utilisateur = new Utilisateur();
                $utilisateur->setIdUtilisateur($idUtilisateur)
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
                    
                    $utilisateur = $serviceUtilisateur->searchUserbyMail($mailUtil);
                    echo detailUtilisateur($utilisateur);
                    die;  
                } 
                catch (ServiceException $se) {
                    header("Location: ../../index.php");
                    die;
                }
            } else{
                $allPays = $servicePays->searchAll();
                $tabAffichageFormUpdateUser = array(
                    'title' => 'Modifier vos informations personnelles',
                    'titleBtn' => 'Modifier',
                    'action' => 'update',
                    'allPays' => $allPays
                );
                $service = new ServiceUtilisateur();
                $utilisateur = $service->searchById(($_SESSION ['idUtil']));
        
                echo formulairesUtilisateur($tabAffichageFormUpdateUser,$utilisateur,$message);
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
        if(!$_SESSION){
            connexion('Vous devez être connecté en tant que professionnel',null);
            die;            
        }
        $utilisateur = $serviceUtilisateur->searchUserbyMail($_SESSION['mailUtil']);
        echo detailUtilisateur($utilisateur);

    }
}