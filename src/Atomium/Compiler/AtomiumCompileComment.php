<?php 

namespace Lighty\Kernel\Atomium\Compiler;

use Lighty\Kernel\Objects\Strings;
use Lighty\Kernel\Objects\Table;

/**
 * Class to hundle with Atomium comments
 * 
 * @package    Lighty Kernel
 * @subpackage Atomium
 * @author     Youssef Had
 */
class AtomiumCompileComment
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
	protected static function hide($script)
	{
		$output = "";
		//
		$data = Strings::splite($script , self::$openTag );
		//
		for ($i=0; $i < Table::count($data); $i++) 
			if(Strings::contains($data[$i],self::$closeTag))
			{
				$next = Strings::splite( $data[$i], self::$closeTag);
				//
				for ($j=1; $j < Table::count($next) ; $j++)
					$output .= $next[$j];
			}
			else $output .= $data[$i];
		//
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