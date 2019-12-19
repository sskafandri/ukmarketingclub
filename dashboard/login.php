<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('error_reporting', E_ALL);


// include('inc/class_session.inc.php');
// $session = new Session();
session_start();

// includes
include('inc/db.php');
include('inc/global_vars.php');
include('inc/functions.php');

// debug($_POST);

$ip 							= $_SERVER['REMOTE_ADDR'];
$user_agent     				= $_SERVER['HTTP_USER_AGENT'];

$now 							= time();

$email 							= post('email');
$password 						= post('password');

// debug($_POST);

// $email 							= addslashes($email);
// $password 						= addslashes($password);

// lets try whmcs
$postfields["username"] 		= $whmcs['username']; 
$postfields["password"] 		= $whmcs['password'];
$postfields["action"] 			= "validatelogin";
$postfields["email"] 			= $email;
$postfields["password2"] 		= $password;
$postfields["responsetype"] 	= 'json';
$postfields['accesskey']		= $whmcs['accesskey'];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $whmcs['url']);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
$data = curl_exec($ch);
if (curl_error($ch)) {
    die('Unable to connect: ' . curl_errno($ch) . ' - ' . curl_error($ch));
}
curl_close($ch);

$results = json_decode($data, true);

// debug($whmcs);

// debug($results);

if($results["result"]=="success"){
    // login confirmed
	
	$_SESSION['account']['id'] 		= $results['userid'];
	$_SESSION['account']['email'] 	= $email;
	$user_id 						= $results['userid'];

	// lets get client details
	$postfields["username"] 			= $whmcs['username'];
	$postfields["password"] 			= $whmcs['password'];
	$postfields["responsetype"] 		= "json";
	$postfields["action"] 				= "getclientsdetails";
	$postfields["clientid"] 			= $user_id;
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $whmcs['url']);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
	$client_data = curl_exec($ch);
	if (curl_error($ch)) {
	    die('Unable to connect: ' . curl_errno($ch) . ' - ' . curl_error($ch));
	}
	curl_close($ch);

	$client_data = json_decode($client_data, true);

	// debug($client_data);

	// lets check their product status for late / non payment
	$postfields["username"] 			= $whmcs['username'];
	$postfields["password"] 			= $whmcs['password'];
	$postfields["responsetype"] 		= "json";
	$postfields["action"] 				= "getclientsproducts";
	$postfields["clientid"] 			= $user_id;
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $whmcs['url']);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
	$data = curl_exec($ch);
	if (curl_error($ch)) {
	    die('Unable to connect: ' . curl_errno($ch) . ' - ' . curl_error($ch));
	}
	curl_close($ch);

	$data = json_decode($data, true);

	// debug($data);

	foreach($data['products']['product'] as $product)
	{
		if (in_array($product['pid'], $product_ids)) {
		    // product match for this platform

		    if($product['status'] != 'Active'){
				// forward to billing area
				$whmcsurl 			= "https://ublo.club/billing/dologin.php";
				$autoauthkey 		= "admin1372";
				$email 				= $email;
				
				$timestamp 			= time(); 
				$goto 				= "clientarea.php";
				
				$hash 				= sha1($email.$timestamp.$autoauthkey);
				
				$url 				= $whmcsurl."?email=$email&timestamp=$timestamp&hash=$hash&goto=".urlencode($goto);
				go($url);
			}else{
				$_SESSION['logged_in']					= true;
				$_SESSION['account']['id']				= $client_data['userid'];
				$_SESSION['account']['type']			= $user['type'];	

				status_message('success', 'Login successful');
				go($site['url'].'dashboard.php?c=home');
			}
		}
	}
	
	// login rejected due to now having the right product
	status_message('danger', 'You do not have a valid license.');
	go($site['url'].'/?c=login');
}else{
	// login rejected
	status_message('danger', 'Incorrect Login details');
	go($site['url'].'/?c=login');
}


?>