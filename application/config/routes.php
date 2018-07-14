<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* FTP Controller */
$route['add-ftp']                           = 'ftp/addFtp';
$route['add-ftp-account']                   = 'ftp/addFtpAccount';
$route['edit-ftp']                          = 'ftp/editFtp';
$route['edit-ftp/(:num)']                   = 'ftp/editFtpAccount/$1';
$route['update-ftp-account/(:num)']         = 'ftp/updateFtpAccount/$1';
$route['delete-ftp']                        = 'ftp/deleteFtp';
$route['delete-ftp-account(:num)']          = 'ftp/deleteFtpAccount/$1';
$route['settings']                          = 'ftp/settingsFtp';
$route['update-settings']                   = 'ftp/updateSettingsFtp';

/* FTP Server Controller */
$route['ftp-file-edit/(:any)/(:any)']       = 'ftpserver/ftpFileEdit';
$route['ftp-file-delete/(:any)/(:any)']     = 'ftpserver/ftpFileDelete';
$route['ftp-folder-delete/(:any)/(:any)']   = 'ftpserver/ftpFolderDelete';

$route['ftp-file-move/(:any)/(:any)']       = 'ftpserver/ftpFileMove';
$route['ftp-file-copy/(:any)/(:any)']       = 'ftpserver/ftpFileCopy';
$route['ftp-file-move-transfer/(:any)']     = 'ftpserver/ftpFileMoveTransfer';
$route['ftp-file-copy-transfer/(:any)']     = 'ftpserver/ftpFileCopyTransfer';
$route['ftp-cancle-move/(:any)']            = 'ftpserver/ftpCancleMove';
$route['ftp-cancle-copy/(:any)']            = 'ftpserver/ftpCancleCopy';

// $route['ftp-file-download']                 = 'ftpserver/ftpFileDownload';

/* User Controller */
$route['add-user']                          = 'user/addUserFtp';
$route['add-user-account']                  = 'user/addUserFtpAccount';
$route['edit-user/(:num)']                  = 'user/editUserFtpAccount/$1';
$route['update-user-account/(:num)']        = 'user/updateUserFtpAccount/$1';
$route['delete-user-account/(:num)']        = 'user/deleteUserFtpAccount/$1';
$route['manage-user']                       = 'user/manageUserFtp';
$route['user-profile']                      = 'user/userProfile';
$route['update-user-account-info']          = 'user/userProfileUpdate';

/* Login Controller */
$route['login-check']                       = 'login/loginCheck';

/* Default Settings */
$route['default_controller']                = 'ftp';
$route['404_override']                      = '';
$route['translate_uri_dashes']              = FALSE;
