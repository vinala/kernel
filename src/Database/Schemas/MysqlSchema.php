<?php

namespace Lighty\Kernel\Database;

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
	* function to add intschema column
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
}