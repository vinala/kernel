<?php

/*
* Get user helpers files from support folder
* 
*/
$files = glob('../support/helpers/*');


/*
* Include user helpers
*
*/
foreach ($files as $file) {
	$segments = explode('../support/helpers/', $file);

	$name = explode('.', $segments[1]);

	$name = $name[0];
	
	if ( ! function_exists($name))
	{
		include($file);
	}
}
