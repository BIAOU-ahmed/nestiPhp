<?php
SiteUtil::require("controller/UserController.php");

SiteUtil::require("controller/RecipeController.php");

session_start();
class MainController
{

    public function __construct()
    {
    }

    public static function processRoute($action = null)
    {

        FormatUtil::sanitize($_POST); // need recursive sanitizing for multidimensional array
        FormatUtil::sanitize($_GET);
        $location = $_GET['loc'] ?? null;


        // UserController::setEntity(UserController::getUser());
        if (UserController::getLoggedInUser() == null) {
            return  UserController::processAction('login');
        }
        
        switch ($location) {
            case 'user':
                UserController::processAction();
                break;
            case 'recipe':
                RecipeController::processAction();
                break;
            case 'article':
                ArticleController::processAction();
                break;
        }
    }
}
