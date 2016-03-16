<?php
echo var_dump(glob("*"));

require "vendor/autoload.php";
// require __DIR__."/../../autoload.php";


// Fiesta\Kernel\Foundation\Application::run("../",true,true,"Connector.php");
Fiesta\Kernel\Foundation\Application::test();