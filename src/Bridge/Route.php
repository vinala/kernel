<?php 

use Lighty\Kernel\Foundation\Application;


Lighty\Kernel\Router\Route::get('bridge', function(){	
	include Application::$root.'vendor/lighty/kernel/src/Bridge/View.php';
});