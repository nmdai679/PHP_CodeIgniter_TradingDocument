<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 | -------------------------------------------------------------------
 |  URI ROUTING
 | -------------------------------------------------------------------
 */

// API endpoints
$route['api/movies']          = 'Api/movies';
$route['api/movies/(:any)']   = 'Api/movie_detail/$1';
$route['api/characters']      = 'Api/characters';
$route['api/phases']          = 'Api/phases';

// Trang chủ SPA
$route['default_controller']  = 'trade';
$route['404_override']        = '';
$route['translate_uri_dashes'] = FALSE;
