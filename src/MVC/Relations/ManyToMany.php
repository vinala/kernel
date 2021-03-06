<?php

namespace Vinala\Kernel\MVC\Relations;

use Vinala\Kernel\Collections\Collection;
use Vinala\Kernel\MVC\Relations\Exception\ModelNotFindedException;
use Vinala\Kernel\String\Strings;

/**
 * Many to many relation.
 */
class ManyToMany
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
    public function ini($related, $model, $intermediate = null, $local = null, $remote = null)
    {
        $relatedTable = $this->getTable($related);
        $modelTable = $this->getTable($model);
        //
        $intermediate = is_null($intermediate) ? $this->getIntermediate($modelTable, $relatedTable) : $intermediate;
        //
        $this->checkModels($related, $intermediate, get_class($model));
        //
        $localVal = $this->relationValue($related, $model, $local);
        $localColumn = $this->relationColumn($related, $model, $local);
        $remoteColumn = $this->remoteColumn($related, $remote);
        //
        return $mod = $this->relate($related, $intermediate, $remoteColumn, $localColumn, $localVal);
    }

    /**
     * Get the Intermediate table.
     *
     * @param
     */
    protected function getIntermediate()
    {
        $args = func_get_args();
        //
        $args = Collection::sort($args);

        return $args[0].'_'.$args[1];
    }

    /**
     * Get static name of model table.
     *
     * @param $model object
     */
    protected function getStaticTable($model)
    {
        $vars = get_class_vars(get_class($model));

        return $vars['table'];
    }

    /**
     * check if the model are extisted.
     *
     * @param $related string
     * @param $model string
     */
    protected function checkModels()
    {
        $models = func_get_args();
        //
        foreach ($models as $model) {
            if (!class_exists($model)) {
                $this->ModelNotFinded($model);
            }
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
     * get the id key of the model from his name.
     *
     * @param $table : string name of the model
     */
    protected function idKey($table)
    {
        return Strings::toLower($table).'_id';
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
     * get the name of the column of the remote table.
     *
     * @param $column : name of the column
     * @param $model : name of the model
     */
    protected function remoteColumn($model, $column)
    {
        $table = $model::$table;
        //
        return !is_null($column) ? $column : $this->idKey($table);
    }

    /**
     * get all values in intermediate model.
     *
     * @param $column : name of the column
     * @param $model : name of the model
     */
    protected function intermediates($model, $column, $value)
    {
        return $model::where($column, '=', $value);
    }

    /**
     * get all values in relation.
     *
     * @param $column : name of the column
     * @param $model : name of the model
     */
    protected function relate($remote, $intermediates, $remoteColumn, $localColumn, $localValue)
    {
        $intermediates = $this->intermediates($intermediates, $localColumn, $localValue);
        //
        if (!is_null($intermediates)) {
            return $this->all($intermediates, $remote, $remoteColumn);
        }
        //
    }

    /**
     * get all values in remote model.
     *
     * @param $model : the model where to get data from
     * @param $column : the column where to get data from
     * @param $value : the value to get
     */
    protected function all($intermediates, $model, $column)
    {
        $data = [];
        //
        foreach ($intermediates as $intermediate) {
            $data[] = $this->one($model, $column, $intermediate->$column);
        }
        //
        return $data;
    }

    /**
     * get one value in remote model.
     *
     * @param $model : the model where to get data from
     * @param $column : the column where to get data from
     * @param $value : the value to get
     */
    protected function one($model, $column, $value)
    {
        $object = $model::where($column, '=', $value);

        if (!is_null($object)) {
            if (count($object) > 0) {
                return $object[0];
            }
        }
    }

    /**
     * Get the table of the model.
     *
     * @param string $model
     *
     * @return string
     */
    protected function getTable($model)
    {
        return $model::$table;
    }
}
