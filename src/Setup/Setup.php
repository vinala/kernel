<?php 

namespace Vinala\Kernel\Setup;

use Vinala\Kernel\Foundation\Application;
use Vinala\Kernel\Foundation\Connector;

class Setup
{
	public static function launch()
	{
		Connector::need(Application::$root."vendor/vinala/kernel/src/Setup/Assets/Views/main.php");
	}
}