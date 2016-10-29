<?php 

namespace Vinala\Kernel\Database\Connector\Exception;

/**
* Directory not fount exception
*/
class ConnectorException extends \Exception
{
	protected $message = "We cannot connect to database";
}