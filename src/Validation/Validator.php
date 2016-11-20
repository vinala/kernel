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
			self::$validator->rule($rule, $columns);
		}
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

	/**
	* Check if validation fails
	*
	* @return bool
	*/
	public static function fails()
	{
		return ! self::$validator->validate();
	}

	/**
	* Get first validation error if exists 	
	*
	* @return string
	*/
	public static function error()
	{
		$errors = self::$validator->errors();

		return empty($errors) ?: array_pop($errors);
	}
	
	
	
	
	


	
}