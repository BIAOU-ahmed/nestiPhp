<?php

class Article extends BaseEntity
{
    private $idArticle;
    private $unitQuantity;
    private $flag;
    private $dateCreation;
    private $dateModification;
    private $idImage;
    private $idUnit;
    private $idProduct;
    private $name;


    public function getArticlePrices(): array
    {
        return $this->getRelatedEntities("ArticlePrice");
    }

    public function getLots(): array
    {
        return $this->getRelatedEntities("Lot");
    }

    public function getOrderLines(): array
    {
        return $this->getRelatedEntities("OrderLine");
    }

    public function getProduct(): ?Product
    {
        return $this->getRelatedEntity("Product");
    }

    public function getUnit(): ?Unit
    {
        return $this->getRelatedEntity("Unit");
    }

    public function getImage(): ?Image
    {
        return $this->getRelatedEntity("Image");
    }

    public function setUnit(Unit $u)
    {
        $this->setRelatedEntity($u);
    }


    public function setProduct(Product $p)
    {
        $this->setRelatedEntity($p);
    }


    public function setImage(Image $i)
    {
        $this->setRelatedEntity($i);
    }

    public function getOrders(): array
    {
        return $this->getIndirectlyRelatedEntities("Orders", "OrderLine", BaseDao::FLAGS['active']);
    }

    public function getLastPrice(): string
    {

        $maxDate = 0;
        $arrayArticlePrice = $this->getArticlePrices();
        $price = 0;
        foreach ($arrayArticlePrice as $value) {
            $date = strtotime($value->getDateStart());
            if ($maxDate < $date) {
                $maxDate = $date;
                $price = $value->getPrice();
            }
        }
        return round($price, 2);
    }

    public function getLastPriceAt(string $dateMax): string
    {

        $maxDate = 0;
        $arrayArticlePrice = $this->getArticlePrices();
        $price = '';
        foreach ($arrayArticlePrice as $value) {
            $date = strtotime($value->getDateStart());
            if ($date <= $dateMax) {
                if ($maxDate < $date) {
                    $maxDate = $date;
                    $price = $value->getPrice();
                }
            }
        }
        return $price;
    }

    public function getImageName(): ?String
    {
        $imageName = "noImage.jpg";
        if ($this->getImage()) {
            $imageName = "articles/" . $this->getImageFullName();
        }
        return $imageName;
    }

    public function  getImageFullName()
    {
        return $this->getImage() ? $this->getImage()->getName() . '.' . $this->getImage()->getFileExtension() : "noImage.jpg";
    }
    public function getTotalPurchases()
    {
        $total = 0;
        foreach ($this->getLots() as $lot) {
            $total += $lot->getSubTotal();
        }
        return $total;
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

    /**
     * Get the value of idUnit
     */
    public function getIdUnit()
    {
        return $this->idUnit;
    }

    /**
     * Set the value of idUnit
     *
     * @return  self
     */
    public function setIdUnit($idUnit)
    {
        $this->idUnit = $idUnit;

        return $this;
    }

    /**
     * Get the value of idImage
     */
    public function getIdImage()
    {
        return $this->idImage;
    }

    /**
     * Set the value of idImage
     *
     * @return  self
     */
    public function setIdImage($idImage)
    {
        $this->idImage = $idImage;

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

    /**
     * Get the value of flag
     */
    public function getFlag()
    {
        return $this->flag;
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
     * Get the value of unitQuantity
     */
    public function getUnitQuantity()
    {
        return $this->unitQuantity;
    }

    /**
     * Set the value of unitQuantity
     *
     * @return  self
     */
    public function setUnitQuantity($unitQuantity)
    {
        $this->unitQuantity = $unitQuantity;

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

    /**
     * Get the value of dateModification
     */
    public function getDateModification()
    {
        return $this->dateModification;
    }

    /**
     * Set the value of dateModification
     *
     * @return  self
     */
    public function setDateModification($dateModification)
    {
        $this->dateModification = $dateModification;

        return $this;
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    public function getLastImportation()
    {
        $importations = ImportationDao::findAllBy('idArticle', $this->getId());
        usort($importations, function ($a, $b) {
            return strcmp($a->getImportationDate(), $b->getImportationDate());
        });
        $index = sizeof($importations) - 1;
        $result = '';
        if ($index >= 0) {
            $result = $importations[$index]->getImportationDate();
        }
        return $result;
    }

    public function getNbOrdered()
    {
        $totalQuantity = 0;
        foreach ($this->getOrderLines() as $orderLine) {
            if ($orderLine->getOrder()->getFlag() != "b") {
                $totalQuantity += $orderLine->getQuantity();
            }
        }
        return $totalQuantity;
    }

    public function getTotalSalls()
    {
        $totalQuantity = 0;
        foreach ($this->getOrderLines() as $orderLine) {
            if ($orderLine->getOrder()->getFlag() != "b") {
                $dateMax = strtotime($orderLine->getOrder()->getDateCreation());

                $totalQuantity += $this->getLastPriceAt($dateMax) * $orderLine->getQuantity();
            }
        }
        return $totalQuantity;
    }

    public function getBenefit()
    {

        return $this->getTotalSalls() - $this->getTotalPurchases();
    }

    public function getNbBought()
    {
        $totalQuantity = 0;
        foreach ($this->getLots() as $lot) {
            $totalQuantity += $lot->getQuantity();
        }
        return $totalQuantity;
    }

    public function getInventory()
    {
        return $this->getNbBought() - $this->getNbOrdered();
    }

    public function getFactoryName()
    {
        $unitQuantity = $this->getUnitQuantity();
        $unitName = $this->getUnit()->getName();
        $productName = $this->getProduct()->getName();
        $name = $unitQuantity . ' ' . $unitName . ' de ' . $productName;
        return $name;
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

    public function getDisplayName()
    {
        return $this->unitQuantity . ' ' . $this->getUnit()->getName() . ' de ' . $this->getProduct()->getName();
    }
}
