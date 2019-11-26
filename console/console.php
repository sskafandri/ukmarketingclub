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

if($task == 'clean_db'){
	$query = $conn->query("PURGE BINARY LOGS TO 'mysql-bin.000061' ");
	console_output("Finished.");
}

if($task == 'node_checks'){
	console_output("Checking nodes for online / offline status.");
	$now = time();

	$query = $conn->query("SELECT `id`,`updated`,`name` FROM `headend_servers` WHERE `status` != 'installing' ");
	$headends = $query->fetchAll(PDO::FETCH_ASSOC);
	foreach($headends as $headend) {
		$time_diff = $now - $headend['updated'];
		if($time_diff > 70) {
			console_output("Headend '".stripslashes($headend['name'])."' appears offline.");
			$update = $conn->exec("UPDATE `headend_servers` SET `status` = 'offline' WHERE `id` = '".$headend['id']."' ");

			$update = $conn->exec("UPDATE `capture_devices` SET `status` = 'offline' WHERE `server_id` = '".$headend['id']."' ");

			$update = $conn->exec("UPDATE `streams` SET `status` = 'offline' WHERE `server_id` = '".$headend['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `status` = 'offline' WHERE `source_server_id` = '".$headend['id']."' ");

			$update = $conn->exec("UPDATE `streams` SET `stream_uptime` = '' WHERE `server_id` = '".$headend['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `stream_uptime` = '' WHERE `source_server_id` = '".$headend['id']."' ");
		}
	}
	console_output("Finished.");
}

if($task == 'source_checks'){
	console_output("Checking all sources for online / missing status.");
	$now = time();

	$query = $conn->query("SELECT * FROM `headend_servers` ");
	$headends = $query->fetchAll(PDO::FETCH_ASSOC);
	foreach($headends as $headend) {
		if($headend['status'] == 'online') {
			$query = $conn->query("SELECT * FROM `capture_devices` WHERE `status` != 'missing' AND `server_id` = '".$headend['id']."' ");
			$sources = $query->fetchAll(PDO::FETCH_ASSOC);
			foreach($sources as $source) {
				$time_diff = $now - $source['updated'];
				if($time_diff > 70) {
					console_output("Source '".stripslashes($source['name'])."' appears to be missing.");
					$update = $conn->exec("UPDATE `capture_devices` SET `status` = 'missing' WHERE `id` = '".$source['id']."' ");
				}
			}
		}
	}
	console_output("Finished.");
}

if($task == 'stream_checks'){

	console_output("Checking streams for online / offline status.");

	$runs = 1;
	
	$query = $conn->query("SELECT * FROM `streams` ORDER BY 'server_id' ASC");
	$streams = $query->fetchAll(PDO::FETCH_ASSOC);

    $count 				= count($streams);

    for ($i=0; $i<$runs; $i++) {
        for ($j=0; $j<$count; $j++) {
            $pipe[$j] = popen("php -q /home2/slipstream/public_html/hub/console/console.php stream_checks_process ".$streams[$j]['id'], 'w');
            // $pipe[$j] = popen("echo ".$streams[$j]['id'], 'w');
            // echo "php -q /home2/slipstream/public_html/hub/console/console.php stream_checks_process ".$streams[$j]['id'] ."\n";
        }

        // wait for them to finish
        for ($j=0; $j<$count; ++$j) {
            pclose($pipe[$j]);
        }

    }

	console_output("Finished.");
}

if($task == 'stream_ondemand_check'){
	$time_shift = time() - 120;

	console_output("Checking on-demand channels for activity.");

	$query = $conn->query("SELECT `id`,`server_id`,`running_pid`,`name` FROM `streams` WHERE `stream_type` = 'input' AND `enable` = 'yes' AND `ondemand` = 'yes' ");
	$input_streams = $query->fetchAll(PDO::FETCH_ASSOC);
	
	foreach($input_streams as $input_stream){

		console_output("Input Stream: " . stripslashes($input_stream['name']));

		// get output streams
		$query = $conn->query("SELECT `id` FROM `streams` WHERE `source_stream_id` = '".$input_stream['id']."' ");
		$output_streams = $query->fetchAll(PDO::FETCH_ASSOC);

		$viewers = 0;

		foreach($output_streams as $output_stream){
			$query = $conn->query("SELECT `id` FROM `streams_connection_logs` WHERE `stream_id` = '".$output_stream['id']."' AND `timestamp` > '".$time_shift."' GROUP BY 'client_ip' ");
			$online_clients = $query->fetchAll(PDO::FETCH_ASSOC);
			$viewers = $viewers + count($online_clients);
		}

		if($viewers == 0){
			console_output(" - " . $viewers . " viewers, stopping.");

			$job['action'] = 'kill_pid';
			$job['command'] = 'kill -9 '.$input_stream['running_pid'];

			// add the job
			$insert = $conn->exec("INSERT INTO `jobs` 
		        (`server_id`,`job`)
		        VALUE
		        ('".$input_stream['server_id']."','".json_encode($job)."')");
		}else{
			console_output(" - " . $viewers . " viewers, skipping.");
		}
	}
}

if($task == 'stream_checks_process') {
	$stream_id = $argv[2];

	$now = time();

	$query = $conn->query("SELECT * FROM `streams` WHERE `id` = '".$stream_id."' ");
	$streams = $query->fetchAll(PDO::FETCH_ASSOC);
	foreach($streams as $stream) {
		$stream['output_options'] = json_decode($stream['output_options'], true); 

		// get headend data for this stream
		$query = $conn->query("SELECT * FROM `headend_servers` WHERE `id` = '".$stream['server_id']."' ");
		$stream['headend'] = $query->fetchAll(PDO::FETCH_ASSOC);
		
		foreach($stream['output_options'] as $key => $output_options) {
			// build stream_url
			$screen_resolution = explode('x', $output_options['screen_resolution']);

			if($stream['headend'][0]['output_type'] == 'rtmp') {
				$stream['stream_url'] = 'http://'.$stream['headend'][0]['wan_ip_address'].':'.$stream['headend'][0]['http_stream_port'].'/hls/'.$stream['publish_name'].'/index.m3u8';
			}else{
				$stream['stream_url'] = 'http://'.$stream['headend'][0]['wan_ip_address'].':'.$stream['headend'][0]['http_stream_port'].'/play/hls/'.$stream['publish_name'].'_'.$screen_resolution[1].'/index.m3u8';
			}

			// make sure the IP is in the firewall for outgoing connections
			shell_exec("sudo csf -a " . $stream['headend'][0]['wan_ip_address']);

			// console_output("Testing URL: " . $stream['stream_url']);

			$stream['test_results'] = shell_exec("/etc/ffmpeg/ffprobe -v quiet -print_format json -show_format -show_streams ".$stream['stream_url']);
			
			$stream['test_results'] = json_decode($stream['test_results'], true);

			// update status
			if(isset($stream['test_results']['streams'])) {
				console_output("Stream: '".stripslashes($stream['name'] . ' ' . strtoupper($key))."' appears ".$colors->getColoredString("online.", "green", "black"));
				$output_options['status'] = 'online';
			}elseif(!isset($stream['test_results']['streams'])){
				console_output("Stream: '".stripslashes($stream['name'] . ' ' . strtoupper($key))."' appears ".$colors->getColoredString("offline.", "red", "black"));
				$output_options['status'] = 'offline';
			}else{
				console_output("Stream: '".stripslashes($stream['name'] . ' ' . strtoupper($key))."' status =  ".$colors->getColoredString("UNKNOWN.", "blue", "black"));
				$output_options['status'] = 'unknown';

				print_r($stream['test_results']);
			}

			$save_results[$key] = $output_options;
		}

		$update = $conn->exec("UPDATE `streams` SET `output_options` = '".json_encode($save_results)."' WHERE `id` = '".$stream['id']."' ");

	}
}

if($task == 'stream_sync'){
	console_output("Syncing category and logo from input to output streams.");
	$now = time();

	$query = $conn->query("SELECT * FROM `streams` ");
	$streams = $query->fetchAll(PDO::FETCH_ASSOC);
	foreach($streams as $stream) {
		// update category_id
		$update = $conn->exec("UPDATE `streams` SET `category_id` = '".$stream['category_id']."' WHERE `source_stream_id` = '".$stream['id']."' ");

		// update logo
		$update = $conn->exec("UPDATE `streams` SET `logo` = '".$stream['logo']."' WHERE `source_stream_id` = '".$stream['id']."' ");
	}
	console_output("Finished.");
}

if($task == 'customer_checks'){
	console_output("Checking customers for various things.");
	
	$now = time();

	$query = $conn->query("SELECT * FROM `customers` ");
	$customers = $query->fetchAll(PDO::FETCH_ASSOC);
	foreach($customers as $customer) {
		$expire_date = strtotime($customer['expire_date']);

		// make sure unlimited is enabled
		if($customer['expire_date'] == '1970-01-01'){
			$update = $conn->exec("UPDATE `customers` SET `status` = 'enabled' WHERE `id` = '".$customer['id']."' ");
		}elseif(time() > $expire_date) {
	        // customer account expired, update it
	        $update = $conn->exec("UPDATE `customers` SET `status` = 'expired' WHERE `id` = '".$customer['id']."' ");

	        console_output("Customer: ".$customer['username']." has expired, updating records.");
	    }else{
	    	$update = $conn->exec("UPDATE `customers` SET `status` = 'enabled' WHERE `id` = '".$customer['id']."' ");
	    }
	}
	console_output("Finished.");
}

if($task == 'xc_imports'){
	console_output("Xtream-Codes Import Manager.");
	$now = time();

	$query = $conn->query("SELECT * FROM `slipstream_cms`.`xc_import_jobs` WHERE `status` = 'pending' LIMIT 1");
	$import = $query->fetch(PDO::FETCH_ASSOC);

	if(!empty($import)){

		$user_id = $import['user_id'];
		
		console_output("Starting Import Job: ".$import['id']);
		console_output("User: ".$import['user_id']);
		console_output("Filename: /var/www/html/portal/xc_uploads/".$user_id."/".$import['filename']);
		
		$update = $conn->exec("UPDATE `slipstream_cms`.`xc_import_jobs` SET `status` = 'importing' WHERE `id` = '".$import['id']."' ");

		// sanity checks
		if(!file_exists("/var/www/html/portal/xc_uploads/".$user_id."/".$import['filename'])){
			$update = $conn->exec("UPDATE `slipstream_cms`.`xc_import_jobs` SET `status` = 'error' WHERE `id` = '".$import['id']."' ");
			$update = $conn->exec("UPDATE `slipstream_cms`.`xc_import_jobs` SET `error_message` = 'Unable to find file.' WHERE `id` = '".$import['id']."' ");
			console_output("File does not exist or we cannot read it.");
			die();
		}

		// remove database and create it again
		$delete = $conn->exec("DROP DATABASE IF EXISTS `slipstream_xc_staging`;");
		$delete = $conn->exec("CREATE DATABASE `slipstream_xc_staging`;");

		// parse out the files to import
		exec("sed -n -e '/DROP TABLE.*`streams`/,/UNLOCK TABLES/p' /var/www/html/portal/xc_uploads/".$user_id."/".$import['filename']." > /var/www/html/portal/xc_uploads/".$user_id."/streams.sql");
		exec("sed -n -e '/DROP TABLE.*`users`/,/UNLOCK TABLES/p' /var/www/html/portal/xc_uploads/".$user_id."/".$import['filename']." > /var/www/html/portal/xc_uploads/".$user_id."/users.sql");
		exec("sed -n -e '/DROP TABLE.*`reg_users`/,/UNLOCK TABLES/p' /var/www/html/portal/xc_uploads/".$user_id."/".$import['filename']." > /var/www/html/portal/xc_uploads/".$user_id."/reg_users.sql");
		exec("sed -n -e '/DROP TABLE.*`packages`/,/UNLOCK TABLES/p' /var/www/html/portal/xc_uploads/".$user_id."/".$import['filename']." > /var/www/html/portal/xc_uploads/".$user_id."/packages.sql");
		exec("sed -n -e '/DROP TABLE.*`bouquets`/,/UNLOCK TABLES/p' /var/www/html/portal/xc_uploads/".$user_id."/".$import['filename']." > /var/www/html/portal/xc_uploads/".$user_id."/bouquets.sql");
		exec("sed -n -e '/DROP TABLE.*`mag_devices`/,/UNLOCK TABLES/p' /var/www/html/portal/xc_uploads/".$user_id."/".$import['filename']." > /var/www/html/portal/xc_uploads/".$user_id."/mag_devices.sql");
		
		// import DB files
		console_output("Importing Xtream-Codes SQL Dump files.");
		exec("(/usr/bin/mysql -u slipstream -padmin1372 -hlocalhost slipstream_xc_staging < /var/www/html/portal/xc_uploads/".$user_id."/streams.sql) 2>&1", $output, $result);
		exec("(/usr/bin/mysql -u slipstream -padmin1372 -hlocalhost slipstream_xc_staging < /var/www/html/portal/xc_uploads/".$user_id."/users.sql) 2>&1", $output, $result);
		exec("(/usr/bin/mysql -u slipstream -padmin1372 -hlocalhost slipstream_xc_staging < /var/www/html/portal/xc_uploads/".$user_id."/reg_users.sql) 2>&1", $output, $result);
		exec("(/usr/bin/mysql -u slipstream -padmin1372 -hlocalhost slipstream_xc_staging < /var/www/html/portal/xc_uploads/".$user_id."/packages.sql) 2>&1", $output, $result);
		exec("(/usr/bin/mysql -u slipstream -padmin1372 -hlocalhost slipstream_xc_staging < /var/www/html/portal/xc_uploads/".$user_id."/bouquets.sql) 2>&1", $output, $result);
		exec("(/usr/bin/mysql -u slipstream -padmin1372 -hlocalhost slipstream_xc_staging < /var/www/html/portal/xc_uploads/".$user_id."/mag_devices.sql) 2>&1", $output, $result);

		// more sanity checks
		try {
        	$result = $conn->query("SELECT * FROM `slipstream_xc_staging`.`streams` LIMIT 1");
	    } catch (Exception $e) {
	        // We got an exception == table not found
	        $update = $conn->exec("UPDATE `slipstream_cms`.`xc_import_jobs` SET `status` = 'error' WHERE `id` = '".$import['id']."' ");
			$update = $conn->exec("UPDATE `slipstream_cms`.`xc_import_jobs` SET `error_message` = 'Your backup does not contain a streams table. Try making a new backup and uploading it again. Do NOT trim anything but LOG files.' WHERE `id` = '".$import['id']."' ");
			console_output("missing streams table.");
			die();
	    }
	    try {
        	$result = $conn->query("SELECT * FROM `slipstream_xc_staging`.`users` LIMIT 1");
	    } catch (Exception $e) {
	        // We got an exception == table not found
	        $update = $conn->exec("UPDATE `slipstream_cms`.`xc_import_jobs` SET `status` = 'error' WHERE `id` = '".$import['id']."' ");
			$update = $conn->exec("UPDATE `slipstream_cms`.`xc_import_jobs` SET `error_message` = 'Your backup does not contain a users table. Try making a new backup and uploading it again. Do NOT trim anything but LOG files.' WHERE `id` = '".$import['id']."' ");
			console_output("missing users table.");
			die();
	    }
	    try {
        	$result = $conn->query("SELECT * FROM `slipstream_xc_staging`.`reg_users` LIMIT 1");
	    } catch (Exception $e) {
	        // We got an exception == table not found
	        $update = $conn->exec("UPDATE `slipstream_cms`.`xc_import_jobs` SET `status` = 'error' WHERE `id` = '".$import['id']."' ");
			$update = $conn->exec("UPDATE `slipstream_cms`.`xc_import_jobs` SET `error_message` = 'Your backup does not contain a reg_users table. Try making a new backup and uploading it again. Do NOT trim anything but LOG files.' WHERE `id` = '".$import['id']."' ");
			console_output("missing reg_users table.");
			die();
	    }
	    try {
        	$result = $conn->query("SELECT * FROM `slipstream_xc_staging`.`bouquets` LIMIT 1");
	    } catch (Exception $e) {
	        // We got an exception == table not found
	        $update = $conn->exec("UPDATE `slipstream_cms`.`xc_import_jobs` SET `status` = 'error' WHERE `id` = '".$import['id']."' ");
			$update = $conn->exec("UPDATE `slipstream_cms`.`xc_import_jobs` SET `error_message` = 'Your backup does not contain a bouquets table. Try making a new backup and uploading it again. Do NOT trim anything but LOG files.' WHERE `id` = '".$import['id']."' ");
			console_output("missing bouquets table.");
			die();
	    }
	    /*
	    try {
        	$result = $conn->query("SELECT * FROM `slipstream_xc_staging`.`mag_devices` LIMIT 1");
	    } catch (Exception $e) {
	        // We got an exception == table not found
	        $update = $conn->exec("UPDATE `slipstream_cms`.`xc_import_jobs` SET `status` = 'error' WHERE `id` = '".$import['id']."' ");
			$update = $conn->exec("UPDATE `slipstream_cms`.`xc_import_jobs` SET `error_message` = 'Your backup does not contain a mag_devices table. Try making a new backup and uploading it again. Do NOT trim anything but LOG files.' WHERE `id` = '".$import['id']."' ");
			console_output("missing mag_devices table.");
			die();
	    }
	    */

		// get first server id
		$query = $conn->query("SELECT `id` FROM `slipstream_cms`.`headend_servers` WHERE `user_id` = '".$user_id."' LIMIT 1");
		$server = $query->fetch(PDO::FETCH_ASSOC);
		$server_id = $server['id'];
		if(empty($server_id)){
			$update = $conn->exec("UPDATE `slipstream_cms`.`xc_import_jobs` SET `status` = 'error' WHERE `id` = '".$import['id']."' ");
			$update = $conn->exec("UPDATE `slipstream_cms`.`xc_import_jobs` SET `error_message` = 'Please add your first server first.' WHERE `id` = '".$import['id']."' ");
			console_output("Please add your first server first.");
			die();
		}

		// convert xc streams to ss streams
		$query = $conn->query("SELECT * FROM `slipstream_xc_staging`.`streams` WHERE `type` = '1' ");
		$xc_streams = $query->fetchAll(PDO::FETCH_ASSOC);

		console_output("Migrating: ".number_format(count($xc_streams))." streams");

		foreach($xc_streams as $xc_stream){
			$rand 				= md5(rand(00000,99999).time());

			$name 				= addslashes($xc_stream['stream_display_name']);
			$name 				= trim($name);

			$source 			= stripslashes($xc_stream['stream_source']);
			$source 			= str_replace(array("[", "]"), "", $source);
			$source 			= explode(",", $source);

			if(is_array($source)) {
				$source = $source[0];
			}else{
				$source = $source;
			}

			$source 			= str_replace('"', "", $source);
			$source 			= addslashes($source);

			$ffmpeg_re			= 'no';

			$logo 				= addslashes($xc_stream['stream_icon']);

		    // add input stream
			$insert = $conn->exec("INSERT INTO `slipstream_cms`.`streams` 
		        (`user_id`,`server_id`,`stream_type`,`name`,`enable`,`source`,`cpu_gpu`,`job_status`,`ffmpeg_re`,`logo`,`epg_xml_id`)
		        VALUE
		        ('".$user_id."',
		        '".$server_id."',
		        'input',
		        '".$name."',
		        'no',
		        '".$source."',
		        'cpu',
		        'analysing',
		        '".$ffmpeg_re."',
		        '".$logo."',
		        '".$xc_stream['channel_id']."'
		    )");

		    $stream_id = $conn->lastInsertId();

		    // add output stream
		    $insert = $conn->exec("INSERT INTO `slipstream_cms`.`streams` 
		        (`user_id`,`enable`,`server_id`,`stream_type`,`name`,`source_server_id`,`source_stream_id`,`old_xc_id`,`logo`,`epg_xml_id`)
		        VALUE
		        ('".$user_id."',
		        'no',
		        '".$server_id."',
		        'output',
		        '".$name."',
		        '".$server_id."',
		        '".$stream_id."',
		        '".$xc_stream['id']."',
		        '".$logo."',
		        '".$xc_stream['channel_id']."'
		    )");

			echo ".";
		}
		echo "\n";

		// convert xc packages to ss packages
		$query = $conn->query("SELECT * FROM `slipstream_xc_staging`.`packages` ");
		$xc_packages = $query->fetchAll(PDO::FETCH_ASSOC);

		console_output("Migrating: ".number_format(count($xc_packages))." packages");

		foreach($xc_packages as $xc_package){
			$xc_package['bouquets'] = str_replace(array("[","]"), "", $xc_package['bouquets']);

			$insert = $conn->exec("INSERT INTO `slipstream_cms`.`packages` 
		        (`user_id`,`name`,`is_trial`,`credits`,`trial_duration`,`official_duration`,`bouquets`,`old_xc_id`)
		        VALUE
		        ('".$user_id."',
		        '".addslashes($xc_package['package_name'])."',
		        '".addslashes($xc_package['is_trial'])."',
		        '".addslashes($xc_package['official_credits'])."',
		        '".addslashes($xc_package['trial_duration'])."',
		        '".addslashes($xc_package['official_duration'])."',
		        '".addslashes($xc_package['bouquets'])."',
		        '".addslashes($xc_package['id'])."'
		    )");

		    echo ".";
		}
		echo "\n";

		// convert xc bouquet to ss packages
		$query = $conn->query("SELECT * FROM `slipstream_xc_staging`.`bouquets` ");
		$xc_bouquets = $query->fetchAll(PDO::FETCH_ASSOC);

		console_output("Migrating: ".number_format(count($xc_bouquets))." bouquets");

		foreach($xc_bouquets as $xc_bouquet){
			$xc_bouquet['streams'] = str_replace(array("[","]",'"'), "", $xc_bouquet['bouquet_channels']);
			
			$old_streams = explode(",", $xc_bouquet['streams']);

			foreach($old_streams as $old_stream){
				$query = $conn->query("SELECT `id` FROM `slipstream_cms`.`streams` WHERE `user_id` = '".$user_id."' AND `old_xc_id` = '".$old_stream."' ");
				$temp_stream = $query->fetch(PDO::FETCH_ASSOC);
				$new_streams[] = $temp_stream['id'];
			}

			$xc_bouquet['streams'] = implode(",", $new_streams);

			$insert = $conn->exec("INSERT IGNORE INTO `slipstream_cms`.`bouquets` 
		        (`user_id`,`name`,`streams`,`old_xc_id`)
		        VALUE
		        ('".$user_id."',
		        '".addslashes($xc_bouquet['bouquet_name'])."',
		        '".addslashes($xc_bouquet['streams'])."',
		        '".addslashes($xc_bouquet['id'])."'
		    )");

		    echo ".";
		}
		echo "\n";

		// convert xc users to ss customers
		$query = $conn->query("SELECT * FROM `slipstream_xc_staging`.`reg_users` ");
		$xc_reg_users = $query->fetchAll(PDO::FETCH_ASSOC);

		console_output("Migrating: ".number_format(count($xc_reg_users))." resellers");

		foreach($xc_reg_users as $xc_reg_user){
			if($xc_reg_user['status'] == 1){
				$xc_reg_user['status'] = 'enabled';
			}else{
				$xc_reg_user['status'] = 'disable';
			}

			$password = md5(time().rand(0,9));

			$insert = $conn->exec("INSERT INTO `slipstream_cms`.`resellers` 
		        (`status`,`updated`,`user_id`,`group_id`,`email`,`username`,`password`,`credits`)
		        VALUE
		        ('".addslashes($xc_reg_user['status'])."',
		        '".time()."',
		        '".$user_id."',
		        '4',
		        '".addslashes($xc_reg_user['email'])."',
		        '".addslashes($xc_reg_user['username'])."',
		        '".$password."',
		        '".addslashes($xc_reg_user['credits'])."'
		    )");

		    echo ".";
		}
		echo "\n";

		// convert xc users to ss customers
		$query = $conn->query("SELECT `id`,`exp_date`,`created_by`,`username`,`password`,`bouquet`,`max_connections`,`admin_notes`,`reseller_notes` FROM `slipstream_xc_staging`.`users` ");
		$xc_users = $query->fetchAll(PDO::FETCH_ASSOC);

		console_output("Migrating: ".number_format(count($xc_users))." customers");

		foreach($xc_users as $xc_user){
			$xc_user_exp_date = date("Y-m-d", $xc_user['exp_date']);

			if($xc_user['exp_date'] < time()) {
				$customer_status = 'expired';
			}else{
				$customer_status = 'enabled';
			}

			$old_owner = $xc_user['created_by'];

			$query = $conn->query("SELECT `username` FROM `slipstream_xc_staging`.`reg_users` WHERE `id` = '".$old_owner."' ");
			$xc_old_owner = $query->fetch(PDO::FETCH_ASSOC);
			$new_owner_username = $xc_old_owner['username'];

			$query = $conn->query("SELECT `id` FROM `slipstream_cms`.`resellers` WHERE `user_id` = '".$user_id."' AND `username` = '".$new_owner_username."' ");
			$new_owner = $query->fetch(PDO::FETCH_ASSOC);
			$reseller_id = $new_owner['id'];

			$xc_user['bouquet'] = str_replace(array("[","]", '"'), "", $xc_user['bouquet']);

			$old_bouquets = explode(",", $xc_user['bouquet']);

			foreach($old_bouquets as $old_bouquet){
				$query = $conn->query("SELECT `id` FROM `slipstream_cms`.`bouquets` WHERE `user_id` = '".$user_id."' AND `old_xc_id` = '".$old_bouquet."' ");
				$temp_bouquet = $query->fetch(PDO::FETCH_ASSOC);
				$new_bouquets[] = $temp_bouquet['id'];
			}

			$xc_user['bouquet'] = implode(",", $new_bouquets);

			$insert = $conn->exec("INSERT IGNORE INTO `slipstream_cms`.`customers` 
		        (`status`,`user_id`,`reseller_id`,`username`,`password`,`expire_date`,`live_content`,`bouquet`,`max_connections`,`notes`,`reseller_notes`,`old_xc_id`)
		        VALUE
		        ('".$customer_status."',
		        '".$user_id."',
		        '".$reseller_id."',
		        '".addslashes($xc_user['username'])."',
		        '".addslashes($xc_user['password'])."',
		        '".$xc_user_exp_date."',
		        'on',
		        '".$xc_user['bouquet']."',
		        '".$xc_user['max_connections']."',
		        '".addslashes($xc_user['admin_notes'])."',
		        '".addslashes($xc_user['reseller_notes'])."',
		       	'".$xc_user['id']."'
		    )");

		    unset($old_bouquets);
		    unset($new_bouquets);
		
		    echo ".";
		}
		echo "\n";

		// convert mag_devices to ss customers
		$query = $conn->query("SELECT `user_id`,`mag_id`,`mac`,`bright`,`aspect` FROM `slipstream_xc_staging`.`mag_devices` ");
		$xc_mags = $query->fetchAll(PDO::FETCH_ASSOC);

		console_output("Migrating: ".number_format(count($xc_mags))." mag_devices");

		foreach($xc_mags as $xc_mag){
			// old customer_id
			$old_customer_id = $xc_mag['user_id'];

			// get new customer_id
			$query = $conn->query("SELECT `id` FROM `slipstream_cms`.`customers` WHERE `user_id` = '".$user_id."' AND `old_xc_id` = '".$old_customer_id."' ");
			$customer = $query->fetch(PDO::FETCH_ASSOC);

			if(empty($customer)){
				$customer['id'] = 0;
			}

			$insert = $conn->exec("INSERT INTO `slipstream_cms`.`mag_devices` 
		        (`user_id`,`customer_id`,`mac`,`aspect`,`old_xc_id`)
		        VALUE
		        ('".$user_id."',
		        '".$customer['id']."',
		        '".$xc_mag['mac']."',
		        '".addslashes($xc_mag['aspect'])."',
		        '".addslashes($xc_mag['mag_id'])."'
		    )");

		    echo ".";
		}
		echo "\n";

		// remove files

		$update = $conn->exec("UPDATE `slipstream_cms`.`xc_import_jobs` SET `status` = 'complete' WHERE `id` = '".$import['id']."' ");
	}

	console_output("Finished.");
}

if($task == 'xc_imports_mac_fix'){
	console_output("Xtream-Codes Import Manager - MAG MAC Fix.");

	// convert mag_devices to ss customers
	$query 		= $conn->query("SELECT `mag_id`,`mac` FROM `slipstream_xc_staging`.`mag_devices` ");
	$xc_mags 	= $query->fetchAll(PDO::FETCH_ASSOC);

	console_output("Updating: ".number_format(count($xc_mags))." mag_devices");

	foreach($xc_mags as $xc_mag){
		$old_mag_id = $xc_mag['mag_id'];

		/*
		if(base64_decode($xc_mag['mac'], true)){
			$update = $conn->exec("UPDATE `slipstream_cms`.`mag_devices` SET `mac` = '".$xc_mag['mac']."' WHERE `old_xc_id` = '".$old_customer_id."' ");
		}else{
		    $update = $conn->exec("UPDATE `slipstream_cms`.`mag_devices` SET `mac` = '".base64_encode($xc_mag['mac'])."' WHERE `old_xc_id` = '".$old_customer_id."' ");
		}
		*/

		// console_output("UPDATE `slipstream_cms`.`mag_devices` SET `mac` = '".$xc_mag['mac']."' WHERE `old_xc_id` = '".$old_mag_id."';");

		$update = $conn->exec("UPDATE `slipstream_cms`.`mag_devices` SET `mac` = '".$xc_mag['mac']."' WHERE `old_xc_id` = '".$old_mag_id."' ");
	    echo ".";
	}

	echo "\n";

	console_output("Finished.");
}

if($task == 'stalker_sync'){
	console_output("SlipStream > Ministra Sync");

	// stream_categories > tv_genre
	$query 					= $conn->query("SELECT * FROM `slipstream_cms`.`stream_categories` ORDER BY `id` ");
	$stream_categories 		= $query->fetchAll(PDO::FETCH_ASSOC);

	console_output("Syncing: ".number_format(count($stream_categories))." stream_categories");

	// 24/7 tv channel category override
	$query 					= $conn->query("SELECT `id` FROM `stalker_db`.`tv_genre` WHERE `title` = '24/7 TV Channels' LIMIT 1");
	$existing_category 		= $query->fetch(PDO::FETCH_ASSOC);

	if(!isset($existing_category['id'])){
		$insert = $conn->exec("INSERT INTO `stalker_db`.`tv_genre` 
	        (`id`,`title`,`number`,`modified`,`censored`)
	        VALUE
	        ('999999',
	        '24/7 TV Channels',
	        '999999',
	        '2019-10-01 00:00:00',
	        '0'
	    )");
	}

	foreach($stream_categories as $stream_category){
		$query 					= $conn->query("SELECT `id` FROM `stalker_db`.`tv_genre` WHERE `id` = '".$stream_category['id']."' LIMIT 1");
		$existing_category 		= $query->fetch(PDO::FETCH_ASSOC);

		if(!isset($existing_category['id'])){
			$insert = $conn->exec("INSERT INTO `stalker_db`.`tv_genre` 
		        (`id`,`title`,`number`,`modified`,`censored`)
		        VALUE
		        ('".$stream_category['id']."',
		        '".addslashes($stream_category['name'])."',
		        '".$stream_category['id']."',
		        '2019-10-01 00:00:00',
		        '0'
		    )");
		}else{
			$update = $conn->exec("UPDATE `stalker_db`.`tv_genre` SET `title` = '".addslashes($stream_category['name'])."' WHERE `id` = '".$stream_category['id']."' ");
		}
	}

	console_output(" ");
	console_output("======================================================================");
	console_output(" ");

	// packages > tarrif_plan
	$query 					= $conn->query("SELECT * FROM `slipstream_cms`.`packages` ORDER BY `id` ");
	$packages 				= $query->fetchAll(PDO::FETCH_ASSOC);

	console_output("Syncing: ".number_format(count($packages))." packages to tariffs");

	foreach($packages as $package){
		$query 					= $conn->query("SELECT `id` FROM `stalker_db`.`tariff_plan` WHERE `id` = '".$package['id']."' LIMIT 1");
		$existing_tarrif 		= $query->fetch(PDO::FETCH_ASSOC);

		if(!isset($existing_tarrif['id'])){
		    $insert = $conn->exec("INSERT INTO `stalker_db`.`tariff_plan` 
		        (`id`,`external_id`,`name`,`user_default`,`days_to_expires`)
		        VALUE
		        ('".$package['id']."',
		        '',
		        '".addslashes($package['name'])."',
		        '0',
		        '0'
		    )");
		}else{
			$update = $conn->exec("UPDATE `stalker_db`.`tariff_plan` SET `name` = '".addslashes($package['name'])."' WHERE `id` = '".$package['id']."' ");
		}

		// convert bouquets to package_in_plan
		$delete = $conn->exec("DELETE FROM `stalker_db`.`package_in_plan`		 	WHERE `package_id` = '".$package['id']."' ");
		
		$bouquets = explode(",", $package['bouquets']);
		$bouquets = array_filter($bouquets);

		foreach($bouquets as $bouquet){
			$insert = $conn->exec("INSERT INTO `stalker_db`.`package_in_plan` 
		        (`package_id`,`plan_id`,`optional`,`modified`)
		        VALUE
		        ('".$bouquet."',
		        '".$package['id']."',
		        '0',
		        '2019-10-01 00:00:00'
		    )");
		}
	}

	console_output(" ");
	console_output("======================================================================");
	console_output(" ");

	// streams > itv, ch_links
	$query 					= $conn->query("SELECT * FROM `slipstream_cms`.`streams` WHERE `stream_type` = 'output' ORDER BY `id` ");
	$streams 				= $query->fetchAll(PDO::FETCH_ASSOC);

	console_output("Syncing: ".number_format(count($streams))." streams to channels");

	foreach($streams as $stream){
		console_output("Name: ".addslashes($stream['name']));

		// account for no category
		if(empty($stream['category_id'])){
			$stream['category_id'] = 1;
		}

		// find server for this stream
		$query 					= $conn->query("SELECT `wan_ip_address`,`http_stream_port` FROM `slipstream_cms`.`headend_servers` WHERE `id` = '".$stream['source_server_id']."' ");
		$stream_server 			= $query->fetch(PDO::FETCH_ASSOC);

		// build internal source url
		$stream['source']		= "http://".$stream_server['wan_ip_address'].":".$stream_server['http_stream_port']."/play/hls/".$stream['id']."_.m3u8?token=".$global_settings['master_token'];

		// check for existing stream
		$query 					= $conn->query("SELECT `id` FROM `stalker_db`.`itv` WHERE `id` = '".$stream['id']."' LIMIT 1");
		$existing_stream 		= $query->fetch(PDO::FETCH_ASSOC);
		if(!isset($existing_stream['id'])){
			console_output(" - New stream found");

			$insert = $conn->exec("INSERT IGNORE INTO `stalker_db`.`itv` 
		        (`id`,`name`,`number`,`censored`,`cmd`,`tv_genre_id`,`service_id`,`modified`,`xmltv_id`)
		        VALUE
		        ('".$stream['id']."',
		        '".addslashes($stream['name'])."',
		        '".$stream['id']."',
		        '0',
		        '".$stream['source']."',
		        '".$stream['category_id']."',
		        '',
		        '2019-10-01 00:00:00',
		        '".$stream['epg_xml_id']."'
		    )");
		}else{
			console_output(" - Existing stream");
			$update = $conn->exec("UPDATE `stalker_db`.`itv` SET `name` = '".addslashes($stream['name'])."' 				WHERE `id` = '".$stream['id']."' ");
			$update = $conn->exec("UPDATE `stalker_db`.`itv` SET `cmd` = '".$stream['source']."' 				WHERE `id` = '".$stream['id']."' ");
			$update = $conn->exec("UPDATE `stalker_db`.`itv` SET `tv_genre_id` = '".$stream['category_id']."' 	WHERE `id` = '".$stream['id']."' ");
			$update = $conn->exec("UPDATE `stalker_db`.`itv` SET `xmltv_id` = '".$stream['epg_xml_id']."' 		WHERE `id` = '".$stream['id']."' ");
		}

		$query 					= $conn->query("SELECT `id` FROM `stalker_db`.`ch_links` WHERE `ch_id` = '".$stream['id']."' LIMIT 1");
		$existing_stream_link 	= $query->fetch(PDO::FETCH_ASSOC);

		if(!isset($existing_stream_link['id'])){
		    $insert = $conn->exec("INSERT INTO `stalker_db`.`ch_links` 
		        (`ch_id`,`url`,`status`,`changed`)
		        VALUE
		        ('".$stream['id']."',
		        '".$stream['source']."',
		        '1',
		        '2019-10-01 00:00:00'
		    )");
		}else{
			$update = $conn->exec("UPDATE `stalker_db`.`ch_links` SET `url` = '".$stream['source']."' 			WHERE `ch_id` = '".$stream['id']."' ");
		}
	}

	// get stalker_db streams to compare for removing
	$query 					= $conn->query("SELECT `id` FROM `stalker_db`.`itv` ORDER BY `id` ");
	$temp_stalker_streams 	= $query->fetchAll(PDO::FETCH_ASSOC);
	foreach($temp_stalker_streams as $temp_stalker_stream){
		$stalker_streams[] = $temp_stalker_stream['id'];
	}

	// format slipstream_cms streams for array_diff
	foreach($streams as $stream){
		$slipstream_streams[] = $stream['id'];
	}

	console_output(" ");
	console_output("======================================================================");
	console_output(" ");

	// 24/7 tv channels > itv, ch_links
	$query 					= $conn->query("SELECT * FROM `slipstream_cms`.`channels` ORDER BY `id` ");
	$channels 				= $query->fetchAll(PDO::FETCH_ASSOC);

	console_output("Syncing: ".number_format(count($channels))." 24/7 tv channels to channels");

	foreach($channels as $channel){
		console_output("Name: ".addslashes($channel['name']));

		// find server for this stream
		$query 					= $conn->query("SELECT `wan_ip_address`,`http_stream_port` FROM `slipstream_cms`.`headend_servers` WHERE `id` = '".$channel['server_id']."' ");
		$channel_server 		= $query->fetch(PDO::FETCH_ASSOC);

		// build internal source url
		$channel['source']		= "http://".$channel_server['wan_ip_address'].":".$channel_server['http_stream_port']."/play/hls/channel_".$channel['id']."_.m3u8?token=".$global_settings['master_token'];

		// check for existing stream
		$query 					= $conn->query("SELECT `id` FROM `stalker_db`.`itv` WHERE `id` = '247".$channel['id']."' LIMIT 1");
		$existing_channel 		= $query->fetch(PDO::FETCH_ASSOC);
		if(!isset($existing_channel['id'])){
			console_output(" - New channel found");

			$insert = $conn->exec("INSERT IGNORE INTO `stalker_db`.`itv` 
		        (`id`,`name`,`number`,`censored`,`cmd`,`tv_genre_id`,`service_id`,`modified`)
		        VALUE
		        ('247".$channel['id']."',
		        '24/7: ".addslashes($channel['name'])."',
		        '247".$channel['id']."',
		        '0',
		        '".$channel['source']."',
		        '999999',
		        '',
		        '2019-10-01 00:00:00'
		    )");
		}else{
			console_output(" - Existing stream");
			$update = $conn->exec("UPDATE `stalker_db`.`itv` SET `name` = '24/7: ".addslashes($channel['name'])."' 				WHERE `id` = '247".$channel['id']."' ");
			$update = $conn->exec("UPDATE `stalker_db`.`itv` SET `cmd` = '".$channel['source']."' 				WHERE `id` = '247".$channel['id']."' ");
		}

		$query 					= $conn->query("SELECT `id` FROM `stalker_db`.`ch_links` WHERE `ch_id` = '247".$channel['id']."' LIMIT 1");
		$existing_channel_link 	= $query->fetch(PDO::FETCH_ASSOC);

		if(!isset($existing_channel_link['id'])){
		    $insert = $conn->exec("INSERT INTO `stalker_db`.`ch_links` 
		        (`ch_id`,`url`,`status`,`changed`)
		        VALUE
		        ('247".$channel['id']."',
		        '".$channel['source']."',
		        '1',
		        '2019-10-01 00:00:00'
		    )");
		}else{
			$update = $conn->exec("UPDATE `stalker_db`.`ch_links` SET `url` = '".$channel['source']."' 			WHERE `ch_id` = '247".$channel['id']."' ");
		}
	}

	// format slipstream_cms channels for array_diff
	foreach($channels as $channel){
		$slipstream_streams[] = '247'.$channel['id'];
	}

	// compare arrays to remove ones we dont want
	$contents_diffs = array_diff($stalker_streams, $slipstream_streams);
	foreach($contents_diffs as $contents_diff){
		$delete = $conn->exec("DELETE FROM `stalker_db`.`itv` WHERE `id` = '".$contents_diff."' ");
		
	}

	console_output(" ");
	console_output("======================================================================");
	console_output(" ");

	// bouquets > services_package
	$query 					= $conn->query("SELECT * FROM `slipstream_cms`.`bouquets` ORDER BY `id` ");
	$bouquets 				= $query->fetchAll(PDO::FETCH_ASSOC);

	console_output("Syncing: ".number_format(count($bouquets))." bouquets to services_package");

	foreach($bouquets as $bouquet){
		console_output("Name: ".addslashes($bouquet['name']));

		// convert ss to ministra bouqet / package type
		if($bouquet['type'] == 'live'){
			$bouquet_type = 'tv';
		}elseif($bouquet['type'] == 'vod'){
			$bouquet_type = 'video';
		}elseif($bouquet['type'] == 'channel'){
			$bouquet_type = 'tv';
		}else{
			$bouquet_type = 'tv';
		}

		$delete = $conn->exec("DELETE FROM `stalker_db`.`services_package`		 	WHERE `id` = '".$bouquet['id']."' ");
		$delete = $conn->exec("DELETE FROM `stalker_db`.`service_in_package` 		WHERE `package_id` = '".$bouquet['id']."' ");
		// $delete = $conn->exec("DELETE FROM `stalker_db`.`package_in_plan` 		WHERE `package_id` = '".$bouquet['id']."' ");

		$insert = $conn->exec("INSERT INTO `stalker_db`.`services_package` 
	        (`id`,`name`,`type`,`all_services`,`service_type`,`rent_duration`,`price`)
	        VALUE
	        ('".$bouquet['id']."',
	        '".addslashes($bouquet['name'])."',
	        '".$bouquet_type."',
	        '1',
	        'periodic',
	        '0',
	        '0.00'
	    )");

		console_output(" - Streams to Package:" . $bouquet['streams']);

		// get bouquets_contents and to service_in_package
		$query 					= $conn->query("SELECT * FROM `slipstream_cms`.`bouquets_content` WHERE `bouquet_id` = '".$bouquet['id']."' ");
		$bouquets_contents 		= $query->fetchAll(PDO::FETCH_ASSOC);

	    if(is_array($bouquets_contents) && !empty($bouquets_contents)){
	    	foreach($bouquets_contents as $bouquets_content){
	    		$insert = $conn->exec("INSERT INTO `stalker_db`.`service_in_package` 
			         (`service_id`,`package_id`,`type`,`modified`,`options`)
			        VALUE
			        ('".$bouquets_content['content_id']."',
			        '".$bouquet['id']."',
			        '".$bouquet_type."',
			        '2019-10-01 00:00:00',
			        '{}'
			    )");
	    	}
	    }		    
	}

	console_output(" ");
	console_output("======================================================================");
	console_output(" ");

	// customers > users
	$query 					= $conn->query("SELECT * FROM `slipstream_cms`.`customers` ORDER BY `id` ");
	$customers 				= $query->fetchAll(PDO::FETCH_ASSOC);

	console_output("Syncing: ".number_format(count($customers))." customers to users");

	foreach($customers as $customer){
		// generate stalker compatible password
		$stalker_password 		= md5(md5($customer['password']).$customer['id']);

		// set customer status for stalker
		if($customer['status'] == 'enabled'){
			$customer['status'] = 0;
		}else{
			$customer['status'] = 1;
		}

		// see if customer has a mag assigned to it
		$query 					= $conn->query("SELECT `mac` FROM `slipstream_cms`.`mag_devices` WHERE `customer_id` = '".$customer['id']."' LIMIT 1");
		$customer_mag 			= $query->fetch(PDO::FETCH_ASSOC);
		if(isset($customer_mag['mac'])){
			$customer['mac'] = base64_decode($customer_mag['mac']);
		}else{
			$customer['mac'] = '';
		}

		// check for existing stalker user
		$query 					= $conn->query("SELECT `id` FROM `stalker_db`.`users` WHERE `id` = '".$customer['id']."' LIMIT 1");
		$existing_customer 		= $query->fetch(PDO::FETCH_ASSOC);

		if(!isset($existing_customer['id'])){
			console_output(" - New customer: ".addslashes($customer['username']));
			$insert = $conn->exec("INSERT INTO `stalker_db`.`users` 
		        (`id`, `name`, `sname`, `pass`, `parent_password`, `bright`, `contrast`, `saturation`, `aspect`, `video_out`, `volume`, `playback_buffer_bytes`, `playback_buffer_size`, `audio_out`, `mac`, `ip`, `ls`, `version`, `lang`, `locale`, `city_id`, `status`, `hd`, `main_notify`, `fav_itv_on`, `now_playing_start`, `now_playing_type`, `now_playing_content`, `additional_services_on`, `time_last_play_tv`, `time_last_play_video`, `operator_id`, `storage_name`, `hd_content`, `image_version`, `last_change_status`, `last_start`, `last_active`, `keep_alive`, `playback_limit`, `screensaver_delay`, `phone`, `tv_quality`, `fname`, `login`, `password`, `stb_type`, `serial_number`, `num_banks`, `tariff_plan_id`, `comment`, `now_playing_link_id`, `now_playing_streamer_id`, `just_started`, `last_watchdog`, `created`, `country`, `access_token`, `plasma_saving`, `device_id`, `ts_enabled`, `ts_enable_icon`, `ts_path`, `ts_max_length`, `ts_buffer_use`, `ts_action_on_exit`, `ts_delay`, `video_clock`, `device_id2`, `verified`, `hdmi_event_reaction`, `pri_audio_lang`, `sec_audio_lang`, `pri_subtitle_lang`, `sec_subtitle_lang`, `subtitle_color`, `subtitle_size`, `show_after_loading`, `play_in_preview_by_ok`, `hw_version`, `openweathermap_city_id`, `theme`, `settings_password`, `expire_billing_date`, `reseller_id`, `account_balance`, `client_type`, `hw_version_2`, `blocked`, `units`, `tariff_expired_date`, `tariff_id_instead_expired`, `activation_code_auto_issue`)
					VALUES
					('".$customer['id']."',
						'',
						'',
						'',
						'0000',
						'200',
						'127',
						'127',
						'16',
						'',
						'100',
						'0',
						'0',
						'1',
						'".$customer['mac']."',
						'',
						'',
						'',
						'',
						'',
						'0',
						'".$customer['status']."',
						'0',
						'1',
						'0',
						'0000-00-00 00:00:00',
						'0',
						'',
						'1',
						'0000-00-00 00:00:00',
						'0000-00-00 00:00:00',
						'0',
						'',
						'0',
						'',
						'0000-00-00 00:00:00',
						'0000-00-00 00:00:00',
						'0000-00-00 00:00:00',
						'0000-00-00 00:00:00',
						'5',
						'10',
						'',
						'high',
						'".addslashes($customer['username'])."',
						'".addslashes($customer['username'])."',
						'".$stalker_password."',
						'',
						'',
						'0',
						'1',
						'',
						'0',
						'0',
						'0',
						'0000-00-00 00:00:00',
						'2019-10-27 00:05:55',
						'GB',
						'',
						'0',
						'',
						'0',
						'1',
						'',
						'3600',
						'cyclic',
						'no_save',
						'on_pause',
						'Off',
						'',
						'0',
						NULL,
						'',
						'',
						'',
						'',
						'16777215',
						'20',
						'',
						NULL,
						'',
						'0',
						'',
						'0000',
						'0000-00-00 00:00:00',
						'0',
						'',
						'',
						'',
						'0',
						'metric',
						'0000-00-00 00:00:00',
						'1',
						'0'
		    )");
		}else{
			console_output(" - Existing customer: ".addslashes($customer['username']));
			$update = $conn->exec("UPDATE `stalker_db`.`users` SET `fname` = '".addslashes($customer['username'])."' 		WHERE `id` = '".$customer['id']."' ");
			$update = $conn->exec("UPDATE `stalker_db`.`users` SET `login` = '".addslashes($customer['username'])."' 		WHERE `id` = '".$customer['id']."' ");
			$update = $conn->exec("UPDATE `stalker_db`.`users` SET `password` = '".addslashes($stalker_password)."' 		WHERE `id` = '".$customer['id']."' ");
			$update = $conn->exec("UPDATE `stalker_db`.`users` SET `mac` = '".$customer['mac']."' 				WHERE `id` = '".$customer['id']."' ");
			$update = $conn->exec("UPDATE `stalker_db`.`users` SET `status` = '".$customer['status']."' 		WHERE `id` = '".$customer['id']."' ");
		}

		// build the stalker / ministra itv_subscription
		$customer_bouquets = explode(",", $customer['bouquet']);

		$customer_streams = array();
		$customer_streams_count = 0;

		foreach($customer_bouquets as $customer_bouquet){
			// check bouquet type
			$query 					= $conn->query("SELECT * FROM `slipstream_cms`.`bouquets` WHERE `id` = '".$customer_bouquet."' ");
			$bouquet_type 			= $query->fetch(PDO::FETCH_ASSOC);
			console_output("Bouquet: ".$customer_bouquet." | ".$bouquet_type['type']);

			// get streams for this bouqeut
			$query 					= $conn->query("SELECT * FROM `slipstream_cms`.`bouquets_content` WHERE `bouquet_id` = '".$customer_bouquet."' ");
			$bouquets_contents 		= $query->fetchAll(PDO::FETCH_ASSOC);
			// console_output("Bouquet Contents: ".print_r($bouquets_contents));

			foreach($bouquets_contents as $bouquets_content){
				console_output("Adding Content ID: ".$bouquets_content['content_id']);
				if($bouquet_type['type'] == 'live'){
					$customer_streams[] = $bouquets_content['content_id'];
				}elseif($bouquet_type['type'] == 'channel'){
					$customer_streams[] = '247'.$bouquets_content['content_id'];
				}
				// $customer_streams[$customer_streams_count] = $bouquets_content['content_id'];
			}

			$customer_streams_count++;
		}

		console_output("Customer Stream Subscription");
		// debug($customer_streams);

		// filter dupes
		// $customer_streams = array_filter($customer_streams);

		// serialize for ministra
		$customer_streams = serialize($customer_streams);

		// base64 encode
		$customer_streams = base64_encode($customer_streams);

		// check for existing supscription
		$query 					= $conn->query("SELECT `id` FROM `stalker_db`.`itv_subscription` WHERE `uid` = '".$customer['id']."' LIMIT 1");
		$existing_subscription 	= $query->fetch(PDO::FETCH_ASSOC);

		if(!isset($existing_subscription['id'])){
			console_output(" - New customer subscription");

			$insert = $conn->exec("INSERT INTO `stalker_db`.`itv_subscription` 
		         (`uid`,`sub_ch`,`bonus_ch`,`addtime`)
		        VALUE
		        ('".$customer['id']."',
		        '".$customer_streams."',
		        '',
		        '2019-10-01 00:00:00'
		    )");
		}else{
			console_output(" - Existing customer subscription");
			$update = $conn->exec("UPDATE `stalker_db`.`itv_subscription` SET `sub_ch` = '".$customer_streams."' 		WHERE `uid` = '".$customer['id']."' ");
		}

		unset($customer_streams);
	}

	console_output(" ");
	console_output("======================================================================");
	console_output(" ");

	// epg
	$query 					= $conn->query("SELECT * FROM `slipstream_cms`.`epg_setting` ORDER BY `id` ");
	$epg_sources 			= $query->fetchAll(PDO::FETCH_ASSOC);

	console_output("Syncing: ".number_format(count($epg_sources))." epg sources");

	foreach($epg_sources as $epg_source){
		console_output("Name: ".addslashes($epg_source['name']));

		$insert = $conn->exec("INSERT IGNORE INTO `stalker_db`.`epg_setting` 
	        (`id`,`uri`,`etag`,`status`)
	        VALUE
	        ('".$epg_source['id']."',
	        '".$epg_source['uri']."',
	        '".$epg_source['etag']."',
	        '1'
	    )"); 
	}

	echo "\n";

	console_output("Finished.");
}

if($task == 'totals'){
	console_output("Count totals for various tables.");
	
	// episodes per 24/7 channel
	$query 		= $conn->query("SELECT `id`,`name` FROM `channels`; ");
	$channels 	= $query->fetchAll(PDO::FETCH_ASSOC);

	foreach($channels as $channel) {
		// count episodes in this seriess
		$query = $conn->query("SELECT `id` FROM `channels_files` WHERE `channel_id` = '".$channel['id']."' ");
		$channel_files = $query->fetchAll(PDO::FETCH_ASSOC);
		$total_episodes = count($channel_files);

		$update = $conn->exec("UPDATE `channels` SET `total_episodes` = '".$total_episodes."' WHERE `id` = '".$channel['id']."' ");

		console_output("24/7 TV Channel: " . $channel['name'] . " | Episodes: " . $total_episodes);
	}

	// episodes per tv series
	$query 		= $conn->query("SELECT `id`,`name` FROM `tv_series`; ");
	$tv_shows 	= $query->fetchAll(PDO::FETCH_ASSOC);

	foreach($tv_shows as $tv_show) {
		// count episodes in this series
		$query = $conn->query("SELECT `id` FROM `tv_series_files` WHERE `tv_series_id` = '".$tv_show['id']."' ");
		$channel_files = $query->fetchAll(PDO::FETCH_ASSOC);
		$total_episodes = count($channel_files);

		$update = $conn->exec("UPDATE `tv_series` SET `total_episodes` = '".$total_episodes."' WHERE `id` = '".$tv_show['id']."' ");

		console_output("TV Series: " . $tv_show['name'] . " | Episodes: " . $total_episodes);
	}

	console_output("Finished.");
}

if($task == 'channel_watch'){
	console_output("Checking 24/7 Channels for content.");
	
	// get all channels to monitor
	$query 		= $conn->query("SELECT `id`,`user_id`,`server_id`,`name`,`watch_folder` FROM `channels` ");
	$channels 	= $query->fetchAll(PDO::FETCH_ASSOC);

	if(isset($channels[0])){
		// loop over channels
		foreach($channels as $channel){
			$channel['name'] = stripslashes($channel['name']);
			console_output("Channel: " . $channel['name']);

			// get server connection details 
			$sql = "
		        SELECT `id`,`wan_ip_address`,`http_stream_port` 
		        FROM `headend_servers` 
		        WHERE `id` = '".$channel['server_id']."' 
		    ";
		    $query      		= $conn->query($sql);
		    $headend    		= $query->fetch(PDO::FETCH_ASSOC);

		    $folder_scan 		= @file_get_contents('http://'.$headend['wan_ip_address'].':'.$headend['http_stream_port'].'/scan_folder_files.php?passcode=1372&folder_path='.$channel['watch_folder']);

		    $folder_scan 		= json_decode($folder_scan, true);

		    if(isset($folder_scan[0])) {
		    	foreach($folder_scan as $key => $value){
		    		$name 					= $key;
					$file_location 			= addslashes($value);

		    		// check to see if we are already have this episode
					$query 					= $conn->query("SELECT `id` FROM `channels_files` WHERE `server_id` = '".$channel['server_id']."' AND `channel_id` = '".$channel['id']."' AND `file_location` = '".$file_location."'  ");
					$channel_file 			= $query->fetch(PDO::FETCH_ASSOC);

					if(!isset($channel_file['id'])){

						$path_bits 				= explode("/", $file_location);
						$reverse_path_bits 		= array_reverse($path_bits);
						$filename 				= $reverse_path_bits[0];

						console_output(" - New File: " . stripslashes($filename));

						// get filename
						if (preg_match("'^(.+)\.S([0-9]+)E([0-9]+).*$'i",$filename,$n)){
						    $show['name'] = preg_replace("'\.'"," ",$n[1]);
						    $show['season'] = intval($n[2],10);
						    $show['episode'] = intval($n[3],10);
						}

						if(isset($show['name']) && isset($show['season']) && isset($show['episode'])){
							console_output(" - - Getting metadata");
							$url = 'http://www.omdbapi.com/?apikey=19354e2e&t&t='.urlencode($channel['name']).'&Season='.urlencode($show['season']).'&Episode='.urlencode($show['episode']);
						    $curl = curl_init();
						    curl_setopt($curl, CURLOPT_URL, $url);
						    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
						    curl_setopt($curl, CURLOPT_HEADER, false);
						    $metadata = curl_exec($curl);
						    curl_close($curl);

						    $metadata = json_decode($metadata, true);

						    if($metadata['Response'] == True || $metadata['Response'] == 'True'){
						        if(isset($metadata['Title'])){
						        	$name           = addslashes($metadata['Title']);
						        }
						    }else{
						    	$name = $key;
						    }
						}

						// get next number in the order
						$query = $conn->query("SELECT `order` FROM `channels_files` WHERE `channel_id` = '".$channel['id']."' ORDER BY `order` DESC LIMIT 1");
						$bits = $query->fetch(PDO::FETCH_ASSOC);
						if(isset($bits['order'])) {
							$next_order = ($bits['order'] + 1);
						}else{
							$next_order = 0;
						}
							
						// add input stream
						$insert = $conn->exec("INSERT IGNORE INTO `channels_files` 
					        (`user_id`,`server_id`,`channel_id`,`name`,`file_location`,`order`,`season`,`episode`)
					        VALUE
					        ('".$channel['user_id']."',
					        '".$channel['server_id']."',
					        '".$channel['id']."',
					        '".$name."',
					        '".$file_location."',
					        '".$next_order."',
					        '".$show['season']."',
					        '".$show['episode']."'
					    )");
					}
				}
			}

			sleep(2);
		}
	}else{
		console_output("No channels to scan.");
	}

	console_output("Finished.");
}

if($task == 'tv_series_watch'){
	console_output("Checking TV Series for content.");
	
	// get all channels to monitor
	$query 		= $conn->query("SELECT `id`,`user_id`,`server_id`,`name`,`watch_folder` FROM `tv_series` ");
	$shows 		= $query->fetchAll(PDO::FETCH_ASSOC);

	if(isset($shows[0])){
		// loop over shows
		foreach($shows as $show){
			$show['name'] = stripslashes($show['name']);
			console_output("TV Series: " . $show['name']);

			// get server connection details 
			$sql = "
		        SELECT `id`,`wan_ip_address`,`http_stream_port` 
		        FROM `headend_servers` 
		        WHERE `id` = '".$show['server_id']."' 
		    ";
		    $query      		= $conn->query($sql);
		    $headend    		= $query->fetch(PDO::FETCH_ASSOC);

		    // console_output(" - API Endpoint: http://".$headend['wan_ip_address'].":".$headend['http_stream_port']."/scan_folder_files.php?passcode=1372&show=".urlencode($show['name'])."&folder_path=".$show['watch_folder']);

		    $folder_scan 		= @file_get_contents('http://'.$headend['wan_ip_address'].':'.$headend['http_stream_port'].'/scan_folder_files.php?passcode=1372&show='.urlencode($show['name']).'&folder_path='.$show['watch_folder']);

		    $folder_scan 		= json_decode($folder_scan, true);

		    // print_r($folder_scan);

		    if(!empty($folder_scan)) {
		    	foreach($folder_scan as $key => $value){
		    		$name 					= $key;
					$file_location 			= addslashes($value);

		    		// check to see if we are already have this episode
					$query 					= $conn->query("SELECT `id` FROM `tv_series_files` WHERE `server_id` = '".$show['server_id']."' AND `tv_series_id` = '".$show['id']."' AND `file_location` = '".$file_location."'  ");
					$show_file 				= $query->fetch(PDO::FETCH_ASSOC);

					if(!isset($show_file['id'])){

						$plot 					= '';
						$year 					= '';
						$rating 				= '';
						$cover_photo 			= '';
						$release_date 			= '';

						$path_bits 				= explode("/", $file_location);
						$reverse_path_bits 		= array_reverse($path_bits);
						$filename 				= $reverse_path_bits[0];

						console_output(" - New File: " . stripslashes($filename));

						// get filename
						if(preg_match("'^(.+)\.S([0-9]+)E([0-9]+).*$'i",$filename,$n)){
						    $show['name'] 		= preg_replace("'\.'"," ",$n[1]);
						    $show['season'] 	= intval($n[2],10);
						    $show['episode'] 	= intval($n[3],10);
						}else{
							$show['season'] 	= '';
							$show['episode'] 	= '';
						}

						if(isset($show['name']) && isset($show['season']) && isset($show['episode'])){
							console_output(" - - Getting metadata");
							$url = 'http://www.omdbapi.com/?apikey=19354e2e&t&t='.urlencode($show['name']).'&Season='.urlencode($show['season']).'&Episode='.urlencode($show['episode']);
						    $curl = curl_init();
						    curl_setopt($curl, CURLOPT_URL, $url);
						    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
						    curl_setopt($curl, CURLOPT_HEADER, false);
						    $metadata = curl_exec($curl);
						    curl_close($curl);

						    $metadata = json_decode($metadata, true);

						    if($metadata['Response'] == True || $metadata['Response'] == 'True'){
						        if(isset($metadata['Title'])){
						        	$name           = addslashes($metadata['Title']);
						        }

						        if(isset($metadata['Plot'])){
						        	$plot           = addslashes($metadata['Plot']);
						        }

						        if(isset($metadata['Year'])){
						        	$year           = addslashes($metadata['Year']);
						        }

						        if(isset($metadata['Rated'])){
						        	$rated           = addslashes($metadata['Rated']);
						        }

						        if(isset($metadata['Released'])){
						        	$release_date	= addslashes($metadata['Released']);
						        }

						        if(isset($metadata['Poster'])){
						        	$cover_photo    = addslashes($metadata['Poster']);
						        }
						    }else{
						    	$name = $key;
						    }
						}

						// get next number in the order
						/*
						$query = $conn->query("SELECT `order` FROM `tv_series_files` WHERE `tv_series_id` = '".$show['id']."' ORDER BY `order` DESC LIMIT 1");
						$bits = $query->fetch(PDO::FETCH_ASSOC);
						if(isset($bits['order'])) {
							$next_order = ($bits['order'] + 1);
						}else{
							$next_order = 0;
						}
						*/
							
						// add input stream
						$insert = $conn->exec("INSERT IGNORE INTO `tv_series_files` 
					        (`user_id`,`server_id`,`tv_series_id`,`name`,`file_location`,`year`,`rating`,`release_date`,`plot`,`cover_photo`,`season`,`episode`)
					        VALUE
					        ('".$show['user_id']."',
					        '".$show['server_id']."',
					        '".$show['id']."',
					        '".$name."',
					        '".$file_location."',
					        '".$year."',
					        '".$rating."',
					        '".$release_date."',
					        '".$plot."',
					        '".$cover_photo."',
					        '".$show['season']."',
					        '".$show['episode']."'
					    )");
					}
				}
			}

			sleep(2);
		}
	}else{
		console_output("No TV series to scan.");
	}

	console_output("Finished.");
}