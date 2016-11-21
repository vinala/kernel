<?php 

namespace Vinala\Kernel\Validation;

use Valitron\Validator as V;

/**
* Result of Validation
*/
class ValidationResult
{

	//--------------------------------------------------------
	// Properties
	//--------------------------------------------------------

	/**
	* Errors array
	*
	* @var array 
	*/
	protected $errors = array() ;

	/**
	* Error string
	*
	* @var string
	*/
	protected $error ;

	/**
	* If validation fails
	*
	* @var bool 
	*/
	protected $fails = null ;


	/**
	* The validator class
	*
	* @var Valitron\Validator 
	*/
	protected $validator ;

	//--------------------------------------------------------
	// Constructor
	//--------------------------------------------------------

	function __construct(V $validator)
	{
		$this->validator = $validator;
	}

	//--------------------------------------------------------
	// Functions
	//--------------------------------------------------------		

	/**
	* Check if validation fails
	*
	* @return bool
	*/
	public function fails()
	{
		$this->fails = ! $this->validator->validate();

		return $this->fails;
	}

	/**
	* Get first validation error if exists 	
	*
	* @return string
	*/
	public function error()
	{
		$errors = $this->validator->errors();

		$this->error = empty($errors) ?: array_pop($errors)[0];

		return $this->error ;
	}

	/**
	* Get validation errors if exists 	
	*
	* @return string
	*/
	public function errors()
	{
		$this->errors = $this->validator->errors();

		return $this->errors ;
	}
	
	
	
	
}