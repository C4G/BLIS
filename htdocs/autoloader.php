<?php

    /*** nullify any existing autoloads ***/
    spl_autoload_register(null, false);

    /*** specify extensions that may be loaded ***/
    spl_autoload_extensions('.php');

    /*** class Loader ***/
    function classLoader($class)
    {
        // $filename = strtolower($class) . '.php';
        $filename = $class . '.php';
        $file = $_SERVER['DOCUMENT_ROOT'].'/classes/' . $filename;
        if (!is_readable($file))
        {
            return false;
        }
        include $file;
    }

    function pluginLoader($class)
    {
        $filename = $class . '.php';
        $file =$_SERVER['DOCUMENT_ROOT'].'../local/plugins/' . $filename;
        if (!is_readable($file))
        {
            return false;
        }
        include $file;
    }

    /*** register the loader functions ***/
    spl_autoload_register('classLoader');
    spl_autoload_register('pluginLoader');

