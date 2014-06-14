<?php

    // $page['path'] comes from whatever file includes/requires this file
    $path_config = "{$page['path']}_config/";
    
    // this helps to resolve buffering differences between local and live environments
    ob_start();    
    
    // This block of code is used to undo magic quotes.  Magic quotes are a terrible
    // feature that was removed from PHP as of PHP 5.4.  However, older installations
    // of PHP may still have magic quotes enabled and this code is necessary to
    // prevent them from causing problems.  For more information on magic quotes:
    // http://php.net/manual/en/security.magicquotes.php
    if(function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc())
    {
        function undo_magic_quotes_gpc(&$array)
        {
            foreach($array as &$value)
            {
                if(is_array($value))
                {
                    undo_magic_quotes_gpc($value);
                }
                else
                {
                    $value = stripslashes($value);
                }
            }
        }
        undo_magic_quotes_gpc($_POST);
        undo_magic_quotes_gpc($_GET);
        undo_magic_quotes_gpc($_COOKIE);
    }

    // This tells the web browser that your content is encoded using UTF-8
    // and that it should submit content back to you using UTF-8
    header('Content-Type: text/html; charset=utf-8');

    // This initializes a session.
    // Sessions are used to store information about a visitor from one web page visit to the next.
    // Unlike a cookie, the information is stored on the server-side and cannot be modified by the visitor.
    // However, note that in most cases sessions do still use cookies and require the visitor to have cookies enabled.
    // For more information about sessions:
    // http://us.php.net/manual/en/book.session.php
    session_start();
    
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