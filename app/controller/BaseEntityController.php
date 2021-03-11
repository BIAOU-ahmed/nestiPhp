<?php

//require_once PATH_ENTITY . 'Recipe.php';
//require_once PATH_TOOLS . 'FormatUtil.php';
//require_once PATH_MODEL . 'dao/RecipeDao.php';
//require_once PATH_MODEL . 'entity/BaseEntity.php';

//SiteUtil::require('model/entity/Recipe.php');
//SiteUtil::require('model/entity/BaseEntity.php');
//SiteUtil::require('model/dao/RecipeDao.php');
//SiteUtil::require('model/entity/BaseEntity.php');



class BaseEntityController extends BaseController
{

    protected static $entity;
    protected static $entityClass;
    protected static $dao;


    public static function callActionMethod($action)
    {
        if ($action  == "") {
            $action = 'list';
        }
        parent::callActionMethod($action);
    }

    public static function processAction($forceAction = null)
    {

        $controller = SiteUtil::getUrlParameters()[0] ?? "";
        $id = SiteUtil::getUrlParameters()[2] ?? "";
        $action = SiteUtil::getUrlParameters()[1] ?? "";



        if ($forceAction != null) {
            $action = $forceAction;
        }

        get_called_class()::initializeEntity($id);

        self::$dao = self::getEntityClass()::getDaoClass();

        get_called_class()::callActionMethod($action);
    }

    public static function setupTemplateVars(&$vars, &$templates)
    {
        // $parameter = SiteUtil::getUrlParameters()[2] ?? "";
        // if ($parameter == "deleted") {
        //     static::addVars(["message" => "deleted"]);
        // }

        parent::setupTemplateVars($vars, $templates);
        if (strpos($templates['action'], '/') === false) {

            $templates['action'] = strtolower(self::getEntityClass()) . "/" . $templates['action'];
        }



        // Add shared parameters to the existing ones
        $vars = array_merge($vars, [
            'entity' =>  self::getEntity(),
            'templatePath' => SiteUtil::toAbsolute("app/view/") . $templates['action'] . ".php",
        ]);
    }


    /**
     * initializeEntity
     * Sets user class parameter to a user from data source if specified in url, otherwise a new user
     * @return void
     */
    protected static function initializeEntity($id)
    {

        if (!empty($id)) { // If a user ID is specified in the URL

            self::setEntity(self::getDao()::findById($id)); // find corresponding user in data source
        }

        if (!self::getEntity()) { // If no ID specified, or wrong ID specified

            $class =  self::getEntityClass();

            self::setEntity(new $class);
        }
    }

    public static function getEntityClass()
    {

        return get_called_class()::$entityClass;
    }



    public static function addImage()
    {
        if (isset($_FILES)) {
            $filetype = array('jpeg', 'jpg', 'png', 'gif', 'PNG', 'JPEG', 'JPG');
            // FormatUtil::dump($_POST['idRecipe']);
            if (isset($_POST['idRecipe']) || isset($_POST['idArticle'])) {
                $id = isset($_POST['idRecipe']) ? $_POST['idRecipe'] : $_POST['idArticle'];
                $directoryName = isset($_POST['idRecipe']) ? 'recipes' : 'articles';
            }

            foreach ($_FILES as $key) {

                $name = time() . $key['name'];
                $path = "../public/images/$directoryName/" . $name;
                $file_ext =  pathinfo($name, PATHINFO_EXTENSION);


                if (in_array(strtolower($file_ext), $filetype)) {

                    if ($key['size'] < 1000000) {
                        if (move_uploaded_file($key['tmp_name'], $path)) {

                            $d = new DateTime('NOW');
                            $t = explode('.', $name);
                            $image = new Image();
                            $image->setName($t[0]);
                            $image->setDateCreation($d->format('Y-m-d H:i:s'));
                            $image->setFileExtension($t[1]);
                            // FormatUtil::dump($image);
                            ImageDao::saveOrUpdate($image);
                            // echo static::getDao();
                            $entity = static::getDao()::findById($id);
                            // FormatUtil::dump($entity);
                            $entity->setIdImage($image->getId());
                            static::getDao()::saveOrUpdate($entity);
                            // FormatUtil::dump($image);
                            echo SiteUtil::url() . "public/images/$directoryName/" . $name;
                        }
                    } else {
                        echo "FILE_SIZE_ERROR";
                    }
                } else {
                    echo "FILE_TYPE_ERROR";
                }
            }
        }
        // FormatUtil::dump($_POST['entity']);

        if (isset($_POST['entity']['recipe']) || isset($_POST['entity']['article'])) {
            $id = isset($_POST['entity']['recipe']) ? $_POST['entity']['recipe'] : $_POST['entity']['article'];
            $name = isset($_POST['entity']['recipe']) ? 'recipes' : 'articles';
            $entity = static::getDao()::findById($id);
            $entity->setIdImage(null);
            static::getDao()::saveOrUpdate($entity);
            echo SiteUtil::url() . "public/images/$name/gateauauxfraises.jpg";
        }
    }

    /**
     * edit
     * edit an existing recipe, or a newly-created one
     * @return void
     */
    public static function edit()
    {

        $templateName = 'edit';
        $templateVars = ["isSubmitted" => !empty($_POST[self::getEntityClass()])];

        if ($templateVars["isSubmitted"]) { // if we arrived here by way of the submit button in the edit view
            $entity = self::getEntity();
            EntityUtil::setFromArray($entity, $_POST[self::getEntityClass()]);
            // FormatUtil::dump(self::getEntity());

            if (self::getEntity()->isValid()) {
                // self::getDao()::saveOrUpdate(self::getEntity());
                $templateName = null; // null template will redirect to default action
            } else {
                $templateVars["errors"] = self::getEntity()->getErrors();
                FormatUtil::dump($templateVars["errors"]);
            }
        }

        // template remains "edit" if no POST user parameters, or if user parameters in POST are invalid
        self::render($templateName, $templateVars);
    }

    /**
     * delete
     * shows a delete confirmation form, which if submitted deletes user
     * @return void
     */
    public static function delete()
    {

        FormatUtil::dump($_POST);
        if (!empty($_POST)) {
            $controller = SiteUtil::getUrlParameters()[0] ?? "";
            $id = SiteUtil::getUrlParameters()[2] ?? "";
            $action = SiteUtil::getUrlParameters()[1] ?? "";
            $templateName = 'delete';
            $templateVars = ['message' => 'deleted'];
            FormatUtil::dump($controller);
            FormatUtil::dump($id);
            FormatUtil::dump(self::getEntity());
            self::getDao()::delete(self::getEntity());
            $_SESSION['message'] = "deleted";
            header('Location: ' . SiteUtil::url() . $controller . '/list');
            // self::render(null, $templateVars);

            // header('Location: ' . SiteUtil::url() . $controller.'/list?message=deleted');
            // header('Location: ' . SiteUtil::url() . $controller . '/list/deleted');

            exit();
            // self::render(['action' => 'list', 'base' => 'common/base'],$templateVars);
        }
        // static::render($templateName, $templateVars);
        // $templateName = 'delete';

        // if (!empty($_POST)) { // if we arrived here by way of the submit button in the delete view
        //     self::getDao()::delete(self::getEntity());
        //     $templateName = null;
        // }

        // self::render($templateName);
    }

    public static function list()
    {
        self::render("list", [
            'entities' => self::getDao()::findAll()
        ]);
    }

    /**
     * Get the value of entity
     */
    public static function getEntity()
    {
        return get_called_class()::$entity;
    }

    /**
     * Get the value of entity
     */
    public static function setEntity($entity)
    {

        get_called_class()::$entity = $entity;
    }

    public static function getDao()
    {
        return get_called_class()::$dao;
    }
}
