<?php

    // starts a session
    session_start();

    error_reporting(E_ALL);
    require_once('config/includes.php');
    require_once('config/routes.php');
    require_once('dispatcher.php');

    //$dispatcher = new Dispatcher();
    //$dispatcher->dispatch( $_SERVER['REQUEST_URI']);

    Dispatcher::dispatch($_SERVER['REQUEST_URI']);
    
    $strings = new StringFunctions();
    
    function __autoload($class_name) {
        if(file_exists('app/models/'.strtolower($class_name) . '.php')) {
            require_once('app/models/'.strtolower($class_name) . '.php');
        } else {
            throw new Exception("Unable to load $class_name.");
        }
    }
	
?>
