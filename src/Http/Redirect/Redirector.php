<?php 

namespace Vinala\Kernel\Http\Redirect;

//use SomeClass;

/**
* Redirect class
*
* @version 1.0
* @author Youssef Had
* @package Vinala\Kernel\Http\Redirect
* @since v3.3.0
*/
class Redirector
{
	
	//--------------------------------------------------------
	// Properties
	//--------------------------------------------------------

	
	/**
	* Te scheme used for the last request
	*
	* @var string 
	*/
	protected $cacheScheme ;
	

	//--------------------------------------------------------
	// Constructor
	//--------------------------------------------------------

	function __construct()
	{
		
	}

	//--------------------------------------------------------
	// Functions
	//--------------------------------------------------------

	/**
	* Redirect to previous location
	*
	* @return mixed
	*/
	public function back()
	{
		return header('Location: javascript://history.go(-1)');
	}
	
	/**
	* Redirect to some url
	*
	* @param string $url
	* @return mixed
	*/
	public function to($url , $secure = null)
	{
		if ($this->isValidUrl($url)) {
            return $path;
        }

        $scheme = $this->getScheme($secure);

		return ;
	}

	/**
	* Get the scheme
	*
	* @param bool $secured
	* @return string
	*/
	protected function getScheme($secured = null)
	{
		if(is_null($secured))
		{
			if(is_null($this->cacheScheme))
			{
				$this->cacheScheme = request( 'REQUEST_SCHEME' , 'http' , 'server').'://';

				return $this->cacheScheme;
			}

			else $this->cacheScheme;
		}

		return $secured ? 'http://' : 'https://' ;
	}
	


	

}