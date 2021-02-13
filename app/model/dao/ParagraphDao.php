<?php

class ParagraphDao extends BaseDao{
 

    public static function findPrevOrFollo($values,String $signe,String $order){
        $pdo = DatabaseUtil::connect();
        $sql = "SELECT * FROM " . self::getTableName() . " WHERE paragraphPosition $signe ? AND idRecipe = ? ORDER BY paragraphPosition $order";
        

        $req = $pdo->prepare($sql);
        $req->execute($values);

        $entities = [];
        while ($entity = self::fetchEntity($req,null) ) { // set entity properties to fetched column values
            if ($entity != null){ // entity might have a parent with a blocked flag
                $entities[] = $entity;
            }
        };
        return $entities;
    }

    public static function deleteRecipeParagraph(Paragraph $ingredient) {
        $pdo = DatabaseUtil::connect();
        $sql = "DELETE FROM " .self::getTableName()  . " WHERE idParagraph = ?";
        $q = $pdo->prepare($sql);
        $q->execute([$ingredient->getId()]); // if user doesn't exist, null instead of id
    }

}