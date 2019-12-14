<?php

use App\Kernel;

spl_autoload_register(function ($class) {
    require_once  str_replace(['App\\', '\\'], ['src/', '/'], $class) . '.php';
});

error_reporting(E_ALL);
header("X-XSS-Protection: 1; mode=block");
define("ROOT", $_SERVER['DOCUMENT_ROOT']);
ob_start();

$kernel = new Kernel();

Kernel::$router->run();