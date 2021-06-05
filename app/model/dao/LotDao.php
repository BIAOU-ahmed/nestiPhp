<?php

class LotDao extends BaseDao{
 

    public static function findAll($flag=null): array
    {
        $pdo = DatabaseUtil::connect();
        $sql = "SELECT * FROM " . self::getTableName();
        
        $values = [];

        if ( $flag != null && in_array('flag', self::getColumnNames()) ){
            $sql .= " AND flag = ?";
            $values[] = $flag;
        }

        $req = $pdo->prepare($sql);
 
        $req->execute($values);

        $entities = [];
        while ($entity = self::fetchEntity($req, $flag)) { // set entity properties using fetched values
            if ($entity != null){ // entity might have a parent with a blocked flag
                $entities[] = $entity;
            }
        };
        return $entities;
    }


    public static function findOneLot($value, $flag=null)
    {
        $pdo = DatabaseUtil::connect();
        $sql = "SELECT * FROM " . self::getTableName() . " WHERE idArticle = ? AND idSupplierOrder = ?";
        $values = $value;

        if ( $flag != null  && in_array('flag', self::getColumnNames()) ){
            $sql .= " AND flag = ?";
            $values[] = $flag;
        }

        $req = $pdo->prepare($sql);
        $req->execute($values);

        $entity = self::fetchEntity($req, $flag); // set entity properties using fetched values

        return $entity ?? null; // fetchObject returns boolean false if no row found, whereas we want null
    }


    public static function save(?BaseEntity &$entity)
    {
        $insertedId = null;
        // Loop through inherited tables (from parent to child), inserting the relevant entity properties
        foreach (self::getParentClasses() as $currentClass) {
            $pdo = DatabaseUtil::connect();
            $currentDao = $currentClass::getDaoClass();


            $sql = "INSERT INTO `lot` (`idArticle`, `idSupplierOrder`, `unitCost`, `dateReception`, `quantity`) VALUES (?, ?, ?, ?, ?);";
            

            $q = $pdo->prepare($sql);

            $q->execute(array(EntityUtil::get($entity, "idArticle"), EntityUtil::get($entity, "idSupplierOrder"), EntityUtil::get($entity, "unitCost"), EntityUtil::get($entity, "dateReception"), EntityUtil::get($entity, "quantity")));
        }

        return $entity; // Last inserted ID is entity's id
    }

}