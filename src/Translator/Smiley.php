<?php 

namespace Vinala\Kernel\Translator;

use Vinala\Kernel\Config\Config;
use Vinala\Kernel\Objects\Table;
use Vinala\Kernel\Access\Path;


/**
* Class For Smileys
*/
class Smiley
{

	/*
	*	To initial the smiley class, this function
	*	should be writen in the head of your html
	*	page
	**/
	public static function Ini()
	{
		echo "<link href='".config('smiley.css')."' rel='stylesheet' type='text/css'>";
	}

	/*
	*	To Translate written smileys text to smileys images
	**/
	public static function translate($text)
	{
		foreach (Config::get('smiley.db_smileys') as $key => $value) {
			$div="<div class='fst_sml $value'></div>";
			$text = str_replace( $key , $div , $text );
		}

		foreach (Config::get('smiley.smileys') as $key => $value) {
			$div="<div class='fst_sml $value'></div>";
			$text = str_replace( $key , $div , $text );
		}
		//
		return $text;
	}

	/*
	*	To Translate written smileys text to smiles code
	*	for storing in database
	**/
	public static function store($text)
	{
		foreach (Config::get('smiley.codes') as $key => $value) 
			$text = str_replace( $key , $value , $text );
		
		return $text;
	}
}