<?php 

namespace Lighty\Kernel\Setup\Documentations;

class Translator
{
	protected static function langDoc($index)
	{
		$doc = array(
			'default_lang' => "\n\t|  Default framework language ", 
			'lang_cookie' => "\n\t|  Langue cookie to store framework default language",
			);
		//
		return $doc[$index]."\n\t*/";
	}

	protected static function langTitles($index)
	{
		$titles = array(
			'default_lang' => "Default lang", 
			'lang_cookie' => "Lang Cookie name",
			);
		//
		$sep = "\n\t|----------------------------------------------------------";
		return "\n\n\t/*".$sep."\n\t| ".$titles[$index].$sep;
	}

	protected static function langRow($index,$param)
	{
		$title = self::LangTitles($index);
		$doc = self::LangDoc($index);
		//
		return $title.$doc."\n\n\t$param\n";
	}

	public static function set($langue)
	{
		$default_lang = self::langRow("default_lang","'default'=>'$langue',");
		$lang_cookie = self::langRow("lang_cookie","'cookie'=>'lighty_lang',");
		//
		return "<?php \n\nreturn array(\n\t".$default_lang.$lang_cookie."\n);";
	}
}