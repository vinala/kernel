<?php 

namespace Fiesta\Kernel\Http;

use Fiesta\Kernel\Foundation\Application;
/**
* 
*/
class Root
{
	public static $css=Application::$root."app/resources/css/";
	public static $js=Application::$root."app/resources/js/";
	public static $resource=Application::$root."app/resources/";
	public static $images=Application::$root."app/resources/images/";
	public static $scripts=Application::$root."app/scripts/";
}