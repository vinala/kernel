<?php

namespace Vinala\Kernel\Database;

use Vinala\Kernel\Collections\Collection;
use Vinala\Kernel\Filesystem\Filesystem;
use Vinala\Kernel\Foundation\Application;

/**
 * migaration class.
 */
class Migration
{
    protected static $schemas;

    public static function getAll($name)
    {
        $r = glob(Application::$root.'app/schemas/*.php');
        $r2 = [];
        foreach ($r as $value) {
            $temp = explode('_', $value);

            $temp2 = explode('.', $temp[1]);

            $r2[] = $temp2[0];
        }

        $r3 = array_unique($r2);
        //

        echo "<div class='form-group col-md-7' style='display:block'><select name=".$name." class='form-control'>";
        foreach ($r3 as $value) {
            echo "<option value='".$value."'>".$value.'</option>';
        }
        echo '</select></div>';
    }

    protected static function createRegister($root)
    {
        if (!(new Filesystem())->exists($root.'database/schema/.register')) {
            (new Filesystem())->put($root.'database/schema/.register', '');
        }
    }

    protected static function setRegister($array, $root)
    {
        self::createRegister($root);
        //
        $s = serialize($array);
        //
        file_put_contents($root.'database/schema/.register', $s);
        //
    }

    protected static function getRegister($root)
    {
        self::createRegister($root);
        //
        $f = file_get_contents($root.'database/schema/.register');
        $data = strlen($f) > 2 ? unserialize($f) : '';
        $data = !($data) ? [] : $data;
        //
        return $data;
    }

    public static function updateRegister($name, $state, $root)
    {
        $data = self::getRegister($root);

        //
        $existe = false;
        //

        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['name'] == $name) {
                $existe = true;
                $data[$i]['state'] = $state;
                $data[$i]['exec'] = time();
            }
        }
        //
        if (!$existe) {
            $data[] = ['name' => $name, 'state' => $state, 'exec' => time()];
        }

        //
        self::setRegister($data, $root);
        self::checkRegister($root);
        //
        return $data;
    }

    public static function checkRegister($root)
    {
        $data = self::getRegister($root);
        //
        $schemas = self::getSchemas($root);
        //
        // contains
        for ($i = 0; $i < Collection::count($data); $i++) {
            if (!Collection::contains($schemas, $data[$i]['name'])) {
                $data[$i]['state'] = 'droped';
                $data[$i]['exec'] = time();
            }
        }
        //
        self::setRegister($data, $root);
    }

    protected static function getSchemas($root)
    {
        $f = glob($root.'app/schemas/*.php');
        $sch = [];
        //
        foreach ($f as $value) {
            $t = explode('/', $value);
            $t = $t[Collection::count($t) - 1];
            $t = explode('.php', $t);
            $t = $t[0];
            $sch[] = $t;
        }
        //
        return $sch;
    }
}
