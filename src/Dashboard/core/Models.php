<?php 

namespace Lighty\Kernel\Dashboard;

use Lighty\Kernel\Foundation\Application;


class Models
{
	public static function sort()
	{
		$i =1;
		foreach (glob(Application::$root."app/models/*.php") as $value) 
		{
		  	$r=explode('models/',$value);
		  	echo "<tr><td>$i</td><td>".$r[1]."</td><td></td><td>".date("Y/m/d H:i:s",filemtime($value))."</td></tr>";
		 } 
	}
}