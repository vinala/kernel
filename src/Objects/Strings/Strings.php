<?php

namespace Vinala\Kernel\Objects;

use Vinala\Kernel\Objects\Strings\Exception\StringOutIndexException;
use Vinala\Kernel\Objects\Table;

/**
* String Trim Consts
**/
define('TRIM_BOTH', 'both');
define('TRIM_END', 'end');
define('TRIM_START', 'start');


/**
* Strings Class
*/
class Strings
{
	public static function length($string)
		{
			return strlen($string);
		}

	public static function splite($string,$limit)
		{
			return explode($limit, $string);
		}

	public static function concat()
		{
			$args=func_get_args();
			$string="";
			foreach ($args as $value) {
				$string.=$value;
			}
			return $string;
		}

	public static function compare($string1,$string2,$ignoreCase=true)
		{
			if($ignoreCase)
			{
				if(strcasecmp($string1,$string2)==0) return true;
				else return false;
			}
			else
			{
				if(strcmp($string1,$string2)==0) return true;
				else return false;
			}
		}

	public static function join($array,$separator,$startIndex=0,$count=-1)
		{
			$string="";
			//
			$end= $count==-1 ? Table::count($array) : $count;
			//
			for ($i=$startIndex; $i < $end ; $i++) {
				if($i==($end-1)) $string.=$array[$i];
				else echo $string.=$array[$i].$separator;
			}
			//
			return $string;
		}

	public static function replace($target,$search,$object)
		{
			return str_replace($search, $object, $target);
		}

	public static function contains($string,$substring)
		{
			if(strpos($string,$substring) !== false) return true;
			else return false;
		}

	public static function at($string,$index)
		{
			if(self::lenght($string)>=($index+1))
				return $string[$index];
			else return false;
		}

	public static function insert($string,$new,$index)
		{
			$str1="";
			$str2="";
			//
			if(self::isIndexIN($string,$index))
			{
				for ($i=0; $i < ($index) ; $i++) {
					$str1.=$string[$i];
				}
				//
				for ($i=($index); $i < Strings::lenght($string) ; $i++) {
					$str2.=$string[$i];
				}
				//
				return $str1.$new.$str2;
			}
			else throw new StringOutIndexException();
		}

	public static function subString($string,$indexStart,$count = null)
		{
			return mb_substr($string, $indexStart, $count, 'UTF-8');

			if(self::checkIndex($string,$indexStart))
			{
				$str="";
				for ($i=$indexStart; $i < ($indexStart+$count) ; $i++) {
					$str.=$string[$i];
				}
				return $str;
			}			
		}

	static function checkIndex($string,$index)
		{
			if(self::isIndexIN($string,$index)) return true;
			else throw new StringOutIndexException();
		}

	static function isIndexIN($string,$index)
		{
			if(Strings::lenght($string)>($index+1)) return true;
			else return false;
		}

	static function trimCollShars($param)
		{
			$string="";
			if(is_array($param)) foreach ($param as $value) $string.=$value;
			else if(is_string($param)) $string=$param;
			return $string;
		}

	public static function trim($string,$chars=null,$side=TRIM_BOTH)
		{
			if( $side == TRIM_START)
			{
				if(is_null($chars)) return ltrim($string);
				else return ltrim($string,self::trimCollShars($chars));
			}
			else if( $side == TRIM_END)
			{
				if(is_null($chars)) return rtrim($string);
				else return rtrim($string,self::trimCollShars($chars));
			}
			else if( $side == TRIM_BOTH)
			{
				if(is_null($chars)) return trim($string);
				else return trim($string,self::trimCollShars($chars));
			}
		}

	public static function toLower($value)
		{
			return strtolower($value);
		}

	public static function toUpper($value)
		{
			return strtoupper($value);
		}

	public static function firstUpper($value)
		{
			return ucfirst($value);
		}

	public static function firstsUpper($value)
		{
			return ucwords($value);
		}


	/**
	* Check if string starts with another string of collection of strings
	*
	* @param string $string
	* @param string|array $substring
	* @return bool
	*/
	public static function startsWith($string , $substrings)
	{
		if(is_array($substrings))
		{
			foreach ((array) $substrings as $substring) 
			{
	            if ($substring != '' && mb_strpos($string, $substring) === 0) 
	            {
	                return true;
	            }
	        }
		}
		elseif(is_string($substrings))
		{
			if ($substrings != '' && mb_strpos($string, $substrings) === 0) 
            {
                return true;
            }
		}

        return false;
	}

	/**
	* Check ifstring ends with another string of collection of strings
	*
	* @param string $string
	* @param string|array $substring
	* @return bool
	*/
	public static function endsWith($string , $substrings)
	{
		if(is_array($substrings))
		{
			foreach ((array) $substrings as $substring) 
			{
	            if ((string) $substring === static::subString($string, -static::length($substring))) 
	            {
	                return true;
	            }
	        }
		}
		elseif(is_string($substrings))
		{
			if ((string) $substring === static::subString($string, -static::length($substring))) 
            {
                return true;
            }
		}

        return false;
	}
	
	
}
