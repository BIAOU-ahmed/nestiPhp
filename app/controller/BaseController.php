<?php

//require_once PATH_ENTITY . 'Recipe.php';
//require_once PATH_TOOLS . 'FormatUtil.php';
//require_once PATH_MODEL . 'dao/RecipeDao.php';
//require_once PATH_MODEL . 'entity/BaseEntity.php';

//SiteUtil::require('model/entity/Recipe.php');
//SiteUtil::require('model/entity/BaseEntity.php');
//SiteUtil::require('model/dao/RecipeDao.php');
//SiteUtil::require('model/entity/BaseEntity.php');



class BaseController
{

    protected static $entity;
    protected static $entityClass;
    protected static $dao;


    public static function callActionMethod($action)
    {
        method_exists(get_called_class(), $action) ?
            get_called_class()::$action() : // if action in URL exists, call it
            get_called_class()::error(); // else call default one
    }

    public static function processAction($forceAction = null)
    {
     
         @[$location, $action, $id] =SiteUtil::getUrlParameters();


        if ($forceAction != null) {
            $action = $forceAction;
        }

        get_called_class()::callActionMethod($action);
    }


    /**
     * render
     * renders a template
     * @param  mixed $templateName template name , or null to redirect to default action
     * @return void
     */
    protected static function render($templates, $vars = [])
    {
        if ($templates == null) {
            //si le templet eest nul(ex si on delete un article => aon applele le tmplate par dafault (ici la liste))
            self::error();
        } else {
            if (!is_array($templates)) {
                 $templates =['action'=>$templates,'base'=>'common/base'];
            }
     
         get_called_class()::setupTemplateVars($vars,$templates);
        
            //repars a la racine du porjet
            include_once SiteUtil::toAbsolute('app/view/'.$templates['base'].'.php');
        }
    }

    public static function setupTemplateVars(&$vars,&$templates){
        @[$location, $action, $id] =SiteUtil::getUrlParameters();
            // Add shared parameters to the existing ones
            $vars = array_merge($vars, [
                'baseUrl' => SiteUtil::url(), // absolute url of public folder
                'controller' => self::class,         // current user
                'templatePath' => SiteUtil::toAbsolute("app/view/".$templates['action'].'.php'),
                'loggedInUser' => UserController::getLoggedInUser(),
                'stylesheet' => $templates['action'],
                'urlParameters' => ['action'=>$action,'location'=>$location,'id'=>$id]
            ]);

    }


    //ca va chercher dans le dossier error et abvec un / si c'est autre part que dan sle dossier de l'entité en cours
    public static function error()
    {
        self::render('error/error404');
    }
}