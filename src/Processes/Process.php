<?php

namespace Vinala\Kernel\Process;

use Vinala\Kernel\Time\DateTime;

/**
 * Language class.
 */
class Process
{
    const root = '';

    /**
     * Add Tracking doc bloc.
     *
     * @return string
     */
    protected static function track()
    {
        $result = '';

        if (config('lumos.tracking')) {
            $result .= ' * @author '.config('app.owner')."\n";
            $result .= ' * creation time : '.DateTime::now().' ('.time().')'."\n";
        }

        return $result;
    }

    /**
     * Generate a class documentation.
     *
     * @param string $main
     *
     * @return string
     */
    public static function docs($main)
    {
        $result = "/**\n * ".$main."\n *\n";

        $result .= self::track();

        $result .= " */\n";

        return $result;
    }
}
