<?php 

namespace Lighty\Kernel\Mocking;

use Lighty\Kernel\Foundation\Application;

/**
* Mocking class
*/
class configMocking
{
	protected static function mockAlias()
	{
		return 
			array('enable' => true ,
				'aliases' => array( 
					'Alias' => 			Lighty\Kernel\Config\Alias::class,
					'App' => 			Lighty\Kernel\Foundation\Application::class,
					'Auth' => 			Lighty\Kernel\Security\Auth::class,
					'Base' => 			Lighty\Kernel\Objects\Base::class,
					'Cache' => 			Lighty\Kernel\Caches\Cache::class,
					'Config' => 		Lighty\Kernel\Config\Config::class,
					'Cookie' => 		Lighty\Kernel\Storage\Cookie::class,
					'Database' => 		Lighty\Kernel\Database\Database::class,
					'DataCollection' =>	Lighty\Kernel\Objects\DataCollection::class,
					'DBTable' => 		Lighty\Kernel\Database\DBTable::class,
					'Debug' => 			Lighty\Kernel\Log\Debug::class,
					'Errors' => 		Lighty\Kernel\Http\Errors::class,
					'Faker' => 			Lighty\Kernel\Resources\Faker::class,
					'Filesystem' => 	Lighty\Kernel\Filesystem\Filesystem::class,
					'Hash' => 			Lighty\Kernel\Security\Hash::class,
					'Html' => 			Lighty\Kernel\HyperText\Html::class,
					'Http' => 			Lighty\Kernel\Http\Http::class,
					'Input' => 			Lighty\Kernel\HyperText\Input::class,
					'Libs' => 			Lighty\Kernel\Resources\Libs::class,
					'License' => 		Lighty\Kernel\Security\License::class,
					'Links' => 			Lighty\Kernel\Http\Links::class,
					'Log' => 			Lighty\Kernel\Logging\Log::class,
					'Mail' => 			Lighty\Kernel\Mailing\Mail::class,
					'ModelArray' => 	Lighty\Kernel\MVC\Model\ModelArray::class,
					'Path' => 			Lighty\Kernel\Access\Path::class,
					'Res' => 			Lighty\Kernel\HyperText\Res::class,
					'Root' => 			Lighty\Kernel\Http\Root::class,
					'Route' => 			Lighty\Kernel\Router\Route::class,
					'Schema' => 		Lighty\Kernel\Database\Schema::class,
					'Security' => 		Lighty\Kernel\Security\Security::class,
					'Session' => 		Lighty\Kernel\Storage\Session::class,
					'Smile' => 			Lighty\Kernel\Translator\Smiley::class,
					'Storage' => 		Lighty\Kernel\Storage\Storage::class,
					'Strings' => 		Lighty\Kernel\Objects\Strings::class,
					'Sys' => 			Lighty\Kernel\Objects\Sys::class,
					'Table' => 			Lighty\Kernel\Objects\Table::class,
					'Time' => 			Lighty\Kernel\Objects\DateTime::class,
					'Translator' => 	Lighty\Kernel\Translator\Lang::class,
					'Url' => 			Lighty\Kernel\Access\Url::class,
					'Vars' => 			Lighty\Kernel\Objects\Vars::class,
					'View' => 			Lighty\Kernel\MVC\View\View::class,
		));
	}

	protected static function mockLoggin()
	{
		return array(
			'debug' => false,
			'msg' => "Ohlala! il semble que quelque chose s'ait mal passé",
			'log' => 'app/storage/logs/pikia.log',
			'bg' => '#a4003a',);
	}

	protected static function mockApp()
	{
		return array(
					'project'=>'Pikia Kernel', 
					'owner'=>'Youssef', 
					'url'=>Application::root(), 
					'title'=> 'Pikia PHP Framework',
					'timezone'=> 'UTC',  
					'unrouted'=> true, 
					'charset'=> 'utf-8', 
				);
	}

	public static function mock()
	{
		return 
			[ 
				"alias" => self::mockAlias(),
				"loggin" => self::mockLoggin(),
				"app" => self::mockApp(),
			];
	}
}