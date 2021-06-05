<?php

class StatisticsController extends BaseController
{


    public static function callActionMethod($action)
    {
        if (!UserController::getLoggedInUser()->isAdministrator()) {
            $action = "accessDenied";
        }
        parent::callActionMethod($action);
    }

    // prepare all data passed to the toast functions 
    public static function dashboard()
    {
        $connectionByHour = [];
        $categories = [];
        $allLogs = ConnectionLogDao::findAll();
        // loop on all date to create a list of formated date 
        foreach ($allLogs as $log) {
            $format = 'Y-m-d H:i:s';
            $logDate = DateTime::createFromFormat($format, $log->getDateConnection());

            $categories[$logDate->format('H')][] = $log;
        }

        // loop on categories to create array of connexion hour number
        foreach ($categories as $key => $logs) {
            $connectionByHour[] = (object)array("name" => $key, "data" => count($logs));
        }


        $allUsers = UsersDao::findAll();
        // sort all user by number of connection
        usort($allUsers, function ($v1, $v2) {
            return count($v2->getConnectionLogs()) <=> count($v1->getConnectionLogs());
        });
        $allUsers = array_slice($allUsers, 0, 10); // get ten firt user in the sorted array


        $allChefs = ChefDao::findAll();
        // sorted chef by number of recipe created 
        usort($allChefs, function ($v1, $v2) {
            return count($v2->getRecipes()) <=> count($v1->getRecipes());
        });
        $allChefs = array_slice($allChefs, 0, 10); // get ten firt chef in the sorted array


        $allRecipes = RecipeDao::findAll();
        // sort recipes by rate 
        usort($allRecipes, function ($v1, $v2) {
            return $v2->getRate() <=> $v1->getRate();
        });
        $allRecipes = array_slice($allRecipes, 0, 10); // get ten first recipes 


        $allOrders = OrdersDao::findAll();
        // sort order by price 
        usort($allOrders, function ($v1, $v2) {
            return $v2->getPrice() <=> $v1->getPrice();
        });
        $allOrders = array_slice($allOrders, 0, 3);


        $mostConectedUsers = [];
        // create an array of all most connected user with their id and full name 
        foreach ($allUsers as $user) {
            $mostConectedUsers[] = ["id" => $user->getId(), "name" => $user->getFirstName() . ' ' . $user->getLastName()];
        }
        $startDate = new DateTime;
        $startDate->add(DateInterval::createFromDateString("-10 days"));


        $soldTotalByDay = [];
        $purchasedTotalByDay = [];

        for ($i = 9; $i >= 0; $i--) {
            $date = new DateTime;
            $date->add(DateInterval::createFromDateString("-{$i}days"));
            $day = intval($date->format('d'));
            $value = [$startDate->format('Y-m-d H:i:s'), $day];
            $orders = OrdersDao::findAllAffterDate("dateCreation", $value, 'a'); // get all orders create in 10 last days 
            $lots = LotDao::findAllAffterDate("dateReception", $value, 'a'); // get all lot make in 10 last days 
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

        // get all articles with a stock equal or under of zero 
        $articleOutOfStock = array_filter(ArticleDao::findAll(), function ($a) {
            return $a->getInventory() <= 0;
        });
        $allArticles = ArticleDao::findAll();
        // sort all artciles by total sall 
        usort($allArticles, function ($v1, $v2) {
            return $v2->getTotalSalls() <=> $v1->getTotalSalls();
        });
        $allArticles = array_slice($allArticles, 0, 10);
        $articleSales = [];
        $articlePurchases = [];

        foreach ($allArticles as $value) {
            $articleSales[] = $value->getTotalSalls();
            $articlePurchases[] = $value->getTotalPurchases();

        }
        static::render("statistics/dashboard", [

            "jsVars" => [
                "connexionByHour" => $connectionByHour,
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
