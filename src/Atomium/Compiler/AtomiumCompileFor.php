<?php 

namespace Lighty\Kernel\Atomium\Compiler;

use Lighty\Kernel\Objects\Strings;
use Lighty\Kernel\Objects\Table;

/**
* 
*/
class AtomiumCompileFor
{

	protected static function openTag($script)
	{
		$output = "";
		$opened = true;
		//
		$data = Strings::splite($script , '@for' );
		//
		for ($i=0; $i < Table::count($data); $i++) { 
			if($i % 2 != 0)
			{
				$output .= "<?php for";
				//
				$next = Strings::splite( $data[$i], "\n");
				//
				$output .= $next[0] ." : ?>";
				//
				for ($j=1; $j < Table::count($next) ; $j++)
					$output .= $next[$j];
			}
			else $output .= $data[$i];
		}
		//
		return $output;
	}

	protected static function closeTag($script)
	{
		return str_replace('@endfor', '<?php endfor; ?>', $script);
	}

	public static function run($script)
	{
		$script = self::openTag($script);
		$script = self::closeTag($script);
		return $script;
	}
}