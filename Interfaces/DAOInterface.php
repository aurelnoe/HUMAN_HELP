<?php
include_once("MissionInterface.php");
include_once("EtablissementInterface.php");
// include_once("UtilisateurInterface.php");
// include_once("BlogInterface.php");
include_once("AvisInterface.php");
include_once("PaysInterface.php");
// include_once("TypeActiviteInterface.php");
// include_once("RoleInterface.php");

interface DAOInterface
{
    public function add(object $objet);

    public function update(object $objet);

    public function delete(int $id);

    public function searchById(int $id);

    public function searchAll();
}