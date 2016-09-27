<?php 

use Lighty\Kernel\Database\Query;
use Lighty\Kernel\Config\Config;

/**
* The Mapping Objet-Relationnel (ORM) class
* 
* Beta (Source code name : model)
*/
class Model
{

	//--------------------------------------------------------
	// Properties
	//--------------------------------------------------------


	/**
	* the name and value of primary key of the model
	*
	* @var array
	*/
    protected $key = array();


    /**
	* the name of primary key of the model
	*
	* @var string
	*/
    protected $KeyName;

    /**
	* the value of primary key of the model
	*
	* @var string
	*/
    protected $KeyValue;

    /**
	* the value of the model table name
	*
	* @var string
	*/
    protected $table;

    /**
	* array contains all columns of data table
	*
	* @var array
	*/
    public $columns = array();

    /**
	* if data table could have reserved data
	* with the columns deleted_at
	*
	* @var bool
	*/
    public $reserved = false;

    /**
	* if data table could have tracked data
	* with the columns created_at and edited_at
	*
	* @var bool
	*/
    public $tracked = false;



    //--------------------------------------------------------
    // Constructor
    //--------------------------------------------------------



    /**
	* The constructor
	*
	*/
	function __construct()
	{
		$this->getTable();
		$this->columns();
	}

	//--------------------------------------------------------
    // Functions
    //--------------------------------------------------------

	/**
	* get the model table name
	*
	* @param $table
	* @return null
	*/
	public function getTable()
	{
		$this->table = ( Config::get('database.prefixing') ? Config::get('database.prefixe') : "" ) . $this->table ;
		//
		return $this->table;
	}

	/**
	* to get and set all columns of data table
	*
	* @return array
	*/
	protected function columns()
	{
		$this->columns = $this->extruct(
			Query::table("INFORMATION_SCHEMA.COLUMNS" , false)
			->select("COLUMN_NAME")
			->where("TABLE_SCHEMA","=",Config::get('database.database'))
			->andwhere("TABLE_NAME","=",$this->table)
			->get(Query::GET_ARRAY)
			);
		//
		return $this->columns;
	}

	/**
	* convert array rows from array to string
	* this function is used columns() function
	*
	* @param $columns array
	* @return array
	*/
	protected function extruct($columns)
	{
		$data = array();
		//
		foreach ($columns as $value)
			foreach ($value as $subValue)
			{
				$data[] = $subValue;
				//
				// Check if reserved
				if( ! $this->reserved ) this->isReserved($subValue);
				//
				//
				if( ! $this->tracked ) this->isTracked($subValue);
			}
		//
		return $data;
	}

	/**
	* check if data table could have reserved data
	*
	* @param $column string
	* @return bool
	*/
	protected function isReserved($column)
	{
		if($column == "deleted_at") $this->reserved = true;
	}

	/**
	* check if data table could have tracked data
	*
	* @param $column string
	* @return bool
	*/
	protected function isTracked($column)
	{
		if($column == "deleted_at" || $column == "edited_at") 
			$this->tracked = true;
	}
	
	
	
	
	
}