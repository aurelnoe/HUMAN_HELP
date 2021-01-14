<?php
include_once("DAOInterface.php");

interface PaysInterface extends DAOInterface
{
    public function searchNameById(int $idPays); 
    public function searchIdByName(string $namePays);
    public function searchContinentById(int $idPays);
}