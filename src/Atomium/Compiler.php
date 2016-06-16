<?php 

namespace Lighty\Kernel\Atomium;

use Lighty\Kernel\Atomium\Compiler\AtomiumCompileIf;
use Lighty\Kernel\Atomium\Compiler\AtomiumCompileElse;
use Lighty\Kernel\Atomium\Compiler\AtomiumCompileFor;
use Lighty\Kernel\Atomium\Compiler\AtomiumCompileEndFor;
use Lighty\Kernel\Atomium\Compiler\AtomiumCompileComment;
use Lighty\Kernel\Atomium\Compiler\AtomiumCompileOneLineComment;
use Lighty\Kernel\Atomium\Compiler\AtomiumCompileEndIf;
use Lighty\Kernel\Atomium\Compiler\AtomiumCompileElseIf;
use Lighty\Kernel\Atomium\Compiler\AtomiumCompileForeach;
use Lighty\Kernel\Atomium\Compiler\AtomiumCompileEndForeach;
use Lighty\Kernel\Atomium\Compiler\AtomiumCompileWhile;
use Lighty\Kernel\Atomium\Compiler\AtomiumCompileEndWhile;
use Lighty\Kernel\Atomium\Compiler\AtomiumCompileSub;
use Lighty\Kernel\Atomium\Compiler\AtomiumCompileExec;
use Lighty\Kernel\Atomium\Compiler\AtomiumCompileHtmlDiv;
use Lighty\Kernel\Atomium\Compiler\AtomiumCompileTake;
use Lighty\Kernel\Atomium\Compiler\AtomiumCompileCapture;
use Lighty\Kernel\Atomium\Compiler\AtomiumCompileLang;
use Lighty\Kernel\Atomium\Compiler\AtomiumCompileBreak;
use Lighty\Kernel\Atomium\Compiler\AtomiumCompileOneLineInstruction;




class Compiler 
{

	/**
	 * The code that Atomium will compile
	 */
	protected static $output;

	public static function run($file, $values)
	{
		return self::getContent($file);
	}

	protected  static function getContent($file)
	{
		self::$output = file_get_contents($file)."\n";
		//
		self::output();
		//
		return self::$output;
	}

	public function setVar($content)
	{
		$opened = false;
		$str = "";
		//
		// foreach ($content as $key => $value) 
		for ($i=0; $i < strlen($content) ; $i++) 
		{
			if($content[$i] == "{" && $content[$i+1] == "$" && !$opened) 
			{
				$str .= "<?php echo ";
				$opened = true;
			}
			elseif($content[$i] == "}" && $opened)
			{
				$str .= "?>";
				$opened = false;
			}
			else 
				$str .= $content[$i];
		}
		// 
		return $str;
	}

	public static function output( $content = null) 
	{
		if( ! is_null($content)) self::$output = $content;
		//
		self::compilComment();
		self::compilOneLineComment();
		self::compilTag();
		self::compilSub();
		self::compilExec();
		self::compiltest();
		//
	  	self::compilEchoApostrophe();
	  	self::compilEchoQuota();
	  	self::compilEndIF();
	  	self::compilIf();

	  	self::compilElseIf();
	  	self::compilElse();
	  	self::compilForeach();
	  	self::compilEndForeach();
	  	self::compilFor();
	  	self::compilEndFor();
	  	self::compilBreak();
	  	self::compilWhile();
	  	//
	  	self::compilLang();
	  	//
	  	self::compilTake();
	  	self::compilCapture();
	  	//
	  	self::compilHtmlDiv();

	  	//
	  	self::compilEcho();
	  	//
	  	if( ! is_null($content)) return self::$output ;
	}

	/**
	 * Replace PHP Tag
	 */
	protected static function compilTag()
	{
		self::replace("{{?", "<?php");
		self::replace("?}}", "?>");
	}

	/**
	 * Replace Echos
	 */
	protected static function compilEcho()
	{
		self::replace("{{", "<?php echo htmlentities(");
		self::replace("}}", "); ?>");
	}

	/**
	 * Replace Echos
	 */
	protected static function compilEchoApostrophe()
	{
		self::replace("{{ '", "<?php echo htmlentities('");
		self::replace("' }}", "'); ?>");
	}

	/**
	 * Replace Echos
	 */
	protected static function compilEchoQuota()
	{
		self::replace('{{ "', '<?php echo htmlentities("');
		self::replace('" }}', '"); ?>');
	}

	/**
	 * Compile IF
	 */
	protected static function compilIf()
	{
		self::$output = AtomiumCompileIf::run(self::$output);
	}

	/**
	 * Compile ELSE
	 */
	protected static function compilElse()
	{
		self::$output = AtomiumCompileElse::run(self::$output);	
	}

	/**
	 * Compile EndIF
	 */
	protected static function compilEndIF()
	{
		self::$output = AtomiumCompileEndIf::run(self::$output);	
	}

	/**
	 * Compile ELSE
	 */
	protected static function compilElseIf()
	{
		self::$output = AtomiumCompileElseIf::run(self::$output);	
	}

	/**
	 * Compile FOR
	 */
	protected static function compilFor()
	{
		self::$output = AtomiumCompileFor::run(self::$output);
	}

	/**
	 * Compile FOR
	 */
	protected static function compilEndFor()
	{
		self::$output = AtomiumCompileEndFor::run(self::$output);
	}

	/**
	 * Compile Break
	 */
	protected static function compilBreak()
	{
		self::$output = AtomiumCompileBreak::run(self::$output);
	}

	/**
	 * Compile Foreach
	 */
	protected static function compilForeach()
	{
		self::$output = AtomiumCompileForeach::run(self::$output);
	}

	/**
	 * Compile end Foreach
	 */
	protected static function compilEndForeach()
	{
		self::$output = AtomiumCompileEndForeach::run(self::$output);
	}

	/**
	 * Compile While
	 */
	protected static function compilWhile()
	{
		self::$output = AtomiumCompileWhile::run(self::$output);
	}

	/**
	 * Compile While
	 */
	protected static function compilEndWhile()
	{
		self::$output = AtomiumCompileEndWhile::run(self::$output);
	}

	/**
	 * Compile One Line Comments
	 */
	protected static function compilOneLineComment()
	{
		self::$output = AtomiumCompileOneLineComment::run(self::$output);
	}

	/**
	 * Compile Comments
	 */
	protected static function compilComment()
	{
		self::$output = AtomiumCompileComment::run(self::$output);
	}

	/**
	 * Compile Call
	 */
	protected static function compilSub()
	{
		self::$output = AtomiumCompileSub::run(self::$output);
	}

	/**
	 * Compile Exec
	 */
	protected static function compilExec()
	{
		self::$output = AtomiumCompileExec::run(self::$output);
	}

	/**
	 * Compile Lang
	 */
	protected static function compilLang()
	{
		self::$output = AtomiumCompileLang::run(self::$output);
	}

	/**
	 * HTML Compiles
	 */

	/**
	 * Compile for HTML Div
	 */
	protected static function compilHtmlDiv()
	{
		self::$output = AtomiumCompileHtmlDiv::run(self::$output);
	}

	/**
	 * Atomium Functions
	 */

	/**
	 * Compile for HTML Div
	 */
	protected static function compilTake()
	{
		self::$output = AtomiumCompileTake::run(self::$output);
	}

	/**
	 * Compile for HTML Div
	 */
	public static function compilCapture()
	{
		self::$output = AtomiumCompileCapture::run(self::$output);
	}

	/**
	 * Compile for HTML Div
	 */
	public static function compiltest()
	{
		self::$output = AtomiumCompileOneLineInstruction::run(self::$output,"@test", ";", "<?php echo Config::get(" ,"); ?>");
	}

	/**
	 * Replace strings
	 */
	protected static function replace($old, $new)
	{
		self::$output = str_replace($old, $new, self::$output);
	}
}
