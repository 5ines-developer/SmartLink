<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'account';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


//  employee authendication
$route['register']              = 'authendication/register';
$route['account-verification']  = 'authendication/otp_verification';
$route['account-verify']        = 'authendication/otp_verify';
$route['login']                 = 'authendication/login';
$route['logout']                = 'authendication/logout';
$route['forgot-password']       = 'authendication/forgot_password';
$route['forgot-verify']         = 'authendication/forgot_verify';
$route['forgot-password-set']   = 'authendication/forgot_password_set';
// agent dashboard
$route['dashboard']    			= 'authendication/enter';
// account
$route['account-setting']       = 'account';
$route['change-password']       = 'account/change_psw';
//refer a friend
$route['refer-a-friend']       	= 'account/refer_friend';
$route['add-refer-a-friend']    = 'account/insert_refer';
//notification
$route['notifications']    		= 'account/notification_dash';
$route['noti-view/(:any)/(:any)/(:any)']  = 'account/noti_view/$1/$2/$3';
// list of referals
$route['referal-list']    		= 'account/referal_list';
$route['referal-list/(:any)']   = 'account/referal_list/$1';

//reward points
$route['reward-points']    		= 'account/reward_point';
$route['claim-points']    		= 'account/claim_reward';
$route['claim-list']    		= 'account/claims';
$route['claim-list/(:any)']   = 'account/claims/$1';
$route['verify-credentials']    		= 'account/code_auth';


