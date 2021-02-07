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
    protected static $entity;
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

            $candidate = UsersDao::findOneBy('login', $_POST['Users']['username'], BaseDao::FLAGS['active']);

            if ($candidate != null && $candidate->isPassword($_POST['Users']['password'])) {

                self::setLoggedInUser($candidate, $_POST['Users']['password']);
                $today = date("Y-m-d H:i:s");
                $newConnection = new ConnectionLog();
                $newConnection->setIdUsers(self::getLoggedInUser()->getId());
                $newConnection->setDateConnection($today);
                ConnectionLogDao::saveOrUpdate($newConnection);
                header('Location: ' . SiteUtil::url() . 'recipe/list');
            }
        }
        self::render(['action' => 'login', 'base' => 'users/baseLogin']);;
    }


    public static function logout()
    {
        self::setLoggedInUser(null);
        $templateVars = ['message' => 'disconnect'];
        // header('Location: ' . SiteUtil::url() . 'user/login');
        self::render(['action' => 'login', 'base' => 'users/baseLogin'], $templateVars);;
    }


    /**
     * Get the value of user
     */
    public static function getLoggedInUser()
    {
        if (self::$loggedInUser == null &&  isset($_COOKIE['user'])) {
            $candidate = UsersDao::findOneBy('login', $_COOKIE['user']['login'], "a");
            if ($candidate != null && $candidate->isPassword($_COOKIE['user']['password'])) {
                self::$loggedInUser = $candidate;
            };
        }
        return self::$loggedInUser;
    }

    public static function edit()
    {
        $templateName = 'edit';
        $templateVars = ["isSubmitted" => !empty($_POST[static::getEntityClass()])];
        $templateVars['orderLines'] = [];

        $orders = self::getEntity()->getOrders();
        foreach($orders as $order){
            $templateVars['orderLines'][$order->getId()] = $order->getOrderLines();
            foreach($order->getOrderLines() as $element){
                FormatUtil::dump((array) $element);
            }
        }
        if ($templateVars["isSubmitted"]) { // if we arrived here by way of the submit button in the edit view
            $user = static::getEntity();
            EntityUtil::setFromArray($user, $_POST[static::getEntityClass()]);
            FormatUtil::dump(static::getEntity());

            if (static::getEntity()->isValid()) {
                
                // self::getDao()::saveOrUpdate(self::getEntity());
                $templateName = null; // null template will redirect to default action
            } else {
                $templateVars["errors"] = static::getEntity()->getErrors();
                FormatUtil::dump($templateVars["errors"]);
            }
        }

        // template remains "edit" if no POST user parameters, or if user parameters in POST are invalid
        static::render($templateName, $templateVars);
    }
    public static function setLoggedInUser($user, $plaintextPassword = null)
    {

        self::$loggedInUser = $user;
        if ($user == null) {
            $login = null;
        } else {
            $login = $user->getLogin();
        }
        setcookie("user[login]",  $login, 2147483647, '/');
        setcookie("user[password]", $plaintextPassword, 2147483647, '/');
    }
}
