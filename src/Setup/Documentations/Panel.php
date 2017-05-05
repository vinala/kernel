<?php

namespace Vinala\Kernel\Setup\Documentations;

class Panel
{
    protected static function panelDoc($index)
    {
        $doc = [
            'activation'    => "\n\t|  To define if you wanna give access to the \n\t|  panel or not , for your security if you \n\t|  complete building your app, please turn \n\t|  this off",
            'route'         => "\n\t|  Route for panel, for your security please change it",
            'path'          => "\n\t|  Here the path of the panel index, you can \n\t|  search in the internet to change the panel, \n\t|  for your security you should change the panel\n\t|  folder name",
            'passwords'     => "\n\t|  Here are the passwords to access to the panel",
            'configuration' => "\n\t|  The framework will set true if you passed \n\t|  the setup",
            'ajax'          => "\n\t|  This is links of ajax functions",
            ];
        //
        return $doc[$index]."\n\t*/";
    }

    protected static function panelTitles($index)
    {
        $titles = [
            'activation'    => 'Panel Activation',
            'route'         => 'Panel Route',
            'path'          => 'Panel Path',
            'passwords'     => 'Panel Passwords',
            'configuration' => 'Setup',
            'ajax'          => 'Ajax Routes',
            ];
        //
        $sep = "\n\t|----------------------------------------------------------";

        return "\n\n\t/*".$sep."\n\t| ".$titles[$index].$sep;
    }

    protected static function panelRow($index, $param)
    {
        $title = self::panelTitles($index);
        $doc = self::panelDoc($index);
        //
        return $title.$doc."\n\n\t$param\n";
    }

    public static function set($state, $route, $pass_1, $pass_2)
    {
        $activation = self::panelRow('activation', "'enable'=> $state,");
        $route = self::panelRow('route', "'route'=>'$route',");
        $path = self::panelRow('path', "'path'=>'vendor/vinala/panel/index.php',");
        $passwords = self::panelRow('passwords', "'password1'=>'$pass_1',\n\t'password2'=>'$pass_2',");
        $configuration = self::panelRow('configuration', "'setup' => true,");
        $ajax = self::panelRow('ajax', "'ajax' => array(\n\n\t\t// for new seeds\n\t\t\t'new_seed' => 'new_seed',\n\n\t\t// to exec migrations\n\t\t\t'exec_migration' => 'exec_migration',\n\n\t\t// to rollback migrations\n\t\t\t'rollback_migration' => 'rollback_migration', \n\n\t\t// for new migrations\n\t\t\t'new_migration' => 'new_migration',\n\n\t\t// for new controllers\n\t\t\t'new_controller' => 'new_controller',\n\n\t\t// for new language folder\n\t\t\t'new_dir_lang' => 'new_dir_lang',\n\n\t\t// for new language file\n\t\t\t'new_file_lang' => 'new_file_lang',\n\n\t\t// for new links file\n\t\t\t'new_link' => 'new_link',\n\n\t\t// for new models\n\t\t\t'new_model' => 'new_model',\n\n\t\t// for new views\n\t\t\t'new_view' => 'new_view',\n\n\t\t// to exec costume migrations\n\t\t\t'exec_cos_migration' => 'exec_cos_migration',\n\n\t\t// to rollback costume migrations\n\t\t\t'rollback_cos_migration' => 'rollback_cos_migration',\n\t),");
        //
        return "<?php \n\nreturn array(\n\t".$activation.$route.$path.$passwords.$configuration.$ajax."\n);";
    }
}
