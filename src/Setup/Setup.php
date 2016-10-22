<?php 

namespace Lighty\Kernel\Setup;

use Lighty\Kernel\Foundation\Application;
use Lighty\Kernel\Foundation\Connector;

class Setup
{
	public static function launch()
	{
		Connector::need(Application::$root."vendor/vinala/kernel/src/Setup/Assets/Views/main.php");
	}
}