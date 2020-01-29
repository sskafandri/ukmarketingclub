<?php
session_start();

date_default_timezone_set('UTC');

if(isset($_GET['dev']) && $_GET['dev'] == 'yes'){
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
}

// includes
include('/home/ukmarketingclub/public_html/dashboard/inc/db.php');
include('/home/ukmarketingclub/public_html/dashboard/inc/global_vars.php');
include('/home/ukmarketingclub/public_html/dashboard/inc/functions.php');

// get affiliate username
$_SESSION['affiliate_username'] 		= get('username');
$cookie_name 							= "affiliate_username";
$cookie_value 							= get('username');
setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day

header("Location: https://ukmarketingclub.com/");
?>