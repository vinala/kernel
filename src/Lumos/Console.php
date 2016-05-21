<?php 

namespace Lighty\Kernel\Console;

use Symfony\Component\Console\Application as Ap;
use Lighty\Kernel\Console\Command\Command\NewCommand;
use Lighty\Kernel\Console\Command\Translator\NewLanguageDirectoryCommand;
use Lighty\Kernel\Console\Command\Translator\NewLanguageFileCommand;
use Lighty\Kernel\Console\Command\Schema\NewSchemaCommand;
use Lighty\Kernel\Console\Command\Schema\ExecSchemaCommand;
use Lighty\Kernel\Console\Command\Schema\RollbackSchemaCommand;
use Lighty\Kernel\Console\Command\Links\NewLinkFileCommand;
use Lighty\Kernel\Console\Command\Models\NewModelCommand;
use Lighty\Kernel\Console\Command\Views\NewViewCommand;
use Lighty\Kernel\Console\Command\Controller\NewControllerCommand;
use Lighty\Kernel\Console\Command\Routes\NewGetRouteCommand;
use Lighty\Kernel\Console\Command\Seed\NewSeedCommand;
use Lighty\Kernel\Console\Command\Seed\ExecSeedCommand;
use Lighty\Kernel\Console\Command\Various\AllCommand;
use Lighty\Kernel\Console\Command\Command\testCommand;
use Lighty\Kernel\Console\Command\Info;


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
		self::setKernelClasses();
		//
		foreach (self::$kernelCommands as $value) 
			$app->add(new $value());
	}

	/**
	 * Add all user command classes to console
	 */
	public static function AddUserCommands($app)
	{
		self::setUserClasses();
		//
		foreach (self::$userCommands as $value) 
			$app->add(new $value());
	}

	/**
	 * Search for commmand classes of user
	 */
	public static function setUserClasses()
	{
		$namespace = "Lighty\App\Console\Commands";
		//
        foreach (get_declared_classes() as $value)
            if(\Strings::contains($value,$namespace)) 
            	self::$userCommands[] = $value;
	}

	/**
	 * Search for commmand classes of kernel
	 */
	public static function setKernelClasses()
	{
		$namespace = "Lighty\Kernel\Console\Commands";
		//
        foreach (get_declared_classes() as $value)
            if(\Strings::contains($value,$namespace)) 
            	self::$kernelCommands[] = $value;
	}

	/**
	 * Search for commmand classes of user
	 */
	public static function getUserClasses()
	{
		$classes = array();
		//
		$namespace = "Lighty\App\Console\Commands";
		//
        foreach (get_declared_classes() as $value)
            if(\Strings::contains($value,$namespace)) 
            	$classes[] = $value;

		return $classes;            
	}

	/**
	 * Search for commmand classes of kernel
	 */
	public static function getKernelClasses()
	{
		$classes = array();
		//
		$namespace = "Lighty\Kernel\Console\Commands";
		//
        foreach (get_declared_classes() as $value)
            if(\Strings::contains($value,$namespace)) 
            	$classes[] = $value;

		return $classes;
	}
}


