<?php

namespace Vinala\Kernel\Mailing ;

use Vinala\Kernel\MVC\View\View;

/**
* The Mailing surface
*
* @version 2.0
* @author Youssef Had
* @package Vinala\Kernel\Mailing
* @since v3.3.0
*/
class Mail
{

    //--------------------------------------------------------
    // Properties
    //--------------------------------------------------------

    /**
     * The SMTP params
     *
     * @var Vinala\Kernel\Mailing\SMTP
     */
    private $smtp ;

    /**
     * The mail Closure
     *
     * @var closure
     */
    private $closure ;

    /**
     * The mail view
     *
     * @var string
     */
    public $view ;

    /**
     * The mail type
     *
     * @var string
     */
    public $type;


    

    //--------------------------------------------------------
    // Constructor
    //--------------------------------------------------------

    function __construct($view, $data)
    {
        $this->smtp = SMTP::getDefault();

        $this->view($view, $data);
    }

    //--------------------------------------------------------
    // Functions
    //--------------------------------------------------------


    /**
     * The send function
     *
     * @param string $view
     * @param array $data
     * @param closure $closure
     *
     * @return null
     */
    public static function send($view, $data, $closure)
    {
        $mailer = new self($view, $data);

        $closure($mailer);
        
        $view = static::view($mailer->type, $view, $data);
        $body = $view['body'];
        $type = $view['type'];
        return ;
    }

    /**
     * Get the view to send
     *
     * @param string $type
     * @param string $name
     * @param array $data
     *
     * @return string
     */
    private function view($type, $value, $data)
    {
        if ($type == 'text') {
            $this->view = $value;
            $this->type = 'text/plain';
        } elseif ($type == 'html') {
            $this->view = View::make($value, $data)->get();
            $this->type = 'text/html';
        }
    }
}
