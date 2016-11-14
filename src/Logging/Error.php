<?php 

namespace Vinala\Kernel\Logging;

/**
* Class Error to handle with errors
*/
class Error
{


	/**
	* if true the frameworrk will debug your errors
	*
	* @var bool 
	*/
	protected $debug ;


	/**
	* if the handler was registered
	*
	* @var book 
	*/
	protected $registered = array() ;
	
	function __construct()
	{
		
	}


	/**
	* Register Error hundler
	*
	* @return null
	*/
	public function register()
	{
		$this->debug = config("loggin.debug");

		set_error_handler(array($this, 'onError'));
        set_exception_handler(array($this, 'onException'));

        $previousDisplayErrorsSetting = ini_get('display_errors');
        ini_set('display_errors', '0');

        register_shutdown_function(array($this, 'onShutdown'));
	}

	/**
	* Error Handler
	*
	* @return null
	*/
	public function onError($code, $message, $file = null, $line = null, array $context = null)
    {
    	
	}

	/**
	* Exception Handler
	*
	* @param Exception $exception
	* @return null
	*/
	public function onException($exception)
    {
    	
    }

    /**
	* Application Shutdown Handler
	*
	* @param Exception $exception
	* @return null
	*/
    public function onShutdown()
    {
    	
    }
	
}