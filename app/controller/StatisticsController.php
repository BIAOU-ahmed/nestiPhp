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

    public static function dashboard()
    {

        $allUsers = UsersDao::findAll();
        usort($allUsers, function ($v1, $v2) {
            return count($v2->getConnectionLogs()) <=> count($v1->getConnectionLogs());
        });
        $allUsers = array_slice($allUsers, 0, 10);
        $mostConectedUsers = [];
        foreach($allUsers as $user){
            $mostConectedUsers[] =["id"=>$user->getId(),"name"=>$user->getFirstName().' '.$user->getLastName()];
        }
        FormatUtil::dump($allUsers);
        $startDate = new DateTime;
        $startDate->add(DateInterval::createFromDateString("-10 days"));

        $connexionByHour = [];
        $soldTotalByDay = [];
        $purchasedTotalByDay = [];

        for ($i = 9; $i >= 0; $i--) {
            $date = new DateTime;
            $date->add(DateInterval::createFromDateString("-{$i}days"));
            $day = intval($date->format('d'));
            // FormatUtil::dump($date);
            echo "il y a $i jopur";
            // FormatUtil::dump($day);
            $value = [$startDate->format('Y-m-d H:i:s'), $day];
            $orders = OrdersDao::findAllAffterDate("dateCreation", $value, 'a');
            // FormatUtil::dump($orders);
            // //        $purchaseTotal = 0;
            $soldTotal = 0;
            $purchasedTotal = 0;
            foreach ($orders as $order) {
                $soldTotal += $order->getPrice();
                $purchasedTotal += $order->getPurchases();
            }
            $purchasedTotalByDay[] = $purchasedTotal;
            $soldTotalByDay[] = $soldTotal;
        }


        $articleSales = [];
        static::render("statistics/dashboard", [

            "jsVars" => [
                "connexionByHour" => $connexionByHour,
                "soldTotalByDay" => $soldTotalByDay,
                "purchasedTotalByDay" => $purchasedTotalByDay,
                "mostConectedUsers" => $allUsers,
                "articleSales" => $articleSales
            ]
        ]);
    }
}
