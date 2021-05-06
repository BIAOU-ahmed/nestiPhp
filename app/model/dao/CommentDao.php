<?php

class CommentDao extends BaseDao
{

    public static function findComment($value, $flag = null): ?Comment
    {
        $pdo = DatabaseUtil::connect();
        $sql = "SELECT * FROM " . self::getTableName() . " WHERE idUsers = ? AND idRecipe = ?";
        $values = $value;

        if ($flag != null  && in_array('flag', self::getColumnNames())) {
            $sql .= " AND flag = ?";
            $values[] = $flag;
        }

        $req = $pdo->prepare($sql);
        $req->execute($values);

        $entity = self::fetchEntity($req, $flag); // set entity properties using fetched values

        return $entity ?? null; // fetchObject returns boolean false if no row found, whereas we want null
    }


    public static function updateComment(?Comment &$entity)
    {
        foreach (self::getParentClasses() as $currentClass) {
            $pdo = DatabaseUtil::connect();
            $currentDao = $currentClass::getDaoClass();


            $sql = "UPDATE " . $currentDao::getTableName() . " SET commentTitle = ? , commentContent = ? , dateCreation = ? , flag = ? , idModerator = ?  WHERE idUsers = ? AND idRecipe= ?";
            $q = $pdo->prepare($sql);

            $values = [$entity->getCommentTitle(), $entity->getCommentContent(), $entity->getDateCreation(), $entity->getFlag(), $entity->getIdModerator(), $entity->getIdUsers(), $entity->getIdRecipe()];

            $q->execute($values);
        }
    }
}
