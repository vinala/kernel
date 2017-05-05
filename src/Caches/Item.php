<?php

namespace Vinala\Kernel\Cache;

use Symfony\Component\Cache\CacheItem;

/**
 * The item cache class.
 *
 * @version 1.0
 *
 * @author Youssef Had
 *
 * @since v3.3.0
 */
class Item
{
    //--------------------------------------------------------
    // Properties
    //--------------------------------------------------------

    /**
     * The symfony cache item.
     *
     * @var Symfony\Component\Cache\CacheItem
     */
    protected $item = null;

    //--------------------------------------------------------
    // Constructor
    //--------------------------------------------------------

    public function __construct(CacheItem $item)
    {
        $this->item = $item;
    }

    //--------------------------------------------------------
    // Functions
    //--------------------------------------------------------

    /**
     * Get the value of the item.
     *
     * @return mixed
     */
    public function value()
    {
        return $this->item->get();
    }

    /**
     * Get the key name of the item.
     *
     * @return mixed
     */
    public function name()
    {
        return $this->item->getKey();
    }
}
