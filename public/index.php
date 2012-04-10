<?php

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
if (!defined('APPLICATION_ENV')){
	switch ($_SERVER["HTTP_HOST"]){
		case "staging.nickandcampbell.com": define('APPLICATION_ENV','staging'); break;
		case "owen.local": define('APPLICATION_ENV','click3x'); break;
		default : define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));
	}
}else echo "app_env: ".APPLICATION_ENV;
echo "app_env: ".APPLICATION_ENV;
// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap()
            ->run();