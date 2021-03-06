<?php

namespace Vinala\Kernel\MVC\Relations;

use Vinala\Kernel\MVC\Relations\Exception\ModelNotFindedException;
use Vinala\Kernel\String\Strings;

/**
 * One to many relation.
 */
class OneToMany
{
    /**
     * The one to many relation.
     *
     * @param $model : the model wanted to be related to the
     *			current model
     * @param $local : if not null would be the local column
     *			of the relation
     * @param $remote : if not null would be the $remote column
     *			of the relation
     */
    public function ini($related, $model, $local = null, $remote = null)
    {
        $this->checkModels($related, $model);
        //
        $relationVal = $this->relationValue($related, $model, $local);
        $relationColumn = $this->relationColumn($related, $model, $remote);
        //
        return $this->all($related, $relationColumn, $relationVal);
    }

    /**
     * get the value of column of the relation.
     *
     * @param $column : name of the column
     * @param $model : name of the model
     */
    protected function relationValue($related, $model, $column = null)
    {
        $table = $model::$table;
        //
        return $model->{!is_null($column) ? $column : $this->idKey($table)};
    }

    /**
     * get the name of the column of the relation.
     *
     * @param $column : name of the column
     * @param $model : name of the model
     */
    protected function relationColumn($related, $model, $column = null)
    {
        $table = $model::$table;
        //
        return !is_null($column) ? $column : $this->idKey($table);
    }

    /**
     * get the id key of the model from his name.
     *
     * @param $model : name of the model
     */
    protected function idKey($table)
    {
        return Strings::toLower($table).'_id';
    }

    /**
     * Get the object for the relation one to one.
     *
     * @param $model : the model where to get data from
     * @param $column : the column where to get data from
     * @param $value : the value to get
     */
    protected function all($model, $column, $value)
    {
        return $model::where($column, '=', $value);
    }

    /**
     * check if the model are extisted.
     *
     * @param $related string
     * @param $model string
     */
    protected function checkModels($related, $model)
    {
        if (!class_exists($related)) {
            $this->ModelNotFinded($related);
        }
        if (!class_exists(get_class($model))) {
            $this->ModelNotFinded(get_class($model));
        }
    }

    /**
     * throw the not found exception for model.
     *
     * @param $model string
     */
    protected function ModelNotFinded($model)
    {
        throw new ModelNotFindedException($model);
    }
}
