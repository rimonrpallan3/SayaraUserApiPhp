<?php
ob_start();
session_start();
define('ADMIN_SESSION', 'admin_userlog');
define('DB_SERVER', 'localhost');
//define('DB_USERNAME', 'beta123_pricing');
//define('DB_PASSWORD', '86130111');
//define('DB_DATABASE', 'beta123_pricing');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'sayara');
//define('BASE_URL','http://betaholder.com/pricing');
define('BASE_URL','http://10.1.1.18/sayara');
define('DOCUMENT_ROOT',$_SERVER['DOCUMENT_ROOT'].'sayara');
date_default_timezone_set('Asia/Kolkata');
// REDIRECT IF NOT LOGGED IN AS ADMIN
if(!isset($_SESSION[ADMIN_SESSION]) && $page!='login'){
    header('Location: login.php');
}