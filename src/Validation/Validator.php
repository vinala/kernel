<?php 

namespace Vinala\Kernel\Validation;

use Valitron\Validator as V;

/**
* Validatior class
*/
class Validator
{
	
	//--------------------------------------------------------
	// Properties
	//--------------------------------------------------------

	/**
	* the Kint validator 
	*
	* @var Valitron\Validator
	*/
	protected static $validator ;

	/**
	* Translator folder path
	*
	* @var string 
	*/
	protected static $langFolder ;

	/**
	* Translator file path
	*
	* @var string 
	*/
	protected static $langFile ;
	
	//--------------------------------------------------------
	// Functions
	//--------------------------------------------------------

	/**
	* Initiate validator
	*
	* @return null
	*/
	public static function ini()
	{
		$lang = config('lang.default');

		self::$langFolder = dirname(dirname(__DIR__))."/app/lang/".$lang;
		self::$langFile = self::$langFolder."/validator.php";
		if(is_file(self::$langFile))
		{
			V::langDir(self::$langFolder); 
			V::lang('validator');
		}
	}
	


	
}