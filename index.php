<?php

/*
 * define constants
 */
define('ROOT_DIR', dirname(__FILE__));
define('ROOT_URL', (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/');
define('APP_DIR', dirname(__FILE__).'/app');
define('CLASS_DIR', APP_DIR.'/class');

if(file_exists(APP_DIR.'/local-config.php')){
    include_once ROOT_DIR.'/local-config.php';
} else {
    include_once ROOT_DIR . '/config.php';
}


/*
 *  includes
 */
require APP_DIR.'/helpers.php';
require APP_DIR.'/Router.php';



/*
 * Register autoload
 */
spl_autoload_register(function($className){
    $classFile = CLASS_DIR.'/'.$className.'.php';
    $handlersFile = APP_DIR.'/handlers/'.$className.'.php';
    if(file_exists($classFile)){
        include $classFile;
        return true;
    }
    if(file_exists($handlersFile)){
        include $handlersFile;
        return true;
    }
    return false;
});

/*
 * Add routes
 */
Router::addRoute('/', array('MainHandler', 'init') );

Router::start();

exit;




