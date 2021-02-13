<?php
class RecipeFormBuilder extends FormBuilder {

    public  $formParameters = [
        "name" => ["notEmpty"],
        "difficulty" => ["notEmpty","uciqueNumber"],
        "portions" => ["notEmpty", "numeric"],
        "preparationTime" => ["notEmpty","numeric"]
    ];


}