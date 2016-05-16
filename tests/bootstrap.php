<?php

// Travis CI
require __DIR__."/../vendor/autoload.php";

// Local PHPUnit
// require __DIR__."/../../../autoload.php";



// Fiesta\Kernel\Foundation\Application::run("../",true,true,"Connector.php");
Pikia\Kernel\Foundation\Application::test();