<?php 

namespace Fiesta\Core\Media;

/**
* Belongs To relation
*/
class QR
{

	public static function make($text, $class = '', $width = 100 , $height = 100)
	{
		$link = "http://chart.apis.google.com/chart?chs=".$width."x$height&cht=qr&chld=|0&chl=$text";
		$img = "<img src='$link' class='$class' height='$height' width='$width' />";
		echo $img;
	}
}