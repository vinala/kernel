<?php

namespace Vinala\Kernel\Events;

class EventListener
{
    /**
     * Set events pattern and thier function.
     *
     * @var array
     */
    protected static $events;

    /**
     * Get Events of Listener.
     *
     * @return array
     */
    public static function getEvents()
    {
        return static::$events;
    }
}
