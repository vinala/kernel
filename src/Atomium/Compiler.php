<?php 

namespace Lighty\Kernel\Atomium;

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
		self::$output = file_get_contents($file);
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

	protected static function output() 
	{
		self::compilEcho();
	  	self::compilTag();
	  	self::compilEchoApostrophe();
	  	self::compilEchoQuota();
	  	self::compilIf();


	        

	   //  foreach ($this->values as $key => $value) 
	   //  {
	 		// $tagToReplace = '{$'.$key.'}';
	   //      $output = str_replace($tagToReplace, $value, $output);
	   //  }
	    //
	    // $output = $this->setVar($output);
	  
	    // return $output;
	}

	/**
	 * Replace PHP Tag
	 */
	protected static function compilTag()
	{
		self::replace("{?", "<?php");
		self::replace("?}", "?>");
	}

	/**
	 * Replace Echos
	 */
	protected static function compilEcho()
	{
		self::replace("{{", "<?php echo ");
		self::replace("}}", "; ?>");
	}

	/**
	 * Replace Echos
	 */
	protected static function compilEchoApostrophe()
	{
		self::replace("{'", "<?php echo '");
		self::replace("'}", "'; ?>");
	}

	/**
	 * Replace Echos
	 */
	protected static function compilEchoQuota()
	{
		self::replace('{"', '<?php echo "');
		self::replace('"}', '"; ?>');
	}

	/**
	 * Compile IF
	 */
	protected static function compilIf()
	{
		self::replace('@if', '<?php if ');
		self::replace('):', ') : ?>');
		self::replace('@endif', '<?php endif; ?>');
	}

	/**
	 * Replace strings
	 */
	protected static function replace($old, $new)
	{
		self::$output = str_replace($old, $new, self::$output);
	}
}