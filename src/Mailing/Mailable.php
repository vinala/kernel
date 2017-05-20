<?php

namespace Vinala\Kernel\Mailing ;

use Vinala\Kernel\MVC\View;

/**
* The Mailable class where users can send thier mails
*
* @version 1.0
* @author Youssef Had
* @package Vinala\Kernel\Mailing
* @since v3.3.0
*/
class Mailable
{

    //--------------------------------------------------------
    // Properties
    //--------------------------------------------------------

    /**
     * The view used
     *
     * @var string
     */
    public $_view;

    //--------------------------------------------------------
    // Constructor
    //--------------------------------------------------------

    function __construct()
    {
        //
    }

    //--------------------------------------------------------
    // Functions
    //--------------------------------------------------------

    /**
     * Set the view
     *
     * @param string $name
     *
     * @return Vinala\Kernel\Mailing\Mailable
     */
    public function view($name)
    {
        $this->_view = View::make($name);

        $vars = get_object_vars($this);

        foreach ($vars as $key => $value) {
            if (! in_array($key, ['_view'])) {
                $this->_view->with($key, $value);
            }
        }

        return $this;
    }
}
