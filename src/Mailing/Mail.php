<?php

namespace Vinala\Kernel\Mailing;

use Swift_Attachment as Attachment;
use Swift_Mailer as Mailer;
use Swift_Message as Message;
use Swift_SmtpTransport as Transport;
use Vinala\Kernel\Mailing\Exceptions\MailViewNotFoundException;
use Vinala\Kernel\MVC\View\View;

/**
 * The Mailing surface.
 *
 * @version 2.0
 *
 * @author Youssef Had
 *
 * @since v3.3.0
 */
class Mail
{
    //--------------------------------------------------------
    // Properties
    //--------------------------------------------------------

    /**
     * The SMTP params.
     *
     * @var Vinala\Kernel\Mailing\SMTP
     */
    private $smtp;

    /**
     * The mail Closure.
     *
     * @var closure
     */
    private $closure;

    /**
     * The mail view.
     *
     * @var string
     */
    public $view;

    /**
     * The mailable object.
     *
     * @var Vinala\Kernel\Mailing\Mailable
     */
    private $mailable;

    /**
     * The SMTP transport.
     *
     * @var Swift\SmtpTransport
     */
    private $transport;

    /**
     * The Swift mailer.
     *
     * @var Swift\Mailer
     */
    private $mailer;

    /**
     * The Swift message.
     *
     * @var Swift\Message
     */
    private $message;

    /**
     * The receivers of the mail.
     *
     * @var array
     */
    private $receivers;

    //--------------------------------------------------------
    // Constructor
    //--------------------------------------------------------

    public function __construct()
    {
        $this->smtp = SMTP::getDefault();

        $this->transport();
        $this->mailer();
    }

    //--------------------------------------------------------
    // Functions
    //--------------------------------------------------------

    /**
     * The send function.
     *
     * @param string  $view
     * @param array   $data
     * @param closure $closure
     *
     * @return null
     */
    public static function prepare($view, $data, $closure)
    {
        $mailer = new self();

        $closure($mailer);

        $mailer->view($view, $data);
        $mailer->transport();
    }

    /**
     * Get the view to send.
     *
     * @param string $type
     * @param string $name
     * @param array  $data
     *
     * @return string
     */
    private function checkView()
    {
        exception_if((is_null($this->mailable->get('_view')) && is_null($this->mailable->get('_text'))), MailViewNotFoundException::class);
    }

    /**
     * Set the SMTP transport.
     *
     * @return Swift_SmtpTransport
     */
    private function transport()
    {
        $this->transport = Transport::newInstance($this->smtp->get('host'), $this->smtp->get('port'), $this->smtp->get('encryption'))
            ->setUsername($this->smtp->get('username'))
            ->setPassword($this->smtp->get('password'));

        return $this->transport;
    }

    /**
     * Set the mail subject.
     *
     * @return string
     */
    private function subject()
    {
        return is_null($this->mailable->get('_subject')) ? config('mail.subject') : $this->mailable->get('_subject');
    }

    /**
     * Set the Swift mailer.
     *
     * @return Swift\Mailer
     */
    private function mailer()
    {
        $this->mailer = Mailer::newInstance($this->transport);

        return $this->mailer;
    }

    /**
     * Set the Swift message.
     *
     * @return Swift\Message
     */
    private function message()
    {
        $subject = $this->subject();

        $this->message = Message::newInstance();

        $this->message->setBody($this->mailable->get('_view'), $this->mailable->get('_type'));
        $this->message->setFrom([$this->smtp->get('sender_email')], $this->smtp->get('sender_name'));

        return $this->message;
    }

    /**
     * To add reciever adresses.
     *
     * @return $this
     */
    public static function to()
    {
        $args = func_get_args();

        $receivers = [];

        foreach ($args as $arg) {
            if (is_string($arg)) {
                $receivers[] = $arg;
            } elseif (is_array($arg)) {
                foreach ($arg as $value) {
                    $receivers[] = $value;
                }
            }
        }

        $mail = new self();
        $mail->setDestination($receivers);

        return $mail;
    }

    /**
     * Set email destination.
     *
     * @param array $mails
     *
     * @return $this
     */
    protected function setDestination(array $mails)
    {
        $this->recievers = $mails;

        return $this;
    }

    /**
     * Set the mailable class to send.
     *
     * @param Vinala\Kernel\Mailing\Mailable
     *
     * @return bool
     */
    public function send(Mailable $mailable)
    {
        $this->mailable = $mailable;

        $this->mailable->build();

        $this->checkView();

        $this->message();

        $this->setAttachments();
        $this->setCC();
        $this->setCCI();

        return $this->mailer->send($this->message);
    }

    /**
     * Set the files on mail surface.
     *
     * @return void
     */
    private function setAttachments()
    {
        $attachments = $this->mailable->get('_attachments');

        if (!is_null($attachments)) {
            foreach ($attachments as $attachment) {
                if (in_array('name')) {
                    $this->message->attach(Attachment::fromPath($attachment['file'])->setFilename($attachment['name']));
                } else {
                    $this->message->attach(Attachment::fromPath($attachment['file']));
                }
            }
        }
    }

    /**
     * Set the CC mails.
     *
     * @return void
     */
    private function setCC()
    {
        $cc = $this->mailable->get('_cc');

        if (!is_null($cc)) {
            foreach ($cc as $mail) {
                $this->message->setCC($mail);
            }
        }
    }

    /**
     * Set the CCI mails.
     *
     * @return void
     */
    private function setCCI()
    {
        $cci = $this->mailable->get('_cci');

        if (!is_null($cci)) {
            foreach ($cci as $mail) {
                $this->message->setBcc($mail);
            }
        }
    }
}
