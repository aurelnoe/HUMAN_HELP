<?php
include_once($_SERVER['DOCUMENT_ROOT']."/HUMAN_HELP/Security/config.php");
require_once(PATH_BASE . "/Exceptions/DAOException.php");
include_once(PATH_BASE . "/Interfaces/DAOInterface.php");

class PaysDAO implements DAOInterface,PaysInterface
{
    private $bddConnect;

    public function __construct() 
    {
        $this->bddConnect = new BddConnect();
    }

    public function add(object $pays)
    {   
        try
        {
            $db = $this->bddConnect->connexion();

            //  $getIdPays = $pays->getIdPays();
             $getNomPays = $pays->getNomPays();
             $getContinent = $pays->getContinent();           

             $query ="INSERT INTO pays VALUES (NULL,:nomPays,:continent)";

             $stmt = $db->prepare($query);

             $stmt->bindParam(':idPays', $getIdPays);
             $stmt->bindParam(':nomPays', $getNomPays);
             $stmt->bindParam(':continent', $getContinent);
             
             $stmt->execute();
        }
        catch (PDOException $e){
            throw new DAOException($e->getMessage(),$e->getCode());
        }  
        finally{
            $db = null;
            $stmt = null;   
        }
    }

    public function update(object $pays)
    {
        try
        {
            $db = $this->bddConnect->connexion();

             $getIdPays = $pays->getIdPays();
             $getNomPays = $pays->getNomPays();
             $getContinent = $pays->getContinent();

             $query ="UPDATE pays  
             SET idPays = :idPays,
                 nomPays = :nomPays,
                 continent = :continent,";

             $stmt = $db->prepare($query);

             $stmt->bindParam(':idPays', $getIdPays);
             $stmt->bindParam(':nomPays', $getNomPays);
             $stmt->bindParam(':continent', $getContinent);
        }
        catch (PDOException $e){
            throw new DAOException($e->getMessage(),$e->getCode());
        }  
        finally{
            $db = null;
            $stmt = null;   
        }
    }

    public function delete(int $idPays)
    {
        try
        {
            $db = $this->bddConnect->connexion();

            $query = "DELETE FROM pays WHERE idPays = :idPays";
            $stmt = $db->prepare($query);
            $stmt->bindParam(":idPays", $idPays);
            $stmt->execute();
        }
        catch (PDOException $e){
            throw new DAOException($e->getMessage(),$e->getCode());
        }  
        finally{
            $db = null;
            $stmt = null;   
        }
    }

    public function searchAll():array
    {
        try
        {
            $db = $this->bddConnect->connexion();

            $query = 'SELECT * FROM pays';
            $stmt = $db->prepare($query);
            $stmt->execute();
            $pays = $stmt->fetchAll(PDO::FETCH_CLASS,'Pays');
                
            return $pays;
        }
        catch (PDOException $e){
            throw new DAOException($e->getMessage(),$e->getCode());
        }  
        finally{
            $db = null;
            $stmt = null;   
        }
    }

    public function searchById(int $idPays):object
    {
        try
        {
            $db = $this->bddConnect->connexion();

            $query = "SELECT * FROM pays WHERE idPays = :idPays";
            $stmt = $db->prepare($query);
            $stmt->bindParam(":idPays", $idPays);
            $stmt->execute();

            $pays = $stmt->fetchAll(PDO::FETCH_CLASS,'Pays');

            return $pays[0];
        }
        catch (PDOException $e){
            throw new DAOException($e->getMessage(),$e->getCode());
        }  
        finally{
            $db = null;
            $stmt = null;   
        }
    }

    public function searchNameById(int $idPays):string
    {
        try
        {
            $db = $this->bddConnect->connexion();

            $query = "SELECT nomPays FROM pays WHERE idPays = :idPays";
            $stmt = $db->prepare($query);
            $stmt->bindParam(":idPays", $idPays);
            $stmt->execute();

            $pays = $stmt->fetchAll(PDO::FETCH_CLASS,'Pays');

            return $pays[0];
        }
        catch (PDOException $e){
            throw new DAOException($e->getMessage(),$e->getCode());
        }  
        finally{
            $db = null;
            $stmt = null;   
        }
    }

    public function searchIdByName(string $namePays):array
    {
        try
        {
            $db = $this->bddConnect->connexion();

            $query = "SELECT * FROM pays WHERE nomPays = :nomPays";
            $stmt = $db->prepare($query);
            $stmt->bindParam(":nomPays", $namePays);
            $stmt->execute();

            $pays = $stmt->fetchAll(PDO::FETCH_CLASS,'Pays');
            
            return $pays;
        }
        catch (PDOException $e){
            throw new DAOException($e->getMessage(),$e->getCode());
        }  
        finally{
            $db = null;
            $stmt = null;   
        }
    }

    public function searchContinentById(int $idPays):string
    {
        try
        {
            $db = $this->bddConnect->connexion();

            $query = "SELECT continent FROM pays WHERE idPays = :idPays";
            $stmt = $db->prepare($query);
            $stmt->bindParam(":idPays", $idPays);
            $stmt->execute();

            $pays = $stmt->fetchAll(PDO::FETCH_CLASS,'Pays');

            return $pays[0];
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