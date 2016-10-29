<?php 

namespace Vinala\Kernel\Setup\Documentations;

class Maintenance
{
	protected static function MaintDoc($index)
	{
		$doc = array(
			'activate' => "", 
			'Message' => "",
			'background' => "",
			'out' => ""
			);
		//
		return $doc[$index]."\n\t*/";
	}

	protected static function MaintTitles($index)
	{
		$titles = array(
			'activate' => "App Maintenance", 
			'Message' => "Maintenance Message",
			'background' => "Maintenance background",
			'out' => "Out Maintenance Routes",
			);
		//
		$sep = "\n\t|----------------------------------------------------------";
		return "\n\n\t/*".$sep."\n\t| ".$titles[$index].$sep;
	}

	protected static function MaintRow($index,$param)
	{
		$title = self::MaintTitles($index);
		$doc = self::MaintDoc($index);
		//
		return $title.$doc."\n\n\t$param\n";
	}

	public static function set($maintenance)
	{
		$activate = self::MaintRow("activate","'activate' => $maintenance, ");
		$Message = self::MaintRow("Message","'msg'=>\"Le site web est en cours de maintenance...\",");
		$background = self::MaintRow("background","'bg' => '#d6003e',");
		$out = self::MaintRow("out","'outRoutes' => array(\n\t\tConfig::get('panel.route'),\n\t),");
		//
		return "<?php \nuse Vinala\Kernel\Config\Config;\n\nreturn array(\n\t".$activate.$Message.$background.$out."\n);";
	}
}