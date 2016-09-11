<?php 

namespace Lighty\Kernel\Database;

use Lighty\Kernel\Config\Config;
use Lighty\Kernel\Database\Drivers\MysqlDatabase;


/**
* Database Class
*/
class Database
{

	static $server=null;
	static $default=null;
	static $serverData=array();
	static $defaultData=array();
	private static $driver=null;

	public static function ini()
	{
		self::$driver=self::driver();
		self::$driver->connect();
	}

	/**
	* Set the driver used in config files
	* @return Database
	*/
	public static function driver()
	{
		switch (Config::get('database.default')) {
			case 'sqlite':
				# code...
				break;

			case 'mysql':
					return (new MysqlDatabase);
				break;

			case 'pgsql':
				# code...
				break;

			case 'sqlsrv':
				# code...
				break;
		}
	}

	
	/**
	* Connect to driver database server
	* @return PDO
	*/
	public static function connect()
	{
		return self::$driver->connect();
	}


	/**
	* Connect to default driver database server
	* @return PDO
	*/
	public static function defaultConnection()
	{
		return self::connect();
	}


	/**
	* Connect to another driver database server
	* @param string, string, string, string
	* @return PDO
	*/
	public function newConnection($host, $database, $user, $password )
	{
		return self::$driver->connect($host, $database, $user, $password );
	}
	





	public static function exec($sql)
	{
		return self::$driver->exec($sql);
	}

	public static function execErr()
	{
		return self::$driver->execErr();
	}

	//assoc : 1 , array : 2
	public static function read($sql,$mode=2)
	{
		return self::$driver->read($sql , $mode);
	}

	public static function countR($res)
	{
		return self::$driver->countR($res);
	}

	public static function countS($sql)
	{
		return self::$driver->countS($sql);
	}

	public static function res($sql)
	{
		return self::$driver->res($sql);
	}

	/**
	 * Export the Database
	 */
	public static function export()
	{
		return self::$driver->export();
	}

	/**
	 *  Get all columns
	 */
	public static function colmuns($table)
	{
		return self::$driver->getColmuns($table);
	}

	/**
	 * get increment columns
	 */
	public static function incrementColumns($table)
	{
		return self::$driver->getIncrement($table);
	}

	/**
	 * get normal columns without increments
	 */
	public static function normalColumns($table)
	{
		return self::$driver->getNormalColumn($table);
	}



}

