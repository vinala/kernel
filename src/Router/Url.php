<?php

namespace Vianal\Kernel\Routing;

use Vinala\Kernel\String\Strings;

/**
 * The URL genarator class.
 *
 * @version 1.0
 *
 * @author Youssef Had
 *
 * @since v3.3.0
 */
class Url
{
    //--------------------------------------------------------
    // Properties
    //--------------------------------------------------------

    //

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
     * Genarte to Url.
     *
     * @param string $path
     * @param array  $extra
     * @param bool   $secure
     *
     * @return string
     */
    public static function to($path, $extra = [], $secure = null)
    {
    }

    /**
     * Check if Url is valid.
     *
     * @param string $path
     *
     * @return bool
     */
    public static function isValidUrl($path)
    {
        if (Strings::startsWith($path, ['#', '//', 'mailto:', 'tel:', 'http://', 'https://'])) {
            return true;
        }

        return filter_var($path, FILTER_VALIDATE_URL) !== false;
    }

    /**
     * Get the app rooted url.
     *
     * @return string
     */
    public static function root($secure = null)
    {
        $framework = '/public/index.php';
        $server = request('PHP_SELF', '', 'server');
        $scheme = (is_null($secure) ? request('REQUEST_SCHEME', '', 'server') : ($secure ? 'https' : 'http')).'://';
        $serverName = request('SERVER_NAME', '', 'server');

        $parts = explode($framework, $server);

        $root = $parts[0].'/';

        return $scheme.$serverName.$root;
    }
}
