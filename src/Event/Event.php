<?php 

namespace Vinala\Kernel\Events ;

use Vinala\Kernel\Objects\Strings;
use Vinala\Kernel\Event\Exception\ManyListenersArgumentsException;

/**
* 
*/
class Event
{
	

	/**
	* List of Listners
	*
	* @var array 
	*/
	public static $listners = array() ;

	/**
	* Register all listners
	*
	* @return null
	*/
	public static function register()
	{
		$namespace = "Vinala\App\Events";

        foreach (get_declared_classes() as $value)
            if(Strings::contains($value,$namespace)) 
            {
            	$name = self::getName($value);

            	$events = $value::getEvents();

            	if( ! is_null($events))
	            	foreach ($events as $key => $value) 
	            	{
	            		$data[$name.".".$key] = $value;
	            	}

	            self::$listners = array_collapse([$data , self::$listners]);
            }
	}

	/**
	* Get the listner name
	*
	* @param string $name
	* @return string
	*/
	protected static function getName($name)
	{
		$segements = explode('\\', $name);

		return array_pop($segements);
	}
	

	/**
	* Fire a trigger
	*
	* @param 
	* @param 
	* @return 
	*/
	public static function trigger()
	{
		$args = func_get_args();

		//Check if trigger have parrams
		$haveParams = count($args) > 1 ? true : false ;

		//Get events
		$events = self::splite($args[0]);

		if( $haveParams && count($events) > 1 )
		{
			throw new ManyListenersArgumentsException();
		}

		if(count($events) > 1) self::runMany($events);
		elseif(count($events) == 1) self::runOne($events , array_except($args , 0));

		return true ;
	}

	/**
	* Get events from event pattern
	*
	* @param mixed $pattern
	* @return array
	*/
	protected static function splite($pattern)
	{
		if(is_array($pattern))
		{
			$events = array();

			foreach ($pattern as $value) 
			{
				$events = array_collapse([$events , self::extract($value) ]);
			}

			return $events;
		}
		elseif(is_string($pattern))
		{
			return self::extract($pattern);
		}
	}

	/**
	* Extract events from string pattern
	*
	* @param string $pattern
	* @return array
	*/
	protected static function extract($pattern)
	{
		if(str_contains($pattern , '|'))
		{
			$segements = explode('|', $pattern);

			$events[$segements[0]] = explode('.', $segements[1]);
		}
		else
		{
			$segements = explode('.', $pattern);

			$events[$segements[0]] = $segements[1];
		}

		return $events;
	}

	/**
	* Run and execute many events trigger
	*
	* @param array $events
	* @return bool
	*/
	public static function runMany($events)
	{
		foreach ($events as $key => $value) 
		{
			$name = '\Vinala\App\Events\\'.$key;

			$object = new $name();

			if(is_array($value))
			{
				foreach ($value as $function) 
				{
					$function = self::$listners[$key.'.'.$function];

					$object->$function();
				}
			}
			elseif(is_string($value))
			{
				$function = self::$listners[$key.'.'.$value];

				$object->$function();
			}
		}

		return true;
	}

	/**
	* Run and execute one event trigger
	*
	* @param array $events
	* @return bool
	*/
	public static function runOne($events , $args)
	{
		foreach ($events as $key => $value) 
		{
			$name = '\Vinala\App\Events\\'.$key;

			$object = new $name();

			$function = self::$listners[$key.'.'.$value];

			call_user_func_array(array($object, $function), $args);
		}

		return true;
	}
	
	
	
	
	
	
}