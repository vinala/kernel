<?php 

namespace Vinala\Kernel\Atomium\Compiler;

use Vinala\Kernel\String\Strings;
use Vinala\Kernel\Collections\Collection;

/**
* Class to compile One line instruction
*/
class AtomiumCompileInstructions
{

	/**
	 * To replace open tag end it's end with PHP tag
	 *
	 * @var string, string, string
	 * @return string
	 */
	protected static function compile($script, $phpFunc, $phpClose)
	{
		// $params = self::removeBrackets($script);
		$output = $phpFunc.$script.$phpClose;
		//
		return $output;
	}


	/**
	 * To remove brackets from params
	 *
	 * @var string
	 * @return string
	 */
	protected static function removeBrackets($value)
	{
		return substr($value,1,-1);
	}


	/**
	 * To compile de open tag
	 *
	 * @var string, string, string, string, string 
	 * @return string
	 */
	protected static function open($script, $openTag, $closeChar, $phpFunc, $phpClose)
	{
		//
		$data = Strings::splite($script , $openTag );
		//
		$output = $data[0];
		
		//
		for ($i=1; $i < Collection::count($data); $i++) 
		{
			$items = self::getParmas($data[$i], $closeChar);
			//
			$params = $items['params'];
			$rest = $items['rest'];
			//
			$output .= self::compile($params, $phpFunc, $phpClose);
			$output .= $rest;
		}
		//
		return $output;
	}


	/**
	 * Get Fucntion params and the rest of script
	 *
	 * @var string, string
	 * @return array
	 */
	protected static function getParmas($row, $closeChar)
	{
		$params = "";
		$rest = "";
		$taken = false;
		$string = false; // 1 "" - 2 ''
		$opened = 0; // 1 "" - 2 ''
		//
		for ($j=0; $j < strlen($row); $j++) 
		{ 
			//
			if($row[$j] == "'" && !$string) $string = 2;
			elseif($row[$j] == '"' && !$string) $string = 1;
			elseif($row[$j] == "'" && $string) $string = false;
			elseif($row[$j] == '"' && $string) $string = false;
			//
			if( $row[$j] == "(" ) $opened++;
			else if( $row[$j] == ")" ) $opened--;
			//
			if(!$string && $opened == 0 && $row[$j] == $closeChar && !$taken) $taken=true;
			elseif(!$taken) $params .= $row[$j];
			elseif($taken) $rest .= $row[$j];
		}
		//
		return array("params" => $params, "rest" => $rest);
	}


	/**
	 * To run the compiler
	 *
	 * @var string
	 */
	public static function run($script, $openTag, $closeChar, $phpFunc, $phpClose)
	{
		return self::open($script, $openTag, $closeChar, $phpFunc, $phpClose);
	}
}