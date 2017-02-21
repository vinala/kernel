<?php

namespace Vinala\Kernel\Config;

use Vinala\Kernel\Foundation\Application;
use Vinala\Kernel\Foundation\Connector;
use Vinala\Kernel\Config\Exceptions\ConfigException;
use Vinala\Kernel\Mocking\configMocking;
use Vinala\Kernel\Config\Exceptions\DatabaseDriverNotFoundException;

/**
* Config Class
*/
class Config
{
	/**
	 * All config params
	 */
	protected static $params = array();

	/**
	 * get path of config files
	 * @param $param(string) : file name
	 */
	protected static function getPath($param)
	{
		$path = (is_null(Application::$root) ? "config/$param.php" :  Application::$root."config/$param.php");
		//
		return Connector::need((is_null(Application::$root) ? "config/$param.php" :  Application::$root."config/$param.php"));
	}

	/**
	 * get primary parameter
	 */
	protected static function getFirstLevel()
	{
		return 
			array('error','database','app','license','maintenance','lang','security','auth','mail','view','loggin','storage','cache','alias','smiley','lumos','components'
				);
	}

	/**
	 * load all params from file to virtual array
	 */
	public static function mock()
	{
		self::$params = configMocking::mock();
		//
		return true;
	}

	/**
	 * load all params from file to virtual array
	 */
	public static function load($kernelTest = false)
	{
		if($kernelTest) return self::mock();
		else
		{
			$levels = self::getFirstLevel();
			//
			foreach ($levels as $level) { self::$params[$level] = self::getPath($level); }
			//
			return true;
		}
	}

	/**
	 * throw ConfigException
	 * @param $first(string) primary parameter
	 * @param $second(string) secondary parameter
	 */
	protected static function exception($first,$second)
	{
		throw new ConfigException($second,$first);
	}

	/**
	 * check if parameter exists
	 * @param $param(string) primary and secondary parameter concatenated
	 */
	public static function check($param , $default = false)
	{
		$p = self::separate($param);
		//
		if( $p['first'] == 'database') self::checkDatabase($p['second']);
		//
		else
		{
			if( ! in_array( $p['first'], self::getFirstLevel()))
			{
				if( ! $default )
				{
					self::exception( $p['first'] , $p['second'] );
				}
				return true;
			}
			elseif ( ! array_key_exists( $p['second'] , self::$params[ $p['first'] ]) ) 
			{
				if( ! $default )
				{	
					self::exception( $p['first'] , $p['second'] );
				}
				return true;
			}
		}
		//
		return true;
	}

	/**
	 * separate request parameter to two primary and secondary parameter
	 * @param $key(string) primary and secondary parameter concatenated
	 */
	protected static function separate($key)
	{
		$params=explode('.', $key);
		//
		return array('first' => $params[0] ,'second' => $params[1] );
	}

	/**
	 * find request parameter
	 * @param $param(string) primary and secondary parameter concatenated
	 */
	protected static function reach($param , $default = null)
	{
		$p = self::separate($param);
		//
		if( $p['first'] == 'database') return self::callDatabase( $p['second'] );
		return array_get(self::$params , $param , $default);

	}

	/**
	 * check if secondary parameter exists if primary parameter is 'database'
	 * @param $key(string) primary and secondary parameter concatenated
	 */
	protected static function checkDatabase($key)
	{
		$driver = self::$params['database']['default'];
		//
		if( array_key_exists( $key , self::$params['database'])) return true;
		else if( array_key_exists( $key , self::$params['database']['connections'][$driver])) return true;
		else self::exception( 'database' , $key );
	}

	/**
	 * find request parameter if primary parameter is 'database'
	 * @param $key(string) secondary parameter concatenated
	 */
	protected static function callDatabase($key)
	{
		$params = array("migration" ,"prefixing" ,"prefixe" ,"default" );
		$data = self::$params['database'];
		$driver = $data['default'];
		//
		exception_if(! array_has( $data['connections'] , $driver ) , DatabaseDriverNotFoundException::class ,  $driver );
		//
		return ( ! in_array( $key , $params )) ? $data['connections'][$driver][$key] : $data[$key] ;
	}

	/**
	 * get value of config parameter
	 *
	 * @param $value(string) primary and secondary parameter concatenated
	 */
	public static function get($key , $value = null)
	{
		if(self::check($key , ! is_null($value)))
		{
			return self::reach($key , $value);
		}

		return $value;
	}

	/**
	* Get all config params
	*
	* @return array
	*/
	public static function all()
	{
		return self::$params;
	}
	

}
