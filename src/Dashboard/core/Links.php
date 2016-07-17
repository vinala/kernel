<?php 

namespace Lighty\Kernel\Dashboard;

use Lighty\Kernel\Foundation\Application;


class Links
{
	public static function sort()
	{
		$i =1;
		foreach (glob(Application::$root."app/links/*.php") as $value) 
		{
		  	$r=explode('links/',$value);
		  	echo "<tr><td>$i</td><td>".$r[1]."</td><td>".date("Y/m/d H:i:s",filemtime($value))."</td></tr>";
		  	//
		  	$i++;
		 } 
	}
}