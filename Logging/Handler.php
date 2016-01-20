<?php 

namespace Fiesta\Core\Logging;

use Fiesta\Core\Config\Config;
use Fiesta\Core\Glob\App;
use Whoops\Run;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Handler\PlainTextHandler;

/**
* Error Handler class
*/
class Handler
{
	/**
	 * the class whoops
	 */
	protected static $whoops;

	/**
	 * the page of hundler
	 */
	protected static $page;



	public static function run()
	{
		
		if(Config::get('loggin.debug')) self::PrettyPage();
		else self::SimplePage();
	}

	protected static function PrettyPage()
	{
		self::$whoops = new Run;
		self::$page = new PrettyPageHandler();
		//
		self::setPrettyParams();
		self::exec();
	}

	protected static function SimplePage()
	{
		self::$whoops = new Run;
		self::$page = new PlainTextHandler();
		//
		self::setSimpleParams();
		self::exec();
	}

	protected static function setPrettyParams()
	{
		self::$page->setPageTitle(Config::get('loggin.msg'));
		self::$page->setEditor("sublime"); 
	}

	protected static function setSimpleParams()
	{
		self::$page->msg=Config::get('loggin.msg');
		self::$page->bg_color=Config::get('loggin.bg');
		self::$page->handle();
	}

	protected static function exec()
	{
		self::$whoops->pushHandler(self::$page);
		self::$whoops->register();
	}
	
}
