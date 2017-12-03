<?php

namespace Vinala\Kernel\Validation ;

use Respect\Validation\Validator as BaseValidator;

/**
* Validation Surface
*
* @version 2.0
* @author Youssef Had
* @package Vinala\Kernel\Validation
* @since v3.4.0
*/
class Validator 
{

   //--------------------------------------------------------
   // Properties
   //--------------------------------------------------------

   /**
    * The object of the validation
    *
    * @var mixed
    */
   public $object = null;

   /**
    * Type of the object
    *
    * @var string
    */
   public $type = 'label';

   /**
    * Base validator
    *
    * @var string
    */
   public $validator = null;

   //--------------------------------------------------------
   // Constructor
   //--------------------------------------------------------

   function __construct($object = null , $type = 'label')
   {
      $this->object = $object;
      $this->type = $type;
      $this->validator = new BaseValidator;
   }

   //--------------------------------------------------------
   // Getters ans Setters 
   //--------------------------------------------------------
   

   public function __call($name,$args)
   {
      if(!($name == 'validate' || $name == 'check' || $name == 'error'  || $name == 'not')) {
         $this->validator = call_user_func_array([$this->validator ,$name], $args);
         return $this->validator;
      } 
   }


   //--------------------------------------------------------
   // Functions
   //--------------------------------------------------------

   /**
    * use a value to validate.
    *
    * @param int|string
    * @param 
    *
    * @return Validator
    */
   public function label($object)
   {
      $this->object = $object;
   }

   /**
    * validate the value.
    *
    * @param 
    * @param 
    *
    * @return 
    */
   public function validate()
   {
      return $this->validator->validate($this->object);
   }

   /**
    * negate any rule.
    *
    * @param BaseValidator $arg
    *
    * @return BaseValidator
    */
   public function not($arg)
   {
      $this->validator = $this->validator::not($arg);
      return $this->validator;
   }

   /**
    * Get the message error.
    *
    * @return string
    */
   public function error()
   {
      try {
         $this->validator->check($this->object);
      } catch(\Respect\Validation\Exceptions\ValidationException $e) {
         return $e->getMessage();
      }
   }

}