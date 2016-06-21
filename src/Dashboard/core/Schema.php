<?php 

namespace Lighty\Kernel\Dashboard;

use Lighty\Kernel\Foundation\Application;
use Lighty\Kernel\Database\Migration;


class Schema
{
	public static function sort()
	{
		$ind = 1;
		//
		$stats = Migration::getRegister(Application::$root);
		// die(var_dump($stats));
		//
		foreach (glob(Application::$root."database/schema/*.php") as $value) 
		{
		  	$r=explode('database/schema/',$value);
		  	$name = explode('.php',$r[1]);
		  	$name = $name[0];
		  	$tables = explode('_', $name);
		  	$table = "";
		  	$stat = "";
		  	//
		  	foreach ($stats as $key2 => $value2) if( $value2['name'] == $name ) $stat = $value2['state'];
		  	//
		  	for ($i=1; $i < count($tables) ; $i++) $table .= $tables[$i];
		  	//
		  		switch ($stat) {
		  			case 'droped': $stat = '<span class="label label-sm label-danger"> Droped </span>'; break;
		  			
		  			default: $stat = '<span class="label label-sm label-info"> '.$stat.' </span>'; break;
		  		}
		  	//
		  	echo "<tr><td>$ind</td><td>".$name."</td><td>".date("Y/m/d H:i:s",filemtime($value))."</td><td>$table</td><td>$stat</td></tr>";
		  	//
		  	$ind++;
		 } 
	}
}
