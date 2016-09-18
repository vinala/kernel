<?php

namespace Lighty\Kernel\Database;

use Lighty\Kernel\Config\Config;


/**
* Schema builder class
*/
class Schema
{
	/**
	 * String contains main Sql query 
	 *
	 * @var string
	 */
	static $query;

	/**
	 * Array contains Sql colmuns
	 *
	 * @var array
	 */
	static $colmuns = array();
}