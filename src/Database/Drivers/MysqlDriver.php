<?php

namespace Vinala\Kernel\Database\Drivers;

use Vinala\Kernel\Collections\Collection;
use Vinala\Kernel\Config\Config;
use Vinala\Kernel\Database\Connector\MysqlConnector;
use Vinala\Kernel\Database\Database;
use Vinala\Kernel\Database\Exporters\MysqlExporter;

/**
 * Mysql Database Class.
 */
class MysqlDriver extends Driver
{
    const URL_FAILD_MODE_EXCEPTION = '1';
    const EXCEPTION_FAILD_MODE = '2';

//--------------------------------------------------------
// Conection functions
//--------------------------------------------------------

    /**
     * Connect to Mysql database server.
     *
     * @param string, string, string, string
     *
     * @return PDO
     */
    public static function connect($host = null, $database = null, $user = null, $password = null)
    {
        if (config('app.setup')) {
            self::$connection = new MysqlConnector($host, $database, $user, $password);
            self::$server = self::$connection->connector;
        }

        return self::$server;
    }

    /**
     * return Mysqli error string.
     *
     * @return string
     *
     * @deprecated 3.3.0
     */
    public function execErr()
    {
        return self::error();
    }

//--------------------------------------------------------
// Functions to export database
//--------------------------------------------------------
// the following functions is for purpose of exporting
// data into folder database/backup

    /**
     * Export the Database.
     */
    public static function export()
    {
        return MysqlExporter::export();
    }

    /**
     * Get columns of data table.
     */
    public function getColmuns($table)
    {
        $table = self::table($table);
        $columns = [];
        //
        $data = Database::read("select COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '".Config::get('database.database')."' AND TABLE_NAME = '$table';");
        //
        foreach ($data as $key => $value) {
            $columns[] = $value['COLUMN_NAME'];
        }
        //
        return $columns;
    }

    /**
     * Get columns of data table.
     */
    public function getIncrement($table)
    {
        $table = self::table($table);
        $columns = [];
        //
        $data = Database::read("select COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '".Config::get('database.database')."' AND TABLE_NAME = '$table' AND EXTRA like '%auto_increment%';");
        //
        foreach ($data as $key => $value) {
            $columns[] = $value['COLUMN_NAME'];
        }
        //
        return $columns;
    }

    /**
     * Get columns of data table without auto increment columns.
     */
    public function getNormalColumn($table)
    {
        $all = self::getColmuns($table);
        $incs = self::getIncrement($table);
        //
        return Collection::except($incs, $all);
    }

    /**
     * Get the real name of table with prefix.
     */
    public function table($table)
    {
        if (Config::get('database.prefixing')) {
            return Config::get('database.prefixe').$table;
        }

        return $table;
    }
}
