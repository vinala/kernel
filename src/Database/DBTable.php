<?php

namespace Vinala\Kernel\Database;

use Vinala\Kernel\Config\Config;
use Vinala\Kernel\HyperText\Res;

class DBTable
{
    public $name = 'null';
    public $reelName = null;
    public $columns = [];
    public $data = [];

    //pagination data

    public $nbRows;
    public $nbPages;
    public $CurrentPage;
    public $RowsPerPage;

    //
    public function __construct($name)
    {
        $this->reelName = $name;
        $this->name = $this->setName($name);
        //
        $columns = Database::read("select COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '".Config::get('database.database')."' AND TABLE_NAME = '".$this->name."';");
        //
        foreach ($columns as $key => $value) {
            array_push($this->columns, $value['COLUMN_NAME']);
        }
    }

    public function setName($name)
    {
        if (Config::get('database.prefixing')) {
            return Config::get('database.prefixe').$name;
        } else {
            return $name;
        }
    }

    public function insert($array)
    {
        $ok = false;

        if (count($array) > 0) {
            foreach ($array as $subarray) {
                if (count($subarray) > 0) {
                    $sql = 'insert into '.$this->name.' ';
                    $col = '(';
                    $vals = '(';
                    //
                    $i = 0;
                    foreach ($subarray as $key => $value) {
                        if ($i > 0) {
                            $col .= ',';
                            $vals .= ',';
                        }
                        $col .= $key;
                        $vals .= "'$value'";
                        $i++;
                    }
                    //
                    $col .= ')';
                    $vals .= ')';
                    //
                    $sql .= $col.' values'.$vals.';';
                    //
                    $ok = Database::exec($sql);
                }
            }
        }
        //
        return $ok;
    }

    public function update($cond, $array)
    {
        $ok = false;

        if (count($array) > 0) {
            foreach ($array as $subarray) {
                if (count($subarray) > 0) {
                    $sql = 'update '.$this->name.' set ';
                    $val = '';
                    //
                    $i = 0;
                    foreach ($subarray as $key => $value) {
                        if ($i > 0) {
                            $val .= ',';
                        }
                        $val .= $key."='".$value."'";
                        $i++;
                    }
                    //
                    $sql .= $val.' where '.$cond.';';
                    //
                    $ok = Database::exec($sql);
                }
            }
        }
        //
        return $ok;
    }

    public function delete($cond)
    {
        $sql = 'delete from '.$this->name.' where '.$cond;

        return Database::exec($sql);
    }

    public function clear()
    {
        Database::exec('TRUNCATE TABLE '.$this->name.';');
    }

    public function all($sql = '')
    {
        if (empty($sql)) {
            $sql = 'select * from '.$this->name;
        }
        //
        $this->data = Database::read($sql);

        return $this->data;
    }

    public function paginate($RowsPerPage)
    {

        // count data
        $sql = 'select count(*) as nbRows from '.$this->name;
        $var = Database::read($sql);
        $this->RowsPerPage = $RowsPerPage;
        $this->nbRows = $var[0]['nbRows'];
        $this->nbPages = ceil($this->nbRows / $RowsPerPage);

        //if isset get
        $this->CurrentPage = 1;
        if (isset($_GET[Config::get('view.pagination_param')]) && !empty($_GET[Config::get('view.pagination_param')])) {
            if ($_GET[Config::get('view.pagination_param')] > 0 && $_GET[Config::get('view.pagination_param')] <= $this->nbPages) {
                $this->CurrentPage = Res::get(Config::get('view.pagination_param'));
            }
        }

        //get Data
        $r = [];
        $sql = 'select * from '.$this->name.' Limit '.(($this->CurrentPage - 1) * $this->RowsPerPage).",$this->RowsPerPage";
        $this->data = Database::read($sql);
        //

        return $this;
    }
}
