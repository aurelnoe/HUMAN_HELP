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

/***** ID BASE DE DONNEES */

define('ID_MEDECINE',1);
define('ID_DONATION',2);
define('ID_ENSEIGNEMENT',3);
define('ID_CONSTRUCTION',4);
define('ID_TRADUCTION',5);

define('A_DISTANCE',1);
define('SUR_LE_TERRAIN',2);
