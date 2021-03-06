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
$route['default_controller'] = 'pages';
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
$route['refer-a-friend/edit/(:any)']    = 'account/edit_refer/$1';
$route['refer-a-friend/delete/(:any)']    = 'account/delete_refer/$1';
$route['referrals/view/(:any)'] 		= 'account/view_refer/$1';//view refer afriend





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
$route['claim-list/(:any)']   	= 'account/claims/$1';
$route['verify-credentials']    = 'account/code_auth';

//terms and conditions
$route['terms-and-conditions']  = 'pages/terms';
$route['privacy-policy']  		= 'pages/privacy_policy';
$route['copyright']  			= 'pages/copyright';
$route['marketing']  			= 'pages/marketing';

// landing page
$route['index']  				= 'pages/index';
$route['mobile-device']  		= 'pages/mobile_device';
$route['fixed-service']  		= 'pages/fixed_service';
$route['contact-us'] 			= 'pages/contact';
$route['contact/insert'] 		= 'pages/send_contact';




/*================================================================*/
// Rest Api****
// rest Api Authentication
$route['api/v1/register']	    		= 'api/auth/register';//agent  registration
$route['api/v1/activate-account']	    = 'api/auth/otp_verify';//activate account
$route['api/v1/resend-code']			= 'api/auth/resend_code';//resend otp to mobile
$route['api/v1/login']	    			= 'api/auth/login';//login
$route['api/v1/forgot-password']	    = 'api/auth/forgot_password';//forgot password
$route['api/v1/forgot-password-verify']	= 'api/auth/forgot_verify';//verify otp and mobile no
$route['api/v1/set-password']			= 'api/auth/set_password';//update new password

// account settings
$route['api/v1/profile']				= 'api/account/profile';//fetch agent profile
$route['api/v1/profile-image']			= 'api/account/profile_image';//update profile image
$route['api/v1/update-profile']			= 'api/account/update_profile';//update agent profile
$route['api/v1/change-password']		= 'api/account/changePass';//update agent profile
//dashboard
$route['api/v1/dashboard']				= 'api/dashboard/dashboard';//fetch agent profile
//notification
$route['api/v1/notification']			= 'api/notification/notiGet';//fetch agent profile
$route['api/v1/notification/(:any)']	= 'api/notification/single_noti/$1';//fetch single notificationedit_refer
$route['api/v1/noti-count']				= 'api/notification/notiCount';//fetch agent profile

//refer a friend
$route['api/v1/refer-friend']		    	= 'api/Referrals/insertRefer';//insert refer afriend
$route['api/v1/referrals']		    		= 'api/Referrals/referrals';//all referrals
$route['api/v1/refer-friend/edit/(:any)'] 	= 'api/Referrals/edit_refer/$1';//insert refer afriend
$route['api/v1/referrals/update']			= 'api/Referrals/updateRefer';//update refer afriend
$route['api/v1/referrals/delete/(:any)'] 	= 'api/Referrals/delete_refer/$1';//delete refer afriend
$route['api/v1/category']    				= 'api/Referrals/category';

$route['api/v1/share']    				= 'api/Referrals/shareFriend';

//reward points
$route['api/v1/reward-points']		    = 'api/Rewardpoint/reward';//insert refer afriend -> get points
$route['api/v1/claim-points']		    = 'api/Rewardpoint/insertclaim';//insert refer afriend
$route['api/v1/claims']		    		= 'api/Rewardpoint/claims';//claim reward points list
$route['api/v1/view-smartcode']		    = 'api/Rewardpoint/authcheck';//insert refer afriend

 