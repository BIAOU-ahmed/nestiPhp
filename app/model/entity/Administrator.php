<?php
class Administrator extends Users{
    private $idAdministrator;


    public function getImportations(): array{
        return $this->getRelatedEntities("Importation"); 
    }

    public function getLots(): array{
        return $this->getIndirectlyRelatedEntities("Lot", "Importation"); 
    }

    public function getNbImportation(){
        return sizeof($this->getImportations());
    }

    public function getLastImportation(){
        $importations = $this->getImportations();
        usort($importations, function($a, $b) {return strcmp($a->getImportationDate(), $b->getImportationDate());});
        $index = sizeof($importations)-1;
        $result = '';
        if($index>=0){
            $result = $importations[$index]->getImportationDate();
        }
        return $result;
    }

    /**
     * Get the value of idAdministrator
     */ 
    public function getIdAdministrator()
    {
        return $this->idAdministrator;
    }

    /**
     * Set the value of idAdministrator
     *
     * @return  self
     */ 
    public function setIdAdministrator($idAdministrator)
    {
        $this->idAdministrator = $idAdministrator;

        return $this;
    }
}