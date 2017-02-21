<?php 

namespace Vinala\Kernel\Cache\Driver ;

use Stash\Pool;
use Stash\Driver\Apc as Adapter;

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
	// Constructor
	//--------------------------------------------------------

	function __construct()
	{
		$options = array('ttl' => 3600, 'namespace' => md5(__file__));

		// Set the driver
		$driver = new Adapter($options);

		// Set the Pool
		parent::call(new Pool($driver));
	}

}