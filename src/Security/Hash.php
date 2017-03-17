<?php

namespace Vinala\Kernel\Security ;

//use SomeClass;

/**
* The Hash strings surface
*
* @version 2.0
* @author Youssef Had
* @package Vinala\Kernel\Securtiy
* @since v3.3.0
*/
class Hash
{

    //--------------------------------------------------------
    // Functions
    //--------------------------------------------------------

    /**
    * A function to create a hash string based on another string
    *
    * @param string $string
    * @return simplexml_load_string
    */
    public static function make($string)
    {
        $key1 = config('security.key1');
        $key2 = config('security.key2');

        return sha1(md5($string.'youssef'.$key1)).md5(sha1($string.'Vinala'.$key2));
    }

    /**
    * Check if a value is equal to hashed value
    *
    * @param string $value
    * @param string $hash
    * @return bool
    */
    public static function equals($value , $hash)
    {
        return ( static::make($value) == $hash );
    }

    /**
    * Create a hash string
    *
    * @param int $lenght
    * @return string
    */
    public static function create($lenght)
    {
        $characters = 'abcdefghijk01234lmnopq56789rstuxyvwz';
        $charLenght = strlen($characters);

        $string = '';
        for ($i=0; $i < $lenght; $i++) { 
            $index = mt_rand(0, $charLenght - 1);
            $string .= $characters[$index];
        }

        return $string;
    }

    /**
    * Create token for session surface
    *
    * @return string
    */
    public static function token()
    {
		return static::create(32);
    }
    

}