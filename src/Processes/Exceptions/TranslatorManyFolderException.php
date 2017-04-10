<?php

namespace Vinala\Kernel\Process\Exception;

/**
* Directory not fount exception
*/
class TranslatorManyFolderException extends \Exception
{
    protected $message;
    //
    function __construct()
    {
        $this->message="Vinala can't detect sub folder in languages folder, use only one folder : \n'folder.file'";
    }
}
