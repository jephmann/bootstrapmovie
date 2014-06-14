<?php

    // $page['path'] comes from whatever file includes/requires this file
    $path_config = "{$page['path']}_config/";
    
    // this helps to resolve buffering differences between local and live environments
    ob_start();
    
    date_default_timezone_set('America/Chicago');
    
    // general error stuff
    ini_set('display_errors', true);
    ini_set('display_startup_errors', true);
    error_reporting (E_ALL);
    
    // autoloading class files    
    spl_autoload_register(null, false);     /*** nullify any existing autoloads ***/    
    spl_autoload_extensions('.class.php');  /*** specify extensions that may be loaded ***/    
    function classLoader($class)            /*** class Loader ***/
    {
        $filename   = strtolower($class) . '.class.php';
        $file       = '_classes/' . $filename;
        if (!file_exists($file))
        {
            $file   = '../' . $file;
            if (!file_exists($file))
            {
                return false;
            }
        }
        include $file;
    }    
    spl_autoload_register('classLoader');   /*** register the loader functions ***/