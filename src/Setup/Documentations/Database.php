<?php 

namespace Lighty\Kernel\Setup\Documentations;

/**
* 
*/
class Database
{
	
	/**
	 * Database
	 */
	protected static function dbDoc($index)
	{
		$doc = array(
			'default' => "\n\t|  Default used database driver",
			'connections' => "\n\t|  All drivers that Lighty Work with",
			'table' => "\n\t|  Database used to store migrations info",
			'prefixing' => "\n\t|  If true, Lighty will add prefixe for all \n\t|  Database tables created by the framework",
			'prefixe' => "\n\t|  This string will be add to all tables names\n\t|  created by Lighty if prefixing parameter was true",
			);
		//
		return $doc[$index]."\n\t*/";
	}

	protected static function dbTitles($index)
	{
		$titles = array(
			'default' => "Default Database Connection",
			'connections' => "Database Connections",
			'table' => "Schemas Table",
			'prefixing' => "Prefixing",
			'prefixe' => "The prefixe",
			);
		//
		$sep = "\n\t|----------------------------------------------------------";
		return "\n\n\t/*".$sep."\n\t| ".$titles[$index].$sep;
	}

	protected static function dbRow($index,$param)
	{
		$title = self::dbTitles($index);
		$doc = self::dbDoc($index);
		//
		return $title.$doc."\n\n\t$param\n";
	}

	protected static function dbConnections($host,$name,$usr,$pass)
	{
		return "'connections' => array(\n\n\t\t'sqlite' => array(\n\t\t\t'driver'   => 'sqlite',\n\t\t\t'database' => __DIR__.'/../database/production.sqlite',\n\t\t),\n\n\t\t'mysql' => array(\n\t\t\t'driver'    => 'mysql',\n\t\t\t'host'      => '".$host."',\n\t\t\t'database'  => '".$name."',\n\t\t\t'username'  => '".$usr."',\n\t\t\t'password'  => '".$pass."',\n\t\t\t'charset'   => 'utf8',\n\t\t\t'collation' => 'utf8_unicode_ci',\n\t\t),\n\n\t\t'pgsql' => array(\n\t\t\t'driver'   => 'pgsql',\n\t\t\t'host'     => 'localhost',\n\t\t\t'database' => 'forge',\n\t\t\t'username' => 'forge',\n\t\t\t'password' => '',\n\t\t\t'charset'  => 'utf8',\n\t\t\t'schema'   => 'public',\n\t\t),\n\n\t\t'sqlsrv' => array(\n\t\t\t'driver'   => 'sqlsrv',\n\t\t\t'host'     => 'localhost',\n\t\t\t'database' => 'database',\n\t\t\t'username' => 'root',\n\t\t\t'password' => '',\n\t\t),\n\t),";
	}

	public static function set($host,$name,$usr,$pass,$prefixing,$prefix)
	{
		$default = self::dbRow("default","'default' => 'mysql', ");
		$connections = self::dbRow("connections",self::dbConnections($host,$name,$usr,$pass));
		$table = self::dbRow("table","'migration' => 'lighty_migrations',");
		$prefixing = self::dbRow("prefixing","'prefixing' => $prefixing ,");
		$prefixe = self::dbRow("prefixe","'prefixe' => '".$prefix."_',");
		
		//
		return "<?php \n\nreturn array(\n\t".$default.$connections.$table.$prefixing.$prefixe."\n);";
	}
}