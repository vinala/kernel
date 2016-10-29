<?php 

use Vinala\Kernel\Setup\Response;

get("hello/db_check",function() { return Response::setDb_step(); });
get("hello/set_glob",function() { return Response::setGlob_step(); });
get("hello/set_secur",function() { return Response::setSecur_step(); });
get("hello/set_panel",function() { return Response::setPanel_step(); });