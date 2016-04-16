<?php 

namespace Pikia\Kernel\Console;

use Symfony\Component\Console\Application as Ap;
use Pikia\Kernel\Console\Command\Translator\NewLanguageDirectoryCommand;
use Pikia\Kernel\Console\Command\Translator\NewLanguageFileCommand;
use Pikia\Kernel\Console\Command\Schema\NewSchemaCommand;
use Pikia\Kernel\Console\Command\Schema\ExecSchemaCommand;
use Pikia\Kernel\Console\Command\Schema\RollbackSchemaCommand;
use Pikia\Kernel\Console\Command\Links\NewLinkFileCommand;
use Pikia\Kernel\Console\Command\Models\NewModelCommand;
use Pikia\Kernel\Console\Command\Views\NewViewCommand;
use Pikia\Kernel\Console\Command\Controller\NewControllerCommand;
use Pikia\Kernel\Console\Command\Routes\NewGetRouteCommand;
use Pikia\Kernel\Console\Command\Seed\NewSeedCommand;
use Pikia\Kernel\Console\Command\Seed\ExecSeedCommand;
use Pikia\Kernel\Console\Command\Various\AllCommand;
use Pikia\Kernel\Console\Command\Info;


class Console
{
	// const note = 'note';
	const ok 	= "success";
	const err 	= "failure";
	const war 	= "warning";
	const rmq 		= "note";
	const lst 		= "list";
	const nn 		= "nn";
	//
	public static $application ;

	public static function run() 
	{
		self::$application = new Ap();
		//
		self::addCommands(self::$application);
		//
		self::$application->run();
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
			case "list": 		$out = "[1;36m"; break;  	//cyan background
			case "nn": 		$out = "[1;30m"; break;  		//black background
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
		//Controller
		$app->add(new NewControllerCommand());
		//Routes
		$app->add(new NewGetRouteCommand());
		//Seeds
		$app->add(new NewSeedCommand());
		$app->add(new ExecSeedCommand());
		//Info
		$app->add(new Info());
		//All
		$app->add(new AllCommand());
	}

	public static function setCyan($text)
	{
		return chr(27) . "[1;36m" . "$text" . chr(27) . "[0m";
	}
}


