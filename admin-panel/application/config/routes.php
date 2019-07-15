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
$route['default_controller'] = 'admin';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// admin authentication
$route['login']         = 'admin/index';
$route['login/check'] 	= 'admin/form_validation';
$route['dashboard'] 	= 'admin/enter';
$route['logout'] 		= 'admin/logout';
// admin forgot password
$route['forgot/email-check']  	= 'admin/forget_password';
$route['set-password/(:any)'] 	= 'admin/add_pass/$1';
$route['update-password'] 	  	= 'admin/update_pass';
// change password
$route['change-password'] 	  	 = 'admin/change_password';
$route['update/change-password'] = 'admin/password_validation'; 
// account settings
$route['profile'] 				 = 'admin/accntsttngs';
$route['update-profile'] 		 = 'admin/updateacnt';
// referals
$route['manage-referals'] 		 = 'Referals/manage_referals';
$route['delete-referals/(:any)'] = 'Referals/delete_referals/$1';
$route['view-referals/(:any)'] 	 = 'Referals/view_referals/$1';
$route['approve-referals'] 	 	 = 'Referals/approve_referals';
$route['reject-referals'] 	 	 = 'Referals/reject_referals';

// referals
$route['noti-view/(:any)/(:any)/(:any)']  = 'Referals/noti_view/$1/$2/$3';
$route['all-notification'] 		 = 'Referals/all_notification';

// product
$route['add-product'] 		 = 'Product/index';
$route['insert-product'] 	 = 'Product/insert_product';
$route['manage-product'] 	 = 'Product/get_product';
$route['delete-product/(:any)'] = 'Product/delete_product/$1';
$route['edit-product/(:any)'] 	 = 'Product/edit_product/$1';

