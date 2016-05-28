<?php 

namespace Lighty\Kernel\Database;

use SeedsCaller as Caller;
use Lighty\Kernel\Database\Exception\SeedersEmptyException;

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
		return $tab->run();
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

}