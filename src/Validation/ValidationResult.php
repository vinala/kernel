<?php 

namespace Vinala\Kernel\Validation;

/**
* Result of Validation
*/
class ValidationResult
{

	/**
	* Errors array
	*
	* @var array 
	*/
	protected static $errors = array() ;


	/**
	* If validation fails
	*
	* @var bool 
	*/
	protected static $fails = false ;


	/**
	* The validator class
	*
	* @var Valitron\Validator 
	*/
	protected static $validator ;
	
	
	
	
}