<?php 

namespace Lighty\Kernel\Database;

use Lighty\Kernel\Config\Config;

/**
* Query Class
*/
class Query
{

	/**
	 * Table of data
	 */
	protected $table;

	/**
	 * columns query
	 */
	protected $column = "*";

	/**
	 * Set the query table
	 * @param string 
	 * @return object
	 */
	public static function table($table)
	{
		return new self($table);
	}

	/**
	 * Constructor for class
	 */
	function __construct($table)
	{
		if(Config::get("database.prefixing")) $this->table = Config::get("database.prefixe").$table;
		else $this->table = $table;
	}

	/**
	 * Get all Data returned from query
	 * @return Array
	 */
	public function get()
	{
		$query="select ".$this->column." from ".$this->table; 
		return Database::read($query);
	}
}