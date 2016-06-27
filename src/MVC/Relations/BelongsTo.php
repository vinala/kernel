<?php 

namespace Lighty\Kernel\MVC\Relations;

use Lighty\Kernel\Objects\Table;
use Lighty\Kernel\Objects\Strings;
use Lighty\Kernel\MVC\Relations\Exception\ModelNotFindedException as ModelNotFoundException;

define('OneToOneRelation', 'one');
define('OneToManyRelation', 'many');

/**
* Belongs To relation
*/
class BelongsTo
{	
	
	/**
	 * Current model
	 */
	protected $currentModel;

	/**
	 * Current table
	 */
	protected $currentTable;

	/**
	 * Relation type
	 */
	protected $relation;



	/**
	 * The belongs to relation
	 *
	 * @param $model : the model wanted to be related to the 
	 *			current model
	 * @param $local : if not null would be the local column
	 *			of the relation
	 * @param $remote : if not null would be the $remote column
	 *			of the relation
	 */
	public function ini($related , $model , $local = null , $remote = null)
	{
		$this->setCurrent($model);
		$this->checkModels($related);
		//
		if($this->isOneToOne($related,$model, $local, $remote)) return $this->prepare($this->OneToOne($related,$model,$local, $remote));
		elseif($this->isOneToMany($related,$model, $local, $remote)) return $this->prepare($this->OneToMany($related,$model,$local, $remote));
	}

	/**
	 * check if the relation is one to one
	 * @param $model object
	 * @param $related string
	 */
	protected function isOneToOne($related,$model, $local, $remote)
	{
		return ($this->getType(get_class($model) ,$related, $local, $remote) == OneToOneRelation);
	}

	/**
	 * check if the relation is one to one
	 * @param $model object
	 * @param $related string
	 */
	protected function isOneToMany($related,$model, $local, $remote)
	{
		return ($this->getType(get_class($model) ,$related, $local, $remote) == OneToManyRelation);
	}

	/**
	 * reverse one to one relation
	 * @param $model object
	 * @param $related string
	 * @param $local string
	 */
	protected function OneToOne($related,$model,$local,$remote)
	{
		$relationVal  = $this->oneRelationValue($related , $model , $local);
		$relationColumn  = $this->oneRelationColumn($related , $model , $remote);
		//
		return $this->all($related , $relationColumn , $relationVal);
	}


	/**
	 * reverse one to one relation
	 * @param $model object
	 * @param $related string
	 * @param $local string
	 */
	protected function OneToMany($related,$model,$local,$remote)
	{
		$relationVal  = $this->manyRelationValue($related , $model , $local);
		$relationColumn  = $this->manyRelationColumn($related , $model , $remote);
		//
		return $this->all($related , $relationColumn , $relationVal);
	}


	/**
	 * set current model name and data table name
	 * @param $model object
	 */
	protected function setCurrent($model)
	{
		$this->currentModel = get_class($model);
		$theModel = $this->currentModel;
		$this->currentTable = $theModel::$table;
	}

	/**
	 * check if the model are extisted
	 * @param $related string
	 * @param $model string
	 */
	protected function checkModels()
	{
		$models = func_get_args();
		//
		foreach ($models as $model)
			if( ! class_exists($model)) $this->ModelNotFound($model);
	}

	/**
	 * throw the not found exception for model
	 * @param $model string
	 */
	protected function ModelNotFound($model)
	{
		throw new ModelNotFoundException($model);
	}

	/**
	 * get the value of column of the relation
	 *
	 * @param $column : name of the column
	 * @param $model : name of the model
	 */
	protected function oneRelationValue($related , $model , $column = null)
	{
		$table = $this->checkModelType($model);
		//
		return $model->{! is_null($column) ? $column : $this->idKey($table)};
	}

	/**
	 * get the name of the column of the relation
	 *
	 * @param $column : name of the column
	 * @param $model : name of the model
	 */
	protected function oneRelationColumn($related , $model , $column = null)
	{
		$table = $this->checkModelType($model);
		//
		return (! is_null($column) ? $column : $this->idKey($table));
	}

	/**
	 * get the value of column of the relation
	 *
	 * @param $column : name of the column
	 * @param $model : name of the model
	 */
	protected function manyRelationValue($related , $model , $column = null)
	{
		$table = $this->checkModelType($related);
		//
		return $model->{! is_null($column) ? $column : $this->idKey($table)};
	}

	/**
	 * get the name of the column of the relation
	 *
	 * @param $column : name of the column
	 * @param $model : name of the model
	 */
	protected function manyRelationColumn($related , $model , $column = null)
	{
		$table = $this->checkModelType($related);
		//
		return (! is_null($column) ? $column : $this->idKey($table));
	}

	/**
	 * get the id key of the model from his name
	 *
	 * @param $table : string name of the model
	 */
	protected function idKey($table)
	{
		return Strings::toLower($table)."_id";
	}

	/**
	 * Get the object for the relation one to one
	 * @param $model : the model where to get data from
	 * @param $column : the column where to get data from
	 * @param $value : the value to get
	 */
	protected function all($model , $column , $value)
	{
		return $model::where( "$column = '$value'");
	}

	/**
	 * preparing the data for the hasone relation
	 * @param $model : data of the raltion
	 * @param $remote : the model wanted to be related to the 
	 *			current model
	 */
	protected function prepare($models)
	{
		return ! is_null($models->data) ? 
					((Table::count($models->data) > 0) 
						? ((Table::count($models->data) == 1) 
							? $models->data[0] 
							: $models->data
						) 
						: null 
					) 
					: null ;
	}

	/**
	 * get database table
	 * @param $model : mixed
	 */
	protected function checkModelType($model)
	{
		if( is_string($model)) return $this->getTable($model);
		else if( is_object($model)) return $this->getTable(get_class($model));
	}

	/**
	 * get database table
	 * @param $model string
	 */
	protected function getTable($model)
	{
		return $model::$table;
	}

	/**
	 * get the type of relation
	 * @param $model string
	 */
	protected function getType($model ,$related , $local, $remote)
	{
		$modelObject = new $model;
		$remoteObject = new $related;
		//
		$tablemodel=$model::$table;
		$tableremote=$related::$table;
		//
		if(is_null($local) && is_null($remote))
		{
			$model = $tablemodel."_id";
			$remote = $tableremote."_id";
		}
		else $model = $remote;
		//
		if(array_key_exists ($model, get_object_vars($remoteObject) )) $this->relation = OneToOneRelation; 
		if(array_key_exists ($remote, get_object_vars($modelObject) )) $this->relation = OneToManyRelation; 	
		//
		return $this->relation;
	}
}
