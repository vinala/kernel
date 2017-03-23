<?php 

namespace Vinala\Kernel\MVC\ORM;

use Vinala\Kernel\Collections\Collection as Table;

/**
* The class Collection of ORM
*/
class Collection
{

	//--------------------------------------------------------
	// Properties
	//--------------------------------------------------------

	/**
	* the array contains the ORMs
	*
	* @var array
	*/
    private $list = array();


    //--------------------------------------------------------
    // Constructor
    //--------------------------------------------------------


    function __construct($data = null)
    {
    	$this->list = is_null($data) ? array() : $data ;
    }


    //--------------------------------------------------------
    // Functions
    //--------------------------------------------------------

    /**
    * get list of rows of ORM
    *
    * @return array
    */
    public function get()
    {
    	return $this->list;
    }
    

    /**
    * add ORM to Collection
    *
    * @param ORM $object
    * @return null
    */
    public function add($object)
    {
    	$this->list[] = $object;
    }

    /**
    * count Collection list
    *
    * @return int
    */
    public function count()
    {
        return Table::count($this->list);
    }

}