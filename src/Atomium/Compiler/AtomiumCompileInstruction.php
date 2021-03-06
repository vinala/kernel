<?php

namespace Vinala\Kernel\Atomium\Compiler;

use Vinala\Kernel\Collections\Collection;
use Vinala\Kernel\String\Strings;

class AtomiumCompileInstruction
{
    /**
     * To replace open tag end it's end with PHP tag.
     *
     * @var string
     */
    public static function openTag($script, $openTag, $phpOpenTag, $endOpenTag, $phpEndOpenTag)
    {
        $data = Strings::splite($script, $openTag);
        //
        $output = $data[0];
        //
        for ($i = 1; $i < Collection::count($data); $i++) {
            $output .= $phpOpenTag;
            //
            $next = Strings::splite($data[$i], $endOpenTag);
            $output .= $next[0].$phpEndOpenTag;
            //
            for ($j = 1; $j < Collection::count($next); $j++) {
                if ($j == (Collection::count($next) - 1)) {
                    $output .= $next[$j];
                } else {
                    $output .= $next[$j].$endOpenTag;
                }
            }
        }

        return $output;
    }

    /**
     * To replace close tag end it's end with PHP tag.
     *
     * @var string
     */
    public static function closeTag($script, $closeTag, $phpCloseTag)
    {
        return str_replace($closeTag, $phpCloseTag, $script);
    }

    /**
     * To run the compiler.
     *
     * @var string
     */
    public static function run($script)
    {
        $script = self::openTag($script);
        //
        $script = self::closeTag($script);
        //
        return $script;
    }
}
