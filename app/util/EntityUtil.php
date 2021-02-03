<?php
class EntityUtil{
    public static function get($entity,String $propertyName){

        return $entity->{'get'.ucfirst($propertyName)}();
    }
    
    public static function set(&$entity,String $propertyName,$propertyValue){

        return $entity->{'set'.ucfirst($propertyName)}($propertyValue);
    }
}