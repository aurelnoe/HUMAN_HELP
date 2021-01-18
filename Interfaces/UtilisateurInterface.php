<?php
include_once("DAOInterface.php");

interface UtilisateurInterface extends DAOInterface
{
    public function searchUserbyMail(string $mail); 
    public function searchUserNameById(int $id);
}