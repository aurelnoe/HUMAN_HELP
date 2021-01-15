<?php
include_once("DAOInterface.php");

interface EtablissementInterface extends DAOInterface
{
    public function searchNameById(int $idEtablissement); 
    public function searchEtablissementByIdUtilisateur(int $idUtilisateur);
}