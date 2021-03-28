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
            if (!UserController::getLoggedInUser()->isModerator() && !UserController::getLoggedInUser()->isAdministrator()) {
                $action = "accessDenied";
            }
        }

        parent::callActionMethod($action);
    }




    public static function login()
    {
        $templateVars = [];
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
            } else {
                $templateVars['message'] = 'errorLogin';
            }
        }
        self::render(['action' => 'login', 'base' => 'users/baseLogin'], $templateVars);
    }
    public static function orderLines()
    {
        if (isset($_POST['order'])) {
            $orderId = (int) trim($_POST['order']);
            $order = OrdersDao::findById($orderId);
            $orderLines = $order->getOrderLines();
            // FormatUtil::dump($orderLines);
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

    public static function blockedComment()
    {

        echo "toto";
        $id = SiteUtil::getUrlParameters()[2] ?? "";
        $values = [$id, $_POST['id']];
        $comment = CommentDao::findComment($values);
        FormatUtil::dump($_POST['id']);
        FormatUtil::dump($_POST['idModerator']);
        FormatUtil::dump($comment);
        $comment->setIdModerator($_POST['idModerator']);
        $comment->setFlag('b');
        FormatUtil::dump($comment);
        FormatUtil::dump("iduser " . $comment->getIdUsers());
        $controller = SiteUtil::getUrlParameters()[0] ?? "";
        // $id = SiteUtil::getUrlParameters()[2] ?? "";
        CommentDao::updateComment($comment);
        // $_SESSION['message'] = "deleted";
        header('Location: ' . SiteUtil::url() . $controller . '/edit/' . $id);
        // // self::render(null, $templateVars);

        // // header('Location: ' . SiteUtil::url() . $controller.'/list?message=deleted');
        // // header('Location: ' . SiteUtil::url() . $controller . '/list/deleted');

        // exit();
    }
    public static function approuvedComment()
    {

        echo "toto";
        $id = SiteUtil::getUrlParameters()[2] ?? "";
        $values = [$id, $_POST['id']];
        $comment = CommentDao::findComment($values);
        FormatUtil::dump($_POST['id']);
        FormatUtil::dump($_POST['idModerator']);
        FormatUtil::dump($comment);
        $comment->setIdModerator($_POST['idModerator']);
        $comment->setFlag('a');
        FormatUtil::dump($comment);
        FormatUtil::dump("iduser " . $comment->getIdUsers());
        $controller = SiteUtil::getUrlParameters()[0] ?? "";
        // $id = SiteUtil::getUrlParameters()[2] ?? "";
        CommentDao::updateComment($comment);
        // $_SESSION['message'] = "deleted";
        header('Location: ' . SiteUtil::url() . $controller . '/edit/' . $id);
        // // self::render(null, $templateVars);

        // // header('Location: ' . SiteUtil::url() . $controller.'/list?message=deleted');
        // // header('Location: ' . SiteUtil::url() . $controller . '/list/deleted');

        // exit();
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
        foreach ($orders as $order) {
            $templateVars['orderLines'][$order->getId()] = $order->getOrderLines();
            foreach ($order->getOrderLines() as $element) {
                // FormatUtil::dump((array) $element);
            }
        }
        FormatUtil::dump(static::getEntity());
        if ($templateVars["isSubmitted"]) { // if we arrived here by way of the submit button in the edit view
            $user = static::getEntity();
            // EntityUtil::setFromArray($user, $_POST[static::getEntityClass()]);
            FormatUtil::dump(static::getEntity());
            $formBuilder = new UsersFormBuilder($user, $_POST[static::getEntityClass()]);
            // FormatUtil::dump( $_POST['roles']);
            // FormatUtil::dump($formBuilder);
            $city = CityDao::findOneBy("name", $_POST['Users']['city']);
            if ($formBuilder->isValid()) {
                if (!$city) {
                    $city = new City();
                    $city->setName($_POST['Users']['city']);
                    $cityId = CityDao::save($city);
                    $city->setId($cityId);
                }
                // FormatUtil::dump($city);
                $validatedProperties = $formBuilder->getParameters();
                // FormatUtil::dump($validatedProperties);
                if (isset($validatedProperties['city'])) {
                    echo "test";
                    unset($validatedProperties['city']);
                }

                if (isset($validatedProperties['password'])) {
                    $plainTextPassword = $validatedProperties['password'];
                    // FormatUtil::dump($plainTextPassword);
                    unset($validatedProperties['password']);
                    $user->setPasswordHashFromPlaintext($plainTextPassword);
                }

                EntityUtil::setFromArray($user, $validatedProperties);
                $user->setIdCity($city->getId());



                self::getDao()::saveOrUpdate($user);

                if (isset($_POST['roles']['admin'])) {
                    $user->makeAdministrator();
                }
                if (isset($_POST['roles']['chef'])) {
                    $user->makeChef();
                }
                if (isset($_POST['roles']['moderator'])) {
                    $user->makeModerator();
                }
                // null template will redirect to default action
            } else {
                $templateVars["errors"] = $formBuilder->getErrors();
                $properties = $_POST[static::getEntityClass()];
                if (isset($properties['password'])) {
                    unset($properties['password']);
                }

                if (isset($properties['city'])) {
                    echo "test";
                    unset($properties['city']);
                }

                EntityUtil::setFromArray($user, $properties);

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
