<?php
include_once($_SERVER['DOCUMENT_ROOT']."/HUMAN_HELP/Security/config.php");
require_once(PATH_BASE . "/Exceptions/DAOException.php");
include_once(PATH_BASE . "/Interfaces/DAOInterface.php");
include_once(PATH_BASE . "/Interfaces/UtilisateurInterface.php");

class UtilisateurDAO extends BddConnect implements DAOInterface,UtilisateurInterface
{
    private $bddConnect;

    public function __construct() 
    {
        $this->bddConnect = new BddConnect();
    }

    public function add(object $utilisateur)
    {
        try
        {
            $db = $this->bddConnect->connexion();
            
            $getCivilite = $utilisateur->getCivilite();
            $getPseudo = $utilisateur->getPseudo();
            $getNomUtil = $utilisateur->getNomUtil();
            $getPrenomUtil = $utilisateur->getPrenomUtil();           
            $getAdresseUtil = $utilisateur->getAdresseUtil();
            $getCodePostalUtil = $utilisateur->getCodePostalUtil();
            $getVilleUtil = $utilisateur->getVilleUtil();
            $getMailUtil = $utilisateur->getMailUtil();
            $getTelUtil = $utilisateur->getTelUtil();
            $getPasswordUtil = $utilisateur->getPasswordUtil();
            $getDateNaissance = $utilisateur->getDateNaissance()->format('Y-m-d');
            $getDateInscriptionUtil = $utilisateur->getDateInscriptionUtil()->format('Y-m-d');
            $getIdRole = $utilisateur->getIdRole();
            $getIdPays = $utilisateur->getIdPays();
            
            $query ="INSERT INTO utilisateur VALUES (NULL,:civilite,:pseudo,:nomUtil,:prenomUtil,:adresseUtil,:codePostalUtil,
                                                :villeUtil,:mailUtil,:telUtil,:passwordUtil,:dateNaissance,
                                                :dateInscriptionUtil,:idRole,:idPays)";

            $stmt = $db->prepare($query);

            $stmt->bindParam(':civilite', $getCivilite);
            $stmt->bindParam(':pseudo', $getPseudo);
            $stmt->bindParam(':nomUtil', $getNomUtil);
            $stmt->bindParam(':prenomUtil', $getPrenomUtil);
            $stmt->bindParam(':adresseUtil', $getAdresseUtil);
            $stmt->bindParam(':codePostalUtil', $getCodePostalUtil);
            $stmt->bindParam(':villeUtil', $getVilleUtil);
            $stmt->bindParam(':mailUtil', $getMailUtil);
            $stmt->bindParam(':telUtil', $getTelUtil);
            $stmt->bindParam(':passwordUtil', $getPasswordUtil);
            $stmt->bindParam(':dateNaissance', $getDateNaissance);
            $stmt->bindParam(':dateInscriptionUtil', $getDateInscriptionUtil);
            $stmt->bindParam(':idRole', $getIdRole);
            $stmt->bindParam(':idPays', $getIdPays);
            
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

    //********************FONCTION MODIDIER UN UTILISATEUR************************ */
    public function update(object $utilisateur)
    {
        try
        {
            $db = $this->bddConnect->connexion();

            $getIdUtilisateur = $utilisateur->getIdUtilisateur();
            $getCivilite = $utilisateur->getCivilite();
            $getPseudo = $utilisateur->getPseudo();
            $getNomUtil = $utilisateur->getNomUtil();
            $getPrenomUtil = $utilisateur->getPrenomUtil();           
            $getAdresseUtil = $utilisateur->getAdresseUtil();
            $getCodePostalUtil = $utilisateur->getCodePostalUtil();
            $getVilleUtil = $utilisateur->getVilleUtil();
            $getMailUtil = $utilisateur->getMailUtil();
            $getTelUtil = $utilisateur->getTelUtil();
            $getPasswordUtil = $utilisateur->getPasswordUtil();
            $getDateNaissance = $utilisateur->getDateNaissance()->format('Y-m-d');
            $getDateInscriptionUtil = $utilisateur->getDateInscriptionUtil()->format('Y-m-d');
            $getIdRole = $utilisateur->getIdRole();
            $getIdPays = $utilisateur->getIdPays();

            $query ="UPDATE utilisateur  
            SET civilite = :civilite,
                pseudo = :pseudo,
                nomUtil = :nomUtil,
                prenomUtil = :prenomUtil,
                adresseUtil = :adresseUtil,
                codePostalUtil = :codePostalUtil,
                villeUtil = :villeUtil,
                mailUtil = :mailUtil,
                telUtil = :telUtil,
                passwordUtil = :passwordUtil,
                dateNaissance = :dateNaissance,
                dateInscriptionUtil = :dateInscriptionUtil,
                idRole = :idRole,
                idPays = :idPays
            WHERE idUtilisateur = :idUtilisateur";

            $stmt = $db->prepare($query);

            $stmt->bindParam(':civilite', $getCivilite);
            $stmt->bindParam(':pseudo', $getPseudo);
            $stmt->bindParam(':nomUtil', $getNomUtil);
            $stmt->bindParam(':prenomUtil', $getPrenomUtil);
            $stmt->bindParam(':adresseUtil', $getAdresseUtil);
            $stmt->bindParam(':codePostalUtil', $getCodePostalUtil);
            $stmt->bindParam(':villeUtil', $getVilleUtil);
            $stmt->bindParam(':mailUtil', $getMailUtil);
            $stmt->bindParam(':telUtil', $getTelUtil);
            $stmt->bindParam(':passwordUtil', $getPasswordUtil);
            $stmt->bindParam(':dateNaissance', $getDateNaissance);
            $stmt->bindParam(':dateInscriptionUtil', $getDateInscriptionUtil);
            $stmt->bindParam(':idRole', $getIdRole);
            $stmt->bindParam(':idPays', $getIdPays);
            $stmt->bindParam(':idUtilisateur', $getIdUtilisateur);
        
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

    //*********************FONCTION SUPPRIMER UTILISATEUR**************** */
    public function delete(int $idUtilisateur)
    {
        try
        {
            $db = $this->bddConnect->connexion();

            $query = "DELETE FROM utilisateur WHERE idUtilisateur = :idUtilisateur";
            $stmt = $db->prepare($query);
            $stmt->bindParam(":idUtilisateur", $idUtilisateur);
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

    //*********************FONCTION CHERCHER TOUT LES UTILISATEURS**************** */
    public function searchAll():array
    {
        try
        {
            $db = $this->bddConnect->connexion();

            $query = 'SELECT * FROM utilisateur';
            $stmt = $db->prepare($query);
            $stmt->execute();
            $utilisateurs = $stmt->fetchAll(PDO::FETCH_CLASS,'Utilisateur');
            
            return $utilisateurs;
        }
        catch (PDOException $e){
            throw new DAOException($e->getMessage(),$e->getCode());
        }  
        finally{
            $db = null;
            $stmt = null;   
        }
    }

    //*********************FONCTION CHERCHER UTILISATEUR PAR ID**************** */
    public function searchById($idUtilisateur):object
    {
        try
        {
            $db = $this->bddConnect->connexion();

            $query = "SELECT * FROM utilisateur WHERE idUtilisateur = :idUtilisateur";
            $stmt = $db->prepare($query);
            $stmt->bindParam(":idUtilisateur", $idUtilisateur);
            $stmt->execute();
            $utilisateur = $stmt->fetchAll(PDO::FETCH_CLASS,'Utilisateur');

            return $utilisateur[0];
        }
        catch (PDOException $e){
            throw new DAOException($e->getMessage(),$e->getCode());
        }  
        finally{
            $db = null;
            $stmt = null;   
        }
    }

    //*********************FONCTION CHERCHER UTILISATEUR PAR ID**************** */
    public function searchUserbyMail($mailUtil):object
    {
        try
        {
            $db = $this->bddConnect->connexion();

            $query = "SELECT * FROM utilisateur WHERE mailUtil = :mailUtil";
            $stmt = $db->prepare($query);
            $stmt->bindParam(":mailUtil", $mailUtil);
            $stmt->execute();
            $utilisateur = $stmt->fetchAll(PDO::FETCH_CLASS,'Utilisateur');
            if (!($utilisateur)) {
                throw new DAOException("Veuillez saisir un identifiant ou un mot de passe correct",1081);
            }
            return $utilisateur[0];
        }
        catch (PDOException $e){
            throw new DAOException($e->getMessage(),$e->getCode());
        }  
        finally{
            $db = null;
            $stmt = null;   
        }
    }

    //*********************FONCTION CHERCHER PSEUDO UTILISATEUR PAR ID**************** */
    public function searchUserNameById($idUtilisateur):string
    {
        try
        {
            $db = $this->bddConnect->connexion();

            $query = "SELECT pseudo FROM utilisateur WHERE idUtilisateur = :idUtilisateur";
            $stmt = $db->prepare($query);
            $stmt->bindParam(":idUtilisateur", $idUtilisateur);
            $stmt->execute();
            $utilisateur = $stmt->fetchAll(PDO::FETCH_CLASS,'Utilisateur');

            return $utilisateur[0];
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