<?php

namespace Lighty\Kernel\Database;

use Lighty\Kernel\Objects\Table;
use Lighty\Kernel\Config\Config;

/**
* Schema builder class
*/
class MysqlSchema extends Schema
{
	/**
	* function to add incremented primary key column
	*
	* @param string name
	* @return schema
	*/
	public function id($name)
	{
		self::$colmuns[]=$nom.' int primary key AUTO_INCREMENT';
		return $this;
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
		$cmnd = $name.' varchar('.$length.')';
		//
		if(!empty($default)) cmnd.=" DEFAULT '$default' ";
		//
		self::$colmuns[]=$cmnd;
		return $this;
	}

	/**
	* function to add int column
	*
	* @param string name
	* @param int length
	* @param string $default
	* @return schema
	*/
	public function int($name, $length=11 ,$default=null)
	{
		$cmnd=$name.' int('.$length.')';
		//
		if(!empty($default)) $cmnd.=" DEFAULT $default ";
		//
		self::$colmuns[]=$cmnd;
		//
		return $this;
	}

	/**
	* function to add long column
	*
	* @param string name
	* @param int length
	* @param string $default
	* @return schema
	*/
	public function long($name,$length=11 ,$default=null)
	{
		$cmnd=$name.' bigint('.$length.')';
		//
		if(!empty($default)) $cmnd.=" DEFAULT $default ";
		//
		self::$colmuns[]=$cmnd;

		return $this;
	}

	/**
	* function to add float column
	*
	* @param string name
	* @param int length
	* @param string $default
	* @return schema
	*/
	public function float($name,$length=11 ,$default=null)
	{
		$cmnd=$name.' float('.$length.')';
		//
		if(!empty($default)) $cmnd.=" DEFAULT $default ";
		//
		self::$colmuns[]=$cmnd;

		return $this;
	}

	/**
	* function to add text column
	*
	* @param string name
	* @return schema
	*/
	public function text($name)
	{
		self::$colmuns[]=$name.' text';
		//
		return $this;
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
		$cmnd = $name.' tinyint(1)';
		//
		if(!empty($default)) 
		{
			$default = $default ? "1" : "0" ;
			$cmnd.=" DEFAULT $default ";
		}
		//
		self::$colmuns[]=$cmnd;
		//
		return $this;
	}

	/**
	* function to add datetime column
	*
	* @param string name
	* @return schema
	*/
	public function datetime($name)
	{
		self::$colmuns[]=$name.' DATETIME';
		//
		return $this;
	}

	/**
	* function to add date column
	*
	* @param string name
	* @return schema
	*/
	public function date($name)
	{
		self::$colmuns[]=$name.' date';
		//
		return $this;
	}

	/**
	* function to add time column
	*
	* @param string name
	* @return schema
	*/
	public function time($name)
	{
		self::$colmuns[] = $name.' time';
		//
		return $this;
	}

	/**
	* function to add timestamp column
	*
	* @param string name
	* @param string default
	* @return schema
	*/
	public function timestamp($name ,$default = "")
	{
		$cmnd = $name.' int(15)';
		//
		if( ! empty($default) ) $cmnd .= " DEFAULT $default ";
		//
		self::$colmuns[] = $cmnd;
		//
		return $this;
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
		self::$colmuns[]='created_at int(15),edited_at int(15)';
		return $this;
	}

	/**
	* function to add deleted column for stashed data
	*
	* @return schema
	*/
	public function stash()
	{
		self::$colmuns[]='deleted_at int(15)';
		return $this;
	}

	/**
	* function to add deleted column for stashed data
	*
	* @return schema
	*/
	public function stash()
	{
		self::$colmuns[]='deleted_at int(15)';
		return $this;
	}

	/**
	* function to add remembreToken column
	*
	* @return schema
	*/
	public function remembreToken()
	{
		self::$colmuns[]='rememberToken varchar(255)';
		return $this;
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
	public function default($value)
	{
		$i=Table::count(self::$colmuns)-1;
		self::$colmuns[$i].=" default '".$value."'";
		//
		return $this;
	}

	/**
	* function to add not null constraint
	*
	* @return schema
	*/
	public function notnull()
	{
		$i=Table::count(self::$colmuns)-1;
		self::$colmuns[$i].=" not null";
		//
		return $this;
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
		$i=Table::count(self::$colmuns)-1;
		//
		self::$colmuns[$i] .= " references ".$table;
		if(!empty($colmun)) self::$colmuns[$i] .= "(".$colmun.")";
		//
		return $this;
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
		if( is_array($colmuns))
		{
			$query = "CONSTRAINT $name UNIQUE (";
			//
			for ($i=0; $i < Table::count($colmuns); $i++) {
				if($i==Table::count($colmuns)-1) $query .= $colmuns[$i];
				else $query .= $colmuns[$i].",";
			}
			$query .= ")";
			//
			self::$colmuns[] = $query;
		}
		//
		return $this;
	}


	//--------------------------------------------------------
	// Schema building
	//--------------------------------------------------------


	/**
	* function to get name of table in case of table prefix
	*
	* @param string $name
	* @return string
	*/
	protected static function table($name)
	{
		if(Config::get('database.prefixing')) $name=Config::get('database.prefixe').$name;
		//
		return $name;
	}

	/**
	* function to build query of table creation
	*
	* @param string $name
	* @param callable $script
	* @return bool
	*/
	public static function create($name,$script)
	{
		$name = self::table($name);
		//
		self::$query = "create table ".$name."(";
		//
		$object = new self();
		$script($object);
		//
		$query = "";
		//
		for ($i=0; $i < Table::count(self::$colmuns); $i++)
			$query = ($i == (Table::count(self::$colmuns)-1)) ? self::$colmuns[$i] : self::$colmuns[$i]."," ;
		//
		self::$query .= $query.") DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
		//
		return Database::exec(self::$query);
	}

	/**
	* function to build query of table erasing
	*
	* @param string $name
	* @return bool
	*/
	public static function drop($name)
	{
		$name = self::table($name);
		//
		return Database::exec("DROP TABLE ".$name);
	}

	/**
	* function to build query for rename table
	*
	* @param string $from
	* @param string $to
	* @return bool
	*/
	public static function rename($from, $to)
	{
		$from=self::table($from);
		$to=self::table($to);
		//
		return Database::exec("RENAME TABLE ".$from." TO ".$to);
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
		$name = self::table($name);
		//
		self::$query = "alter table ".$name." ";
		//
		$object = new self();
		$script($object);
		//
		$query = "";
		for ($i=0; $i < Table::count(self::$sql_rows); $i++)
			$query = " add " . self::$colmuns[$i] . (($i == (Table::count(self::$colmuns)-1)) ? "" : ",");
		//
		self::$query .= $query
		//
		return Database::exec(self::$query);
	}

	/**
	* function to build query for removing column to table
	*
	* @param string $name
	* @param callable $script
	* @return bool
	*/
	public static function remove($name,$colmuns)
	{
		$name = self::tableName($name);
		//
		self::$query = "alter table ".$name." ";
		//
		if(is_array($colmuns))
			for ($i=0; $i < Table::count($colmuns); $i++)
				self::$query = " drop ".$colmuns[$i] . (($i == (Table::count(self::$colmuns)-1)) ? "" : ",");
		else self::$query .= " drop ".$colmuns;
		//
		return Database::exec(self::$query);
	}

}