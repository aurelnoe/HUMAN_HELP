<?php
session_start();
include_once(PATH_BASE . "/Services/ServiceMission.php");
include_once(PATH_BASE . "/Services/ServicePays.php");
include_once(PATH_BASE . "/Services/ServiceTypeActivite.php");
include_once(PATH_BASE . "/Services/ServiceEtablissement.php");
include_once(PATH_BASE . "/Presentation/PresentationMission.php");
include_once(PATH_BASE . "/Exceptions/ServiceException.php");

$_GET = array_map('htmlentities',$_GET); 
$_COOKIE = array_map('htmlentities',$_COOKIE);
$_REQUEST = array_map('htmlentities',$_REQUEST);
$_POST = array_map('htmlentities',$_POST);

if(!empty($_GET))
{
    $serviceMission = new ServiceMission(); 

    $professionnel = isset($_SESSION['mailUtil']) && isset($_SESSION['idUtil']) && $_SESSION['role'] == 'professionnel';
    
    if (isset($_GET['idMission']) && empty($_GET['action'])) 
    {
        try {
            $mission = $serviceMission->searchById($_GET['idMission']);
            echo detailsMission($mission,$professionnel,null,null);       
        }
        catch (ServiceException $se) {
            echo listeMissions($serviceMission,$professionnel,$se->getCode());
        }
    }
    elseif(!empty($_GET['action']) && isset($_GET['action']) && $professionnel)
    {
        if (!empty($_POST) && isset($_POST)) //UPDATE MISSION
        {
            if($_GET['action'] == 'update' && isset($_POST['idMission']))
            {        
                if (!empty($_FILES['imageMission']['tmp_name'])) {
                    if (getimagesize($_FILES['imageMission']['tmp_name']) == False) {
                        echo "Veulliez ajouter une image";
                    }
                    $imageMission = $_FILES['imageMission']['tmp_name'];
                    $imageMission = file_get_contents($imageMission);
                    $imageMission = base64_encode($imageMission);
                }

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
                if ($message=="") {
                    $idMission = $_POST['idMission'];
                    $titreMission = $_POST['titreMission'];
                    $descriptionMission = $_POST['descriptionMission'];
                    $typeFormation = $_POST['typeFormation'];
                    $dateDebut = $_POST['dateDebut'];
                    $duree = $_POST['duree'];
                    $dateAjout = date("Y-m-d");
                    $idPays = (int)$_POST['idPays'];
                    $idEtablissement = (int)$_POST['idEtablissement'];
                    $idTypeActivite = (int)$_POST['idTypeActivite'];
    
                    $mission = new Mission();
                    $mission->setIdMission($idMission)
                            ->setTitreMission($titreMission)
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
                        $serviceMission->update($mission);
        
                        $mission = $serviceMission->searchById($idMission);
            
                        echo detailsMission($mission,$professionnel,null,null);       
                        die;
                    }
                    catch (ServiceException $se) {
                        $serviceMission->update($mission);
        
                        $mission = $serviceMission->searchById($idMission);
            
                        echo detailsMission($mission,$professionnel,$se->getCode(),$se->getMessage());       
                        die;
                    }        
                }else{
                    
                    $serviceTypeActivite = new ServiceTypeActivite();
                    $servicePays = new ServicePays();
                    $mission = $serviceMission->searchById($_GET['idMission']);
                    
                    $allPays = $servicePays->searchAll();
                    $allTypeActivite = $serviceTypeActivite->searchAll();
                    $tabAffichageFormUpdateMission = array(
                        'title' => 'Modification de la mission',
                        'titleBtn' => 'Modifier la mission',
                        'action' => 'update',
                        'idMission' => $_GET['idMission'],
                        'idEtablissement' => $idEtablissement,
                        'allPays' => $allPays,
                        'allTypeActivite' => $allTypeActivite,
                        'idMission' => $_GET['idMission']
                    );
                    echo formulairesMission($tabAffichageFormUpdateMission,$mission,$message);
                    die;
                }
            }
        }
    }
}
