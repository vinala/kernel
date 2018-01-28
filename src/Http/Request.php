<?php

namespace Vinala\Kernel\Http;

/**
 * Requests Class.
 */
class Request
{
    /**
     * Data array contains request data.
     *
     * @var array
     */
    protected $data = [];

    public function __construct()
    {
        $this->data = $this->getData();

        $this->setProperties();
    }

    /**
     * Get resuest data.
     *
     * @return array
     */
    public function getData()
    {
        $data = $_REQUEST;
        unset($data['_framework_url_']);

        return $data;
    }

    /**
     * Set request data as class properties.
     *
     * @return bool
     */
    protected function setProperties()
    {
        foreach ($this->data as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * Get all Requests.
     *
     * @return array
     */
    public function all()
    {
        return $this->data;
    }

    /**
     * Return true if the current request is post.
     *
     * @return bool
     */
    public static function isPost()
    {
        return !empty($_POST) && isset($_POST);
    }
}
