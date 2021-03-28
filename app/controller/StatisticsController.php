<?php

//require_once PATH_ENTITY . 'Recipe.php';
//require_once PATH_TOOLS . 'FormatUtil.php';
//require_once PATH_MODEL . 'dao/RecipeDao.php';
//require_once PATH_MODEL . 'entity/BaseEntity.php';

//SiteUtil::require('model/entity/Recipe.php');
//SiteUtil::require('model/entity/BaseEntity.php');
//SiteUtil::require('model/dao/RecipeDao.php');
//SiteUtil::require('model/entity/BaseEntity.php');



class StatisticsController extends BaseController
{


    public static function callActionMethod($action)
    {
        if (!UserController::getLoggedInUser()->isAdministrator()) {
            $action = "accessDenied";
        }
        parent::callActionMethod($action);
    }

    public static function dashboard()
    {
        $connexionByHour = [];
        $allLogs = ConnectionLogDao::findAll();
        foreach ($allLogs as $book) {
            $format = 'Y-m-d H:i:s';
            $logDate = DateTime::createFromFormat($format, $book->getDateConnection());
            // echo $lotDate;
            $categories[$logDate->format('H')][] = $book;
        }
        foreach ($categories as $key => $logs) {
            $connexionByHour[] = (object) array("name" => $key, "data" => count($logs));
        }
        // FormatUtil::dump($connexionByHour);
        // FormatUtil::dump($categories);


        $allUsers = UsersDao::findAll();
        usort($allUsers, function ($v1, $v2) {
            return count($v2->getConnectionLogs()) <=> count($v1->getConnectionLogs());
        });
        $allUsers = array_slice($allUsers, 0, 10);


        $allChefs = ChefDao::findAll();
        usort($allChefs, function ($v1, $v2) {
            return count($v2->getRecipes()) <=> count($v1->getRecipes());
        });
        $allChefs = array_slice($allChefs, 0, 10);


        $allRecipes = RecipeDao::findAll();
        // FormatUtil::dump($allRecipes[0]->getGrades());
        usort($allRecipes, function ($v1, $v2) {
            return $v2->getRate() <=> $v1->getRate();
        });
        $allRecipes = array_slice($allRecipes, 0, 10);


        $allOrders = OrdersDao::findAll();
        usort($allOrders, function ($v1, $v2) {
            return $v2->getPrice() <=> $v1->getPrice();
        });
        $allOrders = array_slice($allOrders, 0, 3);


        $mostConectedUsers = [];
        foreach ($allUsers as $user) {
            $mostConectedUsers[] = ["id" => $user->getId(), "name" => $user->getFirstName() . ' ' . $user->getLastName()];
        }
        // FormatUtil::dump($allOrders);
        $startDate = new DateTime;
        $startDate->add(DateInterval::createFromDateString("-10 days"));


        $soldTotalByDay = [];
        $purchasedTotalByDay = [];

        for ($i = 9; $i >= 0; $i--) {
            $date = new DateTime;
            $date->add(DateInterval::createFromDateString("-{$i}days"));
            $day = intval($date->format('d'));
            // FormatUtil::dump($date);
            // echo "il y a $i jopur";
            // FormatUtil::dump($day);
            $value = [$startDate->format('Y-m-d H:i:s'), $day];
            $orders = OrdersDao::findAllAffterDate("dateCreation", $value, 'a');
            $lots = LotDao::findAllAffterDate("dateReception", $value, 'a');
            // FormatUtil::dump($orders);
            // //        $purchaseTotal = 0;
            $soldTotal = 0;
            $purchasedTotal = 0;
            foreach ($orders as $order) {
                $soldTotal += $order->getPrice();
            }
            foreach ($lots as $lot) {
                $purchasedTotal += $lot->getSubTotal();
            }
            $purchasedTotalByDay[] = $purchasedTotal;
            $soldTotalByDay[] = $soldTotal;
        }


        $articleOutOfStock = array_filter(ArticleDao::findAll(), function ($a) {
            return $a->getInventory() == 0;
        });
        $allArticles = ArticleDao::findAll();
        usort($allArticles, function ($v1, $v2) {
            return $v2->getTotalSalls() <=> $v1->getTotalSalls();
        });
        $allArticles = array_slice($allArticles, 0, 10);
        FormatUtil::dump($allArticles);
        $articleSales = [];
        $articlePurchases = [];
        foreach ($allArticles as $value) {
            $articleSales[] = $value->getTotalSalls();
            $articlePurchases[] = $value->getTotalPurchases();
        }

        static::render("statistics/dashboard", [

            "jsVars" => [
                "connexionByHour" => $connexionByHour,
                "soldTotalByDay" => $soldTotalByDay,
                "purchasedTotalByDay" => $purchasedTotalByDay,
                "mostConectedUsers" => $allUsers,
                "mostBiggenOrders" => $allOrders,
                "articleOutOfStock" => $articleOutOfStock,
                "topChefs" => $allChefs,
                "topRecipes" => $allRecipes,
                "articlePurchases" => $articlePurchases,
                "articleSales" => $articleSales
            ]
        ]);
    }
}
