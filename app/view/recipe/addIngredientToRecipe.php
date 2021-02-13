
<?php
// $ingredient = IngredientDao::findAllBy("name",)

// FormatUtil::dump($_POST);
if (isset($_POST['recipe'])) {
    $ingName = $_POST['ingredientName'];
    $unitName = $_POST['unitName'];
    $quantity = $_POST['quantity'];
    $recipe = RecipeDao::findById($_POST['recipe']);
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

    $ingredientRecipe = new IngredientRecipe();
    $ingredientRecipe->setIdProduct($ingredient->getId());
    $ingredientRecipe->setIdRecipe($recipe->getId());
    $ingredientRecipe->setIdUnit($unit->getId());
    $ingredientRecipe->setQuantity($quantity);
    // FormatUtil::dump($ingredientRecipe);
    IngredientRecipeDao::save($ingredientRecipe);
    // CREATE TRIGGER `increment_position` BEFORE INSERT ON `ingredientrecipe` FOR EACH ROW BEGIN DECLARE naw_position integer; SET @naw_position := (SELECT MAX(recipePosition)FROM ingredientrecipe WHERE idRecipe = NEW.`idRecipe`); SET NEW.`recipePosition` = @maxPosition+1; END 
    // FormatUtil::dump($unit);
    // FormatUtil::dump($ingredient);
    // FormatUtil::dump($recipe);

    foreach ($recipe->getIngredientRecipes() as $ing) { ?>
        <li>
            <?= $ing->getQuantity() . " " . $ing->getUnit()->getName() . ' de ' . $ing->getIngredient()->getName() ?>
        </li>
<?php }
}
