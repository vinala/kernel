<?php 

namespace Lighty\Kernel\MVC\ORM;

/**
* Relational Objects Array (ROA)
*/
class ROA
{

	//--------------------------------------------------------
	// Properties
	//--------------------------------------------------------

	/**
	* the array contains the ORMs
	*
	* @var array
	*/
    public $list = array();


    //--------------------------------------------------------
    // Constructor
    //--------------------------------------------------------


    function __construct($data = null)
    {
    	$this->list = $data;
    }


    //--------------------------------------------------------
    // Functions
    //--------------------------------------------------------


    /**
    * add ORM to ROA
    *
    * @param ORM $object
    * @return null
    */
    public function add($object)
    {
    	$this->list[] = $object;
    }

}