<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
$route['default_controller'] = 'frontend';
$route['404_override']       = '';
$route['translate_uri_dashes'] = FALSE;

$route['diesel-master'] = 'frontend/admin_alogin';
$route['login-admin'] = 'frontend/admin_loginfn';
//$route['admin/user-details/(:any)'] = 'admin/user_details/$1';
$route['admin/user-details/(:any)'] = 'admin/user_details/$1';

$route['mannual_share'] = 'admin/mannual_share';

$route['recordsheet_upload'] = 'admin/upload_record_sheet';


$route['change-password'] = 'process/change_password';
$route['kyc-submit'] = 'process/submit_kyc';
$route['edit-profile'] = 'process/edit_user_profile';

$route['edit-profilemonika'] = 'process/edit_user_profile_monika';              #monika
$route['edit-image'] = 'process/edit_profile_pic';

$route['bank-info'] = 'process/get_bank';
$route['update-bank'] = 'process/bank_update';

$route['check-otp'] = 'frontend/otp_check';
$route['forget-password'] = 'frontend/password_forget';

$route['forget-pass'] = 'frontend/pass_forget';
$route['reset-password/(:any)'] = 'frontend/password_reset/$1';
$route['reset-pass'] = 'frontend/pass_reset';

$route['reg-searchusername'] = 'frontend/reg_searchusername';
