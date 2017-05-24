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
abstract class Mailable
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
     * The text used.
     *
     * @var string
     */
    public $_text;

    /**
     * The mail type.
     *
     * @var string
     */
    private $_type;

    /**
     * The subject of the mail.
     *
     * @var string
     */
    private $_subject;

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

    /**
     * The attachments
     *
     * @var array
     */
    private $_attachments = [];


    //--------------------------------------------------------
    // Constructor
    //--------------------------------------------------------

    public function __construct()
    {
        //
    }

    //--------------------------------------------------------
    // Getters and setters
    //--------------------------------------------------------

    /**
     * Main getter of the class.
     *
     * @return string
     */
    public function get($var)
    {
        return $this->$var;
    }

    /**
     * Getter of $_type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     * Getter of $_subject.
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->_subject;
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
            if (!in_array($key, ['_view', '_text', '_type', '_subject', '_sender_name', '_sender_mail'])) {
                $this->_view->with($key, $value);
            }
        }

        $this->_type = 'text/html';

        return $this;
    }

    /**
     * Set the text to send.
     *
     * @param string $text
     *
     * @return $this
     */
    public function text($text)
    {
        $this->_text = $text;

        $this->_type = 'text/plain';

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

    /**
     * The subject of the mail.
     *
     * @param string $subject
     *
     * @return $this
     */
    public function subject($subject)
    {
        $this->_subject = $subject;

        return $this;
    }

    /**
     * add attachments to the mail.
     *
     * @param string $path
     *
     * @return $this
     */
    public function attachments($files)
    {
        foreach ($files as $file) {
            if (is_string($file)) {
                $this->_attachments[] = ['file' => $file];
            } elseif (is_array($file)) {
                foreach ($file as $key => $value) {
                    $this->_attachments[] = ['name' => $key, 'file' => $value];
                }
            }
        }
        
        return $this;
    }
}
