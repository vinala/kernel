<?php

namespace Vinala\Kernel\Http\Redirect;

use Vianal\Kernel\Routing\Url;

/**
 * Redirect class.
 *
 * @version 1.0
 *
 * @author Youssef Had
 *
 * @since v3.3.0
 */
class Redirector
{
    //--------------------------------------------------------
    // Properties
    //--------------------------------------------------------

    /**
     * Te scheme used for the last request.
     *
     * @var string
     */
    protected $cacheScheme;

    //--------------------------------------------------------
    // Constructor
    //--------------------------------------------------------

    public function __construct()
    {
    }

    //--------------------------------------------------------
    // Functions
    //--------------------------------------------------------

    /**
     * Redirect to url.
     *
     * @param string $url
     *
     * @return bool
     */
    protected function locate($url)
    {
        header('Location: '.$url);
        die();
    }

    /**
     * Redirect to previous location.
     *
     * @return mixed
     */
    public function back()
    {
        return self::locate('javascript://history.go(-1)');
    }

    /**
     * Redirect to some url.
     *
     * @param string $url
     * @param array  $extra
     * @param bool   $secure
     *
     * @return mixed
     */
    public function to($url, $extra = [], $secure = null)
    {
        if ($this->isValidUrl($url)) {
            return $url;
        }

        $scheme = $this->getScheme($secure);

        $params = $this->setParams($extra);

        $url = $this->setUrl($url);

        $url = $scheme.$url.$params;

        return self::locate($url);
    }

    /**
     * Get the scheme.
     *
     * @param bool $secured
     *
     * @return string
     */
    protected function getScheme($secured = null)
    {
        if (is_null($secured)) {
            if (is_null($this->cacheScheme)) {
                $this->cacheScheme = request('REQUEST_SCHEME', 'http', 'server').'://';

                return $this->cacheScheme;
            } else {
                $this->cacheScheme;
            }
        }

        return $secured ? 'http://' : 'https://';
    }

    /**
     * To set get parameters.
     *
     * @param array $args
     *
     * @return string
     */
    protected function setParams(array $args)
    {
        if (!empty($args)) {
            $request = '?';
        } else {
            $request = '';
        }

        foreach ($args as $key => $value) {
            if (is_numeric($key)) {
                if ($request != '?') {
                    $request .= '&';
                }
                $request .= $value;
            } elseif (is_string($key)) {
                if ($request != '?') {
                    $request .= '&';
                }
                $request .= $key.'='.$value;
            }
        }

        return $request;
    }

    /**
     * Check if the url used is a valid url.
     *
     * @param string $url
     *
     * @return bool
     */
    protected function isValidUrl($url)
    {
        return Url::isValidUrl($url);
    }

    /**
     * Set the url redirection.
     *
     * @param string $url
     *
     * @return string
     */
    private static function setUrl($url)
    {
        $server = $_SERVER['SERVER_NAME'];

        return $url == '/' ? $server : $url;
    }

    /**
     * Redirect to route.
     *
     * @param string $route
     * @param bool   $secure
     *
     * @return mixed
     */
    public function route($route, $secure = null)
    {
        $path = Url::root();

        if ($route == '/') {
            $route = $path;
        } else {
            $route = $path.$route;
        }

        return self::locate($route, $secure);
    }
}
