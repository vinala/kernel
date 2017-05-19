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
    

    //--------------------------------------------------------
    // Constructor
    //--------------------------------------------------------

    function __construct()
    {
        $this->smtp = SMTP::getDefault();
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
        $mailer = new self();

        $closure($mailer);
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
    private static function view($type, $name, $data)
    {
        if ($type == 'text') {
            return [
                'body' => $view,
                'type' => 'text/plain'
            ];
        } elseif ($type == 'html') {
            return [
                'body' => View::make($view, $data)->get(),
                'type' => 'text/html'
            ];
        }
    }
}
