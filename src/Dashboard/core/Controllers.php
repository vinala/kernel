<?php 

namespace Lighty\Kernel\Dashboard;

use Lighty\Kernel\Foundation\Application;


class Controllers
{
	public static function sort()
	{
		$i =1;
		foreach (glob(Application::$root."app/controllers/*.php") as $value) 
		{
		  	$r=explode('controllers/',$value);
		  	echo "<tr><td>$i</td><td>".$r[1]."</td><td>".date("Y/m/d H:i:s",filemtime($value))."</td></tr>";
		  	//
		  	$i++;
		 } 
	}
}