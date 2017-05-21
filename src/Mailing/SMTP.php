<?php

namespace Vinala\Kernel\Mailing;

use Vinala\Kernel\Mailing\Exceptions\SmtpParameterNotFoundException;

/**
 * The SMTP protocol class.
 *
 * @version 1.0
 *
 * @author Youssef Had
 *
 * @since v3.3.0
 */
class SMTP
{
    //--------------------------------------------------------
    // Properties
    //--------------------------------------------------------

    /**
     * The SMTP host.
     *
     * @var string
     */
    private $host;

    /**
     * The SMTP port.
     *
     * @var int
     */
    private $port;

    /**
     * The SMTP encryption.
     *
     * @var string
     */
    private $encryption;

    /**
     * The SMTP username.
     *
     * @var string
     */
    private $username;

    /**
     * The SMTP password.
     *
     * @var string
     */
    private $password;

    /**
     * The sender email adress.
     *
     * @var string
     */
    private $sender_email;

    /**
     * The sender name.
     *
     * @var string
     */
    private $sender_name;

    //--------------------------------------------------------
    // Constructor
    //--------------------------------------------------------

    public function __construct($host, $port, $encryption, $username, $password, $sender_email, $sender_name)
    {
        $this->host = $host;
        $this->port = $port;
        $this->encryption = $encryption;
        $this->username = $username;
        $this->password = $password;
        $this->sender_email = $sender_email;
        $this->sender_name = $sender_name;
    }

    //--------------------------------------------------------
    // Getters and Setters
    //--------------------------------------------------------
    
    /**
     * Getter of the class.
     *
     * @return string
     */
    public function get($var)
    {
        return $this->$var;
    }

    //--------------------------------------------------------
    // Functions
    //--------------------------------------------------------

    /**
     * Init the SMTP class by getting gefualt values from Config surface.
     *
     * @return Vinala\Kernel\Mailing
     */
    public static function getDefault()
    {
        $smtp = new self(
            config('mail.host'),
            config('mail.port'),
            config('mail.encryption'),
            config('mail.username'),
            config('mail.password'),
            config('mail.password'),
            config('mail.from')['adresse'],
            config('mail.from')['name']
            );

        // static::check($smtp);

        return $smtp;
    }

    /**
     * Check if SMTP configurated.
     *
     * @return bool
     */
    private static function check($smtp)
    {
        exception_if(empty($smtp->host), SmtpParameterNotFoundException::class, 'host');
        exception_if(empty($smtp->port), SmtpParameterNotFoundException::class, 'port');
        exception_if(empty($smtp->encryption), SmtpParameterNotFoundException::class, 'encryption');
        exception_if(empty($smtp->username), SmtpParameterNotFoundException::class, 'username');
        exception_if(empty($smtp->password), SmtpParameterNotFoundException::class, 'password');
        exception_if(empty($smtp->sender_email), SmtpParameterNotFoundException::class, 'sender email');
        exception_if(empty($smtp->sender_name), SmtpParameterNotFoundException::class, 'sender name');

        return true;
    }
}
