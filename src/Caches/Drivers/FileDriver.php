<?php 

namespace Vinala\Kernel\Cache\Driver ;

use Symfony\Component\Cache\Adapter\FilesystemAdapter as Adapter;

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
		$lifetime = config('cache.lifetime');

		parent::call(new Adapter('' , $lifetime , $path ));
	}

}