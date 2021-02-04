<?php
class MainController{

    public function __construct(){
        $loader = new \Twig\Loader\FilesystemLoader(SiteUtil::toAbsolute('templates/user'));
        $this->twig = new \Twig\Environment($loader);
        
        FormatUtil::sanitize($_POST); // need recursive sanitizing for multidimensional array

        // action is first slug in url, id second
        @[$action, $id] = SiteUtil::getUrlParameters();

        $this->initializeUser($id);
        
        method_exists($this, $action)?
            $this->$action(): // if action in URL exists, call it
            $this->default(); // else call default one
    }
    
}