<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Trang chủ
$route['default_controller']  = 'trade';
$route['404_override']        = '';
$route['translate_uri_dashes'] = FALSE;

// Auth
$route['auth']                 = 'auth/index';
$route['auth/login']           = 'auth/index';
$route['auth/login_post']      = 'auth/login_post';
$route['auth/register']        = 'auth/register';
$route['auth/register_post']   = 'auth/register_post';
$route['auth/logout']          = 'auth/logout';

// Trade
$route['trade']                      = 'trade/index';
$route['trade/create']               = 'trade/create';
$route['trade/detail/(:num)']        = 'trade/detail/$1';
$route['trade/update_status/(:num)'] = 'trade/update_status/$1';
$route['trade/delete/(:num)']        = 'trade/delete/$1';

// Comment
$route['comment/add/(:num)']         = 'comment/add/$1';
$route['comment/delete/(:num)/(:num)'] = 'comment/delete/$1/$2';

// Rating
$route['rating/add/(:num)']          = 'rating/add/$1';

// Message (Chat)
$route['message/inbox']              = 'message/inbox';
$route['message/conversation/(:num)'] = 'message/conversation/$1';
$route['message/send']               = 'message/send';

// Profile
$route['profile']                    = 'profile/index';
$route['profile/toggle_phone']       = 'profile/toggle_phone';
$route['profile/update_phone']       = 'profile/update_phone';

// Admin
$route['admin']                        = 'admin/index';
$route['admin/users']                  = 'admin/users';
$route['admin/delete_post/(:num)']     = 'admin/delete_post/$1';
$route['admin/approve_post/(:num)']    = 'admin/approve_post/$1';
$route['admin/reject_post/(:num)']     = 'admin/reject_post/$1';
$route['admin/toggle_role/(:num)']     = 'admin/toggle_role/$1';
