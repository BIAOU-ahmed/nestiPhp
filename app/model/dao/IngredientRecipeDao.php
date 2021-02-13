<?php

class IngredientRecipeDao extends BaseDao
{

    public static function save(?BaseEntity &$entity)
    {
        $insertedId = null;
        // Loop through inherited tables (from parent to child), inserting the relevant entity properties
        foreach (self::getParentClasses() as $currentClass) {
            $pdo = DatabaseUtil::connect();
            $currentDao = $currentClass::getDaoClass();


            $sql = "INSERT INTO `ingredientrecipe` (`idProduct`, `idRecipe`, `quantity`, `idUnit`) VALUES (?, ?, ?, ?);";
            // FormatUtil::dump($sql);

            $q = $pdo->prepare($sql);

            $q->execute(array(EntityUtil::get($entity, "idProduct"), EntityUtil::get($entity, "idRecipe"), EntityUtil::get($entity, "quantity"), EntityUtil::get($entity, "idUnit")));
        }

        // FormatUtil::dump($entity);
        return $entity; // Last inserted ID is entity's id
    }



    public static function updateRecipeIngredient(?IngredientRecipe &$entity) {
        // Loop through inherited tables (from parent to child), updating the relevant entity properties
        foreach ( self::getParentClasses() as $currentClass ) { 
            $pdo = DatabaseUtil::connect();
            $currentDao = $currentClass::getDaoClass();

  
            $sql = "UPDATE " . $currentDao::getTableName() . " SET quantity = ? , recipePosition = ?   WHERE idProduct = ? AND idRecipe= ?";

            $q = $pdo->prepare($sql);

            $values = [$entity->getQuantity(),$entity->getRecipePosition(),$entity->getIdProduct(),$entity->getIdRecipe()];
           
            $q->execute($values);
        }
    }




    public static function findOneBy($product, $recipe, $flag = null)
    {
        $pdo = DatabaseUtil::connect();
        $sql = "SELECT * FROM " . self::getTableName() . " WHERE idProduct = ? AND idRecipe= ?";
        $values = [$product, $recipe];

        if ($flag != null  && in_array('flag', self::getColumnNames())) {
            $sql .= " AND flag = ?";
            $values[] = $flag;
        }

        $req = $pdo->prepare($sql);
        $req->execute($values);

        $entity = self::fetchEntity($req, $flag); // set entity properties using fetched values

        return $entity ?? null; // fetchObject returns boolean false if no row found, whereas we want null
    }


    public static function findPrevOrFollo($values, String $signe)
    {
        $pdo = DatabaseUtil::connect();
        $sql = "SELECT * FROM " . self::getTableName() . " WHERE recipePosition  $signe ? AND idRecipe = ? ORDER BY recipePosition ASC";


        $req = $pdo->prepare($sql);
        $req->execute($values);
        
        $entities = [];
        while ($entity = self::fetchEntity($req, null)) { // set entity properties to fetched column values
            if ($entity != null) { // entity might have a parent with a blocked flag
                $entities[] = $entity;
            }
        };
        return $entities;
    }


    public static function deleteRecipeIngredient(IngredientRecipe $ingredient) {
        $pdo = DatabaseUtil::connect();
        $sql = "DELETE FROM " .self::getTableName()  . " WHERE idProduct = ? AND idRecipe = ?";
        $q = $pdo->prepare($sql);
        $q->execute([$ingredient->getIdProduct() , $ingredient->getIdRecipe()]); // if user doesn't exist, null instead of id
    }

}
