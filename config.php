<?php

define('PATH_BASE',$_SERVER['DOCUMENT_ROOT']."/HUMAN_HELP/");

include_once(PATH_BASE . "/Services/ServicePays.php");
function nameRole($idRole): string
{
    if ($idRole == 1) {
        $role = 'particulier';
    }
    elseif ($idRole == 2 ) {
        $role = 'professionnel';
    }
    elseif ($idRole == 3 ) {
        $role = 'admin';
    }
    return $role;
}
/*** Affichage valeur des clés secondaires */
function searchNamePaysById($id):void
{
    $servicePays = new ServicePays();
    echo utf8_encode($servicePays->searchNameById($id));
}
function searchNameTypeActivityById($id):void
{
    $serviceTypeActivite = new ServiceTypeActivite();
    echo utf8_encode($serviceTypeActivite->searchNameById($id));
}
function searchContinentById($id):void
{
    $servicePays = new ServicePays();
    echo utf8_encode($servicePays->searchContinentById($id));
}
function searchDenominationById($id):void
{
    $serviceEtablissement = new ServiceEtablissement();
    echo utf8_encode($serviceEtablissement->searchNameById($id));
}
function searchMissionsById($idPays,$idTypeActivite,$idTypeFormation):array
{
    $serviceMission = new ServiceMission();
    return $serviceMission->searchMissions($idPays,$idTypeActivite,$idTypeFormation);
}
function civilite($idCivilite)
{
    if ($idCivilite == 1){

        $civilite = 'Monsieur';
    }
    elseif ($idCivilite == 2 ){
        $civilite = 'Madame';
    }
    return $civilite;

}

function searchUserNameById($idUtilisateur)
{     
    $serviceUtilisateur = new ServiceUtilisateur;
    echo $serviceUtilisateur->searchUserNameById($idUtilisateur);
}
/***** ID BASE DE DONNEES */

define('ID_MEDECINE',1);
define('ID_DONATION',2);
define('ID_ENSEIGNEMENT',3);
define('ID_CONSTRUCTION',4);
define('ID_TRADUCTION',5);

define('A_DISTANCE',1);
define('SUR_LE_TERRAIN',2);
