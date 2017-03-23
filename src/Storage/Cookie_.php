<?php

namespace Vinala\Kernel\Storage ;

//use SomeClass;

/*
* Cookies surface
*
* @version 2.0
* @author Youssef Had
* @package Vinala\Kernel\Storage
* @since v3.3.0
*/
class Cookie
{

    //--------------------------------------------------------
    // Properties
    //--------------------------------------------------------

    /*
    * The cookies registers array
    *
    * @var array
    */
    protected static $register = array();

    /*
    * The register name
    *
    * @var string
    */
    protected static $register_name = 'VINALA_COOKIE_SURFACE' ;

    //--------------------------------------------------------
    // Constructor
    //--------------------------------------------------------

    function __construct()
    {
        //
    }

    /**
    * Initiate the cookie surface
    *
    * @return null
    */
    public static function ini()
    {
        static::load();
    }

    //--------------------------------------------------------
    // Functions
    //--------------------------------------------------------

    /**
    * Load the cookies register
    *
    * @return bool
    */
    protected static function load()
    {
        if( ! array_has($_SESSION , static::$register_name) )
        {
            $_SESSION[static::$register_name] = [];
        }

        static::$register = $_SESSION[static::$register_name];

        return true;
    }

    
    /**
    * Save the cookies register
    *
    * @param string $name
    * @return bool
    */
    protected static function save($name)
    {
        
        return ;
    }


    /**
    * Set new cookie
    *
    * @param 
    * @param 
    * @return 
    */
    public static function name()
    {
        
        return ;
    }

}