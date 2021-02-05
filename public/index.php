<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname( __FILE__ ) . '/../app/util/SiteUtil.php';
// require_once dirname( __FILE__ ) . '/../vendor/autoload.php';
// SiteUtil::require('model/dao/BaseDao.php');

// SiteUtil::require('model/entity/BaseEntity.php');

// SiteUtil::require("controller/MainController.php");
SiteUtil::autoloadRegister();
// SiteUtil::require("controller/UserController.php");
// new MainController(); // Constructor will determine action 
MainController::processRoute();