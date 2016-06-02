<!DOCTYPE html>
<html>
	<head>
	<?php 
		use Lighty\Kernel\Resources\Libs;
		use Lighty\Kernel\HyperText\Html;
		use Lighty\Kernel\Access\Path;
		use Lighty\Kernel\Config\Config;
		use Lighty\Kernel\Translator\Lang;
		use Lighty\Kernel\Foundation\Application;
		//
		Libs::css("app/resources/library/bootstrap-3.3.1.min.css",false);
		Libs::css("app/resources/library/bootstrap-theme-3.3.1.min.css",false);
		Libs::js("app/resources/library/jquery-1.11.3.min.js",false);
		//
		// Libs::css(Application::$root."vendor/lighty/kernel/src/Setup/Assets/bootstrap-3.3.1.min.css",false);
		// Libs::css(Application::$root."vendor/lighty/kernel/src/Setup/Assets/bootstrap-theme-3.3.1.min.css",false);
		// Libs::js(Application::$root."vendor/lighty/kernel/src/Setup/Assets/jquery-1.11.3.min.js",false);
		//
		Html::charset("utf-8"); 
		Html::title();
		Html::favicon(Path::$public."/favicon.ico");
		Libs::css("vendor/lighty/kernel/src/Setup/Assets/css/hello.css",false);
		Libs::js("vendor/lighty/kernel/src/Setup/Assets/js/hello.js",false);
	?>
	</head>
	<body>
		<?php Connector::need(Application::$root."vendor/lighty/kernel/src/Setup/Assets/Views/setup.php"); ?>
	</body>
</html>