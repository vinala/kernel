<?php 

namespace Fiesta\Core\Database;

use Fiesta\Core\Filesystem\Filesystem;
use Fiesta\Core\Objects\Table;
/**
* migaration class
*/
class Migration
{
	
	protected static $schemas;
	public static function getAll($name)
	{
		$r=glob("../app/schemas/*.php");
		$r2=array();
		foreach ($r as $value) {
			
			$temp=explode("_",$value);
			
			$temp2=explode(".",$temp[1]);
			
			$r2[]=$temp2[0];
			
		}
		
		$r3=array_unique($r2);
		//
		
		echo "<div class='form-group col-md-7' style='display:block'><select name=".$name." class='form-control'>";
		foreach ($r3 as $value) {
			echo "<option value='".$value."'>".$value."</option>";
		} 
		echo "</select></div>";
	}

	protected static function createRegister($root)
	{
		if(!(new Filesystem)->exists($root.'app/schemas/.register'))
			(new Filesystem)->put($root.'app/schemas/.register',"");
	}
	
	protected static function setRegister($array,$root)
	{
		self::createRegister($root);
		//
		$s = serialize($array);
		//
		file_put_contents($root.'app/schemas/.register', $s);
		//
		
	}

	protected static function getRegister($root)
	{
		self::createRegister($root);
		//
		$f=file_get_contents($root.'app/schemas/.register');
		$data = strlen($f) > 2 ? unserialize($f) : "";
		$data = !($data) ? array() : $data ;
		//
		return $data;
	}

	public static function updateRegister($name,$state="init",$root)
	{
		$data = self::getRegister($root);
		
		//
		$existe=false;
		//

		for ($i=0; $i < count($data); $i++) { 
			if($data[$i]["name"]==$name)
			{
				$existe=true;
				$data[$i]["state"]=$state;
				$data[$i]["exec"]=time();
				
			}
		}
		//
		if(!$existe) $data[]=array("name" => $name , "state" => $state , "exec" => time()); 
		
		//
		self::setRegister($data,$root);
		self::checkRegister($root);
		//
		return $data;
	}

	public static function checkRegister($root)
	{
		$data = self::getRegister($root);
		//
		$schemas = self::getSchemas($root);
		//
		// contains
		for ($i=0; $i < Table::count($data); $i++)
		{ 
			if( ! Table::contains($schemas,$data[$i]['name']))
			{
				$data[$i]['state']="droped";
				$data[$i]['exec']=time();
			}
		}
		//
		self::setRegister($data,$root);
		

	}

	protected static function getSchemas($root)
	{
		$f=glob($root.'app/schemas/*.php');
		$sch = array();
		//
		foreach ($f as $value) {
			$t=explode("/", $value);
			$t=$t[Table::count($t)-1];
			$t=explode(".php", $t);
			$t=$t[0];
			$sch[]=$t;
		}
		//
		return $sch;
	}


	
}