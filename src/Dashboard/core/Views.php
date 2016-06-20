<?php 

namespace Lighty\Kernel\Dashboard;

use Lighty\Kernel\Foundation\Application;
use Lighty\Kernel\Objects\Strings;


class Views
{
	public static function sort()
	{
		$i =1;
		$path = Application::$root."app/views";
		$data = self::getSub($path);
		
		//
		foreach (glob(Application::$root."app/views/*") as $value) 
		{
			if( ! is_dir($value))
			{
				$r = explode('views/',$value);
			  	$data = self::getType($r[1]);
			  	echo "<tr><td>$i</td><td>".$data["name"]."</td><td>".$data["type"]."</td><td>".date("Y/m/d H:i:s",filemtime($value))."</td></tr>";
			}
			else
			{
				$r = explode('views/',$value);
			  	// $data = self::getType($r[1]);
			  	echo "<tr><td>$i</td><td>$value</td><td></td><td>".date("Y/m/d H:i:s",filemtime($value))."</td></tr>";
			}
		  	
		 } 
	}

	protected static function getSub($path)
	{
		$data = array();
		foreach (glob($path."/*") as $value)
			if(is_dir($value)) $dirs["dir"][] = $value;
			else $dirs["file"][] = $value;
		//
		return $data;
	}

	protected static function getType($file)
	{
		$elements = Strings::splite($file,".");
		//
		$data = array("name" => $elements[0]);
		$ext = "";
		for ($i=1; $i < count($elements); $i++) $ext .= $elements[$i];
			// die($ext);
		//
		switch ($ext) {
			case 'tplphp': $data["type"] = "Smarty"; break;
			case 'tpl': $data["type"] = "Smarty"; break;
			case 'atom': $data["type"] = "Atomium"; break;
			case 'atomphp': $data["type"] = "Atomium"; break;
			case 'php': $data["type"] = "None"; break;
		}
		//
		return $data;
	}
}