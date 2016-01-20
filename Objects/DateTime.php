<?php 

namespace Fiesta\Core\Objects;

use Fiesta\Core\Config\Config;
use Fiesta\Core\Object\String;
use Carbon\Carbon;

/**
* DateTime class
*/
class DateTime
{
	/**
	 * set framework Timezone 
	 */
	public static function setTimezone()
	{
		date_default_timezone_set(Config::get('app.timezone'));
	}

	/**
	 * get framework Timezone 
	 */
	public static function getTimezone()
	{
		return date_default_timezone_get();
	}

	/**
	 * get current timestamp
	 */
	public static function current()
	{
		return time();
	}

	/**
	 * get now datetime
	 */
	public static function now()
	{
		return Carbon::now();
	}

	/**
	 * get today date
	 */
	public static function today()
	{
		return Carbon::today();
	}

	/**
	 * get tomorrow date
	 */
	public static function tomorrow()
	{
		return Carbon::tomorrow();
	}

	/**
	 * get yesterday date
	 */
	public static function yesterday()
	{
		return Carbon::yesterday();
	}

	/**
	 * create new date
	 */
	public static function create( $year=null , $month=null , $day=null , $hour=null , $min=null , $second=null )
	{
		return Carbon::create($year, $month, $day, $hour, $min, $second);
	}

	public static function datetime($timestamp=null,$vars=false)
	{
		$o1 = array();
		$o2=null;
		//
		if($vars)
		{
			if(is_null($timestamp)) $timestamp=time();
			//
			$o1["year"]=date("Y",$timestamp);
			$o1["month"]=date("n",$timestamp);
			$o1["day"]=date("j",$timestamp);
			$o1["hour"]=date("G",$timestamp);
			$o1["minute"]=date("i",$timestamp);
			$o1["second"]=date("s",$timestamp);
			//
			return $o1;
		}
		else
		{
			if(is_null($timestamp)) $timestamp=time();
			//
			$o2=date("Y/m/d H:i:s",$timestamp);
			//
			return $o2;
		}
	}

	public static function date($timestamp=null,$vars=false)
	{
		$o1 = array();
		$o2=null;
		//
		if($vars)
		{
			if(is_null($timestamp)) $timestamp=time();
			//
			$o1["year"]=date("Y",$timestamp);
			$o1["month"]=date("n",$timestamp);
			$o1["day"]=date("j",$timestamp);
			//
			return $o1;
		}
		else
		{
			if(is_null($timestamp)) $timestamp=time();
			//
			$o2=date("Y/m/d",$timestamp);
			//
			return $o2;
		}
	}

	public static function time($timestamp=null,$vars=false)
	{
		$o1 = array();
		$o2=null;
		//
		if($vars)
		{
			if(is_null($timestamp)) $timestamp=time();
			//
			$o1["hour"]=date("G",$timestamp);
			$o1["minute"]=date("i",$timestamp);
			$o1["second"]=date("s",$timestamp);
			//
			return $o1;
		}
		else
		{
			if(is_null($timestamp)) $timestamp=time();
			//
			$o2=date("G:i:s",$timestamp);
			//
			return $o2;
		}
	}
	/**
	 * Convert string datetime to array
	 */
	public static function parse($date)
	{
		return Carbon::parse($data);
	}

	public static  function next($day,$timestamp = null)
	{
		$vars = self::datetime($timestamp,true);
		if( $timestamp != null ) 
			Carbon::setTestNow(self::create($vars['year'],$vars["month"],$vars["day"],$vars["hour"],$vars["minute"],$vars["second"]));
		//
		return new Carbon('next '.$day);  
	}

	public static  function last($day,$timestamp = null)
	{
		$vars = self::datetime($timestamp,true);
		if( $timestamp != null ) 
			Carbon::setTestNow(self::create($vars['year'],$vars["month"],$vars["day"],$vars["hour"],$vars["minute"],$vars["second"]));
		//
		return new Carbon('last '.$day);  
	}


}