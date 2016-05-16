<?php


// die(var_dump(glob(__DIR__.'/../../../*')));
// require __DIR__."/../../../autoload.php";

// require "vendor/autoload.php";
// require __DIR__."/../../autoload.php";
// require_once __DIR__.'/../vendor/fiesta/kernel/src/Testing/TestCase.php';
die(var_dump(glob(__DIR__."/../vendor/autoload.php")));


// Fiesta\Kernel\Foundation\Application::run("../",true,true,"Connector.php");
Pikia\Kernel\Foundation\Application::test();