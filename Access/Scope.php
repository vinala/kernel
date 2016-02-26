<?php 

/**
 * Scope function to make easy for users to 
 * access to some framework functions
 */

use Fiesta\Kernel\MVC\View\View;
use Fiesta\Kernel\Router\Route;
use Fiesta\Kernel\Objects\DateTime;

/**
 * Views
 */
function view($value,$data=null) { return View::make($value,$data); }

/**
 * Route
 */
function get($uri,$callback,$subdomains=null) { return Route::get($uri,$callback,$subdomains); }
function call($uri,$controller,$data=null) { return Route::call($uri,$controller,$data); }

/**
 * Config
 */
function config($param) { return Config::get($param); }

/**
 * Time
 */
function now() { return DateTime::now(); }

/**
 * Http
 */
function abort($arg = null) { return Http::abort($arg); }