<?php 

namespace Lighty\Kernel\Dashboard;

use Lighty\Kernel\Process\Controller;
use Lighty\Kernel\Process\Migrations;
use Lighty\Kernel\Process\Seeds;
use Lighty\Kernel\Process\Translator;
use Lighty\Kernel\Process\Links;
use Lighty\Kernel\Process\Model;
use Lighty\Kernel\Process\View;
use Lighty\Kernel\Database\Database;

class Response
{
	/**
	 * create controller
	 */
	public static function createController()
	{
		$file = $_POST['new_controller_file_name'];
		$class = $_POST['new_controller_class_name'];
		$route = isset($_POST['new_controller_route']);
		//
		if(controller::create($file, $class, $route,"../")) echo "true";
		else echo "false";
	}

	/**
	 * create controller
	 */
	public static function createSchema()
	{
		$name = $_POST['migname'];
		//
		if(Migrations::add($name, "../"))
			echo "true";
		else echo "false";
	}

	/**
	 * create seeder
	 */
	public static function createSeeder()
	{
		$name = $_POST['seed_name'];
		$table = $_POST['seed_table'];
		$count = $_POST['seed_count'];
		//
		if(Seeds::add($name,$table,$count,"../"))
			echo "Seeder created";
		else echo "There was a problem";
	}

	/**
	 * create Lang Directory
	 */
	public static function createLangDir()
	{
		$name=$_POST['lang_dir_name'];
		//
		if(Translator::createDir($name,"../"))
			echo "Directory created";
		else echo "There was a problem";
	}

	/**
	 * create Lang File
	 */
	public static function createLangFile()
	{
		$dir=$_POST['lang_dir_name_2'];
		$file=$_POST['lang_file_name'];
		//
		if(Translator::createFile($dir , $file, "../"))
			echo "File created";
		else echo "There was a problem";
	}

	/**
	 * create Link File
	 */
	public static function createLink()
	{
		$name=$_POST['link_name'];
		//
		if(Links::create($name, "../"))
			echo "Link file created";
		else echo "There was a problem";
	}

	/**
	 * create Model
	 */
	public static function createModel()
	{
		$class=$_POST['new_models_class_name'];
		$file=$_POST['new_models_file_name'];
		$table=$_POST['new_models_table_name'];
		//
		if(Model::create($file , $class , $table, "../"))
			echo "true";
		else echo "false";
	}

	/**
	 * create View
	 */
	public static function createView()
	{
		$name=$_POST['new_view_file_name'];
		$temp = "nan";
		//
		switch ($_POST['new_view_template']) 
		{
			case 'atom': $temp = "atom"; break;
			case 'smart': $temp = "smarty"; break;
		}
		//
		if(View::create($name , $temp, "../")) echo "true";
		else echo "false";
	}

	/**
	 * exec Seeder
	 */
	public static function execSeed()
	{
		if(Seeds::exec())
			echo "Seeder executed";
		else echo "There was a problem";
	}

	/**
	 * exec Schema
	 */
	public static function execSchema()
	{
		if(Migrations::exec("../"))
			echo "true";
		else echo "false";
	}

	/**
	 * rollback Schema
	 */
	public static function rollbackSchema()
	{
		if(Migrations::rollback("../"))
			echo "true";
		else echo "false";
	}
}