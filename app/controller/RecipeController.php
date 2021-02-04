<?php

// SiteUtil::require('model/entity/Recipe.php');
SiteUtil::require('model/entity/Users.php');
SiteUtil::require('util/FormatUtil.php');




class UserController
{

    protected $user;


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

        // action is first slug in url, id second
        //   @[$action, $id] = SiteUtil::getUrlParameters();

        // $this->initializeUser($id);
        

            method_exists($this, $action) ?
            $this->$action() : // if action in URL exists, call it
            $this->default(); // else call default one
        
        
    }

    public function setUser($user)
    {
        $_SESSION['userLogin'] = $user->getLogin();
        $this->user = $user;
    }

    /**
     * initializeEntity
     * Sets user class parameter to a user from data source if specified in url, otherwise a new user
     * @return void
     */
    private function initializeUser($id)
    {
        if (!empty($id)) { // If a user ID is specified in the URL
            $this->user = UsersDao::findById($id); // find corresponding user in data source
        }

        if (!$this->user) { // If no ID specified, or wrong ID specified
            $this->user = new Users;
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
        $templateVars = ["isSubmitted" => !empty($_POST['recipe'])];

        if ($templateVars["isSubmitted"]) { // if we arrived here by way of the submit button in the edit view
            $this->user->setParametersFromArray($_POST['recipe']);
            if ($this->user->isValid()) {
                UsersDao::saveOrUpdate($this->user);
                $templateName = null; // null template will redirect to default action
            } else {
                $templateVars["errors"] = $this->user->getErrors();
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
            UsersDao::delete($this->user);
            $templateName = null;
        }

        $this->render($templateName);
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
            $this->default();
        } else {
            // Add shared parameters to the existing ones
            $vars = array_merge($vars, [
                'baseUrl' => SiteUtil::url() . 'public', // absolute url of public folder
                'user' => $this->user,         // current user
                'controller' => $this,         // current user
                'templatePath' => SiteUtil::toAbsolute("app/view/user/$templateName.php")
            ]);
            //pour que ca fonctionne pour toutes les aciton, on passe le nom du template
            include __DIR__ . '/../view/common/base.php';
            //    echo $this->twig->render("$templateName.twig", $vars); // render twig template
        }
    }


    /**
     * read
     * view user parameters
     * @return void
     */
    private function read()
    {
        $this->render('read');
    }

    protected function login()
    {
        
        $template = 'login';
        if (isset($_POST['user'])) {
            
            $candidate = UsersDao::findOneBy('login', $_POST['user']['username']);
           
            if($candidate != null && $candidate->isPassword($_POST['user']['password']) ){
                $this->setUser($candidate);
                $template = null;
            }
        }
        $this->render($template);
    }

    /**
     * default
     * default action (called if no action specified, wrong action specified, or null template specified)
     * @return void
     */
    private function default()
    {
        $this->render("listUsers", [
            'users' => UsersDao::findAll()
        ]);
    }



    /**
     * Get the value of user
     */
    public function getUser()
    {
        if(isset($_SESSION['userLogin'])){
            $this->user = UsersDao::findOneBy('login',$_SESSION['userLogin']);
        }
        return $this->user;
    }
}
