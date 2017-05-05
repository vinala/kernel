<?php

namespace Vinala\Kernel\Filesystem;

//use SomeClass;

/**
 * Class File for Filesystem.
 *
 * @version 1.0
 *
 * @author Youssef Had
 *
 * @since v3.3.0
 */
class File
{
    //--------------------------------------------------------
    // Properties
    //--------------------------------------------------------

    /**
     * Instance fo Filesystem class.
     *
     * @var Vinala\Kernel\Filesystem\Filesystem
     */
    protected static $instance = null;

    //--------------------------------------------------------
    // Functions
    //--------------------------------------------------------

    /**
     * Magic function.
     *
     * @param
     * @param
     *
     * @return
     */
    public static function __callStatic($function, $args)
    {
        $mother = 'Vinala\Kernel\Filesystem\Filesystem';

        exception_if(!method_exists($mother, $function), \LogicException::class, "Call to undefined method File::$function()");

        $instance = static::getInstance($mother);

        return call_user_func_array([$instance, $function], $args);
    }

    /**
     * Set and get instance of Filesystem class.
     *
     * @return Vinala\Kernel\Filesystem\Filesystem
     */
    protected static function getInstance($class)
    {
        if (is_null(static::$instance)) {
            return static::$instance = instance($class);
        }

        return static::$instance;
    }
}
