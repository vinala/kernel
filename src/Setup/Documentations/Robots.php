<?php

namespace Vinala\Kernel\Setup\Documentations;

use Vinala\kernel\Foundation\Application;

class Robots
{
    public static function set($hide = true)
    {
        return self::write(self::count($hide));
    }

    public static function count($hide)
    {
        return "User-agent: *\nDisallow:".($hide ? ' / ' : '');
    }

    public static function write($count)
    {
        return file_put_contents(Application::$root.'robots.txt', $count, 0);
    }
}
