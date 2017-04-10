<?php

namespace Vinala\Kernel\MVC\ORM\Exception;

/**
* Directory not fount exception
*/
class ManyPrimaryKeysException extends \Exception
{

    protected $message = "Vinala Framework doesn't support many primary keys in ine DataTable";   // exception message
}
