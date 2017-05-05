<?php

namespace Vinala\Kernel\Support;

//use SomeClass;

/**
 * Class for functions arguments.
 *
 * @version 1.0
 *
 * @author Youssef Had
 *
 * @since v3.3.0
 */
class FunctionArgs
{
    //--------------------------------------------------------
    // Properties
    //--------------------------------------------------------

    /**
     * The arguments list.
     *
     * @var array
     */
    protected $args = [];

    //--------------------------------------------------------
    // Constructor
    //--------------------------------------------------------

    public function __construct($args)
    {
        $this->args = $args;
    }

    //--------------------------------------------------------
    // Functions
    //--------------------------------------------------------

    /**
     * Get arguments array.
     *
     * @return array
     */
    public function get()
    {
        return $this->args;
    }
}
