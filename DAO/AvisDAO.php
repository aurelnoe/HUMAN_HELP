<?php
include_once($_SERVER['DOCUMENT_ROOT']."/HUMAN_HELP/Security/config.php");
include_once(PATH_BASE . "/Interfaces/DAOInterface.php");

class AvisDAO extends BddConnect implements DAOInterface,AvisInterface
{
    private $bddConnect;

    public function __construct() 
    {
        $this->bddConnect = new BddConnect();
    }

     /******************* FONCTION AJOUTER UN AVIS/COMMENTAIRE *****************************/

    public function add(Object $avis)
    {   
        try 
        {
            $db = $this->bddConnect->connexion();

            $getTemoignage = $avis->getTemoignage();
            $getDateCommentaire = $avis->getDateCommentaire()->format('Y-m-d'); 
            $getIdUtilisateur = $avis->getIdUtilisateur();
            $getIdArticle = $avis->getIdArticle();
            

            $query = "INSERT INTO avis VALUES (NULL,:temoignage,:dateCommentaire,
                                                    :idUtilisateur,:idBlog)";            
            $stmt = $db->prepare($query); 
                       
            $stmt->bindParam(':temoignage', $getTemoignage);
            $stmt->bindParam(':dateCommentaire', $getDateCommentaire);
            $stmt->bindParam(':idUtilisateur', $getIdUtilisateur);
            $stmt->bindParam(':idBlog', $getIdArticle);

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


    /******************* FONCTION MODIFIER UN AVIS *****************************/

    public function update(Object $avis)
    {   
        try {

            $db = $this->bddConnect->connexion();

            $getIdAvis = $avis->getIdAvis();
            $getTemoignage = $avis->getTemoignage();
            $getDateCommentaire = $avis->getDateCommentaire()->format('Y-m-d'); 
            $getIdUtilisateur = $avis->getIdUtilisateur();
            $getIdArticle = $avis->getIdArticle();
            

            $query = "UPDATE avis 
            SET temoignage = :temoignage,
                dateCommentaire = :dateCommentaire,
                idUtilisateur = :idUtilisateur,
                idBlog = :idBlog
            WHERE idAvis = :idAvis";    

            $stmt = $db->prepare($query); 

            $stmt->bindParam(':idAvis', $getIdAvis);           
            $stmt->bindParam(':temoignage', $getTemoignage);
            $stmt->bindParam(':dateCommentaire', $getDateCommentaire);
            $stmt->bindParam(':idUtilisateur', $getIdUtilisateur);
            $stmt->bindParam(':idBlog', $getIdArticle);
            

            $stmt->execute();

                    
        } 
        catch (PDOException $e){
            echo 'Echec de la connexion : '.$e->getMessage();
        }
        finally{
            $db = null;
            $stmt = null;   
        }         
    }

     /******************* FONCTION SUPPRIMER UN AVIS*****************************/

     public function delete($idAvis)
     {
         try 
         {
             $newConnect = new BddConnect();
             $db = $newConnect->connexion();
 
             $query = "DELETE FROM avis WHERE idAvis = :idAvis";
             $stmt = $db->prepare($query);
             $stmt->bindParam(":idAvis", $idAvis);
             $stmt->execute();
 
             $db = null;
             $stmt = null;
         } 
         catch (PDOException $e){
            throw new DAOException($e->getMessage(),$e->getCode());
        }  
        finally{
            $db = null;
            $stmt = null;   
        }          
     }

     /**************** FONCTION CHERCHER TOUS LES AVIS ***********************/

     public function searchAll()
     {
         try 
         {
            $db = $this->bddConnect->connexion();
 
            $query = 'SELECT * FROM avis';
            $stmt = $db->prepare($query);
            $stmt->execute();
            $avis = $stmt->fetchAll(PDO::FETCH_CLASS,'Avis');

            $db = null;
            $stmt = null;
            
            return $avis;
         } 
         catch (PDOException $e){
            throw new DAOException($e->getMessage(),$e->getCode());
        }  
        finally{
            $db = null;
            $stmt = null;   
        }       
     }

/**************** FONCTION CHERCHER AVIS PAR ID ***********************/ 
     public function searchById($idAvis)
    {
        try 
        {
            $db = $this->bddConnect->connexion();
            
            $query = "SELECT * FROM avis WHERE idAvis = :idAvis";   
            $stmt = $db->prepare($query);
            $stmt->bindParam(":idAvis", $idAvis);
            $stmt->execute();       

            $avis = $stmt->fetchAll(PDO::FETCH_CLASS,'Avis');////MYSQLI FETCH ARRAY
            

            return $avis[0];
        } 
        catch (PDOException $e){
            throw new DAOException($e->getMessage(),$e->getCode());
        }  
        finally{
            $db = null;
            $stmt = null;   
        }       
    }
/**************** FONCTION CHERCHER AVIS PAR ID ARTICLE ***********************/ 
public function searchByIdArticle($idBlog)
    {
        try 
        {
            $db = $this->bddConnect->connexion();
            
            $query = "SELECT * FROM avis WHERE idBlog = :idBlog";   
            $stmt = $db->prepare($query);
            $stmt->bindParam(":idBlog", $idBlog);
            $stmt->execute();       

            $avis = $stmt->fetchAll(PDO::FETCH_CLASS,'Avis');////MYSQLI FETCH ARRAY
            

            return $avis;
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
 