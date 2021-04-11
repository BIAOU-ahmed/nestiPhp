<?php
SiteUtil::require('model/dao/RecipeDao.php');
class Recipe extends BaseEntity
{
    private $idRecipe;
    private $dateCreation;
    private $name;
    private $difficulty;
    private $portions;
    private $flag;
    private $preparationTime;
    private $idChef;
    private $idImage;
    private $idCategory;

    private $errors;

    function __construct()
    {
        if ($this->getDateCreation() == null) {
            $d = new DateTime('NOW');
            $this->setDateCreation($d->format('Y-m-d H:i:s'));
        }
        if ($this->getFlag() == null) {

            $this->setFlag("w");
        }
    }
    public function getAllIngredient()
    {
        return ProductDao::findAll();
    }
    public function getAllUnit()
    {
        return UnitDao::findAll();
    }
    public function getComments(): array
    {
        return $this->getRelatedEntities("Comment");
    }
    public function getGrades(): array
    {
        return $this->getRelatedEntities("Grades");
    }

    public function getParagraphs(): array
    {
        $paragraphs = $this->getRelatedEntities("Paragraph");
        usort($paragraphs, function ($a, $b) {
            return strcmp($a->getParagraphPosition(), $b->getParagraphPosition());
        });
        return $paragraphs;
    }
    public function getIngredientRecipes(): array
    {
        $ingredientRecipe = $this->getRelatedEntities("IngredientRecipe");
        usort($ingredientRecipe, function ($a, $b) {
            return strcmp($a->getRecipePosition(), $b->getRecipePosition());
        });
        return $ingredientRecipe;
    }
    public function getImage(): ?Image
    {
        return $this->getRelatedEntity("Image");
    }

    public function setImage(Image $i)
    {
        $this->setRelatedEntity($i);
    }

    public function getChef(): ?Chef
    {
        return $this->getRelatedEntity("Chef");
    }

    public function setChef(Chef $c)
    {
        $this->setRelatedEntity($c);
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
     * Get the value of idRecipe
     */
    public function getIdRecipe()
    {
        return $this->idRecipe;
    }

    public function getRate(){
        $result = 0;
        $total = 0;
        foreach ($this->getGrades() as $value) {
            $total += $value->getRating();
        }
        if(count($this->getGrades())!=0){
            $result = $total/count($this->getGrades());
        }
        return $result;
    }

    public function getTime()
    {
        $time = (int) $this->getPreparationTime();
        $hour = intdiv($time, 60);
        $min = fmod($time, 60);
        $hour = ltrim($hour, "0");
        $min = ltrim($min, "0");
        // $hour = (String) ((int)$hour) ;

        $hour = $hour ? $hour . 'h' : '';
        $min = $min ? $min . 'min' : '';

        $displayTime = $hour . $min;
        return $displayTime;
    }
    /**
     * Set the value of idRecipe
     *
     * @return  self
     */
    public function setIdRecipe($idRecipe)
    {
        $this->idRecipe = $idRecipe;

        return $this;
    }

    /**
     * Get the value of preparationTime
     */
    public function getPreparationTime()
    {
        return $this->preparationTime;
    }

    /**
     * Set the value of preparationTime
     *
     * @return  self
     */
    public function setPreparationTime($preparationTime)
    {
        $this->preparationTime = $preparationTime;

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
     * Get the value of portions
     */
    public function getPortions()
    {
        return $this->portions;
    }

    /**
     * Set the value of portions
     *
     * @return  self
     */
    public function setPortions($portions)
    {
        $this->portions = $portions;

        return $this;
    }

    /**
     * Get the value of difficulty
     */
    public function getDifficulty()
    {
        return $this->difficulty;
    }

    /**
     * Set the value of difficulty
     *
     * @return  self
     */
    public function setDifficulty($difficulty)
    {
        $this->difficulty = $difficulty;

        return $this;
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

    /**
     * Get the value of idCategory
     */ 
    public function getIdCategory()
    {
        return $this->idCategory;
    }

    /**
     * Set the value of idCategory
     *
     * @return  self
     */ 
    public function setIdCategory($idCategory)
    {
        $this->idCategory = $idCategory;

        return $this;
    }
}
