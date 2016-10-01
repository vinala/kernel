<?php 

use Lighty\Kernel\Database\Query;
use Lighty\Kernel\Config\Config;
use Lighty\Kernel\Objects\Table;
use Lighty\Kernel\Objects\DateTime as Time;
//
use Lighty\Kernel\MVC\ORM\Exception\TableNotFoundException;
use Lighty\Kernel\MVC\ORM\Exception\ManyPrimaryKeysException;
use Lighty\Kernel\MVC\ORM\Exception\PrimaryKeyNotFoundException;

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
	* the name of the model table with prifix
	*
	* @var string
	*/
    protected $prifixTable;

	/**
	* the name and value of primary key of the model
	*
	* @var array
	*/
    public $key = array();


    /**
	* the name of primary key of the model
	*
	* @var string
	*/
    protected $keyName;

    /**
	* the value of primary key of the model
	*
	* @var string
	*/
    protected $keyValue;

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

    /**
	* if this data row is stashed all data 
	* will be stored in this array
	*
	* @var array
	*/
    protected $stashedData ;

    



    //--------------------------------------------------------
    // Constructor
    //--------------------------------------------------------



    /**
	* The constructor
	*
	*/
	function __construct($key = null)
	{
		$this->getTable();
		$this->columns();
		$this->key();
		if( ! is_null($key)) $this->struct($key);
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
		$this->prifixTable = ( Config::get('database.prefixing') ? Config::get('database.prefixe') : "" ) . $this->table ;
		//
		if( ! $this->checkTable() ) throw new TableNotFoundException($this->table);
		//
		return $this->prifixTable;
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
			->andwhere("TABLE_NAME","=",$this->prifixTable)
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
			->andwhere("TABLE_NAME","=",$this->prifixTable)
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

	/**
	* function execute SQL query to get Primary keys
	*
	* @return array
	*/
	protected function getPK()
	{
		switch (Config::get('database.default')) 
		{
			case 'sqlite': break;
			case 'mysql':
					return Database::read("SHOW INDEX FROM ".$this->prifixTable." WHERE `Key_name` = 'PRIMARY'");
				break;

			case 'pgsql': break;
			case 'sqlsrv': break;
		}
	}

	/**
	* set primary key
	* the framework doesn't support more the column to be 
	* the primary key otherwise exception will be thrown
	*
	* @return null
	*/
	protected function key()
	{
		$data = $this->getPK();
		//
		if(Table::count($data) > 1) throw new ManyPrimaryKeysException();
		else if(Table::count($data) == 0 ) throw new PrimaryKeyNotFoundException($this->table);
		//
		$this->keyName = $data[0]['Column_name'];
		$this->key["name"] = $data[0]['Column_name'];
	}

	/**
	* get data from data table according to primary key value
	*
	* @param int $key
	* @return null
	*/
	protected function struct($key)
	{
		$data = $this->dig($key);
		//
		if(Table::count($data) == 1)
		{
			if( $this->canStashed && $this->stashedAt($data) ) $this->stashed = true ;
			//
			$this->convert($data);
		}
	}

	/**
	* search for data by Query Class according to primary key
	*
	* @param int $key
	* @return array
	*/
	protected function dig($key)
	{
		return Query::from($this->table)
			->select("*")
			->where( $this->keyName , "=" , $key)
			->get(Query::GET_ARRAY);
	}

	/**
	* check if this data is already stashed
	*
	* @param array $data
	* @return bool
	*/
	protected function stashedAt($data)
	{
		if(is_null($data[0]["deleted_at"])) return false;
		else return $data[0]["deleted_at"] < Time::current();
	}

	/**
	* make data array colmuns as property
	* in case of hidden data property was true
	* data will be stored in hidden data 
	* instead ofas property
	*
	* @param array $data
	* @return null
	*/
	protected function convert($data)
	{
		foreach ($data[0] as $key => $value) 
			if( ! $this->stashed ) 
			{
				$this->$key = $value ;
				$this->setKey($key , $value);
			}
			else $this->stashedData[$key] = $value ;
	}

	/**
	* set the primary key value by verifying
	* the name of the key in data array and
	* the name of $keyName property
	*
	* @param string $key
	* @param string $value
	* @return null
	*/
	protected function setKey($key , $value)
	{
		if($key == $this->keyName)
		{
			$this->keyValue = $value;
			$this->key["value"] = $value;
		}
	}

	
	



	
	
	
	
	
	
	
	
	
	
	
}
