<?php

$config['base_fir'] 							= '/home2/jamie/public_html/projects/ubloclub_dashboard';

$config['version']								= '1';

// site vars
$site['url']									= 'http://127.0.0.1:10810/portal/';
$site['title']									= 'SlipStream CMS';
$site['copyright']								= 'Written by DeltaColo.';

// logo name vars
$site['name_long']								= 'SlipStream<b>CMS</b>';
$site['name_short']								= '<b>SS</b>';

// get settings table contents
$query = $conn->query("SELECT `config_name`,`config_value` FROM `global_settings` ");
$global_settings_temp = $query->fetchAll(PDO::FETCH_ASSOC);

foreach($global_settings_temp as $bits){
	$global_settings[$bits['config_name']] 		= $bits['config_value'];
}

$site['url']									= $global_settings['site_url'];
$site['title']									= $global_settings['site_title'];
$site['name_long']								= $global_settings['site_name'];
$site['name_short']								= $global_settings['site_name_short'];

// whmcs vars
$whmcs['url'] 									= "https://ublo.club/billing/includes/api.php"; # URL to WHMCS API file
$whmcs["username"] 								= "api_user"; # Admin username goes here
$whmcs["password"] 								= md5("admin1372"); # Admin password goes here  
$whmcs['accesskey']								= 'admin1372';

// product details
$product_ids = array(
					1, // network customer pack - 10 x 10ml pack
					2, // business builder pack - 1 year
					);