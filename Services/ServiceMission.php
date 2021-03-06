<?php
include_once($_SERVER['DOCUMENT_ROOT']."/HUMAN_HELP/Security/config.php");
include_once(PATH_BASE . "/DAO/MissionDAO.php");
include_once(PATH_BASE . "/Exceptions/DAOException.php");

class ServiceMission 
{
    private $missionDAO;

    public function __construct()
    {
        return $this->missionDAO = new MissionDAO();
    }

    public function add($mission)
    {
        try {
            return $this->missionDAO->add($mission);
        } 
        catch (DAOException $de) {
            throw new ServiceException($de->getMessage(),$de->getCode());
        }      
    }

    public function update($mission)
    {
        try {
            return $this->missionDAO->update($mission);
        } 
        catch (DAOException $de) {
            throw new ServiceException($de->getMessage(),$de->getCode());
        }     
    }

    public function delete($idMission)
    {
        try {
            $this->missionDAO->delete($idMission);
        } 
        catch (DAOException $de) {
            throw new ServiceException($de->getMessage(),$de->getCode());
        }        
    }

    public function searchAll()
    {
        try {
            return $this->missionDAO->searchAll();
        } 
        catch (DAOException $de) {
            throw new ServiceException($de->getMessage(),$de->getCode());
        }    
    }

    /************ PAGE DETAIL MISSION *********/
    public function searchById($idMission)
    {
        try 
        {          
            return $this->missionDAO->searchById($idMission);
        }
        catch (DAOException $de) {
            throw new ServiceException($de->getMessage(),$de->getCode());
        } 
    }

    /************ FILTRER LES MISSIONS ***********/
    public function searchMissions($getIdPays,$getIdTypeActivite,$getTypeFormation,$getPage)
    {
        try {
            return $this->missionDAO->searchMissions($getIdPays,$getIdTypeActivite,$getTypeFormation,$getPage);      
        }
        catch (DAOException $de) {
            throw new ServiceException($de->getMessage(),$de->getCode());
        }  
    }

    /************ PAGE LISTE MISSION PRO ***********/
    public function searchMissionByPro($idEtablissement,$page)
    {
        try {
            return $this->missionDAO->searchMissionByPro($idEtablissement,$page);      
        }
        catch (DAOException $de) {
            throw new ServiceException($de->getMessage(),$de->getCode());
        }  
    }

    /************ PAGINATION ***********/
    public function countPageMissionPro($idEtablissement)
    {
        try {
            return $this->missionDAO->countPageMissionPro($idEtablissement);      
        }
        catch (DAOException $de) {
            throw new ServiceException($de->getMessage(),$de->getCode());
        }  
    }
    public function countPageMissions($getIdPays,$getIdTypeActivite,$getTypeFormation)
    {
        try {
            return $this->missionDAO->countPageMissions($getIdPays,$getIdTypeActivite,$getTypeFormation);      
        }
        catch (DAOException $de) {
            throw new ServiceException($de->getMessage(),$de->getCode());
        }  
    }

    /**
     * Get the value of missionDAO
     */ 
    public function getMissionDAO()
    {
        return $this->missionDAO;
    }

    /**
     * Set the value of missionDAO
     *
     * @return  self
     */ 
    public function setMissionDAO($missionDAO)
    {
        $this->missionDAO = $missionDAO;

        return $this;
    }
}