<?php
// local, display errors
error_reporting(E_ALL ^ E_DEPRECATED);
ini_set('display_errors', '1');

// define environment
define('APP_ENVIRONMENT', 'development');

// set include path
define('APP_ROOT', dirname(dirname(__FILE__)));
set_include_path(implode(PATH_SEPARATOR, array(
    '/www/shared/ZF/1.5.3/library/',
    APP_ROOT . '/application/models',
    get_include_path(),
)));

// setup autoloader loader
require_once "Zend/Loader.php";
Zend_Loader::registerAutoload();

// init front controller
$front = Zend_Controller_Front::getInstance();
$front->setControllerDirectory(APP_ROOT . '/application/controllers');

// setup frontcontroller bootstrap plugin
require_once APP_ROOT . '/application/controllers/plugins/Bootstrap.php';
$bootstrapPlugin = new My_Controller_Front_Plugin_Bootstrap();
$front->registerPlugin($bootstrapPlugin);

// dispatch
$front->dispatch();
