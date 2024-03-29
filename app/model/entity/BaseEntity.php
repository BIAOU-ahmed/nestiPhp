<?php
class BaseEntity{
    
    protected static $columnNames; 
    /**
     * getDaoClass
     * get the DAO class that corresponds to the current instance
     * @return String the DAO class, ie "RecipeDao"
     */
    public static function getDaoClass(): String{
        return get_called_class() . "Dao";
    }

    /**
     * getRelatedEntities
     * Get an array of entities that are joined to the current instance by a foreign key
     * 
     * @param  mixed $relatedEntityClass Class of the related entity to look for
     * @return array of related entities
     */
    protected function getRelatedEntities(String $relatedEntityClass, $flag=null): array
    {
        // find dao class of the related entity
        $relatedClassDao = $relatedEntityClass::getDaoClass();

        // find column name of the related entity's primary key
        $thisPrimaryKeyName = static::getDaoClass()::getPkColumnName();

        $relatedClassPrimaryKey = $relatedClassDao::getPkColumnName();
  
        return $relatedClassDao::findAllBy(
            // joined entity's foreign key name is the same as starting entity's primary key name 
            $thisPrimaryKeyName,
            $this->getId(),
            $flag
        );
    }
    public function getState($entity)
    {

        if ($entity->getFlag() == "a") {
            $state = "Actif";
        } else if ($entity->getFlag() == "w") {
            $state = "En attente";
        } else {
            $state = "Bloqué";
        }
        return $state;
    }

    public function getStateClass($entity)
    {

        if ($entity->getFlag() == "a") {
            $color = "bg-green-400";
        } else if ($entity->getFlag() == "w") {
            $color = "bg-yellow-400";
        } else {
            $color = "bg-red-400";
        }
        return $color;
    }
    
    
    /**
     * getRelatedEntity
     * Get an entity that is joined to the current instance by a foreign key
     * 
     * @param  mixed $relatedEntityClass Class of the related entity to look for
     * @return mixed related entity, or null if none exists
     */
    protected function getRelatedEntity(String $relatedEntityClass, $flag=null): ?BaseEntity
    {
        // find dao class of the related entity
        $relatedClassDao = $relatedEntityClass::getDaoClass();

        // find column name of the related entity's primary key
        $relatedClassPrimaryKey = $relatedClassDao::getPkColumnName();

        // If foreign key is in current instance
        if (  property_exists($this, $relatedClassPrimaryKey) ){
            $relatedEntity = $relatedClassDao::findById(
                // joined entity's primary key name is the same as starting entity's corresponding foreign key 
                EntityUtil::get($this, $relatedClassPrimaryKey) ,
                $flag
            );
        } else { // If foreign key is in related object
            $relatedEntity = static::getDaoClass()::findOneBy(
                // joined entity's foreign key name is the same as starting entity's primary key
                static::getDaoClass()::getPkColumnName(),
                $this->getId(),
                $flag
            );
        }

        return $relatedEntity;
    }



  
    /**
     * setRelatedEntity
     * sets the current instance's foreign key parameter to that of the related entity's primary key
     * @param  BaseEntity $relatedEntity to link to current instance
     * @return void
     */
    protected function setRelatedEntity(?BaseEntity $relatedEntity)
    {
        // find dao class of the joined entity
        $relatedClassDao = get_class($relatedEntity)::getDaoClass();

        // find column name of the joined entity's primary key
        $relatedClassPrimaryKey = $relatedClassDao::getPkColumnName();

        EntityUtil::set($this, $relatedClassPrimaryKey, $relatedEntity->getId());

        self::getDaoClass()::saveOrUpdate($this);
    }


    
    /**
     * getId
     * get the primary key value for the current instance
     * @return void
     */
    public function getId(){
        $idColumnName = self::getDaoClass()::getPkColumnName();
        return EntityUtil::get($this, $idColumnName);
    }

    /**
     * getId
     * get the primary key value for the current instance
     * @return void
     */
    public function setId($id){
        $idColumnName = self::getDaoClass()::getPkColumnName();
        EntityUtil::set($this,  $idColumnName, $id);
    }
    

     /**
     * getIndirectlyRelatedEntities
     * Get an array of entities that are joined to the current instance in a many-to-many relationship 
     * 
     * @param  mixed $joinedEntityClass Class of the joined entity to look for
     * @return array of related entities
     */
    protected function getIndirectlyRelatedEntities(String $relatedEntityClass, String $joinClass, $flag = null): array
    {
        return self::getDaoClass()::getManyToMany($this,  $joinClass , $relatedEntityClass,$flag);
    }
}