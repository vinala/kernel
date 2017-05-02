<?php

namespace Vinala\Kernel\Mailing ;

//use SomeClass;

/**
* The SMTP protocol class
*
* @version 1.0
* @author Youssef Had
* @package Vinala\Kernel\Mailing
* @since v3.3.0
*/
class SMTP
{

    //--------------------------------------------------------
    // Properties
    //--------------------------------------------------------

    /**
    * The SMTP host
    *
    * @var string
    */
    private $host ;

    
    /**
    * The SMTP port
    *
    * @var int
    */
    private $port ;


    /**
    * The SMTP encryption
    *
    * @var string
    */
    private $encryption ;


    /**
    * The SMTP username
    *
    * @var string
    */
    private $username;


    /**
    * The SMTP password
    *
    * @var string
    */
    private $password ;


    /**
    * The sender email adress
    *
    * @var string
    */
    private $sender_email ;


    /**
    * The sender name
    *
    * @var string
    */
    private $sender_name ;

    //--------------------------------------------------------
    // Constructor
    //--------------------------------------------------------


    function __construct($host, $port, $secure, $username, $password, $from)
    {
        $this->host = $host ;
        $this->port = $port ;
        $this->secure = $secure ;
        $this->username = $username ;
        $this->password = $password ;
        $this->from = $from ;
    }

    //--------------------------------------------------------
    // Functions
    //--------------------------------------------------------

    //
}
