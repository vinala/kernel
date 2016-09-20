<?php

namespace Lighty\Kernel\Database;

use Lighty\Kernel\Objects\Table;

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
			$sql="CONSTRAINT $name UNIQUE (";
			//
			for ($i=0; $i < count($colmuns); $i++) {
				if($i==count($colmuns)-1) $sql .= $colmuns[$i];
				else $sql .= $colmuns[$i].",";
			}
			$sql .= ")";
			//
			self::$colmuns[] = $sql;
		}
		//
		return $this;
	}

}