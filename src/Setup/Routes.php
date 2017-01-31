<?php 

use Vinala\Kernel\Setup\Response;

// get("hello/db_check",function() { return Response::setDb_step(); });



get("hello/setup",function() { 
	if(Response::setGlob_step()) 
		return Response::setPanel_step();
	else echo 'false';
});



// get("hello/set_secur",function() { return Response::setSecur_step(); });
// get("hello/set_panel",function() { return Response::setPanel_step(); });