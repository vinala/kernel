<?php

namespace Vinala\Kernel\Setup\Documentations;

class Maintenance
{
    protected static function MaintDoc($index)
    {
        $doc = [
            'enabled' => 'To enabled maintenance',
            'out'     => "List of routes that will not stopped by maintenance\n\t| middlware",
            'view'    => "The view that will be displayed if maintenance\n\t| is activated\n\t| ATTENTION : the view should not be in atomium and not\n\t| be using any of framework cubes or components",
            ];
        //
        return "\t| ".$doc[$index]."\n\t|\n\t**/";
    }

    protected static function MaintTitles($index)
    {
        $titles = [
            'enabled' => 'App Maintenance',
            'out'     => 'Routes out of maintenance',
            'view'    => 'Maintenance view',
            ];
        //
        $sep = "\n\t|----------------------------------------------------------";

        return "\n\n\t/*".$sep."\n\t| ".$titles[$index].$sep."\n";
    }

    protected static function MaintRow($index, $param)
    {
        $title = self::MaintTitles($index);
        $doc = self::MaintDoc($index);
        //
        return $title.$doc."\n\t$param\n";
    }

    public static function set($maintenance, $out = [], $view = 'errors.maintenance')
    {
        $enabled = self::MaintRow('enabled', "'enabled' => $maintenance, ");
        $out = self::MaintRow('out', "'out' => [\n\t\t//\n\t],");
        $view = self::MaintRow('view', "'view' => '$view',");
        //
        return "<?php\n\n\nreturn [".$enabled.$out.$view."\n];";
    }
}
