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
	* The validator 
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

	/**
	* Make new validation procces
	*
	* @param array $data
	* @param array $rules
	* @return Vinala\Kernel\Validation\Validator
	*/
	public static function make(array $data , array $rules)
	{
		self::$validator = new V($data);

		foreach ($rules as $rule => $columns) 
		{
			$columns = self::separte($columns);
			self::$validator->rule(trim($rule) , $columns);
		}

		return new ValidationResult(self::$validator);
	}

	/**
	* Separte the data keys by |
	*
	* @param string $colmuns
	* @return array
	*/
	protected static function separte($colmuns)
	{
		return explode('|', $colmuns);
	}


	
	
	
	
	


	
}