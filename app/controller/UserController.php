<?php

// SiteUtil::require('model/entity/Recipe.php');
SiteUtil::require('model/entity/Users.php');
SiteUtil::require('util/FormatUtil.php');
SiteUtil::require('controller/BaseController.php');




class UserController extends BaseEntityController
{

    protected static $entityClass = "Users";
    protected static $dao = "UsersDao";
    protected static $loggedInUser;
    // public static function getEntityClass()
    // {

    //     return "Users";
    // }

    // public static function callActionMethod($action)
    // {
    //     self::$entity = self::getUser();
    //     if (self::$entity == null) {
    //         $action = "login";
    //     }
    //     parent::callActionMethod($action);
    // }




    public static function login()
    {

        $template = 'login';
        if (isset($_POST['Users'])) {

            $candidate = UsersDao::findOneBy('login', $_POST['Users']['username']);

            if ($candidate != null && $candidate->isPassword($_POST['Users']['password'])) {

                self::setLoggedInUser($candidate, $_POST['Users']['password']);
                header('Location: ' . SiteUtil::url() . 'loc=recipe&action=list');
            }
        }
        self::render(['action'=>'login','base'=>'users/baseLogin']);;
    }


    public static function logout()
    {
        self::setLoggedInUser(null);
        
        header('Location: ' . SiteUtil::url() . 'loc=user&action=login');
    }


    /**
     * Get the value of user
     */
    public static function getLoggedInUser()
    {
        if (self::$loggedInUser == null &&  isset($_COOKIE['user'])) {
            $candidate = UsersDao::findOneBy('login', $_COOKIE['user']['login']);
            if ($candidate->isPassword($_COOKIE['user']['password'])) {
                self::$loggedInUser = $candidate;
            };
        }
        return self::$loggedInUser;
    }

    public static function setLoggedInUser($user, $plaintextPassword = null)
    {
        if ($user != null) {
            self::$loggedInUser = $user;
            setcookie("user[login]", $user->getLogin(), 2147483647, '/');
            setcookie("user[password]", $plaintextPassword, 2147483647, '/');
        }
    }
}
