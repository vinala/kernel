<?php

namespace Vinala\Kernel\Validation ;

use Vinala\Kernel\Filesystem\File;

use Vinala\Kernel\Validation\Exception\LanguageFileNotFoundException;
use Vinala\Kernel\Validation\Exception\ValidationRuleNotFoundException;
use InvalidArgumentException as IAE;

/**
* The Validation surface
*
* @version 2.0
* @author Youssef Had
* @package Vinala\Kernel\Validation
* @since v3.3.2
*/
class Validator 
{

   //--------------------------------------------------------
   // Properties
   //--------------------------------------------------------

   /**
    * All data of validator
    *
    * @var array
    */
   protected $data = [];

   /**
    * Fields of validation data
    *
    * @var array
    */
   protected $fields = [];

   /**
    * Translator file
    *
    * @var array
    */
   protected $lang;

   /**
    * All rules of instance validation
    *
    * @var array
    */
   protected $rules = [];



   //--------------------------------------------------------
   // Constructor
   //--------------------------------------------------------

   function __construct($data = array(), $file = null)
   {
      //set data
      $this->data($data);

      

      //set the language file
      $this->lang($file);
   }

   //--------------------------------------------------------
   // Setters and Getters
   //--------------------------------------------------------

   /**
    * Set data of validator.
    *
    * @param array $data
    * @param 
    *
    * @return null
    */
   public function data($data)
   {
      $this->data = $data;

      //set fields of data
      $this->fields();
   }

   //--------------------------------------------------------
   // Functions
   //--------------------------------------------------------

   /**
    * Set fields.
    *
    * @param 
    * @param 
    *
    * @return array
    */
   protected function fields()
   {
      foreach ($this->data as $key => $value) {
         $this->fields[] = $key;
      }

      return $this->fields;
   }

   /**
    * Set lang file.
    *
    * @param string $file
    * @param 
    *
    * @return string
    */
   public function lang($file)
   {
      $lang = config('lang.default');

      $file = $file ?: 'validation';

      $this->lang = $file;
      $file = $this->path().'resources/translator/'.$lang.'/'.$file.'.php';
      
      if(!File::exists($file)) {
         throw new LanguageFileNotFoundException('/'.$lang.'/'.$this->lang);
      }      
   }

   /**
    * Get main path of the app.
    *
    * @return 
    */
   protected function path()
   {
      $path = dirname(__DIR__);

      for ($i=0; $i < 4; $i++) { 
         $path = dirname($path);
      }
      
      return $path.'/';
   }

   /**
    * Set the rules of validation.
    *
    * @param array $rules
    *
    * @return 
    */
   public function rule( $rule, $fields, $value = null)
   {
      if($this->exists($rule)) {
         $_rule = [
            'rule' => ucfirst($rule),
            'fields' => $fields,
            'value' => $value,
            'message' => translate($this->lang.'.'.$rule),
         ];

         $this->rules[$rule] = $_rule;
      }
   }

   /**
    * Check if rule exists.
    *
    * @param string $name
    * @param 
    *
    * @return bool
    */
   protected function exists($name)
   {
      $ruleMethod = 'validate' . ucfirst($name);
      if (!method_exists($this, $ruleMethod)) {
         throw new ValidationRuleNotFoundException($name);
      }
      
      return true;
   }

   /**
    * The equals validation.
    *
    * @param array $fields
    * @param string $value
    *
    * @return 
    */
   public function validateEquals($fields ,$value)
   {
      if(count($fields) < 2 ) {
         throw new IAE("Fields of validation is not enough, must at least 2 fields");
      }

      $value = $this->data[array_values($fields)[0]];

      for ($i=1; $i < count($fields); $i++) { 
         if($this->data[$fields[$i]] == $value)
         {
            $value = $this->data[$fields[$i]];
         }
         else return false;
      }

      return true;
   }

   /**
    * The required validation.
    *
    * @param array $fields
    * @param string $value
    *
    * @return 
    */
   public function validateRequired($fields ,$value)
   { 
      for ($i=0; $i < count($fields); $i++) { 
         if(is_null($this->data[$fields[$i]]))
         {
            return false;
         } elseif(empty($this->data[$fields[$i]])) {
            return false;
         }
      }

      return true;
   }

   /**
    * Validate the current validation.
    *
    * @return bool
    */
   public function validate()
   {
      $res = array();
      dc($this);
      foreach ($this->rules as $key => $value) {
         $res[$key] = call_user_func_array([$this, 'validate'.$value['rule']], [$value['fields'], $value['value']]);
      }
      dc($res);
   }

}