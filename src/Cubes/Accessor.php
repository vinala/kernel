<?php

namespace Vinala\Kernel\Cubes;

//use SomeClass;

/**
 * Class to get cubes accessors.
 *
 * @version 1.0
 *
 * @author Youssef Had
 *
 * @since v3.3.0
 */
class Accessor
{
    //--------------------------------------------------------
    // Functions
    //--------------------------------------------------------

    /**
     * Redirect surface accessor.
     *
     * @return string
     */
    public static function redirect()
    {
        return \Vinala\Kernel\Access\Redirect::class;
    }

    /**
     * Exception accessor.
     *
     * @return string
     */
    public static function exception()
    {
        return \Vinala\Kernel\Logging\Exception::class;
    }

    /**
     * Redirector accessor.
     *
     * @return string
     */
    public static function redirector()
    {
        return \Vinala\Kernel\Http\Redirect\Redirector::class;
    }
}
