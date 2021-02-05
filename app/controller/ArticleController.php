<?php

// SiteUtil::require('model/entity/Recipe.php');
SiteUtil::require('model/entity/Users.php');
SiteUtil::require('util/FormatUtil.php');
SiteUtil::require('controller/BaseController.php');




class ArticleController extends BaseEntityController
{

    protected static $entityClass = "Article";
    protected static $dao = "ArticleDao";
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



}
