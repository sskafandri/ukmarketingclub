<?php
date_default_timezone_set('UTC');

session_start();

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
$username 		= get('username');

debug($_GET);
die();

// convert username to userid
// $query      	= $conn->query("SELECT `id` FROM `users` WHERE `affiliate_username` = '".$username."' ");
// $user      	 	= $query->fetch(PDO::FETCH_ASSOC);

// convert userid to affiliateid
// $query      	= $conn->query("SELECT `id` FROM `whmcs`.`tblaffiliates` WHERE `clientid` = '".$user['id']."' ");
// $affiliate 		= $query->fetch(PDO::FETCH_ASSOC);

if(isset($affiliate['id'])){
	$_SESSION['ref'] = $username;
}

$_SESSION['ref'] = $username;

header("Location: https://ukmarketingclub.com");
?>