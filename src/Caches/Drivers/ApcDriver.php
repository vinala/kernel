<?php 

namespace Vinala\Kernel\Cache\Driver ;

use Symfony\Component\Cache\Adapter\ApcuAdapter as Adapter;

/**
* The file system cache driver
*
* @version 1.0
* @author Youssef Had
* @package Vinala\Kernel\Cache\Driver
* @since v3.3.0
*/
class ApcDriver extends Driver
{
	//--------------------------------------------------------
	// Proprties
	//--------------------------------------------------------

	/**
	* The Library used by the driver
	*
	* @var string
	*/
	private $library = 'symfony' ;

	//--------------------------------------------------------
	// Constructor
	//--------------------------------------------------------

	function __construct()
	{
		$lifetime = config('cache.lifetime');

		// Set the driver
		$driver = new Adapter('' , $lifetime);

		parent::call(new Pool($driver));
	}

}