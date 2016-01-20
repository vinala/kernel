<?php 

namespace Fiesta\Core\MVC\Relations;

use Fiesta\Core\Objects\Table;
use Fiesta\Core\Objects\String;
use Fiesta\Core\MVC\Relations\Exception\ManyRelationException;
use Fiesta\Core\MVC\Relations\Exception\ModelNotFindedException;


/**
* One to one relation
*/
class OneToOne
{
	
	
	/**
	 * The one to one relation
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
		$this->checkModels($related,$model);
		//
		$relationVal  = $this->relationValue($related , $model , $local);
		$relationColumn  = $this->relationColumn($related , $model , $local);
		//
		$mod=$this->first($related , $relationColumn , $relationVal);
		//
		return $this->prepare($mod , $related);
	}

	/**
	 * get the value of column of the relation
	 *
	 * @param $column : name of the column
	 * @param $model : name of the model
	 */
	protected function relationValue($related , $model , $column = null)
	{
		$table = $related::$table;
		//
		return $model->{! is_null($column) ? $column : $this->idKey($table)};
	}

	/**
	 * get the name of the column of the relation
	 *
	 * @param $column : name of the column
	 * @param $model : name of the model
	 */
	protected function relationColumn($related , $model , $column = null)
	{
		$table = $related::$table;
		//
		return (! is_null($column) ? $column : $this->idKey($table));
	}

	/**
	 * Get the object for the relation one to one
	 * @param $model : the model where to get data from
	 * @param $column : the column where to get data from
	 * @param $value : the value to get
	 */
	protected function first($model , $column , $value)
	{
		return (new $model)->get( $column , "=" , $value);
	}

	/**
	 * preparing the data for the hasone relation
	 * @param $model : data of the raltion
	 * @param $remote : the model wanted to be related to the 
	 *			current model
	 */
	protected function prepare($model , $remote)
	{
		return !empty($model) ? isset($model->data) ? Table::count($model->data) == 1 ? $model->data[0] : $this->ManyRelationException($remote) : null : null;
	}

		/**
	 * throwing the ManyRelation Exception
	 * @param $remote : the model wanted to be related to the 
	 *			current model
	 */
	protected function ManyRelationException($related , $model)
	{
		$model = get_class($model);
		$related = get_class($related);
		//
		throw new ManyRelationException( $model , $related );
	}

	/**
	 * get the id key of the model from his name
	 *
	 * @param $model : name of the model
	 */
	protected function idKey($table)
	{
		return String::toLower($table)."_id";
	}

	/**
	 * check if the model are extisted
	 * @param $related string
	 * @param $model string
	 */
	protected function checkModels($related,$model)
	{
		if( ! class_exists($related)) $this->ModelNotFinded($related);
		if( ! class_exists(get_class($model))) $this->ModelNotFinded(get_class($model));
	}

	/**
	 * throw the not found exception for model
	 * @param $model string
	 */
	protected function ModelNotFinded($model)
	{
		throw new ModelNotFindedException($model);
	}

}