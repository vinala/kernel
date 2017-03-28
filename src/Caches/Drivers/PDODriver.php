<?php 

namespace Vinala\Kernel\Cache\Driver ;

use Symfony\Component\Cache\Adapter\PdoAdapter as Adapter;
use Vinala\Kernel\Database\Database;

/**
* The PHP files cache driver
*
* @version 1.0
* @author Youssef Had
* @package Vinala\Kernel\Cache\Driver
* @since v3.3.0
*/
class PDODriver extends Driver
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
		// $path = '../'.config('cache.options.file.location');
		$lifetime = config('cache.lifetime');

		parent::call(new Adapter(Database::connect() , '' , $lifetime ));
	}

}