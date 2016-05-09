<?php

namespace Pikia\Kernel\Console;

/**
*  Argument
*/
class Argument
{
	
	/**
	 * name of argument
     *
	 * @var OutputInterface
	 */
	public $name;

    /**
     * if the argument is optional
     *
     */
    public $requirement;

    /**
     * description of argument
     *
     */
    public $description;



	function __construct($name, $requirement = null, $description = "")
	{
		$this->name = $name;
        $this->requirement = $requirement;
        $this->description = $description;
	}
}