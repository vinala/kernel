<?php 

namespace Pikia\Kernel\Translator;

use Pikia\Kernel\Translator\Exception\LanguageKeyNotFoundException;
use Pikia\Kernel\Config\Config;
use Pikia\Kernel\Storage\Cookie;
use Pikia\Kernel\HyperText\Res;
use Pikia\Kernel\Objects\Base;
use Pikia\Kernel\Filesystem\Filesystem;
use Pikia\Kernel\Foundation\Application;

/**
* Language class
*/
class Lang
{
	static $textes;
	public static $lang;
	private static $supportedLangs=array();

	public static function ini($lang=null)
	{
		self::$supportedLangs=self::getSupported();
		//
		self::$lang= is_null($lang) ? self::detect() : $lang ;
		self::put();
	}

	public static function get($key)
	{
		$value = "";
		//
		if(array_key_exists ($key, self::$textes)) $value=self::$textes[$key];
		else throw new  LanguageKeyNotFoundException($key);
		//
		return $value;
	}

	public static function set($lang)
	{
		Cookie::create(self::getName(),$lang,(60*24*7*30));
		Res::stsession("Pikia_lang",$lang);
	}

	private static function put()
	{
		foreach (glob(Application::$root."app/lang/".self::$lang."/*.php") as $filename)
		{
			$tbl=(\Connector::need($filename));
			foreach ($tbl as $key => $value) {
				self::$textes[$key]=$value;
			}
		}
	}

	public static function detect()
	{

		if(isset($_SESSION["Pikia_lang"]) && !empty($_SESSION["Pikia_lang"]))
		{
			if (in_array($_SESSION["Pikia_lang"], self::$supportedLangs)) 
			{

			    if(Base::full(self::getCookie())) 
			    {
			    	if(self::getCookie() != $_SESSION["Pikia_lang"])
			    	{
			    		Cookie::create(self::getName(),$_SESSION["Pikia_lang"],(60*24*7));
			    	}
			    }
			    else  
			    {
			    	Cookie::create(self::getName(),$_SESSION["Pikia_lang"],(60*24*7));
			    }
			}
			else 
			{			
				Res::stsession("Pikia_lang",Config::get('lang.default'));
				if(Base::full(self::getCookie())) 
			    	if(self::getCookie() != Config::get('lang.default'))
			    	{
						Cookie::create(self::getName(),Config::get('lang.default'),(60*24*7));				
			    	}
			}
		}
		else if(Base::full(self::getCookie()))
		{
			if(in_array(self::getCookie(), self::$supportedLangs))
			{
				Res::stsession("Pikia_lang",self::getCookie());
			}
			else
			{
				Cookie::create(self::getName(),Config::get('lang.default'),(60*24*7));
				Res::stsession("Pikia_lang",Config::get('lang.default'));
			}
		}
		else 
		{
			Res::stsession("Pikia_lang",Config::get('lang.default'));
		}
		//
		return Res::session("Pikia_lang");
	}

	private static function hash($value)
	{
		return md5(md5($value)."lang".Config::get('security.key1').md5(Config::get('security.key2')));
	}

	private static function getName()
	{
		return self::hash(Config::get('lang.cookie'));
	}

	private static function getCookie()
	{
		return Cookie::get(self::getName());
	}

	private static function getSupported()
	{
		$supp=array();
		$sup=(new Filesystem)->directories(Application::$root."app/lang");
		//
		foreach ($sup as $value) {
			$r=explode(Application::$root."app/lang/", $value);
			$supp[]=$r[1];
		}
		//
		return $supp;
	}

	public static function setDefault()
	{
		Cookie::create(self::getName(),Config::get('lang.default'),(60*24*7));
		Res::stsession("Pikia_lang",Config::get('lang.default'));
	}
	
}
