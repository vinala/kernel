<?php

namespace Vinala\Kernel\Setup\Documentations;

class App
{
    protected static function appDoc($index)
    {
        $doc = [
            'project_name'  => "\n\t|  Your project name",
            'owner_name'    => "\n\t|  Your name",
            'project_url'   => "\n\t|  Your website root link, you should put your \n\t| root link , by default we using Application::root \n\t| function to get the root link even if you \n\t| working on localhost",
            'html_title'    => "\n\t|  Default HTML title",
            'timezone'      => "\n\t|  Here you should set your timezone after that \n\t| whenever you wanna get time, Vinala will give\n\t| you exact time for the timezone.\n\t| To get all of timezones supported in php \n\t| visite here : http://php.net/manual/en/timezones.php",
            'character_set' => "\n\t|  The framework will set true if you passed\n\t|  the setup",
            'setup'         => "\n\t|  Default encodage when you using HTML::charset",
            ];
        //
        return $doc[$index]."\n\t|\n\t**/";
    }

    protected static function appTitles($index)
    {
        $titles = [
            'project_name'  => 'Project name',
            'owner_name'    => 'Owner name',
            'project_url'   => 'Project url',
            'html_title'    => 'HTML Default title',
            'timezone'      => 'Timezone',
            'setup'         => 'Setup',
            'character_set' => 'Default Character Set',
            ];
        //
        $sep = "\n\t|----------------------------------------------------------";

        return "\n\n\t/*".$sep."\n\t| ".$titles[$index].$sep;
    }

    protected static function appRow($index, $param)
    {
        $title = self::appTitles($index);
        $doc = self::appDoc($index);
        //
        return $title.$doc."\n\t$param\n\n";
    }

    public static function set($name, $project, $setup)
    {
        $setup = $setup ? 'true' : 'false';

        $project_name = self::appRow('project_name', "'project' => '$project' ,");
        $owner_name = self::appRow('owner_name', "'owner' => '".$name."' ,");
        $project_url = self::appRow('project_url', "'url' => root() ,");
        $html_title = self::appRow('html_title', "'title' => 'Vinala PHP Framework' , ");
        $timezone = self::appRow('timezone', "'timezone' => 'UTC' ,");
        $character_set = self::appRow('character_set', "'charset' => 'utf-8' , ");
        $setup_set = self::appRow('setup', "'setup' => $setup , ");
        //
        return "<?php\n\n\n\nreturn [\n\n\t".$project_name.$owner_name.$project_url.$html_title.$timezone.$character_set.$setup_set."\n];";
    }
}
