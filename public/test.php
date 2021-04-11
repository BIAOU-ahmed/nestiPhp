<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname( __FILE__ ) . '/../app/util/SiteUtil.php';
// require_once dirname( __FILE__ ) . '/../vendor/autoload.php';
// SiteUtil::require('model/dao/BaseDao.php');

// SiteUtil::require('model/entity/BaseEntity.php');

// SiteUtil::require("controller/MainController.php");

// SiteUtil::require("controller/UserController.php");
// new MainController(); // Constructor will determine action 
// $user = UsersDao::findOneBy("login","alice");
$user = new Users();
$d = new DateTime('NOW');
$user->setLogin('Alice');
$user->setFirstName('Alice');
$user->setLastName('Morgan');
$user->setEmail('alice@example.com');
$user->setFlag('a');
$user->setDateCreation($d->format('Y-m-d H:i:s'));
$user->setAddress1('14 av');
$user->setZipCode(35070);
$user->setPasswordHashFromPlaintext("azerty14AZERTY!");
UsersDao::saveOrUpdate($user);
// echo $d->format('Y-m-d H:i:s');