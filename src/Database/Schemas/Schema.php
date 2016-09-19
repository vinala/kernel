<?php

namespace Lighty\Kernel\Database;

use Lighty\Kernel\Config\Config;

/**
* Schema builder class
*/
class Schema
{

	//--------------------------------------------------------
	// Variables
	//--------------------------------------------------------

	/**
	 * Default schema to use
	 *
	 * @var schema
	 */
	static $driver;

	/**
	 * String contains main Sql query 
	 *
	 * @var string
	 */
	static $query;

	/**
	 * Array contains Sql colmuns
	 *
	 * @var array
	 */
	static $colmuns = array();

	//--------------------------------------------------------
	// Schema standard functions
	//--------------------------------------------------------

	/**
	* Initiat the schema class by selecting database driver
	*
	*/
	public static function ini()
	{
		switch (Config::get("database.driver"))
		{
			case 'mysql':
				self::$driver = new MysqlSchema ;
				break;
		}
	}

	//--------------------------------------------------------
	// Columns Type
	//--------------------------------------------------------


	/**
	* function to add incremented primary key column
	*
	* @param string name
	* @return schema
	*/
	public function id($name)
	{
		return self::$driver->id($name);
	}

	/**
	* function to add varchar column
	*
	* @param string name
	* @param int length
	* @param string $default
	* @return schema
	*/
	public function string($name, $length=255, $default=null)
	{
		return return self::$driver->string($name, $length, $default);
	}

	/**
	* function to add int column
	*
	* @param string name
	* @param int length
	* @param string $default
	* @return schema
	*/
	public function int($name, $length=255, $default=null)
	{
		return return self::$driver->int($name, $length, $default);
	}
	
}