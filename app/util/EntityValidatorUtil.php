<?php


/**
 * EntityValidator
 * static methods to validate Entity properties
 */
class EntityValidatorUtil
{

    /**
     * notEmpty
     * validates if property value is not empty
     * @param  mixed $parameters whose property we must check
     * @param  String $parameterName name of property whose value we must check
     * @return bool true if validates
     */
    public static function notEmpty($entity,$parameters, String $parameterName): bool
    {
        return !empty($parameters[$parameterName]);
    }

    /**
     * email
     * validates if property value is a valid email
     * @param  mixed $parameters whose property we must check
     * @param  String $parameterName name of property whose value we must check
     * @return bool true if validates
     */
    public static function email($entity,$parameters, String $parameterName): bool
    {
        return filter_var(
            $parameters[$parameterName],
            FILTER_VALIDATE_EMAIL
        );
    }

    /**
     * telephone
     * validates if property value is a valid telephone number
     * @param  mixed $parameters whose property we must check
     * @param  String $parameterName name of property whose value we must check
     * @return bool true if validates
     */
    public static function telephone($entity,$parameters, String $parameterName): bool
    {
        return preg_match(
            "/^\+?[0-9]+$/", // only numbers, with optional "+" in front
            $parameters[$parameterName]
        );
    }

    /**
     * telephone
     * validates if property value is a valid telephone number
     * @param  mixed $parameters whose property we must check
     * @param  String $parameterName name of property whose value we must check
     * @return bool true if validates
     */
    public static function numeric($entity,$parameters, String $parameterName): bool
    {
        return preg_match(
            "/^[0-9]+$/", // only numbers, with optional "+" in front
            $parameters[$parameterName]
        );
    }

    public static function uciqueNumber($entity,$parameters, String $parameterName): bool
    {
        return preg_match(
            "/^[0-5]{1}+$/", // only numbers, with optional "+" in front
            $parameters[$parameterName]
        );
    }


    public static function strong($entity,$parameters, String $parameterName)
    {
        $n = 0;

        if (static::haveNumber($entity,$parameters,$parameterName)) {
            $n += 10;
        }
        if (static::haveLower($entity,$parameters,$parameterName)) {
            $n += 26;
        }
        if (static::haveUpper($entity,$parameters,$parameterName)) {
            $n += 26;
        }
        if (static::haveSpecialChar($entity,$parameters,$parameterName)) {
            $n += 8;
        }
      
        $result = round(strlen($parameters[$parameterName])) * (log($n) / log(2));

        return $result >= 80;
    }

    public static function haveNumber($entity,$parameters, String $parameterName)
    {
        
        $result = false;
        if (preg_match('@[0-9]@', $parameters[$parameterName])) {
            $result = true;
        }
 

        return $result;
    }

    public static function haveLower($entity,$parameters, String $parameterName)
    {
      
        $regexLower = "/[a-z]/";

        $result = false;
        if (preg_match($regexLower, $parameters[$parameterName])) {
            $result = true;
        }

        return $result;
       
    }

    public static function haveUpper($entity,$parameters, String $parameterName)
    {
       
        $regexUpper = "/[A-Z]+/";

        $result = false;
        if (preg_match($regexUpper, $parameters[$parameterName])) {
            $result = true;
        }

        return $result;
    }

    public static function haveSpecialChar($entity,$parameters, String $parameterName)
    {
        $result = false;
        if (preg_match('/[!@#$%^&*-]/', $parameters[$parameterName])) {
            $result = true;
        }
    
        return $result;
    }
    /**
     * url
     * validates if property value is a valid url 
     * @param  mixed $parameters whose property we must check
     * @param  String $parameterName name of property whose value we must check
     * @return bool true if validates
     */
    public static function url($entity,$parameters, String $parameterName): bool
    {
        return filter_var(
            $parameters[$parameterName],
            FILTER_VALIDATE_URL // Need to use strict identical operator with FILTER_VALIDATE_URL
        ) === true;
    }

    /**
     * url
     * validates if property value is made up of letters, spaces, and hyphens
     * @param  mixed $parameters whose property we must check
     * @param  String $parameterName name of property whose value we must check
     * @return bool true if validates
     */
    public static function letters($entity,$parameters, String $parameterName): bool
    {
        return preg_match(
            "/^[a-zA-ZÀ-ÿ\- ]*$/", // only letters, spaces, and hyphens (including accents)
            $parameters[$parameterName]
        );
    }



    /**
     * unique
     * validates if no other parameters in datasource (excluding currently-checked parameters) has the same property value
     * @param  mixed $parameters whose property we must check
     * @param  String $parameterName name of property whose value we must check
     * @return bool true if validates
     */
    public static function unique($entity,$parameters, String $parameterName): bool
    {
        $value = $parameters[$parameterName];
        $entityInDb = $entity->getDaoClass()::findOneBy($parameterName, $value);

        // first, we must check if property value was not changed from the one in database
        if (
            $entityInDb != null // If parameters exists with same value in the same property
            &&  $entityInDb->getId() == $entity->getId()
        ) { // Unique constraint is only satisfied if parameters we're checking is the same as the one in database
            $valid = true;
        } else {
            $valid = $entityInDb == null;
        }

        return $valid;
    }

    /**
     * _get
     * convenience method: gets a property value from an object
     * @param  mixed $parameters parameters whose property we need the value of
     * @param  String $parameterName name of property whose value we need
     * @return mixed property value
     */
    private static function _get($parameters, String $parameterName)
    {
        return $parameters->{"get" . ucfirst($parameterName)}();
    }
}
