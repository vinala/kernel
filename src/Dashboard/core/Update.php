<?php 

namespace Lighty\Kernel\Dashboard;

use Lighty\Kernel\Foundation\Application;


class Update
{
	public static function check()
	{
		$current = Application::numKernelVersion();
		$last = Application::numLastKernelVersion();
		//
		return $current != $last;
	}
}
