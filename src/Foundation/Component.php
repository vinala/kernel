<?php

namespace Vinala\Kernel\Foundation;

use Vinala\Kernel\Config\Config;
use Vinala\Kernel\String\Strings;

/**
 * The components class.
 */
class Component
{
    /**
     * Check if the component is active.
     *
     * @param string $name the component name
     *
     * @return bool
     */
    public static function isOn($name)
    {
        $name = Strings::toLower($name);
        //
        return Config::get('components.'.$name);
    }

    /**
     * Load component list.
     *
     * @return array
     */
    public static function load()
    {
        $configParams = Config::all();
        $compnentParams = $configParams['components'];

        return $compnentParams;
    }
}
