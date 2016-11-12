<?php 

namespace Vinala\Kernel\Html ;

use Vinala\Kernel\Storage\Session;

/**
* Form Class
*/
class Form
{
	/**
	* array for framework reserved attributes
	*
	* @var array 
	*/
	protected static $reserved = array('method' , 'action' , 'url' , 'charset' , 'files');


	
	/**
	* array of labels used in form
	*
	* @var array 
	*/
	protected static $labels = array() ;


	/**
	* the CSRF token
	*
	* @var string 
	*/
	protected static $csrfToken ;
	


	/**
	* function to open the form
	*
	* @param array $options
	* @return string
	*/
	public static function open( array $options = array() )
	{
		// get the method passed in $options else use port
		$method = array_get($options, 'method', 'post');
		$attributes['method'] = self::getMethod($method);
		
		$attributes['action'] = self::getAction($options);
		$attributes['accept-charset'] = array_get($options, 'charset' , 'UTF-8');
		//
		//PUT and PATCH and DELETE
		//
		//if form use files
		if (isset($options['files']) && $options['files'])
		{
			$options['enctype'] = 'multipart/form-data';
		}
		
		$attributes = array_merge(
			$attributes, array_except($options, self::$reserved)
		);
		
		$attributes = Html::attributes($attributes);

		return '<form'.$attributes.'>';
	}

	/**
	* function to set form method to upper 
	* and eccept ONLY get and post
	*
	* @param string $method
	* @return string
	*/
	protected static function getMethod($method)
	{
		$method = strtoupper($method);
		//
		return $method != "GET" ? "POST" : $method;
	}

	/**
	* Function to set the method
	*
	* @param array $options
	* @return string
	*/
	protected static function getAction(array $options)
	{
		//check if action is URL
		if(array_has($options , 'url'))
		{
			return 'http://'.array_get($options , 'url');
		}

		//check if action is secure for HTTPS
		if(array_has($options , 'secure'))
		{
			return 'https://'.array_get($options , 'secure');
		}

		//check if action is route
		if(array_has($options , 'route'))
		{
			return path().array_get($options , 'route');
		}
	}
	

	/**
	* function to close form
	*
	* @return string
	*/
	public static function close()
	{
		self::$labels = null;

		return '</form>';
	}

	/**
	 * Get the ID attribute for a field name.
	 *
	 * @param  string  $name
	 * @param  array   $attributes
	 * @return string
	 */
	public static function getIdAttribute($name, $attributes)
	{
		if (array_has($attributes , 'id' ))
		{
			return $attributes['id'];
		}
		if (in_array($name, self::$labels))
		{
			return $name;
		}
	}

		/**
	 * Create a form input field.
	 *
	 * @param  string  $type
	 * @param  string  $name
	 * @param  string  $value
	 * @param  array   $options
	 * @return string
	 */
	public static function input($type, $name, $value = null, $options = array())
	{
		if ( ! isset($options['name'])) $options['name'] = $name;


		$id = self::getIdAttribute($name, $options);
		// if ( ! in_array($type, $this->skipValueTypes))
		// {
		// 	$value = $this->getValueAttribute($name, $value);
		// }

		$merge = compact('type', 'value', 'id');
		$options = array_merge($options, $merge);
		return '<input'.Html::attributes($options).'>';
	}


	/**
	* Create a form input hidden
	*
	* @param string $name
	* @param string $value
	* @param array $options
	* @return string
	*/
	public static function hidden($name , $value = null , array $options = array())
	{
		$options = array_except($options , ['type','value','name']);

		return self::input("hidden" , $name , $value , $options);
	}

	/**
	* Create a form csrf input hidden
	*
	* @return string
	*/
	public static function token()
	{
		$token = ! empty(self::$csrfToken) ? self::$csrfToken : Session::token() ;

		return self::hidden("_token" , $token);
	}
	
	/**
	* function to genenrate input text
	*
	* @param string $name
	* @param string $value
	* @param array $options
	* @return string
	*/
	public static function text($name , $value = null , array $options = array())
	{
		$options = array_except($options , ['type','value','name']);
		
		return self::input("text" , $name , $value , $options);
	}

	/**
	* function to genenrate submit
	*
	* @param string $value
	* @param array $options
	* @return string
	*/
	public static function submit($value , array $options = array())
	{
		$options = array_except($options , ['type','value']);

		return self::input("submit" , 'null' , $value , $options);

	}

	/**
	* Create a form label
	*
	* @param string $name
	* @param string $value
	* @param array $options
	* @return string
	*/
	public static function label($name ,$value = null , array $options = array() )
	{
		$options = array_except($options , ['value' , 'for']);

		self::$labels[] = $name;

		$value = e(self::formatLabel($name, $value));

		$options = Html::attributes($options);

		return '<label for="'.$name.'"'.$options.'>'.$value.'</label>';
	}

	/**
	* Get label form name and format
	*
	* @param string $name
	* @param string $value
	* @return string
	*/
	public static function formatLabel($name , $value)
	{
		return $value ?: ucwords(str_replace("_", " ", $name));
	}
	
	


	
	
	
	
}