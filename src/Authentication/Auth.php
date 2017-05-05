<?php

namespace Vinala\Kernel\Authentication;

use LogicException;
use Vinala\Kernel\Authentication\EXceptions\AuthenticationModelNotFoundException as AMNFE;
use Vinala\Kernel\Database\Query;
use Vinala\Kernel\Database\Row;
use Vinala\Kernel\MVC\ORM;
use Vinala\Kernel\Security\Hash;
use Vinala\Kernel\Storage\Cookie;
use Vinala\Kernel\Storage\Session;

/**
 * Authentication surface.
 *
 * @version 2.0
 *
 * @author Youssef Had
 *
 * @since v3.3.0
 */
class Auth
{
    //--------------------------------------------------------
    // Properties
    //--------------------------------------------------------

    /**
     * The data source table.
     *
     * @var string
     */
    private static $table;

    /**
     * The fields used in authentication.
     *
     * @var array
     */
    private static $fields = [];

    /**
     * The cookie saved fields.
     *
     * @var array
     */
    private static $saved = [];

    /**
     * The user authenticated data.
     *
     * @var Row
     */
    private static $user;

    //--------------------------------------------------------
    // Constructor
    //--------------------------------------------------------

    public function __construct()
    {
        //
    }

    /**
     * The init of surface.
     *
     * @return null
     */
    public static function ini()
    {
        static::$table = config('auth.table');
        static::$fields = config('auth.hashed_fields');
        static::$saved = config('auth.saved_fields');
    }

    //--------------------------------------------------------
    // Functions
    //--------------------------------------------------------

    /**
     * Try to authenticate.
     *
     * @param array $fields
     * @param bool  $remember
     *
     * @return bool
     */
    public static function attempt($fields, $remember = false)
    {
        $hashed = static::hash($fields);

        $data = static::query($hashed);

        if (count($data) > 0) {
            //Set the user
            static::$user = static::orm($data[0]);

            static::save_session();

            static::save_cookie();

            return true;
        }

        return false;
    }

    /**
     * Hash the authentication data.
     *
     * @param array $data
     *
     * @return array
     */
    protected static function hash($fields)
    {
        foreach ($fields as $key => $value) {
            if (in_array($key, self::$fields)) {
                $fields[$key] = Hash::make($value);
            }
        }

        return $fields;
    }

    /**
     * Get the user authenticate.
     *
     * @param array $fields
     * @param array $hashed
     *
     * @return array
     */
    protected static function query($fields)
    {
        $result = Query::from(static::$table);

        $result = $result->where();

        foreach ($fields as $key => $value) {
            $result = $result->andWhere($key, '=', $value);
        }

        return $result->get();
    }

    /**
     * Save the user in the session.
     *
     * @param array $user
     *
     * @return bool
     */
    protected static function save_session()
    {
        $saved = [];

        $user = (array) static::$user;

        foreach ($user as $key => $value) {
            if (in_array($key, static::$saved)) {
                $saved[$key] = $value;
            }
        }

        $name = static::resource('session');

        Session::put($name, $saved, config('auth.cookie_lifetime'));

        return true;
    }

    /**
     * Create Cookie if the authentication will be remembred.
     *
     * @return bool
     */
    protected static function save_cookie()
    {
        $name = static::resource('cookie');

        return Cookie::create(
            $name,
            static::$user->rememberToken,
            config('auth.cookie_lifetime')
            );
    }

    /**
     * Logout the user from the app.
     *
     * @return true
     */
    public static function logout()
    {
        Session::forget(static::resource('session'));
        Cookie::forget(static::resource('cookie'));
        static::$user = null;

        return true;
    }

    /**
     * Check if user logged in.
     *
     * @return bool
     */
    public static function check()
    {
        if (Session::exists(static::resource('session'))) {
            return true;
        } elseif (Cookie::existe(static::resource('cookie'))) {
            $token = Cookie::get(static::resource('cookie'));

            $result = Query::from(config('auth.table'))
                ->where('rememberToken', '=', $token)
                ->get();

            if (count($result) > 0) {
                return true;
            }

            return false;
        }

        return false;
    }

    /**
     * Get the user logged in.
     *
     * @return Vinala\Kernel\MVC\ORM
     */
    public static function user()
    {
        if (self::check()) {
            if (is_null(static::$user)) {
                $data = Session::get(static::resource('session'));

                $data = static::query($data);

                static::$user = static::orm($data[0]);
            }

            return static::$user;
        }
    }

    /**
     * Login the user if session or cookie saved.
     *
     * @return Vinala\Kernel\MVC\ORM|bool
     */
    public static function login()
    {
        if (Cookie::existe(static::resource('cookie'))) {
            $token = Cookie::get(static::resource('cookie'));

            $result = Query::from(config('auth.table'))
                ->where('rememberToken', '=', $token)
                ->get();

            if (count($result) > 0) {
                static::$user = static::orm($result[0]);

                static::save_session();

                return static::$user;
            }

            return false;
        }

        return false;
    }

    /**
     * Check if the user is a guest.
     *
     * @return bool
     */
    public static function guest()
    {
        if (self::check()) {
            return false;
        }

        return true;
    }

    /**
     * Convert data from array of
     * Vinala\Kernel\Database\Row to
     * Vinala\Kernel\MVC\ORM.
     *
     * @param array $data
     *
     * @return Vinala\Kernel\MVC\ORM
     */
    private static function orm(Row $data)
    {
        // exception_if( ! ( $data instanceof Row) , \LogicException::class , 'The result of Authentication query is not instance of Vinala\Kernel\Database\Row');

        $data = (array) $data;
        $id = array_shift($data);

        $model = config('auth.model');

        exception_if(!class_exists($model), AMNFE::class);

        return new $model($id);
    }

    /**
     * Get the resources hashed name.
     *
     * @param string $resource session|cookie
     *
     * @return string
     */
    private static function resource($resource)
    {
        exception_if(($resource != 'session' && $resource != 'cookie'), LogicException::class, 'The resource name of \''.$resource.'\' is not supported by Vinala, only session or cookie');

        return Hash::make(config('auth.'.$resource));

        // For more security, make for every user a resource name
        return Hash::make(config('auth.'.$resource).static::$user->rememberToken);
    }
}
