<?php 

/**
 * Scope function to make easy for users to 
 * access to somefrmaework functions
 */

use Fiesta\Core\MVC\View\View;
use Fiesta\Core\Router\Route;
use Fiesta\Core\Objects\DateTime;

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
function abort($arg) { return Http::abort($arg); }
function error($error = 404,$data = null) { return App::error($error , $data); }