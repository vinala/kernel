<?php

namespace Vinala\Kernel\Database\InOut\Mysql;

use Vinala\Kernel\Config\Config;
use Vinala\Kernel\Database\Drivers\MysqlDriver as Driver;
use Vinala\Kernel\Filesystem\Filesystem;
use Vinala\Kernel\Foundation\Application;
use Vinala\Kernel\Time\DateTime as Time;

/**
 * database export class.
 */
class Exporter
{
    /**
     * Get SQL query of table stucture.
     *
     * @param string $table name of table to export
     *
     * @return string table structure
     */
    public static function stucture($table)
    {
        $drop = "DROP TABLE IF EXISTS `$table`;";
        $res = Driver::read('SHOW CREATE TABLE '.$table);
        $struct = $res[0]['Create Table'];
        //
        return "\n\n-- $table\n\n-- '$table' Table Structure\n$drop\n".$struct.";\n\n";
    }

    /**
     * Get all data tables created in the current database.
     *
     * @return array
     */
    public static function tables()
    {
        $tables = false;
        //
        $Tables = Driver::read('SHOW TABLES', Driver::INDEX);
        // die(var_dump($Tables));
        //
        foreach ($Tables as $row) {
            $target_tables[] = $row[0];
        }
        //
        if ($tables !== false) {
            $target_tables = array_intersect($target_tables, $tables);
        }
        //
        return $target_tables;
    }

    /**
     * Get timestamp of export generation.
     *
     * @param timestamp $time the current time
     *
     * @return timestamp
     */
    public static function time($time)
    {
        $current = Time::datetime($time);
        //
        return "-- Generated in $current ($time)";
    }

    /**
     * Get info about database server connection.
     *
     * @return string
     */
    public static function info()
    {
        $database = Config::get('database.database');
        $host = Config::get('database.host');
        $username = Config::get('database.username');
        //
        return "\n\n-- Database : $database\n-- Host : $host\n-- User : $username\n";
    }

    /**
     * Save exported data in sql file.
     *
     * @param timestamp $time  the current time
     * @param string    $query the sql query
     *
     * @return Filesystem
     */
    public static function save($file, $query)
    {
        $path = Application::$root."database/backup/$file";
        //
        return (new Filesystem())->put($path, $query);
    }

    /**
     * Get query of creating database.
     *
     * @return string
     */
    public static function database()
    {
        $database = Config::get('database.database');

        return "\n\n DROP DATABASE IF EXISTS $database;\n\n CREATE DATABASE $database;\n USE $database;";
    }

    /**
     * fetch data inside data tables.
     *
     * @param array $tables tables of database
     *
     * @return string
     */
    public static function fetch($tables)
    {
        foreach ($tables as $table) {
            $result = Driver::query("SELECT * FROM $table", Driver::INDEX);
            $fields = $result->columnCount();
            $rows = $result->rowCount();
            $data = Driver::read("SELECT * FROM $table", Driver::INDEX);
            //
            $content = (!isset($content) ? '' : $content).self::stucture($table);
            //
            for ($i = 0, $st_counter = 0; $i < 1; $i++, $st_counter = 0) {
                foreach ($data as $row) {
                    if ($st_counter % 100 == 0 || $st_counter == 0) {
                        $content .= "\n-- Table Data\nINSERT INTO ".$table.' VALUES';
                    }
                    //
                    $content .= "\n(";
                    //
                    for ($j = 0; $j < $fields; $j++) {
                        $row[$j] = str_replace("\n", '\\n', addslashes($row[$j]));
                        //
                        if (isset($row[$j])) {
                            if (!empty($row[$j])) {
                                $content .= '"'.$row[$j].'"';
                            } else {
                                $content .= 'NULL';
                            }
                        }
                        //
                        else {
                            $content .= '""';
                        }
                        //
                        if ($j < ($fields - 1)) {
                            $content .= ',';
                        }
                    }
                    //
                    $content .= ')';
                    //
                    if ((($st_counter + 1) % 100 == 0 && $st_counter != 0) || $st_counter + 1 == $rows) {
                        $content .= ';';
                    }
                    //
                    else {
                        $content .= ',';
                    }
                    //
                    $st_counter = $st_counter + 1;
                }
            }
            $content .= "\n\n\n";
        }

        return $content;
    }

    /**
     * Set the file header.
     *
     * @param string name the file name
     *
     * @return null
     */
    public static function file($name)
    {
        header('Content-Type: application/octet-stream');
        header('Content-Transfer-Encoding: Binary');
        header('Content-disposition: attachment; filename="'.$name.'"');
    }

    /**
     * Export the current database.
     *
     * @return bool
     */
    public static function export($name)
    {
        $now = time();
        //
        $tables = self::tables();
        //
        $query = self::time($now).self::info();
        $query .= self::database();
        $query .= self::fetch($tables);
        //
        $file = ($name ?: config('database.database').'_'.$now).'.sql';
        //
        self::file($file);
        //
        self::save($file, $query);
        //
        return true;
    }
}
