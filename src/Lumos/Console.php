<?php

namespace Vinala\Kernel\Console;

use Symfony\Component\Console\Application as Ap;

class Console
{
    // const note = 'note';
    const ok = 'success';
    const err = 'failure';
    const war = 'warning';
    const rmq = 'note';
    const lst = 'list';
    const nn = 'nn';
    //
    public static $application;

    /**
     * User commands.
     */
    protected static $userCommands;

    /**
     * Kernel commands.
     */
    protected static $kernelCommands;

    public static function run()
    {
        self::$application = new Ap();
        //
        self::addCommands(self::$application);
        //
        self::$application->run();
    }

    public static function color($status, $text = null)
    {
        $text = is_null($text) ? ' >> ' : $text;
        $out = '';
        //
        switch ($status) {
            case 'success':    $out = '[1;32m'; break;    //Green background
            case 'failure':    $out = '[1;31m'; break;    //Red background
            case 'warning':    $out = '[1;33m'; break;    //Yellow background
            case 'note':        $out = '[1;34m'; break;    //Blue background
            case 'list':        $out = '[1;36m'; break;    //cyan background
            case 'nn':        $out = '[1;30m'; break;        //black background
        }
        //
        return chr(27)."$out"."$text".chr(27).'[0m';
    }

    public static function setMessage($text, $status)
    {
        return self::color($status).$text;
    }

    protected static function addCommands($app)
    {
        self::AddUserCommands($app);
        self::AddKernelCommands($app);
    }

    public static function setCyan($text)
    {
        return chr(27).'[1;36m'."$text".chr(27).'[0m';
    }

    /**
     * Add all kernel command classes to console.
     */
    public static function AddKernelCommands($app)
    {
        self::setKernelClasses();
        // die(var_dump(self::$kernelCommands));
        //
        foreach (self::$kernelCommands as $value) {
            $app->add(new $value());
        }
    }

    /**
     * Add all user command classes to console.
     */
    public static function AddUserCommands($app)
    {
        self::setUserClasses();
        //
        if (!is_null(self::$userCommands)) {
            foreach (self::$userCommands as $value) {
                $app->add(new $value());
            }
        }
    }

    /**
     * Search for commmand classes of user.
     */
    public static function setUserClasses()
    {
        $namespace = "Vinala\App\Support\Lumos";
        //
        foreach (get_declared_classes() as $value) {
            if (str_contains($value, $namespace)) {
                self::$userCommands[] = $value;
            }
        }
    }

    /**
     * Search for commmand classes of kernel.
     */
    public static function setKernelClasses()
    {
        $namespace = "Vinala\Kernel\Console\Commands";
        //
        foreach (get_declared_classes() as $value) {
            if (str_contains($value, $namespace)) {
                self::$kernelCommands[] = $value;
            }
        }
    }

    /**
     * Search for commmand classes of user.
     */
    public static function getUserClasses()
    {
        $classes = [];
        //
        $namespace = "Vinala\App\Support\Lumos";
        //
        foreach (get_declared_classes() as $value) {
            if (str_contains($value, $namespace)) {
                $classes[] = $value;
            }
        }

        return $classes;
    }

    /**
     * Search for commmand classes of kernel.
     */
    public static function getKernelClasses()
    {
        $classes = [];
        //
        $namespace = "Vinala\Kernel\Console\Commands";
        //
        foreach (get_declared_classes() as $value) {
            if (\Strings::contains($value, $namespace)) {
                $classes[] = $value;
            }
        }

        return $classes;
    }
}
