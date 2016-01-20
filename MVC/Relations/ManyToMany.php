<?php 

namespace Fiesta\Core\MVC\Relations;

use Fiesta\Core\Objects\Table;
use Fiesta\Core\Objects\String;
use Fiesta\Core\MVC\Relations\Exception\ManyRelationException;
use Fiesta\Core\MVC\Relations\Exception\ModelNotFindedException;

/**
* Many to many relation
*/
class ManyToMany
{


	/**
	 * The one to many relation
	 *
	 * @param $model : the model wanted to be related to the 
	 *			current model
	 * @param $local : if not null would be the local column
	 *			of the relation
	 * @param $remote : if not null would be the $remote column
	 *			of the relation
	 */
	public function ini($related , $model , $intermediate = null , $local = null , $remote = null)
	{
		$relatedTable = $related::$table;
		$modelTable = $this->getStaticTable($model);
		$intermediate = is_null($intermediate) ? $this->getIntermediate($modelTable , $relatedTable) : $intermediate ;
		//
		$this->checkModels($related , $intermediate , get_class($model));
		//
		$localVal  = $this->relationValue($related , $model , $local);
		$localColumn  = $this->relationColumn($related , $model , $local);	
		$remoteColumn  = $this->remoteColumn($related  , $remote);
		//
		return $mod=$this->relate($related , $intermediate , $remoteColumn , $localColumn , $localVal);
	}

	/**
	 * Get the Intermediate table
	 * @param 
	 */
	protected function getIntermediate()
	{
		$args = func_get_args();
		//
		$args = Table::sort($args);
		return $args[0].'_'.$args[1];
	}

	/**
	 * Get static name of model table
	 * @param $model object
	 */
	protected function getStaticTable($model)
	{
		$vars = get_class_vars(get_class($model));
		return $vars['table'];
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
			if( ! class_exists($model)) $this->ModelNotFinded($model);
	}

	/**
	 * throw the not found exception for model
	 * @param $model string
	 */
	protected function ModelNotFinded($model)
	{
		throw new ModelNotFindedException($model);
	}

	/**
	 * get the value of column of the relation
	 *
	 * @param $column : name of the column
	 * @param $model : name of the model
	 */
	protected function relationValue($related , $model , $column = null)
	{
		$table = $model::$table;
		//
		return $model->{! is_null($column) ? $column : $this->idKey($table)};
	}

	/**
	 * get the id key of the model from his name
	 *
	 * @param $table : string name of the model
	 */
	protected function idKey($table)
	{
		return String::toLower($table)."_id";
	}

	/**
	 * get the name of the column of the relation
	 *
	 * @param $column : name of the column
	 * @param $model : name of the model
	 */
	protected function relationColumn($related , $model , $column = null)
	{
		$table = $model::$table;
		//
		return (! is_null($column) ? $column : $this->idKey($table));
	}

	/**
	 * get the name of the column of the remote table
	 *
	 * @param $column : name of the column
	 * @param $model : name of the model
	 */
	protected function remoteColumn( $model , $column)
	{
		$table = $model::$table;
		//
		return (! is_null($column) ? $column : $this->idKey($table));
	}

	/**
	 * get all values in intermediate model
	 *
	 * @param $column : name of the column
	 * @param $model : name of the model
	 */
	protected function intermediates($model , $column , $value)
	{
		return $model::where( "$column = '$value'");
	}

	/**
	 * get all values in relation
	 *
	 * @param $column : name of the column
	 * @param $model : name of the model
	 */
	protected function relate($remote , $intermediates , $remoteColumn , $localColumn , $localValue)
	{
		$intermediates = $this->intermediates($intermediates , $localColumn , $localValue);
		//
		$data = ! is_null($intermediates->data) ? $this->all($intermediates , $remote , $remoteColumn) : null ;
		//
		return $data;
	}

	/**
	 * get all values in remote model
	 * @param $model : the model where to get data from
	 * @param $column : the column where to get data from
	 * @param $value : the value to get
	 */
	protected function all($intermediates , $model , $column)
	{
		$data = array();
		//
		foreach ($intermediates->data as $intermediate) 
			$data[] = $this->one($model , $column , $intermediate->$column);
		//
		return $data;
	}

	/**
	 * get one value in remote model
	 * @param $model : the model where to get data from
	 * @param $column : the column where to get data from
	 * @param $value : the value to get
	 */
	protected function one($model , $column , $value)
	{
		$object = $model::where( "$column = '$value'");
		return !empty($object) ? $object->data[0] : null ;
	}
}