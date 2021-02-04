<?php

// SiteUtil::require('model/entity/Recipe.php');
SiteUtil::require('model/entity/Users.php');
SiteUtil::require('util/FormatUtil.php');




class UserController extends BaseController{

    protected static $entityClass = "Users";


    /**
     * __construct
     * constructor sanitizes request, initializes a user, and calls an action 
     * @return void
     */
    public function __construct()
    {

        parent::__construct();
        

        // $this->initializeUser($id);
        // if ($this->getUser() == null) {
        //     $this->login();
        // }else{

        //     method_exists($this, $action) ?
        //     $this->$action() : // if action in URL exists, call it
        //     $this->default(); // else call default one
        // }

    }

    protected function processAction($action)
    {
        
        if (isset($_SESSION['userLogin'])) {
            $this->entity = UsersDao::findOneBy('login', $_SESSION['userLogin']);
           
        }else{
            $action = "login";
        }
        parent::processAction($action);
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
     * render
     * renders a template
     * @param  mixed $templateName template name , or null to redirect to default action
     * @return void
     */
    // private function render($templateName, $vars = [])
    // {
    //     if ($templateName == null) {
    //         //si le templet eest nul(ex si on delete un article => aon applele le tmplate par dafault (ici la liste))
    //         $this->default();
    //     } else {

    //         // Add shared parameters to the existing ones
    //         $vars = array_merge($vars, [
    //             'baseUrl' => SiteUtil::url() . 'public', // absolute url of public folder
    //             'user' => $this->user,         // current user
    //             'controller' => $this,         // current user
    //             'templatePath' => SiteUtil::toAbsolute("app/view/user/$templateName.php")
    //         ]);
    //         //pour que ca fonctionne pour toutes les aciton, on passe le nom du template
    //         include __DIR__ . '/../view/common/base.php';
    //         //    echo $this->twig->render("$templateName.twig", $vars); // render twig template
    //     }
    // }


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

            if ($candidate != null && $candidate->isPassword($_POST['user']['password'])) {
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
    // private function default()
    // {
    //     $this->render("listUsers", [
    //         'users' => UsersDao::findAll()
    //     ]);
    // }



    /**
     * Get the value of user
     */
    public function getUser()
    {
        if (isset($_SESSION['userLogin'])) {
            $this->user = UsersDao::findOneBy('login', $_SESSION['userLogin']);
        }
        return $this->user;
    }
}
