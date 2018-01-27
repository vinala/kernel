<?php

namespace Vinala\Kernel\Database;

use Vinala\Kernel\Collections\Collection;
use Vinala\Kernel\Config\Config;
use Vinala\Kernel\Database\Exceptions\QueryException;
//
use Vinala\Kernel\String\Strings;

/**
 * Query Class.
 */
class Query
{
    const GET_ARRAY = 'array';
    const GET_OBJECT = 'object';

    /**
     * Table of data.
     *
     * @var string
     */
    protected $table;

    /**
     * Tables of data.
     *
     * @var array
     */
    protected $tables = [];

    /**
     * columns query.
     *
     * @var array
     */
    protected $columns = '*';

    /**
     * values query.
     *
     * @var array
     */
    protected $values = [];

    /**
     * edits array for update query.
     *
     * @var array
     */
    protected $sets = [];

    /**
     * where clause.
     */
    protected $where = '';

    /**
     * order of data.
     */
    protected $order = '';

    /**
     * group of data.
     */
    protected $group = '';

    /**
     * The last SQL query used in surface.
     *
     * @var string
     */
    protected static $sql = null;

    //--------------------------------------------------------
    // Constructor
    //--------------------------------------------------------

    /**
     * Constructor for class.
     *
     * @param string
     */
    public function __construct($tables, $prefix = true)
    {
        if ($prefix && Config::get('database.prefixing')) {
            $prefix = config('database.prefixe');
            // $this->table = Config::get('database.prefixe').$table;
        } else {
            $prefix = '';
        }

        if (!is_array($tables)) {
            $tables = (array) $tables;
        }

        foreach ($tables as $table) {
            $this->tables[] = $prefix.$table;
        }
    }

    //--------------------------------------------------------
    // Functions
    //--------------------------------------------------------

    /**
     * function to clear all properties for the next use.
     *
     * @return null
     */
    private function reset()
    {
        $this->table = null;
        $this->tables = null;
        $this->columns = '*';
        //
        $this->values =
        $this->sets = [];
        //
        $this->where =
        $this->order =
        $this->group = '';
    }

    /**
     * Get the last query used.
     *
     * @return string
     */
    public static function last()
    {
        return static::$sql;
    }

    /**
     * Set the query table.
     *
     * @param string
     *
     * @return object
     */
    public static function table($table, $prefix = true)
    {
        return new self($table, $prefix);
    }

    /**
     * Set the query table.
     *
     * @param string
     *
     * @return object
     */
    public static function from($table, $prefix = true)
    {
        return new self($table, $prefix);
    }

    /**
     * Get all Data returned from query.
     *
     * @return array
     */
    public function get($type = 'object')
    {
        return self::query($type);
    }

    /**
     * Get first Data returned from query.
     *
     * @return array
     */
    public function first($type = 'object')
    {
        $data = self::query($type);
        if (Collection::count($data) > 0) {
            return $data[0];
        }
    }

    /**
     * get arraay of data.
     *
     * @param string
     *
     * @return array
     */
    public function query($type = 'object')
    {
        $sql = 'select '.$this->columns.' from '.$this->getTables($this->tables).' '.$this->where.' '.$this->order.' '.$this->group;

        static::$sql = $sql;
        //
        if ($data = Database::read($sql)) {
            return self::fetch($data, $type);
        } elseif (Database::execerr()) {
            throw new QueryException();
        }
    }

    /**
     * Get the tables names as string.
     *
     * @param array $tables
     *
     * @return string
     */
    private function getTables($tables)
    {
        $names = '';
        $i = 0;

        foreach ($tables as $table) {
            $names .= $table;
            $i++;

            if (count($tables) > $i) {
                $names .= ',';
            }
        }

        return $names;
    }

    /**
     * Fetch data.
     *
     * @param array
     *
     * @return array
     */
    public function fetch($array, $type = 'object')
    {
        $data = [];
        //
        foreach ($array as $row) {
            //
            if ($type == 'object') {
                $rw = new Row();
                //
                foreach ($row as $index => $column) {
                    if (!is_int($index)) {
                        $rw->$index = $column;
                    }
                }
            } elseif ($type == 'array') {
                $rw = [];
                //
                foreach ($row as $index => $column) {
                    if (!is_int($index)) {
                        $rw[$index] = $column;
                    }
                }
            }

            //
            $data[] = $rw;
        }
        //
        return $data;
    }

    /**
     * Set columns of query.
     *
     * @return array
     */
    public function select()
    {
        $columns = func_get_args();
        $target = '';
        //
        $i = false;
        foreach ($columns as $column) {
            if (!$i) {
                $target .= $column;
            } else {
                $target .= ','.$column;
            }
            $i = true;
        }
        //
        $this->columns = $target;
        //
        return $this;
    }

    /**
     * Set where clause.
     *
     * @param string $column
     * @param string $relation
     * @param string $value
     *
     * @return array
     */
    public function where($column = null, $relation = null, $value = null, $link = false)
    {
        if (is_null($column) && is_null($relation) && is_null($value)) {
            $this->where = ' where 1 = 1 ';
        } else {
            if (!$link) {
                $this->where = " where $column $relation '$value' ";
            } else {
                $this->where = " where $column $relation $value ";
            }
        }
        //
        return $this;
    }

    /**
     * Set a link between tables.
     *
     * @param string $column1
     * @param string $colmun2
     *
     * @return $this
     */
    public function link($column1, $colmun2)
    {
        if ($this->where != '') {
            $this->where .= " and ( $column1 = $colmun2 ) ";
        } else {
            $this->where = " where ( $column1 = $colmun2 ) ";
        }

        return $this;
    }

    /**
     * Set new OR condition in where clause.
     *
     * @param string $column
     * @param string $relation
     * @param string $value
     *
     * @return array
     */
    public function orWhere($column, $relation, $value, $link = false)
    {
        if (!$link) {
            $this->where .= " or ( $column $relation '$value' )";
        } else {
            $this->where .= " or ( $column $relation $value )";
        }

        //
        return $this;
    }

    /**
     * Set new AND condition in where clause.
     *
     * @param string $column
     * @param string $relation
     * @param string $value
     *
     * @return array
     */
    public function andWhere($column, $relation, $value, $link = false)
    {
        if (!$link) {
            $this->where .= " and ( $column $relation '$value' )";
        } else {
            $this->where .= " and ( $column $relation $value )";
        }

        //
        return $this;
    }

    /**
     * Set new multi condition in where clause.
     *
     * @param string $begin
     * @param string $between
     * @param array  $conditions
     *
     * @return Query
     */
    private function groupWhere($begin, $between, $conditions)
    {
        $query = (Strings::trim($begin) == 'or') ? ' or ( ' : (Strings::trim($begin) == 'and') ? ' and ( ' : ' ( ';
        //
        for ($i = 1; $i < Collection::count($conditions); $i++) {
            $query .= $conditions[$i];
            $query .= ($i < Collection::count($conditions) - 1) ? " $between " : ' ';
        }
        //
        $query .= ' ) ';
        //
        $this->where .= $query;
        //
        return $this;
    }

    /**
     * Set new OR for multi condition in where clause.
     *
     * @return Query
     */
    public function orGroup()
    {
        $conditions = func_get_args();
        if (Collection::count($conditions) == 0) {
            throw new ErrorException('Missing arguments for orGroup() ');
        }
        //
        return $this->groupWhere($conditions[0], 'or', $conditions);
    }

    /**
     * Set new AND for multi condition in where clause.
     *
     * @return Query
     */
    public function andGroup()
    {
        $conditions = func_get_args();
        if (Collection::count($conditions) == 0) {
            throw new ErrorException('Missing arguments for andGroup() ');
        }
        //
        return $this->groupWhere($conditions[0], 'and', $conditions);
    }

    /**
     * to create condition for or()/and() function.
     *
     * @param string $column
     * @param string $relation
     * @param string $value
     *
     * @return string
     */
    public static function condition($column, $relation, $value, $quote = true)
    {
        $query = " ( $column $relation ";
        $query .= $quote ? "'$value' ) " : " $value ) ";

        return $query;
    }

    /**
     * Set the order of data.
     *
     * @return array
     */
    public function order()
    {
        $columns = func_get_args();
        $order = '';
        $i = 0;
        //
        if ($columns) {
            foreach ($columns as $value) {
                if (!$i) {
                    $order .= ' order by '.$value;
                } else {
                    $order .= ','.$value;
                }
                $i = 1;
            }
        }
        //
        $this->order = $order;
        //
        return $this;
    }

    /**
     * Set the group of data.
     *
     * @return array
     */
    public function group()
    {
        $columns = func_get_args();
        $group = '';
        $i = 0;
        //
        if ($columns) {
            foreach ($columns as $value) {
                if (!$i) {
                    $order .= ' group by '.$value;
                } else {
                    $order .= ','.$value;
                }
                $i = 1;
            }
        }
        //
        $this->group = $group;
        //
        return $this;
    }

    //--------------------------------------------------------
    // Insert functions
    //--------------------------------------------------------

    /**
     * set the table where to put data into.
     *
     * @param string $name
     *
     * @return Query
     */
    public static function into($table, $prefix = true)
    {
        return new self($table, $prefix);
    }

    /**
     * set array of columns.
     *
     * @return Query
     */
    public function column()
    {
        $columns = func_get_args();
        //
        if (Collection::count($columns) == 1 && is_array($columns[0])) {
            $columns = $columns[0];
        }
        //
        $target = '';
        //
        $i = false;
        foreach ($columns as $column) {
            if (!$i) {
                $target .= "$column";
            } else {
                $target .= ",$column";
            }
            $i = true;
        }
        //
        $this->columns = $target;
        //
        return $this;
    }

    /**
     * set array of values.
     *
     * @return Query
     */
    public function value()
    {
        $values = func_get_args();
        //
        if (Collection::count($values) == 1 && is_array($values[0])) {
            $values = $values[0];
        }
        //
        $target = '';
        //
        $i = false;
        foreach ($values as $value) {
            $value = str_replace("'" , "''" , $value);
            if (!$i) {
                $target .= "'$value'";
            } else {
                $target .= ",'$value'";
            }
            $i = true;
        }
        //
        $this->values = $target;
        //
        return $this;
    }

    /**
     * execute insert query.
     *
     * @return bool
     */
    public function insert()
    {
        $query = 'insert into '.$this->getTables($this->tables).' ('.$this->columns.') values ('.$this->values.')';
        //
        $this->reset();
        //
        return Database::exec($query);
    }

    //--------------------------------------------------------
    // Update Functions
    //--------------------------------------------------------

    /**
     * function to set elemets to update.
     *
     * @param string $column
     * @param string $value
     *
     * @return Query
     */
    public function set($column, $value, $quote = true)
    {
        $value = str_replace("'" , "''" , $value);
        $this->sets[] = $quote ? " $column = '$value'" : " $column = $value";

        return $this;
    }

    /**
     * execute update query.
     *
     * @return bool
     */
    public function update()
    {
        $query = 'update '.$this->getTables($this->tables).' set ';
        //
        for ($i = 0; $i < Collection::count($this->sets); $i++) {
            if ($i < Collection::count($this->sets) - 1) {
                $query .= $this->sets[$i].',';
            } else {
                $query .= $this->sets[$i];
            }
        }
        //
        $query .= ' '.$this->where;
        //
        $this->reset();
        //
        return Database::exec($query);
    }

    //--------------------------------------------------------
    // Remove functions
    //--------------------------------------------------------

    /**
     * delete row from data table.
     *
     * @return bool
     */
    public function delete()
    {
        $query = 'delete from '.$this->table.' ';
        //
        $query .= ' '.$this->where;
        //
        $this->reset();
        //
        return Database::exec($query);
    }
}
