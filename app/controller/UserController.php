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

    public static function callActionMethod($action)
    {
        if ($action != 'login' && $action != 'logout') {
            //only moderator or administrator is allow
            if (!UserController::getLoggedInUser()->isModerator() && !UserController::getLoggedInUser()->isAdministrator()) {
                $action = "accessDenied";
            }
        }

        parent::callActionMethod($action);
    }




    // login a user if the user exist and have the rigth password
    public static function login()
    {
        $templateVars = [];
        $template = 'login';
        if (isset($_POST['Users'])) {

            $candidate = UsersDao::findOneBy('login', $_POST['Users']['username'], BaseDao::FLAGS['active']);

            if ($candidate != null && $candidate->isPassword($_POST['Users']['password'])) {

                self::setLoggedInUser($candidate, $_POST['Users']['password']);
                $today = date("Y-m-d H:i:s");
                // create new connection log 
                $newConnection = new ConnectionLog();
                $newConnection->setIdUsers(self::getLoggedInUser()->getId());
                $newConnection->setDateConnection($today);
                ConnectionLogDao::saveOrUpdate($newConnection);
                header('Location: ' . SiteUtil::url() . 'recipe/list');
            } else {
                $templateVars['message'] = 'errorLogin';
            }
        }
        self::render(['action' => 'login', 'base' => 'users/baseLogin'], $templateVars);
    }

    // get  all order lines of a order 
    public static function orderLines()
    {
        if (isset($_POST['order'])) {
            $orderId = (int) trim($_POST['order']);
            $order = OrdersDao::findById($orderId);
            $orderLines = $order->getOrderLines();

            $array = [];
            $index = 0;
            foreach ($orderLines as $lines) {
                $array[$index]['unitQuantity'] = $lines->getArticle()->getUnitQuantity();
                $array[$index]['unitName'] = $lines->getArticle()->getUnit()->getName();
                $array[$index]['productName'] = $lines->getArticle()->getProduct()->getName();
                $array[$index]['quantity'] = $lines->getQuantity();
                $index++;
            }
            echo json_encode($array);
        }
    }

    // blocke a comment  
    public static function blockedComment()
    {

        $id = SiteUtil::getUrlParameters()[2] ?? "";
        $values = [$id, $_POST['id']];
        $comment = CommentDao::findComment($values);

        // change the flag to blocked 
        $comment->setIdModerator($_POST['idModerator']);
        $comment->setFlag('b');

        $controller = SiteUtil::getUrlParameters()[0] ?? "";

        CommentDao::updateComment($comment);

        header('Location: ' . SiteUtil::url() . $controller . '/edit/' . $id);
    }
    // to approuved the comment 
    public static function approuvedComment()
    {

        $id = SiteUtil::getUrlParameters()[2] ?? "";
        $values = [$id, $_POST['id']];
        $comment = CommentDao::findComment($values);
        // change the flag to active
        $comment->setIdModerator($_POST['idModerator']);
        $comment->setFlag('a');

        $controller = SiteUtil::getUrlParameters()[0] ?? "";

        CommentDao::updateComment($comment);

        header('Location: ' . SiteUtil::url() . $controller . '/edit/' . $id);
    }

    // disconnect the user  
    public static function logout()
    {
        self::setLoggedInUser(null);
        $templateVars = ['message' => 'disconnect'];

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
        foreach ($orders as $order) {
            $templateVars['orderLines'][$order->getId()] = $order->getOrderLines();
        }
        if ($templateVars["isSubmitted"]) { // if we arrived here by way of the submit button in the edit view
            $user = static::getEntity();

            $formBuilder = new UsersFormBuilder($user, $_POST[static::getEntityClass()]);

            $city = CityDao::findOneBy("name", $_POST['Users']['city']);
            if ($formBuilder->isValid()) { // if is valid
                if (!$city) { // if city dont exist is created
                    $city = new City();
                    $city->setName($_POST['Users']['city']);
                    $cityId = CityDao::save($city);
                    $city->setId($cityId);
                }

                $validatedProperties = $formBuilder->getParameters();
                // remove the city to change it by the id
                if (isset($validatedProperties['city'])) {

                    unset($validatedProperties['city']);
                }

                // remove the password entered by the user and change it by the hash password 
                if (isset($validatedProperties['password'])) {
                    $plainTextPassword = $validatedProperties['password'];

                    unset($validatedProperties['password']);
                    $user->setPasswordHashFromPlaintext($plainTextPassword);
                }

                // set all user data with the proporties which is validated
                EntityUtil::setFromArray($user, $validatedProperties);
                $user->setIdCity($city->getId());



                self::getDao()::saveOrUpdate($user);
                // according to the roles choosed we create the child of the user
                if (isset($_POST['roles']['admin'])) {
                    $user->makeAdministrator();
                }
                if (isset($_POST['roles']['chef'])) {
                    $user->makeChef();
                }
                if (isset($_POST['roles']['moderator'])) {
                    $user->makeModerator();
                }
                if ($user->getId()) {
                    $templateVars["succes"] = "L'utilisateur a été modifier avec succès";
                } else {
                    $templateVars["succes"] = "L'utilisateur a été ajouter avec succès";
                    header('Location: ' . SiteUtil::url() . 'user/list/');
                    exit;
                }

                // null template will redirect to default action
            } else {


                $templateVars["errors"] = $formBuilder->getErrors();

                $templateVars["properties"] = $_POST[static::getEntityClass()];
            }
        }

        // template remains "edit" if no POST user parameters, or if user parameters in POST are invalid
        static::render($templateName, $templateVars);
    }
    public static function setLoggedInUser($user, $plaintextPassword = null)
    {
        // to set the logged user in the cookie 
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
