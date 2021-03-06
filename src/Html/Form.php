<?php

namespace Vinala\Kernel\Html;

use Vinala\Kernel\Storage\Session;

/**
 * Form Class.
 */
class Form
{
    /**
     * array for framework reserved attributes.
     *
     * @var array
     */
    protected static $reserved = ['method', 'action', 'url', 'charset', 'files'];

    /**
     * array of labels used in form.
     *
     * @var array
     */
    protected static $labels = [];

    /**
     * the CSRF token.
     *
     * @var string
     */
    protected static $csrfToken;

    /**
     * function to open the form.
     *
     * @param array $options
     *
     * @return string
     */
    public static function open(array $options = [])
    {
        // get the method passed in $options else use port
        $method = array_get($options, 'method', 'post');
        $attributes['method'] = self::getMethod($method);

        $attributes['action'] = self::getAction($options);
        $attributes['accept-charset'] = array_get($options, 'charset', 'UTF-8');
        //
        //PUT and PATCH and DELETE
        //
        //if form use files
        if (isset($options['files']) || in_array('files', $options)) {
            $options['enctype'] = 'multipart/form-data';
        }

        $attributes = array_merge(
            $attributes, array_except($options, self::$reserved)
        );

        $attributes = Html::attributes($attributes);

        $token = self::token();

        return '<form'.$attributes.'>'.$token;
    }

    /**
     * function to set form method to upper
     * and eccept ONLY get and post.
     *
     * @param string $method
     *
     * @return string
     */
    protected static function getMethod($method)
    {
        $method = strtoupper($method);
        //
        return $method != 'GET' ? 'POST' : $method;
    }

    /**
     * Function to set the method.
     *
     * @param array $options
     *
     * @return string
     */
    protected static function getAction(array $options)
    {
        //check if action is URL
        if (array_has($options, 'url')) {
            return 'http://'.array_get($options, 'url');
        }

        //check if action is secure for HTTPS
        if (array_has($options, 'secure')) {
            return 'https://'.array_get($options, 'secure');
        }

        //check if action is route
        if (array_has($options, 'route')) {
            return path().array_get($options, 'route');
        }
    }

    /**
     * function to close form.
     *
     * @return string
     */
    public static function close()
    {
        self::$labels = null;

        return '</form>';
    }

    /**
     * Get the ID attribute for a field name.
     *
     * @param string $name
     * @param array  $attributes
     *
     * @return string
     */
    public static function getIdAttribute($name, $attributes)
    {
        if (array_has($attributes, 'id')) {
            return $attributes['id'];
        }

        if (!is_null(self::$labels)) {
            if (in_array($name, self::$labels)) {
                return $name;
            }
        }
    }

    /**
     * Create a form input field.
     *
     * @param string $type
     * @param string $name
     * @param string $value
     * @param array  $options
     *
     * @return string
     */
    public static function input($type, $name, $value = null, $options = [])
    {
        if (!isset($options['name'])) {
            $options['name'] = $name;
        }

        $id = self::getIdAttribute($name, $options);

        $merge = compact('type', 'value', 'id');
        $options = array_merge($options, $merge);

        return '<input'.Html::attributes($options).'>';
    }

    /**
     * Create a form checked field.
     *
     * @param string $type
     * @param string $name
     * @param string $value
     * @param array  $options
     *
     * @return string
     */
    public static function checked($type, $name, $checked = false, $options = [])
    {
        if (!isset($options['name'])) {
            $options['name'] = $name;
        }

        $id = self::getIdAttribute($name, $options);

        $merge = compact('type', 'value', 'id');
        $options = array_merge($options, $merge);

        $checked = !$checked ? '' : 'checked';

        return '<input'.Html::attributes($options)." $checked>";
    }

    /**
     * Exclure main input arguments from array.
     *
     * @param array $options
     * @param array $args
     *
     * @return array
     */
    protected static function exclure(&$options, $args = ['type', 'value', 'name'])
    {
        foreach ($options as $key => $option) {
            if (array_has($args, $key)) {
                unset($options[$key]);
            }
        }
    }

    /**
     * Create a form input hidden.
     *
     * @param string $name
     * @param string $value
     * @param array  $options
     *
     * @return string
     */
    public static function hidden($name, $value = null, array $options = [])
    {
        self::exclure($options);

        return self::input('hidden', $name, $value, $options);
    }

    /**
     * Create a form csrf input hidden.
     *
     * @return string
     */
    public static function token()
    {
        self::$csrfToken = !empty(self::$csrfToken) ? self::$csrfToken : Session::token();

        return self::hidden('_token', self::$csrfToken);
    }

    /**
     * function to genenrate input text.
     *
     * @param string $name
     * @param string $value
     * @param array  $options
     *
     * @return string
     */
    public static function text($name, $value = null, array $options = [])
    {
        self::exclure($options);

        return self::input('text', $name, $value, $options);
    }

    /**
     * function to create form password input.
     *
     * @param string $name
     * @param string $value
     * @param array  $options
     *
     * @return string
     */
    public static function password($name, $value = null, array $options = [])
    {
        self::exclure($options);

        return self::input('password', $name, $value, $options);
    }

    /**
     * generate form input email.
     *
     * @param string $name
     * @param string $value
     * @param array  $options
     *
     * @return string
     */
    public static function email($name, $value = null, array $options = [])
    {
        self::exclure($options);

        return self::input('email', $name, $value, $options);
    }

    /**
     * generate a url form input.
     *
     * @param string $name
     * @param string $value
     * @param array  $options
     *
     * @return string
     */
    public static function url($name, $value = null, array $options = [])
    {
        self::exclure($options);

        return self::input('url', $name, $value, $options);
    }

    /**
     * generate a file input field.
     *
     * @param string $name
     * @param array  $options
     *
     * @return string
     */
    public static function file($name, $options = [])
    {
        self::exclure($options);

        return self::input('file', $name, null, $options);
    }

    /**
     * generate a textarea input field.
     *
     * @param string $name
     * @param string $value
     * @param array  $options
     *
     * @return string
     */
    public static function textarea($name, $value = null, array $options = [])
    {
        self::exclure($options);

        //for textarea size
        $options = self::setTextAreaSize($options);

        $options['id'] = self::getIdAttribute($name, $options);
        $options['name'] = $name;

        unset($options['size']);

        $options = Html::attributes($options);

        return '<textarea'.$options.'>'.e($value).'</textarea>';
    }

    /**
     * set a textarea size from options.
     *
     * @param array $options
     *
     * @return
     */
    public static function setTextAreaSize($options)
    {
        if (isset($options['size'])) {
            return self::setQuickTextAreaSize($options);
        }

        $cols = array_get($options, 'cols', 50);
        $rows = array_get($options, 'rows', 10);

        return array_merge($options, compact('cols', 'rows'));
    }

    /**
     * get a textarea size from string option.
     *
     * @param array $option
     *
     * @return array
     */
    public static function setQuickTextAreaSize($options)
    {
        $value = explode('x', $options['size']);

        if (count($value) < 2) {
            return array_merge($options, ['cols' => 50, 'rows' => 10]);
        } elseif (!is_numeric($value[0]) || !is_numeric($value[1])) {
            return array_merge($options, ['cols' => 50, 'rows' => 10]);
        } else {
            return array_merge($options, ['cols' => $value[0], 'rows' => $value[1]]);
        }
    }

    /**
     * generate a select input field.
     *
     * @param string $name
     * @param array  $list
     * @param string $selected
     * @param array  $options
     *
     * @return string
     */
    public static function select($name, $list = [], $selected = null, $options = [])
    {
        self::exclure($options, ['name']);
        //
        $options['name'] = $name;
        //
        $sub = '';
        //
        if (!empty($list)) {
            foreach ($list as $value) {
                $sub .= self::option($value, (!is_null($selected) && $value == $selected));
            }
        }
        //
        $options = Html::attributes($options);
        //
        return '<select'.$options.">\n".$sub."</select>\n";
    }

    /**
     * set select options.
     *
     * @param string $value
     * @param string $key
     * @param bool   $seleceted
     *
     * @return string
     */
    protected static function option($value, $seleceted = false)
    {
        return "\t\t<option value='$value' ".(!$seleceted ? '' : 'selected').">$value</option>\n";
    }

    /**
     * Set a form checkbox.
     *
     * @param string $name
     * @param bool   $checked
     * @param array  $options
     *
     * @return string
     */
    public static function checkbox($name, $checked = false, $options = [])
    {
        self::exclure($options);

        return self::checked('checkbox', $name, $checked, $options);
    }

    /**
     * Set a form radio.
     *
     * @param string $name
     * @param bool   $checked
     * @param array  $options
     *
     * @return string
     */
    public static function radio($name, $checked = false, $options = [])
    {
        self::exclure($options, ['value']);

        return self::checked('radio', $name, $checked, $options);
    }

    /**
     * generate a file image field.
     *
     * @param string $url
     * @param string $name
     * @param array  $options
     *
     * @return string
     */
    public static function image($url, $name = null, $options = [])
    {
        $options['src'] = $url;

        self::exclure($options);

        return self::input('image', $name, null, $options);
    }

    /**
     * function to genenrate reset.
     *
     * @param string $value
     * @param array  $options
     *
     * @return string
     */
    public static function reset($value, array $options = [])
    {
        self::exclure($options, ['type', 'value']);

        return self::input('reset', 'null', $value, $options);
    }

    /**
     * function to genenrate submit.
     *
     * @param string $value
     * @param array  $options
     *
     * @return string
     */
    public static function submit($value, array $options = [])
    {
        self::exclure($options, ['type', 'value']);

        return self::input('submit', 'null', $value, $options);
    }

    /**
     * Create a form label.
     *
     * @param string $name
     * @param string $value
     * @param array  $options
     *
     * @return string
     */
    public static function label($name, $value = null, array $options = [])
    {
        self::exclure($options, ['value', 'for']);

        self::$labels[] = $name;

        $value = e(self::formatLabel($name, $value));

        $options = Html::attributes($options);

        return '<label for="'.$name.'"'.$options.'>'.$value.'</label>';
    }

    /**
     * Get label form name and format.
     *
     * @param string $name
     * @param string $value
     *
     * @return string
     */
    public static function formatLabel($name, $value)
    {
        return $value ?: ucwords(str_replace('_', ' ', $name));
    }
}
