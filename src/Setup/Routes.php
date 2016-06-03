<?php 

use Lighty\Kernel\Setup\Response;

get("hello/db_check",function()
{
	return Response::setDb_step();
});