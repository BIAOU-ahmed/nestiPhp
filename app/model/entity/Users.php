<?php

class Users extends BaseEntity
{

    // public const VALIDATED_PROPERTIES = [
    //     "firstName" => ["notEmpty", "letters"],
    //     "lastName" => ["notEmpty", "letters"],
    //     "passwordHash" => ["notEmpty", "strong",""],
    //     "login" => ["notEmpty", "unique"],
    //     "email" => ["email", "unique"]
    // ];

    private $idUsers;
    private $lastName;
    private $firstName;
    private $email;
    private $passwordHash;
    private $flag;
    private $dateCreation;
    private $login;
    private $address1;
    private $address2;
    private $zipCode;
    private $idCity;


    private $errors;

    function __construct()
    {
        if($this->getDateCreation()==null){
            $d = new DateTime('NOW');
            $this->setDateCreation($d->format('Y-m-d H:i:s'));
        }

    }



    // /**
    //  * isValid
    //  * Looks at error array andreturns false if it contains an error
    //  * @return bool true if all validators passed, false if just one validator failed
    //  */
    // public function isValid()
    // {
    //     return empty($this->getErrors());
    // }





    // /**
    //  * validateProperty
    //  * Loops through all validators for that property (if any), and returns a list of failed validators
    //  * @param  String $fieldName
    //  * @return Array errors found, by validator name (or empty array if none found)
    //  * example return array:
    //  * ['notEmpty' => true],   // error found: empty value
    //  */
    // public function validateProperty(String $propertyName)
    // {
    //     $propertyErrors = [];

    //     if (isset(self::VALIDATED_PROPERTIES[$propertyName])) {
    //         // Loop through each validator for that field
    //         foreach (self::VALIDATED_PROPERTIES[$propertyName] as $validatorName) {
    //             // store error states (negated validator) with the validator name as key
    //             $errored = !EntityValidatorUtil::$validatorName($this, $propertyName);
    //             if ($errored) {
    //                 $propertyErrors[$validatorName] = true;
    //             }
    //         }
    //     }

    //     return $propertyErrors;
    // }


    // /**
    //  * getErrors
    //  * validate each field, store array of failed validators
    //  * @return Array multidimensional array of error arrays, stored by property name.
    //  * Example returned array: 
    //  *  [
    //  *      'lastName'  =>  ['notEmpty' => true],
    //  *      'tel'       =>  ['notEmpty' => true, 'telephone' => true ],
    //  *      'email'     =>  ['unique' => true ],
    //  * ]
    //  */
    // public function getErrors(): ?array
    // {
    //     if ($this->errors == null) {
    //         $this->errors = [];

    //         foreach (self::VALIDATED_PROPERTIES as $propertyName => $validators) {
    //             // assign an array of errors in the form ['myValidator' => true, 'myOtherValidator' => false ]
    //             $this->errors[$propertyName] = $this->validateProperty($propertyName);
    //             if (empty($this->errors[$propertyName])) {
    //                 unset($this->errors[$propertyName]); // If no error found, unset empty array
    //             }
    //         }
    //     }

    //     return $this->errors;
    // }

    public function getCity(): ?City
    {
        return $this->getRelatedEntity("City");
    }

    public function setCity(City $c)
    {
        $this->setRelatedEntity($c);
    }


    public function getOrders(): array
    {
        return $this->getRelatedEntities("Orders");
    }

    public function getConnectionLogs(): array
    {
        return $this->getRelatedEntities("ConnectionLog");
    }

    public function getComments(): array
    {
        return $this->getRelatedEntities("Comment");
    }

    public function getRecipes(): array
    {
        return $this->getIndirectlyRelatedEntities("Recipe", "Grades", BaseDao::FLAGS['active']);
    }

    /**
     * Get the value of dateCreation
     */
    public function getDateCreation()
    {

        return $this->dateCreation;
    }

    /**
     * Set the value of dateCreation
     *
     * @return  self
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get the value of flag
     */
    public function getFlag()
    {
        return $this->flag;
    }

    /**
     * Set the value of flag
     *
     * @return  self
     */
    public function setFlag($flag)
    {
        $this->flag = $flag;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPasswordHash()
    {
        return $this->passwordHash;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */
    public function setPasswordHash($p)
    {
        $this->passwordHash = $p;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of firtName
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set the value of firtName
     *
     * @return  self
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }
    public function getRoles()
    {
        $isAdmin = AdministratorDao::findOneBy("idAdministrator", $this->getId());
        $isChef = ChefDao::findOneBy("idChef", $this->getId());
        $isModerator = ModeratorDao::findOneBy("idModerator", $this->getId());
        $rolesArray = [];

        if ($isAdmin) {
            $rolesArray[] = "Admin";
        }
        if ($isChef) {
            $rolesArray[] = "Chef";
        }
        if ($isModerator) {
            $rolesArray[] = "Moderator";
        }
        $roles = implode(",", $rolesArray);

        if ($roles == "") {
            $roles = "Utilisateur";
        }
        return $roles;
    }
    public function getNbOrder(){
        return sizeof($this->getOrders());
    }

    public function ordersPrice(){
        $userOrders = $this->getOrders();
        $total = 0;
        foreach($userOrders as $order){
            $total += $order->getPrice();
        }
        return $total;
    }

    public function getLastOrder(){        
        $userOrders = $this->getOrders();
        usort($userOrders, function($a, $b) {return strcmp($a->getDateCreation(), $b->getDateCreation());});
        $index = sizeof($userOrders)-1;
        $result = '';
        if($index>=0){
            $result = $userOrders[$index]->getPrice();
        }
        return $result;
    }

    public function getChef(){
        return ChefDao::findById($this->getId());
    }
    public function getAdministrator(){
        return AdministratorDao::findById($this->getId());
    }
    public function getModerator(){
        return ModeratorDao::findById($this->getId());
    }
    public function makeChef(){
        if($this->getChef()==null){
            $chef = new Chef();
            $chef->setIdChef($this->getId());
            ChefDao::save($chef);
        }
       
    }
    public function makeAdministrator(){
        if($this->getAdministrator()==null){
            $administrator = new Administrator();
            $administrator->setIdAdministrator($this->getId());
            AdministratorDao::save($administrator);
        }
       
    }
    public function makeModerator(){
        if($this->getModerator()==null){
            $moderator = new Moderator();
            $moderator->setIdModerator($this->getId());
            ModeratorDao::save($moderator);
        }
       
    }

    public function isChef(){
        return $this->getChef()!=null;
    }
    public function isAdministrator(){
        $result = true;
        if($this->getAdministrator()==null){
            $result = false;
        }
        return $result;
    }
    public function isModerator(){
        return $this->getModerator()!=null;
    }
   
    // public function getState()
    // {

    //     if ($this->getFlag() == "a") {
    //         $state = "Actif";
    //     } else if ($this->getFlag() == "w") {
    //         $state = "En attente";
    //     } else {
    //         $state = "Bloqué";
    //     }
    //     return $state;
    // }

    public function getLastConnectionDate()
    {
        $date = ConnectionLogDao::findLastConnection($this->getId());
        if ($date != null) {
            $date = date_create($date)->format('Y-m-d H:i');
            $dateHours = explode(" ", $date);
            $date = $dateHours[0] . ' ' . implode("h", explode(":", $dateHours[1]));
        } else {
            $date = "-";
        }
        return $date;
    }
    /**
     * Get the value of lastName
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set the value of lastName
     *
     * @return  self
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get the value of idUser
     */
    public function getIdUsers()
    {
        return $this->idUsers;
    }

    /**
     * Set the value of idUser
     *
     * @return  self
     */
    public function setIdUsers($idUsers)
    {
        $this->idUsers = $idUsers;

        return $this;
    }

    /**
     * Get the value of login
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set the value of login
     *
     * @return  self
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }


    public function setPasswordHashFromPlaintext($plaintextPassword)
    {
        $this->setPasswordHash(password_hash($plaintextPassword, PASSWORD_DEFAULT));
    }
    public function isPassword($plaintextPassword)
    {
        return password_verify($plaintextPassword, $this->getPasswordHash());
    }

    /**
     * Get the value of address1
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * Set the value of address1
     *
     * @return  self
     */
    public function setAddress1($address1)
    {
        $this->address1 = $address1;

        return $this;
    }

    /**
     * Get the value of address2
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * Set the value of address2
     *
     * @return  self
     */
    public function setAddress2($address2)
    {
        $this->address2 = $address2;

        return $this;
    }

    /**
     * Get the value of zipCode
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * Set the value of zipCode
     *
     * @return  self
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * Get the value of idCity
     */
    public function getIdCity()
    {
        return $this->idCity;
    }

    /**
     * Set the value of idCity
     *
     * @return  self
     */
    public function setIdCity($idCity)
    {
        $this->idCity = $idCity;

        return $this;
    }
}
