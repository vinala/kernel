<?php 

namespace Vinala\Kernel\Setup;

use Vinala\Kernel\Foundation\Application;
use Vinala\Kernel\Foundation\Bus;

class Setup
{
	public static function launch()
	{
		Bus::need(Application::$root."vendor/vinala/kernel/src/Setup/Assets/Views/main.php");
	}
}