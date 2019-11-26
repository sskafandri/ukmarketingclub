<?php

include('/var/www/html/portal/inc/db.php');
include('/var/www/html/portal/inc/global_vars.php');
include('/var/www/html/portal/inc/functions.php');
include('/var/www/html/portal/inc/php_colors.php');

date_default_timezone_set('UTC');

$colors = new Colors();

$task = $argv[1];

function killlock()
{
    global $lockfile;
	exec("rm -rf $lockfile");
}

if($task == 'cron'){
	
	console_output("Slipstream CMS CRON");

	$check = shell_exec("ps aux | grep '/var/www/html/portal/console/console.php node_checks' | grep -v 'grep' | grep -v '/bin/sh' | wc -l");
	if($check == 0) {
		console_output("Loading Module: node checks");
		$run = shell_exec('php -q /var/www/html/portal/console/console.php node_checks > /tmp/cron.node_checks.log');
		echo $run."\n";
	}else{
		console_output("Skipping Module: node checks");
	}

	$check = shell_exec("ps aux | grep '/var/www/html/portal/console/console.php customer_checks' | grep -v 'grep' | grep -v '/bin/sh' | wc -l");
	if($check == 0) {
		console_output("Loading Module: customer checks");
		$run = shell_exec('php -q /var/www/html/portal/console/console.php customer_checks > /tmp/cron.customer_checks.log');
		echo $run."\n";
	}else{
		console_output("Skipping Module: customer checks");
	}

	$check = shell_exec("ps aux | grep '/var/www/html/portal/console/console.php channel_watch' | grep -v 'grep' | grep -v '/bin/sh' | wc -l");
	if($check == 0) {
		console_output("Loading Module: 24/7 channel manager");
		$run = shell_exec('php -q /var/www/html/portal/console/console.php channel_watch > /tmp/cron.channel_watch.log');
		echo $run."\n";
	}else{
		console_output("Skipping Module: 24/7 channel manager");
	}

	$check = shell_exec("ps aux | grep '/var/www/html/portal/console/console.php tv_series_watch' | grep -v 'grep' | grep -v '/bin/sh' | wc -l");
	if($check == 0) {
		console_output("Loading Module: tv series manager");
		$run = shell_exec('php -q /var/www/html/portal/console/console.php tv_series_watch > /tmp/cron.tv_series_watch.log');
		echo $run."\n";
	}else{
		console_output("Skipping Module: tv series manager");
	}

	$check = shell_exec("ps aux | grep '/var/www/html/portal/console/console.php stream_ondemand_check' | grep -v 'grep' | grep -v '/bin/sh' | wc -l");
	if($check == 0) {
		console_output("Loading Module: live stream ondemand check");
		$run = shell_exec('php -q /var/www/html/portal/console/console.php stream_ondemand_check > /tmp/cron.stream_ondemand_check.log');
		echo $run."\n";
	}else{
		console_output("Skipping Module: live stream ondemand check");
	}

	$check = shell_exec("ps aux | grep '/var/www/html/portal/console/console.php xc_imports' | grep -v 'grep' | grep -v '/bin/sh' | wc -l");
	if($check == 0) {
		console_output("Loading Module: xtream-codes importer");
		$run = shell_exec('php -q /var/www/html/portal/console/console.php xc_imports > /tmp/cron.xc_imports.log');
		echo $run."\n";
	}else{
		console_output("Skipping Module: xtream-codes importer");
	}

	$check = shell_exec("ps aux | grep '/var/www/html/portal/console/console.php stalker_sync' | grep -v 'grep' | grep -v '/bin/sh' | wc -l");
	if($check == 0) {
		console_output("Loading Module: stalker / ministra sync");
		$run = shell_exec('php -q /var/www/html/portal/console/console.php stalker_sync > /tmp/cron.stalker_sync.log');
		echo $run."\n";
	}else{
		console_output("Skipping Module: stalker / ministra sync");
	}

	$check = shell_exec("ps aux | grep '/var/www/html/portal/console/console.php totals' | grep -v 'grep' | grep -v '/bin/sh' | wc -l");
	if($check == 0) {
		console_output("Loading Module: total calc for cms stats");
		$run = shell_exec('php -q /var/www/html/portal/console/console.php totals > /tmp/cron.totals.log');
		echo $run."\n";
	}else{
		console_output("Skipping Module: total calc for cms stats");
	}

	echo "\n\n";

	killlock();

	console_output("Finished.");
}

if($task == 'total_downlines'){
	console_output("Count totals for various tables.");
	
	// downline totals
	$query 				= $conn->query("SELECT `id`,`upline_id`,`first_name`,`last_name` FROM `customers`; ");
	$working_customers 	= $query->fetchAll(PDO::FETCH_ASSOC);

	foreach($working_customers as $working_customer){
		// find level 1
		foreach($working_customers as $customer){
			// count downline for this customer
			if($customer['upline_id'] == $working_customer['id']){
				$downline[1][] = $customer['id'];
			}
		}

		// find level 2
		if(is_array($downline[1])){
			foreach($downline[1] as $level_2){
	        	foreach($working_customers as $customer){
	    			if($customer['upline_id'] == $level_2){
	    				$downline[2][] = $customer['id'];
	    			}
	    		}
	    	}
	    }

	    $downline_total = array_merge($downline[1], $downline[2]);
	    $downline_total = count($downline_total);

	    console_output("Member: ".$working_customer['first_name'].' '.$working_customer['last_name'].' | '.$downline_total.' in downline.');

	}

	console_output("Finished.");
}
