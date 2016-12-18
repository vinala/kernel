<?php 

namespace Vinala\Kernel\Http\Redirect;

use Vianal\Kernel\Routing\Url;

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

	function __construct(){}

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
	public function to($url , $extra = [] , $secure = null)
	{
		if ($this->isValidUrl($url)) {
            return $url;
        }

        $scheme = $this->getScheme($secure);

        $params = $this->setParams($extra);

        $url = $scheme . $url . $params;

		return $url;
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

	/**
	* To set get parameters
	*
	* @param array $args
	* @return string
	*/
	protected function setParams(array $args)
	{
		$request = '?';

		foreach ($args as $key => $value) 
		{
			if(is_numeric($key))
			{
				if($request != '?') $request .= '&';
				$request .= $value;
			}
			elseif(is_string($key))
			{
				if($request != '?') $request .= '&';
				$request .= $key.'='.$value;
			}
		}

		return $request;
	}

	/**
	* Check if the url used is a valid url
	*
	* @param string $url
	* @return bool
	*/
	protected function isValidUrl($url)
	{
		return Url::isValidUrl($url);
	}
	
	
	


	

}