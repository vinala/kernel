<?php 

use Vinala\Kernel\Setup\Response;

get("hello/setup",function() { 
	Response::setGlob_step();
});