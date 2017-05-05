<?php

namespace Vinala\Kernel\Setup\Documentations;

class Security
{
    protected static function securityDoc($index)
    {
        $doc = [
            'keys' => "\n\t|  These keys are for the security of your app, the first should be string\n\t|  contains 32 chars and the second should be string contains at least 10\n\t|  chars, in first configuration the framework change automatically these\n\t|  keys",
            ];
        //
        return $doc[$index]."\n\t*/";
    }

    protected static function securityTitles($index)
    {
        $titles = [
            'keys' => 'Encryption Keys',
            ];
        //
        $sep = "\n\t|----------------------------------------------------------";

        return "\n\n\t/*".$sep."\n\t| ".$titles[$index].$sep;
    }

    protected static function securityRow($index, $param)
    {
        $title = self::securityTitles($index);
        $doc = self::securityDoc($index);
        //
        return $title.$doc."\n\n\t$param\n";
    }

    public static function set($sec_1, $sec_2)
    {
        $keys = self::securityRow('keys', "'key1' => '$sec_1',\n\t'key2' => '$sec_2',");
        //
        return "<?php \n\nreturn array(\n\t".$keys."\n);";
    }
}
