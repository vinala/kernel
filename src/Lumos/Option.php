<?php

namespace Vinala\Kernel\Console;

/**
 *  Argument.
 */
class Option
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

    /**
     * default value.
     */
    public $value;

    public function __construct($name, $requirement = null, $description = '', $value = null)
    {
        $this->name = $name;
        $this->requirement = $requirement;
        $this->description = $description;
        $this->value = $value;
    }
}
