<?php

namespace Vinala\Kernel\Resources;

use Vinala\Kernel\Access\Path;

/**
*
*/
class Assets
{
	public static function css($file,$default=true)
	{
		if (strpos($file,'http://') !== false) {
		    echo '<link rel="stylesheet" type="text/css" href="'.$file.'.css">'."\n";
		}
		else
		{
			if($default)
			{
				$file=str_replace('.', '/', $file);
				// echo '<link rel="stylesheet" type="text/css" href="'.Path::$app.'/resources/css/'.$file.'.css">'."\n";
				echo '<link rel="stylesheet" type="text/css" href="assets/css/'.$file.'.css">'."\n";
			}
			else
			{
				echo '<link rel="stylesheet" type="text/css" href="'.$file.'">'."\n";
			}
		}
	}

	public static function js($file,$default=true)
	{
		if (strpos($file,'http://') !== false) {
		    echo '<script type="text/javascript"  src="'.$file.'"></script>'."\n";
		}
		else
		{

			if($default)
			{
				$file=str_replace('.', '/', $file);
				echo '<script type="text/javascript"  src="assets/js/'.$file.'.js"></script>'."\n";
			}
			else
			{
				echo '<script type="text/javascript"  src="'.$file.'"></script>'."\n";
			}
		}

	}
}
