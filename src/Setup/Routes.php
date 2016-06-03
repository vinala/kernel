<?php 

use Lighty\Kernel\Setup\Response;

get("hello/db_check",function() { return Response::setDb_step(); });
get("hello/set_glob",function() { return Response::setGlob_step(); });