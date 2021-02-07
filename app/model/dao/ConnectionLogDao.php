<?php

class ConnectionLogDao extends BaseDao{
 
    public static function findLastConnection( $value, $flag=null)
    {
        $pdo = DatabaseUtil::connect();
        $sql = "SELECT MAX(dateConnection) FROM " . self::getTableName() . " WHERE idUsers = ?";
        $values = [$value];

        if ( $flag != null){
            $sql .= " AND flag = ?";
            $values[] = $flag;
        }

        $req = $pdo->prepare($sql);
        $req->execute($values);
        $lastConnectionDate = $req->fetch(); // set entity properties using fetched values

        return $lastConnectionDate[0] ?? null; // fetchObject returns boolean false if no row found, whereas we want null
    }

}