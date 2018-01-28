<?php

namespace Vinala\Kernel\Database\InOut\Mysql;

use Vinala\Kernel\Database\Database;
use Vinala\Kernel\Filesystem\Filesystem;

/**
 * Database Mysql Import class.
 *
 * @version 1.0
 *
 * @author Youssef Had
 *
 * @since v3.3.0
 */
class Importer
{
    //--------------------------------------------------------
    // Functions
    //--------------------------------------------------------

    /**
     * Get the last database save.
     *
     * @param string $name
     *
     * @return string
     */
    public static function last($name)
    {
        if (!$name) {
            $database = config('database.database');
            $path = root().'database/backup';
            $files = glob($path.'/*.sql');

            if (!is_null($files)) {
                for ($i = count($files) - 1; $i >= 0; $i--) {
                    $file = $files[$i];
                    //
                    $file = explode(root().'database/backup/'.$database.'_', $file);
                    $file = $file[1];
                    $file = explode('.sql', $file);
                    $file = $file[0];
                    //
                    if (is_numeric($file)) {
                        return root().'database/backup/'.$database.'_'.$file.'.sql';
                    }
                }
            }
        } elseif ($name) {
            return root().'database/backup/'.$name.'.sql';
        }
    }

    /**
     * Import the last save or custom save.
     *
     * @param string $name
     *
     * @return bool
     */
    public static function import($name = null)
    {
        $file = static::last($name);

        if (!is_null($file)) {
            $query = (new Filesystem())->get($file);
            //
            Database::exec($query);

            return true;
        }
    }
}
