<?php
    
    // Database connection params
    define('HOST', 'localhost');
    define('USERNAME', 'root');
    define('PASSWORD', '');
    define('DATABASE', 'clockit');
    define('DSN', 'mysql:host=localhost;dbname=clockit');

    
    //define('BASE_PATH', dirname(realpath(__FILE__)) . '/');
    //define('APP_PATH', BASE_PATH . 'app/');
    
    // The server root
    define('SERVER_ROOT', $_SERVER['DOCUMENT_ROOT']);


    // The app folder
    define('APP_FOLDER', 'app');

    define('CONTROLLER_POSTFIX', 'controller');


    // Directory separator
    define('DS', '/');

    // Application Directory - need to change this to your app folder.
    define('APP_ROOT', 'clockit');

    // address of website.
    define('WEBSITE', 'http://localhost:90/');

    // MVC paths
    // IF YOU RUN THIS ON LINUX YOU MAY NEED TO ADD .DS after the SERVER_ROOT.
    // example : define('MODEL_PATH', SERVER_ROOT.DS.APP_ROOT.DS.'models'.DS);
    define('MODEL_PATH', SERVER_ROOT.APP_ROOT.DS.APP_FOLDER.DS.'models'.DS);
    define('VIEW_PATH', SERVER_ROOT.APP_ROOT.DS.APP_FOLDER.DS.'views'.DS);
    define('CONTROLLER_PATH', SERVER_ROOT.APP_ROOT.DS.APP_FOLDER.DS.'controllers'.DS);
    define('CONFIG_PATH', SERVER_ROOT.APP_ROOT.DS.'config'.DS);
    define('DEBUG_ROUTE', true);
?>
