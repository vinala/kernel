<?php

namespace Vinala\Kernel\Cache\Driver;

use Vinala\Kernel\Cache\Exception\DatabaseSurfaceDisabledException;
use Vinala\Kernel\Database\Query;
use Vinala\Kernel\Database\Schema;

/**
 * The cache driver of database.
 *
 * @version 2.0
 *
 * @author Youssef Had
 *
 * @since v3.3.0
 */
class PDODriver extends Driver
{
    //--------------------------------------------------------
    // Properties
    //--------------------------------------------------------

    /**
     * The database table.
     *
     * @var string
     */
    protected $table;

    //--------------------------------------------------------
    // Constructor
    //--------------------------------------------------------

    public function __construct()
    {
        $this->table = config('cache.options.database.table');

        $this->establish();
    }

    //--------------------------------------------------------
    // Functions
    //--------------------------------------------------------

    /**
     * Find item in cache.
     *
     * @param string $key
     *
     * @return array
     */
    private function find($key)
    {
        if ($this->exists($key)) {
            $data = Query::from($this->table)
                        ->where('name', '=', $key)
                        ->first();

            if ($data->lifetime >= time()) {
                return ['name' => $key, 'value' => $this->unpacking($data->value), 'lifetime' => $data->lifetime];
            } else {
                $this->remove($key);
            }
        }
    }

    /**
     * Check if Cache table is exists.
     *
     * @return boom
     */
    private function checkTable()
    {
        return Schema::existe($this->table);
    }

    /**
     * Create database cache table.
     *
     * @return null
     */
    private function createTable()
    {
        Schema::create($this->table, function ($tab) {
            $tab->inc('id');
            $tab->string('name');
            $tab->string('value');
            $tab->long('lifetime');
            $tab->unique('cacheunique', ['name']);
        });
    }

    /**
     * Establish conenction to database.
     *
     * @return null
     */
    private function establish()
    {
        exception_if(!config('components.database'), DatabaseSurfaceDisabledException::class);

        if (!$this->checkTable()) {
            $this->createTable();
        }
    }

    /**
     * Packing the data to string.
     *
     * @param mixed
     *
     * @return string
     */
    protected function packing($value)
    {
        return serialize($value);
    }

    /**
     * Unpacking the data from string.
     *
     * @param string $mixed
     *
     * @return mixed
     */
    protected function unpacking($value)
    {
        return unserialize($value);
    }

    /**
     * Create new item cache.
     *
     * @param string $name
     * @param mixed  $value
     * @param int    $lifetime
     *
     * @return bool
     */
    public function put($name, $value, $lifetime = null, $timestamp = false)
    {
        if (is_null($lifetime)) {
            $lifetime = confg('cache.lifetime');
        }

        if (!$timestamp) {
            $lifetime = time() + $lifetime;
        }

        $value = $this->packing($value);

        $this->save($name, $value, $lifetime);
    }

    /**
     * Add data to cache database table.
     *
     * @param string $name
     * @param string $value
     * @param int    $lifetime
     *
     * @return bool
     */
    protected function add($name, $value, $lifetime)
    {
        return Query::into($this->table)
                    ->column('name', 'value', 'lifetime')
                    ->value($name, $value, $lifetime)
                    ->insert();
    }

    /**
     * Update data in cache database table.
     *
     * @param string $name
     * @param string $value
     * @param int    $lifetime
     *
     * @return bool
     */
    protected function edit($name, $value, $lifetime)
    {
        return Query::into($this->table)
                    ->set('name', $name)
                    ->set('value', $value)
                    ->set('lifetime', $lifetime)
                    ->where('name', '=', $name)
                    ->update();
    }

    /**
     * Remove data from cache database table.
     *
     * @param string $name
     *
     * @return bool
     */
    public function remove($name)
    {
        return Query::from($this->table)
                    ->where('name', '=', $name)
                    ->delete();
    }

    /**
     * Save the data cache.
     *
     * @param string $name
     * @param string $value
     * @param int    $lifetime
     *
     * @return bool
     */
    protected function save($name, $value, $lifetime)
    {
        if ($this->exists($name)) {
            return $this->edit($name, $value, $lifetime);
        }

        return $this->add($name, $value, $lifetime);
    }

    /**
     * Check if cache key exists in database.
     *
     * @param string $key
     *
     * @return bool
     */
    private function exists($key)
    {
        $data = Query::from($this->table)->where('name', '=', $key)->get();

        return  count($data) > 0;
    }

    /**
     * Check if cache key exists in database.
     *
     * @param string $key
     *
     * @return bool
     */
    public function has($key)
    {
        return $this->exists($key);
    }

    /**
     * Get a cache key.
     *
     * @param string name
     *
     * @return mixed
     */
    public function get($name, $default = null)
    {
        if ($this->exists($name)) {
            $data = Query::from($this->table)
                        ->where('name', '=', $name)
                        ->first();

            if ($data->lifetime >= time()) {
                return $this->unpacking($data->value);
            } else {
                $this->remove($name);

                return $default;
            }
        }

        return $default;
    }

    /**
     * Get an item cache and remove it.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function pull($key)
    {
        $item = $this->get($key);

        $this->remove($key);

        return $item;
    }

    /**
     * Get Expiration time of a key.
     *
     * @param string $key
     *
     * @return int
     */
    public function expiration($key)
    {
        if ($this->exists($name)) {
            $data = Query::from($this->table)
                        ->where('name', '=', $name)
                        ->first();

            if ($data->lifetime >= time()) {
                return $data->lifetime;
            }
        }
    }

    /**
     * Prolong a lifetime of cache item.
     *
     * @param string $key
     * @param int    $lifetime
     *
     * @return bool
     */
    public function prolong($key, $lifetime)
    {
        $item = $this->find($key);

        if (!is_null($item)) {
            $lifetime = $item['lifetime'] + $lifetime;

            $this->put($key, $item['value'], $lifetime, true);
        }
    }
}
