<?php

namespace Vinala\Kernel\Database\Connector;

use PDO;
use PDOException;
use Vinala\Kernel\Config\Config;
use Vinala\Kernel\Database\Connector\Exception\ConnectorException;
use Vinala\Kernel\String\Strings;

/**
 * Mysql Connector.
 */
class MysqlConnector
{
    /**
     * Mysql Connector.
     *
     * @param PDO
     */
    public $connector;

    /**
     * Constructor.
     *
     * @param string,string,string,string
     *
     * @return PDO
     */
    public function __construct($host = null, $database = null, $user = null, $password = null, $port = null)
    {
        $config = $this->config($host, $database, $user, $password, $port);
        //
        $dsn = 'mysql:host='.$config['host'].';port='.$config['port'].';dbname='.$config['database'];
        //
        try {
            $this->connector = new PDO(
                    $dsn,
                    $config['user'],
                    $config['password']
                );
            //
            $this->connector->exec('set names '.config('database.charset'));
            $this->connector->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new ConnectorException();
        }
        //
        return $this->connector;
    }

    /**
     * check if the host is localhost and replace it by adresse.
     *
     * @param string
     *
     * @return string
     */
    protected function setLocal($host)
    {
        return Strings::trim($host) == 'localhost' ? '127.0.0.1' : $host;
    }

    /**
     * get Connection configuration.
     *
     * @param string,string,string,string
     *
     * @return
     */
    protected function config($host, $database, $user, $password, $port)
    {
        //if(Config::get("database.host")=="" && Config::get("database.username")=="" && Config::get("database.password")=="" && Config::get("database.database")=="") throw new DatabaseArgumentsException();
        return [
            'host'     => $this->setLocal($host ? $host : Config::get('database.host')),
            'database' => $database ? $database : Config::get('database.database'),
            'user'     => $user ? $user : Config::get('database.username'),
            'password' => $password ? $password : Config::get('database.password'),
            'port'     => $port ? $port : Config::get('database.port'),
        ];
    }

    /**
     * Close the Mysql connection.
     */
    public function close()
    {
        $this->connector = null;
    }
}
