<?php

namespace Vinala\Lumos\Response;

use Vinala\Kernel\Foundation\Application;
use Vinala\Kernel\Setup\Documentations\Database;

/**
 * class to reponse lumos config commands.
 */
class ConfigSetting
{
    /**
     * configure database.
     *
     * @param string $server
     * @param string $database
     * @param string $user
     * @param string $password
     *
     * @return bool
     */
    public static function database()
    {
        $args = func_get_args();
        //
        switch ($args[0]) {
            case 'mysql': return self::mysql($args[1], $args[2], $args[3], $args[4], $args[5]); break;

            default:
                // code...
                break;
        }
    }

    /**
     * function to set Mysql server config params.
     *
     * @param string $host
     * @param string $database
     * @param string $user
     * @param string $password
     * @param string $prefix
     *
     * @return
     */
    public static function mysql($host, $database, $user, $password, $prefix = null)
    {
        if (is_null($prefix)) {
            $prefixing = 'false';
            $prefix = 'ysf';
        } else {
            $prefixing = 'true';
        }
        //
        $content = Database::set('mysql', $host, $database, $user, $password, $prefixing, $prefix);
        //
        file_put_contents(Application::$root.'config/database.php', $content, 0);
        //
        return true;
    }
}
