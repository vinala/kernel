<?php

namespace Vinala\Kernel\MVC;

use Vinala\Kernel\MVC\Views;

/**
* View mother class
*/
class View
{

    //--------------------------------------------------------
    // Properties
    //--------------------------------------------------------


    /**
    * The last view used by makefunction
    *
    * @var Vinala\Kernel\MVC\Views
    */
    protected static $view ;
    

    //--------------------------------------------------------
    // Functions
    //--------------------------------------------------------

    /**
    * Call and make a view
    *
    * @param string $name
    * @param array $data
    * @return Vinala\Kernel\MVC\Views
    */
    public static function make($name, $data = null, $nest = null)
    {
        self::$view = new Views;

        return self::$view->call($name, $data, $nest);
    }

    /**
    * Show a view
    *
    * @param Vinala\Kernel\MVC\Views $view
    * @return null
    */
    public static function show(Views $view)
    {
        return $view->show($view);
    }

    /**
    * Extend to child view
    *
    * @param string $name
    * @param array $data
    * @return null
    */
    public static function extend($name, $data = null)
    {
        return self::$view->call($name, $data)->show();
    }
    
    //------------------------------


    public static function get($value, $data = null)
    {
        return Views::get($value, $data);
    }

    public static function import($plugin, $value, $data = null)
    {
        return Views::import($plugin, $value, $data);
    }

    /**
    * Check if the view exists
    *
    * @param string $name
    * @return bool
    */
    public static function exists($name, $nest = null)
    {
        return instance(Views::class)->exists($name, $nest);
    }
}
