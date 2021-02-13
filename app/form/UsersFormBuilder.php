<?php
class UsersFormBuilder extends FormBuilder {

    public  $formParameters = [
        "firstName" => ["notEmpty", "letters"],
        "lastName" => ["notEmpty", "letters"],
        "password" => ["notEmpty", "strong","haveNumber","haveLower","haveUpper","haveSpecialChar"],
        "city" => ["notEmpty"],
        "address1" => ["notEmpty"],
        "zipCode" => ["notEmpty","numeric"],
        "login" => ["notEmpty", "unique"],
        "email" => ["email", "unique"]
    ];


}