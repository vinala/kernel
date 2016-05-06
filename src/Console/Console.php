<?php 

namespace Pikia\Kernel\Console;

use Symfony\Component\Console\Application as Ap;
use Pikia\Kernel\Console\Command\Command\NewCommand;
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
use Pikia\Kernel\Console\Command\Command\testCommand;
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

	/**
	 * User commands 
	 */
	protected static $userCommands;

	/**
	 * Kernel commands 
	 */
	protected static $kernelCommands;

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
		// Command
		// $app->add(new NewCommand());
		// $app->add(new testCommand());
		// Translator
		$app->add(new NewLanguageDirectoryCommand());
		$app->add(new NewLanguageFileCommand());
		//Schema
		// $app->add(new ExecSchemaCommand());
		// $app->add(new RollbackSchemaCommand());
		//Link
		
		//Model
		// $app->add(new NewModelCommand());
		//View
		$app->add(new NewViewCommand());
		//Controller
		// $app->add(new NewControllerCommand());
		//Routes
		// $app->add(new NewGetRouteCommand());
		//Seeds
		// $app->add(new NewSeedCommand());
		// $app->add(new ExecSeedCommand());
		//Info
		// $app->add(new Info());
		//All
		$app->add(new AllCommand());
		//
		self::AddUserCommands($app);
		self::AddKernelCommands($app);
	}

	public static function setCyan($text)
	{
		return chr(27) . "[1;36m" . "$text" . chr(27) . "[0m";
	}

	/**
	 * Add all kernel command classes to console
	 */
	public static function AddKernelCommands($app)
	{
		self::getKernelClasses();
		//
		foreach (self::$kernelCommands as $value) 
			$app->add(new $value());
	}

	/**
	 * Add all user command classes to console
	 */
	public static function AddUserCommands($app)
	{
		self::getUserClasses();
		//
		foreach (self::$userCommands as $value) 
			$app->add(new $value());
	}

	/**
	 * Search for commmand classes of user
	 */
	public static function getUserClasses()
	{
		$namespace = "Pikia\App\Console\Commands";
		//
        foreach (get_declared_classes() as $value)
            if(\Strings::contains($value,$namespace)) 
            	self::$userCommands[] = $value;
	}

	/**
	 * Search for commmand classes of kernel
	 */
	public static function getKernelClasses()
	{
		$namespace = "Pikia\Kernel\Console\Commands";
		//
        foreach (get_declared_classes() as $value)
            if(\Strings::contains($value,$namespace)) 
            	self::$kernelCommands[] = $value;
	}
}


