<?phpsession_start();if(isset($_GET['dev']) && $_GET['dev'] == 'yes'){	error_reporting(E_ALL);	ini_set('display_errors', 1);	ini_set('error_reporting', E_ALL);}date_default_timezone_set('UTC');// echo '<pre>';// print_r($_SESSION);// includesinclude('dashboard/inc/db.php');include('dashboard/inc/global_vars.php');include('dashboard/inc/functions.php');print_r($_SESSION);// get for affiliate_username$affiliate 				= get_affiliate($_SESSION['affiliate_username']);// print_r($_SESSION);// print_r($affiliate);// echo '</pre>';// https check and redirect// check to make sure terms have been acceptedif(post('order_promoter_pack') == 'on'){	if(empty(post('accept_promoter_pack_terms'))){		status_message('danger',"You failed to accept the Promoter Terms & Conditions.");    	go($_SERVER['HTTP_REFERER']);	}}?>