<?php
include_once($_SERVER['DOCUMENT_ROOT']."/HUMAN_HELP/Security/config.php");
require_once(PATH_BASE . "/Exceptions/DAOException.php");
include_once(PATH_BASE . "/Interfaces/DAOInterface.php");

class MissionDAO extends BddConnect implements DAOInterface,MissionInterface
{
    private $bddConnect;

    public function __construct() 
    {
        $this->bddConnect = new BddConnect();
    }
    
    /******************* AJOUTE MISSION *****************************/
    public function add(object $mission)
    {   
        try 
        {
            $db = $this->bddConnect->connexion(); 

            $getTitreMission = $mission->getTitreMission();
            $getDescriptionMission = $mission->getDescriptionMission();
            $getTypeFormation = $mission->getTypeFormation();
            $getImageMission = $mission->getImageMission();
            $getDateDebut = $mission->getDateDebut()->format('Y-m-d');
            $getDuree = $mission->getDuree();
            $getDateAjout = $mission->getDateAjout()->format('Y-m-d');
            $getIdPays = $mission->getIdPays();
            $getIdEtablissement = $mission->getIdEtablissement();
            $getIdTypeActivite = $mission->getIdTypeActivite();

            $query = "INSERT INTO mission VALUES (NULL,:titreMission,:descriptionMission,:typeFormation,:imageMission,
                                                    :dateDebut,:duree,:dateAjout,:idPays,:idEtablissement,:idTypeActivite)"; //           
            $stmt = $db->prepare($query); 
            
            $stmt->bindParam(':titreMission', $getTitreMission);           
            $stmt->bindParam(':descriptionMission', $getDescriptionMission);
            $stmt->bindParam(':typeFormation', $getTypeFormation);
            $stmt->bindParam(':imageMission', $getImageMission);
            $stmt->bindParam(':dateDebut', $getDateDebut);
            $stmt->bindParam(':duree', $getDuree);
            $stmt->bindParam(':dateAjout', $getDateAjout);
            $stmt->bindParam(':idPays', $getIdPays);
            $stmt->bindParam(':idEtablissement', $getIdEtablissement);
            $stmt->bindParam(':idTypeActivite', $getIdTypeActivite);

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

    /******************* MODIFIE MISSION *****************************/

    public function update(object $mission)
    { 
        try 
        {
            $db = $this->bddConnect->connexion(); 

            $getIdMission = $mission->getIdMission();
            $getTitreMission = $mission->getTitreMission();
            $getDescriptionMission = $mission->getDescriptionMission();       
            $getTypeFormation = $mission->getTypeFormation();
            $getImageMission = $mission->getImageMission();
            $getDateDebut = $mission->getDateDebut()->format('Y-m-d');
            $getDuree = $mission->getDuree();
            $getDateAjout = $mission->getDateAjout()->format('Y-m-d');
            $getIdPays = $mission->getIdPays();
            $getIdEtablissement = $mission->getIdEtablissement();
            $getIdTypeActivite = $mission->getIdTypeActivite();
            
            $query = "UPDATE mission 
                        SET titreMission = :titreMission,
                            descriptionMission = :descriptionMission,
                            typeFormation = :typeFormation,
                            imageMission = :imageMission,
                            dateDebut = :dateDebut,
                            duree = :duree,
                            dateAjout = :dateAjout,
                            idPays = :idPays,
                            idEtablissement = :idEtablissement,
                            idTypeActivite = :idTypeActivite
                        WHERE idMission = :idMission";  

            $stmt = $db->prepare($query);

            $stmt->bindParam(':titreMission', $getTitreMission);           
            $stmt->bindParam(':descriptionMission', $getDescriptionMission);
            $stmt->bindParam(':typeFormation', $getTypeFormation);
            $stmt->bindParam(':imageMission', $getImageMission);
            $stmt->bindParam(':dateDebut', $getDateDebut);
            $stmt->bindParam(':duree', $getDuree);
            $stmt->bindParam(':dateAjout', $getDateAjout);
            $stmt->bindParam(':idPays', $getIdPays);
            $stmt->bindParam(':idEtablissement', $getIdEtablissement);
            $stmt->bindParam(':idTypeActivite', $getIdTypeActivite);
            $stmt->bindParam(':idMission', $getIdMission);
            // if ($stmt->execute()) {
            //     throw new DAOException('La mission a bien été mise à jour',9958);
            // }
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

    /******************* DELETE MISSION*****************************/

    public function delete(int $idMission)
    {
        try 
        {
            $db = $this->bddConnect->connexion();

            $query = "DELETE FROM mission WHERE idMission = :idMission";
            $stmt = $db->prepare($query);
            $stmt->bindParam(":idMission", $idMission);

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

    /**************** CHERCHE TOUTES LES MISSIONS ***************/
    public function searchAll():array
    {
        try 
        {
            $db = $this->bddConnect->connexion();

            $query = 'SELECT * FROM mission';
            $stmt = $db->prepare($query);
            $stmt->execute();
            $missions = $stmt->fetchAll(PDO::FETCH_CLASS,'Mission');
            if (empty($missions)) {
                throw new DAOException("Aucune mission n'a été trouvé dans la base de données", 9998);
            }
            return $missions;
        } 
        catch (PDOException $e){
            throw new DAOException($e->getMessage(),$e->getCode());
        }  
        finally{
            $db = null;
            $stmt = null;   
        }
    }

    /**************** CHERCHE UNE MISSION ***********************/
    public function searchById(int $idMission):object
    {
        try 
        {
            $db = $this->bddConnect->connexion();
            
            $query = "SELECT * FROM mission WHERE idMission = :idMission";   
            $stmt = $db->prepare($query);
            $stmt->bindParam(":idMission", $idMission);
            $stmt->execute();       

            $mission = $stmt->fetchAll(PDO::FETCH_CLASS,'Mission');////MYSQLI FETCH ARRAY
            //varDump($mission);
            if (empty($mission[0])) {
                throw new DAOException("La mission n'a pas été trouvé dans la base de données",9999);
            }
            return $mission[0];
        } 
        catch (PDOException $e){
            throw new DAOException($e->getMessage(),$e->getCode());
        }  
        finally{
            $db = null;
            $stmt = null;   
        }
    }

    /**************** CHERCHE TOUTES LES MISSIONS D'UN PRO *****OK**/
    public function searchMissionByPro(int $idEtablissement,int $getPage):array
    {
        try {
            $db = $this->bddConnect->connexion();

            $page = $getPage ?? 1;

            if(!filter_var($page, FILTER_VALIDATE_INT)){
                throw new Exception('Numéro de page invalide');
            }
        
            if ($page === '1') {
                header('Location: /HUMAN_HELP/Controller/MissionsController/listeMissionProController.php?page=');
                http_response_code(301);
                exit;
            }

            $currentPage = (int)$page;
            if ($currentPage <= 0) {
                throw new Exception('Numéro de page invalide');
            }
            $count = (int)$db->query("SELECT COUNT(idMission) 
                                    FROM mission 
                                    WHERE idEtablissement = $idEtablissement"
                                    )->fetch(PDO::FETCH_NUM)[0];
            $limite = 6;
            // $pages = ceil($count / 6);
            // // if ($currentPage > $pages) {
            // //     throw new Exception('Cette page n\'existe pas');
            // // }
            $debut = ($currentPage - 1) * $limite;
            $query = "SELECT * FROM mission 
                        WHERE idEtablissement = $idEtablissement
                        LIMIT $limite OFFSET $debut";
            $stmt = $db->prepare($query);
            $stmt->execute();  

            $missions = $stmt->fetchAll(PDO::FETCH_CLASS,'Mission');
                                  
            return $missions;
        } 
        catch (PDOException $e){
            throw new DAOException($e->getMessage(),9997);
        }  
        finally{
            $db = null;
            $stmt = null;   
        }       
    }

    public function countPageMissionPro(int $idEtablissement):int
    {
        $newConnect = new BddConnect();
        $db = $newConnect->connexion();

        $count = (int)$db->query("SELECT COUNT(idMission) 
                                    FROM mission 
                                    WHERE idEtablissement = $idEtablissement"
                                    )->fetch(PDO::FETCH_NUM)[0];
        $pages = ceil($count / 6);
                                
        return $pages;
    }

    public function searchMissions(int $getIdPays=null,int $getIdTypeActivite=null,int $getTypeFormation=null,int $getPage=null):array
    {
        try {
            $db = $this->bddConnect->connexion();

            $page = $getPage ?? 1;

            // if(!filter_var($page, FILTER_VALIDATE_INT)){
            //     throw new Exception('Numéro de page invalide');
            // }
        
            // if ($page === '1') {
            //     header("Location: /HUMAN_HELP/Controller/MissionsController/searchMissonsController.php?idPays=$getIdPays&idTypeActivite=$getIdTypeActivite&page=");
            //     http_response_code(301);
            //     exit;
            // }

            $currentPage = (int)$page;
            $limite = 6;
            $debut = ($currentPage - 1) * $limite;
            $selectAllWhere ='SELECT * FROM mission WHERE';

            $query = $selectAllWhere . 1;
            if(!empty($getIdPays) && empty($getIdTypeActivite))
            {   // Filtre que par pays
                $query = "$selectAllWhere idPays = $getIdPays LIMIT $limite OFFSET $debut";
            }   
            else if(empty($getIdPays) && !empty($getIdTypeActivite))
            {   // Filtre que par type d'activité
                $query = "$selectAllWhere idTypeActivite = $getIdTypeActivite LIMIT $limite OFFSET $debut";
            }
            else if(!empty($getIdPays) && !empty($getIdTypeActivite))
            {   // Filtre par pays ET par type d'activité
                $query = "$selectAllWhere idPays = $getIdPays AND idTypeActivite = $getIdTypeActivite LIMIT $limite OFFSET $debut";
            }
            else if(!empty($getTypeFormation) && $getIdPays==null && $getIdTypeActivite==null)
            {   // Filtre que par type de formation
                $query = "$selectAllWhere typeFormation = $getTypeFormation LIMIT $limite OFFSET $debut";
            }
            $stmt = $db->prepare($query);
            $stmt->execute();  

            $missions = $stmt->fetchAll(PDO::FETCH_CLASS,'Mission');
                                  
            return $missions;
        } 
        catch (PDOException $e){
            throw new DAOException($e->getMessage(),$e->getCode());
        }  
        finally{
            $db = null;
            $stmt = null;   
        }
    }

    public function countPageMissions(int $getIdPays=null,int $getIdTypeActivite=null,int $getTypeFormation=null)
    {
        $newConnect = new BddConnect();
        $db = $newConnect->connexion();
        
        $countIdMission = "SELECT COUNT(idMission) FROM mission WHERE";
        if(!empty($getIdPays) && empty($getIdTypeActivite))
        {   // Filtre que par pays
            $count = (int)$db->query("$countIdMission idPays = $getIdPays")->fetch(PDO::FETCH_NUM)[0];
            $pages = ceil($count / 6);
                
        }   
        else if(empty($getIdPays) && !empty($getIdTypeActivite))
        {   // Filtre que par type d'activité
            $count = (int)$db->query("$countIdMission idTypeActivite = $getIdTypeActivite")->fetch(PDO::FETCH_NUM)[0];
            $pages = ceil($count / 6);
        }
        else if(!empty($getIdPays) && !empty($getIdTypeActivite))
        {   // Filtre par pays ET par type d'activité
            $count = (int)$db->query("$countIdMission idPays = $getIdPays AND idTypeActivite = $getIdTypeActivite")->fetch(PDO::FETCH_NUM)[0];
            $pages = ceil($count / 6); 
        }
        else if(!empty($getTypeFormation) && $getIdPays==null && $getIdTypeActivite==null)
        {   // Filtre que par type de formation
            $count = (int)$db->query("$countIdMission typeFormation = $getTypeFormation")->fetch(PDO::FETCH_NUM)[0];
            $pages = ceil($count / 6);
        }
                                
        return $pages;
    }
}

?>