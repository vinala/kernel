<?php 

namespace Vinala\Kernel\Process ;

//use SomeClass;

/**
* Alias process class
*
* @version 1.0
* @author Youssef Had
* @package Vinala\Kernel\Process
* @since v3.3.0
*/
class Alias
{

	//--------------------------------------------------------
	// Functions
	//--------------------------------------------------------

	/**
	* Get documentation of config file
	*
	* @return array
	*/
	protected static function docs()
	{
		return [
			'enable' => "\n\t/*\n\t|----------------------------------------------------------\n\t| Enable Aliases\n\t|----------------------------------------------------------\n\t| Here to activate classes aliases\n\t|\n\t**/\n",

			'kernel' => "\n\t/*\n\t|----------------------------------------------------------\n\t| Kernel Aliases\n\t|----------------------------------------------------------\n\t| this array is responsible for aliases of class\n\t| in the kernel.\n\t|\n\t**/\n",

			'user' => "\n\t/*\n\t|----------------------------------------------------------\n\t| User Aliases\n\t|----------------------------------------------------------\n\t| this array is responsible for your aliases, feel\n\t| free to register as many as \n\t| you wish as the aliases are 'lazy' loaded so \n\t| they don't hinder performance.\n\t|\n\t**/",

			'exceptions' => "\n\t/*\n\t|----------------------------------------------------------\n\t| Exceptions Aliases\n\t|----------------------------------------------------------\n\t| this array is responsible for aliases of exceptions class\n\t| classes\n\t|\n\t**/",

			'controllers' => "\n\t/*\n\t|----------------------------------------------------------\n\t| Controllers Aliases\n\t|----------------------------------------------------------\n\t| this array is responsible for aliases of controllers class\n\t| classes\n\t|\n\t**/",

			'models' => "\n\t/*\n\t|----------------------------------------------------------\n\t| Models Aliases\n\t|----------------------------------------------------------\n\t| this array is responsible for aliases of models class\n\t| classes\n\t|\n\t**/",
		];
	}

	/**
	* Set the config params
	*
	* @param bool $enabled
	* @param array $params
	* @return bool
	*/
	public static function set($enabled , $params)
	{
		$docs = self::docs();

		$enabled = $docs['enabled'].self::enbaledFormat($enabled);
		$kernel = $docs['kernel'].self::kernelFormat($params['kernel']);

		return true;
	}

	/**
	* Enabled switch format
	*
	* @param bool $enabled
	* @return string
	*/
	protected static function enbaledFormat($enabled)
	{
		return "'enable' => ".($enabled ? 'true' : 'false')." ,";
	}

	/**
	* Kernel array format
	*
	* @param array $data
	* @return string
	*/
	protected static function kernelFormat($data)
	{
		$format = "\t'kernel' => [\n";

		foreach ($data as $key => $value) {
			$format .= "\t\t'$key' => $value::class , \n";
		}

		$format .= "\t],";

		return $format;
	}
	
	
	

}