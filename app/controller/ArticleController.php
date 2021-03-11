<?php

// SiteUtil::require('model/entity/Recipe.php');
SiteUtil::require('model/entity/Users.php');
SiteUtil::require('util/FormatUtil.php');
SiteUtil::require('controller/BaseController.php');




class ArticleController extends BaseEntityController
{

    protected static $entityClass = "Article";
    protected static $dao = "ArticleDao";
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
    public static function orders()
    {
        self::render("orders", [
            'entities' => OrdersDao::findAll()
        ]);
    }

    public static function edit()
    {


        $templateName = 'edit';
        $templateVars = ["isSubmitted" => !empty($_POST[self::getEntityClass()])];

        if ($templateVars["isSubmitted"]) { // if we arrived here by way of the submit button in the edit view
            FormatUtil::dump($_POST[static::getEntityClass()]);

            $article = ArticleDao::findById($_POST[static::getEntityClass()]['idArticle']);
            FormatUtil::dump($article);
            $article->setName($_POST[static::getEntityClass()]['name']);
            FormatUtil::dump($article);


            self::getDao()::saveOrUpdate($article);
            // header('Location: ' . SiteUtil::url() . 'recipe/list/'.$recipe->getId());
            // exit;

        }

        // template remains "edit" if no POST user parameters, or if user parameters in POST are invalid
        self::render($templateName, $templateVars);
    }
}
