<?php

class FormBuilder
{


    public  $formParameters;
    public  $parameters;
    public $entity;
    public $errors;
    public function __construct($entity,array $parameters)
    {
        $this->entity = $entity;
        $this->parameters = $parameters;
    }
    /**
     * isValid
     * Looks at error array andreturns false if it contains an error
     * @return bool true if all validators passed, false if just one validator failed
     */
    public function isValid()
    {
        return empty($this->getErrors());
    }





    /**
     * validateProperty
     * Loops through all validators for that property (if any), and returns a list of failed validators
     * @param  String $fieldName
     * @return Array errors found, by validator name (or empty array if none found)
     * example return array:
     * ['notEmpty' => true],   // error found: empty value
     */
    public function validateProperty(String $propertyName)
    {
        $propertyErrors = [];

        if (isset($this->formParameters[$propertyName])) {
            // Loop through each validator for that field
            foreach ($this->formParameters[$propertyName] as $validatorName) {
                // store error states (negated validator) with the validator name as key
                $errored = !EntityValidatorUtil::$validatorName($this->entity,$this->parameters, $propertyName);
                if ($errored) {
                    $propertyErrors[$validatorName] = true;
                }
            }
        }

        return $propertyErrors;
    }


    /**
     * getErrors
     * validate each field, store array of failed validators
     * @return Array multidimensional array of error arrays, stored by property name.
     * Example returned array: 
     *  [
     *      'lastName'  =>  ['notEmpty' => true],
     *      'tel'       =>  ['notEmpty' => true, 'telephone' => true ],
     *      'email'     =>  ['unique' => true ],
     * ]
     */
    public function getErrors(): ?array
    {
        if ($this->errors == null) {
            $this->errors = [];

            foreach ($this->parameters as $propertyName => $validators) {
                // assign an array of errors in the form ['myValidator' => true, 'myOtherValidator' => false ]
                $this->errors[$propertyName] = $this->validateProperty($propertyName);
                if (empty($this->errors[$propertyName])) {
                    unset($this->errors[$propertyName]); // If no error found, unset empty array
                }
            }
        }

        return $this->errors;
    }

    /**
     * Get the value of formParameters
     */ 
    public function getFormParameters()
    {
        return $this->formParameters;
    }

    /**
     * Get the value of parameters
     */ 
    public function getParameters()
    {
        return $this->parameters;
    }
}
