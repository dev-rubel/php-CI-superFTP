<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* FTP Controller */
$route['add-ftp'] = 'ftp/addFtp';
$route['add-ftp-account'] = 'ftp/addFtpAccount';
$route['edit-ftp'] = 'ftp/editFtp';
$route['edit-ftp/(:num)'] = 'ftp/editFtpAccount/$1';
$route['update-ftp-account/(:num)'] = 'ftp/updateFtpAccount/$1';
$route['delete-ftp'] = 'ftp/deleteFtp';
$route['delete-ftp-account(:num)'] = 'ftp/deleteFtpAccount/$1';
$route['settings'] = 'ftp/settingsFtp';
$route['update-settings'] = 'ftp/updateSettingsFtp';

$route['ftp-file-edit/(:any)/(:any)'] = 'ftpserver/ftpFileEdit';

/* User Controller */
$route['add-user'] = 'user/addUserFtp';
$route['add-user-account'] = 'user/addUserFtpAccount';
$route['edit-user/(:num)'] = 'user/editUserFtpAccount/$1';
$route['update-user-account/(:num)'] = 'user/updateUserFtpAccount/$1';
$route['delete-user-account/(:num)'] = 'user/deleteUserFtpAccount/$1';
$route['manage-user'] = 'user/manageUserFtp';
$route['user-profile'] = 'user/userProfile';
$route['update-user-account-info'] = 'user/userProfileUpdate';

/* Login Controller */
$route['login-check'] = 'login/loginCheck';

/* Default Settings */
$route['default_controller'] = 'ftp';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
