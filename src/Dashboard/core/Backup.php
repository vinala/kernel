<?php 

namespace Lighty\Kernel\Dashboard;

use Lighty\Kernel\Foundation\Application;
use Lighty\Kernel\Database\Migration;


class Backup
{
	public static function sort()
	{
		$i =1;
		foreach (glob(Application::$root."database/backup/*.sql") as $value) 
		{
		  	$r=explode('database/backup/',$value);
		  	echo "<tr><td>$i</td><td>".$r[1]."</td><td>".date("Y/m/d H:i:s",filemtime($value))."</td></tr>";
		  	//
		  	$i++;
		} 
	}
}
