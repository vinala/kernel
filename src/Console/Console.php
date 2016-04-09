<?php 

namespace Fiesta\Kernel\Console;

use Symfony\Component\Console\Application as Ap;
use Fiesta\Kernel\Console\Command\Translator\NewLanguageDirectoryCommand;
use Fiesta\Kernel\Console\Command\Translator\NewLanguageFileCommand;
use Fiesta\Kernel\Console\Command\Schema\NewSchemaCommand;
use Fiesta\Kernel\Console\Command\Schema\ExecSchemaCommand;
use Fiesta\Kernel\Console\Command\Schema\RollbackSchemaCommand;
use Fiesta\Kernel\Console\Command\Links\NewLinkFileCommand;
use Fiesta\Kernel\Console\Command\Models\NewModelCommand;
use Fiesta\Kernel\Console\Command\Views\NewViewCommand;
use Fiesta\Kernel\Console\Command\Info;


class Console
{
	// const note = 'note';
	const ok 	= "success";
	const err 	= "failure";
	const war 	= "warning";
	const rmq 		= "note";

	public static function run() 
	{
		$application = new Ap();
		//
		self::addCommands($application);
		//
		$application->run();
	}

	public static function color($status , $text = null) 
	{
		
		$text = is_null($text) ? " >> " : $text ;
        $out = "";
        //
        switch($status) 
        {
			case "success": 	$out = "[1;32m"; break;  	//Green background
			case "failure": 	$out = "[1;31m"; break;  	//Red background
			case "warning": 	$out = "[1;33m"; break;  	//Yellow background
			case "note": 		$out = "[1;34m"; break;  	//Blue background
		}
		//
		return chr(27) . "$out" . "$text" . chr(27) . "[0m";
	}

	public static function setMessage($text , $status) 
	{
		return self::color($status).$text;
	}

	protected static function addCommands($app)
	{
		// Translator
		$app->add(new NewLanguageDirectoryCommand());
		$app->add(new NewLanguageFileCommand());
		//Schema
		$app->add(new NewSchemaCommand());
		$app->add(new ExecSchemaCommand());
		$app->add(new RollbackSchemaCommand());
		//Link
		$app->add(new NewLinkFileCommand());
		//Model
		$app->add(new NewModelCommand());
		//View
		$app->add(new NewViewCommand());
		//Info
		$app->add(new Info());
	}
}
