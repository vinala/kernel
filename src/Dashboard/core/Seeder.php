<?php 

namespace Lighty\Kernel\Dashboard;

use Lighty\Kernel\Foundation\Application;
use Lighty\Kernel\Database\Migration;


class Seeder
{
	public static function sort()
	{
		$i =1;
		foreach (glob(Application::$root."database/seeds/*.php") as $value) 
		{
		  	$r=explode('database/seeds/',$value);
		  	echo "<tr><td>$i</td><td>".$r[1]."</td><td>".date("Y/m/d H:i:s",filemtime($value))."</td></tr>";
		  	//
		  	$i++;
		} 
	}
}
