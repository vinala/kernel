<?php 

namespace Lighty\Kernel\Atomium;

class Compiler 
{

	public static function run($file, $values)
	{
		return self::getContent($file);
	}

	protected  static function getContent($file)
	{
		$output = file_get_contents($file);
		//
		return self::output($output);
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

	public static function output($output) {
	    // if (!file_exists($this->file)) {
	    //     return "Error loading template file ($this->file).";
	    // }
	    // $output = file_get_contents($this->file);
	  	
	  		$tagToReplace = '{{';
	        $output = str_replace($tagToReplace, "<?php", $output);

	        $tagToReplace = '}}';
	        $output = str_replace($tagToReplace, "?>", $output);

	        $tagToReplace = '"}';
	        $output = str_replace($tagToReplace, '"; ?>', $output);
	        $tagToReplace = '{"';
	        $output = str_replace($tagToReplace, '<?php echo "', $output);

	        $tagToReplace = "'}";
	        $output = str_replace($tagToReplace, "'; ?>", $output);
	        $tagToReplace = "{'";
	        $output = str_replace($tagToReplace, "<?php echo '", $output);

	        $tagToReplace = '{';
	        $output = str_replace($tagToReplace, "<?php echo ", $output);

	        $tagToReplace = '}';
	        $output = str_replace($tagToReplace, "?>", $output);

	   //  foreach ($this->values as $key => $value) 
	   //  {
	 		// $tagToReplace = '{$'.$key.'}';
	   //      $output = str_replace($tagToReplace, $value, $output);
	   //  }
	    //
	    // $output = $this->setVar($output);
	  
	    return $output;
	}
}