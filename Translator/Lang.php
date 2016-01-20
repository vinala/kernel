<?php 

namespace Fiesta\Core\Translator;

use Fiesta\Core\Translator\Exception\LanguageKeyNotFoundException;
use Fiesta\Core\Config\Config;
use Fiesta\Core\Storage\Cookie;
use Fiesta\Core\HyperText\Res;
use Fiesta\Core\Objects\Base;
use Fiesta\Core\Filesystem\Filesystem;

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
		Res::stsession("Fiesta_lang",$lang);
	}

	private static function put()
	{
		foreach (glob("../app/lang/".self::$lang."/*.php") as $filename)
		{
			$tbl=(include $filename);
			foreach ($tbl as $key => $value) {
				self::$textes[$key]=$value;
			}
		}
	}

	public static function detect()
	{

		if(isset($_SESSION["Fiesta_lang"]) && !empty($_SESSION["Fiesta_lang"]))
		{
			if (in_array($_SESSION["Fiesta_lang"], self::$supportedLangs)) 
			{

			    if(Base::full(self::getCookie())) 
			    {
			    	if(self::getCookie() != $_SESSION["Fiesta_lang"])
			    	{
			    		Cookie::create(self::getName(),$_SESSION["Fiesta_lang"],(60*24*7));
			    	}
			    }
			    else  
			    {
			    	Cookie::create(self::getName(),$_SESSION["Fiesta_lang"],(60*24*7));
			    }
			}
			else 
			{			
				Res::stsession("Fiesta_lang",Config::get('lang.default'));
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
				Res::stsession("Fiesta_lang",self::getCookie());
			}
			else
			{
				Cookie::create(self::getName(),Config::get('lang.default'),(60*24*7));
				Res::stsession("Fiesta_lang",Config::get('lang.default'));
			}
		}
		else 
		{
			Res::stsession("Fiesta_lang",Config::get('lang.default'));
		}
		//
		return Res::session("Fiesta_lang");
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
		$sup=(new Filesystem)->directories("../app/lang");
		//
		foreach ($sup as $value) {
			$r=explode("../app/lang/", $value);
			$supp[]=$r[1];
		}
		//
		return $supp;
	}

	public static function setDefault()
	{
		Cookie::create(self::getName(),Config::get('lang.default'),(60*24*7));
		Res::stsession("Fiesta_lang",Config::get('lang.default'));
	}
	
}
