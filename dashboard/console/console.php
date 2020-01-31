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
	    'limitstart' => '0',
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
	
	foreach($results['clients']['client'] as $user){
		console_output("ID: ".$user['id']." | ".$user['firstname'].' '.$user['lastname']." - Updated");

		// add user and ignore errors
		$insert = $conn->exec("INSERT IGNORE INTO `users` 
	        (`id`,`added`,`type`,`status`)
	        VALUE
	        ('".$user['id']."',
	        '".time()."',
	        'promoter',
	        '".strtolower($user['status'])."'
	    )");

		$update = $conn->exec("UPDATE `users` SET `status` = '".strtolower($user['status'])."' WHERE `id` = '".$user['id']."' ");
		$update = $conn->exec("UPDATE `users` SET `first_name` = '".addslashes($user['firstname'])."' WHERE `id` = '".$user['id']."' ");
		$update = $conn->exec("UPDATE `users` SET `last_name` = '".addslashes($user['lastname'])."' WHERE `id` = '".$user['id']."' ");
		$update = $conn->exec("UPDATE `users` SET `email` = '".addslashes($user['email'])."' WHERE `id` = '".$user['id']."' ");

		$query      		= $conn->query("SELECT * FROM `users` WHERE `id` = '".$user['id']."' ");
		$existing_user     	= $query->fetch(PDO::FETCH_ASSOC);

		if( empty( $existing_user['affiliate_first_name'] ) ) {
			$update = $conn->exec("UPDATE `users` SET `affiliate_first_name` = '".addslashes($user['firstname'])."' WHERE `id` = '".$user['id']."' ");
		}
		if( empty( $existing_user['affiliate_last_name'] ) ) {
			$update = $conn->exec("UPDATE `users` SET `affiliate_last_name` = '".addslashes($user['lastname'])."' WHERE `id` = '".$user['id']."' ");
		}

		console_output("-> Getting User Products");

		// Set post values
		$postfields = array(
		    'username' => $username,
		    'password' => $password,
		    'action' => 'GetClientsProducts',
		    'clientid' => $user['id'],
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

		// cycle products for qualifying product
		foreach($results['products']['product'] as $product){
			// find the right product
			if($product['pid'] == 1){
				console_output("- -> Qualifying Product Found.");
				console_output("- -> Status: ".$product['status']);
				console_output("- -> Renew Date: ".$product['nextduedate']);

				// calculate days remaining
				$now 			= time();
				$your_date 		= strtotime($product['nextduedate']);
				$datediff 		= $your_date - $now;
				$remaining_days = round($datediff / (60 * 60 * 24));

				console_output("- -> Remaining Days: ".$remaining_days." days");

				$update = $conn->exec("UPDATE `users` SET `expire_date` = '".$product['nextduedate']."' WHERE `id` = '".$user['id']."' ");
				$update = $conn->exec("UPDATE `users` SET `promoter_qualified` = 'yes' WHERE `id` = '".$user['id']."' ");

				break;
			}
		}
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
		console_output("Order ID: ".$order['id']);

		// check if existing or new order
		$query      			= $conn->query("SELECT `id`,`user_id`,`upline_id`,`paymentstatus` FROM `orders` WHERE `order_id` = '".$order['id']."' ");
    	$existing_order       	= $query->fetch(PDO::FETCH_ASSOC);

    	// generate data for orders and commissions
    	// get the upline record
		$query      = $conn->query("SELECT * FROM `users` WHERE `id` = '".$order['userid']."' ");
		$upline     = $query->fetch(PDO::FETCH_ASSOC);

		// is this the first order from this customer
		$query      					= $conn->query("SELECT `id` FROM `orders` WHERE `user_id` = '".$order['userid']."' ");
		$existing_customer_orders     	= $query->fetchAll(PDO::FETCH_ASSOC);
		$total_existing_customer_orders = count($existing_customer_orders);
		if($total_existing_customer_orders > 1){
			$first_order = 'no';
		}else{
			$first_order = 'yes';
		}
		console_output("- First Order: ".$first_order);

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

        console_output("- Order Amount: ".$order['amount']);

        // calculate commissions - first_order == yes gets a 20% additional rreward
        if($first_order == 'yes'){
			$commission 			= number_format( ($commission_amount / 100 * 25), 2 );
			$commission_upline 		= number_format( ($commission_amount / 100 * 5), 2 );
		}else{
			$commission 			= number_format( ($commission_amount / 100 * 5), 2 );
			$commission_upline 		= number_format( ($commission_amount / 100 * 5), 2 );
		}

		console_output("- Base Commission Amount: ".$commission_amount);
		console_output("- Level 1 Commission Amount: ".$commission);
		console_output("- Upline Commission Amount: ".$commission_upline);

		// make it human readable
		$commission = number_format($commission, 2, '.', '');

    	if(!isset($existing_order['id'])){
    		// new order, process it
    		//console_output("ID: ".$order['id']." | ".$order['ordernum'].' '.$order['name']);
    		console_output("- Action: Creating New Order");

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
    		console_output("- Action: Calulating Commissions");

    		if( $order['paymentstatus'] == 'Paid' && $existing_order['paymentstatus'] != 'Paid' ) {

    		}

    		// update payment status for each order
    		$update = $conn->exec("UPDATE `orders` SET `paymentstatus` = '".$order['paymentstatus']."' WHERE `id` = '".$existing_order['id']."' ");

    		// add the order to commissions if marked as paid
		    if( $order['paymentstatus'] == 'Paid' ){
		    	// get upline details for working out commissions
		    	
		    	// upline 1
    			$query      	= $conn->query("SELECT `id`,`upline_id`,`promoter_qualified` FROM `users` WHERE `id` = '".$existing_order['upline_id']."' ");
    			$upline_1     	= $query->fetch(PDO::FETCH_ASSOC);

    			// check if upline os qualified
		    	if($upline_1['promoter_qualified'] == 'yes'){
		    		$qualified = 'yes';
		    	}else{
		    		$qualified = 'no';
		    	}

		    	// insert record
	    		$insert = $conn->exec("INSERT IGNORE INTO `commissions` 
			        (`added`,`user_id`,`customer_id`,`amount`,`int_order_id`,`qualified`)
			        VALUE
			        ('".time()."',
			        '".$upline_1['id']."',
			        '".$order['userid']."',
			        '".$commission."',
			        '".$existing_order['id']."',
			        '".$qualified."'
			    )");


			    // upline 2
			    if($upline_1['upline_id'] != 0){
	    			$query      	= $conn->query("SELECT `id`,`upline_id`,`promoter_qualified` FROM `users` WHERE `id` = '".$upline_1['upline_id']."' ");
	    			$upline_2     	= $query->fetch(PDO::FETCH_ASSOC);

	    			// check if upline os qualified
			    	if($upline_2['promoter_qualified'] == 'yes'){
			    		$qualified = 'yes';
			    	}else{
		    			$qualified = 'no';
			    	}

			    	// insert record
		    		$insert = $conn->exec("INSERT IGNORE INTO `commissions` 
				        (`added`,`user_id`,`customer_id`,`amount`,`int_order_id`,`qualified`)
				        VALUE
				        ('".time()."',
				        '".$upline_2['id']."',
				        '".$order['userid']."',
				        '".$commission_upline."',
				        '".$existing_order['id']."',
			        	'".$qualified."'
				    )");
		    	}

		    	// upline 3
			    if($upline_2['upline_id'] != 0){
	    			$query      	= $conn->query("SELECT `id`,`upline_id`,`promoter_qualified` FROM `users` WHERE `id` = '".$upline_2['upline_id']."' ");
	    			$upline_3     	= $query->fetch(PDO::FETCH_ASSOC);

	    			// check if upline os qualified
			    	if($upline_3['promoter_qualified'] == 'yes'){
			    		$qualified = 'yes';
			    	}else{
		    			$qualified = 'no';
			    	}

			    	// insert record
		    		$insert = $conn->exec("INSERT IGNORE INTO `commissions` 
				        (`added`,`user_id`,`customer_id`,`amount`,`int_order_id`,`qualified`)
				        VALUE
				        ('".time()."',
				        '".$upline_3['id']."',
				        '".$order['userid']."',
				        '".$commission_upline."',
				        '".$existing_order['id']."',
			        	'".$qualified."'
				    )");
		    	}

		    	// upline 4
			    if($upline_3['upline_id'] != 0){
	    			$query      	= $conn->query("SELECT `id`,`upline_id`,`promoter_qualified` FROM `users` WHERE `id` = '".$upline_3['upline_id']."' ");
	    			$upline_4     	= $query->fetch(PDO::FETCH_ASSOC);

	    			// check if upline os qualified
			    	if($upline_4['promoter_qualified'] == 'yes'){
			    		$qualified = 'yes';
			    	}else{
		    			$qualified = 'no';
			    	}

			    	// insert record
		    		$insert = $conn->exec("INSERT IGNORE INTO `commissions` 
				        (`added`,`user_id`,`customer_id`,`amount`,`int_order_id`,`qualified`)
				        VALUE
				        ('".time()."',
				        '".$upline_4['id']."',
				        '".$order['userid']."',
				        '".$commission_upline."',
				        '".$existing_order['id']."',
			        	'".$qualified."'
				    )");
		    	}

		    	// upline 5
			    if($upline_4['upline_id'] != 0){
	    			$query      	= $conn->query("SELECT `id`,`upline_id`,`promoter_qualified` FROM `users` WHERE `id` = '".$upline_4['upline_id']."' ");
	    			$upline_5     	= $query->fetch(PDO::FETCH_ASSOC);

	    			// check if upline os qualified
			    	if($upline_5['promoter_qualified'] == 'yes'){
			    		$qualified = 'yes';
			    	}else{
		    			$qualified = 'no';
			    	}

			    	// insert record
		    		$insert = $conn->exec("INSERT IGNORE INTO `commissions` 
				        (`added`,`user_id`,`customer_id`,`amount`,`int_order_id`,`qualified`)
				        VALUE
				        ('".time()."',
				        '".$upline_5['id']."',
				        '".$order['userid']."',
				        '".$commission_upline."',
				        '".$existing_order['id']."',
			        	'".$qualified."'
				    )");
		    	}

		    	// upline 6
			    if($upline_5['upline_id'] != 0){
	    			$query      	= $conn->query("SELECT `id`,`upline_id`,`promoter_qualified` FROM `users` WHERE `id` = '".$upline_5['upline_id']."' ");
	    			$upline_6    	= $query->fetch(PDO::FETCH_ASSOC);

	    			// check if upline os qualified
			    	if($upline_6['promoter_qualified'] == 'yes'){
			    		$qualified = 'yes';
			    	}else{
		    			$qualified = 'no';
			    	}

			    	// insert record
		    		$insert = $conn->exec("INSERT IGNORE INTO `commissions` 
				        (`added`,`user_id`,`customer_id`,`amount`,`int_order_id`,`qualified`)
				        VALUE
				        ('".time()."',
				        '".$upline_6['id']."',
				        '".$order['userid']."',
				        '".$commission_upline."',
				        '".$existing_order['id']."',
			        	'".$qualified."'
				    )");
		    	}

		    	// upline 7
			    if($upline_6['upline_id'] != 0){
	    			$query      	= $conn->query("SELECT `id`,`upline_id`,`promoter_qualified` FROM `users` WHERE `id` = '".$upline_6['upline_id']."' ");
	    			$upline_7    	= $query->fetch(PDO::FETCH_ASSOC);

	    			// check if upline os qualified
			    	if($upline_7['promoter_qualified'] == 'yes'){
			    		$qualified = 'yes';
			    	}else{
		    			$qualified = 'no';
			    	}

			    	// insert record
		    		$insert = $conn->exec("INSERT IGNORE INTO `commissions` 
				        (`added`,`user_id`,`customer_id`,`amount`,`int_order_id`,`qualified`)
				        VALUE
				        ('".time()."',
				        '".$upline_7['id']."',
				        '".$order['userid']."',
				        '".$commission_upline."',
				        '".$existing_order['id']."',
			        	'".$qualified."'
				    )");
		    	}
	    	}else{
	    		console_output("-> Order ID: ".$existing_order['id']." has not been paid yet");
	    	}
    	}

    	console_output("");
	}

	// clean up random bugs
	$query      	= $conn->query("SELECT `id` FROM `users` ");
    $users     		= $query->fetchAll(PDO::FETCH_ASSOC);
    foreach($users as $user){
    	$query      			= $conn->query("SELECT `id` FROM `commissions` WHERE `user_id` = '".$user['id']."' AND `customer_id` = '".$user['id']."' ");
    	$commissions     		= $query->fetchAll(PDO::FETCH_ASSOC);

    	foreach($commissions as $commission){
    		$delete = $conn->exec("DELETE FROM `commissions` WHERE `id` = '".$commission['id']."' ");
    	}
    }

	console_output("Finished.");
}

if($task == 'activate_affiliates'){
	console_output("Activating WHMCS Affiliates.");

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
		console_output("Activating ID: ".$user['id']);

		// Set post values
		$postfields = array(
		    'username' => $username,
		    'password' => $password,
		    'action' => 'AffiliateActivate',
		    'userid' => $user['id'],
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
	}

	console_output("Finished.");
}

if($task == 'user_badges'){
	console_output("Award badges to users.");
	
	// get all users
	$query 				= $conn->query("SELECT `id`,`upline_id`,`first_name`,`last_name` FROM `users` WHERE `type` = 'promoter' ");
	$users 				= $query->fetchAll(PDO::FETCH_ASSOC);

	foreach($users as $user){
		console_output("User: ".$user['id']." | ".$user['first_name'].' '.$user['last_name']);

		// get orders for this user
		$orders = get_whmcs_orders($user['id']);

		//////////////////////////////////////////////////
		// find IBO
		foreach($orders as $order){
			foreach($order['lineitems']['lineitem'] as $order_item){
				console_output("- Product: ".$order_item['order_details']['product_id']." | ".$order_item['product']);
				if($order_item['order_details']['product_id'] == 2){
					// we found the IBO, add the badge
					$insert = $conn->exec("INSERT IGNORE INTO `user_badges` 
				        (`user_id`,`badge_id`)
				        VALUE
				        ('".$user['id']."',
			        	'0'
				    )");

				    console_output("- Badge: IBO");

					break 2;
				}
			}
		}

		//////////////////////////////////////////////////
		// find 1 star IBO
		$badge_to_add['1_star_ibo']['needed_score']		= 1;
		$badge_to_add['1_star_ibo']['score']			= 0;

		// get
		$query 				= $conn->query("SELECT `id`,`upline_id` FROM `users` WHERE `upline_id` = '".$user['id']."' ");
		$downlines 			= $query->fetchAll(PDO::FETCH_ASSOC);
		if(isset($downlines[0]['id'])){
			// loop over the downline and find everyone with a qualifying badge
			foreach($downlines as $downline){
				// check this user for qualifying badge
				$query 				= $conn->query("SELECT `id` FROM `user_badges` WHERE `user_id` = '".$downline['id']."' AND `badge_id` = '0' ");
				$existing_badge 	= $query->fetch(PDO::FETCH_ASSOC);
				if(isset($existing_badge['id'])){
					$badge_to_add['1_star_ibo']['score']++;
				}
			}
		}

		// check the score
		if($badge_to_add['1_star_ibo']['score'] >= $badge_to_add['1_star_ibo']['needed_score']){
			// we found 2 IBOs, add the badge
			$insert = $conn->exec("INSERT IGNORE INTO `user_badges` 
		        (`user_id`,`badge_id`)
		        VALUE
		        ('".$user['id']."',
	        	'1'
		    )");

		    console_output("- Badge: 1 Star IBO");
		}

		//////////////////////////////////////////////////
		// find 2 star IBO
		$badge_to_add['2_star_ibo']['needed_score']		= 2;
		$badge_to_add['2_star_ibo']['score']			= 0;

		// get
		$query 				= $conn->query("SELECT `id`,`upline_id` FROM `users` WHERE `upline_id` = '".$user['id']."' ");
		$downlines 			= $query->fetchAll(PDO::FETCH_ASSOC);
		if(isset($downlines[0]['id'])){
			// loop over the downline and find everyone with a qualifying badge
			foreach($downlines as $downline){
				// check this user for qualifying badge
				$query 				= $conn->query("SELECT `id` FROM `user_badges` WHERE `user_id` = '".$downline['id']."' AND `badge_id` = '0' ");
				$existing_badge 	= $query->fetch(PDO::FETCH_ASSOC);
				if(isset($existing_badge['id'])){
					$badge_to_add['2_star_ibo']['score']++;
				}
			}
		}

		// check the score
		if($badge_to_add['2_star_ibo']['score'] >= $badge_to_add['2_star_ibo']['needed_score']){
			// we found 2 IBOs, add the badge
			$insert = $conn->exec("INSERT IGNORE INTO `user_badges` 
		        (`user_id`,`badge_id`)
		        VALUE
		        ('".$user['id']."',
	        	'2'
		    )");

		    console_output("- Badge: 2 Star IBO");
		}

		//////////////////////////////////////////////////
		// find 3 star IBO
		$badge_to_add['3_star_ibo']['needed_score']		= 3;
		$badge_to_add['3_star_ibo']['score']			= 0;

		// get
		$query 				= $conn->query("SELECT `id`,`upline_id` FROM `users` WHERE `upline_id` = '".$user['id']."' ");
		$downlines 			= $query->fetchAll(PDO::FETCH_ASSOC);
		if(isset($downlines[0]['id'])){
			// loop over the downline and find everyone with a qualifying badge
			foreach($downlines as $downline){
				// check this user for qualifying badge
				$query 				= $conn->query("SELECT `id` FROM `user_badges` WHERE `user_id` = '".$downline['id']."' AND `badge_id` = '0' ");
				$existing_badge 	= $query->fetch(PDO::FETCH_ASSOC);
				if(isset($existing_badge['id'])){
					$badge_to_add['3_star_ibo']['score']++;
				}
			}
		}

		// check the score
		if($badge_to_add['3_star_ibo']['score'] >= $badge_to_add['3_star_ibo']['needed_score']){
			// we found 2 IBOs, add the badge
			$insert = $conn->exec("INSERT IGNORE INTO `user_badges` 
		        (`user_id`,`badge_id`)
		        VALUE
		        ('".$user['id']."',
	        	'3'
		    )");

		    console_output("- Badge: 3 Star IBO");
		}

		//////////////////////////////////////////////////
		// find 4 star IBO
		$badge_to_add['4_star_ibo']['needed_score']		= 4;
		$badge_to_add['4_star_ibo']['score']			= 0;

		// get
		$query 				= $conn->query("SELECT `id`,`upline_id` FROM `users` WHERE `upline_id` = '".$user['id']."' ");
		$downlines 			= $query->fetchAll(PDO::FETCH_ASSOC);
		if(isset($downlines[0]['id'])){
			// loop over the downline and find everyone with a qualifying badge
			foreach($downlines as $downline){
				// check this user for qualifying badge
				$query 				= $conn->query("SELECT `id` FROM `user_badges` WHERE `user_id` = '".$downline['id']."' AND `badge_id` = '0' ");
				$existing_badge 	= $query->fetch(PDO::FETCH_ASSOC);
				if(isset($existing_badge['id'])){
					$badge_to_add['4_star_ibo']['score']++;
				}
			}
		}

		// check the score
		if($badge_to_add['4_star_ibo']['score'] >= $badge_to_add['4_star_ibo']['needed_score']){
			// we found 2 IBOs, add the badge
			$insert = $conn->exec("INSERT IGNORE INTO `user_badges` 
		        (`user_id`,`badge_id`)
		        VALUE
		        ('".$user['id']."',
	        	'4'
		    )");

		    console_output("- Badge: 4 Star IBO");
		}

		//////////////////////////////////////////////////
		// find 5 star IBO
		$badge_to_add['5_star_ibo']['needed_score']		= 5;
		$badge_to_add['5_star_ibo']['score']			= 0;

		// get
		$query 				= $conn->query("SELECT `id`,`upline_id` FROM `users` WHERE `upline_id` = '".$user['id']."' ");
		$downlines 			= $query->fetchAll(PDO::FETCH_ASSOC);
		if(isset($downlines[0]['id'])){
			// loop over the downline and find everyone with a qualifying badge
			foreach($downlines as $downline){
				// check this user for qualifying badge
				$query 				= $conn->query("SELECT `id` FROM `user_badges` WHERE `user_id` = '".$downline['id']."' AND `badge_id` = '0' ");
				$existing_badge 	= $query->fetch(PDO::FETCH_ASSOC);
				if(isset($existing_badge['id'])){
					$badge_to_add['5_star_ibo']['score']++;
				}
			}
		}

		// check the score
		if($badge_to_add['5_star_ibo']['score'] >= $badge_to_add['5_star_ibo']['needed_score']){
			// we found 2 IBOs, add the badge
			$insert = $conn->exec("INSERT IGNORE INTO `user_badges` 
		        (`user_id`,`badge_id`)
		        VALUE
		        ('".$user['id']."',
	        	'5'
		    )");

		    console_output("- Badge: 5 Star IBO");
		}
	}

	console_output("Finished.");
}