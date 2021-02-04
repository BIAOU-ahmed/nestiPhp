<?php

// SiteUtil::require('model/entity/Recipe.php');
SiteUtil::require('model/entity/Users.php');
SiteUtil::require('util/FormatUtil.php');
SiteUtil::require("controller/UserController.php");



class BaseController
{

    protected $entity;
    protected static $entityClass;
    protected static $dao ;

    /**
     * __construct
     * constructor sanitizes request, initializes a user, and calls an action 
     * @return void
     */
    public function __construct()
    {
        // FormatUtil::dump($_SERVER['SERVER_NAME']);
        FormatUtil::sanitize($_POST); // need recursive sanitizing for multidimensional array
        FormatUtil::sanitize($_GET);
        $id = $_GET['id'] ?? null;
        $action = $_GET['action'] ?? null;
        $location = $_GET['loc'] ?? null;

        // action is first slug in url, id second
        //   @[$action, $id] = SiteUtil::getUrlParameters();
        $this->initializeEntity($id);
        if ($location == "user") {

            new UserController(); // Constructor will determine action 
        }
        $dao = self::$entityClass::getDaoClass();
        $this->processAction($action);
    }

    
    protected function processAction($action)
    {

        method_exists($this, $action) ?
            $this->$action() : // if action in URL exists, call it
            $this->error(); // else call default one
    }


    /**
     * render
     * renders a template
     * @param  mixed $templateName template name , or null to redirect to default action
     * @return void
     */
    private function render($templateName, $vars = [])
    {
        if ($templateName == null) {
            //si le templet eest nul(ex si on delete un article => aon applele le tmplate par dafault (ici la liste))
            $this->error();
        } else {
            if (strpos($templateName, '/') === false) {

                $templateName = strtolower($this->entity->getClass()) . "/$templateName";
            }
            // Add shared parameters to the existing ones
            $vars = array_merge($vars, [
                'baseUrl' => SiteUtil::url() . 'public', // absolute url of public folder
                'entity' => $this->entity,         // current user
                'controller' => $this,         // current user
                'templatePath' => SiteUtil::toAbsolute("app/view/$templateName.php")
            ]);
            //pour que ca fonctionne pour toutes les aciton, on passe le nom du template
            include __DIR__ . '/../view/common/base.php';
            //    echo $this->twig->render("$templateName.twig", $vars); // render twig template
        }
    }

    /**
     * initializeEntity
     * Sets user class parameter to a user from data source if specified in url, otherwise a new user
     * @return void
     */
    private function initializeEntity($id)
    {

        if (!empty($id)) { // If a user ID is specified in the URL

            $this->entity = self::$dao::findById($id); // find corresponding user in data source
        }

        if (!$this->entity) { // If no ID specified, or wrong ID specified
            $this->entity = new self::$entityClass;
        }
    }


    /**
     * edit
     * edit an existing recipe, or a newly-created one
     * @return void
     */
    private function edit()
    {
        $templateName = 'edit';
        $templateVars = ["isSubmitted" => !empty($_POST[self::$entityClass])];

        if ($templateVars["isSubmitted"]) { // if we arrived here by way of the submit button in the edit view
            $this->entity->setParametersFromArray($_POST[self::$entityClass]);
            if ($this->entity->isValid()) {
                self::$dao::saveOrUpdate($this->entity);
                $templateName = null; // null template will redirect to default action
            } else {
                $templateVars["errors"] = $this->entity->getErrors();
            }
        }

        // template remains "edit" if no POST user parameters, or if user parameters in POST are invalid
        $this->render($templateName, $templateVars);
    }

    /**
     * delete
     * shows a delete confirmation form, which if submitted deletes user
     * @return void
     */
    private function delete()
    {
        $templateName = 'delete';

        if (!empty($_POST)) { // if we arrived here by way of the submit button in the delete view
            self::$dao::delete($this->entity);
            $templateName = null;
        }

        $this->render($templateName);
    }

    private function list()
    {
        $this->render("list", [
            'entities' => self::$dao::findAll()
        ]);
    }
    public function error()
    {
        $this->render('error/error_404');
    }

    /**
     * Get the value of entity
     */ 
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * Set the value of entity
     *
     * @return  self
     */ 
    public function setEntity($entity)
    {
        $this->entity = $entity;

        return $this;
    }
}
