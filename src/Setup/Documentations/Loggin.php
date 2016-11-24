<?php 

namespace Vinala\Kernel\Setup\Documentations;

class Loggin
{
	protected static function logginDoc($index)
	{
		$doc = array(
			'debug' => "\n\t|  Here to make the framework shows errors and\n\t|  exceptions, false to show friendly messages\n\t|  and true to debug", 
			'error_debug_message' => "\n\t|  If loggin.debug was false the framework will\n\t|  show this message",
			'error_log' => "\n\t|  The path of log file where Lighty store errors\n\t|  by default the framework use this path \n\t|  'app/storage/logs/lighty.log'",
			'background' => "\n\t|  The color background of simple page error"
			);
		//
		return $doc[$index]."\n\t*/";
	}

	protected static function logginTitles($index)
	{
		$titles = array(
			'debug' => "Allow Debug", 
			'error_debug_message' => "Error Debug Message",
			'error_log' => "Error log",
			'background' => "Error simple page background color",
			);
		//
		$sep = "\n\t|----------------------------------------------------------";
		return "\n\n\t/*".$sep."\n\t| ".$titles[$index].$sep;
	}

	protected static function logginRow($index,$param)
	{
		$title = self::LogginTitles($index);
		$doc = self::LogginDoc($index);
		//
		return $title.$doc."\n\n\t$param\n";
	}

	public static function set($loggin , $log ='app/storage/logs/lighty.log')
	{
		$loggin = $loggin ? "true" : "false" ;
		$debug = self::logginRow("debug","'debug'=>$loggin,");
		$error_debug_message = self::logginRow("error_debug_message","'msg' => \"Ohlala! il semble que quelque chose s'ait mal passé\",");
		$error_log = self::logginRow("error_log","'log' => '$log',");
		$background = self::logginRow("background","'bg' => '#a4003a',");
		//
		return "<?php \n\nreturn array(\n\t".$debug.$error_debug_message.$error_log.$background."\n);";
	}
}