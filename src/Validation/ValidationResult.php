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
	* If validation fails
	*
	* @var bool 
	*/
	protected $fails = false ;


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
	
	
	
	
}