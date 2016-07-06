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
	protected $columns = "*";

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
		$data = self::query();
	}

	/**
	 * get arraay of data
	 * @param string
	 * @return array
	 */
	public function query()
	{
		return Database::read("select ".$this->columns." from ".$this->table);
	}

	/**
	 * Set columns of query
	 * @return Array
	 */
	public function select()
	{
		$columns = func_get_args();
		$target = "";
		//
		$i = false;
		foreach ($columns as $column) {
			if( ! $i) $target .= $column;
			else $target .= ",".$column;
			$i = true;
		}
		//
		$this->columns = $target;
		//
		return $this;
	}
}