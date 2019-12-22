<?php

include('/home/ukmarketingclub/public_html/dashboard/inc/db.php');
include('/home/ukmarketingclub/public_html/dashboard/inc/global_vars.php');
include('/home/ukmarketingclub/public_html/dashboard/inc/functions.php');
// include('/home/ukmarketingclub/public_html/dashboard/inc/php_colors.php');

date_default_timezone_set('UTC');

// $colors = new Colors();

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
	$query 				= $conn->query("SELECT `id`,`upline_id`,`first_name`,`last_name` FROM `users`; ");
	$working_customers 	= $query->fetchAll(PDO::FETCH_ASSOC);

	foreach($working_customers as $working_customer){
		// set defaults
		$downline[1] 	= array();
		$downline[2] 	= array();
		$downline[3] 	= array();
		$downline[4] 	= array();
		$downline[5] 	= array();
		$downline[6] 	= array();
		$downline[7] 	= array();
		$downline[8] 	= array();
		$downline[9] 	= array();
		$downline[10] 	= array();


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

	    // find level 3
		if(is_array($downline[2])){
			foreach($downline[2] as $level_3){
	        	foreach($working_customers as $customer){
	    			if($customer['upline_id'] == $level_3){
	    				$downline[3][] = $customer['id'];
	    			}
	    		}
	    	}
	    }

	    // find level 4
		if(is_array($downline[3])){
			foreach($downline[3] as $level_4){
	        	foreach($working_customers as $customer){
	    			if($customer['upline_id'] == $level_4){
	    				$downline[4][] = $customer['id'];
	    			}
	    		}
	    	}
	    }

	    // find level 5
		if(is_array($downline[4])){
			foreach($downline[4] as $level_5){
	        	foreach($working_customers as $customer){
	    			if($customer['upline_id'] == $level_5){
	    				$downline[5][] = $customer['id'];
	    			}
	    		}
	    	}
	    }

	    // find level 6
		if(is_array($downline[5])){
			foreach($downline[5] as $level_6){
	        	foreach($working_customers as $customer){
	    			if($customer['upline_id'] == $level_6){
	    				$downline[6][] = $customer['id'];
	    			}
	    		}
	    	}
	    }

	    // find level 7
		if(is_array($downline[6])){
			foreach($downline[6] as $level_7){
	        	foreach($working_customers as $customer){
	    			if($customer['upline_id'] == $level_7){
	    				$downline[7][] = $customer['id'];
	    			}
	    		}
	    	}
	    }

	    // merge arrays for counting
	    $downline_total = array_merge($downline[1], $downline[2], $downline[3], $downline[4], $downline[5], $downline[6], $downline[7], $downline[8], $downline[9], $downline[10]);
	    $downline_total = count($downline_total);

	    $update = $conn->exec("UPDATE `users` SET `total_downline` = '".$downline_total."' WHERE `id` = '".$working_customer['id']."' ");

	    console_output("Member: ".$working_customer['first_name'].' '.$working_customer['last_name'].' | '.$downline_total.' in downline.');

	    unset($downline);
	    unset($downline_total);
	}

	console_output("Finished.");
}

if($task == 'sync_databases'){
	console_output("Syncing WHMCS to Dashboard.");

	// get all whmcs users
	$whmcsUrl = "https://ublo.club/billing/";
	$username = "api_user";
	$password = md5("admin1372");

	// Set post values
	$postfields = array(
	    'username' => $username,
	    'password' => $password,
	    'action' => 'GetClients',
	    'responsetype' => 'json',
	);

	// Call the API
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $whmcsUrl . 'includes/api.php');
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postfields));
	$response = curl_exec($ch);
	if (curl_error($ch)) {
	    die('Unable to connect: ' . curl_errno($ch) . ' - ' . curl_error($ch));
	}
	curl_close($ch);

	// Decode response
	$results = json_decode($response, true);
	
	foreach($results['clients']['client'] as $user){
		console_output("ID: ".$user['id']."| ".$user['firstname'].' '.$user['lastname']." - Updated");

		$update = $conn->exec("UPDATE `users` SET `status` = '".strtolower($user['status'])."' WHERE `id` = '".$user['id']."' ");

		$update = $conn->exec("UPDATE `users` SET `first_name` = '".addslashes($user['firstname'])."' WHERE `id` = '".$user['id']."' ");
		$update = $conn->exec("UPDATE `users` SET `last_name` = '".addslashes($user['lastname'])."' WHERE `id` = '".$user['id']."' ");
		$update = $conn->exec("UPDATE `users` SET `email` = '".addslashes($user['email'])."' WHERE `id` = '".$user['id']."' ");
	}

	console_output("Finished.");
}

if($task == 'get_orders'){
	console_output("Get WHMCS Orders.");

	// get all whmcs users
	$whmcsUrl = "https://ublo.club/billing/";
	$username = "api_user";
	$password = md5("admin1372");

	// Set post values
	$postfields = array(
	    'username' => $username,
	    'password' => $password,
	    'action' => 'GetOrders',
	    'limitnum' => '10000',
	    'responsetype' => 'json',
	);

	// Call the API
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $whmcsUrl . 'includes/api.php');
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postfields));
	$response = curl_exec($ch);
	if (curl_error($ch)) {
	    die('Unable to connect: ' . curl_errno($ch) . ' - ' . curl_error($ch));
	}
	curl_close($ch);

	// Decode response
	$results = json_decode($response, true);

	// reorder the orders because whmcs is retarded
	$orders = array_reverse($results['orders']['order']);
	
	foreach($orders as $order){
		// check if existing or new order
		$query      			= $conn->query("SELECT `id`,`user_id`,`upline_id`,`paymentstatus` FROM `orders` WHERE `order_id` = '".$order['id']."' ");
    	$existing_order       	= $query->fetch(PDO::FETCH_ASSOC);

    	// generate data for orders and commissions
    	// get the upline record
		$query      = $conn->query("SELECT * FROM `users` WHERE `id` = '".$order['userid']."' ");
		$upline     = $query->fetch(PDO::FETCH_ASSOC);

		// is this the first order from this customer
		$query      			= $conn->query("SELECT `id` FROM `orders` WHERE `user_id` = '".$order['userid']."' ");
		$existing_customer     	= $query->fetch(PDO::FETCH_ASSOC);
		if(isset($existing_customer['id'])){
			$first_order = 'no';
		}else{
			$first_order = 'yes';
		}

		// search for business builder pack and remove it from commission
		$remove_business_builder_pack = false;
		foreach($order['lineitems']['lineitem'] as $line_item){
            $line_item['order_details']     = whmcs_order_to_product($line_item['relid']);

            if($line_item['order_details']['product_id'] == 2){
            	$remove_business_builder_pack = true;
            }
        }

        // remove commissions for business builder pack - its the law
        if($remove_business_builder_pack == true){
        	$commission_amount = $order['amount'] - 40.00;
        }else{
        	$commission_amount = $order['amount'];
        }

        // calculate commissions - first_order == yes gets a 20% additional rreward
        if($first_order == 'yes'){
			$commission 			= ($commission_amount / 100 * 25);
			$commission_upline 		= ($commission_amount / 100 * 5);
		}else{
			$commission 			= ($commission_amount / 100 * 5);
			$commission_upline 		= ($commission_amount / 100 * 5);
		}

		// make it human readable
		$commission = number_format($commission, 2, '.', '');

    	if(!isset($existing_order['id'])){
    		// new order, process it
    		console_output("ID: ".$order['id']." | ".$order['ordernum'].' '.$order['name']);

    		// add the order to orders
    		$insert = $conn->exec("INSERT INTO `orders` 
		        (`added`,`order_id`,`order_num`,`user_id`,`amount`,`commission_amount`,`invoice_id`,`paymentstatus`,`upline_id`,`first_order`,`commission`)
		        VALUE
		        ('".time()."',
		        '".$order['id']."',
		        '".$order['ordernum']."',
		        '".$order['userid']."',
		        '".$order['amount']."',
		        '".$commission_amount."',
		        '".$order['invoiceid']."',
		        '".$order['paymentstatus']."',
		        '".$upline['upline_id']."',
		        '".$first_order."',
		        '".$commission."'
		    )");
    	}else{
    		// update payment status for each order
    		$update = $conn->exec("UPDATE `orders` SET `paymentstatus` = '".$order['paymentstatus']."' WHERE `id` = '".$existing_order['id']."' ");

    		// add the order to commissions if marked as paid
		    if($order['paymentstatus'] == 'Paid'){
		    	// get upline details for working out commissions
		    	
		    	// upline 1
    			$query      	= $conn->query("SELECT `id`,`upline_id`,`promoter_qualified` FROM `users` WHERE `id` = '".$existing_order['upline_id']."' ");
    			$upline_1     	= $query->fetch(PDO::FETCH_ASSOC);

	    		$insert = $conn->exec("INSERT IGNORE INTO `commissions` 
			        (`added`,`user_id`,`customer_id`,`amount`,`int_order_id`)
			        VALUE
			        ('".time()."',
			        '".$upline_1['id']."',
			        '".$order['userid']."',
			        '".$commission."',
			        '".$existing_order['id']."'
			    )");


			    // upline 2
			    if($upline_1['upline_id'] != 0){
	    			$query      	= $conn->query("SELECT `id`,`upline_id` FROM `users` WHERE `id` = '".$upline_1['upline_id']."' ");
	    			$upline_2     	= $query->fetch(PDO::FETCH_ASSOC);

		    		$insert = $conn->exec("INSERT IGNORE INTO `commissions` 
				        (`added`,`user_id`,`customer_id`,`amount`,`int_order_id`)
				        VALUE
				        ('".time()."',
				        '".$upline_2['id']."',
				        '".$order['userid']."',
				        '".$commission_upline."',
				        '".$existing_order['id']."'
				    )");
		    	}

		    	// upline 3
			    if($upline_2['upline_id'] != 0){
	    			$query      	= $conn->query("SELECT `id`,`upline_id` FROM `users` WHERE `id` = '".$upline_2['upline_id']."' ");
	    			$upline_3     	= $query->fetch(PDO::FETCH_ASSOC);

		    		$insert = $conn->exec("INSERT IGNORE INTO `commissions` 
				        (`added`,`user_id`,`customer_id`,`amount`,`int_order_id`)
				        VALUE
				        ('".time()."',
				        '".$upline_3['id']."',
				        '".$order['userid']."',
				        '".$commission_upline."',
				        '".$existing_order['id']."'
				    )");
		    	}

		    	// upline 4
			    if($upline_3['upline_id'] != 0){
	    			$query      	= $conn->query("SELECT `id`,`upline_id` FROM `users` WHERE `id` = '".$upline_3['upline_id']."' ");
	    			$upline_4     	= $query->fetch(PDO::FETCH_ASSOC);

		    		$insert = $conn->exec("INSERT IGNORE INTO `commissions` 
				        (`added`,`user_id`,`customer_id`,`amount`,`int_order_id`)
				        VALUE
				        ('".time()."',
				        '".$upline_4['id']."',
				        '".$order['userid']."',
				        '".$commission_upline."',
				        '".$existing_order['id']."'
				    )");
		    	}

		    	// upline 5
			    if($upline_4['upline_id'] != 0){
	    			$query      	= $conn->query("SELECT `id`,`upline_id` FROM `users` WHERE `id` = '".$upline_4['upline_id']."' ");
	    			$upline_5     	= $query->fetch(PDO::FETCH_ASSOC);

		    		$insert = $conn->exec("INSERT IGNORE INTO `commissions` 
				        (`added`,`user_id`,`customer_id`,`amount`,`int_order_id`)
				        VALUE
				        ('".time()."',
				        '".$upline_5['id']."',
				        '".$order['userid']."',
				        '".$commission_upline."',
				        '".$existing_order['id']."'
				    )");
		    	}

		    	// upline 6
			    if($upline_5['upline_id'] != 0){
	    			$query      	= $conn->query("SELECT `id`,`upline_id` FROM `users` WHERE `id` = '".$upline_5['upline_id']."' ");
	    			$upline_6    	= $query->fetch(PDO::FETCH_ASSOC);

		    		$insert = $conn->exec("INSERT IGNORE INTO `commissions` 
				        (`added`,`user_id`,`customer_id`,`amount`,`int_order_id`)
				        VALUE
				        ('".time()."',
				        '".$upline_6['id']."',
				        '".$order['userid']."',
				        '".$commission_upline."',
				        '".$existing_order['id']."'
				    )");
		    	}

		    	// upline 7
			    if($upline_5['upline_id'] != 0){
	    			$query      	= $conn->query("SELECT `id`,`upline_id` FROM `users` WHERE `id` = '".$upline_6['upline_id']."' ");
	    			$upline_7    	= $query->fetch(PDO::FETCH_ASSOC);

		    		$insert = $conn->exec("INSERT IGNORE INTO `commissions` 
				        (`added`,`user_id`,`customer_id`,`amount`,`int_order_id`)
				        VALUE
				        ('".time()."',
				        '".$upline_7['id']."',
				        '".$order['userid']."',
				        '".$commission_upline."',
				        '".$existing_order['id']."'
				    )");
		    	}
	    	}
    	}
	}

	console_output("Finished.");
}