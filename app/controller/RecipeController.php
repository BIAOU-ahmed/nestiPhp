<?php

// SiteUtil::require('model/entity/Recipe.php');
SiteUtil::require('model/entity/Users.php');
SiteUtil::require('util/FormatUtil.php');
SiteUtil::require('controller/BaseController.php');




class RecipeController extends BaseEntityController
{

    protected static $entityClass = "Recipe";
    protected static $dao = "RecipeDao";
    protected static $loggedInUser;
    protected static $entity;
    // public static function getEntityClass()
    // {

    //     return "Users";
    // }

    // public static function callActionMethod($action)
    // {
    //     self::$entity = self::getUser();
    //     if (self::$entity == null) {
    //         $action = "login";
    //     }
    //     parent::callActionMethod($action);
    // }



    public static function edit()
    {

        $templateName = 'edit';
        $templateVars = ["isSubmitted" => !empty($_POST[self::getEntityClass()])];

        if ($templateVars["isSubmitted"]) { // if we arrived here by way of the submit button in the edit view
            $recipe = static::getEntity();
            $formBuilder = new RecipeFormBuilder($recipe, $_POST[static::getEntityClass()]);

            // EntityUtil::setFromArray($recipe,$_POST[self::getEntityClass()]);

            //     IF NEW.`idImage` IS NULL OR NEW.`idImage` = '' THEN
            //     SET NEW.`idImage` = 1;
            // END IF
            if ($formBuilder->isValid()) {

                $chefId =  UserController::getLoggedInUser()->getId();
                $validatedProperties = $formBuilder->getParameters();
                EntityUtil::setFromArray($recipe, $validatedProperties);
                $recipe->setIdChef($chefId);
                self::getDao()::saveOrUpdate($recipe);
                // header('Location: ' . SiteUtil::url() . 'recipe/list/'.$recipe->getId());
                // exit;
            } else {
                $templateVars["errors"] = $formBuilder->getErrors();
                $properties = $_POST[static::getEntityClass()];
            }
        }

        // template remains "edit" if no POST user parameters, or if user parameters in POST are invalid
        self::render($templateName, $templateVars);
    }


    public static function addImage()
    {
        if (isset($_FILES)) {
            $filetype = array('jpeg', 'jpg', 'png', 'gif', 'PNG', 'JPEG', 'JPG');
            // FormatUtil::dump($_POST['idRecipe']);
            foreach ($_FILES as $key) {

                $name = time() . $key['name'];
                $path = '../public/images/recipes/' . $name;
                $file_ext =  pathinfo($name, PATHINFO_EXTENSION);


                if (in_array(strtolower($file_ext), $filetype)) {

                    if ($key['size'] < 1000000) {
                        if (move_uploaded_file($key['tmp_name'], $path)) {

                            $d = new DateTime('NOW');
                            $t = explode('.', $name);
                            $image = new Image();
                            $image->setName($t[0]);
                            $image->setDateCreation($d->format('Y-m-d H:i:s'));
                            $image->setFileExtension($t[1]);
                            ImageDao::saveOrUpdate($image);
                            $recipe = RecipeDao::findById($_POST['idRecipe']);
                            $recipe->setIdImage($image->getId());
                            RecipeDao::saveOrUpdate($recipe);
                            // FormatUtil::dump($image);
                            echo SiteUtil::url() . 'public/images/recipes/' . $name;
                        }
                    } else {
                        echo "FILE_SIZE_ERROR";
                    }
                } else {
                    echo "FILE_TYPE_ERROR";
                }
            }
        }
        if(isset($_POST['recipe'])){
            $recipe = RecipeDao::findById($_POST['recipe']);
            $recipe->setIdImage(null);
            RecipeDao::saveOrUpdate($recipe);
            echo SiteUtil::url() . 'public/images/recipes/gateauauxfraises.jpg';
        }
    }
    public static function movePreparations()
    {
        if (isset($_POST['recipe'])) {
            $idRecipe = $_POST['recipe'];
            $idParagraph = $_POST['id'];
            $action = $_POST['action'];
            $recipe = RecipeDao::findById($idRecipe);
            // echo "idRecipe ".$idRecipe;
            // FormatUtil::dump($recipe);
            $paragraph = ParagraphDao::findById($idParagraph);
            if ($action == "up") {
                $previous = $paragraph->getPreviousParagraph();

                // FormatUtil::dump($paragraph);
                // FormatUtil::dump($previous);
            } elseif ($action == "down") {
                $previous = $paragraph->getFollowingParagraph();
                // FormatUtil::dump($paragraph->getFollowingParagraph());
            }

            $currentPosition = $paragraph->getParagraphPosition();
            $newPosition = $previous->getParagraphPosition();
            $paragraph->setParagraphPosition($newPosition);
            $previous->setParagraphPosition($currentPosition);
            ParagraphDao::saveOrUpdate($previous);
            ParagraphDao::saveOrUpdate($paragraph);
            // FormatUtil::dump($recipe);
            foreach ($recipe->getParagraphs() as $paragraph) {
                // $array[$ing->getRecipePosition()] = [];
                $array[$paragraph->getParagraphPosition()]['id'] = $paragraph->getId();
                $array[$paragraph->getParagraphPosition()]['content'] = $paragraph->getContent();
            }
            echo json_encode($array);

            // FormatUtil::dump($paragraph);
        }
    }

    public static function addPreparations()
    {
        $idRecipe = isset($_POST['recipe']) ? $_POST['recipe'] : $_POST['load'];
        $recipe = RecipeDao::findById($idRecipe);

        if (isset($_POST['recipe'])) {
            if (isset($_POST['deletedPara'])) {

                $recipePara = ParagraphDao::findById($_POST['deletedPara']);
                // FormatUtil::dump($ingredientRecipe->getRecipePosition());
                $values = [$recipePara->getParagraphPosition(), $recipe->getId()];
                $allNext = ParagraphDao::findPrevOrFollo($values, ">", "ASC");
                $nextPosition = $recipePara->getParagraphPosition();
                ParagraphDao::deleteRecipeParagraph($recipePara);

                foreach ($allNext as $recipeParagraph) {
                    // $positionSwitch = $recipeIngredient->getRecipePosition();
                    $recipeParagraph->setParagraphPosition($nextPosition);
                    $nextPosition += 1;
                    ParagraphDao::saveOrUpdate($recipeParagraph);
                    // IngredientRecipeDao::updateRecipeIngredient($recipeIngredient);
                }
                // FormatUtil::dump($allNext);
            } else {

                // echo $_POST['preparationContent'];
                $paragraphContent = FormatUtil::sanitize($_POST['preparationContent']);
                // echo $paragraphContent;
                $paragraph = new Paragraph();
                $paragraph->setIdRecipe($idRecipe);
                $paragraph->setContent($paragraphContent);

                // FormatUtil::dump($paragraph);
                if (isset($_POST['update'])) {
                    $paragraph = ParagraphDao::findById($_POST['update']);
                    $paragraph->setContent($_POST['newValue']);
                }
                ParagraphDao::saveOrUpdate($paragraph);
            }
        }



        foreach ($recipe->getParagraphs() as $paragraph) {
            // $array[$ing->getRecipePosition()] = [];
            $array[$paragraph->getParagraphPosition()]['id'] = $paragraph->getId();
            $array[$paragraph->getParagraphPosition()]['content'] = $paragraph->getContent();
        }
        echo json_encode($array);
    }

    public static function addIngredient()
    {
        $idRecipe = isset($_POST['recipe']) ? $_POST['recipe'] : $_POST['load'];
        $recipe = RecipeDao::findById($idRecipe);
        $result = true;
        if (isset($_POST['recipe'])) {
            if (isset($_POST['idProduct'])) {
                // echo "toto";
                $ingredientRecipe = IngredientRecipeDao::findOneBy($_POST['idProduct'], $recipe->getId());
                // FormatUtil::dump($ingredientRecipe->getRecipePosition());
                $values = [$ingredientRecipe->getRecipePosition(), $recipe->getId()];
                $allNext = IngredientRecipeDao::findPrevOrFollo($values, ">");
                $nextPosition = $ingredientRecipe->getRecipePosition();
                IngredientRecipeDao::deleteRecipeIngredient($ingredientRecipe);

                foreach ($allNext as $recipeIngredient) {
                    // $positionSwitch = $recipeIngredient->getRecipePosition();
                    $recipeIngredient->setRecipePosition($nextPosition);
                    $nextPosition += 1;
                    IngredientRecipeDao::updateRecipeIngredient($recipeIngredient);
                }
                // FormatUtil::dump($allNext);
            } else {

                $ingName = $_POST['ingredientName'];
                $unitName = $_POST['unitName'];
                $quantity = $_POST['quantity'];

                $ingredient = ProductDao::findOneBy("name", $ingName);
                $unit = UnitDao::findOneBy("name", $unitName);
                if ($ingredient == null) {
                    $ingredient = new Product();
                    $ingredient->setName($ingName);
                    ProductDao::save($ingredient);
                    $ingredient->makeIngredient();
                }
                if ($unit == null) {
                    $unit = new Unit();
                    $unit->setName($unitName);
                    UnitDao::saveOrUpdate($unit);
                }
                // FormatUtil::dump($unit);
                // FormatUtil::dump($ingredient);
                // FormatUtil::dump($ingredient->getId());
                // FormatUtil::dump($unit->getId());
                $ingredientRecipe = IngredientRecipeDao::findOneBy($ingredient->getId(), $recipe->getId());
                // FormatUtil::dump($ingredientRecipe);
                if (!$ingredientRecipe) {
                    $result = true;
                    $ingredientRecipe = new IngredientRecipe();
                    $ingredientRecipe->setIdProduct($ingredient->getId());
                    $ingredientRecipe->setIdRecipe($recipe->getId());
                    $ingredientRecipe->setIdUnit($unit->getId());
                    $ingredientRecipe->setQuantity($quantity);
                    // FormatUtil::dump($ingredientRecipe);
                    IngredientRecipeDao::save($ingredientRecipe);
                } else {
                    $result = false;
                }
            }


            // CREATE TRIGGER `increment_position` BEFORE INSERT ON `ingredientrecipe` FOR EACH ROW BEGIN DECLARE naw_position integer; SET @naw_position := (SELECT MAX(recipePosition)FROM ingredientrecipe WHERE idRecipe = NEW.`idRecipe`); SET NEW.`recipePosition` = @maxPosition+1; END 
            // FormatUtil::dump($unit);
            // FormatUtil::dump($ingredient);
            // FormatUtil::dump($recipe);

        }

        if ($result) {
            $array = [];

            foreach ($recipe->getIngredientRecipes() as $ing) {
                // $array[$ing->getRecipePosition()] = [];
                $array[$ing->getRecipePosition()]['idRecipe'] = $ing->getIdRecipe();
                $array[$ing->getRecipePosition()]['idProduct'] = $ing->getIdProduct();
                $array[$ing->getRecipePosition()]['quantity'] = $ing->getQuantity();
                $array[$ing->getRecipePosition()]['unitName'] = $ing->getUnit()->getName();
                $array[$ing->getRecipePosition()]['ingredientName'] = $ing->getIngredient()->getName();
            }

            // FormatUtil::dump($array);
            echo json_encode($array);
        } else {
            echo $result;
        }


        // self::render(['action' => 'addIngredientToRecipe','base' => 'users/baseLogin']);
    }
}
