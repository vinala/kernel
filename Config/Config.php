<?php

namespace Fiesta\Core\Config;

use Fiesta\Core\Glob\App;
use Fiesta\Core\Config\Exceptions\ConfigException;

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
		return include (is_null(App::$root) ? "../app/config/$param.php" :  App::$root."../app/config/$param.php");
	}

	/**
	 * get primary parameter
	 */
	protected static function getFirstLevel()
	{
		return 
			array('error','database','panel','app','license','maintenance','lang','security','auth','mail','view','loggin','storage','cache','alias','smiley',
				);
	}

	/**
	 * load all params from file to virtual array
	 */
	public static function load()
	{
		$levels = self::getFirstLevel();
		//
		foreach ($levels as $level) { self::$params[$level] = self::getPath($level); }
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
	protected static function check($param)
	{
		$p = self::separate($param);
		//
		if( $p['first'] == 'database') self::checkDatabase($p['second']);
		//
		else
		{
			if( ! in_array( $p['first'], self::getFirstLevel())) self::exception( $p['first'] , $p['second'] );
			else if ( ! array_key_exists( $p['second'] , self::$params[ $p['first'] ]) ) self::exception( $p['first'] , $p['second'] );
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
	protected static function reach($param)
	{
		$p = self::separate($param);
		self::check($param);
		//
		if( $p['first'] == 'database') return self::callDatabase( $p['second'] );
		return self::$params[ $p['first'] ][ $p['second'] ];

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
		return ( ! in_array( $key , $params )) ? $data['connections'][$driver][$key] : $data[$key] ;
	}

	/**
	 * get value of config parameter
	 * @param $value(string) primary and secondary parameter concatenated
	 */
	public static function get($value)
	{
		return self::reach($value);
	}

}
