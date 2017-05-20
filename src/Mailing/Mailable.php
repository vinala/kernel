<?php

namespace Vinala\Kernel\Mailing;

use Vinala\Kernel\MVC\View;

/**
 * The Mailable class where users can send thier mails.
 *
 * @version 1.0
 *
 * @author Youssef Had
 *
 * @since v3.3.0
 */
class Mailable
{
    //--------------------------------------------------------
    // Properties
    //--------------------------------------------------------

    /**
     * The view used.
     *
     * @var string
     */
    public $_view;

    /**
     * The sender name.
     *
     * @var string
     */
    private $_sender_name;

    /**
     * The sender email.
     *
     * @var string
     */
    private $_sender_mail;

    //--------------------------------------------------------
    // Constructor
    //--------------------------------------------------------

    public function __construct()
    {
        //
    }

    //--------------------------------------------------------
    // Functions
    //--------------------------------------------------------

    /**
     * The mail builder function.
     *
     * @return $this
     */
    abstract protected function build();

    /**
     * Set the view.
     *
     * @param string $name
     *
     * @return $this
     */
    public function view($name)
    {
        $this->_view = View::make($name);

        $vars = get_object_vars($this);

        foreach ($vars as $key => $value) {
            if (!in_array($key, ['_view', '_sender_name', '_sender_mail'])) {
                $this->_view->with($key, $value);
            }
        }

        return $this;
    }

    /**
     * Set the sender email and name.
     *
     * @param string $mail
     * @param string $name
     *
     * @return $this
     */
    public function from($mail, $name)
    {
        $this->_sender_name = $name;
        $this->_sender_mail = $mail;

        return $this;
    }
}
