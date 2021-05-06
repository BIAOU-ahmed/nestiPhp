<?php

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
            if (isset($_POST['idRecipe']) || isset($_POST['idArticle'])) {
                $id = isset($_POST['idRecipe']) ? $_POST['idRecipe'] : $_POST['idArticle'];
                $directoryName = isset($_POST['idRecipe']) ? 'recipes' : 'articles';
            }

            foreach ($_FILES as $key) {

                $nameFirstPart = explode('.', $key['name']);
                $name =  $nameFirstPart[0] . time() . '.' . $nameFirstPart[1];
                $path = "../public/images/$directoryName/" . $name;
                $file_ext =  pathinfo($name, PATHINFO_EXTENSION);
                // chack if the file have the rigth type
                if (in_array(strtolower($file_ext), $filetype)) {
                    // check if the file is not too strenght
                    if ($key['size'] < 1000000) {
                        if (move_uploaded_file($key['tmp_name'], $path)) { // upload the file in the forlder choosed

                            $d = new DateTime('NOW');
                            $t = explode('.', $name);
                            $image = new Image();
                            $image->setName($t[0]);
                            $image->setDateCreation($d->format('Y-m-d H:i:s'));
                            $image->setFileExtension($t[1]);

                            ImageDao::saveOrUpdate($image);

                            $entity = static::getDao()::findById($id);

                            $entity->setIdImage($image->getId());
                            static::getDao()::saveOrUpdate($entity);

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

        // if we have recipe or article we create an entity according to the type of the id and add the image to the entity 
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

            if (self::getEntity()->isValid()) {
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
        $controller = SiteUtil::getUrlParameters()[0] ?? "";
        self::getDao()::delete(self::getEntity());
        $_SESSION['message'] = "deleted";
        header('Location: ' . SiteUtil::url() . $controller . '/list');

        exit();
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
