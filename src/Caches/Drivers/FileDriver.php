<?php 

namespace Vinala\Kernel\Cache\Driver ;

use Stash\Pool;
use Stash\Driver\FileSystem as Adapter;

/**
* The file system cache driver
*
* @version 1.0
* @author Youssef Had
* @package Vinala\Kernel\Cache\Driver
* @since v3.3.0
*/
class FileDriver extends Driver
{
	//--------------------------------------------------------
	// Constructor
	//--------------------------------------------------------

	function __construct()
	{
		$path = '../'.config('cache.options.file.location');

		// Set the driver
		$driver = new Adapter(['path' => $path]);

		// Set the Pool
		parent::call(new Pool($driver));
	}

}