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
        $controller = SiteUtil::getUrlParameters()[0] ?? "";
        $id = SiteUtil::getUrlParameters()[2] ?? "";
        $action = SiteUtil::getUrlParameters()[1] ?? "";
      


        // UserController::setEntity(UserController::getUser());
        if (UserController::getLoggedInUser() == null) {
            return  UserController::processAction('login');
        }

        switch ($controller) {
            case 'user':
                UserController::processAction();
                break;
            case 'recipe':
                RecipeController::processAction();
                break;
            case 'article':
                ArticleController::processAction();
                break;
            case "":
                RecipeController::processAction();
                break;
            default:
                BaseController::error();
        }
    }
}
