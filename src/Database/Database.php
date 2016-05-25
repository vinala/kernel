<?php 

namespace Lighty\Kernel\Database;

use Lighty\Kernel\Config\Config;
use Lighty\Kernel\Database\Drivers\MysqlDatabase;
use Lighty\Kernel\Objects\DateTime as Time;
use Lighty\Kernel\Filesystem\Filesystem;

/**
* Database Class
*/
class Database
{

	static $server=null;
	static $default=null;
	static $serverData=array();
	static $defaultData=array();
	private static $driver=null;

	public static function ini()
	{
		self::$driver=self::getDriver();
		self::$driver->setDefault();
	}

	public static function getDriver()
	{
		switch (Config::get('database.default')) {
			case 'sqlite':
				# code...
				break;

			case 'mysql':
					return (new MysqlDatabase);
				break;

			case 'pgsql':
				# code...
				break;

			case 'sqlsrv':
				# code...
				break;
		}
	}
	
	public static function setDefault($red=false,$url=null)
	{
		self::$driver->setDefault();
	}

	public static function setNewServer($host,$user,$password,$database)
	{
		self::$driver->setNewServer($host,$user,$password,$database);
	}

	public static function setDefaultDB()
	{
		self::$driver->setDefaultDB();
	}

	public static function ChangeDB($database,$server=null)
	{
		self::$driver->ChangeDB($database,$server);
	}



	public static function exec($sql)
	{
		return self::$driver->exec($sql);
	}

	public static function execErr()
	{
		return self::$driver->execErr();
	}

	//assoc : 1 , array : 2
	public static function read($sql,$mode=2)
	{
		return self::$driver->read($sql , $mode);
	}

	public static function countR($res)
	{
		return self::$driver->countR($res);
	}

	public static function countS($sql)
	{
		return self::$driver->countS($sql);
	}

	public static function res($sql)
	{
		return self::$driver->res($sql);
	}

	/**
	 * Export the Database
	 */
	public static function export()
	{
		$tables=false;
		$backup_name=false;
		//
		$now = self::exportTimeU();
		//
		$content = self::exportTime($now).self::exportInfo();
		$mysqli = self::exportDatabase();
		//
		$queryTables    = $mysqli->query('SHOW TABLES'); 
        while($row = $queryTables->fetch_row()) 
        { 
            $target_tables[] = $row[0]; 
        }   
        if($tables !== false) 
        { 
            $target_tables = array_intersect( $target_tables, $tables); 
        }
        foreach($target_tables as $table)
        {
            $result         =   $mysqli->query('SELECT * FROM '.$table);  
            $fields_amount  =   $result->field_count;  
            $rows_num=$mysqli->affected_rows;     
            $res            =   $mysqli->query('SHOW CREATE TABLE '.$table); 
            $TableMLine     =   $res->fetch_row();
            $content        = (!isset($content) ?  '' : $content) . "\n\n".$TableMLine[1].";\n\n";

            for ($i = 0, $st_counter = 0; $i < $fields_amount;   $i++, $st_counter=0) 
            {
                while($row = $result->fetch_row())  
                { //when started (and every after 100 command cycle):
                    if ($st_counter%100 == 0 || $st_counter == 0 )  
                    {
                            $content .= "\nINSERT INTO ".$table." VALUES";
                    }
                    $content .= "\n(";
                    for($j=0; $j<$fields_amount; $j++)  
                    { 
                        $row[$j] = str_replace("\n","\\n", addslashes($row[$j]) ); 
                        if (isset($row[$j]))
                        {
                            $content .= '"'.$row[$j].'"' ; 
                        }
                        else 
                        {   
                            $content .= '""';
                        }     
                        if ($j<($fields_amount-1))
                        {
                                $content.= ',';
                        }      
                    }
                    $content .=")";
                    //every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
                    if ( (($st_counter+1)%100==0 && $st_counter!=0) || $st_counter+1==$rows_num) 
                    {   
                        $content .= ";";
                    } 
                    else 
                    {
                        $content .= ",";
                    } 
                    $st_counter=$st_counter+1;
                }
            } $content .="\n\n\n";
        }
        //$backup_name = $backup_name ? $backup_name : $name."___(".date('H-i-s')."_".date('d-m-Y').")__rand".rand(1,11111111).".sql";
        $backup_name = $backup_name ? $backup_name : $now.".sql";
        header('Content-Type: application/octet-stream');   
        header("Content-Transfer-Encoding: Binary"); 
        header("Content-disposition: attachment; filename=\"".$backup_name."\"");
        //
        self::saveExport($now, $content);
        //
        return true;
	}

	/**
	 * Get the time of generation of the database
	 */
	protected static function exportTimeU()
	{
		return time();
	}

	/**
	 * Get the time of generation of the database
	 */
	protected static function exportTime($time)
	{
		$current = Time::datetime($time);
		//
		return "-- Generated in $current ($time)";
	}

	/**
	 * Get the info of the database
	 */
	protected static function exportInfo()
	{
		$database 	= Config::get("database.database");
		$host 		= Config::get("database.host");
		$username 	= Config::get("database.username");
		//
		return "\n\n-- Database : $database\n-- Host : $host\n-- User : $username\n";
	}

	/**
	 * Get the Mysqli Class
	 */
	protected static function exportDatabase()
	{
		$database 	= Config::get("database.database");
		$host 		= Config::get("database.host");
		$username 	= Config::get("database.username");
		$password 	= Config::get("database.password");
		//
		$mysqli = new \mysqli($host,$username,$password,$database); 
        $mysqli->select_db($database); 
        $mysqli->query("SET NAMES 'utf8'");
        //
        return $mysqli;
	}

	/**
	 * Get the Mysqli Class
	 */
	protected static function saveExport($time, $content)
	{
		$database 	= Config::get("database.database");
		//
		$name = $database."_".$time.".sql";
		$path = "app/database/$name";
		//
		return (new Filesystem)->put($path,$content); 
	}

}

