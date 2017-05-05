<?php

namespace Vinala\Kernel\Process;

use Vinala\Kernel\Database\Database;
use Vinala\Kernel\Database\Seeder;
use Vinala\Kernel\Foundation\Application;

/**
 * Seeds class.
 */
class Seeds extends Process
{
    public static function exec()
    {
        return Seeder::ini();
    }

    public static function add($name, $table, $count, $rt = null)
    {
        $nom = $name;
        $Root = is_null($rt) ? Process::root : $rt;
        //
        if (!file_exists($Root."database/seeds/$nom.php")) {
            $myfile = fopen($Root."database/seeds/$nom.php", 'w');
            $txt = self::set($nom, $table, $count);
            //
            fwrite($myfile, $txt);
            fclose($myfile);
            //
            return true;
        } else {
            return false;
        }
    }

    public static function set($nom, $table, $count)
    {
        $colmuns = self::colmuns($table, ($count > 0));
        //
        $txt = "<?php\n\nuse Vinala\Kernel\Database\Seeder;\n\n";

        $txt .= self::docs("$nom seeder");
        $txt .= "*\n*/\nclass $nom extends Seeder\n{\n";

        //datatable name
        $txt .= "\t/*\n\t* Name of DataTable\n\t*/\n\tpublic ".'$table = "'.$table.'" ;'."\n\n";

        //datatable name
        $txt .= "\t/*\n\t* Number of rows to insert\n\t*/\n\tpublic ".'$count = '.$count.' ;'."\n\n";

        //run
        if ($count > 0) {
            $txt .= "\t/*\n\t* Set the data here to insert\n\t*/\n\tpublic function data()\n\t{\n\t\t".'return array('.$colmuns."\n\t\t\t".');'."\n\t}\n}";
        } else {
            $txt .= "\t/*\n\t* Set the data here to insert\n\t*/\n\tpublic function data()\n\t{\n\t\t"."return array(\n\t\t\tarray($colmuns\n\t\t\t),\n\t\t\tarray($colmuns\n\t\t\t),\n\t\t);\n\t}\n}";
        }

        return $txt;
    }

    public static function colmuns($table, $loop)
    {
        $colmuns = Database::normalColumns($table);
        $str = '';
        //
        foreach ($colmuns as $value) {
            if ($loop) {
                $str .= "\n\t\t\t\t".'"'.$value.'" => null ,';
            } else {
                $str .= "\n\t\t\t\t".'"'.$value.'" => null ,';
            }
        }
        //
        return $str;
    }

    /**
     *   Listing all schemas.
     */
    public static function ListAll()
    {
        $seeds = glob(Application::$root.'database/seeds/*.php');
        //
        return $seeds;
    }
}
