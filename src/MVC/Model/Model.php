<?php 

use Lighty\Kernel\Database\Query;
use Lighty\Kernel\Config\Config;
use Lighty\Kernel\Objects\Table;
use Lighty\Kernel\Objects\DateTime as Time;
use Lighty\Kernel\MVC\ORM\CRUD;
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
	* if data table could have kept data
	* with the columns deleted_at
	*
	* @var bool
	*/
    protected $canKept = false;

    /**
	* if this data row is kept
	*
	* @var bool
	*/
    public $kept = false ;

    /**
	* if this data row is kept all data 
	* will be stored in this array
	*
	* @var array
	*/
    public $keptData ;

    /**
	* if data table could have stashed data
	* with the columns appeared_at
	*
	* @var bool
	*/
    protected $canStashed = false;

    /**
	* if this data row is stashed
	*
	* @var bool
	*/
    public $stashed = false ;

    /**
	* if this data row is stashed all data 
	* will be stored in this array
	*
	* @var array
	*/
    public $stashedData ;

	/**
	* if data table is tracked data
	* with the columns created_at and edited_at
	*
	* @var bool
	*/
    public $tracked  = false ;

    /**
	* the state of the ORM
	*
	* @var string
	*/
    protected $state ;

    



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
		if( ! is_null($key)) 
		{
			$this->struct($key);
			$this->state = CRUD::UPDATE_STAT;
		}
		else $this->state = CRUD::CREATE_STAT;
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
				// Check if kept
				if( ! $this->canKept ) $this->isKept($subValue);
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
	* check if data table could have kept data
	*
	* @param $column string
	* @return bool
	*/
	protected function isKept($column)
	{
		if($column == "deleted_at") $this->canKept = true;
	}

	/**
	* check if data table could have stashed data
	*
	* @param $column string
	* @return bool
	*/
	protected function isStashed($column)
	{
		if($column == "appeared_at") $this->canStashed = true;
	}

	/**
	* check if data table could have tracked data
	*
	* @param $column string
	* @return bool
	*/
	protected function isTracked($column)
	{
		if($column == "created_at" || $column == "edited_at") 
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
			if( $this->canKept && $this->keptAt($data) ) $this->kept = true ;
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
	* check if this data is already kept
	*
	* @param array $data
	* @return bool
	*/
	protected function keptAt($data)
	{
		if(is_null($data[0]["deleted_at"])) return false;
		else return $data[0]["deleted_at"] < Time::current();
	}

	/**
	* check if this data is already hidden
	*
	* @param array $data
	* @return bool
	*/
	protected function stashedAt($data)
	{
		if(is_null($data[0]["appeared_at"])) return false;
		else return $data[0]["appeared_at"] > Time::current();
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
			if( ! $this->kept && ! $this->stashed ) 
			{
				$this->$key = $value ;
				$this->setKey($key , $value);
			}
			else
			{
				if($this->kept) $this->keptData[$key] = $value ;
				if($this->stashed) $this->stashedData[$key] = $value ;
			}
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

	/**
	* function to get instance of the table by primary key
	*
	* @param int $key
	* @return ORM
	*/
	public static function get($key)
	{
		$class = get_called_class();
		return new $class($key);
	}

	public function __set($name, $value) {

        echo "Set:$name to $value";
        $this->$name = $value;
    }


	//--------------------------------------------------------
	// CRUD Functions
	//--------------------------------------------------------

	/**
	* Save the opertaion makes by user either creation or editing
	*
	* @return bool
	*/
	public function save()
	{
		if($this->state == CRUD::CREATE_STAT) $this->add();
		elseif ($this->state == CRUD::UPDATE_STAT) $this->edit();
	}

	/**
	* function to add data in data table
	*
	* @return bool
	*/
	private function add()
	{
		$columns = array();
		$values = array();
		//
		if($this->tracked) $this->created_at = Time::current();
		//
		foreach ($this->columns as $value)
			if($value != $this->keyName && isset($this->$value) && !empty($this->$value) )
			{
				$columns[] = $value;
				$values [] = $this->$value;
			}
		//
		return $this->insert($columns , $values);
	}

	/**
	* function to exexute insert data
	*
	* @param array $columns
	* @param array $values
	* @return bool
	*/
	private function insert($columns , $values)
	{
		return Query::table($this->table)
		->column($columns)
		->value($values)
		->insert();
	}

	/**
	* function to edit data in data table
	*
	* @return bool
	*/
	private function edit()
	{
		$columns = array();
		$values = array();
		//
		if($this->tracked) $this->edited_at = Time::current();
		//
		foreach ($this->columns as $value)
			if($value != $this->keyName && isset($this->$value) && !empty($this->$value) )
			{
				$columns[] = $value;
				$values [] = $this->$value;
			}
		//
		return $this->update($columns , $values);
	}

	/**
	* function to exexute update data
	*
	* @param array $columns
	* @param array $values
	* @return bool
	*/
	private function update($columns , $values)
	{
		$query = Query::table($this->table);
		//
		for ($i=0; $i < Table::count($columns) ; $i++) 
			$query = $query->set($columns[$i] , $values[$i]);
		//
		$query->where($this->keyName , "=" , $this->keyValue)
		->update();
		//
		return $query;
	}
	
	
	




	
	



	
	
	
	
	
	
	
	
	
	
	
}
