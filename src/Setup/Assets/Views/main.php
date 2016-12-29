<!DOCTYPE html>
<html>
	<head>
	<?php 
		use Vinala\Kernel\Resources\Libs;
		use Vinala\Kernel\HyperText\Html;
		use Vinala\Kernel\Access\Path;
		use Vinala\Kernel\Config\Config;
		use Vinala\Kernel\Translator\Lang;
		use Vinala\Kernel\Foundation\Application;
		use Vinala\Kernel\Foundation\Connector;
		//
		Libs::css("app/resources/library/bootstrap-3.3.1.min.css",false);
		Libs::css("app/resources/library/bootstrap-theme-3.3.1.min.css",false);
		Libs::js("app/resources/library/jquery-1.11.3.min.js",false);
		//
		Html::charset("utf-8"); 
		Html::title();
		Html::favicon(Path::$public."/favicon.ico");
		Libs::css("vendor/vinala/kernel/src/Setup/Assets/css/hello.css",false);
		Libs::js("vendor/vinala/kernel/src/Setup/Assets/js/hello.js",false);
	?>
	</head>
	<body>
		<?php Connector::need(Application::$root."vendor/vinala/kernel/src/Setup/Assets/Views/setup.php"); ?>
	</body>
</html>