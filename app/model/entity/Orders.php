<?php

class Orders extends BaseEntity
{
    private $idOrders;
    private $flag;
    private $dateCreation;
    private $idUsers;


    public function getOrderLines(): array
    {
        return $this->getRelatedEntities("OrderLine");
    }

    public function getUser(): ?Users
    {
        return $this->getRelatedEntity("Users");
    }

    public function setUser(Users $user)
    {
        $this->setRelatedEntity($user);
    }

    public function getState($entity)
    {

        if ($entity->getFlag() == "a") {
            $state = "Payé";
        } else if ($entity->getFlag() == "w") {
            $state = "En attente";
        } else {
            $state = "Annulé";
        }
        return $state;
    }

    public function getNbArticle()
    {
        $nbArticle = 0;
        foreach ($this->getOrderLines() as $orderLine) {
            $nbArticle += $orderLine->getQuantity();
        }
        return $nbArticle;
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


    public function getPrice()
    {
        $orderLines = $this->getOrderLines();
        $price = 0;
        $dateMax = strtotime($this->getDateCreation());
        foreach ($orderLines as $line) {
            $price += $line->getArticle()->getLastPriceAt($dateMax) * $line->getQuantity();
        }
        return $price;
    }

    public function getPurchases()
    {
        $orderLines = $this->getOrderLines();
        $price = 0;
        $dateMax = strtotime($this->getDateCreation());
        foreach ($orderLines as $line) {
            $price += $line->getArticle()->getTotalPurchases() * $line->getQuantity();
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
     * Get the value of dateCreation
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    public function getFormatedDate()
    {
        setlocale(LC_TIME,'fr_FR.utf8','fra');
        return utf8_encode(ucwords(strftime(" %d %B %G %Hh%M", strtotime($this->getDateCreation()))));
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

    /**
     * Get the value of idUsers
     */
    public function getIdUsers()
    {
        return $this->idUsers;
    }

    /**
     * Set the value of idUsers
     *
     * @return  self
     */
    public function setIdUsers($idUsers)
    {
        $this->idUsers = $idUsers;

        return $this;
    }
}
