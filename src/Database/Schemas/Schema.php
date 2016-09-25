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
				self::$driver = new Schema\MysqlSchema ;
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
	* function to add incremented primary key column
	*
	* @param string name
	* @return schema
	* @deprecated 3.3.0
	*/
	public function inc($name)
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
		return self::$driver->string($name, $length, $default);
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
		return self::$driver->int($name, $length, $default);
	}

	/**
	* function to add long column
	*
	* @param string name
	* @param int length
	* @param string $default
	* @return schema
	*/
	public function long($name, $length=255, $default=null)
	{
		return self::$driver->long($name, $length, $default);
	}

	/**
	* function to add float column
	*
	* @param string name
	* @param int length
	* @param string $default
	* @return schema
	*/
	public function float($name, $length=255, $default=null)
	{
		return self::$driver->float($name, $length, $default);
	}

	/**
	* function to add text column
	*
	* @param string name
	* @return schema
	*/
	public function text($name)
	{
		return self::$driver->text($name);
	}

	/**
	* function to add bool column
	*
	* @param string name
	* @param bool default
	* @return schema
	*/
	public function bool($name, $default = null)
	{
		return self::$driver->bool($name, $default);
	}

	/**
	* function to add datetime column
	*
	* @param string name
	* @return schema
	*/
	public function datetime($name)
	{
		return self::$driver->datetime($name);
	}
	
	/**
	* function to add date column
	*
	* @param string name
	* @return schema
	*/
	public function date($name)
	{
		return self::$driver->date($name);
	}
	
	/**
	* function to add time column
	*
	* @param string name
	* @return schema
	*/
	public function time($name)
	{
		return self::$driver->time($name);
	}

	/**
	* function to add time column
	*
	* @param string name
	* @param string default
	* @return schema
	*/
	public function timestamp($name ,$timestamp)
	{
		return self::$driver->timestamp($name ,$timestamp);
	}

	//--------------------------------------------------------
	// The framework data columns
	//--------------------------------------------------------

	/**
	* function to add update columns created_at and edited_at
	*
	* @return schema
	*/
	public function update()
	{
		return self::$driver->update();
	}

	/**
	* function to add stach data columns deleted_at
	*
	* @return schema
	*/
	public function stash()
	{
		return self::$driver->stash();
	}

	/**
	* function to add remembreToken column
	*
	* @return schema
	*/
	public function remembreToken()
	{
		return self::$driver->remembreToken();
	}

	//--------------------------------------------------------
	// Constraint
	//--------------------------------------------------------

	/**
	* function to add default constraint
	*
	* @param string $value
	* @return schema
	*/
	public function affect($value)
	{
		return self::$driver->affect($value);
	}

	/**
	* function to add notnull constraint
	*
	* @param string $value
	* @return schema
	*/
	public function notnull()
	{
		return self::$driver->notnull();
	}

	/**
	* function to add foreign key constraint
	*
	* @param string $table
	* @param string $colmun
	* @return schema
	*/
	public function foreignkey($table, $colmun=null)
	{
		return self::$driver->foreignkey($table, $colmun);
	}

	/**
	* function to add unique constraint
	*
	* @param string $table
	* @param array $colmuns
	* @return schema
	*/
	public function unique($name, array $colmuns)
	{
		return self::$driver->unique($name, $colmuns);
	}


	//--------------------------------------------------------
	// Schema building
	//--------------------------------------------------------


	/**
	* function to build query of table creation
	*
	* @param string $name
	* @return schema
	*/
	public static function create($name, $script)
	{
		$object = get_class(self::$driver);
		//
		return $object::create($name, $script);
	}

	/**
	* function to build query of table erasing
	*
	* @param string $name
	* @return schema
	*/
	public static function drop($name)
	{
		return self::$driver->drop($name);
	}


	//--------------------------------------------------------
	// Schema updating
	//--------------------------------------------------------


	/**
	* function to build query for adding column to table
	*
	* @param string $name
	* @param callable $script
	* @return bool
	*/
	public static function add($name,$script)
	{
		return self::$driver->add($name,$script);
	}

	/**
	* function to build query for removing column from table
	*
	* @param string $name
	* @param callable $script
	* @return bool
	*/
	public static function remove($name,$script)
	{
		return self::$driver->remove($name,$script);
	}

	/**
	* check if the table is existe in database
	*
	* @param string $name table name
	* @param string $table
	* @return bool
	*/
	public static function existe($name,$table=null)
	{
		$object = get_class(self::$driver);
		return $object::existe($name,$table);
	}


	
}