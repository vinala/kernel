<?php 

namespace Lighty\Kernel\Database;

use Lighty\Kernel\Config\Config;
use Lighty\Kernel\Objects\Table;
use Lighty\Kernel\Database\Exceptions\QueryException;

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
	 * columns query
	 */
	protected $where;

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
		return self::query();
	}

	/**
	 * Get first Data returned from query
	 * @return Array
	 */
	public function first()
	{
		$data = self::query();
		if(Table::count($data) > 0) return $data[1];
	}

	/**
	 * get arraay of data
	 * @param string
	 * @return array
	 */
	public function query()
	{
		$where = ! is_null($this->where) ? " where ".$this->where : "";
		$sql = "select ".$this->columns." from ".$this->table." ".$where;
		// //
		// die($sql);
		if($data = Database::read($sql)) return self::fetch($data);
		elseif(Database::execerr()) throw new QueryException();
		
	}

	/**
	 * Fetch data
	 * @param array
	 * @return array
	 */
	public function fetch($array)
	{
		$data = array();
		// return Database::read("select ".$this->columns." from ".$this->table);
		//
		foreach ($array as $row) {
			//
			$rw = new Row;
			//
			foreach ($row as $index => $column) 
				if( ! is_int($index)) $rw->$index = $column;
			//
			$data[] = $rw ; 
		}
		//
		return $data;
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

	/**
	 * Set where clause
	 * @return Array
	 */
	public function where($column, $relation, $value)
	{
		$this->where = "$column $relation '$value' ";
		//
		return $this;
	}
}