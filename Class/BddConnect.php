<?php 

class BddConnect 
{
    public function connexion(){
        $db = new PDO("mysql:host=localhost;dbname=human_helps",'root','');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    }
}