<?php

class Utilisateur
{
    private $idUtilisateur;
    private $civilite;
    private $pseudo;
    private $nomUtil;
    private $prenomUtil;
    private $adresseUtil;
    private $codePostalUtil;
    private $villeUtil;
    private $mailUtil;
    private $telUtil;
    private $passwordUtil;
    private $dateNaissance;
    private $dateInscriptionUtil;
    private $idRole;
    private $idPays;
    
    public function __toString()
    {
        return
        $this->idUtilisateur .
        $this->civilite .
        $this->pseudo .
        $this->nomUtil .
        $this->prenomUtil .
        $this->adresseUtil .
        $this->codePostalUtil .
        $this->villeUtil .
        $this->mailUtil .
        $this->telUtil .
        $this->passwordUtil .
        $this->idRole .
        $this->idPays;
    }
    

    /**
     * Get the value of idUtilisateur
     */ 
    public function getIdUtilisateur():int
    {
        return $this->idUtilisateur;
    }

    /**
     * Set the value of idUtilisateur
     *
     * @return  self
     */ 
    public function setIdUtilisateur(int $idUtilisateur):self
    {
        $this->idUtilisateur = $idUtilisateur;

        return $this;
    }

    /**
     * Get the value of civilite
     */ 
    public function getCivilite(): int
    {
        return $this->civilite;
    }

    /**
     * Set the value of civilite
     *
     * @return  self
     */ 
    public function setCivilite(int $civilite):self
    {
        $this->civilite = $civilite;

        return $this;
    }

    /**
     * Get the value of pseudo
     */ 
    public function getPseudo():?string
    {
        return $this->pseudo;
    }

    /**
     * Set the value of pseudo
     *
     * @return  self
     */ 
    public function setPseudo(?string $pseudo):self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * Get the value of nomUtil
     */ 
    public function getNomUtil():string
    {
        return $this->nomUtil;
    }

    /**
     * Set the value of nomUtil
     *
     * @return  self
     */ 
    public function setNomUtil(string $nomUtil):self
    {
        $this->nomUtil = $nomUtil;

        return $this;
    }

    /**
     * Get the value of prenomUtil
     */ 
    public function getPrenomUtil():string
    {
        return $this->prenomUtil;
    }

    /**
     * Set the value of prenomUtil
     *
     * @return  self
     */ 
    public function setPrenomUtil(string $prenomUtil):self
    {
        $this->prenomUtil = $prenomUtil;

        return $this;
    }

    /**
     * Get the value of adresseUtil
     */ 
    public function getAdresseUtil():string
    {
        return $this->adresseUtil;
    }

    /**
     * Set the value of adresseUtil
     *
     * @return  self
     */ 
    public function setAdresseUtil(string $adresseUtil):self
    {
        $this->adresseUtil = $adresseUtil;

        return $this;
    }

    /**
     * Get the value of codePostalUtil
     */ 
    public function getCodePostalUtil():int
    {
        return $this->codePostalUtil;
    }

    /**
     * Set the value of codePostalUtil
     *
     * @return  self
     */ 
    public function setCodePostalUtil(int $codePostalUtil):self
    {
        $this->codePostalUtil = $codePostalUtil;

        return $this;
    }

    /**
     * Get the value of villeUtil
     */ 
    public function getVilleUtil():string
    {
        return $this->villeUtil;
    }

    /**
     * Set the value of villeUtil
     *
     * @return  self
     */ 
    public function setVilleUtil(string $villeUtil):self
    {
        $this->villeUtil = $villeUtil;

        return $this;
    }

    /**
     * Get the value of mailUtil
     */ 
    public function getMailUtil():string
    {
        return $this->mailUtil;
    }

    /**
     * Set the value of mailUtil
     *
     * @return  self
     */ 
    public function setMailUtil(string $mailUtil):self
    {
        $this->mailUtil = $mailUtil;

        return $this;
    }

    /**
     * Get the value of telUtil
     */ 
    public function getTelUtil():int
    {
        return $this->telUtil;
    }

    /**
     * Set the value of telUtil
     *
     * @return  self
     */ 
    public function setTelUtil(int $telUtil):self
    {
        $this->telUtil = $telUtil;

        return $this;
    }

    /**
     * Get the value of passwordUtil
     */ 
    public function getPasswordUtil():string
    {
        return $this->passwordUtil;
    }

    /**
     * Set the value of passwordUtil
     *
     * @return  self
     */ 
    public function setPasswordUtil(string $passwordUtil):self
    {
        $this->passwordUtil = $passwordUtil;

        return $this;
    }

    /**
     * Get the value of dateNaissance
     */ 
    public function getDateNaissance():?DateTime
    {
        return new DateTime($this->dateNaissance);
    }

    /**
     * Set the value of dateNaissance
     *
     * @return  self
     */ 
    public function setDateNaissance(?string $dateNaissance):self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get the value of dateInscriptionUtil
     */ 
    public function getDateInscriptionUtil():DateTime
    {
        return new DateTime($this->dateInscriptionUtil);
    }

    /**
     * Set the value of dateInscriptionUtil
     *
     * @return  self
     */ 
    public function setDateInscriptionUtil(string $dateInscriptionUtil):self
    {
        $this->dateInscriptionUtil = $dateInscriptionUtil;

        return $this;
    }

    /**
     * Get the value of idRole
     */ 
    public function getIdRole():int
    {
        return $this->idRole;
    }

    /**
     * Set the value of idRole
     *
     * @return  self
     */ 
    public function setIdRole(int $idRole):self
    {
        $this->idRole = $idRole;

        return $this;
    }

    /**
     * Get the value of idPays
     */ 
    public function getIdPays():int
    {
        return $this->idPays;
    }

    /**
     * Set the value of idPays
     *
     * @return  self
     */ 
    public function setIdPays(int $idPays):self
    {
        $this->idPays = $idPays;

        return $this;
    }
}
?>