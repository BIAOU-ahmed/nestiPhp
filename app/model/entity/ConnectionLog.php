<?php

class ConnectionLog extends BaseEntity{
    private $idConnectionLog;
    private $dateConnection;
    private $idUsers;

    public function getUser(): ?Users{ 
        return $this->getRelatedEntity("User");
    }

    public function setUser(Users $u){
        $this->setRelatedEntity($u);
    }

    /**
     * Get the value of idUser
     */ 
    public function getIdUsers()
    {
        return $this->idUsers;
    }

    /**
     * Set the value of idUser
     *
     * @return  self
     */ 
    public function setIdUsers($idUser)
    {
        $this->idUsers = $idUser;

        return $this;
    }

    /**
     * Get the value of dateConnection
     */ 
    public function getDateConnection()
    {
        return $this->dateConnection;
    }

    /**
     * Set the value of dateConnection
     *
     * @return  self
     */ 
    public function setDateConnection($dateConnection)
    {
        $this->dateConnection = $dateConnection;

        return $this;
    }

    /**
     * Get the value of idUserLog
     */ 
    public function getIdConnectionLog()
    {
        return $this->idConnectionLog;
    }

    /**
     * Set the value of idUserLog
     *
     * @return  self
     */ 
    public function setIdConnectionLog($idUserLog)
    {
        $this->idConnectionLog = $idUserLog;

        return $this;
    }
}