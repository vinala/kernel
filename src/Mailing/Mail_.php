<?php

namespace Vinala\Kernel\Mailing;

use Vinala\Kernel\Config\Config;
use Vinala\Kernel\MVC\View\View;

/**
 * Mail class.
 */
class Mail
{
    private $transport = null;
    private $too = null;
    private $attachmnt = null;
    private $subject = null;
    private $froms = null;
    private $replay = null;
    private $cc = null;
    private $cci = null;
    //private $type="html";
    private static $error = '';
    //
    // SMTP Config
    private $host = '';
    private $port = '';
    private $secure = '';
    private $type = 'html';
    private $username = '';
    private $password = '';
    private $from = [];

    public static function configured($self)
    {
        if (!empty($self->host) || !empty($self->port) || !empty($self->secure) || !empty($self->username) || !empty($self->password) || !empty($self->from)) {
            return true;
        } else {
            return false;
        }
    }

    public static function check($selfmail)
    {
        if (empty($selfmail->host)) {
            throw new \InvalidArgumentException('Missing smtp host');
        }
        if (empty($selfmail->port)) {
            throw new \InvalidArgumentException('Missing smtp port');
        }
        if (empty($selfmail->secure)) {
            throw new \InvalidArgumentException('Missing smtp secure');
        }
        if (empty($selfmail->username)) {
            throw new \InvalidArgumentException('Missing smtp username');
        }
        if (empty($selfmail->password)) {
            throw new \InvalidArgumentException('Missing smtp password');
        }
        if (empty($selfmail->from['adresse'])) {
            throw new \InvalidArgumentException('Missing smtp adresse from');
        }
        if (empty($selfmail->from['name'])) {
            throw new \InvalidArgumentException('Missing smtp name from');
        }
    }

    public static function send($view, $array, $callback)
    {
        //
        $selfmail = new self();
        $callback($selfmail);
        //
        //get The View
        if ($selfmail->type == 'text') {
            $body = $view;
            $type = 'text/plain';
        } elseif ($selfmail->type == 'html') {
            $body = View::make($view, $array)->get();
            $type = 'text/html';
        }
        //
        if (!self::configured($selfmail)) {
            $selfmail->host = Config::get('mail.host');
            $selfmail->port = Config::get('mail.port');
            $selfmail->secure = Config::get('mail.encryption');
            $selfmail->type = 'html';
            $selfmail->username = Config::get('mail.username');
            $selfmail->password = Config::get('mail.password');
            $selfmail->from['adresse'] = Config::get('mail.from')['adresse'];
            $selfmail->from['name'] = Config::get('mail.from')['name'];
        }
        //
        self::check($selfmail);
        //
        $selfmail->transport = \Swift_SmtpTransport::newInstance($selfmail->host, $selfmail->port, $selfmail->secure)
          ->setUsername($selfmail->username)
          ->setPassword($selfmail->password);

        $mailer = \Swift_Mailer::newInstance($selfmail->transport);
        $subject = is_null($selfmail->subject) ? Config::get('mail.subject') : $selfmail->subject;

        //
        //The Message
        $message = \Swift_Message::newInstance($subject);
        $message->setBody($body, $type);
        $message->setFrom([$selfmail->from['adresse'] => $selfmail->from['name']]);

        // Check to
        //
        if (!is_null($selfmail->too) && !empty($selfmail->too)) {
            $message->setTo($selfmail->too);
        } else {
            throw new \InvalidArgumentException('Missing mail to', 1);
        }
        //
        // Attaches
        if (!is_null($selfmail->attachmnt) && count($selfmail->attachmnt) > 0) {
            foreach ($selfmail->attachmnt as $key => $value) {
                $name = '';
                $filee = '';
            //
            foreach ($value as $key2 => $value2) {
                if ($key2 == 0) {
                    $filee = $value2;
                } elseif ($key2 == 1) {
                    $name = $value2;
                }
            }
                if (empty($name)) {
                    $message->attach(\Swift_Attachment::fromPath($filee));
                } else {
                    $message->attach(\Swift_Attachment::fromPath($filee)->setFilename($name));
                }
            }
        }

        //
        // CC
        if (!is_null($selfmail->cc) && count($selfmail->cc) > 0) {
            $r = [];
            //
            foreach ($selfmail->cc as $key => $value) {
                $name = '';
                $mail = '';
                //
                foreach ($value as $key2 => $value2) {
                    if ($key2 == 'mail') {
                        $mail = $value2;
                    } elseif ($key2 == 'name') {
                        $name = $value2;
                    }
                }
                //
                if (empty($name)) {
                    $r[] = $mail;
                } else {
                    $r[$mail] = $name;
                }
            }
            //
            $message->setCC($r);
        }

        //
        // CCI
        if (!is_null($selfmail->cci) && count($selfmail->cci) > 0) {
            $r = [];
            //
            foreach ($selfmail->cci as $key => $value) {
                $name = '';
                $mail = '';
                //
                foreach ($value as $key2 => $value2) {
                    if ($key2 == 'mail') {
                        $mail = $value2;
                    } elseif ($key2 == 'name') {
                        $name = $value2;
                    }
                }
                //
                if (empty($name)) {
                    $r[] = $mail;
                } else {
                    $r[$mail] = $name;
                }
            }
            //
            $message->setBcc($r);
        }

        //
        // Send
        $result = $mailer->send($message);

        return $result;
    }

    public function to()
    {
        //
        $r = func_get_args();
        $r2 = [];
        //
        if (count($r) == 1) {
            if (is_array($r)) {
                foreach ($r as $key => $value) {
                    if (is_array($value)) {
                        $i = 0;
                        $ry = [];
                        foreach ($value as $key => $value) {
                            $r2[] = $value;
                        }
                    } elseif (is_string($value)) {
                        // $r2[]= array(
                        // 'mail' => $value
                        // );
                        $r2[] = $value;
                    }
                }
            } elseif (is_string($r)) {
                $r2[] = [
                'mail' => $r,
                ];
            }
        } elseif (count($r) == 2) {
            $r2[] = [
                'mail' => $r[0],
                'name' => $r[1],
                ];
        }
        //
        $this->too = $r2;
        // die(var_dump($this));
        return $this;
    }

    public function attach()
    {
        //
        $r = func_get_args();
        $r2 = [];
        //
        if (count($r) == 1) {
            if (is_array($r)) {
                foreach ($r as $key => $value) {
                    if (is_array($value)) {
                        $i = 0;
                        $ry = [];
                        foreach ($value as $key => $value) {
                            $r2[] = $value;
                        }
                    } elseif (is_string($value)) {
                        $r2[] = [
                        'file' => $value,
                        ];
                    }
                }
            } elseif (is_string($r)) {
                $r2[] = [
                'file' => $r,
                ];
            }
        } elseif (count($r) == 2) {
            $r2[] = [
                'file' => $r[0],
                'name' => $r[1],
                ];
        }
        //
        $this->attachmnt = $r2;

        return $this;
    }

    public function subject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    public function from($from)
    {
        $this->froms = $from;

        return $this;
    }

    public function cc()
    {
        $r = func_get_args();
        $mail = '';
        $name = '';
        $r2 = [];
        foreach ($r as $key => $value) {
            foreach ($value as $key2 => $value2) {
                if (is_numeric($key2)) {
                    $mail = $value2;
                    $name = '';
                } else {
                    $mail = $key2;
                    $name = $value2;
                }
                $r2[] = ['name'=>$name, 'mail'=>$mail];
            }
        }

        $this->cc = $r2;

        return $this;
    }

    public function cci($from)
    {
        $r = func_get_args();
        $mail = '';
        $name = '';
        $r2 = [];
        foreach ($r as $key => $value) {
            foreach ($value as $key2 => $value2) {
                if (is_numeric($key2)) {
                    $mail = $value2;
                    $name = '';
                } else {
                    $mail = $key2;
                    $name = $value2;
                }
                $r2[] = ['name'=>$name, 'mail'=>$mail];
            }
        }

        $this->cci = $r2;

        return $this;
    }

    public function type($type)
    {
        $this->type = $type;

        return $this;
    }
}