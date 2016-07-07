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
	 * where clause
	 */
	protected $where = "";

	/**
	 * order of data
	 */
	protected $order = "";

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
		if(Table::count($data) > 0) return $data[0];
	}

	/**
	 * get arraay of data
	 * @param string
	 * @return array
	 */
	public function query()
	{
		$sql = "select ".$this->columns." from ".$this->table." ".$this->where." ".$this->order;
		// //
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
		$this->where = " where $column $relation '$value' ";
		//
		return $this;
	}

	/**
	 * Set new OR condition in where clause
	 * @return Array
	 */
	public function orWhere($column, $relation, $value)
	{
		$this->where .= " or ( $column $relation '$value' )";
		//
		return $this;
	}

	/**
	 * Set new AND condition in where clause
	 * @return Array
	 */
	public function andWhere($column, $relation, $value)
	{
		$this->where .= " and ( $column $relation '$value' )";
		//
		return $this;
	}

	/**
	 * Set the order of data
	 * @return Array
	 */
	public function order()
	{
		$columns = func_get_args();
		$order = "" ;
		$i = 0;
		//
		if($columns) 
			foreach ($columns as $value) {
				if( ! $i) $order .= " order by ".$value;
				else $order .= ",".$value;
				$i = 1;
			}
		//
		$this->order = $order;
		//
		return $this;
	}
}