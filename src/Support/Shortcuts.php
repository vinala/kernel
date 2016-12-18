<?php 


use Vinala\Kernel\Config\Config;
use Vinala\Kernel\MVC\View;
use Vinala\Kernel\Router\Route;
use Vinala\Kernel\Objects\DateTime;
use Vinala\Kernel\Objects\Table;
use Vinala\Kernel\Translator\Lang;
use Vinala\Kernel\Foundation\Application;
use Vinala\Kernel\Foundation\Connector;
use Vinala\Kernel\Http\Input;
use Vinala\Kernel\Cubes\Cube;



//--------------------------------------------------------
// Global Shortcuts
//--------------------------------------------------------


if ( ! function_exists("root")) 
{
	/**
	* return Application::$root
	*
	* @param string $value
	* @return string
	*/
	function root()
	{
		return Application::$root;
	}	
}

if ( ! function_exists("path")) 
{
	/**
	* return Application::$path
	*
	* @param string $value
	* @return string
	*/
	function path()
	{
		return Application::$path;
	}	
}

if ( ! function_exists("need")) 
{
	/**
	* return Connector:need
	*
	* @param string $file
	* @return null
	*/
	function need($file)
	{
		return Connector::need($file);
	}	
}

if ( ! function_exists("needOnce")) 
{
	/**
	* return Connector:needOnce
	*
	* @param string $file
	* @return null
	*/
	function needOnce($file)
	{
		return Connector::needOnce($file);
	}	
}

if( ! function_exists("config"))
{
	/**
	* shortcut for Config::get function
	*		
	* @param string $key
	* @return mixed
	*/
	function config($key)
	{
		return Config::get($key);
	}
}


if ( ! function_exists("view")) 
{
	/**
	* shortcut for making view
	*
	* @param string $value
	* @param array $data
	* @return mixed
	*/
	function view( $value , array $data = null )
	{
		return View::make($value,$data);
	}	
}

if ( !function_exists( 'instance' ) ) 
{
	/**
	 * create instance of class
	 * 
	 * @param string $name
	 * @return mixed
	 */
	function instance()
	{
		$args = func_get_args();

		$name = array_shift($args);

		$reflect  = new ReflectionClass($name);
    	return $reflect->newInstanceArgs($args);

		// return new $name(...$args);
	}
}

if ( ! function_exists("validate")) 
{
	/**
	* shortcut for making validator
	*
	* @param array $data
	* @param array $rules
	* @return Vinala\Kernel\Validation\ValidationResult
	*/
	function validate( array $data , array $rules )
	{
		return Vinala\Kernel\Validation\Validator::make($data,$rules);
	}	
}

//--------------------------------------------------------
// Cubes
//--------------------------------------------------------

if ( !function_exists( 'cube' ) ) 
{
	/**
	 * create instance of cube
	 * 
	 * @param string $name
	 * @return mixed
	 */
	function cube()
	{
		$args = func_get_args();

		return Cube::setInstance($args);
	}
}

//--------------------------------------------------------
// Debuging
//--------------------------------------------------------

if ( !function_exists( 'di' ) ) {
	/**
	 * Show debug without die
	 * 
	 * @param string $value
	 * @return string
	 */
	function di($var)
	{
		-dg($var);
	}
}

if ( !function_exists( 'd' ) ) {
	/**
	 * Show debug with die
	 * 
	 * @param string $value
	 * @return string
	 */
	function d($var)
	{
		clean();
		!dg($var);

		die(1);
	}
}

if ( !function_exists( 'trace' ) ) {
	/**
	 * Show application trace
	 * 
	 * @return string
	 */
	function trace()
	{
		Kint::trace();

		die(1);
	}
}

//--------------------------------------------------------
// Routing
//--------------------------------------------------------


if ( ! function_exists("get")) 
{
	/**
	* shortcut for get routing
	*
	* @param string $uri
	* @param callback $callback
	* @param array $subdomains
	* @return mixed
	*/
	function get( $uri , $callback , $subdomains = null )
	{
		return Route::get($uri , $callback , $subdomains);
	}	
}

if ( ! function_exists("post")) 
{
	/**
	* shortcut for post routing
	*
	* @param string $uri
	* @param string $controller
	* @param array $data
	* @return mixed
	*/
	function post( $uri , $controller , $data = null )
	{
		return Route::post($uri , $controller , $data);
	}	
}


if ( ! function_exists("target")) 
{
	/**
	* shortcut for controller routing
	*
	* @param string $uri
	* @param string $controller
	* @param array $data
	* @return mixed
	*/
	function target( $uri , $controller , $data = null )
	{
		return Route::controller($uri , $controller , $data);
	}	
}

if ( ! function_exists("call")) 
{
	/**
	* shortcut for get routing
	*
	* @param string $uri
	* @param string $controller
	* @param array $data
	* @return mixed
	*/
	function call( $uri , $controller , $data = null )
	{
		return Route::call($uri , $controller , $data);
	}	
}

//--------------------------------------------------------
// DateTime
//--------------------------------------------------------


if ( ! function_exists("now")) 
{
	/**
	* shortcut for current timestamp
	*
	* @return int
	*/
	function now()
	{
		return DateTime::current();
	}	
}


if ( ! function_exists("clean")) 
{
	/**
	* shortcut for var_dump
	*
	* @return null
	*/
	function clean()
	{
		return ob_get_clean();
	}	
}


if ( ! function_exists("map")) 
{
	/**
	* shortcut for var_dump
	*
	* @return null
	*/
	function map($object)
	{
		var_dump($object);
	}	
}


if ( ! function_exists("out")) 
{
	/**
	* shortcut for die
	*
	* @return null
	*/
	function out($object)
	{
		die($object);
	}	
}


if ( ! function_exists("abort")) 
{
	/**
	* shortcut for showing exception
	*
	* @param string $msg
	* @return null
	*/
	function abort($msg = "" , $view = null)
	{
		//soon making http Exception
		throw cube('exception' , $msg , $view);
	}	
}

if ( ! function_exists("abort_if")) 
{
	/**
	* shortcut for showing exception if variable is true
	*
	* @param bool $expression
	* @return null
	*/
	function abort_if($expression)
	{
		if($expression) 
			throw new Exception();
	}	
}

if ( ! function_exists("exception_if")) 
{
	/**
	* shortcut for showing costum exception if $expression is true
	*
	* @param bool $expression
	* @param string $exception
	* @param string $message
	* @param string $view
	* @return null
	*/
	function exception_if($expression , $exception = 'exception' , $msg = '' , $view = null)
	{
		if($expression) 
		{
			throw $exception == 'exception' ? cube('exception' , $msg , $view) : instance($exception , $msg );
		}
	}	
}


//--------------------------------------------------------
// Array Shortcuts
//--------------------------------------------------------

if ( ! function_exists("array_get")) 
{
	/**
	* get deeply index on array
	*
	* @param array $array
	* @param string $index
	* @param string $default
	* @return mixed
	*/
	function array_get( $array , $index , $default = null )
	{
		if( ! is_array($array)) return $default;
		//
		if (is_null($index)) return $array;
		//
		if (array_key_exists($index , $array)) return $array[$index];
		//
		foreach (explode('.', $index) as $segment) 
		{
            if ( is_array($array) && array_key_exists($segment , $array)) $array = $array[$segment];
            else return $default;
        }
        //
		return $array;
	}	
}

if ( ! function_exists("array_add")) 
{
	/**
	* add item to array
	*
	* @param array $array
	* @param string $index
	* @param string $default
	* @return mixed
	*/
	function array_add( $array , $index = null , $value )
	{
		if( is_null($index) ) $array[] = $value;
		else $array[$index] = $value;
		//
		return $array;
	}	
}

if ( ! function_exists("array_collapse")) 
{
	/**
	* merge many arrays in one array
	*
	* @param array $array
	* @return mixed
	*/
	function array_collapse($array)
	{
		$results = [];
		//
		foreach ($array as $value) {
			$results = array_merge($results, $value);
		}
		//
		return $results;
	}	
}


if ( ! function_exists("array_forget")) 
{
	/**
	* remove array item or items from a given array using "dot" notation.
	*
	* @param array $array
	* @param array $keys
	* @return mixed
	*/
	function array_forget(&$array , $keys)
	{
		$original = &$array;
		$keys = (array) $keys;
		//
        if (count($keys) === 0) return;
        //
        foreach ($keys as $key) 
        {
        	if (array_key_exists($key , $array)) 
        	{
                unset($array[$key]);
                continue;
            }
            $array = &$original;

            $parts = dot($key);

            while (count($parts) > 1) 
            {
                $part = array_shift($parts);
                if (isset($array[$part]) && is_array($array[$part])) 
                    $array = &$array[$part];
                else continue 2;
            }

            unset($array[array_shift($parts)]);
        }

	}	
}


if ( ! function_exists("array_has")) 
{
	/**
	* check if array have a key from a given array using "dot" notation.
	*
	* @param array $array
	* @return mixed
	*/
	function array_has($array , $key)
	{
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


if ( ! function_exists("array_except")) 
{
	/**
	* remove array item or items from a given array using "dot" notation.
	*
	* @param array $array
	* @param mixed $keys
	* @return mixed
	*/
	function array_except(&$array , $keys)
	{
		array_forget( $array , $keys);
		//
		return $array;
	}	
}


//--------------------------------------------------------
// String Shortcuts
//--------------------------------------------------------

if ( ! function_exists("trans")) 
{
	/**
	* get deeply index on array
	*
	* @param string $key
	* @return string
	*/
	function trans( $key )
	{
		return Lang::get($key);
	}	
}

if ( ! function_exists("dot")) 
{
	/**
	* get array from string by dot notation
	*
	* @param string $key
	* @return array
	*/
	function dot( $key )
	{
		return Strings::splite($key , '.');
	}	
}

if ( ! function_exists("e")) 
{
	/**
	* return html entities value
	*
	* @param string $value
	* @return string
	*/
	function e( $value )
	{
		return htmlentities($value);
	}	
}

if ( ! function_exists("ee")) 
{
	/**
	* echo html entities value
	*
	* @param string $value
	* @return string
	*/
	function ee( $value )
	{
		echo htmlentities($value);
	}	
}

if ( ! function_exists("str_contains")) 
{
	/**
	* Check if string have substring
	*
	* @param string $string
	* @param string $substring
	* @return string
	*/
	function str_contains( $string , $substring )
	{
		if(strpos($string,$substring) !== false) return true;
		else return false;
	}	
}

if ( ! function_exists("request")) 
{
	/**
	* get Http vars
	*
	* @param string $key
	* @param string $default
	* @return string
	*/
	function request( $key , $default = null , $type = "request")
	{
		return Input::get($key , $default , $type);
	}	
}

//--------------------------------------------------------
// Redirect
//--------------------------------------------------------

if ( ! function_exists("back")) 
{
	/**
	* Redirect to previous location
	*
	* @return mixed
	*/
	function back()
	{
		return cube('redirect')->back();
	}	
}
