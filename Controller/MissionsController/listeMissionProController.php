<?php
include_once($_SERVER['DOCUMENT_ROOT']."/HUMAN_HELP/Security/config.php");
session_start();
include_once(PATH_BASE . "/Services/ServiceMission.php");
include_once(PATH_BASE . "/Services/ServicePays.php");
include_once(PATH_BASE . "/Services/ServiceEtablissement.php");
include_once(PATH_BASE . "/Services/ServiceUtilisateur.php");
include_once(PATH_BASE . "/Services/serviceTypeActivite.php");
include_once(PATH_BASE . "/Exceptions/ServiceException.php");
include_once(PATH_BASE . "/Presentation/PresentationMission.php");
include_once(PATH_BASE . "/Presentation/PresentationUtilisateur.php");

$_GET = array_map('htmlentities',$_GET); 
$_COOKIE = array_map('htmlentities',$_COOKIE);
$_REQUEST = array_map('htmlentities',$_REQUEST);
$_POST = array_map('htmlentities',$_POST);

$mission = new Mission();
$etablissement = new Etablissement();
$serviceMission = new ServiceMission();   
$serviceEtablissement = new ServiceEtablissement();
$serviceUtilisateur = new ServiceUtilisateur();
$serviceTypeActivite = new ServiceTypeActivite();
$servicePays = new ServicePays();

$professionnel = isset($_SESSION['mailUtil']) && isset($_SESSION['idUtil']) && $_SESSION['role'] == 'professionnel';

if ($professionnel)
{   
    $page = (!empty($_GET['page']) ? $_GET['page'] : 1);

    if(!empty($_GET['action']) && isset($_GET['action']))
    {
        if (!empty($_POST) && isset($_POST)) 
        {  
            /************************** AJOUTER UNE MISSION ***************************/
            if ($_GET['action'] == 'add')
            {
                /** Encoder l'image avant de l'insérer dans la bdd */
                if (!empty($_FILES['imageMission']['tmp_name'])) {
                    if (getimagesize($_FILES['imageMission']['tmp_name']) == False) {
                        echo "Veulliez ajouter une image";
                    }
                    $imageMission = $_FILES['imageMission']['tmp_name'];
                    $imageMission = file_get_contents($imageMission);
                    $imageMission = base64_encode($imageMission);
                }
                // Controle des champs si javascript est desactive
                $message = '';
                if ($_POST['titreMission'] == "") {
                    $message.= "Veuillez indiquer un titre à la mission !";
                } elseif ($_POST['descriptionMission'] == "") {
                    $message.= "Veuillez indiquer une description !";
                } elseif ($_POST['typeFormation'] == "") {
                    $message.= "Veuillez indiquer un type de formation !";
                } elseif ($_POST['dateDebut'] == "") {
                    $message.= "Veulliez indiquer une date de début !";
                } elseif ($_POST['duree'] == "") {
                    $message.= "Veuillez indiquer la durée !";
                } elseif ($_POST['idPays'] == "") {
                    $message.= "Veuillez indiquer un pays !";
                } elseif ($_POST['idTypeActivite'] == "") {
                    $message.= "Veuillez indiquer un type d'activité !";
                }

                $titreMission = utf8_decode($_POST['titreMission']);
                $descriptionMission = $_POST['descriptionMission'];
                $typeFormation = isset($_POST['typeFormation']) ? $_POST['typeFormation'] : "";
                $dateDebut = $_POST['dateDebut'];
                $duree = $_POST['duree'];
                $dateAjout = date("Y-m-d");
                $idPays = $_POST['idPays'];
                $idEtablissement = $_POST['idEtablissement'];
                $idTypeActivite = $_POST['idTypeActivite'];
                if ($message=="") 
                {
                    $mission->setTitreMission($titreMission)
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
                        $serviceMission->add($mission);   
                        
                        $utilisateur = $serviceUtilisateur->searchById($_SESSION['idUtil']);
                        $etablissement = $serviceEtablissement->searchEtablissementByIdUtilisateur($_SESSION['idUtil']);
                        $pages = $serviceMission->countPageMissionPro($etablissement->getIdEtablissement());
                        $missions = $serviceMission->searchMissionByPro($etablissement->getIdEtablissement(),1);
                        
                        echo listeMissionsPro($missions,$etablissement,$utilisateur,$page,$pages);
                        die;
                    } 
                    catch (ServiceException $se) {
                        if ($professionnel) 
                        {
                            $utilisateur = $serviceUtilisateur->searchById($_SESSION['idUtil']);
                            $etablissement = $serviceEtablissement->searchEtablissementByIdUtilisateur($_SESSION['idUtil']);
                            $pages = $serviceMission->countPageMissionPro($etablissement->getIdEtablissement());
                            $missions = $serviceMission->searchMissionByPro($etablissement->getIdEtablissement(),1);
                            
                            echo listeMissionsPro($missions,$etablissement,$utilisateur,$page,$pages,$se->getCode());
                            die;           
                        }
                        else {
                            header("Location: ../../index.php");
                            die;
                        }
                    }
                }else {
                    $serviceTypeActivite = new ServiceTypeActivite();
                    $servicePays = new ServicePays();
                    $allPays = $servicePays->searchAll();
                    $allTypeActivite = $serviceTypeActivite->searchAll();
                    $tabAffichageFormAddMission = array(
                        'title' => 'Ajouter une nouvelle mission',
                        'titleBtn' => 'Ajouter la mission',
                        'action' => 'add',
                        'idMission' => null,
                        'idEtablissement' => $idEtablissement,
                        'allPays' => $allPays,
                        'allTypeActivite' => $allTypeActivite
                    );
                    echo formulairesMission($tabAffichageFormAddMission,null,$message);
                    die;
                }
            }  
            /**************************************** AJOUTER UN ETABLISSEMENT ************************/
            elseif ($_GET['action'] == 'addEtablissement') 
            {    
                $message = '';
                if ($_POST['denomination'] == "") {
                    $message.= "Veuillez indiquer une dénomination !";
                } elseif ($_POST['adresseEtablissement'] == "") {
                    $message.= "Veuillez indiquer une adresse !";
                } elseif ($_POST['villeEtablissement'] == "") {
                    $message.= "Veuillez indiquer une ville !";
                } elseif ($_POST['codePostalEtablissement'] == "") {
                    $message.= "Veulliez indiquer un code postal !";
                } elseif ($_POST['mailEtablissement'] == "") {
                    $message.= "Veuillez indiquer une adresse mail !";
                } elseif ($_POST['telEtablissement'] == "") {
                    $message.= "Veuillez indiquer un pays !";
                } elseif ($_POST['idPays'] == "") {
                    $message.= "Veuillez indiquer un pays !";
                }

                if ($message=="") 
                {
                    $denomination = utf8_decode($_POST['denomination']);
                    $adresseEtablissement = $_POST['adresseEtablissement'];
                    $villeEtablissement = $_POST['villeEtablissement'];
                    $codePostalEtablissement = $_POST['codePostalEtablissement'];
                    $mailEtablissement = $_POST['mailEtablissement'];
                    $telEtablissement = $_POST['telEtablissement'];
                    $dateAjoutEtablissement = date("Y-m-d"); 
                    $idUtilisateur = (int)$_POST['idUtilisateur'];
                    $idPays = (int)$_POST['idPays'];
            
                    $etablissement  ->setDenomination($denomination)
                                    ->setAdresseEtablissement($adresseEtablissement)
                                    ->setVilleEtablissement($villeEtablissement)
                                    ->setCodePostalEtablissement($codePostalEtablissement)
                                    ->setMailEtablissement($mailEtablissement)
                                    ->setTelEtablissement($telEtablissement)
                                    ->setDateAjoutEtablissement($dateAjoutEtablissement)
                                    ->setIdUtilisateur($idUtilisateur)
                                    ->setIdPays($idPays);
                    try {
                        $serviceEtablissement->add($etablissement);  
    
                        $utilisateur = $serviceUtilisateur->searchById($_SESSION['idUtil']);
                        $etablissement = $serviceEtablissement->searchEtablissementByIdUtilisateur($_SESSION['idUtil']);
                        $pages = $serviceMission->countPageMissionPro($etablissement->getIdEtablissement());
                        $missions = $serviceMission->searchMissionByPro($etablissement->getIdEtablissement(),1);
                        
                        echo listeMissionsPro($missions,$etablissement,$utilisateur,$page,$pages);
                        die;  
                    }
                    catch (ServiceException $se) {
                        header('Location: ' . $_SERVER['HTTP_REFERER']);
                    }
                } else {
                    $utilisateur = $serviceUtilisateur->searchUserbyMail($mailUtil);
                    $tabAffichFormAddEtab = array(
                        'title' => "Ajouter votre établissement",
                        'titleBtn' => "Ajouter l'établissement",
                        'action' => 'addEtablissement',
                        'idEtablissement' => null,
                        'idUtilisateur' => $utilisateur->getIdUtilisateur(),
                        'allPays' => $servicePays->searchAll(),
                    );
                    
                    echo formulairesEtablissement($tabAffichFormAddEtab,null,$message);
                    die;  
                }
            }
            /**************************************** MODIFIER UN ETABLISSEMENT ************************/
            elseif ($_GET['action'] == 'updateEtablissement') 
            {
                $idEtablissement = $_POST['idEtablissement'];
                $denomination = utf8_decode($_POST['denomination']);
                $adresseEtablissement = $_POST['adresseEtablissement'];
                $villeEtablissement = $_POST['villeEtablissement'];
                $codePostalEtablissement = $_POST['codePostalEtablissement'];
                $mailEtablissement = $_POST['mailEtablissement'];
                $telEtablissement = $_POST['telEtablissement'];
                $dateAjoutEtablissement = date("Y-m-d"); 
                $idUtilisateur = $_POST['idUtilisateur'];
                $idPays = $_POST['idPays'];

                $etablissement  ->setIdEtablissement($idEtablissement)
                                ->setDenomination($denomination)
                                ->setAdresseEtablissement($adresseEtablissement)
                                ->setVilleEtablissement($villeEtablissement)
                                ->setCodePostalEtablissement($codePostalEtablissement)
                                ->setMailEtablissement($mailEtablissement)
                                ->setTelEtablissement($telEtablissement)
                                ->setDateAjoutEtablissement($dateAjoutEtablissement)
                                ->setIdUtilisateur($idUtilisateur)
                                ->setIdPays($idPays);
                try {
                    $serviceEtablissement->update($etablissement);   
                    
                    $utilisateur = $serviceUtilisateur->searchById($_SESSION['idUtil']);
                    $etablissement = $serviceEtablissement->searchEtablissementByIdUtilisateur($_SESSION['idUtil']);
                    $pages = $serviceMission->countPageMissionPro($etablissement->getIdEtablissement());
                    $missions = $serviceMission->searchMissionByPro($etablissement->getIdEtablissement(),1);
                    
                    echo listeMissionsPro($missions,$etablissement,$utilisateur,$page,$pages);
                    die;            
                }
                catch (ServiceException $se) {
                    $utilisateur = $serviceUtilisateur->searchById($_SESSION['idUtil']);
                    $etablissement = $serviceEtablissement->searchEtablissementByIdUtilisateur($_SESSION['idUtil']);
                    $pages = $serviceMission->countPageMissionPro($etablissement->getIdEtablissement());
                    $missions = $serviceMission->searchMissionByPro($etablissement->getIdEtablissement(),1);
                    
                    echo listeMissionsPro($missions,$etablissement,$utilisateur,$page,$pages,$se->getCode());
                    die;  
                }
            }
        }
        /**************************************** SUPPRIMER UNE MISSION ************************/
        elseif ($_GET['action'] == 'delete' && !empty($_GET['idMission'])) 
        {  
            try {
                $serviceMission->delete($_GET['idMission']);    
                
                $utilisateur = $serviceUtilisateur->searchById($_SESSION['idUtil']);
                $etablissement = $serviceEtablissement->searchEtablissementByIdUtilisateur($_SESSION['idUtil']);
                $pages = $serviceMission->countPageMissionPro($etablissement->getIdEtablissement());
                $missions = $serviceMission->searchMissionByPro($etablissement->getIdEtablissement(),1);
                
                echo listeMissionsPro($missions,$etablissement,$utilisateur,$page,$pages);
                die;
            }
            catch (ServiceException $se) {
                $utilisateur = $serviceUtilisateur->searchById($_SESSION['idUtil']);
                $etablissement = $serviceEtablissement->searchEtablissementByIdUtilisateur($_SESSION['idUtil']);
                $pages = $serviceMission->countPageMissionPro($etablissement->getIdEtablissement());
                $missions = $serviceMission->searchMissionByPro($etablissement->getIdEtablissement(),1);
                
                echo listeMissionsPro($missions,$etablissement,$utilisateur,$page,$pages,$se->getCode());
                die;           
            }
        }
    }
    else{

        $utilisateur = $serviceUtilisateur->searchById($_SESSION['idUtil']);
        $etablissement = $serviceEtablissement->searchEtablissementByIdUtilisateur($_SESSION['idUtil']);
        $pages = $serviceMission->countPageMissionPro($etablissement->getIdEtablissement());
        $missions = $serviceMission->searchMissionByPro($etablissement->getIdEtablissement(),$page,$pages);
        
        echo listeMissionsPro($missions,$etablissement,$utilisateur,$page,$pages);
        die;
    }
}
else {
    connexion('Vous devez être connecté en tant que professionnel',null);
    die;
}


