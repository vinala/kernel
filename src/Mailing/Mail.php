<?php

namespace Vinala\Kernel\Mailing ;

use Vinala\Kernel\MVC\View\View;
use Swift_SmtpTransport as Transport;
use Swift_Mailer as Mailer;
use Swift_Message as Message;

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

    /**
     * The SMTP transport
     *
     * @var Swift\SmtpTransport
     */
    private $transport;

    /**
     * The Swift mailer
     *
     * @var Swift\Mailer
     */
    private $mailer;

    /**
     * The Swift message
     *
     * @var Swift\Message
     */
    private $message;

    /**
     * The mail subject
     *
     * @var string
     */
    public $subject;
    

    //--------------------------------------------------------
    // Constructor
    //--------------------------------------------------------

    function __construct($view, $data)
    {
        $this->smtp = SMTP::getDefault();

        $this->view($view, $data);
        $this->transport();
        $this->mailer();
        $this->subject();
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
        
        $mailer->view($view, $data);
        $mailer->transport();
        

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
    private function view($value, $data)
    {
        if ($this->type == 'text') {
            $this->view = $value;
            $this->type = 'text/plain';
        } elseif ($this->type == 'html') {
            $this->view = View::make($value, $data)->get();
            $this->type = 'text/html';
        }
    }

    /**
     * Set the SMTP transport
     *
     * @return Swift_SmtpTransport
     */
    private function transport()
    {
        $this->transport = Transport::newInstance($this->smtp->host, $this->smtp->port, $this->smtp->encryption)
            ->setUsername($this->smtp->username)
            ->setPassword($this->smtp->password);

        return $this->transport;
    }

    /**
     * Set the mail subject
     *
     * @return string
     */
    private function subject()
    {
        $this->subject = is_null($this->subject) ? config('mail.subject') : $this->subject;

        return $this->subject;
    }

    /**
     * Set the Swift mailer
     *
     * @return Swift\Mailer
     */
    private function mailer()
    {
        $this->mailer = Mailer::newInstance($this->transport);

        return $this->mailer;
    }

    /**
     * Set the Swift message
     *
     * @return Swift\Message
     */
    private function message()
    {
        $this->message = Message::newInstance($this->subject);

        $this->message->setBody($this->body, $this->type);
        $this->message->setFrom($this->smtp->sender_email, $this->smtp->sender_name);

        return $this->message;
    }

    /**
     * To add reciever adresses
     *
     * @return Vinala\Kernel\Mailing\Mail
     */
    public function to()
    {
        $args = func_get_args();

        if (count($args) == 1) {
            # code...
        } elseif (count($args) == 2) {
            # code...
        }
        

        return $this;
    }
}
