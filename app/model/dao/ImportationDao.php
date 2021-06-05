<?php

class ImportationDao extends BaseDao{
 
    public static function save(?BaseEntity &$entity)
    {
        $insertedId = null;
        // Loop through inherited tables (from parent to child), inserting the relevant entity properties
        foreach (self::getParentClasses() as $currentClass) {
            $pdo = DatabaseUtil::connect();
            $currentDao = $currentClass::getDaoClass();


            $sql = "INSERT INTO `importation` (`idArticle`, `idSupplierOrder`, `idAdministrator`, `importationDate`) VALUES (?, ?, ?, ?);";
           

            $q = $pdo->prepare($sql);

            $q->execute(array(EntityUtil::get($entity, "idArticle"), EntityUtil::get($entity, "idSupplierOrder"), EntityUtil::get($entity, "idAdministrator"), EntityUtil::get($entity, "importationDate")));
        }

       
        return $entity; // Last inserted ID is entity's id
    }
}