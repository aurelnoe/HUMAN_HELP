<?php
include_once("DAOInterface.php");

interface MissionInterface extends DAOInterface
{
    public function searchMissions(int $getIdPays=null,int $getIdTypeActivite=null,int $getTypeFormation=null); 
    public function searchMissionByPro(int $idEtablissement);
}