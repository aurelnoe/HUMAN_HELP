<?php

class Avis
{
    private $idAvis ;
    private $temoignage;
    private $dateCommentaire;
    private $idUtilisateur;
    private $idArticle;
  
    public function __toString(){
        $this->idAvis .
        $this->auteur .
        $this->temoignage .
        $this->dateCommentaire .
        $this->idUtilisateur .
        $this->idArticle;
    }

    /**
     * Get the value of idAvis
     */ 
    public function getIdAvis()
    {
        return $this->idAvis ;
    }

    /**
     * Set the value of idAvis
     *
     * @return  self
     */ 
    public function setIdAvis( $idAvis ):self
    {
        $this->idAvis= $idAvis ;

        return $this;
    }

    /**
     * Get the value of temoignage
     */ 
    public function getTemoignage()
    {
        return $this->temoignage;
    }

    /**
     * Set the value of temoignage
     *
     * @return  self
     */ 
    public function setTemoignage($temoignage)
    {
        $this->temoignage = $temoignage;

        return $this;
    }
  

    /**
     * Get the value of dateCommentaire
     */ 
    public function getDateCommentaire():DateTime
    {
        return new DateTime($this->dateCommentaire);
    }

    /**
     * Set the value of dateCommentaire
     *
     * @return  self
     */ 
    public function setDateCommentaire(string $dateCommentaire):self
    {
        $this->dateCommentaire = $dateCommentaire;

        return $this;
    }

    /**
     * Get the value of idUtilisateur
     */ 
    public function getIdUtilisateur()
    {
        return $this->idUtilisateur;
    }

    /**
     * Set the value of idUtilisateur
     *
     * @return  self
     */ 
    public function setIdUtilisateur( $idUtilisateur):self
    {
        $this->idUtilisateur = $idUtilisateur;

        return $this;
    }


    /**
     * Get the value of idArticle
     */ 
    public function getIdArticle()
    {
        return $this->idArticle;
    }

    /**
     * Set the value of idArticle
     *
     * @return  self
     */ 
    public function setIdArticle($idArticle)
    {
        $this->idArticle = $idArticle;

        return $this;
    }

    
}