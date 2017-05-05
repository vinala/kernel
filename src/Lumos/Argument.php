<?php

namespace Vinala\Kernel\Console;

/**
 *  Argument.
 */
class Argument
{
    /**
     * name of argument.
     *
     * @var OutputInterface
     */
    public $name;

    /**
     * if the argument is optional.
     */
    public $requirement;

    /**
     * description of argument.
     */
    public $description;

    public function __construct($name, $requirement = null, $description = '')
    {
        $this->name = $name;
        $this->requirement = $requirement;
        $this->description = $description;
    }
}
