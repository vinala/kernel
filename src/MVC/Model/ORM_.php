<?php

namespace Vinala\Kernel\MVC;

use InvalidArgumentException;
use Vinala\Kernel\Config\Config;
use Vinala\Kernel\Database\Database;
use Vinala\Kernel\MVC\Model\ModelArray;
use Vinala\Kernel\MVC\ORM\Exception\ForeingKeyMethodException;
use Vinala\Kernel\MVC\ORM\Exception\ManyPrimaryKeysException;
use Vinala\Kernel\MVC\ORM\Exception\PrimaryKeyNotFoundException;
use Vinala\Kernel\MVC\Relations\BelongsTo;
use Vinala\Kernel\MVC\Relations\ManyToMany;
use Vinala\Kernel\MVC\Relations\OneToMany;
use Vinala\Kernel\MVC\Relations\OneToOne;
use Vinala\Kernel\Time\DateTime as Time;

/**
  * ORM class.
  */
 class ORM_
 {
     /**
      * the name of primary key for the model.
      */
     protected $keyName;

     /**
      * the value of primary key for the model.
      */
     protected $keyValue;

     /**
      * Unixtime when this resource was kept deleted.
      */
     protected $kept_at = null;

     /**
      * kept deleted data.
      */
     protected $kept_data = [];

     protected static $table;
     protected $DBtable;
     protected $columns = [];
     protected $key;
     //
     protected $isKept = false;
     protected $isMaj = false;
     protected $areMaj = 0;

     public function __construct($pk = null, $table = null)
     {
         $this->setTable($table);
         $this->setColmuns();
         $this->setPrimaryKey();
         if (!is_null($pk)) {
             $this->setData($pk);
         }
     }

     public function __get($name)
     {
         return $this->getCallable($name);
     }

     protected function getColmuns()
     {
         return Database::read("select COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '".Config::get('database.database')."' AND TABLE_NAME = '".$this->DBtable."';");
     }

     protected function setColmuns()
     {
         $data = [];
         //
         $rows = $this->getColmuns();
         //
         foreach ($rows as $key => $value) {
             foreach ($value as $key2 => $value2) {
                 if (is_numeric($key2)) {
                     $data[] = $value2;
                     $this->setVars($value2);
                     if ($value2 == 'deleted_at') {
                         $this->isKept = true;
                     }
                     if ($value2 == 'created_at') {
                         $this->areMaj++;
                     } elseif ($value2 == 'edited_at') {
                         $this->areMaj++;
                     }
                     //
                     if ($this->areMaj == 2) {
                         $this->isMaj = true;
                     }
                 }
             }
         }
         //
         $this->columns = $data;
         $this->setForeign();
     }

     protected function setVars($key, $value = null, $kept = false)
     {
         if (!$kept) {
             $this->$key = $value;
         }
         // else if( $kept && $key == "deleted_at") $this->$key = $value ;
         elseif ($kept) {
             $this->setKept($key, $value);
         }
         //
         self::setKeyValue($key, $value);
     }

     /**
      * Set primary key value.
      */
     protected function setKeyValue($key, $value)
     {
         if ($key == $this->keyName) {
             $this->keyValue = $value;
         }
     }

     /**
      * Set kept data.
      */
     protected function setKept($key, $value)
     {
         if ($key == 'deleted_at') {
             $this->kept_at = $value;
             $this->kept_data[$key] = $value;
         }
         //
         $this->kept_data[$key] = $value;
     }

     protected function getPrimaryKey()
     {
         return Database::read('SHOW INDEX FROM '.$this->DBtable." WHERE `Key_name` = 'PRIMARY'");
     }

     protected function setPrimaryKey()
     {
         $data = [];
         //
         $rows = $this->getPrimaryKey();
         //
         if (count($rows) > 1) {
             throw new ManyPrimaryKeysException();
         } elseif (count($rows) == 0) {
             throw new PrimaryKeyNotFoundException($this->DBtable);
         }
         //
         $this->key = $rows[0]['Column_name'];
         $this->keyName = $rows[0]['Column_name'];
     }

     protected function setTable($table)
     {
         $table = is_null($table) ? !isset(static::$table) ? get_class($this) : static::$table : $table;
         //
         if (Config::get('database.prefixing')) {
             $this->DBtable = Config::get('database.prefixe').$table;
         } else {
             $this->DBtable = $table;
         }
     }

     protected function setData($pk)
     {
         // if( ! $this->isKept)
         $sql = 'select * from '.$this->DBtable.' where '.$this->keyName."='".$pk."' ";
         // else $sql = "select * from ".$this->DBtable." where ".$this->keyName."='".$pk."' where deleted_at<'".Time::current()."'";
         //
         $data = Database::read($sql, 1);
         //
         if (count($data) == 1) {
             $kept = false;
             // for Smooth delete
             if ($this->isKept) {
                 if ($this->isSmoothDeleted($data)) {
                     $kept = true;
                 }
             }

             foreach ($data[0] as $key => $value) {
                 $this->setVars($key, $value, $kept);
             }
             $this->putForeign();
         }
     }

     protected function putForeign()
     {
         if (isset(static::$foreignKeys)) {
             if (!is_null(static::$foreignKeys)) {
                 $foreigns = static::$foreignKeys;
                 //
                 foreach ($foreigns as $key => $value) {
                     if (method_exists($this, $value)) {
                         $this->$value = $this->$value();
                     } else {
                         throw new ForeingKeyMethodException($value, get_class($this));
                     }
                 }
             }
         }
     }

     protected function setForeign()
     {
         if (isset(static::$foreignKeys)) {
             if (!is_null(static::$foreignKeys)) {
                 $foreigns = static::$foreignKeys;
                 //
                 foreach ($foreigns as $key => $value) {
                     if (method_exists($this, $value)) {
                         $this->$value = null;
                     } else {
                         throw new ForeingKeyMethodException($value, get_class($this));
                     }
                 }
             }
         }
     }

     protected function isSmoothDeleted($data)
     {
         if (is_null($data[0]['deleted_at'])) {
             return false;
         } else {
             return $data[0]['deleted_at'] < Time::current();
         }
     }

     protected static function instance()
     {
         $class = get_class();

         return new $class(null, static::$table);
     }

     protected function getData()
     {
         $vars = [];
         $defaultVars = $this->getDefaultVars();
         //
         foreach (get_object_vars($this) as $key => $value) {
             if (!in_array($key, $defaultVars)) {
                 $vars[$key] = $value;
             }
         }
         //
         return $vars;
     }

     protected function clean()
     {
         $vars = [];
         $defaultVars = $this->getDefaultVars();
         //
         foreach (get_object_vars($this) as $key => $value) {
             if (!in_array($key, $defaultVars)) {
                 $this->$key = null;
             }
         }
     }

     /**
      * To Find element by primary key.
      *
      * @param int : primary key value
      *
      * @return object
      */
     public static function find($id)
     {
         $class = get_called_class();
         //
         return new $class($id);
     }

     protected function getDefaultVars()
     {
         return ['table', 'DBtable', 'columns', 'key', 'isKept', 'isMaj', 'areMaj', 'pk', 'keyName', 'keyValue', 'kept_at', 'kept_data'];
     }

     public function emptyPK()
     {
         $key = $this->keyName;
         $this->$key = null;
     }

     public function add()
     {
         $sql = 'insert into '.$this->DBtable.' ';
         $colmn_string = '(';
         $value_string = ' values(';
         //
         $this->emptyPK();
         $data = $this->getData();
         //
         $i = 0;
         foreach ($data as $key => $value) {
             if ($i == 0) {
                 $colmn_string .= ''.$key;
                 $value_string .= "'".$value."'";
             } else {
                 $colmn_string .= ','.$key;
                 $value_string .= ",'".$value."'";
             }
             //
             $i++;
         }
         if ($this->isMaj) {
             if ($i == 0) {
                 $colmn_string .= 'created_at';
                 $value_string .= "'".Time::current()."'";
             } else {
                 $colmn_string .= ',created_at';
                 $value_string .= ",'".Time::current()."'";
             }
         }
         //
         $colmn_string .= ')';
         $value_string .= ')';
         //
         $sql .= $colmn_string.$value_string;
         //
         return Database::exec($sql);
     }

     protected function getPKvalue()
     {
         return $this->keyValue;
         // $data = $this->getData();
        // return $data[$this->keyName];
     }

     /**
      * delete the resource.
      */
     public function delete()
     {
         if ($this->isKept) {
             $this->lightDelete();
         } else {
             $this->forceDelete();
         }
     }

     /**
      * force delete if the resource is kept delete.
      */
     public function forceDelete()
     {
         $key = $this->getPKvalue();
         $sql = 'delete from '.$this->DBtable.' where '.$this->keyName." = '".$key."' ";
         //
         return Database::exec($sql);
     }

     /**
      * light delete if the resource is kept delete.
      */
     protected function lightDelete()
     {
         $now = Time::current();
         $key = $this->getPKvalue();
         //
         $sql = 'update '.$this->DBtable." set deleted_at='".$now."' where ".$this->keyName." = '".$key."' ";
         if (Database::exec($sql)) {
             $this->clean();
             $this->deleted_at = $now;
         }
     }

     /**
      * restore if kept deleted.
      */
     public function restore()
     {
         if ($this->isKept) {
             $key = $this->getPKvalue();
             $sql = 'update '.$this->DBtable.' set deleted_at=null where '.$this->keyName." = '".$key."' ";
             //
             if (Database::exec($sql)) {
                 // Code to execute the init the model
             }
         }
     }

     /**
      * Dynamic Property.
      *
      * @param $name : name of the function
      */
     public function getCallable($name)
     {
         if (method_exists($this, $name)) {
             return call_user_func([$this, $name]);
         } else {
             throw new InvalidArgumentException('Undefined property: '.get_class($this)."::$name");
         }
     }

     /**
      * Get all rows of Data Table.
      */
     public static function all()
     {
         $self = self::instance();
         //
         // Pagination
         //
         $sql = 'select * from '.$self->DBtable;

         return Database::read($sql, 1);
     }

     public function edit()
     {
         $sql = 'update '.$this->DBtable.' set ';
         //
         $data = $this->getData();
         //
         $i = 0;
         //
         foreach ($data as $key => $value) {
             if ($i == 0) {
                 $sql .= "$key='$value'";
             } else {
                 $sql .= ",$key='$value'";
             }
             $i++;
         }

         if ($this->isMaj) {
             if ($i == 0) {
                 $sql .= "edited_at='".Time::current()."'";
             } else {
                 $sql .= ",edited_at='".Time::current()."'";
             }
         }
         //
         $key = $this->getPKvalue();
         $sql .= ' where '.$this->keyName."='".$key."'";
         //
         return Database::exec($sql);
     }

     public static function get($colmn, $condution, $value)
     {
         $self = self::instance();
         $rows = new ModelArray();
         $sql = 'select * from '.$self->DBtable." where $colmn $condution '$value'";
         $data = Database::read($sql, 1);
         //
         foreach ($data as $key => $value) {
             $row = self::instance();
             //
             foreach ($value as $key2 => $value2) {
                 $row->$key2 = $value2;
                 $row->setKeyValue($key2, $value2);
             }
             //
             $rows->add($row);
         }
         //
         return $rows;
     }

     public static function where($where)
     {
         $self = self::instance();
         $rows = new ModelArray();
         //
         $sql = 'select * from '.$self->DBtable." where $where ";
         $data = Database::read($sql, 1);
         //
         foreach ($data as $key => $value) {
             $row = self::instance();
             //
             foreach ($value as $key2 => $value2) {
                 $row->$key2 = $value2;
                 $row->setKeyValue($key2, $value2);
             }
             //
             $rows->add($row);
         }
         //
         return $rows;
     }

     /**
      * To count rows by where clause.
      *
      * @param $where (string) : the where clause
      **/
     public static function count($where)
     {
         $self = self::instance();
         $rows = new ModelArray();
         //
         $sql = 'select count(*) as cnt from '.$self->DBtable." where $where ";
         $data = Database::read($sql, 1);
         //
         return $data[0]['cnt'];
     }

     /**
      * Check if element in where existe.
      *
      * @param $where (string) : the where clause
      */
     public static function exist($where)
     {
         $self = self::instance();
         $rows = new ModelArray();
         //
         $sql = 'select count(*) as cnt from '.$self->DBtable." where $where ";
         $data = Database::read($sql, 1);
         //
         return $data[0]['cnt'] > 0;
     }

     /**
      * The has one relation for one to one.
      *
      * @param $model : the model wanted to be related to the
      *			current model
      * @param $local : if not null would be the local column
      *			of the relation
      * @param $remote : if not null would be the $remote column
      *			of the relation
      */
     public function hasOne($model, $local = null, $remote = null)
     {
         return (new OneToOne())->ini($model, $this, $local, $remote);
     }

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
     public function hasMany($model, $local = null, $remote = null)
     {
         return (new OneToMany())->ini($model, $this, $local, $remote);
     }

     /**
      * The many to many relation.
      *
      * @param $model : the model wanted to be related to the
      *			current model
      * @param $local : if not null would be the local column
      *			of the relation
      * @param $remote : if not null would be the $remote column
      *			of the relation
      */
     public function belongsToMany($model, $intermediate = null, $local = null, $remote = null)
     {
         return (new ManyToMany())->ini($model, $this, $intermediate, $local, $remote);
     }

     public function belongsTo($model, $local = null, $remote = null)
     {
         return (new BelongsTo())->ini($model, $this, $local, $remote);
         // $val=$this->$local;
        // $mod=new $model;
        // $data=$mod->get($remote, '=' , $val);
        // return $data->get();
     }
 }
