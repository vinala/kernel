<?php 

namespace Lighty\Kernel\Database\Exception;

/**
* Directory not fount exception
*/
class SeedersEmptyException extends \Exception{

	protected $message = "Seeders references to executed are empty in SeedsCaller";
}