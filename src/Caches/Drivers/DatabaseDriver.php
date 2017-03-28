<?php

namespace Vinala\Kernel\Cache\Driver ;

use Vinala\Kernel\Database\Query;
use Vinala\Kernel\Database\Schema;

/**
* The cache driver of database
*
* @version 2.0
* @author Youssef Had
* @package Vinala\Kernel\Cache\Driver
* @since v3.3.0
*/
class PDODriver extends Driver
{

    //--------------------------------------------------------
    // Properties
    //--------------------------------------------------------

    /**
    * The database table 
    *
    * @var string
    */
    protected $table ;

    //--------------------------------------------------------
    // Constructor
    //--------------------------------------------------------

    function __construct()
    {
        $this->table = config('cache.option.database.table');

        $this->establish();
    }

    //--------------------------------------------------------
    // Functions
    //--------------------------------------------------------

    /**
    * Check if Cache table is exists
    *
    * @return boom
    */
    private function checkTable()
    {
        return Schema::existe($this->table);
    }


    /**
    * Create database cache table
    *
    * @return null
    */
    private function createTable()
    {
        Schema::create($this->table,function($tab)
			{
				$tab->inc("id");
				$tab->string("name");
				$tab->string("value");
				$tab->long("life");
				$tab->unique("cacheunique",["name"]);
			});
    }

    /**
    * Establish conenction to database
    *
    * @return null
    */
    private function establish()
    {
        if( ! $this->checkTable())
        {
            $this->createTable();
        }
    }

    /**
    * Packing the data to string 
    *
    * @param mixed
    * @return string 
    */
    protected function packing($value)
    {
        return serialize($value);
    }

    /**
    * Unpacking the data from string 
    *
    * @param string $mixed
    * @return mixed
    */
    protected function unpacking($value)
    {
        return unserialize($value);
    }

    /**
    * Create new item cache 
    *
    * @param string $name
    * @param mixed $value
    * @param int $lifetime
    * @return bool
    */
    public function put($name , $value , $lifetime = null)
    {
        if (is_null($lifetime)) 
        {
            $lifetime = confg('cache.lifetime');
        }
    }

    /**
    * Add data to cache database table 
    *
    * @param string $name 
    * @param string $value 
    * @param int $lifetime
    * @return bool
    */
    protected function add($name , $value , $lifetime)
    {
        return Query::into($this->table)
                    ->column('name' , 'value' , 'life')
                    ->value($name , $value , $lifetime)
                    ->insert();
    }

    /**
    * Update data in cache database table 
    *
    * @param string $name 
    * @param string $value 
    * @param int $lifetime
    * @return bool
    */
    protected function edit($name , $value , $lifetime)
    {
        return Query::into($this->table)
                    ->set('name' , $name)
                    ->set('value' , $value)
                    ->set('lifetime' , $lifetime)
                    ->where('name' , '=' , $name)
                    ->update();
    }

    /**
    * Remove data from cache database table 
    *
    * @param string $name
    * @return bool
    */
    public function remove($name)
    {
        return Query::from($this->table)
                    ->where('name' , '=' , $name)
                    ->remove();
    }

    /**
    * Save the data cache
    *
    * @param string $name 
    * @param string $value 
    * @param int $lifetime
    * @return bool
    */
    protected function save($name , $value , $lifetime)
    {
        if($this->exists($name))
        {
            return $this->edit($name , $value , $lifetime);
        }
        
        return $this->add($name , $value , $lifetime);
    }

    /**
    * Check if cache key exists in database
    *
    * @param string $key
    * @return bool
    */
    private function exists($key)
    {
        $data = Query::from($this->table)->where('name' , '=' , $key)->get();

        return ( count($data) > 0 );
    }

    /**
    * Check if cache key exists in database
    *
    * @param string $key
    * @return bool
    */
    public function has($key)
    {
        return $this->exists($key);
    }



}