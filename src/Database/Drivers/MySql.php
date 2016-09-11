<?php 

namespace Lighty\Kernel\Database\Drivers;

use Lighty\Kernel\Config\Config;
use Lighty\Kernel\Database\Database;
use Lighty\Kernel\Database\Exception\DatabaseArgumentsException;
use Lighty\Kernel\Database\Exception\DatabaseConnectionException;
use mysqli as Sql;
use Lighty\Kernel\Objects\DateTime as Time;
use Lighty\Kernel\Filesystem\Filesystem;
use Lighty\Kernel\Foundation\Application;
use Lighty\Kernel\Objects\Table;
use Lighty\Kernel\Database\Connector\MysqlConnector;


/**
* Mysql Database Class
*/
class Mysql extends Driver
{

	const URL_FAILD_MODE_EXCEPTION = '1';
	const EXCEPTION_FAILD_MODE = '2';

	/**
	* Connect to Mysql database server
	* @param string, string, string, string
	* @return PDO
	*/
	public function connect($host = null, $database = null, $user = null, $password = null)
	{
		if(Config::get('panel.setup')) 
		{
			$this->connection = new MysqlConnector($host, $database, $user, $password);
			$this->server = $this->connection->connector;
		}
		return $this->server;
	}


	public function execErr()
	{
		$msg="";
		if(mysqli_error(Database::$server)!="")
		$msg="mysql error : ".mysqli_error(Database::$server);
		return $msg;
	}


	/**
	 * get Table create
	 */
	public static function tableCreat(Sql $mysqli, $table)
	{
		$drop = "DROP TABLE IF EXISTS `$table`;";
		$res = $mysqli->query('SHOW CREATE TABLE '.$table); 
		//
		$structure = $res->fetch_row();
		//
		return "\n\n-- $table\n\n-- '$table' Table Structure\n$drop\n".$structure[1].";\n\n";
	}

	/**
	 * get Data Table
	 */
	public static function databaseTables(Sql $sql)
	{
		$tables=false;
		//
		$Tables = $sql->query('SHOW TABLES'); 
		//
		while($row = $Tables->fetch_row()) 
            $target_tables[] = $row[0];  
        //
        if($tables !== false) 
            $target_tables = array_intersect( $target_tables, $tables); 
        //
        return $target_tables;
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
        return Database::$default;
	}

	/**
	 * Get the Mysqli Class
	 */
	protected static function saveExport($time, $content)
	{
		$database 	= Config::get("database.database");
		//
		$name = $database."_".$time.".sql";
		$path = Application::$root."database/backup/$name";
		//
		return (new Filesystem)->put($path,$content); 
	}

	/**
	 * query to make database
	 */
	protected static function makeDatabase()
	{
		$database = Config::get("database.database");
		return "\n\n-- CREATE DATABASE $database;\n-- USE $database;";
	}

	/**
	 * fetch Database Tables
	 */
	protected static function fetchTables($tables, Sql $mysqli)
	{
		foreach($tables as $table)
        {
            $result         =   $mysqli->query('SELECT * FROM '.$table);  
            $fields_amount  =   $result->field_count;  
            $rows_num		= $mysqli->affected_rows; 
            //
            $content        = (!isset($content) ?  '' : $content) . self::tableCreat($mysqli, $table);

            for ($i = 0, $st_counter = 0; $i < $fields_amount;   $i++, $st_counter=0) 
            {
                while($row = $result->fetch_row())  
                { 
                	//when started (and every after 100 command cycle):
                    if ($st_counter%100 == 0 || $st_counter == 0 )  
                    	$content .= "\n-- Table Data\nINSERT INTO ".$table." VALUES";
                    //
                    $content .= "\n(";
                    //
                    for($j=0; $j<$fields_amount; $j++)  
                    { 
                        $row[$j] = str_replace("\n","\\n", addslashes($row[$j]) ); 
                        //
                        if (isset($row[$j])) $content .= '"'.$row[$j].'"' ; 
                        //
                        else $content .= '""';
                        // 
                        if ($j<($fields_amount-1)) $content.= ',';
                    }
                    //
                    $content .=")";
                    //every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
                    if ( (($st_counter+1)%100==0 && $st_counter!=0) || $st_counter+1==$rows_num) 
                    	$content .= ";";
                    //
                    else $content .= ",";
                    //
                    $st_counter=$st_counter+1;
                }
            } 
            $content .="\n\n\n";
        }
        return $content;
	}

	/**
	 * Export the Database
	 */
	public static function export()
	{
		$backup_name=false;
		//
		$now = self::exportTimeU();
		//
		$content = self::exportTime($now).self::exportInfo();
		$mysqli = self::exportDatabase();
		$tables = self::databaseTables($mysqli); 
		//
		$content .= self::makeDatabase();
		//
        $content .= self::fetchTables($tables, $mysqli);

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
	 * Get columns of data table
	 */
	public function getColmuns($table)
	{
		$table = self::table($table);
		$columns = array();
		//
		$data = Database::read("select COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '".Config::get('database.database')."' AND TABLE_NAME = '$table';");
		//
		foreach ($data as $key => $value) 
			$columns[] = $value["COLUMN_NAME"];
		//
		return $columns;
	}

	/**
	 * Get columns of data table
	 */
	public function getIncrement($table)
	{
		$table = self::table($table);
		$columns = array();
		//
		$data = Database::read("select COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '".Config::get('database.database')."' AND TABLE_NAME = '$table' AND EXTRA like '%auto_increment%';");
		//
		foreach ($data as $key => $value) 
			$columns[] = $value["COLUMN_NAME"];
		//
		return $columns; 
	}

	/**
	 * Get columns of data table without auto increment columns
	 */
	public function getNormalColumn($table)
	{
		$all = self::getColmuns($table);
		$incs = self::getIncrement($table);
		//
		return Table::except($incs,$all);
	}

	/**
	 * Get the real name of table with prefix
	 */
	public function table($table)
	{
		if(Config::get('database.prefixing')) return Config::get('database.prefixe') . $table;
		return $table;
	}
}
