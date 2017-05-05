<!DOCTYPE html>
<html>
	<head>
	<?php 
        use Vinala\Kernel\Access\Path;
        use Vinala\Kernel\HyperText\Html;
        use Vinala\Kernel\Resources\Assets;

        //
        Assets::css('bootstrap');
        Assets::css('bootstrap-theme');
        Assets::js('jquery');
        //
        Html::charset('utf-8');
        Html::title();
        Html::favicon(Path::$public.'/favicon.ico');
        Assets::css('vendor/vinala/kernel/src/Setup/Assets/css/welcome.css', false);
        Assets::js('vendor/vinala/kernel/src/Setup/Assets/js/hello.js', false);
    ?>
	</head>
	
	<?php need(root().'vendor/vinala/kernel/src/Setup/Assets/Views/setup.php'); ?>
</html>