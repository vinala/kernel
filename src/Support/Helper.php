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
	include($file);
}
