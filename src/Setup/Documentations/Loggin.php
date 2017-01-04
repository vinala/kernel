<?php 

namespace Vinala\Kernel\Setup\Documentations;

class Loggin
{
	protected static function logginDoc($index)
	{
		$doc = array(
			'debug' => "\n\t|  Here to make the framework shows errors and\n\t|  exceptions, false to show friendly messages\n\t|  and true to debug\n\t|", 

			'error_log' => "\n\t|  The path of log file where Lighty store errors\n\t|",
			);
		//
		return $doc[$index]."\n\t**/";
	}

	protected static function logginTitles($index)
	{
		$titles = array(
			'debug' => "Allow Debug", 
			'error_log' => "Error log",
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

	public static function set($loggin , $log ='storage/log/vinala.log')
	{
		$loggin = $loggin ? "true" : "false" ;
		$debug = self::logginRow("debug","'debug' => $loggin ,");
		$error_log = self::logginRow("error_log","'log' => '$log' ,");
		//
		return "<?php\n\nreturn [\n\n\t".$debug.$error_log."\n\n];";
	}
}