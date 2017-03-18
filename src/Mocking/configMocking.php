<?php 

namespace Vinala\Kernel\Mocking;

use Vinala\Kernel\Foundation\Application;

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
					'Alias' => 			Vinala\Kernel\Config\Alias::class,
					'App' => 			Vinala\Kernel\Foundation\Application::class,
					'Auth' => 			Vinala\Kernel\Security\Auth::class,
					'Base' => 			Vinala\Kernel\Objects\Base::class,
					'Cache' => 			Vinala\Kernel\Caches\Cache::class,
					'Config' => 		Vinala\Kernel\Config\Config::class,
					'Cookie' => 		Vinala\Kernel\Storage\Cookie::class,
					'Database' => 		Vinala\Kernel\Database\Database::class,
					'DataCollection' =>	Vinala\Kernel\Objects\DataCollection::class,
					'DBTable' => 		Vinala\Kernel\Database\DBTable::class,
					'Debug' => 			Vinala\Kernel\Log\Debug::class,
					'Errors' => 		Vinala\Kernel\Http\Errors::class,
					'Faker' => 			Vinala\Kernel\Resources\Faker::class,
					'Filesystem' => 	Vinala\Kernel\Filesystem\Filesystem::class,
					'Hash' => 			Vinala\Kernel\Security\Hash::class,
					'Html' => 			Vinala\Kernel\HyperText\Html::class,
					'Http' => 			Vinala\Kernel\Http\Http::class,
					'Input' => 			Vinala\Kernel\HyperText\Input::class,
					'Libs' => 			Vinala\Kernel\Resources\Libs::class,
					'License' => 		Vinala\Kernel\Security\License::class,
					'Links' => 			Vinala\Kernel\Http\Links::class,
					'Log' => 			Vinala\Kernel\Logging\Log::class,
					'Mail' => 			Vinala\Kernel\Mailing\Mail::class,
					'ModelArray' => 	Vinala\Kernel\MVC\Model\ModelArray::class,
					'Path' => 			Vinala\Kernel\Access\Path::class,
					'Res' => 			Vinala\Kernel\HyperText\Res::class,
					'Root' => 			Vinala\Kernel\Http\Root::class,
					'Route' => 			Vinala\Kernel\Router\Route::class,
					'Schema' => 		Vinala\Kernel\Database\Schema::class,
					'Security' => 		Vinala\Kernel\Security\Security::class,
					'Session' => 		Vinala\Kernel\Storage\Session::class,
					'Smile' => 			Vinala\Kernel\Translator\Smiley::class,
					'Storage' => 		Vinala\Kernel\Storage\Storage::class,
					'Strings' => 		Vinala\Kernel\String\Strings::class,
					'Sys' => 			Vinala\Kernel\Objects\Sys::class,
					'Collection' => 			Vinala\Kernel\Collections\Collection::class,
					'Time' => 			Vinala\Kernel\Objects\DateTime::class,
					'Translator' => 	Vinala\Kernel\Translator\Lang::class,
					'Url' => 			Vinala\Kernel\Access\Url::class,
					'Vars' => 			Vinala\Kernel\Objects\Vars::class,
					'View' => 			Vinala\Kernel\MVC\View\View::class,
		));
	}

	protected static function mockLoggin()
	{
		return array(
			'debug' => false,
			'msg' => "Ohlala! il semble que quelque chose s'ait mal passé",
			'log' => 'app/storage/logs/lighty.log',
			'bg' => '#a4003a',);
	}

	protected static function mockApp()
	{
		return array(
					'project'=>'Lighty Kernel', 
					'owner'=>'Youssef', 
					'url'=>Application::root(), 
					'title'=> 'Lighty PHP Framework',
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