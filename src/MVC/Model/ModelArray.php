<?php

namespace Vinala\Kernel\MVC\Model;

use Vinala\Kernel\Collections\Collection;

/**
 * Model array Class.
 */
class ModelArray
{
    public $data;

    public function __construct($data = null)
    {
        if (!is_null($data)) {
            $this->data = $data;
        }
    }

    public function add($row)
    {
        $this->data[] = $row;
    }

    public function get()
    {
        return $this->data;
    }

    public function count()
    {
        return count($this->data);
    }

    public function take($count, $start = 0)
    {
        $data = new self();
        //
        $last = $this->count() > $count ? $count : $this->count();
        //
        for ($i = $start; $i < $last; $i++) {
            $data->add($this->data[$i]);
        }
        //
        return $data;
    }

    /**
     * Get first row of data selected by where clause.
     **/
    public function first()
    {
        if (!empty($this->data)) {
            if (Collection::count($this->data) > 0) {
                return $this->data[0];
            } else {
                return;
            }
        } else {
            return;
        }
    }
}
