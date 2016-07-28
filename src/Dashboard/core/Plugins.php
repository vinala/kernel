<?php 

namespace Lighty\Kernel\Dashboard;

use Lighty\Kernel\Foundation\Application;


class Plugins
{
	public static function get_store()
	{
		return [
			[
				"name" => "Google QR",
				"desc" => "Generate QR Codes",
				"image" => "2",
				"color" => "#000",
				"link" => "",
			],
			[
				"name" => "Youtube player",
				"desc" => "Add Youtube player to your website",
				"image" => "9",
				"color" => "red",
				"link" => "",
			],
			[
				"name" => "Chat",
				"desc" => "chatting with friends",
				"image" => "5",
				"color" => "yellow",
				"link" => "",
			],
			[
				"name" => "Search",
				"desc" => "get google search engine in your web site",
				"image" => "6",
				"color" => "deepskyblue",
				"link" => "",
			],
			[
				"name" => "Adsence",
				"desc" => "set publicity",
				"image" => "7",
				"color" => "green",
				"link" => "",
			],
			[
				"name" => "game",
				"desc" => "add game",
				"image" => "8",
				"color" => "#673ab7",
				"link" => "",
			]
		];
	}
}