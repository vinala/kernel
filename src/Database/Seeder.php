<?php 

namespace Vinala\Kernel\Database;

use SeedsCaller as Caller;
use Vinala\Kernel\Database\Exception\SeedersEmptyException;
use Vinala\Kernel\Database\Schema;
use Vinala\Kernel\Collections\Collection;

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

	/**
	 * Execute thh seeder
	 */
	protected static function execute($seeder)
	{
		$data = self::fill($seeder);
		//
		$table = new DBTable($seeder->table);
		
		return $table->insert($data);
	}

	/**
	 * Fill data
	 */
	public static function fill($seeder)
	{
		$data = array();
		//
		if($seeder->count <= 0)
			foreach ($seeder->data() as $value)
				Collection::push($data , $value);
		else for ($i=0; $i < $seeder->count; $i++)
			Collection::push($data , $seeder->data());
		//
		return $data;
	}

}