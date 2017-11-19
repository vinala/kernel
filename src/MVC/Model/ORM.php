<?php

namespace Vinala\Kernel\MVC;

use InvalidArgumentException;
use Vinala\Kernel\Collections\Collection as Table;
use Vinala\Kernel\Config\Config;
use Vinala\Kernel\Database\Database;
use Vinala\Kernel\Database\Query;
use Vinala\Kernel\Foundation\Exceptions\SurfaceDisabledException;
use Vinala\Kernel\MVC\ORM\Collection;
//
use Vinala\Kernel\MVC\ORM\CRUD;
use Vinala\Kernel\MVC\ORM\Exception\ManyPrimaryKeysException;
use Vinala\Kernel\MVC\ORM\Exception\ModelNotFoundException;
use Vinala\Kernel\MVC\ORM\Exception\PrimaryKeyNotFoundException;
use Vinala\Kernel\MVC\ORM\Exception\TableNotFoundException;
//
use Vinala\Kernel\MVC\Relations\BelongsTo;
use Vinala\Kernel\MVC\Relations\ManyToMany;
use Vinala\Kernel\MVC\Relations\OneToMany;
use Vinala\Kernel\MVC\Relations\OneToOne;
//
use Vinala\Kernel\Time\DateTime as Time;

/**
 * The Mapping Objet-Relationnel (ORM) class.
 *
 * Beta (Source code name : model)
 *
 * @version 2.0
 *
 * @author Youssef Had
 */
class ORM
{
    //--------------------------------------------------------
    // Properties
    //--------------------------------------------------------

    /**
     * the name of the called model.
     *
     * @var string
     */
    protected $_model;

    /**
     * the name and value of primary key of the model.
     *
     * @var array
     */
    public $_key = [];

    /**
     * the name of primary key of the model.
     *
     * @var string
     */
    protected $_keyName;

    /**
     * the value of primary key of the model.
     *
     * @var string
     */
    protected $_keyValue;

    /**
     * the value of the model table name.
     *
     * @var string
     */
    protected $_table;

    /**
     * the name of the model table with prifix.
     *
     * @var string
     */
    protected $_prifixTable;

    /**
     * array contains all columns of data table.
     *
     * @var array
     */
    public $_columns = [];

    /**
     * if data table could have kept data
     * with the columns deleted_at.
     *
     * @var bool
     */
    protected $_canKept = false;

    /**
     * if this data row is kept.
     *
     * @var bool
     */
    public $_kept = false;

    /**
     * if this data row is kept all data
     * will be stored in this array.
     *
     * @var array
     */
    public $_keptData;

    /**
     * if data table could have stashed data
     * with the columns appeared_at.
     *
     * @var bool
     */
    protected $_canStashed = false;

    /**
     * if this data row is stashed.
     *
     * @var bool
     */
    public $_stashed = false;

    /**
     * if this data row is stashed all data
     * will be stored in this array.
     *
     * @var array
     */
    public $_stashedData;

    /**
     * if data table is tracked data
     * with the columns created_at and edited_at.
     *
     * @var bool
     */
    public $_tracked = false;

    /**
     * the state of the ORM.
     *
     * @var string
     */
    protected $_state;

    /**
     * Array of data.
     *
     * @var array
     */
    protected $data = null;

    //--------------------------------------------------------
    // Constructor
    //--------------------------------------------------------

    /**
     * The constructors.
     */
    public function __construct()
    {
        $params = func_get_args();
        //
        $this->checkDatabase();
        //
        if (Table::count($params) == 1 && is_array($params[0])) {
            $this->secondConstruct($params[0]);
        } elseif (Table::count($params) > 0 && is_numeric($params[0])) {
            $this->mainConstruct($params[0], (isset($params[1]) ? $params[1] : null));
        } else {
            $this->emptyConstruct();
        }
    }

    /**
     * the empty constructor.
     */
    private function emptyConstruct()
    {
        $this->getModel();
        $this->getTable();
        $this->columns();
        $this->key();
        $this->_state = CRUD::CREATE_STAT;
    }

    /**
     * the main constructor to search that from database.
     *
     * @param int  $key
     * @param bool $fail
     */
    private function mainConstruct($key = null, $fail = false)
    {
        $this->getModel();
        $this->getTable();
        $this->columns();
        $this->key();
        if (!is_null($key)) {
            $this->struct($key, $fail);
            $this->_state = CRUD::UPDATE_STAT;
        } else {
            $this->_state = CRUD::CREATE_STAT;
        }
    }

    /**
     * the second Construct to fil data from array.
     *
     * @param array $data
     */
    private function secondConstruct($data)
    {
        $this->getModel($data);
        $this->getTable($data);
        $this->columns($data);
        $this->key($data);
        $this->fill($data);
        $this->_state = CRUD::UPDATE_STAT;
    }

    //--------------------------------------------------------
    // Getter and Setter
    //--------------------------------------------------------

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __get($name)
    {
        if (method_exists($this, $name)) {
            return call_user_func([$this, $name]);
        } else {
            throw new InvalidArgumentException('Undefined property: '.get_class($this)."::$name");
        }
    }

    //--------------------------------------------------------
    // Functions
    //--------------------------------------------------------

    /**
     * Check if database surface is on.
     *
     * @return bool
     */
    protected function checkDatabase()
    {
        exception_if(!config('components.database'), SurfaceDisabledException::class, 'database', 'The ORM surface require the Database surface to be enabled');
    }

    /**
     * Get array of data.
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * get the model name.
     *
     * @return string
     */
    protected function getModel($data = null)
    {
        $this->_model = is_null($data) ? get_called_class() : $data['name'];
    }

    /**
     * get the model table name.
     *
     * @param $table
     *
     * @return null
     */
    protected function getTable($data = null)
    {
        if (is_null($data)) {
            $this->_prifixTable = (Config::get('database.prefixing') ? Config::get('database.prefixe') : '').$this->_table;
            //
            if (!$this->checkTable()) {
                throw new TableNotFoundException($this->_table);
            }
            //
            return $this->_prifixTable;
        } else {
            $this->_prifixTable = $data['prifixTable'];
        }
    }

    /**
     * Check if table exists in database.
     *
     * @param $table string
     *
     * @return bool
     */
    protected function checkTable()
    {
        $data = Query::from('information_schema.tables', false)
            ->select('*')
            ->where('TABLE_SCHEMA', '=', Config::get('database.database'))
            ->andwhere('TABLE_NAME', '=', $this->_prifixTable)
            ->get(Query::GET_ARRAY);
        //
        return (Table::count($data) > 0) ? true : false;
    }

    /**
     * to get and set all columns of data table.
     *
     * @return array
     */
    protected function columns($data = null)
    {
        if (is_null($data)) {
            $this->_columns = $this->extruct(
                Query::from('INFORMATION_SCHEMA.COLUMNS', false)
                ->select('COLUMN_NAME')
                ->where('TABLE_SCHEMA', '=', Config::get('database.database'))
                ->andwhere('TABLE_NAME', '=', $this->_prifixTable)
                ->get(Query::GET_ARRAY)
                );
            //
            return $this->_columns;
        } else {
            $this->_columns = $data['columns'];
        }
    }

    /**
     * convert array rows from array to string
     * this function is used columns() function.
     *
     * @param $columns array
     *
     * @return array
     */
    protected function extruct($columns)
    {
        $data = [];
        //
        foreach ($columns as $value) {
            foreach ($value as $subValue) {
                $data[] = $subValue;
                //
                // Check if kept
                if (!$this->_canKept) {
                    $this->isKept($subValue);
                }
                //
                // Check if stashed
                if (!$this->_canStashed) {
                    $this->isStashed($subValue);
                }
                //
                // Check if tracked
                if (!$this->_tracked) {
                    $this->isTracked($subValue);
                }
            }
        }
        //
        return $data;
    }

    /**
     * check if data table could have kept data.
     *
     * @param $column string
     *
     * @return bool
     */
    protected function isKept($column)
    {
        if ($column == 'deleted_at') {
            $this->_canKept = true;
        }
    }

    /**
     * check if data table could have stashed data.
     *
     * @param $column string
     *
     * @return bool
     */
    protected function isStashed($column)
    {
        if ($column == 'appeared_at') {
            $this->_canStashed = true;
        }
    }

    /**
     * check if data table could have tracked data.
     *
     * @param $column string
     *
     * @return bool
     */
    protected function isTracked($column)
    {
        if ($column == 'created_at' || $column == 'edited_at') {
            $this->_tracked = true;
        }
    }

    /**
     * function execute SQL query to get Primary keys.
     *
     * @return array
     */
    protected function getPK()
    {
        switch (Config::get('database.default')) {
            case 'sqlite': break;
            case 'mysql':
                    return Database::read('SHOW INDEX FROM '.$this->_prifixTable." WHERE `Key_name` = 'PRIMARY'");
                break;

            case 'pgsql': break;
            case 'sqlsrv': break;
        }
    }

    /**
     * set primary key
     * the framework doesn't support more the column to be
     * the primary key otherwise exception will be thrown.
     *
     * @return null
     */
    protected function key($data = null)
    {
        if (is_null($data)) {
            $data = $this->getPK();
            //
            if (Table::count($data) > 1) {
                throw new ManyPrimaryKeysException();
            } elseif (Table::count($data) == 0) {
                throw new PrimaryKeyNotFoundException($this->_table);
            }
            //
            $this->_keyName = $data[0]['Column_name'];
            $this->_key['name'] = $data[0]['Column_name'];
        } else {
            $this->_keyName = $data['key'];
            $this->_key['name'] = $data['key'];
        }
    }

    /**
     * get data from data table according to primary key value.
     *
     * @param int $key
     *
     * @return null
     */
    protected function struct($key, $fail)
    {
        $data = $this->dig($key);
        //
        if (Table::count($data) == 1) {
            if ($this->_canKept && $this->keptAt($data)) {
                $this->_kept = true;
            }
            if ($this->_canStashed && $this->stashedAt($data)) {
                $this->_stashed = true;
            }
            //
            $this->convert($data);
        } elseif ($fail && Table::count($data) == 0) {
            throw new ModelNotFoundException($key, $this->_model);
        }
    }

    /**
     * fill data from array.
     *
     * @param array $data
     *
     * @return null
     */
    protected function fill($data)
    {
        if ($this->_canKept && $this->keptAt($data['values'])) {
            $this->_kept = true;
        }
        if ($this->_canStashed && $this->stashedAt($data['values'])) {
            $this->_stashed = true;
        }
        //
        $this->convert($data['values']);
    }

    /**
     * search for data by Query Class according to primary key.
     *
     * @param int $key
     *
     * @return array
     */
    protected function dig($key)
    {
        return Query::from($this->_table)
            ->select('*')
            ->where($this->_keyName, '=', $key)
            ->get(Query::GET_ARRAY);
    }

    /**
     * check if this data is already kept.
     *
     * @param array $data
     *
     * @return bool
     */
    protected function keptAt($data)
    {
        if (is_null($data[0]['deleted_at'])) {
            return false;
        } else {
            return $data[0]['deleted_at'] < Time::current();
        }
    }

    /**
     * check if this data is already hidden.
     *
     * @param array $data
     *
     * @return bool
     */
    protected function stashedAt($data)
    {
        if (is_null($data[0]['appeared_at'])) {
            return false;
        } else {
            return $data[0]['appeared_at'] > Time::current();
        }
    }

    /**
     * make data array colmuns as property
     * in case of hidden data property was true
     * data will be stored in hidden data
     * instead ofas property.
     *
     * @param array $data
     *
     * @return null
     */
    protected function convert($data)
    {
        foreach ($data[0] as $key => $value) {
            if (!$this->_kept && !$this->_stashed) {
                $this->$key = $value;
                $this->setKey($key, $value);
            } else {
                if ($this->_kept) {
                    $this->_keptData[$key] = $value;
                }
                if ($this->_stashed) {
                    $this->_stashedData[$key] = $value;
                }
            }

            $this->data[$key] = $value;
        }
    }

    /**
     * set the primary key value by verifying
     * the name of the key in data array and
     * the name of $keyName property.
     *
     * @param string $key
     * @param string $value
     *
     * @return null
     */
    protected function setKey($key, $value)
    {
        if ($key == $this->_keyName) {
            $this->_keyValue = $value;
            $this->_key['value'] = $value;
        }
    }

    /**
     * function to get instance of the table by primary key.
     *
     * @param int $key
     *
     * @return ORM
     */
    public static function get($key)
    {
        $class = get_called_class();

        return new $class($key);
    }

    /**
     * function to get instance of the table by primary key else throw an exception.
     *
     * @param int $key
     *
     * @return ORM
     */
    public static function getOrFail($key)
    {
        $class = get_called_class();

        return new $class($key, true);
    }

    //--------------------------------------------------------
    // CRUD Functions
    //--------------------------------------------------------

    /**
     * Save the opertaion makes by user either creation or editing.
     *
     * @return bool
     */
    public function save()
    {
        if ($this->_state == CRUD::CREATE_STAT) {
            $this->add();
        } elseif ($this->_state == CRUD::UPDATE_STAT) {
            $this->edit();
        }
    }

    /**
     * function to add data in data table.
     *
     * @return bool
     */
    private function add()
    {
        $columns = [];
        $values = [];
        //
        if ($this->_tracked) {
            $this->created_at = Time::current();
        }
        //
        foreach ($this->_columns as $value) {
            if ($value != $this->_keyName && isset($this->$value) && !empty($this->$value)) {
                $columns[] = $value;
                $values[] = $this->$value;
            }
        }
        //
        return $this->insert($columns, $values);
    }

    /**
     * function to exexute insert data.
     *
     * @param array $columns
     * @param array $values
     *
     * @return bool
     */
    private function insert($columns, $values)
    {
        return Query::table($this->_table)
        ->column($columns)
        ->value($values)
        ->insert();
    }

    /**
     * function to edit data in data table.
     *
     * @return bool
     */
    private function edit()
    {
        $columns = [];
        $values = [];
        //
        if ($this->_tracked) {
            $this->edited_at = Time::current();
        }
        //
        foreach ($this->_columns as $value) {
            if ($value != $this->_keyName && isset($this->$value) && !empty($this->$value)) {
                $columns[] = $value;
                $values[] = $this->$value;
            }
        }
        //
        return $this->update($columns, $values);
    }

    /**
     * function to exexute update data.
     *
     * @param array $columns
     * @param array $values
     *
     * @return bool
     */
    private function update($columns, $values)
    {
        $query = Query::table($this->_table);
        //
        for ($i = 0; $i < Table::count($columns); $i++) {
            $query = $query->set($columns[$i], $values[$i]);
        }
        //
        $query->where($this->_keyName, '=', $this->_keyValue)
        ->update();
        //
        return $query;
    }

    /**
     * to delete the model from database
     * in case of Kept deleted just hide it.
     *
     * @return bool
     */
    public function delete()
    {
        if (!$this->_canKept) {
            $this->forceDelete();
        } else {
            Query::table($this->_table)
            ->set('deleted_at', Time::current())
            ->where($this->_keyName, '=', $this->_keyValue)
            ->update();
        }
    }

    /**
     * to force delete the model from database even if the model is Kept deleted.
     *
     * @return bool
     */
    public function forceDelete()
    {
        $key = $this->_kept ? $this->_keptData[$this->_keyName] : $this->_keyValue;
        //
        Query::table($this->_table)
            ->where($this->_keyName, '=', $key)
            ->delete();
        //
        $this->reset();
    }

    /**
     * reset the current model if it's deleted.
     *
     * @return null
     */
    private function reset()
    {
        $vars = get_object_vars($this);
        //
        foreach ($vars as $key => $value) {
            unset($this->$key);
        }
    }

    /**
     * restore the model if it's kept deleted.
     *
     * @return bool
     */
    public function restore()
    {
        if ($this->_kept) {
            $this->bring();
            //
            Query::table($this->_table)
            ->set('deleted_at', 'NULL', false)
            ->where($this->_keyName, '=', $this->_keyValue)
            ->update();
        }
    }

    /**
     * to extruct data from keptdata array to become properties.
     *
     * @return null
     */
    private function bring()
    {
        foreach ($this->_keptData as $key => $value) {
            $this->$key = $value;
        }
        //
        $this->_keyValue = $this->_keptData[$this->_keyName];
        //
        $this->_keptData = null;
        $this->_kept = false;
    }

    //--------------------------------------------------------
    // Relations
    //--------------------------------------------------------

    /**
     * The has one relation for one to one.
     *
     * @param string $model  : the model wanted to be related to the current model
     * @param string $local  : if not null would be the local column of the relation
     * @param string $remote : if not null would be the $remote column of the relation
     *
     * @return
     */
    public function hasOne($model, $local = null, $remote = null)
    {
        return (new OneToOne())->ini($model, $this, $local, $remote);
    }

    /**
     * The one to many relation.
     *
     * @param string $model  : the model wanted to be related to the current model
     * @param string $local  : if not null would be the local column of the relation
     * @param string $remote : if not null would be the $remote column of the relation
     *
     * @return
     */
    public function hasMany($model, $local = null, $remote = null)
    {
        return (new OneToMany())->ini($model, $this, $local, $remote);
    }

    /**
     * The many to many relation.
     *
     * @param string $model  : the model wanted to be related to the  current model
     * @param string $local  : if not null would be the local column of the relation
     * @param string $remote : if not null would be the $remote column of the relation
     *
     * @return
     */
    public function belongsToMany($model, $intermediate = null, $local = null, $remote = null)
    {
        return (new ManyToMany())->ini($model, $this, $intermediate, $local, $remote);
    }

    /**
     * The many to many relation.
     *
     * @param string $model  : the model wanted to be related to the  current model
     * @param string $local  : if not null would be the local column of the relation
     * @param string $remote : if not null would be the $remote column of the relation
     *
     * @return
     */
    public function belongsTo($model, $local = null, $remote = null)
    {
        return (new BelongsTo())->ini($model, $this, $local, $remote);
    }

    //--------------------------------------------------------
    // Collection functions
    //--------------------------------------------------------

    /**
     * get collection of all data of the model from data table.
     *
     * @return Collection
     */
    public static function all()
    {
        $class = get_called_class();
        $object = new $class();
        $table = $object->_table;
        $key = $object->_keyName;
        //
        $data = Query::table($table)->select('*')->where("'true'", '=', 'true');
        //
        if ($object->_canKept) {
            $data = $data->orGroup(
            'and',
            Query::condition('deleted_at', '>', Time::current()),
            Query::condition('deleted_at', 'is', 'NULL', false));
        }

        if ($object->_canStashed) {
            $data = $data->orGroup(
            'and',
            Query::condition('appeared_at', '<=', Time::current()),
            Query::condition('appeared_at', 'is', 'NULL', false));
        }
        //
        $data = $data->get(Query::GET_ARRAY);
        //
        return self::collect($data, $table, $key);
    }

    /**
     * get collection of all data of the model from data table with the kept data.
     *
     * @return Collection
     */
    public static function withTrash()
    {
        $class = get_called_class();
        $object = new $class();
        $table = $object->_table;
        $key = $object->_keyName;
        //
        $data = Query::table($table)->select('*')->where("'true'", '=', 'true');
        //
        if ($object->_canStashed) {
            $data = $data->orGroup(
            'and',
            Query::condition('appeared_at', '<=', Time::current()),
            Query::condition('appeared_at', 'is', 'NULL', false));
        }
        //
        $data = $data->get(Query::GET_ARRAY);
        //
        return self::collect($data, $table, $key);
    }

    /**
     * get collection of all kept data of the model from data table.
     *
     * @return Collection
     */
    public static function onlyTrash()
    {
        $class = get_called_class();
        $object = new $class();
        $table = $object->_table;
        $key = $object->_keyName;
        //
        $data = Query::table($table)->select('*');
        //
        if ($object->_canKept) {
            $data = $data->where('deleted_at', '<=', Time::current());
        }
        //
        $data = $data->get(Query::GET_ARRAY);
        //
        return self::collect($data, $table, $key);
    }

    /**
     * get collection of all data of the model from data table with the stashed data.
     *
     * @return Collection
     */
    public static function withStashed()
    {
        $class = get_called_class();
        $object = new $class();
        $table = $object->_table;
        $key = $object->_keyName;
        //
        $data = Query::table($table)->select('*')->where("'true'", '=', 'true');
        //
        if ($object->_canKept) {
            $data = $data->orGroup(
            'and',
            Query::condition('deleted_at', '>', Time::current()),
            Query::condition('deleted_at', 'is', 'NULL', false));
        }
        //
        $data = $data->get(Query::GET_ARRAY);
        //
        return self::collect($data, $table, $key);
    }

    /**
     * get collection of all kept data of the model from data table.
     *
     * @return Collection
     */
    public static function onlyStashed()
    {
        $class = get_called_class();
        $object = new $class();
        $table = $object->_table;
        $key = $object->_keyName;
        //
        $data = Query::table($table)->select('*');
        //
        if ($object->_canKept) {
            $data = $data->where('appeared_at', '>', Time::current());
        }
        //
        $data = $data->get(Query::GET_ARRAY);
        //
        return self::collect($data, $table, $key);
    }

    /**
     * convert Query/Row to Collection.
     *
     * @param array $data
     *
     * @return Collection
     */
    private static function collect($data, $table, $key)
    {
        $class = get_called_class();
        $object = new $class();
        $collection = new Collection();
        //
        if (Table::count($data) > 0) {
            foreach ($data as $row) {
                $rows[0] = $row;
                //
                $value =
                [
                    'name'        => $object->_model,
                    'prifixTable' => $object->_prifixTable,
                    'columns'     => $object->_columns,
                    'key'         => $object->_keyName,
                    'values'      => $rows,
                ];
                //
                $collection->add(new $class($value));
            }
        }
        //
        return $collection;
    }

    /**
     * get data by where clause.
     *
     * @param string $column
     * @param string $relation
     * @param string $value
     *
     * @return array
     */
    public static function where($column, $relation, $value)
    {
        $self = self::instance();
        $key = $self->_keyName;
        $data = \Query::from($self->_table)->select($key)->where($column, $relation, $value)->get();
        $rows = [];

        if (!is_null($data)) {
            foreach ($data as $item) {
                $rows[] = self::instance($item->$key);
            }
        }

        return $rows;
    }

    /**
     * get instance of the called model.
     *
     * @param int $key
     *
     * @return array
     */
    protected static function instance($key = null)
    {
        return instance(get_called_class(), $key);
    }
}
