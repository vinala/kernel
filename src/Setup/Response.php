<?php

namespace Vinala\Kernel\Setup;

use Vinala\Kernel\Foundation\Application;
use Vinala\Kernel\Setup\Documentations\App;
use Vinala\Kernel\Setup\Documentations\Loggin;
use Vinala\Kernel\Setup\Documentations\Robots;
use Vinala\Kernel\Setup\Documentations\Security;
use Vinala\Kernel\Setup\Documentations\Translator;

/**
 * class de controller helloController.
 */
class Response
{
    /**
     * set global setup.
     */
    public static function setGlob_step()
    {
        $project = $_POST['project_name'];
        $name = $_POST['dev_name'];
        //
        if (isset($_POST['ckeck_loggin'])) {
            $loggin = true;
        } else {
            $loggin = false;
        }
        //
        if (isset($_POST['ckeck_maintenance'])) {
            $maintenance = 'true';
        } else {
            $maintenance = 'false';
        }
        //
        if (isset($_POST['ckeck_search'])) {
            $robot = true;
        } else {
            $robot = false;
        }
        //
        if (!Application::$isTest) {
            $appCont = App::set($name, $project, true);
            $translatorCont = Translator::set('en');
            $logginCont = Loggin::set($loggin);
            Robots::set($robot);
            //
            file_put_contents(Application::$root.'config/app.php', $appCont, 0);
            file_put_contents(Application::$root.'config/lang.php', $translatorCont, 0);
            file_put_contents(Application::$root.'config/loggin.php', $logginCont, 0);
            //
            echo 'true';
        }
    }

    public static function setSecur_step($sec_1, $sec_2)
    {
        if (!Application::$isTest) {
            $content = Security::set($sec_1, $sec_2);
            //
            file_put_contents(Application::$root.'config/security.php', $content, 0);
            //
            return true;
        }
    }
}
