<?php

class Product extends BaseEntity{

    private $idProduct;
    private $name;


    public function getArticles(): array{
        return $this->getRelatedEntities("Article", BaseDao::FLAGS['active']);
    }
    

    /**
     * Get the value of idProduct
     */ 
    public function getIdProduct()
    {
        return $this->idProduct;
    }

    /**
     * Set the value of idProduct
     *
     * @return  self
     */ 
    public function setIdProduct($idProduct)
    {
        $this->idProduct = $idProduct;

        return $this;
    }

    public function getIngredient(){
        return IngredientDao::findById($this->getId());
    }

    public function makeIngredient(){
        if($this->getIngredient()==null){
            $ing = new Ingredient();
            $ing->setIdIngredient($this->getId());
            IngredientDao::save($ing);
        }
       
    }

    public function isIngredient(){
        return $this->getIngredient()!=null;
    }

    public function getType(){
        return $this->isIngredient() ? 'ingrédient' : 'ustensil';
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
}