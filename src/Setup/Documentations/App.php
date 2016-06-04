<?php 

namespace Lighty\Kernel\Setup\Documentations;

class App
{
	protected static function appDoc($index)
	{
		$doc = array(
			'project_name' => "\n\t|  Your project name", 
			'owner_name' => "\n\t|  Your name", 
			'project_url' => "\n\t|  Your website root link, you should put your \n\t| root link , by default we using Application::root \n\t| function to get the root link even if you \n\t| working on localhost", 
			'html_title' => "\n\t|  Default HTML title",
			'timezone' => "\n\t|  Here you should set your timezone after that \n\t| whenever you wanna get time, Lighty will give\n\t| you exact time for the timezone.\n\t| To get all of timezones supported in php \n\t| visite here : http://php.net/manual/en/timezones.php",
			'routing_inexists' => "\n\t|  When HttpNotFoundException trown if unrouted \n\t| parameter was true it will be show to \n\t| exception else the framework will redirect\n\t| user to Error::r_404 route,",
			'character_set' => "\n\t|  Default encodage when you using HTML::charset"
			);
		//
		return $doc[$index]."\n\t*/";
	}

	protected static function appTitles($index)
	{
		$titles = array(
			'project_name' => "Project name", 
			'owner_name' => "Owner name", 
			'project_url' => "Project url", 
			'html_title' => "HTML Default title",
			'timezone' => "Timezone",
			'routing_inexists' => "Routing inexists event",
			'character_set' => "Default Character Set"
			);
		//
		$sep = "\n\t|----------------------------------------------------------";
		return "\n\n\t/*".$sep."\n\t| ".$titles[$index].$sep;
	}

	protected static function appRow($index,$param)
	{
		$title = self::appTitles($index);
		$doc = self::appDoc($index);
		//
		return $title.$doc."\n\n\t$param\n";
	}

	public static function set($name)
	{
		$project_name = self::appRow("project_name","'project'=>'lighty',");
		$owner_name = self::appRow("owner_name","'owner'=>'".$name."',");
		$project_url = self::appRow("project_url","'url'=>Application::root(),");
		$html_title = self::appRow("html_title","'title'=> 'Lighty PHP Framework',");
		$timezone = self::appRow("timezone","'timezone'=> 'UTC',");
		$routing_inexists = self::appRow("routing_inexists","'unrouted'=> true,");
		$character_set = self::appRow("character_set","'charset'=> 'utf-8', ");
		//
		return "<?php \nuse Lighty\Kernel\Foundation\Application;\n\nreturn array(\n\t".$project_name.$owner_name.$project_url.$html_title.$timezone.$routing_inexists.$character_set."\n);";
	}
}