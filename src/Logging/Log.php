<?php

namespace Vinala\Kernel\Logging;

use Vinala\Kernel\Collections\Collection;
use Vinala\Kernel\Config\Config;
use Vinala\Kernel\Objects\DateTime;
use Vinala\Kernel\Objects\DateTime as Time;
use Vinala\Kernel\String\Strings;

class Log
{
    public static function ini()
    {
        $path = '../'.Config::get('loggin.log');
        ini_set('log_errors', 1);
        ini_set('error_log', $path);
    }

    public static function log($message, $time = true)
    {
        error_log($message);
    }

    protected static function getTime($timestamp)
    {
        return date('[Y-m-d H:i:s', $timestamp).' '.Time::getTimezone().']';
    }

    protected static function endLog($path)
    {
        $txt = '';
        for ($i = 0; $i < 50; $i++) {
            $txt .= '-';
        }
        self::log($txt."\n", false);
    }

    protected static function tabulation()
    {
        $length = 21 + 2 + (Strings::length(DateTime::getTimezone()));
        $txt = '';
        for ($i = 0; $i < $length; $i++) {
            $txt .= ' ';
        }

        return $txt.' ';
    }

    protected static function TraceTabulation()
    {
        $tab = self::getTime(DateTime::now()).' Trace : ';
        $txt = '';
        for ($i = 0; $i < Strings::length($tab); $i++) {
            $txt .= ' ';
        }

        return $txt.' ';
    }

    protected static function Trace($exception)
    {
        $i = 1;
        $txt = '';
        $traces = $exception->getTrace();
        //
        foreach ($traces as $trace) {
            if (array_key_exists('file', $trace)) {
                $txt .= "\n".self::TraceTabulation()."#$i / $trace[file]:$trace[line]";
                $i++;
            }
        }

        return $txt;
    }

    public static function exception($Exception)
    {
        $txt = '';
        $txt .= 'Exception : '.$Exception->getMessage()."\n";
        $txt .= self::tabulation().'Location : '.$Exception->getFile().' in line '.$Exception->getLine()."\n";
        $txt .= self::tabulation().'Class : '.get_class($Exception)."\n";
        $txt .= self::tabulation().'Trace : '.self::Trace($Exception);

        self::log($txt);
    }

    public static function error($message, $data = [])
    {
        self::log('Error : '.$message);
        if (!empty($data)) {
            self::log(self::tabulation().Collection::toString($data), false);
        }
    }

    public static function warning($message, $data = [])
    {
        self::log('Warning : '.$message);
        if (!empty($data)) {
            self::log(self::tabulation().Collection::toString($data), false);
        }
    }

    public static function info($message, $data = [])
    {
        self::log('Info : '.$message);
        if (!empty($data)) {
            self::log(self::tabulation().Collection::toString($data), false);
        }
    }

    public static function debug($message, $data = [])
    {
        self::log('Debug : '.$message);
        if (!empty($data)) {
            self::log(self::tabulation().Collection::toString($data), false);
        }
    }

    public static function notice($message, $data = [])
    {
        self::log('Notice : '.$message);
        if (!empty($data)) {
            self::log(self::tabulation().Collection::toString($data), false);
        }
    }

    public static function critical($message, $data = [])
    {
        self::log('Critical : '.$message);
        if (!empty($data)) {
            self::log(self::tabulation().Collection::toString($data), false);
        }
    }

    public static function alert($message, $data = [])
    {
        self::log('Alert : '.$message);
        if (!empty($data)) {
            self::log(self::tabulation().Collection::toString($data), false);
        }
    }
}
