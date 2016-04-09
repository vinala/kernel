<?php 

namespace Fiesta\Kernel\Console;

use Fiesta\Kernel\Console\Command\GreetCommand;
use Fiesta\Kernel\Console\Command\HelloCommand;
use Fiesta\Kernel\Console\Command\Translator\NewDir as NTDir;
use Fiesta\Kernel\Console\Command\Translator\NewFile as NTFile;
use Fiesta\Kernel\Console\Command\Info;
use Symfony\Component\Console\Application as Ap;

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
		$app->add(new NTDir());
		$app->add(new NTFile());
		$app->add(new Info());
	}
}
