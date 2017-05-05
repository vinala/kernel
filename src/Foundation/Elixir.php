<?php

namespace Vinala\Kernel\Foundation;

//use SomeClass;

/**
 * The Elixir of the framework.
 *
 * @version 1.0
 *
 * @author Youssef Had
 *
 * @since v3.3.0
 */
class Elixir
{
    //--------------------------------------------------------
    // Properties
    //--------------------------------------------------------

    /**
     * The Elixir SHA.
     *
     * @var string
     */
    private static $_SHA = '';

    //--------------------------------------------------------
    // Constructor
    //--------------------------------------------------------

    public function __construct()
    {
        //
    }

    //--------------------------------------------------------
    // Functions
    //--------------------------------------------------------

    /**
     * Check if Elixir allowed.
     *
     * @return bool
     */
    protected static function check()
    {
        if (self::remote() != self::$_SHA) {
            return false;
        }

        return true;
    }
}
