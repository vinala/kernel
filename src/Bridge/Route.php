<?php 

use Lighty\Kernel\Foundation\Application;
use Lighty\Kernel\Bridge\Response;


Lighty\Kernel\Router\Route::get('bridge', function(){	
	include Application::$root.'vendor/lighty/kernel/src/Bridge/View.php';
});

Lighty\Kernel\Router\Route::get('bridge_ajax', function(){	
	// include Application::$root.'vendor/lighty/kernel/src/Bridge/View.php';
	// echo $_POST["input"];
	Lighty\Kernel\Bridge\Response::exec();
});