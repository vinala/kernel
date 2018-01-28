<?php

namespace Vinala\Kernel\Database;

use Vinala\Kernel\Config\Config;
use Vinala\Kernel\Database\Drivers\Driver;
use Vinala\Kernel\Database\Drivers\MysqlDriver;

/**
 * Database Class.
 */
class Database
{
    public static $server = null;
    public static $default = null;
    public static $serverData = [];
    public static $defaultData = [];

    /**
     * The driver used in database surface.
     *
     * @var Vinala\Kernel\Database\Drivers
     */
    private static $driver = null;

    /**
     * True if the framework use the database surface.
     *
     * @var bool
     */
    private static $enabled = false;

    public static function ini()
    {
        if (config('database.default') != 'none') {
            self::$driver = self::driver();
            self::$driver->connect();
            static::$enabled = true;
        }
    }

    //--------------------------------------------------------
    // Conenction functions
    //--------------------------------------------------------

    /**
     * Get if database surface is enabled.
     *
     * @return bool
     */
    public static function isEnabled()
    {
        return static::$enabled;
    }

    /**
     * Set the driver used in config files.
     *
     * @return Database
     */
    public static function driver()
    {
        switch (Config::get('database.default')) {
            case 'sqlite':
                // code...
                break;

            case 'mysql':
                    return new MysqlDriver();
                break;

            case 'pgsql':
                // code...
                break;

            case 'sqlsrv':
                // code...
                break;
        }
    }

    /**
     * Connect to driver database server.
     *
     * @return PDO
     */
    public static function connect()
    {
        return self::$driver->connect();
    }

    /**
     * Connect to default driver database server.
     *
     * @return PDO
     */
    public static function defaultConnection()
    {
        return self::connect();
    }

    /**
     * Connect to another driver database server.
     *
     * @param string, string, string, string
     *
     * @return PDO
     */
    public function newConnection($host, $database, $user, $password)
    {
        return self::$driver->connect($host, $database, $user, $password);
    }

    //--------------------------------------------------------
    // the Read and execute function
    //--------------------------------------------------------

    /**
     * run SQL query.
     *
     * @param string
     *
     * @return bool
     */
    public static function exec($sql)
    {
        return self::$driver->exec($sql);
    }

    /**
     * get data by SQL query
     * //assoc : 1 , array : 2.
     *
     * @param string, int
     *
     * @return array
     */
    public static function read($sql, $mode = Driver::INDEX)
    {
        return self::$driver->read($sql, $mode);
    }

    //--------------------------------------------------------
    // What's the title
    //--------------------------------------------------------

    /**
     * get number of rows of SQL Query.
     *
     * @param $sql string
     *
     * @return int
     *
     * @since 3.3.0
     */
    public static function count($sql)
    {
        return self::$driver->count($sql);
    }

    /**
     * return Mysqli error string.
     *
     * @return string
     *
     * @deprecated 3.3.0
     * @since 1.1.0
     */
    public static function execErr()
    {
        return self::$driver->execErr()[2];
    }

    /**
     * return PDO Error Info.
     *
     * @return string
     *
     * @since 3.3.0
     */
    public static function error()
    {
        return self::$driver->error();
    }

    /**
     * get number of rows of SQL Query (deprecated).
     *
     * @return string
     *
     * @deprecated 3.3.0
     * @since 1.1.0
     */
    public static function countS($sql)
    {
        return self::count($sql);
    }

    public static function res($sql)
    {
        return self::$driver->res($sql);
    }

    /**
     * Export the Database.
     *
     *
     * @param string $name
     *
     * @return bool
     */
    public static function export($name)
    {
        return self::$driver->export($name);
    }

    /**
     * Import the Database.
     *
     *
     * @param string $name
     *
     * @return bool
     */
    public static function import($name)
    {
        return self::$driver->import($name);
    }

    /**
     *  Get all columns.
     */
    public static function colmuns($table)
    {
        return self::$driver->getColmuns($table);
    }

    /**
     * get increment columns.
     */
    public static function incrementColumns($table)
    {
        return self::$driver->getIncrement($table);
    }

    /**
     * get normal columns without increments.
     */
    public static function normalColumns($table)
    {
        return self::$driver->getNormalColumn($table);
    }
}
