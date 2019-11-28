<?php

include('/var/www/html/portal/inc/db.php');
include('/var/www/html/portal/inc/global_vars.php');
include('/var/www/html/portal/inc/functions.php');
include('/var/www/html/portal/inc/php_colors.php');

$query = $conn->query("SELECT * FROM `bouquets` ");
$bouquets = $query->fetchAll(PDO::FETCH_ASSOC);

foreach($bouquets as $bouquet){
	$bouquet['streams'] = explode(",", $bouquet['streams']);

	foreach($bouquet['streams'] as $bouquet_content){
		$insert = $conn->exec("INSERT INTO `bouquets_content` 
	        (`bouquet_id`,`content_id`)
	        VALUE
	        ('".$bouquet['id']."',
	        '".$bouquet_content."'
	    )");
	}
}