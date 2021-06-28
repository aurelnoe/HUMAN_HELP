<?php
include_once($_SERVER['DOCUMENT_ROOT']."/HUMAN_HELP/Security/config.php");
require_once(PATH_BASE . "/Exceptions/DAOException.php");
include_once(PATH_BASE . "/Interfaces/TypeActiviteInterface.php");

class TypeActiviteDAO extends BddConnect implements TypeActiviteInterface
{
    private $bddConnect;

    public function __construct() 
    {
        $this->bddConnect = new BddConnect();
    }

    public function searchAll():array
    {
        try 
        {
            $db = $this->bddConnect->connexion();

            $query = 'SELECT * FROM type_activite';
            $stmt = $db->prepare($query);
            $stmt->execute();
            $typesActivites = $stmt->fetchAll(PDO::FETCH_CLASS,'TypeActivite');

            $db = null;
            $stmt = null;
            
            return $typesActivites;
        } 
        catch (PDOException $e){
            throw new DAOException($e->getMessage(),$e->getCode());
        }  
        finally{
            $db = null;
            $stmt = null;   
        }
    }

    public function searchById(int $idTypeActivite):object
    {
        try 
        {
            $newConnect = new BddConnect();
            $db = $newConnect->connexion();
            
            $query = "SELECT * FROM type_activite WHERE idTypeActivite = :idTypeActivite";   
            $stmt = $db->prepare($query);
            $stmt->bindParam(":idTypeActivite", $idTypeActivite);
            $stmt->execute();       

            $typeActivite = $stmt->fetchAll(PDO::FETCH_CLASS,'TypeActivite');

            return $typeActivite[0];
        } 
        catch (PDOException $e){
            throw new DAOException($e->getMessage(),$e->getCode());
        }  
        finally{
            $db = null;
            $stmt = null;   
        }
    }

    public function searchNameById(int $idTypeActivite):string
    {
        try 
        {
            $newConnect = new BddConnect();
            $db = $newConnect->connexion();
            
            $query = "SELECT typeActivite FROM type_activite WHERE idTypeActivite = :idTypeActivite";   
            $stmt = $db->prepare($query);
            $stmt->bindParam(":idTypeActivite", $idTypeActivite);
            $stmt->execute();       

            $typeActivite = $stmt->fetchAll(PDO::FETCH_CLASS,'TypeActivite');

            return $typeActivite[0];
        } 
        catch (PDOException $e){
            throw new DAOException($e->getMessage(),$e->getCode());
        }  
        finally{
            $db = null;
            $stmt = null;   
        }
    }
}