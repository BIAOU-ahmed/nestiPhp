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
    // this function chek the rigth and the action called and redirecte to it
    public static function callActionMethod($action)
    {
        if ((!UserController::getLoggedInUser()->isChef() && !UserController::getLoggedInUser()->isAdministrator())) {
            $action = "accessDenied";
        }
        $id = SiteUtil::getUrlParameters()[2] ?? "";
        if(!UserController::getLoggedInUser()->isChef() && $action=="edit" && $id == ''){
            $action = "accessDenied";
        }
        parent::callActionMethod($action);
    }


    // this function is to add or edit a recipe
    public static function edit()
    {
        $templateName = 'edit';
        $templateVars = ["isSubmitted" => !empty($_POST[self::getEntityClass()])];

        if ($templateVars["isSubmitted"]) { // if we arrived here by way of the submit button in the edit view
            $recipe = static::getEntity();
            // build the recipe with the cuilder and the post data
            $formBuilder = new RecipeFormBuilder($recipe, $_POST[static::getEntityClass()]);

            // EntityUtil::setFromArray($recipe,$_POST[self::getEntityClass()]);

            //     IF NEW.`idImage` IS NULL OR NEW.`idImage` = '' THEN
            //     SET NEW.`idImage` = 1;
            // END IF
            // check if the values is valid
            if ($formBuilder->isValid()) {

                $chefId =  UserController::getLoggedInUser()->getId();
                $validatedProperties = $formBuilder->getParameters();
                EntityUtil::setFromArray($recipe, $validatedProperties);
                // if id the new recipe add current logged user like chef
                if (!$recipe->getId()) {
                    $recipe->setIdChef($chefId);
                }
                self::getDao()::saveOrUpdate($recipe);
                header('Location: ' . SiteUtil::url() . 'recipe/edit/' . $recipe->getId());
                exit;
            } else {
                $templateVars["errors"] = $formBuilder->getErrors();
                $properties = $_POST[static::getEntityClass()];
            }
        }

        // template remains "edit" if no POST user parameters, or if user parameters in POST are invalid
        self::render($templateName, $templateVars);
    }


    // this is to move the paragraph at up or down
    public static function movePreparations()
    {
        // check if we have the id of the recipe
        if (isset($_POST['recipe'])) {
            $idRecipe = $_POST['recipe']; // the recipe id
            $idParagraph = $_POST['id']; // the paragraph id
            $action = $_POST['action']; // the action asked. to up or down
            $recipe = RecipeDao::findById($idRecipe);
            $paragraph = ParagraphDao::findById($idParagraph);
            // get previews or following paragraph according to the action
            if ($action == "up") {
                $previous = $paragraph->getPreviousParagraph();
            } elseif ($action == "down") {
                $previous = $paragraph->getFollowingParagraph();
            }

            // get the moved paragraph current position
            $currentPosition = $paragraph->getParagraphPosition();

            // get the preview or following position
            $newPosition = $previous->getParagraphPosition();

            // then change the positions
            $paragraph->setParagraphPosition($newPosition);
            $previous->setParagraphPosition($currentPosition);
            ParagraphDao::saveOrUpdate($previous);
            ParagraphDao::saveOrUpdate($paragraph);
            // get the ricepe paragraphs and create a array to jsofy
            foreach ($recipe->getParagraphs() as $paragraph) {
                $array[$paragraph->getParagraphPosition()]['id'] = $paragraph->getId();
                $array[$paragraph->getParagraphPosition()]['content'] = $paragraph->getContent();
            }
            echo json_encode($array);

        }
    }

    // this to add or delete paragraph
    public static function addPreparations()
    {
        $array = [];
        $idRecipe = isset($_POST['recipe']) ? $_POST['recipe'] : $_POST['load']; // get the recipe id

        // if we have id we get the recipe
        if ($idRecipe) {
            $recipe = RecipeDao::findById($idRecipe);

            if (isset($_POST['recipe'])) {
                // if is to delete the paragraph we get the paragraph 
                // and all next paragraph and the position of the deleted paragraph
                if (isset($_POST['deletedPara'])) {

                    $recipePara = ParagraphDao::findById($_POST['deletedPara']);
                    $values = [$recipePara->getParagraphPosition(), $recipe->getId()];
                    $allNext = ParagraphDao::findPrevOrFollo($values, ">", "ASC");
                    $nextPosition = $recipePara->getParagraphPosition();
                    ParagraphDao::deleteRecipeParagraph($recipePara);

                    // we loop on all next paragraph and change their position 
                    // staring with the deleted paragraph position
                    foreach ($allNext as $recipeParagraph) {
                        $recipeParagraph->setParagraphPosition($nextPosition);
                        $nextPosition += 1;
                        ParagraphDao::saveOrUpdate($recipeParagraph);
                    }
                } else {

                    // else if is to add new paragraph we create a 
                    // new paragraph object and set the required values
                    $paragraphContent = FormatUtil::sanitize($_POST['preparationContent']);
                    $paragraph = new Paragraph();
                    $paragraph->setIdRecipe($idRecipe);
                    $paragraph->setContent($paragraphContent);

                    // if is to update the paragraph content we get the paragraph and set the new content
                    if (isset($_POST['update'])) {
                        $paragraph = ParagraphDao::findById($_POST['update']);
                        $paragraph->setContent($_POST['newValue']);
                    }
                    ParagraphDao::saveOrUpdate($paragraph);
                }
            }

            // after the action asked we loop on the recipe paragraph and create an array to return 
            foreach ($recipe->getParagraphs() as $paragraph) {
                // $array[$ing->getRecipePosition()] = [];
                $array[$paragraph->getParagraphPosition()]['id'] = $paragraph->getId();
                $array[$paragraph->getParagraphPosition()]['content'] = $paragraph->getContent();
            }
        }
        echo json_encode($array);
    }

    // add new or delete ingredient  to the recipe
    public static function addIngredient()
    {
        $idRecipe = isset($_POST['recipe']) ? $_POST['recipe'] : $_POST['load']; // get the recipe id passed
        if ($idRecipe) {

            $recipe = RecipeDao::findById($idRecipe); // get the recipe
            $result = true;
            if (isset($_POST['recipe'])) {
                if (isset($_POST['idProduct'])) {
                    // if we have the id of the product that mean we want to delete the ingredient 
                    $ingredientRecipe = IngredientRecipeDao::findOneBy($_POST['idProduct'], $recipe->getId()); // get the ingredient recipe
                    $values = [$ingredientRecipe->getRecipePosition(), $recipe->getId()];
                    $allNext = IngredientRecipeDao::findPrevOrFollo($values, ">");
                    $nextPosition = $ingredientRecipe->getRecipePosition();
                    IngredientRecipeDao::deleteRecipeIngredient($ingredientRecipe);

                    // loop on all next ingredient to change their position
                    foreach ($allNext as $recipeIngredient) {
                        $recipeIngredient->setRecipePosition($nextPosition);
                        $nextPosition += 1;
                        IngredientRecipeDao::updateRecipeIngredient($recipeIngredient);
                    }
                } else {
                    // else is to add a new recipe then we get all values passed
                    $ingName = $_POST['ingredientName'];
                    $unitName = $_POST['unitName'];
                    $quantity = $_POST['quantity'];

                    $ingredient = ProductDao::findOneBy("name", $ingName); 
                    $unit = UnitDao::findOneBy("name", $unitName);

                    // check if the ingredient asked to add is already exist if not we add it 
                    if ($ingredient == null) {
                        $ingredient = new Product();
                        $ingredient->setName($ingName);
                        ProductDao::save($ingredient);
                        $ingredient->makeIngredient();
                    }

                    $ing = IngredientDao::findById($ingredient->getId());
                    // if the product is not already an ingredient we add it like a ingredient
                    if($ing==null){
                        $ingredient->makeIngredient();
                    }
                    $ingredientRecipe = IngredientRecipeDao::findOneBy($ingredient->getId(), $recipe->getId());

                    // check if this ingredient is already added to this recipe if not it added 
                    if (!$ingredientRecipe) {

                        if ($unit == null) {
                            $unit = new Unit();
                            $unit->setName($unitName);
                            UnitDao::saveOrUpdate($unit);
                        }
                        $result = true;
                        $ingredientRecipe = new IngredientRecipe();
                        $ingredientRecipe->setIdProduct($ingredient->getId());
                        $ingredientRecipe->setIdRecipe($recipe->getId());
                        $ingredientRecipe->setIdUnit($unit->getId());
                        $ingredientRecipe->setQuantity($quantity);
                        IngredientRecipeDao::save($ingredientRecipe);
                    } else {
                        // if not we return just false
                        $result = false;
                    }
                }


                // CREATE TRIGGER `increment_position` BEFORE INSERT ON `ingredientrecipe` FOR EACH ROW BEGIN DECLARE naw_position integer; SET @naw_position := (SELECT MAX(recipePosition)FROM ingredientrecipe WHERE idRecipe = NEW.`idRecipe`); SET NEW.`recipePosition` = @maxPosition+1; END 
               

            }

            if ($result) {
                $array = [];
                // if the ingredient is added to the recipe we loop on all the recipe ingredients and make an array to return
                foreach ($recipe->getIngredientRecipes() as $ing) {
                    $array[$ing->getRecipePosition()]['idRecipe'] = $ing->getIdRecipe();
                    $array[$ing->getRecipePosition()]['idProduct'] = $ing->getIdProduct();
                    $array[$ing->getRecipePosition()]['quantity'] = $ing->getQuantity();
                    $array[$ing->getRecipePosition()]['unitName'] = $ing->getUnit()->getName();
                    $array[$ing->getRecipePosition()]['ingredientName'] = $ing->getIngredient()->getName();
                }

                echo json_encode($array);
            } else {
                echo "false";
            }
        }

    }
}
