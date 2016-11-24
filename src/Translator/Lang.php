<?php 

namespace Vinala\Kernel\Translator;

use Vinala\Kernel\Translator\Exception\LanguageKeyNotFoundException;
use Vinala\Kernel\Config\Config;
use Vinala\Kernel\Storage\Cookie;
use Vinala\Kernel\HyperText\Res;
use Vinala\Kernel\Objects\Base;
use Vinala\Kernel\Filesystem\Filesystem;
use Vinala\Kernel\Foundation\Application;

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
		d(self::$textes);
	}

	public static function get($key)
	{
		$value = "";
		//
		if(array_has(self::$textes , $key)) 
			{
				$value = array_get(self::$textes , $key);
			}
		else throw new  LanguageKeyNotFoundException($key);
		//
		return $value;
	}

	public static function set($lang)
	{
		Cookie::create(self::getName(),$lang,(60*24*7*30));
		Res::stsession("Lighty_lang",$lang);
	}

	private static function put()
	{
		foreach (glob(Application::$root."resources/translator/".self::$lang."/*.php") as $filename)
		// foreach (glob(Application::$root."app/lang/".self::$lang."/*.php") as $filename)
		{
			$tbl=(\Connector::need($filename));
			foreach ($tbl as $key => $value) {
				self::$textes[$key]=$value;
			}
		}
	}

	public static function detect()
	{

		if(isset($_SESSION["Lighty_lang"]) && !empty($_SESSION["Lighty_lang"]))
		{
			if (in_array($_SESSION["Lighty_lang"], self::$supportedLangs)) 
			{

			    if(Base::full(self::getCookie())) 
			    {
			    	if(self::getCookie() != $_SESSION["Lighty_lang"])
			    	{
			    		Cookie::create(self::getName(),$_SESSION["Lighty_lang"],(60*24*7));
			    	}
			    }
			    else  
			    {
			    	Cookie::create(self::getName(),$_SESSION["Lighty_lang"],(60*24*7));
			    }
			}
			else 
			{			
				Res::stsession("Lighty_lang",Config::get('lang.default'));
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
				Res::stsession("Lighty_lang",self::getCookie());
			}
			else
			{
				Cookie::create(self::getName(),Config::get('lang.default'),(60*24*7));
				Res::stsession("Lighty_lang",Config::get('lang.default'));
			}
		}
		else 
		{
			Res::stsession("Lighty_lang",Config::get('lang.default'));
		}
		//
		return Res::session("Lighty_lang");
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
		$sup=(new Filesystem)->directories(Application::$root."resources/translator");
		//
		foreach ($sup as $value) {
			$r=explode(Application::$root."resources/translator/", $value);
			$supp[]=$r[1];
		}
		//
		return $supp;
	}

	public static function setDefault()
	{
		Cookie::create(self::getName(),Config::get('lang.default'),(60*24*7));
		Res::stsession("Lighty_lang",Config::get('lang.default'));
	}
	
}
