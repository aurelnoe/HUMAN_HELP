<?php
include_once("DAOInterface.php");

interface UtilisateurInterface extends DAOInterface
{
    public function searchUserbyMail($mailUtil); 
    public function searchUserNameById($idUtilisateur);
}