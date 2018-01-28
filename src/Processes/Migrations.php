<?php

namespace Vinala\Kernel\Process;

use Exception;
use Vinala\Kernel\Config\Config;
use Vinala\Kernel\Database\Database;
use Vinala\Kernel\Database\Migration;
use Vinala\Kernel\Database\Schema;
use Vinala\Kernel\Foundation\Application;

/**
 * Migrations class.
 */
class Migrations extends Process
{
    public static function exec($file = null, $rt = null)
    {
        Schema::ini();
        //
        $root = is_null($rt) ? Process::root : $rt;

        if (is_null($file)) {
            //
            $r = glob($root.'database/schema/*.php');
            //
            $pieces = [];
            $pieces1 = [];
            $pieces2 = [];
            //
            $time = '';
            $name = '';
            //
            $f = [];
            foreach ($r as $key) {
                $pieces = explode('database/schema/', $key);
                $pieces1 = explode('_', $pieces[1]);
                $time = $pieces1[0];
                $p = explode('.', $pieces1[1]);
                $name = $p[0];
                $f[] = $pieces1[0];
                $pieces2[] = $pieces[1];
                $full_name = $pieces1[0].'_'.$name;
            }
            //
            $mx = max($f);
            //
            $ind = 0;
            $i = 0;
            //
            foreach ($pieces2 as $value) {
                if (strpos($value, $mx) !== false) {
                    $ind = $i;
                }

                $i++;
            }
            $link = $r[$ind];
        //
        } else {
            $link = $root."database/schema/$file.php";
            $segemnts = explode('_', $file);
            $time = $segemnts[0];
            $name = $segemnts[1];
            $full_name = $file;
        }

        include_once $link;

        if (up()) {
            $full_name = $time.'_'.$name;
            if (Schema::existe(Config::get('database.migration'))) {
                self::updateRow('executed', $name, $time);
            }
            Migration::updateRegister($full_name, 'exec', $root);

            return true;
        } else {
            false;
        }
    }

    public static function set($name, $Unixtime, $Datetime)
    {
        $txt = "<?php\n\n";
        $txt .= "/*\n* @date : ".$Datetime.'('.$Unixtime.")\n* @name : ".$name."\n*/\n\n\n";
        $txt .= "/**\n* Run the schemas.\n*/\n";
        $txt .= "function up()\n{\n/*\treturn Schema::create('$name',function(".'$tab'.")\n\t{\n\t\t";
        $txt .= '$tab->id('."'$name"."_id'".");\n\t\t".'$tab->string('."'name'".");\n\t});*/";
        $txt .= "\n}\n\n";
        $txt .= "/**\n* Reverse the schemas.\n*/\n";
        $txt .= "function down()\n{\n\t// return Schema::drop('$name');\n";
        $txt .= "}\n\n";
        //
        return $txt;
    }

    public static function create()
    {
        Schema::create(Config::get('database.migration'), function ($tab) {
            $tab->id('pk_schema');
            $tab->string('name_schema');
            $tab->timestamp('date_schema');
            $tab->string('status_schema');
            $tab->string('type_schema');
        });
    }

    public static function add($name, $rt = null)
    {
        Schema::ini();
        //
        $Datetime = date('Y/m/d H:i:s', time());
        $Unixtime = time();
        //
        $root = is_null($rt) ? Process::root : $rt;
        //
        $myfile = fopen($root.'database/schema/'.$Unixtime.'_'.$name.'.php', 'w');
        //
        fwrite($myfile, self::set($name, $Unixtime, $Datetime));
        fclose($myfile);
        //
        if (!Schema::existe(Config::get('database.migration'))) {
            self::create();
        }
        //
        self::addRow($name, $Unixtime);
        //
        Migration::updateRegister($Unixtime.'_'.$name, 'init', $root);
        //
        return $Unixtime;
    }

    public static function rollback($rt = null)
    {
        Schema::ini();
        //
        $Root = is_null($rt) ? Process::root : $rt;
        //
        $r = glob($Root.'database/schema/*.php');
        //
        $pieces = [];
        $pieces1 = [];
        $pieces2 = [];
        $full_names = [];
        //
        $time = '';
        $name = '';
        //
        $f = [];
        foreach ($r as $key) {
            $pieces = explode('database/schema/', $key);
            $pieces1 = explode('_', $pieces[1]);
            $time = $pieces1[0];
            $p = explode('.', $pieces1[1]);
            $name = $p[0];
            $f[] = $pieces1[0];
            $pieces2[] = $pieces[1];
            //
            $full_names = $pieces1[0].'_'.$name;
        }
        $mx = max($f);
        //
        $ind = 0;
        $i = 0;
        //
        foreach ($pieces2 as $value) {
            if (strpos($value, $mx) !== false) {
                $ind = $i;
            }

            $i++;
        }
        $link = $r[$ind];
        //

        include_once $link;

        if (down()) {
            if (Schema::existe(Config::get('database.migration'))) {
                self::updateRow('rolledback', $name, $time);
            }

            $full_names = $time.'_'.$name;
            Migration::updateRegister($full_names, 'rollback', $Root);

            return true;
        } else {
            false;
        }
    }

    /**
     * add new row to migration datatable.
     */
    protected static function addRow($name, $time)
    {
        $table = self::getMigrationTable();
        Database::exec("insert into $table (name_schema,date_schema,status_schema,type_schema) values('$name','$time','init','table')");
    }

    /**
     * Update the existing row in migration datatable.
     */
    protected static function updateRow($status, $name, $time)
    {
        $table = self::getMigrationTable();
        Database::exec("update $table set status_schema='$status' where name_schema='$name' and date_schema='$time'");
    }

    /**
     * the name of dataTable of migrations.
     */
    protected static function getMigrationTable()
    {
        if (Config::get('database.prefixing')) {
            return Config::get('database.prefixe').Config::get('database.migration');
        } else {
            return Config::get('database.migration');
        }
    }

    public static function rollback_cos() /* Beta */
    {
        $Root = '../';
        $r = glob('../database/schema/*.php');

        $r2 = [];
        $r2 = [];
        foreach ($r as $value) {
            $temp1 = explode('schemas/', $value);
            $temp2 = explode('_', $temp1[1]);
            $temp3 = explode('.', $temp2[1]);
            $ex = $temp3[0];
            //

            if ($ex == $_POST['exec_cos_migrate_select']) {
                $r2[] = $ex;
                $r3[] = $temp2[0];
            }
        }
        $v = '';
        //
        if (count($r2) > 1) {
            for ($i = 1; $i < count($r2); $i++) {
                error_log($r3[$i].'*/*'.$r3[$i - 1]);
                if ($r3[$i] >= $r3[$i - 1]) {
                    $v = '../database/schema/'.$r3[$i].'_'.$r2[$i].'.php';
                    $full_name = $r3[$i].'_'.$r2[$i];
                }
            }
        } else {
            $v = '../database/schema/'.$r3[0].'_'.$r2[0].'.php';
            $full_name = $r3[0].'_'.$r2[0];
        }

        try {
            include_once $v;
            if (down()) {
                Migration::updateRegister($full_name, 'rollback', $Root);
                echo 'Schéma annulée';
            } else {
                echo Database::execErr();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public static function exec_cos() /* Beta */
    {
        $Root = '../';
        $r = glob('../database/schema/*.php');

        $r2 = [];
        $r2 = [];
        foreach ($r as $value) {
            $temp1 = explode('schemas/', $value);
            $temp2 = explode('_', $temp1[1]);
            $temp3 = explode('.', $temp2[1]);
            $ex = $temp3[0];
            //
            if ($ex == $_POST['exec_cos_migrate_select']) {
                $r2[] = $ex;
                $r3[] = $temp2[0];
            }
        }
        $v = '';
        $full_name = '';
        //
        if (count($r2) > 1) {
            for ($i = 1; $i < count($r2); $i++) {
                error_log($r3[$i].'*/*'.$r3[$i - 1]);
                if ($r3[$i] >= $r3[$i - 1]) {
                    $v = '../database/schema/'.$r3[$i].'_'.$r2[$i].'.php';
                    $full_name = $r3[$i].'_'.$r2[$i];
                }
            }
        } else {
            $v = '../database/schema/'.$r3[0].'_'.$r2[0].'.php';
            $full_name = $r3[0].'_'.$r2[0];
        }

        try {
            include_once $v;
            if (up()) {
                Migration::updateRegister($full_name, 'exec', $Root);
                echo 'Schéma executé';
            } else {
                echo Database::execErr();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     *   Listing all schemas.
     */
    public static function ListAll()
    {
        $schema = glob(Application::$root.'database/schema/*.php');
        //
        return $schema;
    }
}
