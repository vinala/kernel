<?php

namespace Fiesta\Kernel\Process;

use Fiesta\Kernel\Process\Process;
use Fiesta\Kernel\Database\Migration;
use Fiesta\Kernel\Config\Config;
use Fiesta\Kernel\Database\Schema;
use Fiesta\Kernel\Database\Database;
use Exception;

/**
* Migrations class
*/
class Migrations
{
	public static function exec()
	{
		$root = Process::root;
		$r=glob($root."app/schemas/*.php");
		//
		$pieces=array();
		$pieces1=array();
		$pieces2=array();
		//
		$time="";
		$name="";
		//
		$f = array();
		foreach ($r as $key) {
			$pieces = explode("app/schemas/", $key);
			$pieces1 = explode("_", $pieces[1]);
			$time=$pieces1[0];
			$p=explode(".", $pieces1[1]);
			$name=$p[0];
			$f[]=$pieces1[0];
			$pieces2[]=$pieces[1];
			$full_name=$pieces1[0]."_".$name;
		}
		//
		$mx=max($f);
		//
		$ind=0;$i=0;
		//
		foreach ($pieces2 as $value) {
			
			if (strpos($value,$mx) !== false) $ind=$i;

			$i++;
		}
		$link=$r[$ind];
		//


		include_once $link;
		
		if(up())
		{
			$full_name=$time."_".$name;
			if(Schema::existe(Config::get('database.migration'))) self::updateRow('executed',$name,$time);
			Migration::updateRegister($full_name,"exec",$root);
			return true;
			
		}
		else false;
	}

	public static function set($name,$Unixtime,$Datetime)
	{
		$txt = "<?php\n\n";
		$txt.="/* Schema info\n* @date : ".$Datetime."(".$Unixtime.")\n* @name : ".$name."\n\n\n\n";
		$txt .= "\t/**\n\t * Run the schemas.\n\t*/\n";
		$txt .= "\tfunction up()\n\t{\n\t\treturn true;\n\n";
		$txt .= "\t\t/* Ex.\treturn Schema::create('$name',function(".'$tab'.")\n\t\t\t{\n\t\t\t\t".'$tab->string("name");'."\n\t\t\t});\n\t\t\t*/";
		$txt .= "\n\t}\n\n";
		$txt .= "\t/**\n\t * Reverse the schemas.\n\t*/\n";
		$txt .= "\tfunction down()\n\t{\n\t\treturn true;\n\n";
		$txt .= "\t\t// Ex.\t return Schema::drop('$name');\n\n";
		$txt .= "\t}\n\n";
		$txt .= "?>\n";
		return $txt;
	}

	public static function create()
	{
		Schema::create(Config::get('database.migration'),function($tab)
		{
			$tab->inc("pk_schema");
			$tab->string("name_schema");
			$tab->timestamp("date_schema");
			$tab->string("status_schema");
			$tab->string("type_schema");
		});
	}


	public static function add($name)
	{
		$Datetime=date("Y/m/d H:i:s",time());
		$Unixtime=time();
		//
		$root=Process::root;
		//
		$myfile = fopen($root."app/schemas/".$Unixtime."_".$name.".php", "w");
		//
		fwrite($myfile, self::set($name,$Unixtime,$Datetime));
		fclose($myfile);
		//
		if(!Schema::existe(Config::get('database.migration'))) self::create();
		//
		self::addRow($name,$Unixtime);
		//
		Migration::updateRegister($Unixtime."_".$name,"init",$root);

		return true;
	}

	public static function rollback()
	{
		$Root=Process::root;
		$r=glob($Root."app/schemas/*.php");
		//
		$pieces=array();
		$pieces1=array();
		$pieces2=array();
		$full_names=array();
		//
		$time="";
		$name="";
		//
		$f = array();
		foreach ($r as $key) {
			$pieces = explode("app/schemas/", $key);
			$pieces1 = explode("_", $pieces[1]);
			$time=$pieces1[0];
			$p=explode(".", $pieces1[1]);
			$name=$p[0];
			$f[]=$pieces1[0];
			$pieces2[]=$pieces[1];
			//
			$full_names=$pieces1[0]."_".$name;
		}
		$mx=max($f);
		//
		$ind=0;$i=0;
		//
		foreach ($pieces2 as $value) {
			
			if (strpos($value,$mx) !== false) $ind=$i;

			$i++;
		}
		$link=$r[$ind];
		//
		
			include_once $link;
			
			if(down())
			{
				
				if(Schema::existe(Config::get('database.migration'))) self::updateRow('rolledback',$name,$time);

				$full_names=$time."_".$name;
				Migration::updateRegister($full_names,"rollback",$Root);
				return true;
				
			}
			else false;
		
	}

	/**
	 * add new row to migration datatable
	 */
	protected static function addRow($name,$time)
	{
		$table = self::getMigrationTable();
		Database::exec("insert into $table (name_schema,date_schema,status_schema,type_schema) values('$name','$time','init','table')");
	}

	/**
	 * Update the existing row in migration datatable
	 */
	protected static function updateRow($status,$name,$time)
	{
		$table = self::getMigrationTable();
		Database::exec("update $table set status_schema='$status' where name_schema='$name' and date_schema='$time'");
	}


	/**
	 * the name of dataTable of migrations
	 */
	protected static function getMigrationTable()
	{
		if(Config::get('database.prefixing')) return Config::get('database.prefixe').Config::get('database.migration');
		else return Config::get('database.migration');
	}

	public static function rollback_cos() /* Beta */
	{
		$Root = "../";
		$r=glob("../app/schemas/*.php");

		$r2=array();
		$r2=array();
		foreach ($r as $value) {

		$temp1=explode("schemas/",$value);
		$temp2=explode("_",$temp1[1]);
		$temp3=explode(".",$temp2[1]);
		$ex=$temp3[0];
		//

		if($ex==$_POST['exec_cos_migrate_select'])
			{
				$r2[]=$ex;
				$r3[]=$temp2[0];

			}
		}
		$v="";
		//
		if(count($r2)>1)
		{
			for ($i=1; $i < count($r2); $i++) { 
				error_log($r3[$i].'*/*'.$r3[$i-1]);
				if($r3[$i]>=$r3[$i-1])
				{
					$v="../app/schemas/".$r3[$i]."_".$r2[$i].".php";
					$full_name=$r3[$i]."_".$r2[$i];
				}
			}
		}
		else
		{
			$v="../app/schemas/".$r3[0]."_".$r2[0].".php";
			$full_name=$r3[0]."_".$r2[0];
		}


		try {
			include_once $v;
			if(down())
			{
				Migration::updateRegister($full_name,"rollback",$Root);
				echo "Schéma annulée";
			}
			else echo Database::execErr();
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public static function exec_cos() /* Beta */
	{
		$Root = "../";
		$r=glob("../app/schemas/*.php");

		$r2=array();
		$r2=array();
		foreach ($r as $value) {

		$temp1=explode("schemas/",$value);
		$temp2=explode("_",$temp1[1]);
		$temp3=explode(".",$temp2[1]);
		$ex=$temp3[0];
		//
		if($ex==$_POST['exec_cos_migrate_select'])
			{
				$r2[]=$ex;
				$r3[]=$temp2[0];
			}
		}
		$v="";
		$full_name="";
		//
		if(count($r2)>1)
		{
			for ($i=1; $i < count($r2); $i++) { 
				error_log($r3[$i].'*/*'.$r3[$i-1]);
				if($r3[$i]>=$r3[$i-1])
				{
					$v="../app/schemas/".$r3[$i]."_".$r2[$i].".php";
					$full_name=$r3[$i]."_".$r2[$i];
				}
			}
		}
		else
		{
			$v="../app/schemas/".$r3[0]."_".$r2[0].".php";
			$full_name=$r3[0]."_".$r2[0];
		}


		try {
			include_once $v;
			if(up())
			{
				Migration::updateRegister($full_name,"exec",$Root);
				echo "Schéma executé";
			}
			else echo Database::execErr();
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
}