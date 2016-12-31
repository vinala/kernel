<?php 

namespace Vinala\Kernel\Translator;

use Vinala\Kernel\Storage\Cookie;
use Vinala\Kernel\Storage\Session;
use Vinala\Kernel\Filesystem\File;

use Vinala\Kernel\Translator\Exception\LanguageKeyNotFoundException;
use Vinala\Kernel\Translator\Exception\LanguageNotSupportedException;

/**
* Translator class
*
* @version v1.1
* @author Youssef Had
* @package 
* @since v1.0
*/
class Lang
{
	
	//--------------------------------------------------------
	// Properties
	//--------------------------------------------------------

	
	/**
	* Words used in current language
	*
	* @var array 
	*/
	protected static $words = [] ;


	/**
	* Selected language
	*
	* @var string 
	*/
	public static $lang = null ;


	/**
	* Supported languages
	*
	* @var array 
	*/
	protected static $supported = [] ;


	/**
	* Hashed name of lang cookie
	*
	* @var string 
	*/
	protected static $cookieName = null ;


	/**
	* Lang session name
	*
	* @var string 
	*/
	protected static $sessionName = 'Vinala_lang' ;
	

	//--------------------------------------------------------
	// Constructor
	//--------------------------------------------------------

	function __construct()
	{
		//
	}

	//--------------------------------------------------------
	// Functions
	//--------------------------------------------------------

	/**
	* Initiate the Lang class
	*
	* @param string $lang
	* @return null
	*/
	public static function ini($lang = null)
	{
		self::getSupported();
		
		self::$lang = is_null($lang) ? self::detect() : $lang ;

		exception_if( ! in_array(self::$lang, self::$supported) , LanguageNotSupportedException::class , self::$lang);
		
		self::load();
	}

	/**
	* Get supported langs used by the app
	*
	* @return array
	*/
	protected static function getSupported()
	{
		$folders = File::directories(root().'resources/translator');

		foreach ($folders as $folder) 
		{
			$lang = explode(root() . 'resources/translator/', $folder);

			self::$supported[] = $lang[1];
		}
	}

	/**
	* Detect the used language
	*
	* @return string
	*/
	public static function detect()
	{
		$key = self::$sessionName;

		$cookieName = self::cookieName($key);

		// check if the session lang exists
		if(Session::existe($key))
		{
		
			//check if supported languages contains the session lang value 
			if( ! in_array(Session::get($key) , self::$supported))
			{
				Session::put($key , config('lang.default' , 'en'));
			}

			if(Cookie::existe($cookieName))
			{
				if(Cookie::get($cookieName) != Session::get($key))
				{
					Cookie::create($cookieName , Session::get($key) , (60*24*7));
				}
			}
			else
			{
				Cookie::create($cookieName , Session::get($key) , (60*24*7));
			}
		}

		// check if the cookie lang exists
		elseif(Cookie::existe($cookieName))
		{
			//check if supported languages contains the cookie lang value 
			if( in_array(Cookie::get($key) , self::$supported))
			{
				Session::put($key , Cookie::get($key) );
			}
			else
			{
				Session::put($key , config('lang.default' , 'en'));
				Cookie::create($cookieName , config('lang.default' , 'en') , (60*24*7));
			}
		}

		// if cokkie and session not found
		else
		{
			Session::put($key , config('lang.default' , 'en'));
			Cookie::create($cookieName , config('lang.default' , 'en') , (60*24*7));
		}

		return Session::get($key);
	}

	/**
	* Set the cookie name
	*
	* @param string $name
	* @return string
	*/
	protected static function cookieName($name)
	{
		return self::$cookieName = self::hash($name);
	}


	/**
	* Hash the name of the lang cookie
	*
	* @param string $value
	* @return string
	*/
	protected static function hash($value)
	{
		return md5(md5($value)."lang".config('security.key1').md5(config('security.key2')));
	}


	/**
	* Get all words in supported language
	*
	* @return null
	*/
	protected static function load()
	{
		$files = glob(root().'resources/translator/'.self::$lang.'/*.php');

		foreach ($files as $file) 
		{
			$words = need($file);

			foreach ($words as $key => $value) 
			{
				self::$words[$key] = $value ;
			}
		}
	}

	/**
	* Change tha languauge used
	*
	* @param string $lang
	* @return true
	*/
	public static function set($lang)
	{
		exception_if( ! in_array($lang, self::$supported) , LanguageNotSupportedException::class , $lang);

		Cookie::create(self::$cookieName,$lang,(60*24*7*30));
		Session::put(self::$sessionName , $lang);
		return true;
	}


	/**
	* Get the translate word by a key
	*
	* @param string $key
	* @return string
	*/
	public static function get($key)
	{
		exception_if( ! array_has(self::$words , $key) , LanguageKeyNotFoundException::class , $key);
		
		return array_get(self::$words , $key);	
	}


	/**
	* Set the default language
	*
	* @return true
	*/
	public static function setDefault()
	{
		return self::set(config('lang.default'));
	}
	
}