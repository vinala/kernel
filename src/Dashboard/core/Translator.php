<?php 

namespace Lighty\Kernel\Dashboard;

use Lighty\Kernel\Foundation\Application;
use Lighty\Kernel\Database\Migration;


class Translator
{
	public static function sort()
	{
		$i =1;
		foreach (glob(Application::$root."app/lang/*") as $path) 
		{
		  	$folder=explode('app/lang/',$path);
		  	//
		  	foreach (glob(Application::$root."app/lang/".$folder[1]."/*.php") as  $value) {
		  		$file=explode('app/lang/'.$folder[1].'/',$value);
		  		//
		  		$file = $folder[1]."/".$file[1];
		  		//
		  		echo "<tr><td>$i</td><td>".$file."</td><td>".date("Y/m/d H:i:s",filemtime($value))."</td></tr>";
		  		//
		  		$i++;
		  	}
		  	
		} 
	}
}
