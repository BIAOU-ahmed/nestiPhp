<?php
class Chef extends Users{
    private $idChef;

    public function getRecipes(): array{
        return $this->getRelatedEntities("Recipe", BaseDao::FLAGS['active']);
    }

    public function getUser() { 
        return UsersDao::findOneBy("idUsers",$this->idChef);
    }

    /**
     * Get the value of idChef
     */ 
    public function getIdChef()
    {
        return $this->idChef;
    }

    /**
     * Set the value of idChef
     *
     * @return  self
     */ 
    public function setIdChef($idChef)
    {
        $this->idChef = $idChef;

        return $this;
    }
}