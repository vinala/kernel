<?php 

namespace Lighty\Kernel\Database\Drivers;

use PDO;

use Lighty\Kernel\Config\Config;
use Lighty\Kernel\Database\Database;
use Lighty\Kernel\Database\Exception\DatabaseArgumentsException;
use Lighty\Kernel\Database\Exception\DatabaseConnectionException;
use mysqli as Sql;
use Lighty\Kernel\Objects\DateTime as Time;
use Lighty\Kernel\Filesystem\Filesystem;
use Lighty\Kernel\Foundation\Application;
use Lighty\Kernel\Objects\Table;
use Lighty\Kernel\Database\Connector\MysqlConnector;


/**
* mother class of database drivers lass
*/
class Driver
{
	/**
	 * the PDO to database server
	 * @param PDO
	 */
	public $server;

	/**
	 * the connection to Mysql database server
	 * @param MysqlConnector
	 */
	protected $connection;

	/**
	* Connect to default Mysql database server
	* @return PDO
	*/
	public function defaultConnection()
	{
		return $this->connect();
	}

	/**
	* Connect to another Mysql database server
	* @param string, string, string, string
	* @return PDO
	*/
	public function newConnection($host, $database, $user, $password )
	{
		return $this->connect($host, $database, $user, $password );
	}

	/**
	* run SQL query
	* @param string
	* @return bool
	*/
	public static function exec($sql)
	{
		return $this->server->exec($sql);
	}

	/**
	* get data by SQL query
	* @param string
	* @return array
	*/
	public function read($sql)
	{
		$vals = array();
		$result = $this->server->query($sql);
		while ($row = $result->fetch(PDO::FETCH_ASSOC))
			$vals[]=$row;
		//
		return $vals;
	}

	/**
	* execute SQL query
	* @param string
	* @return mixed
	*/
	public function query($sql)
	{
		return $this->server->query($sql);
	}
	
	/**
	* get number of rows of SQL query
	* @param string
	* @return int
	*/
	public function count($sql)
	{
		$data = $this->query($sql);
		$result = $data->fetchAll(PDO::FETCH_ASSOC);
		//
		return  $result ? count($result) : -1;
	}
	
}