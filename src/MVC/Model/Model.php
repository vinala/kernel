<?php 

use Lighty\Kernel\Database\Query;
use Lighty\Kernel\Config\Config;
use Lighty\Kernel\Objects\Table;
//
use Lighty\Kernel\MVC\ORM\Exception\TableNotFoundException;

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
	* if data table could have stashed data
	* with the columns deleted_at
	*
	* @var bool
	*/
    protected $canStashed = false;

    /**
	* if this data row is stashed
	*
	* @var bool
	*/
    protected $stashed ;

    /**
	* if data table is tracked data
	* with the columns created_at and edited_at
	*
	* @var bool
	*/
    protected $tracked ;

    



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
		if( ! $this->checkTable() ) throw new TableNotFoundException($this->table);
		//
		return $this->table;
	}

	/**
	* Check if table exists in database
	*
	* @param $table string
	* @return bool
	*/
	protected function checkTable()
	{
		$data = Query::from("information_schema.tables" , false)
			->select("*")
			->where("TABLE_SCHEMA","=",Config::get('database.database'))
			->andwhere("TABLE_NAME","=",$this->table)
			->get(Query::GET_ARRAY);
		//
		return (Table::count($data) > 0 ) ? true : false;
	}
	

	/**
	* to get and set all columns of data table
	*
	* @return array
	*/
	protected function columns()
	{
		$this->columns = $this->extruct(
			Query::from("INFORMATION_SCHEMA.COLUMNS" , false)
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
				// Check if stashed
				if( ! $this->canStashed ) $this->isStashed($subValue);
				//
				// Check if tracked
				if( ! $this->tracked ) $this->isTracked($subValue);
			}
		//
		return $data;
	}

	/**
	* check if data table could have stashed data
	*
	* @param $column string
	* @return bool
	*/
	protected function isStashed($column)
	{
		if($column == "deleted_at") $this->canStashed = true;
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