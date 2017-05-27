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

    /**
     * The carbon copy mails
     *
     * @var array
     */
    private $_cc = [];


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
     * @return $this
     */
    public function attachments()
    {
        $files = func_get_args();

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

    /**
     * Add attachment to the mail.
     *
     * @param string $file
     * @param string $name
     *
     * @return $this
     */
    public function attachment($file, $name = null)
    {
        if (!is_null($name)) {
            $this->_attachments[] = ['name' => $key, 'file' => $value];
        } else {
            $this->_attachments[] = ['file' => $value];
        }

        return $this;
    }

    /**
     * Add Carbon Copy to mailable.
     *
     * @return $this
     */
    public function cc()
    {
        $mails = func_get_args();

        foreach ($mails as $mail) {
            if (is_string($mail)) {
                $this->_cc[] = $mail;
            } elseif (is_array($mail)) {
                foreach ($mail as $submail) {
                    $this->_cc[] = $submail;
                }
            }
        }

        return $this;
    }
}
