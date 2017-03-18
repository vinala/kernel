<?php

namespace Vinala\Kernel\Collections ;

//use SomeClass;

/**
* The array surface called List
*
* @version 2.0 
* @author Youssef Had
* @package Vinala\Kernel\Collections
* @since v3.3.0
*/
class Collection
{

    //--------------------------------------------------------
    // Properties
    //--------------------------------------------------------

    //

    //--------------------------------------------------------
    // Constructor
    //--------------------------------------------------------

    function __construct()
    {
        //
    }

    //--------------------------------------------------------
    // Functions
    //--------------------------------------------------------

    /**
    * Returns array elements count 
    *
    * @param array $array
    * @return int | book
    */
    public static function count($array)
    {
        if( ! is_null($array)) return count($array);
        return false;
    }

    /**
    * Get Element from array by dot aspect
    *
    * @param array $array
    * @param string $pattern
    * @return mixed
    */
    public static function get($array , $pattern)
    {
        if( ! is_array($array)) return null;
		//
		if (array_key_exists($pattern , $array)) return $array[$pattern];
		//
		foreach (explode('.', $pattern) as $segment) 
		{
            if ( is_array($array) && array_key_exists($segment , $array)) $array = $array[$segment];
            else return null;
        }
        //
		return null;
    }

    /**
    * Add element to an array 
    *
    * @param array $array
    * @param mixed $value
    * @param mixed $key
    * @return null
    */
    public static function add(&$array , $value , $key = null)
    {
        if( ! is_null($key)) $array[$key] = $value;
        else $array[] = $value;
    }

    /**
    * Add element to end of array  
    *
    * @param array $array
    * @param param[]
    * @return null
    */
    public static function push(&$array)
    {
        $params = func_get_arg();
        
        for ($i=1; $i < static::count($params); $i++) 
        { 
            array_push($array , $params[$i]);
        }
    }

    /**
    * Concat string elements in array
    *
    * @param array $array
    * @param string $separator
    * @return string
    */
    public static function concat(array $array,$separator = ' ')
    {
        $result = '';

        foreach ($array as $string ) 
        {
            if(is_string($string))
            {
                $result .= $string;
            }
        }

        return $result;
    }

    /**
    * Check if array contains a value
    *
    * @param array $array
    * @param mixed $value
    * @return bool
    */
    public static function contains($array , $value)
    {
        foreach ($array as $element) 
        {
            if($element == $value)
            {
                return true;
            }
        }

        return false;
    }

    /**
    * Copy element of an array to another array
    *
    * @param array $array
    * @param array $target
    * @return null
    */
    public static function copy($array , $target)
    {
        foreach ($array as $key => $element) 
        {
            self::add($target , $element , $key);
        }
    }

    /**
    * Check if array equal to another array
    *
    * @param array $array1
    * @param array $array2
    * @return bool
    */
    public static function equal(array $array1 , array $array2)
    {
        if (static::count($array1) != static::count($array2)) 
        {
            return false;
        } 
        else 
        {
            for ($i=0; $i < static::count($array1); $i++) 
            { 
                if($array1[$i] != $array2[$i])
                {
                    return false;
                }
            }
        }
        
        return true;
    }

    /**
    * Distinct element between two array
    *
    * @param array $array1
    * @param array $array2
    * @return array
    */
    public static function except($array1 , $array2)
    {
        $result = array();

        foreach ($array1 as  $key => $value) 
        {
			if( ! static::contains($array2,$value))
            {
                if(is_int($key)) 
                {
                    static::add($array,$value);
                }
				else 
                {
                    static::add($array,$value,$key);
                }
            }
		}

        foreach ($array2 as  $key => $value) 
        {
			if( ! static::contains($array1,$value) && ! self::contains($result,$value))
            {
                if(is_int($key)) 
                {
                    static::add($array,$value);
                }
				else 
                {
                    static::add($array,$value,$key);
                }
            }
		}

        return $result;
    }

    /**
    * Find value in array
    *
    * @param array $array
    * @param mixed $target
    * @return mixed
    */
    public static function findKey($array , $target)
    {
        foreach ($array as $key => $value)
        {
            if($value == $target)
            {
                return $key;
            }
        }
    }

    /**
    * Get the first element of array
    *
    * @param array $array
    * @return mixed
    */
    public static function first($array)
    {
        return array_values($array)[0]; ;
    }

    /**
    * Get the last element of array
    *
    * @param array $array
    * @return mixed
    */
    public static function last($array)
    {
        $data = array_values($array);

        return $data[static::count($data)-1];
    }

    /**
    * Pull the last element an element 
    *
    * @param array $array
    * @return mixed
    */
    public static function pullLast(&$array)
    {
        return array_pop($array);
    }

    /**
    * Pull the first element an element 
    *
    * @param array $array
    * @return mixed
    */
    public static function pullFirst(&$array)
    {
        return array_shift($array);
    }

    /**
    * check if array have a key from a given array using "dot" notation.
    *
    * @param array $array
    * @param string $key
    * @return bool
    */
    public static function exists(array $array , $key)
    {
		//
		if (array_key_exists($key , $array)) return true;
		//
		$keys = dot($key);
        //
        foreach ($keys as $key) 
        {
        	if(array_key_exists($key , $array))
        	{
        		$array = (array) $array[$key];
        		continue;
        	}
        	else return false;
        }
        //
        return true;
    }

}