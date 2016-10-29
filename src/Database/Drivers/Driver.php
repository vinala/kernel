<?php 

namespace Vinala\Kernel\Database\Drivers;

use PDO;

use Vinala\Kernel\Config\Config;
use Vinala\Kernel\Database\Database;
use Vinala\Kernel\Database\Exception\DatabaseArgumentsException;
use Vinala\Kernel\Database\Exception\DatabaseConnectionException;
use mysqli as Sql;
use Vinala\Kernel\Objects\DateTime as Time;
use Vinala\Kernel\Filesystem\Filesystem;
use Vinala\Kernel\Foundation\Application;
use Vinala\Kernel\Objects\Table;
use Vinala\Kernel\Database\Connector\MysqlConnector;


/**
* mother class of database drivers lass
*/
class Driver
{

	const KEY= PDO::FETCH_ASSOC;
	const INDEX= PDO::FETCH_BOTH;
	/**
	 * the PDO to database server
	 * @var PDO
	 */
	public static $server;

	/**
	 * the connection to Mysql database server
	 * @var MysqlConnector
	 */
	protected static $connection;

	/**
	* Connect to default Mysql database server
	*
	* @return PDO
	*/
	public static function defaultConnection()
	{
		return self::connect();
	}

	/**
	* Connect to another Mysql database server
	*
	* @param string $host
	* @param string $database
	* @param string $user
	* @param string $password
	* @return PDO
	*/
	public static function newConnection($host, $database, $user, $password )
	{
		return self::connect($host, $database, $user, $password );
	}

	/**
	* run SQL query
	*
	* @param string
	* @return bool
	*/
	public static function exec($sql)
	{
		self::$server->exec($sql);
		return true;
	}

	/**
	* get data by SQL query
	*
	* @param string
	* @return array
	*/
	public static function read($sql,$mode = Driver::KEY)
	{
		$vals = array();
		$result = self::query($sql);
		while ($row = $result->fetch($mode))
			$vals[]=$row;
		//
		return $vals;
	}


	/**
	* execute SQL query
	*
	* @param string 
	* @return mixed
	*/
	public static function query($sql)
	{
		return self::$server->query($sql);
	}
	
	
	/**
	* get number of rows of SQL query
	*
	* @param string
	* @return int
	*/
	public static function count($sql)
	{
		$data = self::query($sql);
		$result = $data->fetchAll(PDO::FETCH_ASSOC);
		//
		return  $result ? count($result) : -1;
	}

	/**
	* get last error
	*
	* @return string
	*/
	public static function error()
	{
		return self::$server->errorInfo();
	}
	
}