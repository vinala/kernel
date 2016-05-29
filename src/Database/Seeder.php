<?php 

namespace Lighty\Kernel\Database;

use SeedsCaller as Caller;
use Lighty\Kernel\Database\Exception\SeedersEmptyException;
use Lighty\Kernel\Database\Schema;
use Lighty\Kernel\Objects\Table;

/**
* Seeder class
*/
class Seeder
{
	
	public static function call($name,$clear=true)
	{
		$tab=new $name();
		$tabl=$tab->table;
		//
		if($clear)
		{
			$tabs=new DBTable($tabl);
			$tabs->clear();
		}
		//
		return self::execute($tab);
	}

	public static function ini()
	{
		$seeders = self::getSeeders();
		//
		$result = array();
		//
		foreach ($seeders as $value) 
			$result[$value] = self::call($value);
		//
		return $result;
	}

	protected static function getSeeders()
	{
		$seeders = Caller::references();
		//
		if(empty($seeders)) throw new SeedersEmptyException();
		//
		return $seeders;
	}


	protected static function execute($seeder)
	{
		$data = array();
		//
		for ($i=0; $i < $seeder->count; $i++)
			Table::push($data , $seeder->data());
		//
		return Schema::table($seeder->table)->insert($data);
	}

}