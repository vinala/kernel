<?php 

namespace Vinala\Kernel\Html ;

/**
* Class for HTML Builder
*/
class Html
{
	
	/**
	* array for opened tags
	*
	* @var array
	*/
	protected static $opened = array();


	/**
	* open html tag
	*
	* @param string $tag
	* @param array $options
	* @return string
	*/
	public static function open($tag ,array $options = array() , $self = false)
	{
		$attributes = Html::attributes($options);

		//add the opened tag to $opened array
		if( ! $self || is_null($self) )
		{
			self::$opened[] = $tag;
			//
			return '<'.$tag.$attributes.'>';
		}
		else
			return '<'.$tag.$attributes.' />';
	}

	/**
	* close the last open html tag
	*
	* @return string
	*/
	public static function close()
	{
		//get the last opened tag
		$tag = self::$opened[count(self::$opened)-1];

		//remove the last opened tag
		array_pop(self::$opened);

		return '</'.$tag.'>';
	}
		


	/**
	 * Build an HTML attribute string from an array.
	 *
	 * @param  array  $attributes
	 * @return string
	 */
	public static function attributes($attributes)
	{
		$html = array();
		// For numeric keys we will assume that the key and the value are the same
		// as this will convert HTML attributes such as "required" to a correct
		// form like required="required" instead of using incorrect numerics.
		foreach ((array) $attributes as $key => $value)
		{
			$element = self::attributeElement($key, $value);
			if ( ! is_null($element)) $html[] = $element;
		}
		return count($html) > 0 ? ' '.implode(' ', $html) : '';
	}

	/**
	 * Build a single attribute element.
	 *
	 * @param  string  $key
	 * @param  string  $value
	 * @return string
	 */
	protected static function attributeElement($key, $value)
	{
		if (is_numeric($key)) $key = $value;
		if ( ! is_null($value)) return $key.'="'.e($value).'"';
	}

	/**
	* Build a self HTML Tag
	*
	* @param string $tag
	* @param array $options
	* @return string
	*/
	protected static function selfTag($tag , $options = array())
	{
		return static::open($tag , $options , true);
	}

	/**
	* The HTML charset tag
	*
	* @param string $encode
	* @return string
	*/
	public static function charset( $encode = null)
	{
		if( is_null($encode)) 
		{
			$encode = config( 'app.charset' );
		}

		return sattic::selfTag('meta' , ['charset' => $encode]);
	}
	
}