<?php 

namespace Lighty\Kernel\Atomium\Compiler;

use Lighty\Kernel\Objects\Strings;
use Lighty\Kernel\Objects\Table;

/**
* 
*/
class AtomiumCompileCapture
{

	/**
	 * The tag that open the instruction 
	 *
	 * @var string
	 */
	protected static $openTag = "@capture";


	/**
	 * The key where open tag end's
	 *
	 * @var string
	 */
	protected static $endOpenTag = ":";


	/**
	 * The tag that close the instruction 
	 *
	 * @var string
	 */
	protected static $closeTag = "@endcapture;";


	/**
	 * The PHP Open tag that should Lighty replace with
	 *
	 * @var string
	 */
	protected static $phpOpenTag = "<div style='all:unset;' ";


	/**
	 * The key where PHP Open tag end's
	 *
	 * @var string
	 */
	protected static $phpEndOpenTag = " >";


	


	/**
	 * Complie the opening tag
	 *
	 * @var string
	 */
	protected static function get($script, $openTag)
	{
		$data = Strings::splite($script , $openTag );
		//
		$output = "";
		//
		for ($i=1; $i < Table::count($data); $i++) 
		{
			$next = Strings::splite( $data[$i], self::$endOpenTag);
			$rest = "";
			//
			for ($j=0; $j < Table::count($next) ; $j++)
				$rest .= $next[$j]."\n";
			//
			$next = Strings::splite( $rest , self::$closeTag);
			//
			$output = $next[0];
		}
		//
		return $output;
	}


	/**
	 * hide close tag when no need for call
	 *
	 * @var string
	 */
	protected static function hideCloseTag($script)
	{
		return Strings::replace($script, self::$closeTag, "");
	}


	/**
	 * run the compiler
	 *
	 * @var string
	 */
	protected static function hideOpenTag($script)
	{
		$data = Strings::splite($script , self::$openTag );
		//
		$output = $data[0];
		//
		for ($i=1; $i < Table::count($data); $i++) 
		{
			// $output .= self::$phpOpenTag;
			//
			$next = Strings::splite( $data[$i], self::$endOpenTag);
			// $output .= $next[0] .$phpEndOpenTag;
			//
			for ($j=1; $j < Table::count($next) ; $j++)
			{
				if($j==(Table::count($next)-1)) $output .= $next[$j];
				else $output .= $next[$j].self::$endOpenTag;
			}
		}
		return $output;
	}


	/**
	 * run the compiler
	 *
	 * @var string
	 */
	public static function run($script)
	{
		$script = self::hideCloseTag($script);
		$script = self::hideOpenTag($script);
		return $script;
	}


	/**
	 * call the capture
	 *
	 * @var string
	 */
	public static function call($script, $openTag)
	{
		$script = self::get($script, $openTag);
		return $script;
	}
}