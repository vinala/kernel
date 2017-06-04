<?php

namespace Vinala\Kernel\Database;

use SeedsCaller as Caller;
use Vinala\Kernel\Collections\Collection;
use Vinala\Kernel\Database\Exception\SeedersEmptyException;

/**
 * Seeder class.
 */
class Seeder
{
    public static function call($name, $clear = true)
    {
        $tab = new $name();
        $tabl = $tab->table;
        //
        if ($clear) {
            $tabs = new DBTable($tabl);
            $tabs->clear();
        }
        //
        return self::execute($tab);
    }

    public static function ini()
    {
        $seeders = self::getSeeders();
        //
        $result = [];
        //
        foreach ($seeders as $value) {
            $result[$value] = self::call($value);
        }
        //
        return $result;
    }

    protected static function getSeeders()
    {
        $seeders = Caller::references();
        //
        if (empty($seeders)) {
            throw new SeedersEmptyException();
        }
        //
        return $seeders;
    }

    /**
     * Execute thh seeder.
     */
    protected static function execute($seeder)
    {
        $data = self::fill($seeder);
        //
        $table = new DBTable($seeder->table);

        return $table->insert($data);
    }

    /**
     * Fill data.
     */
    public static function fill($seeder)
    {
        $data = [];
        //
        if ($seeder->count <= 0) {
            foreach ($seeder->data() as $value) {
                // Collection::push($data, $value);
                array_push($data, $value);
            }
        } else {
            for ($i = 0; $i < $seeder->count; $i++) {
                // Collection::push($data, $seeder->data());
                array_push($data, $seeder->data());
            }
        }
        //
        return $data;
    }
}
