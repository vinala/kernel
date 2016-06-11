<?php

namespace Lighty\Kernel\MVC\View;

use Smarty;
use Lighty\Kernel\Foundation\Application;



/**
* Smarty Template class
*/
class Template
{
	public static $smarty;

	public static function run()
	{
		self::$smarty=new Smarty;
		//
		self::setParams();
		self::setCache();
	}

	public static function show($view,$data=null)
	{
		self::assign($data);
		return self::display($view);
	}

	protected static function setCache()
	{
		self::$smarty->setTemplateDir(Application::$root.'app/storage/framework/view/compile');
		self::$smarty->setCompileDir(Application::$root.'app/storage/framework/view/template/smarty');
	}

	protected static function setParams()
	{
		self::$smarty->force_compile = false;
		//self::$smarty->debugging = true;
		//self::$smarty->caching = true;
		//self::$smarty->cache_lifetime = 120;
		//Smarty::muteExpectedErrors();
	}

	protected static function display($view)
	{
		return self::$smarty->display($view);
	}

	protected static function assign($data)
	{
		if(!is_null($data)) 
			foreach ($data as $key => $value) self::$smarty->assign($key, $value);
	}
}
