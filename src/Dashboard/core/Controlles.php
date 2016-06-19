<?php 

namespace Lighty\Kernel\Dashboard;


class Controlles
{
	public static function sideBarHighLight($page, $possible)
	{
		foreach ($possible as $value)
			if($page == $value) { echo "active open"; break; }
	}

	public static function sideBarSelected($page, $possible)
	{
		foreach ($possible as $value)
			if($page == $value) { echo '<span class="selected"></span>'; break; }
	}
}