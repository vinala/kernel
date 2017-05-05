<?php

namespace Vinala\Kernel\Setup\Documentations;

class Translator
{
    protected static function langDoc($index)
    {
        $doc = [
            'default_lang' => "\n\t|  Default framework language ",
            'lang_cookie'  => "\n\t|  Langue cookie to store framework default language",
            'lifetime'     => "\n\t|  The lifetime of the language cookie",
            ];
        //
        return $doc[$index]."\n\t*/";
    }

    protected static function langTitles($index)
    {
        $titles = [
            'default_lang' => 'Default lang',
            'lang_cookie'  => 'Lang Cookie name',
            'lifetime'     => 'Lang cookie life time',
            ];
        //
        $sep = "\n\t|----------------------------------------------------------";

        return "\n\n\t/*".$sep."\n\t| ".$titles[$index].$sep;
    }

    protected static function langRow($index, $param)
    {
        $title = self::LangTitles($index);
        $doc = self::LangDoc($index);
        //
        return $title.$doc."\n\n\t$param\n";
    }

    public static function set($langue)
    {
        $default_lang = self::langRow('default_lang', "'default' => '$langue',");
        $lang_cookie = self::langRow('lang_cookie', "'cookie' => 'vinala_lang',");
        $lifetime = self::langRow('lifetime', "'lifetime' => (60*24*30),");
        //
        return "<?php\n\nreturn [\n\t".$default_lang.$lang_cookie.$lifetime."\n];";
    }
}
