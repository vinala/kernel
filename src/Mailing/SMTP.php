<?php

namespace Vinala\Kernel\Mailing ;

//use SomeClass;

/**
* The SMTP Class
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
    * The host server name
    *
    * @var string
    */
    protected $host ;

    /**
    * The smtp posrt
    *
    * @var int
    */
    protected $port ;

    /**
    * The smtp encryption
    *
    * @var string
    */
    protected $encryption ;

    /**
    * The host username
    *
    * @var string
    */
    private $user ;

    /**
    * The host password
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

    function __construct()
    {
        //
    }

    //--------------------------------------------------------
    // Functions
    //--------------------------------------------------------

    //
}
