<?php 

namespace Vinala\Kernel\Atomium;

use Vinala\Kernel\Atomium\Compiler\AtomiumCompileIf;
use Vinala\Kernel\Atomium\Compiler\AtomiumCompileElse;
use Vinala\Kernel\Atomium\Compiler\AtomiumCompileFor;
use Vinala\Kernel\Atomium\Compiler\AtomiumCompileEndFor;
use Vinala\Kernel\Atomium\Compiler\AtomiumCompileComment;
use Vinala\Kernel\Atomium\Compiler\AtomiumCompileOneLineComment;
use Vinala\Kernel\Atomium\Compiler\AtomiumCompileEndIf;
use Vinala\Kernel\Atomium\Compiler\AtomiumCompileElseIf;
use Vinala\Kernel\Atomium\Compiler\AtomiumCompileForeach;
use Vinala\Kernel\Atomium\Compiler\AtomiumCompileEndForeach;
use Vinala\Kernel\Atomium\Compiler\AtomiumCompileWhile;
use Vinala\Kernel\Atomium\Compiler\AtomiumCompileEndWhile;
use Vinala\Kernel\Atomium\Compiler\AtomiumCompileUntil;
use Vinala\Kernel\Atomium\Compiler\AtomiumCompileEndUntil;
use Vinala\Kernel\Atomium\Compiler\AtomiumCompileSub;
use Vinala\Kernel\Atomium\Compiler\AtomiumCompileExec;
use Vinala\Kernel\Atomium\Compiler\AtomiumCompileHtmlDiv;
use Vinala\Kernel\Atomium\Compiler\AtomiumCompileTake;
use Vinala\Kernel\Atomium\Compiler\AtomiumCompileCapture;
use Vinala\Kernel\Atomium\Compiler\AtomiumCompileLang;
use Vinala\Kernel\Atomium\Compiler\AtomiumCompileBreak;
use Vinala\Kernel\Atomium\Compiler\AtomiumCompileOneLineInstruction;
use Vinala\Kernel\Atomium\Compiler\AtomiumCompileCSS;
use Vinala\Kernel\Atomium\Compiler\AtomiumCompileJS;
use Vinala\Kernel\Atomium\Compiler\AtomiumCompileAssign;
use Vinala\Kernel\Atomium\Compiler\AtomiumCompileRun;
use Vinala\Kernel\Foundation\Connector;




class Compiler 
{

	/**
	 * User Tags
	 */
	protected static $userTags;

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
		self::compileUserTags();
		//
		self::compilComment();
		self::compilOneLineComment();
		self::compilTag();
		self::compilSub();
		self::compilExec();
		self::compilAssign();
		self::compilRun();
		//
	  	self::compilEchoApostrophe();
	  	self::compilEchoQuota();
	  	self::compilEchoEntities();
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
	  	self::compilEndWhile();
	  	self::compilUntil();
	  	self::compilEndUntil();
	  	//
	  	self::compilLang();
	  	//
	  	self::compilTake();
	  	self::compilCapture();
	  	//
	  	self::compilCSS();
	  	self::compilJS();

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
		self::replace("?}}", "?>\n");
	}

	/**
	 * Replace Echos htmlentities
	 */
	protected static function compilEchoEntities()
	{
		self::replace("{{*", "<?php echo htmlentities(");
		self::replace("*}}", "); ?>\n");
	}

	/**
	 * Replace Echos
	 */
	protected static function compilEcho()
	{
		self::replace("{{", "<?php echo ");
		self::replace("}}", "; ?>\n");
	}	

	/**
	 * Replace Echos
	 */
	protected static function compilEchoApostrophe()
	{
		self::replace("{{ '", "<?php echo htmlentities('");
		self::replace("' }}", "'); ?>\n");
	}

	/**
	 * Replace Echos
	 */
	protected static function compilEchoQuota()
	{
		self::replace('{{ "', '<?php echo htmlentities("');
		self::replace('" }}', '"); ?>\n');
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
	 * Compile While
	 */
	protected static function compilUntil()
	{
		self::$output = AtomiumCompileUntil::run(self::$output);
	}

	/**
	 * Compile While
	 */
	protected static function compilEndUntil()
	{
		self::$output = AtomiumCompileEndUntil::run(self::$output);
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
	 * Compile for CSS
	 */
	public static function compilCSS()
	{
		self::$output = AtomiumCompileCSS::run(self::$output);
	}

	/**
	 * Compile for JS
	 */
	public static function compilJS()
	{
		self::$output = AtomiumCompileJS::run(self::$output);
	}

	/**
	 * Compile for Assign
	 */
	public static function compilAssign()
	{
		self::$output = AtomiumCompileAssign::run(self::$output);
	}

	/**
	 * Compile for Run
	 */
	public static function compilRun()
	{
		self::$output = AtomiumCompileRun::run(self::$output);
	}

	/**
	 * Replace strings
	 */
	protected static function replace($old, $new)
	{
		self::$output = str_replace($old, $new, self::$output);
	}

	/**
	 * Set User Tags
	 */
	public static function setUserTags()
	{
		self::fetchUserTags();
		//
		$namespace = "Vinala\Kernel\Atomium\User\\";
		//
        foreach (get_declared_classes() as $value)
            if(strpos($value,$namespace) !== false) 
            	self::$userTags[] = $value;
	}

	/**
	 * Fetch User Tags
	 */
	protected static function fetchUserTags()
	{
		$files = Connector::fetch( "tags",true);
		//
		if( ! is_null($files))
			foreach (Connector::fetch( "tags",true) as $file) 
				Connector::need($file);
	}

	/**
	 * Compile User Tags
	 */
	protected static function compileUserTags()
	{
		if( ! is_null(self::$userTags))
			foreach (self::$userTags as $compiler) 
				self::$output = $compiler::run(self::$output);
	}
}
