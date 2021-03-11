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

    public function getNbRecipe(){
        $chefRecipes = RecipeDao::findAllBy('idChef',$this->getIdChef());
        return sizeof($this->getRecipes());
    }

    public function getLastRecipe(){
        $chefRecipes =$this->getRecipes();
        usort($chefRecipes, function($a, $b) {return strcmp($a->getDateCreation(), $b->getDateCreation());});
        $index = sizeof($chefRecipes)-1;
        $result = '';
        if($index>=0){
            $result = $chefRecipes[$index]->getName();
        }
        return $result;
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