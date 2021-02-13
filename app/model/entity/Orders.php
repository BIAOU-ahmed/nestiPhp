<?php

class Orders extends BaseEntity{
    private $idOrders;
    private $flag;
    private $dateCreation;
    private $idUser;

    
    public function getOrderLines(): array{
        return $this->getRelatedEntities("OrderLine");
    }
    
    public function getUser(): ?Users{
        return $this->getRelatedEntity("User");
    }

    public function setUser(Users $user){
        $this->setRelatedEntity($user);
    }

    /**
     * Get the value of idOrdes
     */
    public function getIdOrders()
    {
        return $this->idOrders;
    }

    /**
     * Set the value of idOrdes
     *
     * @return  self
     */
    public function setIdOrders($idOrders)
    {
        $this->idOrders = $idOrders;

        return $this;
    }

    /**
     * Get the value of flag
     */
    public function getFlag()
    {
        return $this->flag;
    }


    public function getPrice(){
        $orderLines = $this->getOrderLines();
        $price = 0;
        foreach($orderLines as $line){
            $price +=(INT) $line->getArticle()->getLastPrice() * $line->getQuantity();
        }
        return $price;
    }
    /**
     * Set the value of flag
     *
     * @return  self
     */
    public function setFlag($flag)
    {
        $this->flag = $flag;

        return $this;
    }

    

    /**
     * Get the value of idUser
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Set the value of idUser
     *
     * @return  self
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get the value of dateCreation
     */ 
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set the value of dateCreation
     *
     * @return  self
     */ 
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }
}