<?php 

namespace Vinala\Kernel\Atomium\Compiler;

use Vinala\Kernel\String\Strings;
use Vinala\Kernel\Objects\Table;

/**
 * Class to hundle with Atomium comments
 * 
 * @package    Lighty Kernel
 * @subpackage Atomium
 * @author     Youssef Had
 */
class AtomiumCompileComments
{
	/**
	 * The tag that open the comment
	 *
	 * @var string
	 */
	protected static $openTag = "{//" ;

	/**
	 * The tag that close the comment
	 *
	 * @var string
	 */
	protected static $closeTag = "//}" ;


	/**
	 * To hide de comment that user write
	 *
	 * @return string
	 */
	public static function hide($script, $openTag, $closeTag)
	{
		$data = Strings::splite($script , $openTag );
		//
		$output = $data[0];
		//
		for ($i=1; $i < Table::count($data); $i++) 
		{
			$output .= "";
			//
			$next = Strings::splite( $data[$i], $closeTag);
			$output .= "";
			//
			for ($j=1; $j < Table::count($next) ; $j++)
			{
				if($j==(Table::count($next)-1)) $output .= $next[$j];
				else $output .= $next[$j].$closeTag;
			}
		}
		return $output;
	}


	/**
	 * Run the compiler
	 *
	 * @return string
	 */
	public static function run($script)
	{
		return self::hide($script);
	}
}