<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('UTC');

session_start();

include("inc/db.php");
include("inc/global_vars.php");
include("inc/functions.php");

$a = $_GET['a'];

switch ($a)
{
	// test
	case "test":
		test();
		break;

	// global_settings
	case "global_settings":
		global_settings();
		break;

	case "accept_terms":
		accept_terms();
		break;

	// customer functions
	case "customer_add":
		customer_add();
		break;

	case "customer_update":
		customer_update();
		break;

	case "customer_multi_options":
		customer_multi_options();
		break;

	case "customer_delete":
		customer_delete();
		break;

	// my_account_update
	case "my_account_update":
		my_account_update();
		break;

	// get members
	case "ajax_members":
		ajax_members();
		break;

	// get products
	case "ajax_products":
		ajax_products();
		break;

	// get withdrawal requests
	case "ajax_withdrawal_requests":
		ajax_withdrawal_requests();
		break;

	case "withdrawal_request_status":
		withdrawal_request_status();
		break;

	case "ajax_withdrawals":
		ajax_withdrawals();
		break;

	// get member commissions
	case "ajax_member_commissions":
		ajax_member_commissions();
		break;

	case "ajax_commissions":
		ajax_commissions();
		break;

	case "ajax_all_commissions":
		ajax_all_commissions();
		break;

	// get downline table_downline
	case "ajax_downline":
		ajax_downline();
		break;

	// commissions
	case "commission_approve":
		commission_approve();
		break;

	case "commissions_approve_all":
		commissions_approve_all();
		break;

	case "commission_reset":
		commission_reset();
		break;

	case "commission_reject":
		commission_reject();
		break;

	case "member_update":
		member_update();
		break;

	case "withdrawal_request_add":
		withdrawal_request_add();
		break;

	case "withdrawal_request_cancel":
		withdrawal_request_cancel();
		break;

	case "product_image_upload":
		product_image_upload();
		break;

	case "product_image_delete":
		product_image_delete();
		break;

	case "product_update":
		product_update();
		break;

	case "product_linked_add":
		product_linked_add();
		break;

	case "product_linked_delete":
		product_linked_delete();
		break;

	case "product_linked_delete":
		product_linked_delete();
		break;

	case "faq_add":
		faq_add();
		break;

	case "faq_update":
		faq_update();
		break;

	case "faq_delete":
		faq_delete();
		break;

// default		
	default:
		home();
		break;
}

function home(){
	die('access denied to function name ' . $_GET['a']);
}

function test(){
	echo exec('whoami');
	echo "<hr>";
	echo '<h3>$_SESSION</h3>';
	echo '<pre>';
	print_r($_SESSION);
	echo '</pre>';
	echo '<hr>';
	echo '<h3>$_POST</h3>';
	echo '<pre>';
	print_r($_POST);
	echo '</pre>';
	echo '<hr>';
	echo '<h3>$_GET</h3>';
	echo '<pre>';
	print_r($_GET);
	echo '</pre>';
	echo '<hr>';

	$json = '"{\"cmd\":\"hts       1952 28.1  2.7 3573956 445384 ?      Ssl  Mar14 878:22 /usr/bin/tvheadend -f -u hts -g video\",\"pid\":\"1952\",\"uptime\":\"878:22\",\"playlist\":\"#EXTM3U\n#EXTINF:-1 tvg-id=\"c6b36ed00191cc357390175faa9c02ce\",BT Sport 1 HD\nhttp://localhost:9981/stream/channelid/1349432262?ticket=E7311857FB5AF3096B32C7969EC43FA1D5BE4DB8&profile=webtv-h264-aac-matroska\n#EXTINF:-1 tvg-id=\"075a033c0feb7e38f00ac80b5398732f\",BT Sport ESPN HD\nhttp://localhost:9981/stream/channelid/1006852615?ticket=2333D14D30F12F7BE3749F2ACB9173FB96FC8D1A&profile=webtv-h264-aac-matroska\n#EXTINF:-1 tvg-id=\"8c6980463aa059c8d1b2eb8d3779a15f\",Eurosport 5HD\nhttp://localhost:9981/stream/channelid/1182820748?ticket=16F55C2A94DAF6B11A666E134B0AC4850422CBDC&profile=webtv-h264-aac-matroska\n#EXTINF:-1 tvg-id=\"96c64f32569c1016b0a345c150d96cdc\",Freesports HD\nhttp://localhost:9981/stream/channelid/844088982?ticket=B505BEAE6456C56AAB32DA0EDB24F9C74EDFE7AE&profile=webtv-h264-aac-matroska\n#EXTINF:-1 tvg-id=\"dd801366afb7860974c87df65568089a\",GOLD HD\nhttp://localhost:9981/stream/channelid/1712554205?ticket=702BD4F98C4E194CD63071FE6AE6C215321C312F&profile=webtv-h264-aac-matroska\n#EXTINF:-1 tvg-id=\"c60ccc45c80074df2201e541b3f9f672\",Liverpool FC TV\nhttp://localhost:9981/stream/channelid/1171000518?ticket=B70A5B91C67EFA7C0B13B0CF155B1B6B9DCE1A1D&profile=webtv-h264-aac-matroska\n#EXTINF:-1 tvg-id=\"3de40017906acfcc92055f30bbbadf63\",National GeographicHD\nhttp://localhost:9981/stream/channelid/385934397?ticket=79FDE7970DFBB44BCC5C40F00F8D29A48E063FBF&profile=webtv-h264-aac-matroska\n#EXTINF:-1 tvg-id=\"8a7082bf75c3899f43bf58bb10d27c96\",NHK World-Japan\nhttp://localhost:9981/stream/channelid/1065513098?ticket=E6731CBB28A727CDB05A7FE0DAC3FC1162AE0F16&profile=webtv-h264-aac-matroska\n#EXTINF:-1 tvg-id=\"25915bf3fc4575f4d066bb684b2d9939\",Old Channel 4HD\nhttp://localhost:9981/stream/channelid/1935380773?ticket=B53AF43FD2B9E4EDD361C98EBA6495E4AE0DBAFA&profile=webtv-h264-aac-matroska\n#EXTINF:-1 tvg-id=\"56735d2153c8c491b8f1c8fcada1b8cd\",Premier 1 HD\nhttp://localhost:9981/stream/channelid/559772502?ticket=E60F7E7F4E1EF6F720DE948513EDF9ED742BB314&profile=webtv-h264-aac-matroska\n#EXTINF:-1 tvg-id=\"e0bc8bcb250dc0106d07460a5758e314\",Sky 5* Movies HD\nhttp://localhost:9981/stream/channelid/1267449056?ticket=2233E71895378FC7F27BFB9008F8443FF67826F0&profile=webtv-h264-aac-matroska\n#EXTINF:-1 tvg-id=\"544a5694b9d27353cbeb00bd7ed2c0eb\",Sky Aliens HD\nhttp://localhost:9981/stream/channelid/341199444?ticket=6AEA7309F0596E2874D31C0E209FE074334A7C0C&profile=webtv-h264-aac-matroska\n#EXTINF:-1 tvg-id=\"cf3a9bacb0d2a94ab0ae5daf688f5b1d\",Sky Disney HD\nhttp://localhost:9981/stream/channelid/748370639?ticket=FC6B4EEFDAA713DA5AC241FC4CA321D696FBFAEB&profile=webtv-h264-aac-matroska\n#EXTINF:-1 tvg-id=\"665cd49dd0cd0fbe2f047630e12f4f22\",Sky One HD\nhttp://localhost:9981/stream/channelid/500456550?ticket=ED70D5526470C5D6E110860E6C93B88A31E6FF66&profile=webtv-h264-aac-matroska\n#EXTINF:-1 tvg-id=\"9d21d2b830da02b4c6f8becd36788478\",Sky Premiere HD\nhttp://localhost:9981/stream/channelid/953295261?ticket=435C144696B09DBA64481086DD47A6762A895FDC&profile=webtv-h264-aac-matroska\n#EXTINF:-1 tvg-id=\"dab63f70df9ef5c69ff172af785c080c\",vm0 - 682.75 - dvb-c/682.75MHz/{PMT:37}\nhttp://localhost:9981/stream/channelid/1883223770?ticket=6B9327EA5E6258642EFB3E9181974897F7AB847B&profile=webtv-h264-aac-matroska\n\",\"streams\":[{\"name\":\"BT Sport 1 HD\",\"stream_url\":\"http://localhost:9981/stream/channelid/1349432262\"},{\"name\":\"BT Sport ESPN HD\",\"stream_url\":\"http://localhost:9981/stream/channelid/1006852615\"},{\"name\":\"Eurosport 5HD\",\"stream_url\":\"http://localhost:9981/stream/channelid/1182820748\"},{\"name\":\"Freesports HD\",\"stream_url\":\"http://localhost:9981/stream/channelid/844088982\"},{\"name\":\"GOLD HD\",\"stream_url\":\"http://localhost:9981/stream/channelid/1712554205\"},{\"name\":\"Liverpool FC TV\",\"stream_url\":\"http://localhost:9981/stream/channelid/1171000518\"},{\"name\":\"National GeographicHD\",\"stream_url\":\"http://localhost:9981/stream/channelid/385934397\"},{\"name\":\"NHK World-Japan\",\"stream_url\":\"http://localhost:9981/stream/channelid/1065513098\"},{\"name\":\"Old Channel 4HD\",\"stream_url\":\"http://localhost:9981/stream/channelid/1935380773\"},{\"name\":\"Premier 1 HD\",\"stream_url\":\"http://localhost:9981/stream/channelid/559772502\"},{\"name\":\"Sky 5* Movies HD\",\"stream_url\":\"http://localhost:9981/stream/channelid/1267449056\"},{\"name\":\"Sky Aliens HD\",\"stream_url\":\"http://localhost:9981/stream/channelid/341199444\"},{\"name\":\"Sky Disney HD\",\"stream_url\":\"http://localhost:9981/stream/channelid/748370639\"},{\"name\":\"Sky One HD\",\"stream_url\":\"http://localhost:9981/stream/channelid/500456550\"},{\"name\":\"Sky Premiere HD\",\"stream_url\":\"http://localhost:9981/stream/channelid/953295261\"},{\"name\":\"vm0 - 682.75 - dvb-c/682.75MHz/{PMT:37}\",\"stream_url\":\"http://localhost:9981/stream/channelid/1883223770\"}]}"';

	$data = json_decode($json, true);
	$data = json_decode($data, true);

	echo '<pre>';
	print_r($data);
}

function global_settings()
{
	global $conn, $global_settings;

	$cms_domain_name 	= post('cms_domain_name');
	$cms_domain_name 	= addslashes($cms_domain_name);
	$cms_domain_name 	= trim($cms_domain_name);

	$cms_ip 			= post('cms_ip');
	$cms_ip 			= addslashes($cms_ip);
	$cms_ip 			= trim($cms_ip);

	$cms_name 			= post('cms_name');
	$cms_name 			= addslashes($cms_name);
	$cms_name 			= trim($cms_name);
	if(empty($cms_name)){
		$cms_name = 'SlipStream CMS';
	}

	$master_token 		= post('master_token');
	$master_token 		= addslashes($master_token);
	$master_token 		= trim($master_token);
	$master_token 		= preg_replace("/[^a-zA-Z0-9]+/", "", $master_token);
	if(empty($master_token)){
		$master_token = md5(time());
	}

	$update = $conn->exec("UPDATE `global_settings` SET `config_value` = '".$cms_domain_name."' 	WHERE `config_name` = 'cms_domain_name' ");
	$update = $conn->exec("UPDATE `global_settings` SET `config_value` = '".$cms_ip."' 				WHERE `config_name` = 'cms_ip' ");
	$update = $conn->exec("UPDATE `global_settings` SET `config_value` = '".$cms_name."' 			WHERE `config_name` = 'cms_name' ");
	$update = $conn->exec("UPDATE `global_settings` SET `config_value` = '".$master_token."' 		WHERE `config_name` = 'master_token' ");

	// echo '<pre>';
	// print_r($_POST);
	// echo '</pre>';

    // log_add("[".$name."] has been updated.");
    status_message('success',"Global settings have been updated.");
    go($_SERVER['HTTP_REFERER']);
}

function server_delete()
{
	global $conn, $global_settings;

	$server_id = get('server_id');

	// check if server is owned by this user
	$query = $conn->query("SELECT `id` FROM `headend_servers` WHERE `id` = '".$server_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	if($query !== FALSE) {
		// this user owns this server

		// define tables to delete from
		$tables = array('capture_devices','capture_devices_audio','cdn_streams_servers','headend_server_logs','jobs','streams_acl_rules','streams_connection_logs','vod_watch','vod');

		// loop through working tables
		foreach ($tables as $table) {
			$query = $conn->query("DELETE FROM `".$table."` WHERE `server_id` = '".$server_id."' ");
		}

		// delete primary record
		$delete = $conn->query("DELETE FROM `headend_servers` WHERE `id` = '".$server_id."' ");

		// log and wrap up
		// log_add("Server Deleted:");
    	status_message('success',"Server has been deleted from SlipStream. Please remember to delete the files from the server in /root/slipstream");
    	// return user to previous page
    	go($_SERVER['HTTP_REFERER']);
	}else{
		// this user DOES NOT own this server
		// log_add("Server Delete Fail: You dont own this server.");
    	status_message('danger',"It appears you do not own this server. This security breach has been reported.");
    	go($_SERVER['HTTP_REFERER']);
	}
}

function ajax_headends()
{
	global $conn, $global_settings;

	header("Content-Type:application/json; charset=utf-8");

	$query = $conn->query("SELECT * FROM `headend_servers` WHERE `user_id` = '".$_SESSION['account']['id']."' ");
	if($query !== FALSE) {
		$headends = $query->fetchAll(PDO::FETCH_ASSOC);

		$count = 0;

		foreach($headends as $headend) {
			$output[$count] = $headend;
			
			// convert seconds to human readable format
			$output[$count]['uptime'] = uptime($headend['uptime']);

			// convert bandwidth to mbit
			$output[$count]['bandwidth_down'] 		= number_format($headend['bandwidth_down'] / 125, 0);
			$output[$count]['bandwidth_up'] 		= number_format($headend['bandwidth_up'] / 125, 0);

			// get source details
			$query = $conn->query("SELECT * FROM `capture_devices` WHERE `server_id` = '".$headend['id']."' ORDER BY `name` ASC");
			if($query !== FALSE) {
				$output[$count]['sources'] = $query->fetchAll(PDO::FETCH_ASSOC);
				$output[$count]['total_sources'] = count($output[$count]['sources']);
			}else{
				$output[$count]['total_sources'] = 0;
			}

			$count++;
		}

		$json = json_encode($output);

		echo $json;
	}
}

function ajax_headend()
{
	global $conn, $global_settings;

	header("Content-Type:application/json; charset=utf-8");

	$server_id = get('server_id');

	$output = array();

	$query = $conn->query("SELECT * FROM `headend_servers` WHERE `id` = '".$server_id."' ");
	if($query !== FALSE) {
		$headends = $query->fetchAll(PDO::FETCH_ASSOC);

		$count = 0;

		foreach($headends as $headend) {
			$output[$count] = $headend;
			
			// convert seconds to human readable format
			$output[$count]['uptime'] = uptime($headend['uptime']);

			// get source details
			$query = $conn->query("SELECT * FROM `capture_devices` WHERE `server_id` = '".$headend['id']."' ORDER BY `video_device` ASC");
			if($query !== FALSE) {
				$output[$count]['sources'] = $query->fetchAll(PDO::FETCH_ASSOC);
				$output[$count]['total_sources'] = count($output[$count]['sources']);
			}else{
				$output[$count]['total_sources'] = 0;
			}

			$output[$count]['nginx_stats'] = json_decode($headend['nginx_stats'], true);

			$output[$count]['astra_config_file'] = json_decode($headend['astra_config_file'], true);

			$output[$count]['gpu_stats'] = json_decode($headend['gpu_stats'], true);

			if(file_exists($output[$count]['mumudvb_config_file'])){
				$output[$count]['mumudvb_config_file'] = json_decode(file_get_contents($output[$count]['mumudvb_config_file']), true);
			}

			if(file_exists($output[$count]['tvheadend_config_file'])){
				$output[$count]['tvheadend_config_file'] = json_decode(file_get_contents($output[$count]['tvheadend_config_file']), true);
			}

			$count++;
		}

		$json = json_encode($output);

		echo $json;
	}
}

function headend_add()
{
	global $conn, $global_settings;

	header("Content-Type:application/json; charset=utf-8");

	$uuid 					= md5(time());

	$name 					= get('name');
	$name 					= addslashes($name);
	$name 					= trim($name);

	if(empty($name)){
		$name = 'Node Server';
	}

	// $ip_address 			= addslashes($_GET['ip_address']);
	// $ssh_port			= addslashes($_POST['ssh_port']);
	// $ssh_password 		= addslashes($_POST['ssh_password']);

	$insert = $conn->exec("INSERT INTO `headend_servers` 
        (`user_id`,`uuid`,`name`,`http_stream_port`)
        VALUE
        ('".$_SESSION['account']['id']."', '".$uuid."','".$name."','".$global_settings['cms_port']."')");
    
    $server_id = $conn->lastInsertId();

    if(!$insert) {
        // echo "\nPDO::errorInfo():\n";
        // print_r($conn->errorInfo());

        $data[0]['status'] 			= 'error';
    	$data[0]['error'] 			= $conn->errorInfo();
    }else{
    	//@file_get_contents($site['url']."actions.php?a=job_add&server_id=".$server_id."&job=install");
    	// log_add("[".$name."] has been added.");
    	status_message('success',"[".$name."] has been added and will be installed shortly.");
    	// go($_SERVER['HTTP_REFERER']);

    	$data[0]['status'] 			= 'added';
    	$data[0]['server_id'] 		= $server_id;
    	$data[0]['server_uuid'] 	= $uuid;
    }

    json_output($data);
}

function headend_update()
{
	global $conn, $global_settings;

	$server_id 			= $_POST['server_id'];
	$name 				= addslashes($_POST['name']);
	$name 				= trim($name);
	// $ssh_port			= addslashes($_POST['ssh_port']);
	// $ssh_password 		= addslashes($_POST['ssh_password']);
	$http_stream_port	= addslashes($_POST['http_stream_port']);
	$http_stream_port 	= trim($http_stream_port);

	$public_hostname	= addslashes($_POST['public_hostname']);
	$public_hostname	= trim($public_hostname);

	$update = $conn->exec("UPDATE `headend_servers` SET `name` = '".$name."' WHERE `id` = '".$server_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	// $update = $conn->exec("UPDATE `headend_servers` SET `ssh_port` = '".$ssh_port."' WHERE `id` = '".$server_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	// $update = $conn->exec("UPDATE `headend_servers` SET `ssh_password` = '".$ssh_password."' WHERE `id` = '".$server_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `headend_servers` SET `http_stream_port` = '".$http_stream_port."' WHERE `id` = '".$server_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `headend_servers` SET `public_hostname` = '".$public_hostname."' WHERE `id` = '".$server_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

	// echo '<pre>';
	// print_r($_POST);
	// echo '</pre>';

    // log_add("[".$name."] has been updated.");
    status_message('success',$name." has been updated.");
    go($_SERVER['HTTP_REFERER']);
}

function ajax_sources_audio()
{
	global $conn, $global_settings;

	$server_id = $_GET['server_id'];

	header("Content-Type:application/json; charset=utf-8");

	$query = $conn->query("SELECT * FROM `capture_devices_audio` WHERE `server_id` = '".$server_id."' ");
	if($query !== FALSE) {
		$sources = $query->fetchAll(PDO::FETCH_ASSOC);

		json_output($sources);
	}
}

function ajax_source_video()
{
	global $conn, $global_settings;

	$source_id = $_GET['source_id'];

	header("Content-Type:application/json; charset=utf-8");

	$query = $conn->query("SELECT * FROM `capture_devices` WHERE `id` = '".$source_id."' ");
	if($query !== FALSE) {
		$sources = $query->fetchAll(PDO::FETCH_ASSOC);

		json_output($sources);
	}
}

function ajax_streams_list()
{
	global $conn, $global_settings;

	$user_id = $_SESSION['account']['id'];

	header("Content-Type:application/json; charset=utf-8");

	function find_outputs($array, $key, $value){
	    $results = array();

	    if(is_array($array)){
	        if (isset($array[$key]) && $array[$key] == $value) {
	            $results[] = $array;
	        }

	        foreach($array as $subarray){
	            $results = array_merge($results, find_outputs($subarray, $key, $value));
	        }
	    }

	    return $results;
	}

	// get headend info
	$query = $conn->query("SELECT `id`,`name`,`wan_ip_address`,`status` FROM `headend_servers` WHERE `user_id` = '".$user_id."' ");
	$headends = $query->fetchAll(PDO::FETCH_ASSOC);

	// get stream categories
	$query = $conn->query("SELECT `id`,`name` FROM `stream_categories` WHERE `user_id` = '".$user_id."' ");
	$categories = $query->fetchAll(PDO::FETCH_ASSOC);

	// handle source_domain filter

	if(empty($_GET['source_domain'])){
		$source_domain_filter = '';
	}else{
		$source_domain_filter = "AND `source` LIKE '%".$_GET['source_domain']."%' ";
	}

	// get streams for this user
	if(empty($_GET['server_id']) || $_GET['server_id'] == 0){
		$query = $conn->query("SELECT `id`,`status`,`ondemand`,`enable`,`server_id`,`source`,`logo`,`name`,`stream_uptime`,`category_id`,`probe_bitrate`,`probe_video_codec`,`probe_audio_codec`,`probe_aspect_ratio`,`fps`,`speed`,`source_type`,`direct` FROM `streams` WHERE `user_id` = '".$user_id."' AND `stream_type` = 'input' " . $source_domain_filter);
		$streams_in = $query->fetchAll(PDO::FETCH_ASSOC);

		$query = $conn->query("SELECT `id`,`status`,`ondemand`,`enable`,`server_id`,`source_stream_id`,`source_server_id`,`name`,`stream_uptime`,`fps`,`speed`,`probe_bitrate`,`probe_video_codec`,`probe_audio_codec` FROM `streams` WHERE `user_id` = '".$user_id."' AND `stream_type` = 'output' " . $source_domain_filter);
		$streams_out = $query->fetchAll(PDO::FETCH_ASSOC);
	}else{
		$query = $conn->query("SELECT `id`,`status`,`ondemand`,`enable`,`server_id`,`source`,`logo`,`name`,`stream_uptime`,`category_id`,`probe_bitrate`,`probe_video_codec`,`probe_audio_codec`,`probe_aspect_ratio`,`fps`,`speed`,`source_type`,`direct` FROM `streams` WHERE `user_id` = '".$user_id."' AND `server_id` = '".$_GET['server_id']."' AND `stream_type` = 'input' " . $source_domain_filter);
		$streams_in = $query->fetchAll(PDO::FETCH_ASSOC);

		$query = $conn->query("SELECT `id`,`status`,`ondemand`,`enable`,`server_id`,`source_stream_id`,`source_server_id`,`name`,`stream_uptime`,`fps`,`speed`,`probe_bitrate`,`probe_video_codec`,`probe_audio_codec` FROM `streams` WHERE `user_id` = '".$user_id."' AND `server_id` = '".$_GET['server_id']."' AND `stream_type` = 'output' " . $source_domain_filter);
		$streams_out = $query->fetchAll(PDO::FETCH_ASSOC);
	}

	if(get('dev') == 'yes'){
		$dev['query_1'] = $query;
	}

	if($query !== FALSE) {
		$count = 0;

		foreach($streams_in as $stream) {
			$output[$count] 					= $stream;

			$output[$count]['checkbox']			= '<center><input type="checkbox" class="chk" id="checkbox_'.$stream['id'].'" name="stream_ids[]" value="'.$stream['id'].'" onclick="multi_options();"></center>';

			if(empty($stream['logo'])){
				$output[$count]['logo'] 		= '';
			}else{
				// $output[$count]['logo'] 		= '<center><img src="'.$stream['logo'].'" height="25px" alt="'.stripslashes($stream['name']).'"></center>';
				$output[$count]['logo'] 		= '';
			}

			$output[$count]['name'] 			= stripslashes($stream['name']);

			// get headend data
			foreach($headends as $headend) {
				if($headend['id'] == $stream['server_id']) {
					$output[$count]['server_name']			= stripslashes($headend['name']);
					break;
				}
			}

			// convert seconds to human readable time
			if(empty($stream['stream_uptime'])) {
				$output[$count]['stream_uptime'] 			= '00:00';
			}else{
				$output[$count]['stream_uptime'] 			= $stream['stream_uptime'];
			}

			$time_shift = time() - 20;

			$output[$count]['category_name'] = '';
			if(is_array($categories)) {
				foreach($categories as $category) {
					if($category['id'] == $stream['category_id']) {
						$output[$count]['category_name'] = $category['name'];
						break;
					}
				}
			}else{
				$output[$count]['category_name'] = '';
			}

			// $output[$count]['watermark_type']		= ucfirst($stream['watermark_type']);
			// $output[$count]['fingerprint']			= ucfirst($stream['fingerprint']);
			$output[$count]['watermark_type']		= '';
			$output[$count]['fingerprint']			= '';

			if($stream['source_type'] == 'direct'){
				$output[$count]['source_type']	= '<center><i class="fas fa-tv" title="Direct Source"><span class="hidden">Direct</span></i></center>';
			}elseif($stream['source_type'] == 'restream'){
				$output[$count]['source_type']	= '<center><i class="fas fa-sitemap" title="Restream Source"><span class="hidden">Restream</span></i></center>';
			}elseif($stream['source_type'] == 'cdn'){
				$output[$count]['source_type']	= '<center><i class="fas fa-server" title="CDN Source"><span class="hidden">CDN</span></i></center>';
			}

			if($stream['direct'] == 'yes'){
				$output[$count]['source_type']	= '<center><i class="fas fa-share" title="Direct to Source"><span class="hidden">Direct</span></i></center>';
			}

			// set some visual array items
			if($stream['status'] == 'online') {
		    	$output[$count]['visual_stream_status'] = '<small class="label bg-green full-width">Online</small>';
		    }elseif($headend['status'] == 'offline' && $stream['status'] == 'offline') {
		    	$output[$count]['visual_stream_status'] = '<small class="label bg-red full-width">Offline</small>';
		    	$output[$count]['fps']					= '';
		    	$output[$count]['stream_uptime']		= '';
		    	$output[$count]['probe_bitrate']		= '';
		    	$output[$count]['speed']				= '';
		    	$output[$count]['probe_bitrate']		= '';
		    	$output[$count]['probe_video_codec']	= '';
		    	$output[$count]['probe_audio_codec']	= '';
		    	$output[$count]['probe_aspect_ratio']	= '';
		    }elseif($stream['enable'] == 'yes' && $stream['status'] == 'offline' && $stream['ondemand'] == 'no') {
		    	$output[$count]['visual_stream_status'] = '<small class="label bg-orange full-width">Starting</small>';
		    	$output[$count]['fps']					= '';
		    	$output[$count]['stream_uptime']		= '';
		    	$output[$count]['probe_bitrate']		= '';
		    	$output[$count]['speed']				= '';
		    	$output[$count]['probe_bitrate']		= '';
		    	$output[$count]['probe_video_codec']	= '';
		    	$output[$count]['probe_audio_codec']	= '';
		    	$output[$count]['probe_aspect_ratio']	= '';
		    }elseif($stream['enable'] == 'yes' && $stream['status'] == 'offline' && $stream['ondemand'] == 'yes') {
		    	$output[$count]['visual_stream_status'] = '<small class="label bg-blue full-width">On-Demand</small>';
		    	$output[$count]['fps']					= '';
		    	$output[$count]['stream_uptime']		= '';
		    	$output[$count]['probe_bitrate']		= '';
		    	$output[$count]['speed']				= '';
		    	$output[$count]['probe_bitrate']		= '';
		    	$output[$count]['probe_video_codec']	= '';
		    	$output[$count]['probe_audio_codec']	= '';
		    	$output[$count]['probe_aspect_ratio']	= '';
		    }elseif($stream['enable'] == 'yes' && $stream['status'] == 'source_offline') {
		    	$output[$count]['visual_stream_status'] = '<small class="label bg-purple full-width">Source Offline</small>';
		    	$output[$count]['fps']					= '';
		    	$output[$count]['stream_uptime']		= '';
		    	$output[$count]['probe_bitrate']		= '';
		    	$output[$count]['speed']				= '';
		    	$output[$count]['probe_bitrate']		= '';
		    	$output[$count]['probe_video_codec']	= '';
		    	$output[$count]['probe_audio_codec']	= '';
		    	$output[$count]['probe_aspect_ratio']	= '';
		    }elseif($stream['enable'] == 'no' && $stream['status'] == 'offline') {
		    	$output[$count]['visual_stream_status'] = '<small class="label bg-red full-width">Stopped</small>';
		    	$output[$count]['fps']					= '';
		    	$output[$count]['stream_uptime']		= '';
		    	$output[$count]['probe_bitrate']		= '';
		    	$output[$count]['speed']				= '';
		    	$output[$count]['probe_bitrate']		= '';
		    	$output[$count]['probe_video_codec']	= '';
		    	$output[$count]['probe_audio_codec']	= '';
		    	$output[$count]['probe_aspect_ratio']	= '';
		    }elseif($stream['status'] == 'analysing') {
		    	$output[$count]['visual_stream_status'] = '<small class="label bg-orange full-width">Analysing</small>';
		    	$output[$count]['fps']					= '';
		    	$output[$count]['stream_uptime']		= '';
		    	$output[$count]['probe_bitrate']		= '';
		    	$output[$count]['speed']				= '';
		    	$output[$count]['probe_bitrate']		= '';
		    	$output[$count]['probe_video_codec']	= '';
		    	$output[$count]['probe_audio_codec']	= '';
		    	$output[$count]['probe_aspect_ratio']	= '';
		    }else{
		    	$output[$count]['visual_stream_status'] = '<small class="label bg-blue full-width">UNKNOWN</small>';
		    	$output[$count]['fps']					= '';
		    	$output[$count]['stream_uptime']		= '';
		    	$output[$count]['probe_bitrate']		= '';
		    	$output[$count]['speed']				= '';
		    	$output[$count]['probe_bitrate']		= '';
		    	$output[$count]['probe_video_codec']	= '';
		    	$output[$count]['probe_audio_codec']	= '';
		    	$output[$count]['probe_aspect_ratio']	= '';
		    }

		    if($output[$count]['direct'] == 'yes'){
		    	$output[$count]['visual_stream_status'] = '<small class="label bg-maroon full-width">Direct to Source</small>';
		    	$output[$count]['fps']					= '';
		    	$output[$count]['stream_uptime']		= '';
		    	$output[$count]['probe_bitrate']		= '';
		    	$output[$count]['speed']				= '';
		    	$output[$count]['probe_bitrate']		= '';
		    	$output[$count]['probe_video_codec']	= '';
		    	$output[$count]['probe_audio_codec']	= '';
		    	$output[$count]['probe_aspect_ratio']	= '';
		    }

		    $output[$count]['visual_source_stream_start'] 	= '';
		    $output[$count]['visual_source_stream_stop']	= '';
		    $output[$count]['visual_source_stream_restart']	= '';

		    if($stream['enable'] == 'no'){
				$output[$count]['visual_source_stream_start']	= '
				<a title="Start Stream" class="btn btn-success btn-xs btn-flat" href="actions.php?a=stream_start&stream_id='.$stream['id'].'">Start</i></a>';
		    }elseif($stream['enable'] == 'yes' && $stream['ondemand'] == 'yes'){
		    	
		    }elseif($stream['enable'] == 'yes' && $stream['status'] == 'offline'){
		    	$output[$count]['visual_source_stream_start']	= '
				<a title="Start Stream" class="btn btn-success btn-xs btn-flat" href="actions.php?a=stream_start&stream_id='.$stream['id'].'">Start</i></a>';

		    	$output[$count]['visual_source_stream_stop'] 	= '
		    	<a title="Stop Stream" class="btn btn-danger btn-xs btn-flat" onclick="return confirm(\'Please allow up to 60 seconds for stream to stop.\')" href="actions.php?a=stream_stop&stream_id='.$stream['id'].'">Stop</a>';

		    	$output[$count]['visual_source_stream_restart'] = '
		    	<a title="Restart Stream" class="btn btn-warning btn-xs btn-flat" href="actions.php?a=stream_restart&stream_id='.$stream['id'].'">Restart</i></a>';
		    }elseif($stream['enable'] == 'yes' && $stream['status'] == 'source_offline'){
		    	$output[$count]['visual_source_stream_stop'] 	= '
		    	<a title="Stop Stream" class="btn btn-danger btn-xs btn-flat" onclick="return confirm(\'Please allow up to 60 seconds for stream to stop.\')" href="actions.php?a=stream_stop&stream_id='.$stream['id'].'">Stop</a>';

		    	$output[$count]['visual_source_stream_restart'] = '
		    	<a title="Restart Stream" class="btn btn-warning btn-xs btn-flat" href="actions.php?a=stream_restart&stream_id='.$stream['id'].'">Restart</i></a>';
		    }elseif($stream['enable'] == 'yes' && $stream['status'] == 'online'){
		    	$output[$count]['visual_source_stream_stop'] 	= '
		    	<a title="Stop Stream" class="btn btn-danger btn-xs btn-flat" onclick="return confirm(\'Please allow up to 60 seconds for stream to stop.\')" href="actions.php?a=stream_stop&stream_id='.$stream['id'].'">Stop</a>';

		    	$output[$count]['visual_source_stream_restart'] = '
		    	<a title="Restart Stream" class="btn btn-warning btn-xs btn-flat" href="actions.php?a=stream_restart&stream_id='.$stream['id'].'">Restart</i></a>';
		    }elseif($stream['enable'] == 'yes' && $stream['status'] == 'analysing'){
		    	$output[$count]['visual_source_stream_stop'] 	= '
		    	<a title="Stop Stream" class="btn btn-danger btn-xs btn-flat" onclick="return confirm(\'Please allow up to 60 seconds for stream to stop.\')" href="actions.php?a=stream_stop&stream_id='.$stream['id'].'">Stop</a>';

		    }

		    if($headend['status'] == 'offline'){
		    	// $output[$count]['visual_source_stream_start'] 	= '';
		    	$output[$count]['visual_source_stream_stop']	= '';
		    	$output[$count]['visual_source_stream_restart']	= '';
		    }

		    if($stream['direct'] == 'yes'){
		    	$output[$count]['visual_source_stream_start'] 	= '';
		    	$output[$count]['visual_source_stream_stop']	= '';
		    	$output[$count]['visual_source_stream_restart']	= '';
		    }

		    $output[$count]['visual_source_stream_edit'] ='<a title="Edit Stream" class="btn btn-info btn-xs btn-flat" href="dashboard.php?c=stream&stream_id='.$stream['id'].'">Edit</a>';
		    $output[$count]['visual_source_stream_delete'] ='<a title="Delete Stream" class="btn btn-danger btn-xs btn-flat" href="actions.php?a=stream_delete&stream_id='.$stream['id'].'" onclick="return confirm(\'Are you sure?\')">Delete</a>';

		    // convert bits to megabit for bitrate
		    if($stream['status'] == 'online'){
		    	if(is_numeric($stream['probe_bitrate'])){
		    		$output[$count]['bitrate'] 			= number_format(($stream['probe_bitrate'] / 1e+6), 2).' Mbit';
		    	}else{
		    		$output[$count]['bitrate'] 			= '0 Mbit';
		    	}
		    	$output[$count]['probe_video_codec'] 	= strtoupper($stream['probe_video_codec']);
		    	$output[$count]['probe_audio_codec'] 	= strtoupper($stream['probe_audio_codec']);
		    }else{
		    	$output[$count]['bitrate'] 				= '';
		    	$output[$count]['probe_video_codec'] 	= '';
		    	$output[$count]['probe_audio_codec'] 	= '';
		    }

		    if($stream['direct'] == 'yes'){
		    	$output[$count]['bitrate'] 				= '';
		    	$output[$count]['probe_video_codec'] 	= '';
		    	$output[$count]['probe_audio_codec'] 	= '';
		    }

			$output[$count]['output_streams'] 			= '';
			$output_stream['output_streams'] 			= '';

			// echo "Found " . array_search("#0000cc", $data);

			$output_streams = find_outputs($streams_out, 'source_stream_id', $stream['id']);
			
			if(is_array($output_streams)){
				// number of output streams
				$output[$count]['total_output_streams'] 				= count($output_streams);
				$output[$count]['total_outputs']						= $output[$count]['total_output_streams'];

				foreach($output_streams as $output_stream){
					$output[$count]['output_streams'] .= '<tr>';

					// get headend data
					foreach($headends as $headend) {
						if($headend['id'] == $output_stream['server_id']) {
							$output_stream['server_name']				= stripslashes($headend['name']);
							break;
						}
					}

					if(empty($output_stream['server_name'])){
						$output_stream['server_name'] = 'Main Server';
					}

					$output_stream['visual_output_stream_status'] 		= '';
					$output_stream['web_player']						= '';
					if($output_stream['status'] == 'online'){
						$output_stream['web_player']					= '<button title="WebPlayer" type="button" class="btn btn-primary btn-flat btn-xs" data-toggle="modal" data-target="#web_player" onclick="new_web_player_iframe_source('.$output_stream['id'].')"><i class="fa fa-tv" aria-hidden="true"></i></button>';
						$output_stream['visual_output_stream_status'] 	= '<small class="label bg-green full-width">Online</small>';
					}elseif($headend['status'] == 'offline' && $output_stream['status'] == 'offline') {
				    	$output_stream['visual_output_stream_status'] 	= '<small class="label bg-red full-width">Offline</small>';
				    	$output_stream['fps']							= '';
				    	$output_stream['stream_uptime']					= '';
				    	$output_stream['probe_bitrate']					= '';
				    	$output_stream['speed']							= '';
				    	$output_stream['probe_bitrate']					= '';
				    	$output_stream['probe_video_codec']				= '';
				    	$output_stream['probe_audio_codec']				= '';
				    	$output_stream['probe_aspect_ratio']			= '';
				    }elseif($output_stream['enable'] == 'yes' && $output_stream['status'] == 'offline' && $stream['ondemand'] == 'no') {
				    	$output_stream['visual_output_stream_status'] 	= '<small class="label bg-orange full-width">Restarting</small>';
				    	$output_stream['fps']							= '';
				    	$output_stream['stream_uptime']					= '';
				    	$output_stream['probe_bitrate']					= '';
				    	$output_stream['speed']							= '';
				    	$output_stream['probe_bitrate']					= '';
				    	$output_stream['probe_video_codec']				= '';
				    	$output_stream['probe_audio_codec']				= '';
				    	$output_stream['probe_aspect_ratio']			= '';
				    }elseif($output_stream['enable'] == 'yes' && $output_stream['status'] == 'offline' && $stream['ondemand'] == 'yes'){
				    	$output_stream['visual_output_stream_status'] 	= '<small class="label bg-blue full-width">On-Demand</small>';
				    	$output_stream['fps']							= '';
				    	$output_stream['stream_uptime']					= '';
				    	$output_stream['probe_bitrate']					= '';
				    	$output_stream['speed']							= '';
				    	$output_stream['probe_bitrate']					= '';
				    	$output_stream['probe_video_codec']				= '';
				    	$output_stream['probe_audio_codec']				= '';
				    	$output_stream['probe_aspect_ratio']			= '';
				    }elseif($output_stream['enable'] == 'no' && $output_stream['status'] == 'offline') {
				    	$output_stream['visual_output_stream_status'] 	= '<small class="label bg-red full-width">Stopped</small>';
				    	$output_stream['fps']							= '';
				    	$output_stream['stream_uptime']					= '';
				    	$output_stream['probe_bitrate']					= '';
				    	$output_stream['speed']							= '';
				    	$output_stream['probe_bitrate']					= '';
				    	$output_stream['probe_video_codec']				= '';
				    	$output_stream['probe_audio_codec']				= '';
				    	$output_stream['probe_aspect_ratio']			= '';
				    }elseif($output_stream['status'] == 'analysing') {
				    	$output_stream['visual_output_stream_status'] 	= '<small class="label bg-orange full-width">Analysing</small>';
				    	$output_stream['fps']							= '';
				    	$output_stream['stream_uptime']					= '';
				    	$output_stream['probe_bitrate']					= '';
				    	$output_stream['speed']							= '';
				    	$output_stream['probe_bitrate']					= '';
				    	$output_stream['probe_video_codec']				= '';
				    	$output_stream['probe_audio_codec']				= '';
				    	$output_stream['probe_aspect_ratio']			= '';
				    }else{
				    	$output_stream['visual_output_stream_status'] 	= '<small class="label bg-blue full-width">UNKNOWN</small>';
				    	$output_stream['fps']							= '';
				    	$output_stream['stream_uptime']					= '';
				    	$output_stream['probe_bitrate']					= '';
				    	$output_stream['speed']							= '';
				    	$output_stream['probe_bitrate']					= '';
				    	$output_stream['probe_video_codec']				= '';
				    	$output_stream['probe_audio_codec']				= '';
				    	$output_stream['probe_aspect_ratio']			= '';
				    }

				    if($stream['direct'] == 'yes'){
				    	$output_stream['visual_output_stream_status'] 	= '';
				    	$output_stream['fps']							= '';
				    	$output_stream['stream_uptime']					= '';
				    	$output_stream['probe_bitrate']					= '';
				    	$output_stream['speed']							= '';
				    	$output_stream['probe_bitrate']					= '';
				    	$output_stream['probe_video_codec']				= '';
				    	$output_stream['probe_audio_codec']				= '';
				    	$output_stream['probe_aspect_ratio']			= '';

				    	$output_stream['visual_output_stream_start'] 	= '';
				    	$output_stream['visual_output_stream_stop']		= '';
				    	$output_stream['visual_output_stream_restart']	= '';

				    	$output_stream['visual_output_stream_edit']		= '';
				    	$output_stream['visual_output_stream_delete']	= '';

				    	$output[$count]['output_streams'] .= '<td colspan="15">This is a Direct to source configured stream. All output options have been disabled.</td>';

						$output[$count]['output_streams'] .= '</tr>';

				    }else{

					    $output_stream['visual_output_stream_start'] 	= '';
					    $output_stream['visual_output_stream_stop']		= '';
					    $output_stream['visual_output_stream_restart']	= '';

					    $output_stream['visual_output_stream_edit'] ='<a title="Edit Stream" class="btn btn-info btn-xs btn-flat" href="dashboard.php?c=stream&stream_id='.$output_stream['id'].'">Edit</a>';
					    $output_stream['visual_output_stream_delete'] ='<a title="Delete Stream" class="btn btn-danger btn-xs btn-flat" href="actions.php?a=stream_delete&stream_id='.$output_stream['id'].'" onclick="return confirm(\'Are you sure?\')">Delete</a>';

					    $output[$count]['output_streams'] .= '<td width="1px" style="white-space: nowrap;"><strong>Status:</strong></td>';
						$output[$count]['output_streams'] .= '<td width="1px">'.$output_stream['visual_output_stream_status'].'</td>';

						$output[$count]['output_streams'] .= '<td width="1px" style="white-space: nowrap;"><strong>Name:</strong></td>';
						$output[$count]['output_streams'] .= '<td>'.stripslashes($output_stream['name']).'</td>';

						$output[$count]['output_streams'] .= '<td></td>';
						$output[$count]['output_streams'] .= '<td></td>';

						if($output_stream['status'] == 'online'){
							// get online clients for this stream
							$time_shift = time() - 60;
							$query = $conn->query("SELECT `id` FROM `streams_connection_logs` WHERE `stream_id` = '".$output_stream['id']."' AND `timestamp` > '".$time_shift."' GROUP BY 'client_ip' ");
							$output_stream['online_clients'] = $query->fetchAll(PDO::FETCH_ASSOC);
							$output_stream['total_online_clients'] = count($output_stream['online_clients']);
							// $output_stream['total_online_clients'] = 0;

							$output[$count]['output_streams'] .= '<td></td>';
							$output[$count]['output_streams'] .= '<td></td>';
							$output[$count]['output_streams'] .= '<td width="1px" style="white-space: nowrap;"><strong>FPS:</strong></td>';
							$output[$count]['output_streams'] .= '<td width="1px">'.(empty($output_stream['fps'])?$stream['fps']:stripslashes($output_stream['fps'])).'</td>';
							$output[$count]['output_streams'] .= '<td width="1px" style="white-space: nowrap;"><strong>Bitrate:</strong></td>';
							if(is_numeric($output_stream['probe_bitrate'])) {
								$output[$count]['output_streams'] .= '<td>'.number_format(($output_stream['probe_bitrate'] / 1e+6), 2).' Mbit</td>';
							}else{
								$output[$count]['output_streams'] .= '<td>N/A</td>';
							}
							$output[$count]['output_streams'] .= '<td width="1px" style="white-space: nowrap;"><strong>Conn:</strong></td>';
							$output[$count]['output_streams'] .= '<td>'.$output_stream['total_online_clients'].'</td>';
						}else{
							$output[$count]['output_streams'] .= '<td></td>';
							$output[$count]['output_streams'] .= '<td></td>';
							$output[$count]['output_streams'] .= '<td></td>';
							$output[$count]['output_streams'] .= '<td></td>';
							$output[$count]['output_streams'] .= '<td></td>';
							$output[$count]['output_streams'] .= '<td></td>';
							$output[$count]['output_streams'] .= '<td></td>';
							$output[$count]['output_streams'] .= '<td></td>';
						}

						$output[$count]['output_streams'] .= '
						<td width="150px" class="text-right">'.$output_stream['web_player'].''.$output_stream['visual_output_stream_start'].''.$output_stream['visual_output_stream_stop'].''.$output_stream['visual_output_stream_restart'].''.$output_stream['visual_output_stream_edit'].''.$output_stream['visual_output_stream_delete'].'</td>';

						$output[$count]['output_streams'] .= '</tr>';
					}
				}
			}

			$count++;
		}

		// $json_out = json_encode(array_values($your_array_here));

		// $output = array_values($output);
		// $data['data'] = $output;

		if(isset($output)) {
			$data['data'] = array_values($output);
		}else{
			$data['data'] = array();
		}

		if(get('dev') == 'yes'){
			$data['dev'] = $dev;
		}

		json_output($data);
	}
}

function job_add()
{
	global $conn, $global_settings;


	$server_id 			= addslashes($_GET['server_id']);
	$headend 			= @file_get_contents($site['url']."actions.php?a=ajax_headend&server_id=".$server_id);
	$job 				= addslashes($_GET['job']);

	if($job == 'reboot') {
		$data['action'] = 'reboot';
		$data['command'] = '/sbin/reboot';
		// example: {"action":"kill_pid","command":"kill -9 12748"}
	}

	$insert = $conn->exec("INSERT INTO `jobs` 
        (`server_id`,`job`)
        VALUE
        ('".$server_id."','".json_encode($data)."')");
    
    if(!$insert) {
        echo "\nPDO::errorInfo():\n";
        print_r($conn->errorInfo());
    }else{
    	if($job == 'reboot') {
    		// log_add("[".$headend['name']."] rebooting.");
			status_message('success',"[".$headend['name']."] will be rebooted shortly.");
		}

    	go($_SERVER['HTTP_REFERER']);
    }
}

function ajax_logs()
{
	global $conn, $global_settings;

	header("Content-Type:application/json; charset=utf-8");

	$query = $conn->query("SELECT * FROM `logs` WHERE `user_id` = '".$_SESSION['account']['id']."' ORDER BY `id` DESC");
	if($query !== FALSE) {
	    $logs = $query->fetchAll(PDO::FETCH_ASSOC);
	    $count = 0;
		foreach($logs as $log) {
			$output[$count]['added'] = date("M, jS Y H:i:s", $log['added']);
			$output[$count]['message'] = stripslashes($log['message']);
			$count++;
		}
	} else {
	   $output = '';
	}

	$json = json_encode($output);

	echo $json;
}

function source_update()
{
	global $conn, $global_settings;

	$source_id 						= $_POST['source_id'];

	$data['source_id']				= $_POST['source_id'];
	$data['name'] 					= addslashes($_POST['name']);
	$data['enable']					= addslashes($_POST['enable']);
	$data['video_codec'] 			= addslashes($_POST['video_codec']);
	$data['framerate_in'] 			= addslashes($_POST['framerate_in']);
	$data['framerate_out'] 			= addslashes($_POST['framerate_out']);
	$data['screen_resolution'] 		= addslashes($_POST['screen_resolution']);
	$data['audio_device'] 			= addslashes($_POST['audio_device']);
	$data['audio_codec'] 			= addslashes($_POST['audio_codec']);
	$data['audio_bitrate'] 			= addslashes($_POST['audio_bitrate']);
	$data['audio_sample_rate'] 		= addslashes($_POST['audio_sample_rate']);
	$data['bitrate'] 				= addslashes($_POST['bitrate']);
	$data['output_type'] 			= addslashes($_POST['output_type']);
	$data['rtmp_server'] 			= addslashes($_POST['rtmp_server']);
	$data['watermark_type'] 		= addslashes($_POST['watermark_type']);
	$data['watermark_image'] 		= addslashes($_POST['watermark_image']);
	$data['rtmp_server'] 			= addslashes($_POST['rtmp_server']);
	$data['rtmp_server'] 			= addslashes($_POST['rtmp_server']);

	foreach($data as $key => $value) {
		// echo $key . " -> " . $value . '<br>';
		$update = $conn->exec("UPDATE `capture_devices` SET `".$key."` = '".$value."' WHERE `id` = '".$source_id."' ");
	}
	
    // log_add("[".$_POST['video_device']."] has been updated.");
    status_message('success',"[".$_POST['video_device']."] has been updated.");
    go($_SERVER['HTTP_REFERER']);
}

function source_stop()
{
	global $conn, $global_settings;

	$source_id = get('source_id');

	$update = $conn->exec("UPDATE `capture_devices` SET `enable` = 'no' WHERE `id` = '".$source_id."' ");
	
    // log_add("Streaming has been stopped.");
}

function source_start()
{
	global $conn, $global_settings;

	$source_id = get('source_id');

	$update = $conn->exec("UPDATE `capture_devices` SET `enable` = 'yes' WHERE `id` = '".$source_id."' ");
	
    // log_add("Streaming has been started.");
}

function source_scan()
{
	global $conn, $global_settings;

	$source_id = $_GET['source_id'];

	$query = $conn->query("SELECT * FROM `capture_devices` WHERE `id` = '".$source_id."' ");
	$source = $query->fetchAll(PDO::FETCH_ASSOC);

	// confirm this is a dvb card
	if($source[0]['type'] == 'dvb_card') {
		// $query = $conn->query("SELECT * FROM `headend_servers` WHERE `id` = '".$source[0]['server_id']."' ");
		// $headend = $query->fetchAll(PDO::FETCH_ASSOC);

		$adapter_name_short = str_replace('adapter', '', $source[0]['video_device']);

		$job['action'] = 'source_scan';
		if($source[0]['dvb_type'] == 'dvbt') {
			$job['command'] = 'w_scan -X -a'.$adapter_name_short.' -c GB > /root/slipstream/node/config/channel_scan/'.$source[0]['video_device'].'.conf';
		}
		$job['source'] = $source[0]['video_device'];

		$job = json_encode($job);

		$insert = $conn->exec("INSERT INTO `jobs` 
	        (`server_id`,`job`)
	        VALUE
	        ('".$source[0]['server_id']."','".$job."')");

		// log_add("Channel scan has been started.");
	}else{
		// log_add("ERROR: This device is not a valid DVB card.");
	}
}

function ajax_stream()
{
	global $conn, $global_settings;

	header("Content-Type:application/json; charset=utf-8");

	$stream_id = get('stream_id');

	$output = array();

	$query = $conn->query("SELECT * FROM `streams` WHERE `id` = '".$stream_id."' ");
	if($query !== FALSE) {
		$streams = $query->fetchAll(PDO::FETCH_ASSOC);

		$count = 0;

		foreach($streams as $stream) {
			$output[$count] = $stream;
			
			// $output[$count]['output_options'] = json_decode($stream['output_options'], true);

			$count++;
		}

		$json = json_encode($output);

		echo $json;
	}
}

function stream_update()
{
	global $conn, $global_settings;

	$stream_id 								= addslashes($_POST['stream_id']);

	$data['enable']							= addslashes($_POST['enable']);

	$data['name'] 							= addslashes(post('name'));
	$data['name']							= trim($data['name']);
	
	$data['server_id']						= addslashes($_POST['server_id']);

	$data['user_agent'] 					= addslashes(post('user_agent'));
	$data['user_agent']						= trim($data['user_agent']);

	$data['ffmpeg_re']						= addslashes($_POST['ffmpeg_re']);

	$data['direct']							= addslashes($_POST['direct']);
	
	if($_POST['stream_type'] == 'input') {
		// $data['source']						= addslashes($_POST['source']);
		// $data['source']						= trim($data['source']);

		$data['category_id']				= addslashes(post('category_id'));

		$data['source_type']				= addslashes(post('source_type'));

		$data['logo']						= addslashes(post('logo'));
		$data['logo']						= trim($data['logo']);
		$data['logo']						= str_replace(' ', '', $data['logo']);

		$data['server_id']					= addslashes(post('server_id'));

		$data['ondemand']					= addslashes(post('ondemand'));

		$data['deint']						= addslashes(post('deint'));

		$data['epg_xml_id']					= addslashes(post('epg_xml_id'));

		$update = $conn->exec("UPDATE `streams` SET `server_id` = '".$data['server_id']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `streams` SET `source_server_id` = '".$data['server_id']."' WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

		// $update = $conn->exec("UPDATE `streams` SET `source` = '".$data['source']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

		$update = $conn->exec("UPDATE `streams` SET `source_type` = '".$data['source_type']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `streams` SET `source_type` = '".$data['source_type']."' WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		
		// update category for input and output streams.
		$update = $conn->exec("UPDATE `streams` SET `category_id` = '".$data['category_id']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `streams` SET `category_id` = '".$data['category_id']."' WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

		$update = $conn->exec("UPDATE `streams` SET `logo` = '".$data['logo']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `streams` SET `logo` = '".$data['logo']."' WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

		// set ondemand for input and output
		$update = $conn->exec("UPDATE `streams` SET `ondemand` = '".$data['ondemand']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `streams` SET `ondemand` = '".$data['ondemand']."' WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

		$update = $conn->exec("UPDATE `streams` SET `deint` = '".$data['deint']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `streams` SET `deint` = '".$data['deint']."' WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

		$update = $conn->exec("UPDATE `streams` SET `epg_xml_id` = '".$data['epg_xml_id']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `streams` SET `epg_xml_id` = '".$data['epg_xml_id']."' WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	}elseif($_POST['stream_type'] == 'output'){
		$data['server_id']				= addslashes($_POST['server_id']);

		$update = $conn->exec("UPDATE `streams` SET `server_id` = '".$data['server_id']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

		$data['source_stream_id']		= addslashes($_POST['source_stream_id']);

		$data['transcoding_profile_id']		= addslashes($_POST['transcoding_profile_id']);

		$update = $conn->exec("UPDATE `streams` SET `transcoding_profile_id` = '".$data['transcoding_profile_id']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

		// get source source for this stream id
		$query = $conn->query("SELECT `id`,`server_id` FROM `streams` WHERE `user_id` = '".$_SESSION['account']['id']."' AND `id` = '".$data['source_stream_id']."' ");
		$source_stream = $query->fetch(PDO::FETCH_ASSOC);

		$data['cpu_gpu']				= addslashes($_POST['cpu_gpu']);
		
		$data['surfaces']				= addslashes($_POST['surfaces']);
		if(empty($data['surfaces'])){
			$data['surfaces'] = 12;
		}
		$data['gpu']					= addslashes($_POST['gpu']);

		if($data['cpu_gpu'] == 'cpu') {
			$data['video_codec'] 		= addslashes($_POST['cpu_video_codec']);
		}
		if($data['cpu_gpu'] == 'gpu') {
			$data['video_codec'] 		= addslashes($_POST['gpu_video_codec']);
		}
		$data['screen_resolution'] 		= addslashes($_POST['screen_resolution']);
		$data['framerate'] 				= preg_replace('/[^0-9]/', '', addslashes($_POST['framerate']));
		if(empty($data['framerate'])) {
			$data['framerate'] 			= '0';
		}
		$data['audio_codec'] 			= addslashes($_POST['audio_codec']);
		$data['audio_bitrate'] 			= preg_replace('/[^0-9]/', '', addslashes($_POST['audio_bitrate']));
		if(empty($data['audio_bitrate']) || $data['audio_bitrate'] == '0') {
			$data['audio_bitrate'] 		= '128';
		}
		$data['audio_sample_rate'] 		= preg_replace('/[^0-9]/', '', addslashes($_POST['audio_sample_rate']));
		if(empty($data['audio_sample_rate']) || $data['audio_sample_rate'] == '0') {
			$data['audio_sample_rate'] 	= '44100';
		}
		$data['bitrate'] 				= preg_replace('/[^0-9]/', '', addslashes($_POST['bitrate']));
		if(empty($data['bitrate']) || $data['bitrate'] == '0') {
			$data['bitrate'] 			= '2000';
		}

		$data['ac'] 					= addslashes($_POST['ac']);
		if(empty($data['ac']) || $data['ac'] == '0') {
			$data['ac'] = '2';
		}

		$data['preset'] 				= addslashes($_POST['preset']);
		$data['profile'] 				= addslashes($_POST['profile']);
		
		$update = $conn->exec("UPDATE `streams` SET `source_server_id` = '".$source_stream['server_id']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

		$update = $conn->exec("UPDATE `streams` SET `cpu_gpu` = '".$data['cpu_gpu']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `streams` SET `surfaces` = '".$data['surfaces']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		if(!empty($data['gpu'])){
			$update = $conn->exec("UPDATE `streams` SET `gpu` = '".$data['gpu']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		}

		$update = $conn->exec("UPDATE `streams` SET `video_codec` = '".$data['video_codec']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `streams` SET `screen_resolution` = '".$data['screen_resolution']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `streams` SET `framerate` = '".$data['framerate']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `streams` SET `audio_codec` = '".$data['audio_codec']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `streams` SET `audio_bitrate` = '".$data['audio_bitrate']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `streams` SET `audio_sample_rate` = '".$data['audio_sample_rate']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `streams` SET `bitrate` = '".$data['bitrate']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `streams` SET `ac` = '".$data['ac']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `streams` SET `preset` = '".$data['preset']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `streams` SET `profile` = '".$data['profile']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	}

	$update = $conn->exec("UPDATE `streams` SET `enable` = '".$data['enable']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `name` = '".$data['name']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `user_agent` = '".$data['user_agent']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

	$update = $conn->exec("UPDATE `streams` SET `direct` = '".$data['direct']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `direct` = '".$data['direct']."' WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

	if($data['enable'] == 'yes') {
		$update = $conn->exec("UPDATE `streams` SET `pending_changes` = 'yes' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	}
	$update = $conn->exec("UPDATE `streams` SET `ffmpeg_re` = '".$data['ffmpeg_re']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

    // log_add("Stream changes have been saved.");
    status_message('success',"Stream changes have been saved.");
    go($_SERVER['HTTP_REFERER']);
}

function stream_update_fingerprint()
{
	global $conn, $global_settings;

	$stream_id 						= addslashes($_POST['stream_id']);

	// fingerprint options
	$data['fingerprint']			= addslashes($_POST['fingerprint']);
	$data['fingerprint_type']		= addslashes($_POST['fingerprint_type']);
	$data['fingerprint_text']		= addslashes($_POST['fingerprint_text']);
	$data['fingerprint_fontsize']	= addslashes($_POST['fingerprint_fontsize']);
	$data['fingerprint_color']		= addslashes($_POST['fingerprint_color']);
	$data['fingerprint_location']	= addslashes($_POST['fingerprint_location']);

	$update = $conn->exec("UPDATE `streams` SET `fingerprint` = '".$data['fingerprint']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `fingerprint_type` = '".$data['fingerprint_type']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `fingerprint_text` = '".$data['fingerprint_text']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `fingerprint_color` = '".$data['fingerprint_color']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `fingerprint_fontsize` = '".$data['fingerprint_fontsize']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `fingerprint_location` = '".$data['fingerprint_location']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

    // log_add("Stream changes have been saved.");
    status_message('success',"Stream changes have been saved.");
    go($_SERVER['HTTP_REFERER']);
}

function stream_update_dehash()
{
	global $conn, $global_settings;

	$stream_id 						= addslashes($_POST['stream_id']);

	// fingerprint options
	$data['dehash']					= addslashes($_POST['dehash']);
	$data['fingerprint_type']		= addslashes($_POST['fingerprint_type']);
	$data['fingerprint_text']		= addslashes($_POST['fingerprint_text']);
	$data['fingerprint_fontsize']	= addslashes($_POST['fingerprint_fontsize']);
	$data['fingerprint_color']		= addslashes($_POST['fingerprint_color']);
	$data['fingerprint_location']	= addslashes($_POST['fingerprint_location']);

	$update = $conn->exec("UPDATE `streams` SET `fingerprint` = '".$data['fingerprint']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `fingerprint_type` = '".$data['fingerprint_type']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `fingerprint_text` = '".$data['fingerprint_text']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `fingerprint_color` = '".$data['fingerprint_color']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `fingerprint_fontsize` = '".$data['fingerprint_fontsize']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `fingerprint_location` = '".$data['fingerprint_location']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

    // log_add("Stream changes have been saved.");
    status_message('success',"Stream changes have been saved.");
    go($_SERVER['HTTP_REFERER']);
}

function stream_restart()
{
	global $conn, $site;

	$stream_id = get('stream_id');

	$query = $conn->query("SELECT * FROM `streams` WHERE `id` = '".$stream_id."' ");
	$stream = $query->fetchAll(PDO::FETCH_ASSOC);

	if(isset($stream[0]) && isset($stream[0]['running_pid'])) {
		$job['action'] = 'kill_pid';
		$job['command'] = 'kill -9 '.$stream[0]['running_pid'];

		// add the job
		$insert = $conn->exec("INSERT INTO `jobs` 
	        (`server_id`,`job`)
	        VALUE
	        ('".$stream[0]['server_id']."','".json_encode($job)."')");

		$update = $conn->exec("UPDATE `streams` SET `enable` = 'yes' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `streams` SET `fps` = '' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `streams` SET `speed` = '' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `streams` SET `stream_uptime` = '' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `streams` SET `pending_changes` = 'no' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `streams` SET `job_status` = 'analysing' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		
	    // log_add("Stream is restarting.");
		status_message('success',"Stream will restart shortly.");
	}else{
		status_message('danger',"There was an error restarting this stream, please try again.");
	}
    go($_SERVER['HTTP_REFERER']);
}

function stream_stop()
{
	global $conn, $global_settings;

	$stream_id = get('stream_id');

	$update = $conn->exec("UPDATE `streams` SET `enable` = 'no' 			WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `status` = 'offline' 		WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `fps` = '' 					WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `speed` = '' 				WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `stream_uptime` = '' 		WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `pending_changes` = 'no' 	WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `job_status` = 'none'	 	WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

	$update = $conn->exec("UPDATE `streams` SET `enable` = 'no' 			WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `status` = 'offline' 		WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `fps` = '' 					WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `speed` = '' 				WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `stream_uptime` = '' 		WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `pending_changes` = 'no' 	WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `job_status` = 'none' 		WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	
    // log_add("Stream has been stopped.");
	status_message('success',"Stream has been stopped.");
    go($_SERVER['HTTP_REFERER']);
}

function stream_start()
{
	global $conn, $global_settings;

	$stream_id = get('stream_id');

	// start source stream
	$update = $conn->exec("UPDATE `streams` SET `enable` = 'yes' 			WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `status` = 'analysing' 		WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `fps` = '' 					WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `speed` = '' 				WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `stream_uptime` = '' 		WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `pending_changes` = 'no' 	WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `job_status` = 'analysing' 	WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

	// start output stream
	$update = $conn->exec("UPDATE `streams` SET `enable` = 'yes' 			WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `status` = 'analysing' 		WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `fps` = '' 					WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `speed` = '' 				WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `stream_uptime` = '' 		WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `pending_changes` = 'no' 	WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `job_status` = 'analysing' 	WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	
    // log_add("Streaming has been started.");
    status_message('success',"Stream has been started.");
    go($_SERVER['HTTP_REFERER']);
}

function stream_add()
{
	global $conn, $global_settings;
	
	$rand 				= md5(rand(00000,99999).time());
	
	$source_method 		= $_POST['remote_playlist']	;

	if($source_method == 'manual'){
		$source 			= addslashes($_POST['add_stream_url']);
	}else{
		$source 			= addslashes($_POST['add_stream_url_list']);
	}

	$source 			= trim($source);
	$source 			= str_replace(' ', '', $source);
	
	if(empty($source)){
		status_message('danger',"You did not enter a stream source.");
    	go($_SERVER['HTTP_REFERER']);
	}

	$server_id			= addslashes($_POST['server']);
	if(empty($server_id) || $server_id == 0){
		$server_id = 1;
	}
	
	$name 				= addslashes($_POST['name']);
	$name 				= trim($name);

	$channel_icon 		= addslashes($_POST['channel_icon']);
	$channel_icon 		= trim($channel_icon);

	$category_id 		= addslashes($_POST['category_id']);
	$category_id 		= trim($category_id);

	$ffmpeg_re			= $_POST['ffmpeg_re'];

	$epg_xml_id			= post('epg_xml_id');

	// add input stream
	$insert = $conn->exec("INSERT INTO `streams` 
        (`user_id`,`server_id`,`stream_type`,`name`,`enable`,`source`,`cpu_gpu`,`job_status`,`ffmpeg_re`,`logo`,`category_id`,`epg_xml_id`)
        VALUE
        ('".$_SESSION['account']['id']."',
        '".$server_id."',
        'input',
        '".$name."',
        'yes',
        '".$source."',
        'cpu',
        'analysing',
        '".$ffmpeg_re."',
        '".$channel_icon."',
        '".$category_id."',
        '".$epg_xml_id."'
    )");

    $stream_id = $conn->lastInsertId();

    // add output stream
    $insert = $conn->exec("INSERT INTO `streams` 
        (`user_id`,`enable`,`server_id`,`stream_type`,`name`,`source_server_id`,`source_stream_id`,`logo`,`category_id`,`epg_xml_id`)
        VALUE
        ('".$_SESSION['account']['id']."',
        'yes',
        '".$server_id."',
        'output',
        '".$name."',
        '".$server_id."',
        '".$stream_id."',
        '".$channel_icon."',
        '".$category_id."',
        '".$epg_xml_id."'
    )");
    
	// log_add("Stream has been added.");
	status_message('success',"Stream has been added.");
	go($_SERVER['HTTP_REFERER']);
}

function import_streams()
{
	global $conn, $global_settings;

	$server_id			= addslashes($_POST['server']);
	if($server_id == 0){
		$server_id = 1;
	}

	$category_id		= addslashes($_POST['category_id']);

	$ffmpeg_re			= $_POST['ffmpeg_re'];

	// handle file upload
	exec("sudo mkdir -p /var/www/html/portal/m3u_uploads/");
	exec("sudo chmod 777 /var/www/html/portal/m3u_uploads/");

	$target_dir = "m3u_uploads/";
	$target_file = $target_dir . $_SESSION['account']['id'].'-'.str_replace(' ', '_', basename($_FILES["m3u_file"]["name"]));
	$uploadOk = 1;
	$file_type = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	
	// check if file already exists
	/*
	if (file_exists($target_file)) {
	    echo "Sorry, file already exists.";
	    $uploadOk = 0;
	}
	*/

	// check file size
	/*
	if ($_FILES["fileToUpload"]["size"] > 500000) {
	    echo "Sorry, your file is too large.";
	    $uploadOk = 0;
	}
	*/

	// allow certain file formats
	if($file_type != "m3u" && $file_type != "m3u8" && $file_type != "txt") {
		status_message('danger',"Sorry, only .m3u and .m3u8 files are allowed.");
		go($_SERVER['HTTP_REFERER']);
	    $uploadOk = 0;
	}

	// check if $uploadOk is set to 0 by an error
	if($uploadOk == 0) {
	    status_message('danger',"Sorry, there was an error uploading your file.");
		go($_SERVER['HTTP_REFERER']);
	// if everything is ok, try to upload file
	}else{
	    if(move_uploaded_file($_FILES["m3u_file"]["tmp_name"], $target_file)) {
	        // echo "The file ". $_SESSION['account']['id'].'-'.basename( $_FILES["m3u_file"]["name"]). " has been uploaded.";
	    }else{
	    	status_message('danger',"Sorry, there was an error uploading your file.");
			go($_SERVER['HTTP_REFERER']);
	    }
	}

  	// read the uploaded m3u into an array
  	error_log("----- M3U URL");
  	error_log("http://".$global_settings['cms_access_url']."/actions.php?a=inspect_m3u&url=http://".$global_settings['cms_access_url']."/m3u_uploads/".$_SESSION['account']['id'].'-'.str_replace(' ', '_',basename( $_FILES["m3u_file"]["name"])));
  	error_log("----- M3U URL");
  	$streams_raw 		= @file_get_contents("http://".$global_settings['cms_access_url']."/actions.php?a=inspect_m3u&url=http://".$global_settings['cms_access_url']."/m3u_uploads/".$_SESSION['account']['id'].'-'.str_replace(' ', '_',basename( $_FILES["m3u_file"]["name"])));
  	$streams 			= json_decode($streams_raw, true);
	if(is_array($streams)){
		foreach($streams as $stream) {
			$rand 				= md5(rand(00000,99999).time());
			
			$name 				= addslashes($stream['title']);
			$name 				= str_replace(array('"',"'",';'), '', $name);
			$name 				= trim($name);

			$source 			= addslashes($stream['url']);
			$source 			= trim($source);
			$source 			= str_replace(' ', '', $source);

			if(!isset($stream['tvlogo']) || empty($stream['tvlogo'])){
				$stream['tvlogo'] = '';
			}

			$insert = $conn->exec("INSERT INTO `streams` 
		        (`user_id`,`server_id`,`stream_type`,`name`,`enable`,`source`,`cpu_gpu`,`job_status`,`ffmpeg_re`,`logo`,`category_id`)
		        VALUE
		        ('".$_SESSION['account']['id']."',
		        '".$server_id."',
		        'input',
		        '".$name."',
		        'no',
		        '".$source."',
		        'cpu',
		        'analysing',
		        '".$ffmpeg_re."',
		        '".$stream['tvlogo']."',
		        '".$category_id."'
		    )");

		    $stream_id = $conn->lastInsertId();

		    // add output stream
		    $insert = $conn->exec("INSERT INTO `streams` 
		        (`user_id`,`enable`,`server_id`,`stream_type`,`name`,`source_server_id`,`source_stream_id`,`logo`,`category_id`)
		        VALUE
		        ('".$_SESSION['account']['id']."',
		        'yes',
		        '".$server_id."',
		        'output',
		        '".$name."',
		        '".$server_id."',
		        '".$stream_id."',
		        '".$stream['tvlogo']."',
		        '".$category_id."'
		    )");
	    }

	    // remove upload file
	    // shell_exec("rm -rf " . $target_file);

		// log_add("Streams has been imported.");
		status_message('success',"All streams have been imported.");
	}else{
		status_message('danger',"No streams found in the uploaded file or something else went wrong.");
	}
	go($_SERVER['HTTP_REFERER']);
}

function stream_add_output()
{
	global $conn, $global_settings;
	
	$rand 				= md5(rand(00000,99999).time());
	
	$source_id 			= addslashes($_POST['source_id']);
	
	$query = $conn->query("SELECT `server_id`,`category_id`,`logo`,`source_type` FROM `streams` WHERE `id` = '".$source_id."' ");
	$stream = $query->fetch(PDO::FETCH_ASSOC);

	$server_id 			= $stream['server_id'];	
	
	$name 				= addslashes($_POST['name']);
	$name 				= trim($name);

	$insert = $conn->exec("INSERT INTO `streams` 
        (`user_id`,`server_id`,`stream_type`,`name`,`source_server_id`,`source_stream_id`,`logo`,`category_id`,`source_type`)
        VALUE
        ('".$_SESSION['account']['id']."',
        '".$server_id."',
        'output',
        '".$name."',
        '".$server_id."',
        '".$source_id."',
        '".$stream['logo']."',
        '".$stream['category_id']."',
        '".$stream['source_type']."'
    )");

    $stream_id = $conn->lastInsertId();
    
	// log_add("Stream has been added.");
	status_message('success',"Stream has been added.");
	go("dashboard.php?c=stream&stream_id=".$stream_id);
}

function stream_delete()
{
	global $conn, $global_settings;

	$stream_id = get('stream_id');

	// is this stream an input or output stream
	$query = $conn->query("SELECT `id` FROM `streams` WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$stream = $query->fetch(PDO::FETCH_ASSOC);

	if($stream['stream_type'] == 'output'){
		// delete output stream
		$delete = $conn->query("DELETE FROM `streams` WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

		// delete stream from stalker
		$delete = $conn->query("DELETE FROM `stalker_db`,`itv` WHERE `id` = '".$stream_id."' ");
	}else{
		// delete output stream
		$delete = $conn->query("DELETE FROM `streams` WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

		// delete outputs for this stream as they are zombies now
		$delete = $conn->query("DELETE FROM `streams` WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	}

	// remove from bouquets_content
	$delete = $conn->exec("DELETE FROM `bouquets_content` WHERE `content_id` = '".$stream_id."' ");

	// delete from stalker
	$delete = $conn->exec("DELETE FROM `stalker_db`.`itv` WHERE `id` = '".$stream_id."' ");

	status_message('success',"Stream has been deleted.");
	go($_SERVER['HTTP_REFERER']);
}

function inspect_m3u()
{
	header('Content-Type: application/json');

	$url = $_GET["url"];

	if(isset($url)) {
		$m3ufile =@file_get_contents($url);
	}else{
	  	//$m3ufile =@file_get_contents('http://pastebin.com/raw/t1mBJ2Yi');
	  	$m3ufile =@file_get_contents('https://raw.githubusercontent.com/onigetoc/iptv-playlists/master/general/tv/us.m3u');
	}

	//$m3ufile = str_replace('tvg-', 'tvg_', $m3ufile);
	$m3ufile = str_replace('group-title', 'tvgroup', $m3ufile);
	$m3ufile = str_replace("tvg-", "tv", $m3ufile);

	//$re = '/#(EXTINF|EXTM3U):(.+?)[,]\s?(.+?)[\r\n]+?((?:https?|rtmp):\/\/(?:\S*?\.\S*?)(?:[\s)\[\]{};"\'<]|\.\s|$))/';
	$re = '/#EXTINF:(.+?)[,]\s?(.+?)[\r\n]+?((?:https?|rtmp):\/\/(?:\S*?\.\S*?)(?:[\s)\[\]{};"\'<]|\.\s|$))/';
	$attributes = '/([a-zA-Z0-9\-]+?)="([^"]*)"/';

	preg_match_all($re, $m3ufile, $matches);

	$i = 1;

	$items = array();

	 foreach($matches[0] as $list) {
	 	 
	   preg_match($re, $list, $matchList);

	   $mediaURL = preg_replace("/[\n\r]/","",$matchList[3]);
	   $mediaURL = preg_replace('/\s+/', '', $mediaURL);   

	   $newdata =  array (
	    'id' => $i++,
	    'title' => $matchList[2],
	    'url' => $mediaURL
	    );
	    
	    preg_match_all($attributes, $list, $matches, PREG_SET_ORDER);
	    
	    foreach ($matches as $match) {
	       $newdata[$match[1]] = $match[2];
	    }

		 $items[] = $newdata;    
	 }

	echo json_encode($items);
}

function inspect_m3u_encoded()
{
	header('Content-Type: application/json');

	$items = array();

	$url = base64_decode($_GET["url"]);

	if(isset($url)) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL,$url);
		$m3ufile = curl_exec($ch);
		curl_close($ch);

		if($m3ufile) {
			//$m3ufile = str_replace('tvg-', 'tvg_', $m3ufile);
			$m3ufile = str_replace('group-title', 'tvgroup', $m3ufile);
			$m3ufile = str_replace("tvg-", "tv", $m3ufile);

			//$re = '/#(EXTINF|EXTM3U):(.+?)[,]\s?(.+?)[\r\n]+?((?:https?|rtmp):\/\/(?:\S*?\.\S*?)(?:[\s)\[\]{};"\'<]|\.\s|$))/';
			$re = '/#EXTINF:(.+?)[,]\s?(.+?)[\r\n]+?((?:https?|rtmp):\/\/(?:\S*?\.\S*?)(?:[\s)\[\]{};"\'<]|\.\s|$))/';
			$attributes = '/([a-zA-Z0-9\-]+?)="([^"]*)"/';

			preg_match_all($re, $m3ufile, $matches);

			$i = 1;

			$items = array();

			foreach($matches[0] as $list) {
			 	 
			   	preg_match($re, $list, $matchList);

			   	$mediaURL = preg_replace("/[\n\r]/","",$matchList[3]);
			   	$mediaURL = preg_replace('/\s+/', '', $mediaURL);   

			   	$newdata =  array (
			    	'id' => $i++,
					'title' => $matchList[2],
			    	'url' => $mediaURL
			    );
			    
			    preg_match_all($attributes, $list, $matches, PREG_SET_ORDER);
			    
			    foreach ($matches as $match) {
			    	$newdata[$match[1]] = $match[2];
			    }

				$items[] = $newdata;    
			}
		}else{
			$items['status'] = 'invalid file or 404';
		}
	}else{
		$items['status'] = 'url is missing'; 
	}

	json_output($items);
}

function inspect_remote_playlist()
{
	global $conn, $global_settings;

	header('Content-Type: application/json');

	$items = '';

	$playlist_id = $_GET["id"];

	$query = $conn->query("SELECT * FROM `remote_playlists` WHERE `id` = '".$playlist_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	if($query !== FALSE) {
		$playlist = $query->fetch(PDO::FETCH_ASSOC);
	}

	if(isset($playlist['url'])) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL,$playlist['url']);
		$m3ufile = curl_exec($ch);
		curl_close($ch);

		if($m3ufile) {
			//$m3ufile = str_replace('tvg-', 'tvg_', $m3ufile);
			$m3ufile = str_replace('group-title', 'tvgroup', $m3ufile);
			$m3ufile = str_replace("tvg-", "tv", $m3ufile);

			//$re = '/#(EXTINF|EXTM3U):(.+?)[,]\s?(.+?)[\r\n]+?((?:https?|rtmp):\/\/(?:\S*?\.\S*?)(?:[\s)\[\]{};"\'<]|\.\s|$))/';
			$re = '/#EXTINF:(.+?)[,]\s?(.+?)[\r\n]+?((?:https?|rtmp):\/\/(?:\S*?\.\S*?)(?:[\s)\[\]{};"\'<]|\.\s|$))/';
			$attributes = '/([a-zA-Z0-9\-]+?)="([^"]*)"/';

			preg_match_all($re, $m3ufile, $matches);

			$i = 1;

			$items = array();

			foreach($matches[0] as $list) {
			 	 
			   	preg_match($re, $list, $matchList);

			   	$mediaURL = preg_replace("/[\n\r]/","",$matchList[3]);
			   	$mediaURL = preg_replace('/\s+/', '', $mediaURL);   

			   	$newdata =  array (
			    	'id' => $i++,
					'title' => $matchList[2],
			    	'url' => $mediaURL
			    );
			    
			    preg_match_all($attributes, $list, $matches, PREG_SET_ORDER);
			    
			    foreach ($matches as $match) {
			    	$newdata[$match[1]] = $match[2];
			    }

				$items[] = $newdata;    
			}
		}else{
			$items['status'] = 'invalid file or 404';
		}
	}else{
		$items['status'] = 'url is missing'; 
	}

	json_output($items);
}

function analyse_stream()
{
	header("Content-Type:application/json; charset=utf-8");

	$url = trim($_GET['url']);
	$url = str_replace(' ', '', $url);

	if(empty($url)) {
		$data[0]['status'] 						= 'missing url';
	}else{
		$data[0]['url']							= $url;
		$data[0]['url_bits']					= parse_url($url);

		// add host > ip to firewall
		$data[0]['url_bits']['ip_address'] 		= gethostbyname($data[0]['url_bits']['host']);
		$data[0]['firewall_cmd']				= "sudo csf -a " . $data[0]['url_bits']['ip_address'];
		// $firewall 							= exec("/usr/bin/sudo -u root -s /usr/sbin/csf -a " . $data['url_bits']['ip_address']);
		// $data[0]['firewall_reply']			= $firewall;

		// test the stream
		$data[0]['results'] 					= shell_exec("/etc/ffmpeg/ffprobe -v quiet -print_format json -show_format -show_streams '".$url."'");
		$data[0]['results'] 					= json_decode($data[0]['results'], true);

		if(isset($data[0]['results']['streams'])) {
			$data[0]['status'] = 'online';

			// lets grab a screenshot
			$random_img = md5($url);
			$data[0]['screenshot_path'] = "/home2/slipstream/public_html/hub/screenshots/".$random_img.".png";
			$data[0]['screenshot_url'] = "http://".$global_settings['cms_access_url']."/screenshots/".$random_img.".png";
			$screenshot = shell_exec("/etc/ffmpeg/ffmpeg -y -i '".$url."' -f image2 -vframes 1 /home2/slipstream/public_html/hub/screenshots/".$random_img.".png");
			
			$count = 1;
			foreach($data[0]['results']['streams'] as $stream) {
				if($stream['codec_type'] == 'video') {
					$data[0]['stream_data'][0] = $stream;
				}
			}

			foreach($data[0]['results']['streams'] as $stream) {
				if($stream['codec_type'] == 'audio') {
					$data[0]['stream_data'][$count] = $stream;
					$count++;
				}
			}
		}elseif(!isset($data[0]['results']['streams'])){
			$data[0]['status'] = 'offline';
		}else{
			$data[0]['status'] = 'unknown';
		}
	}

	json_output($data);
}

function cdn_stream_start()
{
	global $conn, $global_settings;

	$server_id = get('server_id');
	$stream_id = get('stream_id');

	$uuid = md5($server_id.$stream_id);

	// add to db
	$insert = $conn->exec("INSERT INTO `cdn_streams_servers` 
        (`id`,`user_id`,`server_id`,`stream_id`)
        VALUE
        (
        '".$uuid."',
        '".$_SESSION['account']['id']."',
        '".$server_id."',
        '".$stream_id."'
    )");

    // log_add("Stream has been added.");
    status_message('success',"Stream has been added.");
	go($_SERVER['HTTP_REFERER']);
}

function cdn_stream_stop()
{
	global $conn, $global_settings;

	$stream_id = get('stream_id');
	$server_id = get('server_id');

	// get the pid to kill
	$query = $conn->query("SELECT * FROM `cdn_streams_servers` WHERE `stream_id` = '".$stream_id."' AND `server_id` = '".$server_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$stream = $query->fetchAll(PDO::FETCH_ASSOC);

	// set the stream to die by pid
	// example: // example: {"action":"kill_pid","command":"kill -9 12748"}
	$job['action'] = 'kill_pid';
	$job['command'] = 'kill -9 '.$stream[0]['running_pid'];

	// add the job
	$insert = $conn->exec("INSERT INTO `jobs` 
        (`server_id`,`job`)
        VALUE
        ('".$server_id."','".json_encode($job)."')");

	$update = $conn->exec("DELETE FROM `cdn_streams_servers` WHERE `stream_id` = '".$stream_id."' AND `server_id` = '".$server_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	
    // log_add("Streaming has been stopped.");
    status_message('success',"Stream has been stopped.");
	go($_SERVER['HTTP_REFERER']);
}

function acl_rule_add()
{
	global $conn, $global_settings;

	$server_id 		= post( 'server_id' );
	$ip_address 	= post( 'ip_address' );
	$comment 		= addslashes( post( 'comment' ) );

	// add to db
	$insert = $conn->exec("INSERT INTO `streams_acl_rules` 
        (`user_id`,`server_id`,`ip_address`,`comment`)
        VALUE
        (
        '".$_SESSION['account']['id']."',
        '".$server_id."',
        '".$ip_address."',
        '".$comment."'
    )");

    // log_add( "Firewall rule has been added." );
    status_message( 'success' , "Firewall rule has been added." );
	go( $_SERVER['HTTP_REFERER'] );
}

function acl_rule_delete()
{
	global $conn, $global_settings;

	$rule_id = get('rule_id');

	$update = $conn->exec("DELETE FROM `streams_acl_rules` WHERE `id` = '".$rule_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	
    // log_add("Firewall rule has been deleted.");
    status_message('success',"Firewall rule has been deleted.");
	go($_SERVER['HTTP_REFERER']);
}

function stream_enable_format()
{
	global $conn, $site;

	$stream_id 			= get('stream_id');
	$stream_format 		= get('stream_format');

	$stream_raw 		=@file_get_contents($site['url']."actions.php?a=ajax_stream&stream_id=".$stream_id);
	$stream 			= json_decode($stream_raw, true);

	// echo 'stream format: '.$stream_format.' <br>';
	// echo 'existing stream format: '.$stream[0]['output_options'][$stream_format]['enable'].' <br>';

	$stream[0]['output_options'][$stream_format]['enable'] = 'yes';
	// echo 'new stream format: '.$stream[0]['output_options'][$stream_format]['enable'].' <br>';

	$stream[0]['output_options'] = json_encode($stream[0]['output_options']);
	// echo '<pre>';
	// print_r($stream);

	$update = $conn->exec("UPDATE `streams` SET `output_options` = '".$stream[0]['output_options']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

	// add job to kill current stream and let new settings take effect
	/*
	$job['action'] = 'kill_pid';
	$job['command'] = 'kill -9 '.$stream[0]['running_pid'];

	// add the job
	$insert = $conn->exec("INSERT INTO `jobs` 
        (`server_id`,`job`)
        VALUE
        ('".$stream[0]['server_id']."','".json_encode($job)."')");
	*/
	
	// log_add("Stream format updated.");
    status_message('success',"Changes have been saved.");
	go($_SERVER['HTTP_REFERER']);
}

function stream_disable_format()
{
	global $conn, $site;

	$stream_id 			= get('stream_id');
	$stream_format 		= get('stream_format');

	$query = $conn->query("SELECT * FROM `streams` WHERE `id` = '".$stream_id."' ");
	$stream = $query->fetchAll(PDO::FETCH_ASSOC);

	// echo 'stream format: '.$stream_format.' <br>';
	// echo 'existing stream format: '.$stream[0]['output_options'][$stream_format]['enable'].' <br>';

	$stream[0]['output_options'][$stream_format]['enable'] = 'no';
	$stream[0]['output_options'][$stream_format]['status'] = 'offline';
	// echo 'new stream format: '.$stream[0]['output_options'][$stream_format]['enable'].' <br>';

	$stream[0]['output_options'] = json_encode($stream[0]['output_options']);
	// echo '<pre>';
	// print_r($stream);

	$update = $conn->exec("UPDATE `streams` SET `output_options` = '".$stream[0]['output_options']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

	// add job to kill current stream and let new settings take effect
	/*
	$job['action'] = 'kill_pid';
	$job['command'] = 'kill -9 '.$stream[0]['running_pid'];

	// add the job
	$insert = $conn->exec("INSERT INTO `jobs` 
        (`server_id`,`job`)
        VALUE
        ('".$stream[0]['server_id']."','".json_encode($job)."')");

	*/

	// log_add("Stream format updated.");
    status_message('success',"Changes have been saved.");
	go($_SERVER['HTTP_REFERER']);
}

function streams_restart_all()
{
	global $conn, $global_settings;

	$data['action'] = 'streams_restart_all';
	$data['command'] = '';

	$headends = get_all_servers_ids();

	foreach($headends as $headend) {
		if($headend['status'] == 'online') {
			$insert = $conn->exec("INSERT INTO `jobs` 
	        (`server_id`,`job`)
	        VALUE
	        ('".$headend['id']."','".json_encode($data)."')");
		}
	}

	$update = $conn->exec("UPDATE `streams` SET `job_status` = 'restarting' WHERE `user_id` = '".$_SESSION['account']['id']."' AND `enable` = 'yes' ");
	$update = $conn->exec("UPDATE `streams` SET `stream_uptime` = '' WHERE `user_id` = '".$_SESSION['account']['id']."' AND `enable` = 'yes' ");
	$update = $conn->exec("UPDATE `streams` SET `fps` = '' WHERE `user_id` = '".$_SESSION['account']['id']."' AND `enable` = 'yes' ");
	$update = $conn->exec("UPDATE `streams` SET `speed` = '' WHERE `user_id` = '".$_SESSION['account']['id']."' AND `enable` = 'yes' ");
    
    // log_add("Restarting all streams.");
	status_message('success',"All streams will be restarted shortly.");
	go($_SERVER['HTTP_REFERER']);
}

function streams_stop_all()
{
	global $conn, $global_settings;

	$update = $conn->exec("UPDATE `streams` SET `status` = 'offline' WHERE `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `enable` = 'no' WHERE `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `fps` = '' WHERE `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `speed` = '' WHERE `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `stream_uptime` = '' WHERE `user_id` = '".$_SESSION['account']['id']."' ");

    // log_add("Restarting all streams.");
	status_message('success',"All streams will stop shortly.");
    go($_SERVER['HTTP_REFERER']);
}

function streams_start_all()
{
	global $conn, $global_settings;

	// set enable = 'yes' for all streams
	$update = $conn->exec("UPDATE `streams` SET `enable` = 'yes' WHERE `user_id` = '".$_SESSION['account']['id']."' ");
    
    // set job_status = 'analysing' for all streams
    $update = $conn->exec("UPDATE `streams` SET `job_status` = 'analysing' WHERE `user_id` = '".$_SESSION['account']['id']."' AND `enable` = 'yes' ");

    // log_add("Restarting all streams.");
	status_message('success',"All streams will start shortly.");
    go($_SERVER['HTTP_REFERER']);
}

function export_m3u()
{
	global $conn, $global_settings;

	//Generate text file on the fly
	header("Content-type: text/plain");
	header("Content-Disposition: attachment; filename=playlist.m3u");

	$new_line = "\n";

	// demo m3u format
	// #EXTM3U
	// #EXTINF:-1,CHANNEL NAME
	// http://link.to.stream

	print "#EXTM3U".$new_line;

	// build $streams
	$query = $conn->query("SELECT * FROM `streams` WHERE `stream_type` = 'output' AND `user_id` = '".$_SESSION['account']['id']."' ORDER BY `name` ASC");
	$streams = $query->fetchAll(PDO::FETCH_ASSOC);

	foreach($streams as $stream) {
		// get stream data for each headend
		// $query = $conn->query("SELECT * FROM `headend_servers` WHERE `id` = '".$stream['server_id']."' ");
		// $stream['headend'] = $query->fetchAll(PDO::FETCH_ASSOC);

		print "#EXTINF:-1,".strtoupper($stream['stream_type'])." SOURCE - ".stripslashes($stream['name']).$new_line;
		print "http://".$global_settings['cms_access_url']."/streams/".$stream['server_id']."/".$stream['id'].$new_line;
	}
}

function my_account_update()
{
	global $conn, $global_settings;

	/*
	$first_name 			= addslashes($_POST['first_name']);
	$first_name 			= trim($first_name);

	$last_name 				= addslashes($_POST['last_name']);
	$last_name 				= trim($last_name);

	$email 					= addslashes($_POST['email']);
	$email 					= trim($email);

	$tel 					= addslashes($_POST['tel']);
	$tel 					= trim($tel);

	$username 				= addslashes($_POST['username']);
	$username 				= trim($username);

	$password 				= addslashes($_POST['password']);
	$password 				= trim($password);

	$password2 				= addslashes($_POST['password2']);
	$password2 				= trim($password2);

	$address_1 				= post('address_1');
	$address_1 				= addslashes($address_1);

	$address_2 				= post('address_2');
	$address_2 				= addslashes($address_2);

	$address_city 			= post('address_city');
	$address_city 			= addslashes($address_city);

	$address_state 			= post('address_state');
	$address_state 			= addslashes($address_state);

	$address_country 		= post('address_country');
	$address_country 		= addslashes($address_country);

	$address_zip 			= post('address_zip');
	$address_zip 			= addslashes($address_zip);
	*/

	$bank_name 				= post('bank_name');
	$bank_name 				= addslashes($bank_name);

	$bank_account_name 		= post('bank_account_name');
	$bank_account_name 		= addslashes($bank_account_name);

	$bank_account_number 	= post('bank_account_number');
	$bank_account_number 	= addslashes($bank_account_number);
	$bank_account_number 	= preg_replace("/[^0-9]/", "", $bank_account_number);

	$bank_sort_code 		= post('bank_sort_code');
	$bank_sort_code 		= addslashes($bank_sort_code);
	$bank_sort_code 		= preg_replace("/[^0-9]/", "", $bank_sort_code);

	$affiliate_first_name 	= post('affiliate_first_name');
	$affiliate_first_name 	= addslashes($affiliate_first_name);

	$affiliate_last_name 	= post('affiliate_last_name');
	$affiliate_last_name 	= addslashes($affiliate_last_name);

	$affiliate_tel 		 	= post('affiliate_tel');
	$affiliate_tel 		 	= addslashes($affiliate_tel);

	$affiliate_email 		= post('affiliate_email');
	$affiliate_email 		= addslashes($affiliate_email);

	$affiliate_username 	= post('affiliate_username');
	$affiliate_username 	= addslashes($affiliate_username);

	// check username availability
	/*
	$query 					= $conn->query("SELECT `id` FROM `users` WHERE `username` = '".$username."' AND `id` != '".$_SESSION['account']['id']."' ");
	$username_check 		= $query->fetch(PDO::FETCH_ASSOC);
	if(isset($username_check['id'])){
		status_message('danger', "Unable to use '".$username."' as your username as its already in use.");
		go($_SERVER['HTTP_REFERER']);
	}
	*/

	// check affiliate_username availability
	$query 					= $conn->query("SELECT `id` FROM `users` WHERE `affiliate_username` = '".$affiliate_username."' AND `id` != '".$_SESSION['account']['id']."' ");
	$username_check 		= $query->fetch(PDO::FETCH_ASSOC);
	if(isset($username_check['id'])){
		status_message('danger', "Unable to use '".$affiliate_username."' as your affiliate username as its already in use.");
		go($_SERVER['HTTP_REFERER']);
	}

	// password sanity check
	if(!empty($password) && !empty($password2)){
		if($password == $password2){
			$update = $conn->exec("UPDATE `users` SET `password` = '".$password."' 			WHERE `id` = '".$_SESSION['account']['id']."' ");
		}else{
			status_message('danger', "Passwords do not match, please try again.");
			go($_SERVER['HTTP_REFERER']);
		}
	}

	/*
	$update = $conn->exec("UPDATE `users` SET `first_name` = '".$first_name."' 						WHERE `id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `users` SET `last_name` = '".$last_name."' 						WHERE `id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `users` SET `email` = '".$email."' 								WHERE `id` = '".$_SESSION['account']['id']."' ");

	$update = $conn->exec("UPDATE `users` SET `username` = '".$username."' 							WHERE `id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `users` SET `tel` = '".$tel."' 									WHERE `id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `users` SET `address_1` = '".$address_1."' 						WHERE `id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `users` SET `address_2` = '".$address_2."' 						WHERE `id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `users` SET `address_city` = '".$address_city."' 					WHERE `id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `users` SET `address_state` = '".$address_state."' 				WHERE `id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `users` SET `address_country` = '".$address_country."' 			WHERE `id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `users` SET `address_zip` = '".$address_zip."' 					WHERE `id` = '".$_SESSION['account']['id']."' ");
	*/
	
	$update = $conn->exec("UPDATE `users` SET `bank_name` = '".$bank_name."' 						WHERE `id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `users` SET `bank_account_name` = '".$bank_account_name."' 		WHERE `id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `users` SET `bank_account_number` = '".$bank_account_number."' 	WHERE `id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `users` SET `bank_sort_code` = '".$bank_sort_code."' 				WHERE `id` = '".$_SESSION['account']['id']."' ");

	$update = $conn->exec("UPDATE `users` SET `affiliate_username` = '".$affiliate_username."' 		WHERE `id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `users` SET `affiliate_first_name` = '".$affiliate_first_name."' 	WHERE `id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `users` SET `affiliate_last_name` = '".$affiliate_last_name."' 	WHERE `id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `users` SET `affiliate_email` = '".$affiliate_email."' 			WHERE `id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `users` SET `affiliate_tel` = '".$affiliate_tel."' 				WHERE `id` = '".$_SESSION['account']['id']."' ");

	status_message('success', "Your changes have been saved.");
    go($_SERVER['HTTP_REFERER']);
}

function customer_add()
{
	global $conn, $global_settings;
		
	$first_name 		= addslashes($_POST['first_name']);
	$first_name 		= trim($first_name);

	$last_name 			= addslashes($_POST['last_name']);
	$last_name 			= trim($last_name);

	$email 				= addslashes($_POST['email']);
	$email 				= trim($email);

	$username 			= md5(md5(time()));

	$password 			= md5(md5(rand(00000,99999)));

	$expire_date 		= date("Y-m-d", time() + 2629746);

	$insert = $conn->exec("INSERT INTO `customers` 
        (`user_id`,`updated`,`first_name`,`last_name`,`email`,`username`,`password`,`expire_date`)
        VALUE
        ('".$_SESSION['account']['id']."',
        '".time()."',
        '".$first_name."',
        '".$last_name."',
        '".$email."',
        '".$username."',
        '".$password."',
        '".$expire_date."'
    )");

    $customer_id = $conn->lastInsertId();
	status_message('success',"Customer account has been added.");
	go("dashboard.php?c=customer&customer_id=".$customer_id);
}

function customer_update()
{
	global $conn, $global_settings;
	
	$customer_id 		= addslashes($_POST['customer_id']);

	$status 			= addslashes($_POST['status']);

	$first_name 		= addslashes($_POST['first_name']);
	$first_name 		= trim($first_name);
	$first_name 		= preg_replace("/[^a-zA-Z0-9]+/", "", $first_name);

	$last_name 			= addslashes($_POST['last_name']);
	$last_name 			= trim($last_name);
	$last_name 			= preg_replace("/[^a-zA-Z0-9]+/", "", $last_name);

	$email 				= addslashes($_POST['email']);
	$email 				= trim($email);

	$existing_username	= addslashes($_POST['existing_username']);
	$existing_username 	= trim($existing_username);

	$username			= addslashes($_POST['username']);
	$username 			= trim($username);
	$username 			= preg_replace("/[^a-zA-Z0-9]+/", "", $username);

	$password 			= addslashes($_POST['password']);
	$password 			= trim($password);
	$password 			= preg_replace("/[^a-zA-Z0-9]+/", "", $password);

	$max_connections 	= addslashes($_POST['max_connections']);
	$max_connections 	= trim($max_connections);

	$expire_date 		= addslashes($_POST['expire_date']);
	
	$notes 				= addslashes($_POST['notes']);
	$notes 				= trim($notes);

	$reseller_notes 	= addslashes($_POST['reseller_notes']);
	$reseller_notes 	= trim($reseller_notes);

	// $reseller_notes 	= addslashes($_POST['reseller_notes']);
	// $reseller_notes 	= trim($reseller_notes);

	$bouquets 			= $_POST['bouquets'];
	if(!empty($bouquets)){
		$bouquets 			= implode(",", $bouquets);
	}

	$package_id			= post("package_id");
	if($package_id != 0){
		$query 					= $conn->query("SELECT * FROM `packages` WHERE `id` = '".$package_id."' ");
		$package 				= $query->fetch(PDO::FETCH_ASSOC);

		$bouquets 				= $package['bouquets'];
	}

	$live_content 		= 'on';
	$channel_content 	= 'on';
	$vod_content 		= 'on';

	// check if username is already in use
	if($existing_username != $username){
		$query 							= $conn->query("SELECT `id` FROM `customers` WHERE `username` = '".$username."' ");
		$existing_username 				= $query->fetch(PDO::FETCH_ASSOC);
		if(!empty($existing_username)){
			status_message('danger',$username." is already in use.");
		}else{
			$update = $conn->exec("UPDATE `customers` SET `status` = '".$status."' 						WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `customers` SET `first_name` = '".$first_name."'				WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `customers` SET `last_name` = '".$last_name."' 				WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `customers` SET `email` = '".$email."' 						WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `customers` SET `username` = '".$username."' 					WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `customers` SET `password` = '".$password."' 					WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `customers` SET `expire_date` = '".$expire_date."' 			WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `customers` SET `max_connections` = '".$max_connections."' 	WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `customers` SET `notes` = '".$notes."' 						WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `customers` SET `reseller_notes` = '".$reseller_notes."' 		WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `customers` SET `live_content` = '".$live_content."' 			WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `customers` SET `channel_content` = '".$channel_content."' 	WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `customers` SET `vod_content` = '".$vod_content."' 			WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `customers` SET `bouquet` = '".$bouquets."' 					WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			status_message('success',"Customer account has been updated.");
		}
	}else{
		$update = $conn->exec("UPDATE `customers` SET `status` = '".$status."' 						WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `customers` SET `first_name` = '".$first_name."'				WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `customers` SET `last_name` = '".$last_name."' 				WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `customers` SET `email` = '".$email."' 						WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `customers` SET `username` = '".$username."' 					WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `customers` SET `password` = '".$password."' 					WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `customers` SET `expire_date` = '".$expire_date."' 			WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `customers` SET `max_connections` = '".$max_connections."' 	WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `customers` SET `notes` = '".$notes."' 						WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `customers` SET `reseller_notes` = '".$reseller_notes."' 		WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `customers` SET `live_content` = '".$live_content."' 			WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `customers` SET `channel_content` = '".$channel_content."' 	WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `customers` SET `vod_content` = '".$vod_content."' 			WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `customers` SET `bouquet` = '".$bouquets."' 					WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

		status_message('success',"Customer account has been updated.");
	}
	go($_SERVER['HTTP_REFERER']);
}

function customer_multi_options()
{
	global $conn, $site;

	$action = post('multi_options_action');

	$customer_ids = $_POST['customer_ids'];

	if($action == 'disable'){
		foreach($customer_ids as $customer_id)
		{
			$update = $conn->exec("UPDATE `customers` SET `status` = 'disable' 					WHERE `id` = '".$customer_id."' ");
		}

		status_message('success',"Selected customers have been disabled.");
	}
	if($action == 'enable'){
		foreach($customer_ids as $customer_id)
		{
			$update = $conn->exec("UPDATE `customers` SET `status` = 'enabled' 					WHERE `id` = '".$customer_id."' ");
		}

		status_message('success',"Selected customers have been enabled.");
	}
	if($action == 'delete'){
		foreach($customer_ids as $customer_id)
		{
			$update = $conn->exec("DELETE FROM `customers` 										WHERE `id` = '".$customer_id."' ");
		}

		status_message('success',"Selected customers have been deleted.");
	}
	if($action == 'change_package'){
		$package_id = post("package_id");

		// get the package bouquets
		$query 					= $conn->query("SELECT * FROM `packages` WHERE `id` = '".$package_id."' ");
		$package 				= $query->fetch(PDO::FETCH_ASSOC);
		$bouquets 				= $package['bouquets'];

		foreach($customer_ids as $customer_id)
		{
			$update = $conn->exec("UPDATE `customers` SET `bouquet` = '".$bouquets."' 			WHERE `id` = '".$customer_id."' ");
		}

		status_message('success',"Selected customers have been updated with the new package / bouquets.");
	}
	if($action == 'change_expire_date'){
		$expire_date = post("expire_date");
		foreach($customer_ids as $customer_id)
		{
			$update = $conn->exec("UPDATE `customers` SET `expire_date` = '".$expire_date."' 	WHERE `id` = '".$customer_id."' ");
			$update = $conn->exec("UPDATE `customers` SET `status` = 'enabled' 					WHERE `id` = '".$customer_id."' ");
		}

		status_message('success',"Selected customers have been enabled.");
	}

	go($_SERVER['HTTP_REFERER']);
}

function customer_delete()
{
	global $conn, $global_settings;

	$customer_id = get('customer_id');

	$delete = $conn->exec("DELETE FROM `customers` WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	// $delete = $conn->exec("DELETE FROM `stalker_db`,`users` WHERE `id` = '".$customer_id."' ");
	
    // log_add("Customer account has been deleted.");
    status_message('success',"Customer account has been deleted.");
	go($_SERVER['HTTP_REFERER']);
}

function transcoding_profile_add()
{
	global $conn, $global_settings;

	$name 				= addslashes($_POST['name']);
	$name 				= trim($name);

	$data 				= '{"user_agent":"","ffmpeg_re":"no","cpu_gpu":"copy","video_codec":"libx264","cpu_video_codec":"libx264","gpu":"0","gpu_video_codec":"h264_nvenc","surfaces":"10","framerate":"0","preset":"0","profile":"baseline","screen_resolution":"copy","bitrate":"5120","audio_codec":"copy","audio_bitrate":"128","audio_sample_rate":"44100","ac":"2","fingerprint":"disable","fingerprint_type":"static_text","fingerprint_text":"","fingerprint_fontsize":"","fingerprint_color":"white","fingerprint_location":"top_left"}';

	$insert = $conn->exec("INSERT INTO `transcoding_profiles` 
        (`user_id`,`name`,`data`)
        VALUE
        ('".$_SESSION['account']['id']."',
        '".$name."',
        '".$data."'
    )");

    $profile_id = $conn->lastInsertId();
    
	status_message('success',"Transcoding Profile has been created.");
	go('dashboard.php?c=transcoding_profile&profile_id='.$profile_id);
}

function transcoding_profile_update()
{
	global $conn, $global_settings;

	$profile_id 		= $_POST['profile_id'];
	$name 				= $_POST['name'];
	$name 				= addslashes($name);
	$name 				= trim($name);

	$data 				= $_POST['data'];

	if($data['cpu_gpu'] == 'cpu') {
		$data['video_codec'] 		= $data['cpu_video_codec'];
	}
	if($data['cpu_gpu'] == 'gpu') {
		$data['video_codec'] 		= $data['gpu_video_codec'];
	}
	if($data['framerate'] == '') {
		$data['framerate'] 			= $data['0'];
	}
	$data 			= json_encode($data);

	debug($_POST);
	// die();

	$update = $conn->exec("UPDATE `transcoding_profiles` SET `name` = '".$name."'	WHERE `id` = '".$profile_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `transcoding_profiles` SET `data` = '".$data."'	WHERE `id` = '".$profile_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

	status_message('success',"Transcoding Profile has been updated.");
	go($_SERVER['HTTP_REFERER']);
}

function transcoding_profile_delete()
{
	global $conn, $global_settings;

	$profile_id = get('profile_id');

	$update = $conn->exec("UPDATE `streams` SET `transcoding_profile_id` = '0'	WHERE `transcoding_profile_id` = '".$profile_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("DELETE FROM `transcoding_profiles` WHERE `id` = '".$profile_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	
    // log_add("Customer account has been deleted.");
    status_message('success',"Transcoding Profile has been deleted. Please restart streams that were using this profile for changes to take effect");
	go($_SERVER['HTTP_REFERER']);
}

function restart_transcoding_profile_streams()
{
	global $conn, $site;

	$profile_id 		= $_GET['profile_id'];

	// get the stream data
	$query 				= $conn->query("SELECT * FROM `transcoding_profiles` WHERE `id` = '".$profile_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$profile 			= $query->fetch(PDO::FETCH_ASSOC);
	$profile_data		= json_decode($profile['data'], true);

	$query 				= $conn->query("SELECT `id` FROM `streams` WHERE `transcoding_profile_id` = '".$profile_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$stream_ids 		= $query->fetchAll(PDO::FETCH_ASSOC);

	foreach($stream_ids as $stream_id)
		{
			// get stream data
			// debug($stream_id);
			//die();
			$stream_raw 				=@file_get_contents($site['url']."actions.php?a=ajax_stream&stream_id=".$stream_id['id']);
			$stream 					= json_decode($stream_raw, true);

			// build the kill command
			$job['action'] = 'kill_pid';
			$job['command'] = 'kill -9 '.$stream[0]['running_pid'];

			// add the job to kill the stream ready for restart
			$insert = $conn->exec("INSERT INTO `jobs` 
		        (`server_id`,`job`)
		        VALUE
		        ('".$stream[0]['server_id']."','".json_encode($job)."')");

			// update settings for this stream
			$update = $conn->exec("UPDATE `streams` SET `user_agent` = '".$profile_data['user_agent']."' 								WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `ffmpeg_re` = '".$profile_data['ffmpeg_re']."' 									WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `cpu_gpu` = '".$profile_data['cpu_gpu']."' 										WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `video_codec` = '".$profile_data['video_codec']."' 								WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `gpu` = '".$profile_data['gpu']."' 												WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `surfaces` = '".$profile_data['surfaces']."' 									WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `framerate` = '".$profile_data['framerate']."' 									WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `preset` = '".$profile_data['preset']."' 										WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `profile` = '".$profile_data['profile']."' 										WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `screen_resolution` = '".$profile_data['screen_resolution']."' 					WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `bitrate` = '".$profile_data['bitrate']."' 										WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `audio_codec` = '".$profile_data['audio_codec']."' 								WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `audio_bitrate` = '".$profile_data['audio_bitrate']."' 							WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `audio_sample_rate` = '".$profile_data['audio_sample_rate']."' 					WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `ac` = '".$profile_data['ac']."' 												WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `fingerprint` = '".$profile_data['fingerprint']."' 								WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `fingerprint_type` = '".$profile_data['fingerprint_type']."' 					WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `fingerprint_text` = '".$profile_data['fingerprint_text']."' 					WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `fingerprint_fontsize` = '".$profile_data['fingerprint_fontsize']."' 			WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `fingerprint_color` = '".$profile_data['fingerprint_color']."' 					WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `fingerprint_location` = '".$profile_data['fingerprint_location']."' 			WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");

			// set some stream settings to default values
			$update = $conn->exec("UPDATE `streams` SET `enable` = 'yes' 			WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `status` = 'offline' 		WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `fps` = '' 					WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `speed` = '' 				WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `stream_uptime` = '' 		WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `pending_changes` = 'no' 	WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `job_status` = 'analysing' 	WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");

			/*
			$update = $conn->exec("UPDATE `streams` SET `enable` = 'yes' 			WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `status` = 'offline' 		WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `fps` = '' 					WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `speed` = '' 				WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `stream_uptime` = '' 		WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `pending_changes` = 'no' 	WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `job_status` = 'analysing' 	WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			*/
		}

	status_message('success',"Streams will restart shortly.");
	go($_SERVER['HTTP_REFERER']);
}

function stream_category_add()
{
	global $conn, $global_settings;
	
	$name 				= addslashes($_POST['name']);

	$insert = $conn->exec("INSERT INTO `stream_categories` 
        (`user_id`,`name`)
        VALUE
        ('".$_SESSION['account']['id']."',
        '".$name."'
    )");

    $stream_id = $conn->lastInsertId();
    
	// log_add("Stream Category has been added.");
	status_message('success',"Stream Category has been added.");
	go("dashboard.php?c=stream_categories");
}

function stream_category_delete()
{
	global $conn, $global_settings;

	$category_id = get('category_id');

	// remove the category_id from streams
	$query = $conn->query("UPDATE `streams` SET `category_id` = '1' WHERE `category_id` = '".$category_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

	// delete primary record
	$query = $conn->query("DELETE FROM `stream_categories` WHERE `id` = '".$category_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

	// log and wrap up
	// log_add("Stream Category Deleted:");
	status_message('success',"Stream Category has been deleted.");
	// return user to previous page
	go($_SERVER['HTTP_REFERER']);
}

function tv_series_add_old()
{
	global $conn, $global_settings;
	
	$server_id			= addslashes($_POST['server_id']);
	if(empty($_POST['server_id']) || $_POST['server_id'] == 0){

		status_message('danger',"You must select a server.");
		go($_SERVER['HTTP_REFERER']);
	}
	
	$name 				= addslashes($_POST['name']);
	$name 				= trim($name);

	// try the open movie db for meta data
	$url = 'http://www.omdbapi.com/?apikey=19354e2e&t='.urlencode($name);
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HEADER, false);
	$metadata = curl_exec($curl);
	curl_close($curl);

	$metadata = json_decode($metadata, true);

	if($metadata['Response'] == False){
		$year 			= '';
		$cover_photo	= '';
		$description	= '';
		$genre 			= '';
		$runtime 		= '';
		$language 		= '';
	}elseif($metadata['Response'] == True){
		$year 			= addslashes($metadata['Year']);
		$cover_photo	= addslashes($metadata['Poster']);
		$description	= addslashes($metadata['Plot']);
		$genre 			= addslashes($metadata['Genre']);
		$runtime 		= addslashes($metadata['Runtime']);
		$language 		= addslashes($metadata['Language']);
	}

	// add input stream
	$insert = $conn->exec("INSERT INTO `tv_series` 
        (`user_id`,`server_id`,`name`,`cover_photo`,`description`)
        VALUE
        ('".$_SESSION['account']['id']."',
        '".$server_id."',
        '".$name."',
        '".$cover_photo."',
        '".$description."'
    )");

    $series_id = $conn->lastInsertId();
    
	// log_add("TV Series has been added.");
	status_message('success',"TV Series has been added.");
	go('dashboard.php?c=tv_series_edit&id='.$series_id);
}

function tv_series_add()
{
	global $conn, $global_settings;
	
	$server_id			= addslashes($_POST['server_id']);
	if(empty($_POST['server_id']) || $_POST['server_id'] == 0){

		status_message('danger',"You must select a server.");
		go($_SERVER['HTTP_REFERER']);
	}
	
	$folder 				= addslashes($_POST['folder']);

	$folder 				= str_replace(array('"',"'",'\\','!','@','#','$','%','^','&','*','(',')','=','+',';',':','|','[',']','{','}','`','~',' '), '', $folder);
	$folder 				= str_replace(' ', '\ ', $folder);

	// more sanity checks
	if(strpos($folder, '/etc/') !== false) {
	    status_message('danger',"Security Alert: Dont try to scan the /etc/ folder");
    	go($_SERVER['HTTP_REFERER']);
	}
	if(strpos($folder, '/root/') !== false) {
	    status_message('danger',"Security Alert: Dont try to scan the /root/ folder");
    	go($_SERVER['HTTP_REFERER']);
	}
	if(strpos($folder, '/tmp/') !== false) {
	    status_message('danger',"Security Alert: Dont try to scan the /tmp/ folder");
    	go($_SERVER['HTTP_REFERER']);
	}

	// lets scan the folder
	$sql = "
        SELECT `id`,`wan_ip_address`,`http_stream_port` 
        FROM `headend_servers` 
        WHERE `id` = '".$server_id."' 
        AND `user_id` = '".$_SESSION['account']['id']."' 
    ";
    $query      = $conn->query($sql);
    $headend    = $query->fetch(PDO::FETCH_ASSOC);

    $folder_scan =@file_get_contents('http://'.$headend['wan_ip_address'].':'.$headend['http_stream_port'].'/scan_folder_folders.php?passcode=1372&folder_path='.$folder);

    $folder_scan = json_decode($folder_scan, true);

    if(isset($folder_scan[0])) {
    	foreach($folder_scan as $key => $value){

			$full_path 				= addslashes($value);

			// check to see if we are already watching this folder on this server
			$query = $conn->query("SELECT `id` FROM `tv_series` WHERE `server_id` = '".$server_id."' AND `watch_folder` = '".$full_path."' ");
			$channel = $query->fetch(PDO::FETCH_ASSOC);

			if(!isset($channel['id'])){
				// break to get folder for name
				$path_bits 				= explode("/", $full_path);

				$reverse_path_bits 		= array_reverse($path_bits);

				$name 					= $reverse_path_bits[0];
				$name 					= str_replace(array(".","-","_"), " ", $name);
				$name 					= trim($name);

				$metadata 				= get_metadata($name);

				// set meta defaults
				$year 			= '';
				$cover_photo	= '';
				$description	= '';
				$genre 			= '';
				$runtime 		= '';
				$language 		= '';

				if(isset($metadata) && $metadata['status'] == 'match'){
					if(isset($metadata['name']) && !empty($metadata['name'])){
						$name         		  	= addslashes($metadata['name']);
					}
					if(isset($metadata['Year']) && !empty($metadata['Year'])){
				        $year           		= addslashes($metadata['Year']);
			        }
			        if(isset($metadata['cover_photo']) && !empty($metadata['cover_photo'])){
			        	$cover_photo    		= addslashes($metadata['cover_photo']);
			        }
			        if(isset($metadata['description']) && !empty($metadata['description'])){
			        	$description    		= addslashes($metadata['description']);
			        }
			        if(isset($metadata['genre']) && !empty($metadata['genre'])){
			        	$genre          		= addslashes($metadata['genre']);
			        }
			        if(isset($metadata['runtime']) && !empty($metadata['runtime'])){
			        	$run        			= addslashes($metadata['runtime']);
			        }
			        if(isset($metadata['language']) && !empty($metadata['language'])){
			        	$lang       			= addslashes($metadata['language']);
			        }
			        if(isset($metadata['rating']) && !empty($metadata['rating'])){
			        	$rating       			= addslashes($metadata['rating']);
			        }
				}

				// add 
				$insert = $conn->exec("INSERT INTO `tv_series` 
			        (`user_id`,`server_id`,`name`,`cover_photo`,`description`,`watch_folder`,`rating`)
			        VALUE
			        ('".$_SESSION['account']['id']."',
			        '".$server_id."',
			        '".$name."',
			        '".$cover_photo."',
			        '".$description."',
			        '".$full_path."',
			        '".$rating."'
			    )");
			}
		}

		// log_add("Folder scan complete and media files added.");
		status_message('success',"Folder scan complete.");
	}else{
		// log_add("Folder scan complete but no media files were found.");
		status_message('warning',"Folder scan complete but no contents were found.");
	}
    
    go($_SERVER['HTTP_REFERER']);
}

function tv_series_update()
{
	global $conn, $global_settings;

	$series_id 						= addslashes($_POST['series_id']);

	// $data['server_id'] 				= addslashes($_POST['server_id']);

	$data['name'] 					= addslashes($_POST['name']);
	$data['name']					= trim($data['name']);

	$data['description'] 			= addslashes($_POST['description']);
	$data['description']			= trim($data['description']);

	$data['cover_photo'] 			= addslashes($_POST['cover_photo']);
	$data['cover_photo']			= trim($data['cover_photo']);
	
	$update = $conn->exec("UPDATE `tv_series` SET `name` = '".$data['name']."' WHERE `id` = '".$series_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `tv_series` SET `description` = '".$data['description']."' WHERE `id` = '".$series_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `tv_series` SET `cover_photo` = '".$data['cover_photo']."' WHERE `id` = '".$series_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	
    // log_add("TV Series changes have been saved.");
    status_message('success',"TV Series changes have been saved.");
    go($_SERVER['HTTP_REFERER']);
}

function tv_series_delete()
{
	global $conn, $global_settings;

	$series_id = get('series_id');

	// get all episodes to delete from bouquets_content
	$query = $conn->query("SELECT `id` FROM `tv_series_files` WHERE `tv_series_id` = '".$series_id."' ");
	$tv_series_files = $query->fetchAll(PDO::FETCH_ASSOC);
	
	// remove from bouquets_content
	foreach($tv_series_files as $tv_series_file){
		$delete = $conn->exec("DELETE FROM `bouquets_content` WHERE `content_id` = '".$tv_series_file['id']."' ");
	}

	$delete = $conn->exec("DELETE FROM `tv_series_files` WHERE `tv_series_id` = '".$series_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$delete = $conn->exec("DELETE FROM `tv_series` WHERE `id` = '".$series_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	
    // log_add("TV Series has been deleted.");
    status_message('success',"TV Series has been deleted.");
	go($_SERVER['HTTP_REFERER']);
}

function tv_series_episode_add()
{
	global $conn, $global_settings;
	
	$server_id			= addslashes($_POST['server_id']);

	$series_id			= addslashes($_POST['series_id']);
	
	$name 				= addslashes($_POST['name']);
	$name 				= trim($name);

	$file_location 		= addslashes($_POST['file_location']);
	$file_location 		= trim($file_location);

	// get next number in the order
	$query = $conn->query("SELECT `order` FROM `tv_series_files` WHERE `tv_series_id` = '".$series_id."' AND `user_id` = '".$_SESSION['account']['id']."' ORDER BY `order` DESC LIMIT 1");
	$bits = $query->fetch(PDO::FETCH_ASSOC);
	$next_order = ($bits['order'] + 1);
		
	// add input stream
	$insert = $conn->exec("INSERT INTO `tv_series_files` 
        (`user_id`,`server_id`,`tv_series_id`,`name`,`file_location`,`order`)
        VALUE
        ('".$_SESSION['account']['id']."',
        '".$server_id."',
        '".$series_id."',
        '".$name."',
        '".$file_location."',
        '".$next_order."'
    )");

    $series_id = $conn->lastInsertId();
    
	// log_add("Episode has been added.");
	status_message('success',"Episode has been added.");
    go($_SERVER['HTTP_REFERER']);
}

function tv_series_episode_delete()
{
	global $conn, $global_settings;

	$series_file_id = get('id');

	$delete = $conn->exec("DELETE FROM `bouquets_content` WHERE `content_id` = '".$series_file_id."' ");

	$delete = $conn->exec("DELETE FROM `tv_series_files` WHERE `id` = '".$series_file_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	
    // log_add("TV Series has been deleted.");
    status_message('success',"Episode has been deleted.");
	go($_SERVER['HTTP_REFERER']);
}

function tv_series_update_order()
{
	global $conn, $global_settings;

	foreach($_POST['name'] as $key => $value) {
		$update = $conn->exec("UPDATE `tv_series_files` SET `name` = '".addslashes($value)."' WHERE `id` = '".$key."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	}

	// log_add("TV Series has been updated.");
    status_message('success',"TV Series episodes have been updated.");
	go($_SERVER['HTTP_REFERER']);
}

function tv_series_start()
{
	global $conn, $global_settings;

	$series_id = get('series_id');

	$delete = $conn->exec("UPDATE `tv_series_files` SET `enable` = 'yes' WHERE `id` = '".$series_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	
    // log_add("TV Series will start streaming shortly.");
    status_message('success',"TV Series will start streaming shortly.");
	go($_SERVER['HTTP_REFERER']);
}

function tv_series_stop()
{
	global $conn, $global_settings;

	$series_id = get('series_id');

	$delete = $conn->exec("UPDATE `tv_series_files` SET `enable` = 'no' WHERE `id` = '".$series_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	
    // log_add("TV Series will stop streaming shortly.");
    status_message('success',"TV Series will stop streaming shortly.");
	go($_SERVER['HTTP_REFERER']);
}

function vod_watch_add()
{
	global $conn, $global_settings;
	
	$server_id			= addslashes($_POST['server_id']);
	if(empty($_POST['server_id']) || $_POST['server_id'] == 0){

		status_message('danger',"You must select a server.");
		go($_SERVER['HTTP_REFERER']);
	}
	
	$folder 			= addslashes(post('folder'));
	$folder 			= trim($folder);

	// add input stream
	$insert = $conn->exec("INSERT INTO `vod_watch` 
        (`user_id`,`server_id`,`folder`)
        VALUE
        ('".$_SESSION['account']['id']."',
        '".$server_id."',
        '".$folder."'
    )");
    
	// log_add("Video on Demand has been added.");
	status_message('success',"VoD Watch Folder has been added.");
	go($_SERVER['HTTP_REFERER']);
}

function vod_add()
{
	global $conn, $global_settings;
	
	$server_id			= addslashes($_POST['server_id']);
	if(empty($_POST['server_id']) || $_POST['server_id'] == 0){

		status_message('danger',"You must select a server.");
		go($_SERVER['HTTP_REFERER']);
	}
	
	$name 				= addslashes($_POST['name']);
	$name 				= trim($name);

	// try the open movie db for meta data
	$url = 'http://www.omdbapi.com/?apikey=19354e2e&t='.urlencode($name);
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HEADER, false);
	$metadata = curl_exec($curl);
	curl_close($curl);

	$metadata = json_decode($metadata, true);

	if($metadata['Response'] == False){
		$year 			= '';
		$cover_photo	= '';
		$description	= '';
		$genre 			= '';
		$runtime 		= '';
		$language 		= '';
	}elseif($metadata['Response'] == True){
		$year 			= addslashes($metadata['Year']);
		$cover_photo	= addslashes($metadata['Poster']);
		$description	= addslashes($metadata['Plot']);
		$genre 			= addslashes($metadata['Genre']);
		$runtime 		= addslashes($metadata['Runtime']);
		$language 		= addslashes($metadata['Language']);
	}

	// add input stream
	$insert = $conn->exec("INSERT INTO `vod` 
        (`user_id`,`server_id`,`name`,`year`,`cover_photo`,`description`,`genre`,`runtime`,`language`)
        VALUE
        ('".$_SESSION['account']['id']."',
        '".$server_id."',
        '".$name."',
        '".$year."',
        '".$cover_photo."',
        '".$description."',
        '".$genre."',
        '".$runtime."',
        '".$language."'
    )");

    $vod_id = $conn->lastInsertId();
    
	// log_add("Video on Demand has been added.");
	status_message('success',"Video on Demand has been added.");
	go('dashboard.php?c=vod_edit&id='.$vod_id);
}

function vod_update()
{
	global $conn, $global_settings;

	$vod_id 						= addslashes($_POST['vod_id']);

	$data['category_id'] 			= addslashes($_POST['category_id']);

	$data['name'] 					= addslashes($_POST['name']);
	$data['name']					= trim($data['name']);

	$data['description'] 			= addslashes($_POST['description']);
	$data['description']			= trim($data['description']);

	$data['cover_photo'] 			= addslashes($_POST['cover_photo']);
	$data['cover_photo']			= trim($data['cover_photo']);

	$data['year'] 					= addslashes($_POST['year']);
	$data['year']					= trim($data['year']);

	$data['genre'] 					= addslashes($_POST['genre']);
	$data['genre']					= trim($data['genre']);

	$data['runtime'] 				= addslashes($_POST['runtime']);
	$data['runtime']				= trim($data['runtime']);

	$data['language'] 				= addslashes($_POST['language']);
	$data['language']				= trim($data['language']);

	$data['file_location'] 			= addslashes($_POST['file_location']);
	$data['file_location']			= trim($data['file_location']);
	
	$update = $conn->exec("UPDATE `vod` SET `category_id` = '".$data['category_id']."' WHERE `id` = '".$vod_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `vod` SET `name` = '".$data['name']."' WHERE `id` = '".$vod_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `vod` SET `description` = '".$data['description']."' WHERE `id` = '".$vod_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `vod` SET `cover_photo` = '".$data['cover_photo']."' WHERE `id` = '".$vod_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `vod` SET `year` = '".$data['year']."' WHERE `id` = '".$vod_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `vod` SET `genre` = '".$data['genre']."' WHERE `id` = '".$vod_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `vod` SET `runtime` = '".$data['runtime']."' WHERE `id` = '".$vod_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `vod` SET `language` = '".$data['language']."' WHERE `id` = '".$vod_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `vod` SET `file_location` = '".$data['file_location']."' WHERE `id` = '".$vod_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

    // log_add("Video on Demand changes have been saved.");
    status_message('success',"Video on Demand changes have been saved.");
    go($_SERVER['HTTP_REFERER']);
}

function vod_delete()
{
	global $conn, $global_settings;

	$vod_id = get('vod_id');

	$delete = $conn->exec("DELETE FROM `vod` WHERE `id` = '".$vod_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	
	// remove from bouquets_content
	$delete = $conn->exec("DELETE FROM `bouquets_content` WHERE `content_id` = '".$vod_id."' ");

    // log_add("Video on Demand has been deleted.");
    status_message('success',"Video on Demand has been deleted.");
	go($_SERVER['HTTP_REFERER']);
}

function channel_add()
{
	global $conn, $global_settings;
	
	$server_id			= addslashes($_POST['server_id']);
	if(empty($_POST['server_id']) || $_POST['server_id'] == 0){

		status_message('danger',"You must select a server.");
		go($_SERVER['HTTP_REFERER']);
	}

	$type 					= get('type');

	$name 					= get('name');
	
	$folder 				= addslashes($_POST['folder']);

	$folder 				= str_replace(array('"',"'",'\\','!','@','#','$','%','^','&','*','(',')','=','+',';',':','|','[',']','{','}','`','~',' '), '', $folder);

	// more sanity checks
	if(strpos($folder, '/etc/') !== false) {
	    status_message('danger',"Security Alert: Dont try to scan the /etc/ folder");
    	go($_SERVER['HTTP_REFERER']);
	}
	if(strpos($folder, '/root/') !== false) {
	    status_message('danger',"Security Alert: Dont try to scan the /root/ folder");
    	go($_SERVER['HTTP_REFERER']);
	}
	if(strpos($folder, '/tmp/') !== false) {
	    status_message('danger',"Security Alert: Dont try to scan the /tmp/ folder");
    	go($_SERVER['HTTP_REFERER']);
	}

	if($type == 'multi'){
		// lets scan the folder
		$sql = "
	        SELECT `id`,`wan_ip_address`,`http_stream_port` 
	        FROM `headend_servers` 
	        WHERE `id` = '".$server_id."' 
	        AND `user_id` = '".$_SESSION['account']['id']."' 
	    ";
	    $query      = $conn->query($sql);
	    $headend    = $query->fetch(PDO::FETCH_ASSOC);

	    $folder_scan =@file_get_contents('http://'.$headend['wan_ip_address'].':'.$headend['http_stream_port'].'/scan_folder_folders.php?passcode=1372&folder_path='.$folder);

	    $folder_scan = json_decode($folder_scan, true);

	    if(isset($folder_scan[0])) {
	    	foreach($folder_scan as $key => $value){

				$full_path 				= addslashes($value);

				// check to see if we are already watching this folder on this server
				$query = $conn->query("SELECT `id` FROM `channels` WHERE `server_id` = '".$server_id."' AND `watch_folder` = '".$full_path."' ");
				$channel = $query->fetch(PDO::FETCH_ASSOC);

				if(!isset($channel['id'])){
					// break to get folder for name
					$path_bits 				= explode("/", $full_path);

					$reverse_path_bits 		= array_reverse($path_bits);

					$name 					= $reverse_path_bits[0];
					$name 					= str_replace(array(".","-","_"), " ", $name);
					$name 					= trim($name);

					$metadata 				= get_metadata($name);

					// set meta defaults
					$year 			= '';
					$cover_photo	= '';
					$description	= '';
					$genre 			= '';
					$runtime 		= '';
					$language 		= '';

					if(isset($metadata) && $metadata['status'] == 'match'){
						if(isset($metadata['name']) && !empty($metadata['name'])){
							$name         		  	= addslashes($metadata['name']);
						}
						if(isset($metadata['year']) && !empty($metadata['year'])){
					        $year           		= addslashes($metadata['year']);
				        }
				        if(isset($metadata['cover_photo']) && !empty($metadata['cover_photo'])){
				        	$cover_photo    		= addslashes($metadata['cover_photo']);
				        }
				        if(isset($metadata['description']) && !empty($metadata['description'])){
				        	$description    		= addslashes($metadata['description']);
				        }
				        if(isset($metadata['genre']) && !empty($metadata['genre'])){
				        	$genre          		= addslashes($metadata['genre']);
				        }
				        if(isset($metadata['runtime']) && !empty($metadata['runtime'])){
				        	$run        			= addslashes($metadata['runtime']);
				        }
				        if(isset($metadata['language']) && !empty($metadata['language'])){
				        	$lang       			= addslashes($metadata['language']);
				        }
					}

					// add 
					$insert = $conn->exec("INSERT INTO `channels` 
				        (`user_id`,`server_id`,`name`,`cover_photo`,`description`,`watch_folder`)
				        VALUE
				        ('".$_SESSION['account']['id']."',
				        '".$server_id."',
				        '".$name."',
				        '".$cover_photo."',
				        '".$description."',
				        '".$full_path."'
				    )");
				}
			}

			// log_add("Folder scan complete and media files added.");
			status_message('success',"Folder scan complete.");
		}else{
			// log_add("Folder scan complete but no media files were found.");
			status_message('warning',"Folder scan complete but no contents were found.");
		}
	}else{
		$full_path = $folder;
		// check to see if we are already watching this folder on this server
		$query = $conn->query("SELECT `id` FROM `channels` WHERE `server_id` = '".$server_id."' AND `watch_folder` = '".$full_path."' ");
		$channel = $query->fetch(PDO::FETCH_ASSOC);

		if(!isset($channel['id'])){
			// break to get folder for name
			$path_bits 				= explode("/", $full_path);

			$reverse_path_bits 		= array_reverse($path_bits);

			$name 					= $reverse_path_bits[0];
			$name 					= str_replace(array(".","-","_"), " ", $name);
			$name 					= trim($name);

			$metadata 				= get_metadata($name);

			// set meta defaults
			$year 			= '';
			$cover_photo	= '';
			$description	= '';
			$genre 			= '';
			$runtime 		= '';
			$language 		= '';

			if(isset($metadata) && $metadata['status'] == 'match'){
				if(isset($metadata['name']) && !empty($metadata['name'])){
					$name         		  	= addslashes($metadata['name']);
				}
				if(isset($metadata['year']) && !empty($metadata['year'])){
			        $year           		= addslashes($metadata['year']);
		        }
		        if(isset($metadata['cover_photo']) && !empty($metadata['cover_photo'])){
		        	$cover_photo    		= addslashes($metadata['cover_photo']);
		        }
		        if(isset($metadata['description']) && !empty($metadata['description'])){
		        	$description    		= addslashes($metadata['description']);
		        }
		        if(isset($metadata['genre']) && !empty($metadata['genre'])){
		        	$genre          		= addslashes($metadata['genre']);
		        }
		        if(isset($metadata['runtime']) && !empty($metadata['runtime'])){
		        	$run        			= addslashes($metadata['runtime']);
		        }
		        if(isset($metadata['language']) && !empty($metadata['language'])){
		        	$lang       			= addslashes($metadata['language']);
		        }
			}

			// add 
			$insert = $conn->exec("INSERT INTO `channels` 
		        (`user_id`,`server_id`,`name`,`cover_photo`,`description`,`watch_folder`)
		        VALUE
		        ('".$_SESSION['account']['id']."',
		        '".$server_id."',
		        '".$name."',
		        '".$cover_photo."',
		        '".$description."',
		        '".$full_path."'
		    )");
		}
	}
    
    go($_SERVER['HTTP_REFERER']);
}

function channel_update()
{
	global $conn, $global_settings;

	$id 								= addslashes($_POST['id']);

	// $data['server_id'] 				= addslashes($_POST['server_id']);

	$data['name'] 						= addslashes($_POST['name']);
	$data['name']						= trim($data['name']);

	$data['description'] 				= addslashes($_POST['description']);
	$data['description']				= trim($data['description']);

	$data['cover_photo'] 				= addslashes($_POST['cover_photo']);
	$data['cover_photo']				= trim($data['cover_photo']);

	$data['transcoding_profile_id']		= post('transcoding_profile_id');
	
	$update = $conn->exec("UPDATE `channels` SET `name` = '".$data['name']."' 											WHERE `id` = '".$id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `channels` SET `description` = '".$data['description']."' 							WHERE `id` = '".$id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `channels` SET `cover_photo` = '".$data['cover_photo']."' 							WHERE `id` = '".$id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `channels` SET `transcoding_profile_id` = '".$data['transcoding_profile_id']."' 		WHERE `id` = '".$id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	
    // log_add("Channel changes have been saved.");
    status_message('success',"24/7 TV Channel changes have been saved.");
    go($_SERVER['HTTP_REFERER']);
}

function channel_delete()
{
	global $conn, $global_settings;

	$id = get('id');

	// get all episodes to delete from bouquets_content
	$query = $conn->query("SELECT `id` FROM `channels_files` WHERE `channel_id` = '".$id."' ");
	$channel_files = $query->fetchAll(PDO::FETCH_ASSOC);
	
	// remove from bouquets_content
	foreach($channel_files as $channel_file){
		$delete = $conn->exec("DELETE FROM `bouquets_content` WHERE `content_id` = '".$channel_file['id']."' ");
	}

	$delete = $conn->exec("DELETE FROM `channels_files` WHERE `channel_id` = '".$id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$delete = $conn->exec("DELETE FROM `channels` WHERE `id` = '".$id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	
	// delete from stalker
	$delete = $conn->exec("DELETE FROM `stalker_db`.`itv` WHERE `id` = '247".$id."' ");

    // log_add("Channel has been deleted.");
    status_message('success',"Channel has been deleted.");
	go($_SERVER['HTTP_REFERER']);
}

function channel_episode_add()
{
	global $conn, $global_settings;

	$server_id			= addslashes($_POST['server_id']);

	$id					= addslashes($_POST['id']);
	
	$name 				= addslashes($_POST['name']);
	$name 				= trim($name);

	$file_location 		= addslashes($_POST['file_location']);
	$file_location 		= trim($file_location);

	// get next number in the order
	$query = $conn->query("SELECT `order` FROM `channels_files` WHERE `channel_id` = '".$id."' AND `user_id` = '".$_SESSION['account']['id']."' ORDER BY `order` DESC LIMIT 1");
	$bits = $query->fetch(PDO::FETCH_ASSOC);
	if(isset($bits['order'])) {
		$next_order = ($bits['order'] + 1);
	}else{
		$next_order = 0;
	}
		
	// add input stream
	$insert = $conn->exec("INSERT IGNORE INTO `channels_files` 
        (`user_id`,`server_id`,`channel_id`,`name`,`file_location`,`order`)
        VALUE
        ('".$_SESSION['account']['id']."',
        '".$server_id."',
        '".$id."',
        '".$name."',
        '".$file_location."',
        '".$next_order."'
    )");
    
	// log_add("Episode has been added.");
	status_message('success',"Episode has been added.");
    go($_SERVER['HTTP_REFERER']);
}

function channel_episode_delete()
{
	global $conn, $global_settings;

	$id = get('id');

	$delete = $conn->exec("DELETE FROM `bouquets_content` WHERE `content_id` = '".$id."' ");

	$delete = $conn->exec("DELETE FROM `channels_files` WHERE `id` = '".$id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	
    // log_add("Channel Episode has been deleted.");
    status_message('success',"Channel Episode has been deleted.");
	go($_SERVER['HTTP_REFERER']);
}

function channel_episode_delete_all()
{
	global $conn, $global_settings;

	$id = get('id');

	// get all episodes to delete from bouquets_content
	$query = $conn->query("SELECT `id` FROM `channels_files` WHERE `channel_id` = '".$id."' ");
	$channel_files = $query->fetchAll(PDO::FETCH_ASSOC);
	
	// remove from bouquets_content
	foreach($channel_files as $channel_file){
		$delete = $conn->exec("DELETE FROM `bouquets_content` WHERE `content_id` = '".$channel_file['id']."' ");
	}

	$delete = $conn->exec("DELETE FROM `channels_files` WHERE `channel_id` = '".$id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	
    status_message('success',"All Channel Episodes have been deleted.");
	go($_SERVER['HTTP_REFERER']);
}

function channel_episode_scan_folder()
{
	global $conn, $global_settings;

	$server_id			= addslashes($_POST['server_id']);

	$id					= addslashes($_POST['id']);
	
	$folder_path 		= $_POST['folder_path'];
	$folder_path 		= trim($folder_path);

	// sanity checks
	$folder_path 		= str_replace(array('"',"'",'\\','!','@','#','$','%','^','&','*','(',')','=','+',';',':','|','[',']','{','}','`','~',' '), '', $folder_path);

	// more sanity checks
	if(strpos($folder_path, '/etc/') !== false) {
	    status_message('danger',"Security Alert: Dont try to scan the /etc/ folder");
    	go($_SERVER['HTTP_REFERER']);
	}
	if(strpos($folder_path, '/root/') !== false) {
	    status_message('danger',"Security Alert: Dont try to scan the /root/ folder");
    	go($_SERVER['HTTP_REFERER']);
	}
	if(strpos($folder_path, '/tmp/') !== false) {
	    status_message('danger',"Security Alert: Dont try to scan the /tmp/ folder");
    	go($_SERVER['HTTP_REFERER']);
	}

	// lets scan the folder
	$sql = "
        SELECT `id`,`wan_ip_address`,`http_stream_port` 
        FROM `headend_servers` 
        WHERE `id` = '".$server_id."' 
        AND `user_id` = '".$_SESSION['account']['id']."' 
    ";
    $query      = $conn->query($sql);
    $headend    = $query->fetch(PDO::FETCH_ASSOC);

    $folder_scan =@file_get_contents('http://'.$headend['wan_ip_address'].':'.$headend['http_stream_port'].'/scan_folder_files.php?passcode=1372&folder_path='.$folder_path);

    $folder_scan = json_decode($folder_scan, true);

    if(isset($folder_scan[0])) {
    	foreach($folder_scan as $key => $value){

    		$name 				= $key;
			$file_location 		= addslashes($value);

			// get next number in the order
			$query = $conn->query("SELECT `order` FROM `channels_files` WHERE `channel_id` = '".$id."' AND `user_id` = '".$_SESSION['account']['id']."' ORDER BY `order` DESC LIMIT 1");
			$bits = $query->fetch(PDO::FETCH_ASSOC);
			if(isset($bits['order'])) {
				$next_order = ($bits['order'] + 1);
			}else{
				$next_order = 0;
			}
				
			// add input stream
			$insert = $conn->exec("INSERT IGNORE INTO `channels_files` 
		        (`user_id`,`server_id`,`channel_id`,`name`,`file_location`,`order`)
		        VALUE
		        ('".$_SESSION['account']['id']."',
		        '".$server_id."',
		        '".$id."',
		        '".$name."',
		        '".$file_location."',
		        '".$next_order."'
		    )");
		}

		// log_add("Folder scan complete and media files added.");
		status_message('success',"Folder scan complete and media files added.");
	}else{
		// log_add("Folder scan complete but no media files were found.");
		status_message('warning',"Folder scan complete but no media files were found.");
	}
	
    go($_SERVER['HTTP_REFERER']);
}

function channel_update_order()
{
	global $conn, $global_settings;

	foreach($_POST['name'] as $key => $value) {
		$update = $conn->exec("UPDATE `channels_files` SET `name` = '".addslashes($value)."' WHERE `id` = '".$key."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	}

	foreach($_POST['file_location'] as $key => $value) {
		$update = $conn->exec("UPDATE `channels_files` SET `file_location` = '".addslashes($value)."' WHERE `id` = '".$key."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	}

	// log_add("Channel has been updated.");
    status_message('success',"Channel episodes have been updated.");
	go($_SERVER['HTTP_REFERER']);
}

function channel_start()
{
	global $conn, $global_settings;

	$id = get('id');

	$update = $conn->exec("UPDATE `channels` SET `enable` = 'yes' WHERE `id` = '".$id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

	$update = $conn->exec("UPDATE `channels` SET `status` = 'starting' WHERE `id` = '".$id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	
    // log_add("Channel will start streaming shortly.");
    status_message('success',"Channel will start streaming shortly.");
	go($_SERVER['HTTP_REFERER']);
}

function channel_stop()
{
	global $conn, $global_settings;

	$id = get('id');

	$update = $conn->exec("UPDATE `channels` SET `enable` = 'no' WHERE `id` = '".$id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `channels` SET `status` = 'offline' WHERE `id` = '".$id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	
    // log_add("Channel will stop streaming shortly.");
    status_message('success',"Channel will stop streaming shortly.");
	go($_SERVER['HTTP_REFERER']);
}

function dns_add()
{
	global $conn, $global_settings;
		
	$server_id 			= addslashes($_POST['server_id']);
	$query 				= $conn->query("SELECT `wan_ip_address` FROM `headend_servers` WHERE `id` = '".$server_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$server 			= $query->fetch(PDO::FETCH_ASSOC);

	$hostname 			= addslashes($_POST['hostname']);
	$hostname 			= trim($hostname);
	$hostname 			= str_replace(array('.', ' ', '_'), '-', $hostname);

	$domain 			= addslashes($_POST['domain']);

	// check if hostname already in use
	$query = $conn->query("SELECT `id` FROM `addon_dns` WHERE `hostname` = '".$hostname."' AND `domain` = '".$domain."' ");
	$existing_record = $query->fetch(PDO::FETCH_ASSOC);
	if(isset($existing_record['id'])){
		status_message('danger',"DNS Host is already taken.");
		go($_SERVER['HTTP_REFERER']);
		die();
	}

	$cloudflare 		= cf_add_host($hostname, $domain, $server['wan_ip_address']);
	
	debug($_POST);
	debug($cloudflare);
	$insert = $conn->exec("INSERT INTO `addon_dns` 
        (`user_id`,`server_id`,`hostname`,`domain`,`cf_domain_id`)
        VALUE
        ('".$_SESSION['account']['id']."',
        '".$server_id."',
        '".$hostname."',
        '".$domain."',
        '".$cloudflare['domain_id']."'
    )");

    $record_id = $conn->lastInsertId();

	// log_add("DNS Host has been added.");
	status_message('success',"DNS Host has been added.");
	go($_SERVER['HTTP_REFERER']);
}

function dns_update()
{
	global $conn, $global_settings;
	
	$customer_id 		= addslashes($_POST['customer_id']);
	$status 			= addslashes($_POST['status']);
	$first_name 		= addslashes($_POST['first_name']);
	$last_name 			= addslashes($_POST['last_name']);
	$email 				= addslashes($_POST['email']);
	$username			= addslashes($_POST['username']);
	$password 			= addslashes($_POST['password']);
	$max_connections 	= addslashes($_POST['max_connections']);
	$notes 				= addslashes($_POST['notes']);
	
	$update = $conn->exec("UPDATE `customers` SET `status` = '".$status."' WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `customers` SET `first_name` = '".$first_name."' WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `customers` SET `last_name` = '".$last_name."' WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `customers` SET `email` = '".$email."' WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `customers` SET `username` = '".$username."' WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `customers` SET `password` = '".$password."' WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `customers` SET `max_connections` = '".$max_connections."' WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `customers` SET `notes` = '".$notes."' WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

	// log_add("Customer has been updated.");
	status_message('success',"Customer account has been updated.");
	go($_SERVER['HTTP_REFERER']);
}

function dns_delete()
{
	global $conn, $global_settings;

	$id = get('id');

	$update = $conn->exec("DELETE FROM `addon_dns` WHERE `id` = '".$id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	
    // log_add("DNS record has been deleted.");
    status_message('success',"DNS record has been deleted.");
	go($_SERVER['HTTP_REFERER']);
}

function stream_multi_options()
{
	global $conn, $site;

	$action = post('multi_options_action');

	$stream_ids = $_POST['stream_ids'];

	if($action == 'start'){
		foreach($stream_ids as $stream_id)
		{
			$update = $conn->exec("UPDATE `streams` SET `enable` = 'yes' 			WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `status` = 'offline' 		WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `fps` = '' 					WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `speed` = '' 				WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `stream_uptime` = '' 		WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `pending_changes` = 'no' 	WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `job_status` = 'analysing' 	WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

			$update = $conn->exec("UPDATE `streams` SET `enable` = 'yes' 			WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `status` = 'offline' 		WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `fps` = '' 					WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `speed` = '' 				WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `stream_uptime` = '' 		WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `pending_changes` = 'no' 	WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `job_status` = 'analysing' 	WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		}

		status_message('success',"Selected streams will start shortly.");
	}
	if($action == 'stop'){
		foreach($stream_ids as $stream_id)
		{
			$update = $conn->exec("UPDATE `streams` SET `enable` = 'no' 			WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `status` = 'offline' 		WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `fps` = '' 					WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `speed` = '' 				WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `stream_uptime` = '' 		WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `pending_changes` = 'no' 	WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `job_status` = 'none'	 	WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

			$update = $conn->exec("UPDATE `streams` SET `enable` = 'no' 			WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `status` = 'offline' 		WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `fps` = '' 					WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `speed` = '' 				WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `stream_uptime` = '' 		WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `pending_changes` = 'no' 	WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `job_status` = 'none' 		WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		}

		status_message('success',"Selected streams will stop shortly.");
	}
	if($action == 'restart'){
		foreach($stream_ids as $stream_id)
		{
			$stream_raw 				=@file_get_contents($site['url']."/actions.php?a=ajax_stream&stream_id=".$stream_id);
			$stream 					= json_decode($stream_raw, true);

			$job['action'] = 'kill_pid';
			$job['command'] = 'kill -9 '.$stream[0]['running_pid'];

			// add the job
			$insert = $conn->exec("INSERT INTO `jobs` 
		        (`server_id`,`job`)
		        VALUE
		        ('".$stream[0]['server_id']."','".json_encode($job)."')");

			$update = $conn->exec("UPDATE `streams` SET `enable` = 'yes' 			WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `status` = 'offline' 		WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `fps` = '' 					WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `speed` = '' 				WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `stream_uptime` = '' 		WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `pending_changes` = 'no' 	WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `job_status` = 'analysing' 	WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

			$update = $conn->exec("UPDATE `streams` SET `enable` = 'yes' 			WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `status` = 'offline' 		WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `fps` = '' 					WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `speed` = '' 				WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `stream_uptime` = '' 		WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `pending_changes` = 'no' 	WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `job_status` = 'analysing' 	WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		}

		status_message('success',"Selected streams will restart shortly.");
	}
	if($action == 'delete'){
		foreach($stream_ids as $stream_id)
		{
			$stream_raw 				=@file_get_contents($site['url']."/actions.php?a=ajax_stream&stream_id=".$stream_id);
			$stream 					= json_decode($stream_raw, true);

			$job['action'] = 'kill_pid';
			$job['command'] = 'kill -9 '.$stream[0]['running_pid'];

			// add the job
			$insert = $conn->exec("INSERT INTO `jobs` 
		        (`server_id`,`job`)
		        VALUE
		        ('".$stream[0]['server_id']."','".json_encode($job)."')");

			$update = $conn->exec("DELETE FROM `streams` WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

			$update = $conn->exec("DELETE FROM `streams` WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		}

		status_message('success',"Selected streams have been deleted.");
	}
	if($action == 'change_server'){

		$server_id = post('server');

		foreach($stream_ids as $stream_id)
		{
			$stream_raw 				=@file_get_contents($site['url']."/actions.php?a=ajax_stream&stream_id=".$stream_id);
			$stream 					= json_decode($stream_raw, true);

			$job['action'] = 'kill_pid';
			$job['command'] = 'kill -9 '.$stream[0]['running_pid'];

			// add the job
			$insert = $conn->exec("INSERT INTO `jobs` 
		        (`server_id`,`job`)
		        VALUE
		        ('".$stream[0]['server_id']."','".json_encode($job)."')");

			$update = $conn->exec("UPDATE `streams` SET `server_id` = '".$server_id."' 		WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `enable` = 'yes' 					WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `status` = 'offline' 				WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `fps` = '' 							WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `speed` = '' 						WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `stream_uptime` = '' 				WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `pending_changes` = 'no' 			WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `job_status` = 'analysing' 			WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

			$update = $conn->exec("UPDATE `streams` SET `server_id` = '".$server_id."' 			WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `source_server_id` = '".$server_id."' 	WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `enable` = 'yes' 						WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `status` = 'offline' 					WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `fps` = '' 								WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `speed` = '' 							WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `stream_uptime` = '' 					WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `pending_changes` = 'no' 				WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `job_status` = 'analysing' 				WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		}

		status_message('success',"Selected streams will migrate shortly.");
	}
	if($action == 'change_category'){

		$category_id = post('category_id');

		foreach($stream_ids as $stream_id)
		{
			$update = $conn->exec("UPDATE `streams` SET `category_id` = '".$category_id."' 		WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `category_id` = '".$category_id."' 		WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		}

		status_message('success',"Categories have been updated.");
	}
	if($action == 'enable_ondemand'){

		foreach($stream_ids as $stream_id)
		{
			$update = $conn->exec("UPDATE `streams` SET `ondemand` = 'yes' 		WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `ondemand` = 'yes' 		WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

			$update = $conn->exec("UPDATE `streams` SET `enable` = 'yes' 			WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `status` = 'offline' 		WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `fps` = '' 					WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `speed` = '' 				WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `stream_uptime` = '' 		WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `pending_changes` = 'no' 	WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `job_status` = 'analysing' 	WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

			$update = $conn->exec("UPDATE `streams` SET `enable` = 'yes' 			WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `status` = 'offline' 		WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `fps` = '' 					WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `speed` = '' 				WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `stream_uptime` = '' 		WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `pending_changes` = 'no' 	WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `job_status` = 'analysing' 	WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		}

		status_message('success',"On-Demand has been enabled for selected streams.");
	}
	if($action == 'enable_always_on'){

		foreach($stream_ids as $stream_id)
		{
			$update = $conn->exec("UPDATE `streams` SET `ondemand` = 'no' 		WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `ondemand` = 'no' 		WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

			$update = $conn->exec("UPDATE `streams` SET `enable` = 'yes' 			WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `status` = 'offline' 		WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `fps` = '' 					WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `speed` = '' 				WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `stream_uptime` = '' 		WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `pending_changes` = 'no' 	WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `job_status` = 'analysing' 	WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

			$update = $conn->exec("UPDATE `streams` SET `enable` = 'yes' 			WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `status` = 'offline' 		WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `fps` = '' 					WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `speed` = '' 				WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `stream_uptime` = '' 		WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `pending_changes` = 'no' 	WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `job_status` = 'analysing' 	WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		}

		status_message('success',"On-Demand has been enabled for selected streams.");
	}

	go($_SERVER['HTTP_REFERER']);
}

function channels_stop_all()
{
	global $conn, $global_settings;

	$update = $conn->exec("UPDATE `channels` SET `enable` = 'no' 			WHERE `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `channels` SET `status` = 'offline' 		WHERE `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `channels` SET `uptime` = ''				WHERE `user_id` = '".$_SESSION['account']['id']."' ");

	status_message('success',"All channels will stop shortly.");
    go($_SERVER['HTTP_REFERER']);
}

function channels_start_all()
{
	global $conn, $global_settings;

	// set enable = 'yes' for all streams
	$update = $conn->exec("UPDATE `channels` SET `enable` = 'yes' WHERE `user_id` = '".$_SESSION['account']['id']."' ");
    
    // $update = $conn->exec("UPDATE `channels` SET `status` = 'starting' WHERE `id` = '".$id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

	status_message('success',"All channels will start shortly.");
    go($_SERVER['HTTP_REFERER']);
}

function bulk_update_sources()
{
	global $conn, $global_settings;

	$old_source_url = get('old_source_url');
	$new_source_url = get('new_source_url');

	$update = $conn->exec("UPDATE `streams` SET `source` = REPLACE(`source`, '".$old_source_url."', '".$new_source_url."') WHERE `user_id` = '".$_SESSION['account']['id']."' ");

	status_message('success',"Source URLs have been updated.");
    go($_SERVER['HTTP_REFERER']);
}

function remote_playlist_add()
{
	global $conn, $global_settings;

	$name 				= addslashes($_POST['name']);
	$name 				= trim($name);

	$url 				= addslashes($_POST['url']);
	$url 				= trim($url);

	$insert = $conn->exec("INSERT INTO `remote_playlists` 
        (`user_id`,`name`,`url`)
        VALUE
        ('".$_SESSION['account']['id']."',
        '".$name."',
        '".$url."'
    )");

    $record_id = $conn->lastInsertId();

	status_message('success',"Remote Playlist has been added.");
	go($_SERVER['HTTP_REFERER']);
}

function remote_playlist_update()
{
	global $conn, $global_settings;
	
	$customer_id 		= addslashes($_POST['customer_id']);
	$status 			= addslashes($_POST['status']);
	$first_name 		= addslashes($_POST['first_name']);
	$last_name 			= addslashes($_POST['last_name']);
	$email 				= addslashes($_POST['email']);
	$username			= addslashes($_POST['username']);
	$password 			= addslashes($_POST['password']);
	$max_connections 	= addslashes($_POST['max_connections']);
	$notes 				= addslashes($_POST['notes']);
	
	$update = $conn->exec("UPDATE `customers` SET `status` = '".$status."' 							WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `customers` SET `first_name` = '".$first_name."'					WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `customers` SET `last_name` = '".$last_name."' 					WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `customers` SET `email` = '".$email."' 							WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `customers` SET `username` = '".$username."' 						WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `customers` SET `password` = '".$password."' 						WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `customers` SET `max_connections` = '".$max_connections."' 		WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `customers` SET `notes` = '".$notes."' 							WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

	// log_add("Customer has been updated.");
	status_message('success',"Customer account has been updated.");
	go($_SERVER['HTTP_REFERER']);
}

function remote_playlist_delete()
{
	global $conn, $global_settings;

	$id = get('id');

	$update = $conn->exec("DELETE FROM `remote_playlists` WHERE `id` = '".$id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	
    status_message('success',"Remote Playlist has been deleted.");
	go($_SERVER['HTTP_REFERER']);
}

function roku_device_add()
{
	global $conn, $global_settings;

	$server_id 			= addslashes($_POST['server']);

	$device_brand 		= addslashes($_POST['device_brand']);

	$app 				= addslashes($_POST['app']);

	$name 				= addslashes($_POST['name']);
	$name 				= trim($name);

	$ip_address 		= addslashes($_POST['ip_address']);
	$ip_address 		= trim($ip_address);

	$time 				= time();

	$insert = $conn->exec("INSERT INTO `roku_devices` 
        (`updated`,`user_id`,`server_id`,`device_brand`,`name`,`ip_address`,`status`,`app`)
        VALUE
        ('".$time."',
        '".$_SESSION['account']['id']."',
        '".$server_id."',
        '".$device_brand."',
        '".$name."',
        '".$ip_address."',
        'pending_adoption',
        '".$app."',
    )");

    $record_id = $conn->lastInsertId();

	status_message('success',"Roku Device has been added.");
	go($_SERVER['HTTP_REFERER']);
}

function roku_device_update()
{
	global $conn, $global_settings;
	
	$device_id 			= addslashes($_POST['device_id']);
	$server_id 			= addslashes($_POST['server_id']);
	$device_brand 		= addslashes($_POST['device_brand']);
	$app 				= addslashes($_POST['app']);
	$name 				= addslashes($_POST['name']);
	$name 				= trim($name);
	$ip_address 		= addslashes($_POST['ip_address']);
	$channel			= addslashes($_POST['channel']);
	
	$update = $conn->exec("UPDATE `roku_devices` SET `server_id` = '".$server_id."' 			WHERE `id` = '".$device_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `roku_devices` SET `device_brand` = '".$device_id."' 			WHERE `id` = '".$device_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `roku_devices` SET `name` = '".$name."' 						WHERE `id` = '".$device_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `roku_devices` SET `ip_address` = '".$ip_address."' 			WHERE `id` = '".$device_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `roku_devices` SET `app` = '".$app."'			 				WHERE `id` = '".$device_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `roku_devices` SET `channel` = '".$channel."' 				WHERE `id` = '".$device_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

	status_message('success',"Roku Device has been updated.");
	go($_SERVER['HTTP_REFERER']);
}

function roku_device_delete()
{
	global $conn, $global_settings;

	$id = get('id');

	$update = $conn->exec("DELETE FROM `roku_devices` WHERE `id` = '".$id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	
    status_message('success',"Roku Device has been deleted.");
	go($_SERVER['HTTP_REFERER']);
}

function playlist_checker()
{
	global $conn, $global_settings;

	$url 				= addslashes($_POST['playlist_url']);
	$url 				= trim($url);

	$url 				= base64_encode($url);

	status_message('success',"Playlist will be checked in real-time.");
	go("dashboard.php?c=playlist_checker_results&url=".$url);
}

function ajax_stream_checker()
{
	global $conn, $global_settings;

	header("Content-Type:application/json; charset=utf-8");

	$url 						= addslashes($_GET['url']);
	$url 						= trim($url);

	$data['encoded_url'] 		= $url;

	$url 						= base64_decode($url);

	$data['url'] 				= $url;

	$probe_command				= 'timeout 15 ffprobe -v quiet -print_format json -show_format -show_streams "'.$url.'" ';

	$data['probe_command'] 		= $probe_command;

	$stream_info 				= shell_exec($probe_command);

	$stream_info 				= json_decode($stream_info, true);

	if(is_array($stream_info['streams'])){
		$data['status'] = 'online';
	}else{
		$data['status'] = 'offline';
	}

	json_output($data);
}

function reseller_add()
{
	global $conn, $global_settings;
		
	$first_name 		= addslashes($_POST['first_name']);
	$last_name 			= addslashes($_POST['last_name']);
	$email 				= addslashes($_POST['email']);
	$username 			= addslashes($_POST['username']);
	$password 			= addslashes($_POST['password']);
	$credits 			= addslashes($_POST['credits']);
	$notes 				= addslashes($_POST['notes']);

	// $expire_bits 		= explode('-', $expire_date);
	// $expire_date		= $expire_bits[2].'/'.$expire_bits[0].'/'.$expire_bits[1];
	
	$insert = $conn->exec("INSERT INTO `resellers` 
        (`user_id`,`first_name`,`last_name`,`email`,`username`,`password`,`credits`,`notes`)
        VALUE
        ('".$_SESSION['account']['id']."',
        '".$first_name."',
        '".$last_name."',
        '".$email."',
        '".$username."',
        '".$password."',
        '".$credits."',
        '".$notes."'
    )");

    $reseller_id = $conn->lastInsertId();

	status_message('success',"Reseller account has been added.");
	go($_SERVER['HTTP_REFERER']);
}

function reseller_update()
{
	global $conn, $global_settings;
	
	$reseller_id 		= addslashes($_POST['reseller_id']);
	$status 			= addslashes($_POST['status']);
	$first_name 		= addslashes($_POST['first_name']);
	$last_name 			= addslashes($_POST['last_name']);
	$email 				= addslashes($_POST['email']);
	$username 			= addslashes($_POST['username']);
	$password 			= addslashes($_POST['password']);
	$credits 			= addslashes($_POST['credits']);
	$notes 				= addslashes($_POST['notes']);

	// $expire_bits 		= explode('-', $expire_date);
	// $expire_date		= $expire_bits[1].'/'.$expire_bits[2].'/'.$expire_bits[0];
	
	$update = $conn->exec("UPDATE `resellers` SET `status` = '".$status."' 				WHERE `id` = '".$reseller_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `resellers` SET `first_name` = '".$first_name."' 		WHERE `id` = '".$reseller_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `resellers` SET `last_name` = '".$last_name."' 		WHERE `id` = '".$reseller_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `resellers` SET `email` = '".$email."' 				WHERE `id` = '".$reseller_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `resellers` SET `username` = '".$username."' 			WHERE `id` = '".$reseller_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `resellers` SET `password` = '".$password."' 			WHERE `id` = '".$reseller_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `resellers` SET `credits` = '".$credits."' 			WHERE `id` = '".$reseller_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `resellers` SET `notes` = '".$notes."' 				WHERE `id` = '".$reseller_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

	status_message('success',"Reseller account has been updated.");
	go($_SERVER['HTTP_REFERER']);
}

function reseller_delete()
{
	global $conn, $global_settings;

	$reseller_id = get('reseller_id');

	$update = $conn->exec("DELETE FROM `resellers` WHERE `id` = '".$reseller_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	
    status_message('success',"Reseller account has been deleted.");
	go($_SERVER['HTTP_REFERER']);
}

function xc_import(){
	global $whmcs, $site, $conn;

	$user_id 					= $_SESSION['account']['id'];

	$fileName = $_FILES["file1"]["name"]; // The file name
	
	$fileName = str_replace('"', '', $fileName);
	$fileName = str_replace("'", '', $fileName);
	$fileName = str_replace(' ', '_', $fileName);
	$fileName = str_replace(array('!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '+', '+', ';', ':', '\\', '|', '~', '`', ',', '<', '>', '/', '?', '§', '±',), '', $fileName);
	// $fileName = $fileName . '.' . $fileExt;
	
	$fileTmpLoc = $_FILES["file1"]["tmp_name"]; // File in the PHP tmp folder
	$fileType = $_FILES["file1"]["type"]; // The type of file it is
	$fileSize = $_FILES["file1"]["size"]; // File size in bytes
	$fileErrorMsg = $_FILES["file1"]["error"]; // 0 for false... and 1 for true
	if (!$fileTmpLoc) { // if file not chosen
		echo "Please select a file to upload.";
	}
	
	// check if folder exists for customer, if not create it and continue
	if (!file_exists('xc_uploads/'.$user_id) && !is_dir('xc_uploads/'.$user_id)) {
		exec("sudo mkdir -p /var/www/html/portal/xc_uploads");
		exec("sudo mkdir -p /var/www/html/portal/xc_uploads/".$user_id);
		exec("chmod 777 /var/www/html/portal/xc_uploads/".$user_id);
	} 
	
	// handle the uploaded file
	if(move_uploaded_file($fileTmpLoc, "xc_uploads/".$user_id."/".$fileName)){

		// save import job for later
		$insert = $conn->exec("INSERT INTO `xc_import_jobs` 
	        (`user_id`,`status`,`filename`)
	        VALUE
	        ('".$_SESSION['account']['id']."',
	        'pending',
	        '".$fileName."'
	    )");

		// check for compressed files
		if($fileType == 'zip'){

		}

		// report
		echo "<font color='#18B117'><b>Import job has been added. Import will process shortly.</b></font>";
	}else{
		echo "ERROR: Oops, something went very wrong. Please try again or contact support for more help.";
		exit();
	}	
}

function reset_account()
{
	global $conn, $global_settings;

	$user_id			= $_SESSION['account']['id'];
	$type 				= $_GET['type'];
	if(empty($type)){
		status_message('danger',"Missing var, please contact support.");
	}else{
		if($type == 'account' || $type == 'streams'){
			$purge = $conn->exec("DELETE FROM `streams` WHERE `user_id` = '".$user_id."' ");
		}

		if($type == 'account' || $type == 'customers'){
			$purge = $conn->exec("DELETE FROM `customers` WHERE `user_id` = '".$user_id."' ");
		}

		if($type == 'account' || $type == 'packages'){
			$purge = $conn->exec("DELETE FROM `packages` WHERE `user_id` = '".$user_id."' ");
		}

		if($type == 'account' || $type == 'bouquets'){
			$purge = $conn->exec("DELETE FROM `bouquets` WHERE `user_id` = '".$user_id."' ");
		}

		if($type == 'account' || $type == 'resellers'){
			$purge = $conn->exec("DELETE FROM `resellers` WHERE `user_id` = '".$user_id."' ");
		}

		if($type == 'account' || $type == 'mag_devices'){
			$purge = $conn->exec("DELETE FROM `mag_devices` WHERE `user_id` = '".$user_id."' ");
		}

		status_message('success',"Reset complete. Please reboot all your servers.");
	}
	go($_SERVER['HTTP_REFERER']);
}

function bouquet_add()
{
	global $conn, $global_settings;
	
	$name 				= post('name');
	$name 				= addslashes($name);

	$bouquet_type 		= post('bouquet_type');
	$bouquet_type 		= addslashes($bouquet_type);

	$insert = $conn->exec("INSERT INTO `bouquets` 
        (`user_id`,`name`,`type`)
        VALUE
        ('".$_SESSION['account']['id']."',
        '".$name."',
        '".$bouquet_type."'
    )");

    $bouquet_id = $conn->lastInsertId();
    
	// log_add("Stream Category has been added.");
	status_message('success',"Stream Bouquet has been added.");
	go("dashboard.php?c=stream_bouquet&bouquet_id=".$bouquet_id);
}

function bouquet_update()
{
	global $conn, $global_settings;
	
	$bouquet_id 		= addslashes($_POST['bouquet_id']);
	
	$name 				= addslashes($_POST['name']);
	$name 				= trim($name);
		
	$update = $conn->exec("UPDATE `bouquets` SET `name` = '".$name."' WHERE `id` = '".$bouquet_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

	status_message('success',"Stream Bouquet has been updated.");
	go($_SERVER['HTTP_REFERER']);
}

function bouquet_streams_update()
{
	global $conn, $global_settings;

	$bouquet_id 		= addslashes($_POST['bouquet_id']);
	
	if(isset($_POST['to'])){
		$streams 		= $_POST['to'];
	}else{
		$streams 		= array();
	}

	// get existing bouquet contents
	$existing_contents = array();
	$query = $conn->query("SELECT * FROM `bouquets_content` WHERE `bouquet_id` = '".$bouquet_id."' ");
	$bouquet_contents = $query->fetchAll(PDO::FETCH_ASSOC);
	foreach($bouquet_contents as $bouquet_content){
		$existing_contents[] = $bouquet_content['content_id'];
	}

	foreach($streams as $stream){
		$insert = $conn->exec("INSERT IGNORE INTO `bouquets_content` 
	        (`bouquet_id`,`content_id`)
	        VALUE
	        ('".$bouquet_id."',
	        '".$stream."'
	    )");
	}

	// compare arrays to remove ones we dont want
	$contents_diffs = array_diff($existing_contents,$streams);
	foreach($contents_diffs as $contents_diff){
		$delete = $conn->exec("DELETE FROM `bouquets_content` WHERE `bouquet_id` = '".$bouquet_id."' AND `content_id` = '".$contents_diff."' ");
	}

	status_message('success',"Stream Bouquet streams have been updated.");
	go($_SERVER['HTTP_REFERER']);
}

function bouquet_streams_order_update()
{
	global $conn, $global_settings;
	
	$bouquet_id 		= addslashes($_GET['bouquet_id']);

	$positions 			= $_POST['position'];

	$order = 0;
	foreach($positions as $position){
		$update = $conn->exec("UPDATE `bouquets_content` SET `order` = '".$order."' WHERE `bouquet_id` = '".$bouquet_id."' AND `content_id` = '".$position."' ");
		$order++;
	}

	// echo $position;
}

function bouquet_delete()
{
	global $conn, $global_settings;

	$bouquet_id = get('bouquet_id');

	// remove the bouquet_id from customers

	// delete primary record
	$query = $conn->query("DELETE FROM `bouquets` WHERE `id` = '".$bouquet_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

	// log and wrap up
	// log_add("Stream Category Deleted:");
	status_message('success',"Stream Bouquet has been deleted.");
	// return user to previous page
	go($_SERVER['HTTP_REFERER']);
}

function ajax_customer_line()
{
	global $conn, $global_settings;

	$customer_id = get('customer_id');

	$query = $conn->query("SELECT `username`,`password` FROM `customers` WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$customer = $query->fetch(PDO::FETCH_ASSOC);

	$content = '';

	if(!empty($customer['username'])){
		$content .= '<div class="row">';
		$content .= '<div class="col-lg-12">';
		$content .= '<div class="form-group">';
		$content .= '<label class="col-md-3 control-label" for="simple_m3u">M3U</label>';
		$content .= '<div class="col-md-9">';
		$content .= '<input type="text" class="form-control" value="http://'.$global_settings['cms_access_url'].'/customers/'.$customer['username'].'/'.$customer['password'].'/simple_m3u">';
		$content .= '</div>';
		$content .= '</div>';
		$content .= '</div>';
		$content .= '</div>';

		$content .= '<div class="row">';
		$content .= '<div class="col-lg-12">';
		$content .= '<div class="form-group">';
		$content .= '<label class="col-md-3 control-label" for="advanced_m3u">M3U with Options</label>';
		$content .= '<div class="col-md-9">';
		$content .= '<input type="text" class="form-control" value="http://'.$global_settings['cms_access_url'].'/customers/'.$customer['username'].'/'.$customer['password'].'/advanced_m3u">';
		$content .= '</div>';
		$content .= '</div>';
		$content .= '</div>';
		$content .= '</div>';

		$content .= '<div class="row">';
		$content .= '<div class="col-lg-12">';
		$content .= '<div class="form-group">';
		$content .= '<label class="col-md-3 control-label" for="enigma">Enigma 2.0 Autscript - HLS</label>';
		$content .= '<div class="col-md-9">';
		$content .= '<input type="text" class="form-control" value="wget -O /etc/enigma2/iptv.sh \'http://'.$global_settings['cms_access_url'].'/customers/'.$customer['username'].'/'.$customer['password'].'/enigma\' && chmod 777 /etc/enigma2/iptv.sh && /etc/enigma2/iptv.sh">';
		$content .= '</div>';
		$content .= '</div>';
		$content .= '</div>';
		$content .= '</div>';
		$content .= '</div>';

		$content .= '<div class="row">';
		$content .= '<div class="col-lg-12">';
		$content .= '<div class="form-group">';
		$content .= '<label class="col-md-3 control-label" for="enigma">DreamBox OE 2.0 Autscript</label>';
		$content .= '<div class="col-md-9">';
		$content .= '<input type="text" class="form-control" value="http://'.$global_settings['cms_access_url'].'/customers/'.$customer['username'].'/'.$customer['password'].'/dreambox">';
		$content .= '</div>';
		$content .= '</div>';
		$content .= '</div>';
		$content .= '</div>';
		$content .= '</div>';

		$content .= '<div class="row">';
		$content .= '<div class="col-lg-12">';
		$content .= '<div class="form-group">';
		$content .= '<label class="col-md-3 control-label" for="enigma">WebTV</label>';
		$content .= '<div class="col-md-9">';
		$content .= '<input type="text" class="form-control" value="http://'.$global_settings['cms_access_url'].'/customers/'.$customer['username'].'/'.$customer['password'].'/webtv">';
		$content .= '</div>';
		$content .= '</div>';
		$content .= '</div>';
		$content .= '</div>';
		$content .= '</div>';


		$content .= '<div class="row">';
		$content .= '<div class="col-lg-12">';
		$content .= '<div class="form-group">';
		$content .= '<label class="col-md-3 control-label" for="enigma">Octogan</label>';
		$content .= '<div class="col-md-9">';
		$content .= '<input type="text" class="form-control" value="http://'.$global_settings['cms_access_url'].'/customers/'.$customer['username'].'/'.$customer['password'].'/octogan">';
		$content .= '</div>';
		$content .= '</div>';
		$content .= '</div>';
		$content .= '</div>';
		$content .= '</div>';
	}else{
		$content .= 'Customer not found.';
	}

	echo $content;
}

function ajax_members()
{
	global $conn, $global_settings;

	$time_shift 	= time() - 20;

	$user_id 		= $_SESSION['account']['id'];

	header("Content-Type:application/json; charset=utf-8");

	function find_outputs($array, $key, $value){
	    $results = array();

	    if (is_array($array)) {
	        if (isset($array[$key]) && $array[$key] == $value) {
	            $results[] = $array;
	        }

	        foreach ($array as $subarray) {
	            $results = array_merge($results, find_outputs($subarray, $key, $value));
	        }
	    }

	    return $results;
	}

	// get customers
	$query 				= $conn->query("SELECT `id`,`added`,`status`,`first_name`,`last_name`,`email`,`tel`,`expire_date`,`internal_notes`,`upline_id`,`total_downline` FROM `users` ");
	$customers 			= $query->fetchAll(PDO::FETCH_ASSOC);

	if($query !== FALSE) {
		$count = 0;

		foreach($customers as $customer) {
			$output[$count] 								= $customer;
			$output[$count]['checkbox']						= '<center><input type="checkbox" class="chk" id="checkbox_'.$customer['id'].'" name="customer_ids[]" value="'.$customer['id'].'" onclick="multi_options();"></center>';
			
			// member status
			if($customer['status'] == 'active') {
				$output[$count]['status'] 					= '<span class="label label-success full-width" style="width: 100%;">Active</span>';
			}elseif($customer['status'] == 'disabled') {
				$output[$count]['status']					= '<span class="label label-danger full-width" style="width: 100%;">Disabled</span>';
			}elseif($customer['status'] == 'suspended') {
				$output[$count]['status'] 					= '<span class="label label-warning full-width" style="width: 100%;">Suspended</span>';
			}elseif($customer['status'] == 'terminated') {
				$output[$count]['status'] 					= '<span class="label label-danger full-width" style="width: 100%;">Terminated</span>';
			}elseif($customer['status'] == 'closed') {
				$output[$count]['status'] 					= '<span class="label label-danger full-width" style="width: 100%;">Closed</span>';
			}else{
				$output[$count]['status'] 					= '<span class="label label-warning full-width" style="width: 100%;">'.ucfirst($customer['status']).'</span>';
			}

			// full name
			$output[$count]['full_name'] 					= stripslashes($customer['first_name']).' '.stripslashes($customer['last_name']);

			// next expire date
			if($customer['expire_date'] == '1970-01-01'){
				$output[$count]['expire_date']				= 'Never';
			}else{
				$output[$count]['expire_date'] 				= $customer['expire_date'];
			}

			// get upline info
			$output[$count]['upline'] 						= 'Master Account';
			foreach($customers as $customer_upline) {
				if($customer_upline['id'] == $customer['upline_id']) {
					$output[$count]['upline'] 				= '<a href="dashboard.php?c=member&id='.$customer_upline['id'].'">'.stripslashes($customer_upline['first_name']).' '.stripslashes($customer_upline['last_name']).'</a>';
					break;
				}
			}

			// member join date
			$output[$count]['join_date']					= date("Y-m-d", $customer['added']);

			// build the actions menu options
			$output[$count]['actions'] 						= '
				<div class="btn-group">
					<span class="pull-right">
						<a title="View MLM Profile" class="btn btn-info btn-flat btn-xs" href="dashboard.php?c=member&id='.$customer['id'].'"><i class="fa fa-user"></i></a>
						<a title="View Billing Profile" class="btn btn-primary btn-flat btn-xs" href="https://ublo.club/billing/admin/clientssummary.php?userid='.$customer['id'].'" target="_blank"><i class="fa fa-user"></i></a>

						<!-- <a title="Delete" class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'This cannot be undone. The entire downline will be moved up one level. Are you sure?\')" href="actions.php?a=customer_delete&customer_id='.$customer['id'].'"><i class="fa fa-times"></i></a> -->
					</span>
				</div>';

			// internal staff notes
			$output[$count]['internal_notes']				= '<span class="">'.stripslashes($customer['internal_notes']).'</span>';
			$output[$count]['internal_notes_hidden']		= '<span class="hidden">'.stripslashes($customer['internal_notes']).'</span>';

			// set commissions default
			$output[$count]['commissions']['total']				= '0';
			$output[$count]['commissions']['pending']			= '0';
			$output[$count]['commissions']['approved']			= '0';
			$output[$count]['commissions']['paid']				= '0';
			$output[$count]['commissions']['rejected']			= '0';
			$output[$count]['commissions']['missed']			= '0';
			$output[$count]['commissions']['orders']			= '0';

			// get pending commissions
			$query 				= $conn->query("SELECT `id`,`amount`,`qualified`,`status` FROM `commissions` WHERE `user_id` = '".$customer['id']."' ");
			$commissions 		= $query->fetchAll(PDO::FETCH_ASSOC); 
			
			// work with commissions
			foreach($commissions as $commission){
				$output[$count]['commissions']['total']						= $output[$count]['commissions']['total'] + $commission['amount'];

				if($commission['status'] == 'pending' && $commission['qualified'] == 'yes'){
					$output[$count]['commissions']['pending']				= $output[$count]['commissions']['pending'] + $commission['amount'];
				}
				if($commission['status'] == 'approved' && $commission['qualified'] == 'yes'){
					$output[$count]['commissions']['approved']				= $output[$count]['commissions']['approved'] + $commission['amount'];
				}
				if($commission['status'] == 'paid' && $commission['qualified'] == 'yes'){
					$output[$count]['commissions']['paid']					= $output[$count]['commissions']['paid'] + $commission['amount'];
				}
				if($commission['status'] == 'rejected' && $commission['qualified'] == 'yes'){
					$output[$count]['commissions']['rejected']				= $output[$count]['commissions']['rejected'] + $commission['amount'];
				}
				if($commission['qualified'] == 'no'){
					$output[$count]['commissions']['missed'] 				= $output[$count]['commissions']['missed'] + $commission['amount'];
				}
			}

			// clean up commissions
			$output[$count]['commissions']['total'] 							= number_format($output[$count]['commissions']['total'], 2);
			$output[$count]['commissions']['pending'] 							= number_format($output[$count]['commissions']['pending'], 2);
			$output[$count]['commissions']['approved'] 							= number_format($output[$count]['commissions']['approved'], 2);
			$output[$count]['commissions']['paid'] 								= number_format($output[$count]['commissions']['paid'], 2);
			$output[$count]['commissions']['rejected'] 							= number_format($output[$count]['commissions']['rejected'], 2);
			$output[$count]['commissions']['missed'] 							= number_format($output[$count]['commissions']['missed'], 2);
			$output[$count]['commissions']['orders'] 							= number_format(count($commissions));

			// $count loop
			$count++;
		}

		if(isset($output)) {
			$data['data'] = array_values($output);
		}else{
			$data['data'] = array();
		}

		json_output($data);
	}
}

function ajax_member_commissions()
{
	global $conn, $global_settings;

	$count 			= 0;

	$member_id 		= get('id');

	header("Content-Type:application/json; charset=utf-8");

	// get pending commissions
	$query 				= $conn->query("SELECT * FROM `commissions` WHERE `user_id` = '".$member_id."' ");
	$commissions 		= $query->fetchAll(PDO::FETCH_ASSOC); 
	
	// work with commissions
	foreach($commissions as $commission){
		$output[$count]							= $commission;

		$output[$count]['checkbox']				= '<center><input type="checkbox" class="chk" id="checkbox_'.$commission['id'].'" name="commission_ids[]" value="'.$commission['id'].'" onclick="multi_options();"></center>';

		$output[$count]['added'] 				= $commission['added'];
		$output[$count]['order_date'] 			= date("Y-m-d", $commission['added']);
		$pending_commissions_period				= 2592000;
		$output[$count]['release_date'] 		= date("Y-m-d", $commission['added'] + $pending_commissions_period);

		// status
		if($commission['status'] == 'approved'){
			$output[$count]['status'] 					= '<span class="label label-warning full-width" style="width: 100%;">Approved</span>';
		}elseif($commission['status'] == 'pending' && $commission['qualified'] == 'yes'){
			$output[$count]['status']					= '<span class="label label-info full-width" style="width: 100%;">Pending</span>';
		}elseif($commission['status'] == 'pending' && $commission['qualified'] == 'no'){
			$output[$count]['status']					= '<span class="label label-default full-width" style="width: 100%;">N/A</span>';
		}elseif($commission['status'] == 'paid'){
			$output[$count]['status'] 					= '<span class="label label-success full-width" style="width: 100%;">Paid</span>';
		}elseif($commission['status'] == 'rejected'){
			$output[$count]['status'] 					= '<span class="label label-danger full-width" style="width: 100%;">Rejected</span>';
		}else{
			$output[$count]['status'] 					= '<span class="label label-warning full-width" style="width: 100%;">'.ucfirst($commission['status']).'</span>';
		}

		// get customer_id
		$output[$count]['customer_id'] 			= $commission['customer_id'];

		// commission amount
		$output[$count]['amount'] 				= '£'.number_format($commission['amount'], 2);

		// order_id
		$output[$count]['order_id'] 			= '<a href="https://ublo.club/billing/admin/orders.php?action=view&id='.$commission['int_order_id'].'" target="_blank" title="View Order">'.$commission['int_order_id'].'</a>';
		$output[$count]['order_id_hidden']		= '<span class="hidden">'.stripslashes($commission['int_order_id']).'</span>';

		// qualified
		if($commission['qualified'] == 'yes') {
			$output[$count]['qualified'] 					= '<span class="label label-success full-width" style="width: 100%;">Yes</span>';
		}elseif($commission['qualified'] == 'no') {
			$output[$count]['qualified']					= '<span class="label label-danger full-width" style="width: 100%;">No</span>';
		}

		// build the actions menu options
		$output[$count]['actions'] 						= '
			<div class="btn-group">
				<span class="pull-right">
					<!-- 
					<a title="View MLM Profile" class="btn btn-info btn-flat btn-xs" href="dashboard.php?c=member&id='.$commission['id'].'"><i class="fa fa-eye"></i></a>
					<a title="View Billing Profile" class="btn btn-primary btn-flat btn-xs" href="https://ublo.club/billing/admin/clientssummary.php?userid='.$commission['id'].'" target="_blank"><i class="fa fa-dollar"></i></a>
					-->
		';

		if($commission['status'] == 'pending'){
			$output[$count]['actions'] 						.= '
					<span class="hidden-xs">
						<a title="Manually Approve Commission" class="btn btn-success btn-flat btn-xs" href="actions.php?a=commission_approve&id='.$commission['id'].'"><i class="fa fa-check"></i></a>
					</span>
			';
		}elseif($commission['status'] != 'paid'){
			$output[$count]['actions'] 						.= '
					<span class="hidden-xs">
						<a title="Reset Commission" class="btn btn-warning btn-flat btn-xs" onclick="return confirm(\'The commission will be reset. Are you sure?\')" href="actions.php?a=commission_reset&id='.$commission['id'].'"><i class="fa fa-recycle"></i></a>
					</span>
			';
		}else{
			$output[$count]['actions'] 						.= '
					<span class="hidden-xs">
						<a title="Not Available" class="btn btn-default btn-flat btn-xs" href="#" disabled><i class="fa fa-recycle"></i></a>
					</span>
			';
		}

		$output[$count]['actions'] 						.= '
					<span class="hidden-xs">
						<!-- <a title="View Order" class="btn btn-info btn-flat btn-xs" href="https://ublo.club/billing/admin/orders.php?action=view&id='.$commission['int_order_id'].'" target="_blank"><i class="fa fa-shopping-cart"></i></a> -->
					</span>

					<a title="Reject Commission" class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'This will reject this commission for this member. Are you sure?\')" href="actions.php?a=commission_reject&id='.$commission['id'].'"><i class="fa fa-times"></i></a>
				</span>
			</div>';

		// $count loop
		$count++;
	}

	if(isset($output)) {
		$data['data'] = array_values($output);
	}else{
		$data['data'] = array();
	}

	json_output($data);
}

function ajax_downline()
{
	global $conn, $global_settings;

	$count 			= 0;

	$user_id 		= $_SESSION['account']['id'];

	header("Content-Type:application/json; charset=utf-8");

	function find_outputs($array, $key, $value){
	    $results = array();

	    if (is_array($array)) {
	        if (isset($array[$key]) && $array[$key] == $value) {
	            $results[] = $array;
	        }

	        foreach ($array as $subarray) {
	            $results = array_merge($results, find_outputs($subarray, $key, $value));
	        }
	    }

	    return $results;
	}

	// downline totals
	$query 				= $conn->query("SELECT `id`,`added`,`status`,`type`,`first_name`,`last_name`,`email`,`expire_date`,`internal_notes`,`upline_id`,`total_downline` FROM `users` ");
	$customers 			= $query->fetchAll(PDO::FETCH_ASSOC);

	// set defaults
	$runs 			= array(1, 2, 3, 4 ,5 ,6 ,7);
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
	foreach($customers as $customer){
		// count downline for this customer
		if($customer['upline_id'] == $user_id){
			$downline[1][] = $customer['id'];
		}
	}

	// find level 2
	if(is_array($downline[1])){
		foreach($downline[1] as $level_2){
        	foreach($customers as $customer){
    			if($customer['upline_id'] == $level_2){
    				$downline[2][] = $customer['id'];
    			}
    		}
    	}
    }

    // find level 3
	if(is_array($downline[2])){
		foreach($downline[2] as $level_3){
        	foreach($customers as $customer){
    			if($customer['upline_id'] == $level_3){
    				$downline[3][] = $customer['id'];
    			}
    		}
    	}
    }

    // find level 4
	if(is_array($downline[3])){
		foreach($downline[3] as $level_4){
        	foreach($customers as $customer){
    			if($customer['upline_id'] == $level_4){
    				$downline[4][] = $customer['id'];
    			}
    		}
    	}
    }

    // find level 5
	if(is_array($downline[4])){
		foreach($downline[4] as $level_5){
        	foreach($customers as $customer){
    			if($customer['upline_id'] == $level_5){
    				$downline[5][] = $customer['id'];
    			}
    		}
    	}
    }

    // find level 6
	if(is_array($downline[5])){
		foreach($downline[5] as $level_6){
        	foreach($customers as $customer){
    			if($customer['upline_id'] == $level_6){
    				$downline[6][] = $customer['id'];
    			}
    		}
    	}
    }

    // find level 7
	if(is_array($downline[6])){
		foreach($downline[6] as $level_7){
        	foreach($customers as $customer){
    			if($customer['upline_id'] == $level_7){
    				$downline[7][] = $customer['id'];
    			}
    		}
    	}
    }

    foreach($runs as $key => $value){
		foreach($downline[$value] as $customer_id) {
			foreach($customers as $customer){
				if($customer_id == $customer['id']){
					$output[$count] 								= $customer;
					$output[$count]['level']						= $value;
					$output[$count]['account_type']					= ucfirst($customer['type']);
					$output[$count]['checkbox']						= '<center><input type="checkbox" class="chk" id="checkbox_'.$customer['id'].'" name="customer_ids[]" value="'.$customer['id'].'" onclick="multi_options();"></center>';
					
					if($customer['status'] == 'active') {
						$output[$count]['status'] 					= '<span class="label label-success full-width" style="width: 100%;">Enabled</span>';
					}elseif($customer['status'] == 'disabled') {
						$output[$count]['status']					= '<span class="label label-danger full-width" style="width: 100%;">Disabled</span>';
					}elseif($customer['status'] == 'suspended') {
						$output[$count]['status'] 					= '<span class="label label-danger full-width" style="width: 100%;">Suspended</span>';
					}else{
						$output[$count]['status'] 					= '<span class="label label-warning full-width" style="width: 100%;">'.ucfirst($customer['status']).'</span>';
					}

					$output[$count]['full_name'] 					= stripslashes($customer['first_name']).' '.stripslashes($customer['last_name']);

					if($customer['expire_date'] == '1970-01-01'){
						$output[$count]['expire_date']				= 'Never';
					}else{
						$output[$count]['expire_date'] 				= $customer['expire_date'];
					}

					// get upline info
					$output[$count]['upline'] 						= 'You';
					foreach($customers as $customer_upline) {
						if($customer_upline['id'] == $customer['upline_id']) {
							$output[$count]['upline'] 				= stripslashes($customer_upline['first_name']).' '.stripslashes($customer_upline['last_name']);
							break;
						}
					}

					$output[$count]['join_date']					= date("Y-m-d", $customer['added']);

					$output[$count]['actions'] 						= '<!-- <a title="View / Edit" class="btn btn-info btn-flat btn-xs" href="dashboard.php?c=customer&customer_id='.$customer['id'].'"><i class="fa fa-eye"></i></a><a title="Delete" class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'This cannot be undone. The entire downline will be moved up one level. Are you sure?\')" href="actions.php?a=customer_delete&customer_id='.$customer['id'].'"><i class="fa fa-times"></i></a> -->';

					$output[$count]['internal_notes']				= '<span class="">'.stripslashes($customer['internal_notes']).'</span>';
					$output[$count]['internal_notes_hidden']		= '<span class="hidden">'.stripslashes($customer['internal_notes']).'</span>';

					if($output[$count]['level'] == 1){
						$output[$count]['additional_details']		= '
							<table cellpadding="1" cellspacing="0" border="0" width="100%">
								<tr>
						            <td width="150px" valign="top">Additional Details</td>
						            <td valign="top">
						            	<strong>User ID:</strong>'.$output[$count]['id'].'<br>
						            	<strong>Join Date:</strong>'.$output[$count]['join_date'].'<br>
						            </td>
						        </tr>
						        <tr>
						            <td width="150px" valign="top">Contact Details</td>
						            <td valign="top">
						            	<strong>Email:</strong>'.$output[$count]['email'].'<br>
						            </td>
						        </tr>
						    </table>
						';
					}else{
						$output[$count]['additional_details']		= '';
					}

					$count++;

					break;
				}
			}
		}
	}



	if(isset($output)) {
		$data['data'] = array_values($output);
	}else{
		$data['data'] = array();
	}

	json_output($data);
}

function ajax_http_proxy()
{
	$data 			= '';
	$ip_address 	= $_GET['ip_address'];
	$port 			= $_GET['port'];
	$metric 		= $_GET['metric'];

	$url = 'http://'.$ip_address.':'.$port.'/server_stats.php?metric='.$metric;
	$data = @file_get_contents($url);

	echo $data;
}

function accept_terms()
{
	global $conn, $global_settings;

	$update = $conn->exec("UPDATE `users` SET `cms_terms_accepted` = 'yes' WHERE `id` = '".$_SESSION['account']['id']."' ");

    go($_SERVER['HTTP_REFERER']);
}

function license_add()
{
	global $conn, $global_settings;
	
	$license 				= post('license');
	$license 				= trim($license);
	$encoded_license 		= encrypt($license);

	error_log($license);
	error_log($encoded_license);

	$insert = $conn->exec("INSERT INTO `global_settings` 
        (`config_name`,`config_value`)
        VALUE
        ('bGljZW5zZV9rZXk=','".$encoded_license."')");
    
	// log_add("Stream Category has been added.");
	status_message('success',"License '".$license."' has been added.");
    go($_SERVER['HTTP_REFERER']);
}

function license_delete()
{
	global $conn, $global_settings;

	$license = get('license');

	if(empty($license)){
		status_message('danger',"License was not present.");
	}else{
		$query = $conn->query("DELETE FROM `global_settings` WHERE `config_name` = 'bGljZW5zZV9rZXk=' AND `config_value` = '".$license."' ");
		status_message('success',"License has been deleted.");
	}

	go($_SERVER['HTTP_REFERER']);
}

function xc_import_delete()
{
	global $conn, $global_settings;

	$id = get('id');

	$query = $conn->query("DELETE FROM `xc_import_jobs` WHERE `id` = '".$id."' ");
	status_message('success',"Xtream-Codes Import has been deleted.");

	go($_SERVER['HTTP_REFERER']);
}

function mag_add()
{
	global $conn, $global_settings;
		
	$mac_address 		= addslashes($_POST['mac_address']);
	$mac_address 		= trim($mac_address);
	$mac_address 		= base64_encode($mac_address);

	$customer_id 		= addslashes($_POST['customer_id']);
	$customer_id 		= trim($customer_id);


	// check if mac is already in use
	$query = $conn->query("SELECT `mag_id` FROM `mag_devices` WHERE `mac` = '".$mac_address."' ");
	$existing_mag = $query->fetch(PDO::FETCH_ASSOC);
	if(isset($existing_mag['mag_id'])){
		status_message('danger',"MAC '".$_POST['mac_address']."' is already added to a customer.");
	}else{
		$insert = $conn->exec("INSERT INTO `mag_devices` 
	        (`user_id`,`customer_id`,`mac`)
	        VALUE
	        ('1',
	        '".$customer_id."',
	        '".$mac_address."'
	    )");

	    $customer_id = $conn->lastInsertId();
		status_message('success',"MAG Device has been added.");
	}
	go($_SERVER['HTTP_REFERER']);
}

function mag_update()
{
	global $conn, $global_settings;
	
	$mag_id 			= post('mag_id');

	$mac_address 		= addslashes($_POST['mac_address']);
	$mac_address 		= trim($mac_address);
	$mac_address 		= base64_encode($mac_address);

	$customer_id 		= addslashes($_POST['customer_id']);
	$customer_id 		= trim($customer_id);

	$update = $conn->exec("UPDATE `mag_devices` SET `customer_id` = '".$customer_id."' 			WHERE `mag_id` = '".$mag_id."' ");
	$update = $conn->exec("UPDATE `mag_devices` SET `mac` = '".$mac_address."' 					WHERE `mag_id` = '".$mag_id."' ");

	status_message('success',"MAG Device has been updated.");
	go($_SERVER['HTTP_REFERER']);
}

function mag_delete()
{
	global $conn, $global_settings;

	$mag_id = get('mag_id');

	$update = $conn->exec("DELETE FROM `mag_devices` WHERE `mag_id` = '".$mag_id."' ");
	
    // log_add("Customer account has been deleted.");
    status_message('success',"MAG Device has been deleted.");
	go($_SERVER['HTTP_REFERER']);
}

function backup_now()
{
	global $conn, $global_settings;

	$date = date("Y-m-d_h:i", time());
	
	exec("mkdir -p /opt/slipstream/backups/");
	exec("sudo chmod 777 /opt/slipstream/backups/");

	shell_exec("mysqldump -u slipstream -padmin1372 slipstream_cms | gzip > /opt/slipstream/backups/".$date."_slipstream_cms.sql.gz");

	if(file_exists("/opt/slipstream/backups/".$date."_slipstream_cms.sql.gz")){
		status_message('success',"Database backup has been created.");
	}else{
		status_message('danger',"Database backup has failed.");
	}

	go($_SERVER['HTTP_REFERER']);
}

function backup_restore()
{
	global $conn, $global_settings;

	$filename = get("file");

	exec("sudo gunzip -k /opt/slipstream/backups/".$filename);

	$filename = str_replace(".gz", "", $filename);
	
	exec("sudo mysql -uslipstream -padmin1372 slipstream_cms < /opt/slipstream/backups/".$filename);

	exec("sudo rm -rf /opt/slipstream/backups/".$filename);

	status_message('success',"Database backup has been restored.");
	go($_SERVER['HTTP_REFERER']);
}

function backup_delete()
{
	global $conn, $global_settings;

	$filename = get("file");

	if(file_exists("/opt/slipstream/backups/".$filename)){
		exec("sudo rm -rf /opt/slipstream/backups/".$filename);
		status_message('success',"Database backup has been deleted.");
	}else{
		status_message('danger',"Database backup has failed to delete.");
	}

	go($_SERVER['HTTP_REFERER']);
}

function backup_download()
{
	global $conn, $global_settings;

	$filename = get("file");

	if(file_exists("/opt/slipstream/backups/".$filename)){
	    header("Content-Description: File Transfer");
	    header("Content-Type: application/octet-stream");
	    header("Content-Disposition: attachment; filename=".$filename);
	    header("Expires: 0");
	    header("Cache-Control: must-revalidate");
	    header("Pragma: public");
	    header("Content-Length: ".filesize("/opt/slipstream/backups/".$filename));
	    ob_clean();
	    flush();
	    readfile("/opt/slipstream/backups/".$filename);
	    exit;
	}
}

function vod_watch_delete()
{
	global $conn, $global_settings;

	$id = get('id');

	$update = $conn->exec("DELETE FROM `vod_watch` WHERE `id` = '".$id."' ");
	
    // log_add("Customer account has been deleted.");
	status_message('success',"VoD Watch Folder has been deleted.");
	go($_SERVER['HTTP_REFERER']);
}

function package_add()
{
	global $conn, $global_settings;
		
	$name 				= addslashes($_POST['name']);
	$name 				= trim($name);

	$insert = $conn->exec("INSERT INTO `packages` 
        (`user_id`,`name`)
        VALUE
        ('1',
        '".$name."'
    )");

    $package_id = $conn->lastInsertId();

	status_message('success',"Package has been added.");
	go("dashboard.php?c=package&package_id=".$package_id);
}

function package_update()
{
	global $conn, $global_settings;
	
	$package_id 		= post('package_id');

	$name 				= addslashes($_POST['name']);
	$name 				= trim($name);

	$bouquets 			= $_POST['bouquets'];
	if(!empty($bouquets)){
		$bouquets 		= implode(",", $bouquets);
	}

	$credits 			= post("credits");

	$official_duration 	= post("official_duration");

	$update = $conn->exec("UPDATE `packages` SET `name` = '".$name."' 								WHERE `id` = '".$package_id."' ");
	$update = $conn->exec("UPDATE `packages` SET `bouquets` = '".$bouquets."' 						WHERE `id` = '".$package_id."' ");
	$update = $conn->exec("UPDATE `packages` SET `credits` = '".$credits."' 						WHERE `id` = '".$package_id."' ");
	$update = $conn->exec("UPDATE `packages` SET `official_duration` = '".$official_duration."' 	WHERE `id` = '".$package_id."' ");

	status_message('success',"Package has been updated.");
	go($_SERVER['HTTP_REFERER']);
}

function package_delete()
{
	global $conn, $global_settings;

	$package_id = get('package_id');

	$update = $conn->exec("DELETE FROM `packages` WHERE `id` = '".$package_id."' ");
	
    // log_add("Customer account has been deleted.");
    status_message('success',"Package has been deleted.");
	go($_SERVER['HTTP_REFERER']);
}

function vod_category_add()
{
	global $conn, $global_settings;
	
	$name 				= addslashes($_POST['name']);

	$insert = $conn->exec("INSERT INTO `vod_categories` 
        (`user_id`,`name`)
        VALUE
        ('".$_SESSION['account']['id']."',
        '".$name."'
    )");
    
	status_message('success',"VoD Category has been added.");
	go($_SERVER['HTTP_REFERER']);
}

function vod_category_delete()
{
	global $conn, $global_settings;

	$category_id = get('category_id');

	// remove the category_id from streams
	$query = $conn->query("UPDATE `streams` SET `category_id` = '1' WHERE `category_id` = '".$category_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

	// delete primary record
	$query = $conn->query("DELETE FROM `vod_categories` WHERE `id` = '".$category_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

	status_message('success',"VoD Category has been deleted.");
	go($_SERVER['HTTP_REFERER']);
}

function customer_ip_add()
{
	global $conn, $global_settings;
	
	$customer_id 			= addslashes($_POST['customer_id']);
	$customer_ip 			= addslashes($_POST['ip_address']);

	$insert = $conn->exec("INSERT INTO `customers_ips` 
        (`customer_id`,`ip_address`)
        VALUE
        ('".$customer_id."',
        '".$customer_ip."'
    )");
    
	status_message('success',"IP Address has been added.");
	go($_SERVER['HTTP_REFERER']);
}

function customer_ip_delete()
{
	global $conn, $global_settings;

	$customer_ip_id = get('customer_ip_id');

	// delete primary record
	$query = $conn->query("DELETE FROM `customers_ips` WHERE `id` = '".$customer_ip_id."' ");

	status_message('success',"IP Address has been deleted.");
	go($_SERVER['HTTP_REFERER']);
}

function tv_series_episode_delete_all()
{
	global $conn, $global_settings;

	$id = get('id');

	// get all episodes to delete from bouquets_content
	$query = $conn->query("SELECT `id` FROM `tv_series_files` WHERE `tv_series_id` = '".$id."' ");
	$tv_series_files = $query->fetchAll(PDO::FETCH_ASSOC);
	
	// remove from bouquets_content
	foreach($tv_series_files as $tv_series_file){
		$delete = $conn->exec("DELETE FROM `bouquets_content` WHERE `content_id` = '".$tv_series_file['id']."' ");
	}

	$delete = $conn->exec("DELETE FROM `tv_series_files` WHERE `tv_series_id` = '".$id."' ");
	
    status_message('success',"All Series Episodes have been deleted.");
	go($_SERVER['HTTP_REFERER']);
}

function grab_metadata(){
	global $conn, $global_settings;

	$id 					= get('id');
	$type 					= get('type');

	// get data for media type
	if($type == 'tv_series'){
		$query 				= $conn->query("SELECT `name` FROM `tv_series` WHERE `id` = '".$id."' ");
		$media 				= $query->fetch(PDO::FETCH_ASSOC);

		// sanity check
		if(empty($media)){
			status_message('danger',"Unable to find the TV Series, something went really wrong. ");
		}else{
			$media['name']		= stripslashes($media['name']);

			// query omdbapi.com for metadata
			$metadata 				= get_metadata($media['name']);
			if($metadata['status'] == 'match'){
				if(isset($metadata['Title'])){
		        	$name           		= addslashes($metadata['name']);
		        }
		        if(isset($metadata['description'])){
		        	$description       		= addslashes($metadata['description']);
		        }
				if(isset($metadata['cover_photo'])){
		        	$cover_photo           	= addslashes($metadata['cover_photo']);
		        }
		        if(isset($metadata['Rated'])){
		        	$rating           		= addslashes($metadata['Rated']);
		        }

		        // update the metadata
		        $update = $conn->exec("UPDATE `tv_series` SET `description` = '".$description."' 		WHERE `id` = '".$id."' ");
		        $update = $conn->exec("UPDATE `tv_series` SET `cover_photo` = '".$cover_photo."' 		WHERE `id` = '".$id."' ");
		        $update = $conn->exec("UPDATE `tv_series` SET `rating` = '".$rating."' 					WHERE `id` = '".$id."' ");

		        status_message('success',"metadata for '".$media['name']."' has been updated");
			}else{
				status_message('danger',"Unable to find metadata for '".$media['name']."'");
			}
		}
	}

	if($type == '247_channel'){
		$query 				= $conn->query("SELECT `name` FROM `channels` WHERE `id` = '".$id."' ");
		$media 				= $query->fetch(PDO::FETCH_ASSOC);

		// sanity check
		if(empty($media)){
			status_message('danger',"Unable to find the 24/7 channel, something went really wrong. ");
		}else{
			$media['name']		= stripslashes($media['name']);

			// query omdbapi.com for metadata
			$metadata 				= get_metadata($media['name']);
			if($metadata['status'] == 'match'){
				if(isset($metadata['Title'])){
		        	$name           		= addslashes($metadata['name']);
		        }
		        if(isset($metadata['description'])){
		        	$description       		= addslashes($metadata['description']);
		        }
				if(isset($metadata['cover_photo'])){
		        	$cover_photo           	= addslashes($metadata['cover_photo']);
		        }

		        // update the metadata
		        $update = $conn->exec("UPDATE `channels` SET `description` = '".$description."' 		WHERE `id` = '".$id."'; ");
		        $update = $conn->exec("UPDATE `channels` SET `cover_photo` = '".$cover_photo."' 		WHERE `id` = '".$id."'; ");

		        status_message('success',"metadata for '".$media['name']."' has been updated");
			}else{
				status_message('danger',"Unable to find metadata for '".$media['name']."'");
			}
		}
	}
	
	go($_SERVER['HTTP_REFERER']);
}

function delete_all()
{
	global $conn, $global_settings;

	$type = get('type');

	if($type == 'channels'){
		$truncate = $conn->exec("TRUNCATE TABLE channels_files;");
		$truncate = $conn->exec("TRUNCATE TABLE channels;");
    	status_message('success',"All Channels have been deleted.");
    }
    if($type == 'vod'){
		$truncate = $conn->exec("TRUNCATE TABLE vod;");
    	status_message('success',"All Video on Demand movies have been deleted.");
    }
    if($type == 'tv_series'){
		$truncate = $conn->exec("TRUNCATE TABLE tv_series;");
		$truncate = $conn->exec("TRUNCATE TABLE tv_series_files;");
    	status_message('success',"All TV Series have been deleted.");
    }
    if($type == 'streams'){
		$truncate = $conn->exec("TRUNCATE TABLE streams;");
    	status_message('success',"All Streams have been deleted.");
    }
	go($_SERVER['HTTP_REFERER']);
}

function channel_multi_options()
{
	global $conn, $site;

	$action = post('multi_options_action');

	$channel_ids = $_POST['channel_ids'];

	if($action == 'disable'){
		foreach($channel_ids as $channel_id)
		{
			$update = $conn->exec("UPDATE `channels` SET `enable` = 'no' 					WHERE `id` = '".$channel_id."' ");
		}

		status_message('success',"Selected channels have been disabled.");
	}
	if($action == 'enable'){
		foreach($channel_ids as $channel_id)
		{
			$update = $conn->exec("UPDATE `channels` SET `enable` = 'yes' 					WHERE `id` = '".$channel_id."' ");
		}

		status_message('success',"Selected channels have been enabled.");
	}
	if($action == 'delete'){
		foreach($channel_ids as $channel_id)
		{
			$update = $conn->exec("DELETE FROM `channels_files` 							WHERE `channel_id` = '".$channel_id."' ");
			$update = $conn->exec("DELETE FROM `channels` 									WHERE `id` = '".$channel_id."' ");
		}

		status_message('success',"Selected channels have been deleted.");
	}
	if($action == 'change_transcoding_profile'){
		$transcoding_profile_id = post('transcoding_profile_id');
		foreach($channel_ids as $channel_id)
		{
			$update = $conn->exec("UPDATE `channels` SET `transcoding_profile_id` = '".$transcoding_profile_id."' 		WHERE `id` = '".$channel_id."' ");
		}

		status_message('success',"Selected 24/7 TV Channels have been enabled.");
	}

	go($_SERVER['HTTP_REFERER']);
}








function commission_approve()
{
	global $conn, $global_settings;

	$id = get('id');

	$update = $conn->exec("UPDATE `commissions` SET `status` = 'approved' WHERE `id` = '".$id."' ");
	
    status_message('success',"Commission has been manually approved.");

	go($_SERVER['HTTP_REFERER']);
}

function commissions_approve_all()
{
	global $conn, $global_settings;

	$member_id = get('id');

	$update = $conn->exec("UPDATE `commissions` SET `status` = 'approved' WHERE `user_id` = '".$member_id."' AND `status` = 'pending' AND `qualified` = 'yes'  ");
	
    status_message('success',"All pending commissions have been manually approved.");

	go($_SERVER['HTTP_REFERER']);
}

function commission_reset()
{
	global $conn, $global_settings;

	$id = get('id');

	$update = $conn->exec("UPDATE `commissions` SET `status` = 'pending' WHERE `id` = '".$id."' ");
	
    status_message('success',"Commission has been reset.");

	go($_SERVER['HTTP_REFERER']);
}

function ajax_commissions()
{
	global $conn, $global_settings;

	$count 			= 0;

	$member_id 		= $_SESSION['account']['id'];

	header("Content-Type:application/json; charset=utf-8");

	// get all commissions
	$query 				= $conn->query("SELECT * FROM `commissions` WHERE `user_id` = '".$member_id."' ");
	$commissions 		= $query->fetchAll(PDO::FETCH_ASSOC); 
	
	// work with commissions
	foreach($commissions as $commission){
		$output[$count]							= $commission;

		$output[$count]['checkbox']				= '<center><input type="checkbox" class="chk" id="checkbox_'.$commission['id'].'" name="commission_ids[]" value="'.$commission['id'].'" onclick="multi_options();"></center>';

		$output[$count]['added'] 				= $commission['added'];
		$output[$count]['order_date'] 			= date("Y-m-d", $commission['added']);
		$pending_commissions_period				= 2592000;
		$output[$count]['release_date'] 		= date("Y-m-d", $commission['added'] + $pending_commissions_period);

		// status
		if($commission['status'] == 'approved') {
			$output[$count]['status'] 					= '<span class="label label-warning full-width" style="width: 100%;">Approved</span>';
		}elseif($commission['status'] == 'pending' && $commission['qualified'] == 'yes'){
			$output[$count]['status']					= '<span class="label label-info full-width" style="width: 100%;">Pending</span>';
		}elseif($commission['status'] == 'pending' && $commission['qualified'] == 'no'){
			$output[$count]['status']					= '<span class="label label-danger full-width" style="width: 100%;">Missed</span>';
		}elseif($commission['status'] == 'paid') {
			$output[$count]['status'] 					= '<span class="label label-success full-width" style="width: 100%;">Paid</span>';
		}elseif($commission['status'] == 'rejected') {
			$output[$count]['status'] 					= '<span class="label label-danger full-width" style="width: 100%;">Rejected</span>';
		}else{
			$output[$count]['status'] 					= '<span class="label label-warning full-width" style="width: 100%;">'.ucfirst($commission['status']).'</span>';
		}

		// get customer_id
		$output[$count]['customer_id'] 			= $commission['customer_id'];

		// commission amount
		$output[$count]['amount'] 				= '£'.number_format($commission['amount'], 2);

		// order_id
		$output[$count]['order_id'] 			= $commission['int_order_id'];
		$output[$count]['order_id_hidden']		= '<span class="hidden">'.stripslashes($commission['int_order_id']).'</span>';

		// qualified
		if($commission['qualified'] == 'yes') {
			$output[$count]['qualified'] 					= '<span class="label label-success full-width" style="width: 100%;">Yes</span>';
		}elseif($commission['qualified'] == 'no') {
			$output[$count]['qualified']					= '<span class="label label-danger full-width" style="width: 100%;">No</span>';
		}

		// build the actions menu options
		$output[$count]['actions'] 						= '
			<div class="btn-group">
				<span class="pull-right">
					<!-- 
					<a title="View MLM Profile" class="btn btn-info btn-flat btn-xs" href="dashboard.php?c=member&id='.$commission['id'].'"><i class="fa fa-eye"></i></a>
					<a title="View Billing Profile" class="btn btn-primary btn-flat btn-xs" href="https://ublo.club/billing/admin/clientssummary.php?userid='.$commission['id'].'" target="_blank"><i class="fa fa-dollar"></i></a>
					-->
		';

		if($commission['status'] == 'pending'){
			$output[$count]['actions'] 						.= '
					<span class="hidden-xs">
						<a title="Manually Approve Commission" class="btn btn-success btn-flat btn-xs" href="actions.php?a=commission_approve&id='.$commission['id'].'"><i class="fa fa-check"></i></a>
					</span>
			';
		}elseif($commission['status'] != 'paid'){
			$output[$count]['actions'] 						.= '
					<span class="hidden-xs">
						<a title="Reset Commission" class="btn btn-warning btn-flat btn-xs" onclick="return confirm(\'The commission will be reset. Are you sure?\')" href="actions.php?a=commission_reset&id='.$commission['id'].'"><i class="fa fa-recycle"></i></a>
					</span>
			';
		}else{
			$output[$count]['actions'] 						.= '
					<span class="hidden-xs">
						<a title="Not Available" class="btn btn-default btn-flat btn-xs" href="#" disabled><i class="fa fa-recycle"></i></a>
					</span>
			';
		}

		$output[$count]['actions'] 						.= '
					<span class="hidden-xs">
						<!-- <a title="View Order" class="btn btn-info btn-flat btn-xs" href="https://ublo.club/billing/admin/orders.php?action=view&id='.$commission['int_order_id'].'" target="_blank"><i class="fa fa-shopping-cart"></i></a> -->
					</span>

					<a title="Reject Commission" class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'This will reject this commission for this member. Are you sure?\')" href="actions.php?a=commission_reject&id='.$commission['id'].'"><i class="fa fa-times"></i></a>
				</span>
			</div>';

		// $count loop
		$count++;
	}

	if(isset($output)) {
		$data['data'] = array_values($output);
	}else{
		$data['data'] = array();
	}

	json_output($data);
}

function ajax_products()
{
	global $conn, $global_settings;

	$time_shift 	= time() - 20;

	$count 			= 0;

	$user_id 		= $_SESSION['account']['id'];

	header("Content-Type:application/json; charset=utf-8");

	// get ublo affiliate info
	$whmcsUrl = "https://ublo.club/billing/";
	$username = "api_user";
	$password = md5("admin1372");

	// Set post values
	$postfields = array(
	    'username' 		=> $username,
	    'password' 		=> $password,
	    'action' 		=> 'GetProducts',
	    'responsetype' 	=> 'json',
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

	// decode response
	$whmcs_products = json_decode($response, true);
	// debug($whmcs_products);
	$whmcs_products = $whmcs_products['products']['product'];

	foreach($whmcs_products as $product){
		$output[$count] 								= $product;

		// set pricing to price var
		$output[$count]['price']['monthly']				= str_replace('-1.00', '0.00', $output[$count]['pricing']['GBP']['monthly']);
		$output[$count]['price']['quarterly']			= str_replace('-1.00', '0.00', $output[$count]['pricing']['GBP']['quarterly']);
		$output[$count]['price']['annually']			= str_replace('-1.00', '0.00', $output[$count]['pricing']['GBP']['annually']);

		// insert product to local db for additional features
		$insert = $conn->exec("INSERT IGNORE INTO `shop_products` 
	        (`id`,`added`,`title`,`price_month`,`price_year`,`category_id`)
	        VALUE
	        ('".$product['pid']."',
	        '".time()."',
	        '".$product['name']."',
	        '".$output[$count]['price']['monthly']."',
	        '".$output[$count]['price']['annually']."',
	        '".$product['gid']."'
	    )");

	    // update the core values from whmcs
	    $update = $conn->exec("UPDATE `shop_products` SET `title` = '".$product['name']."' 								WHERE `id` = '".$product['pid']."' ");
	    $update = $conn->exec("UPDATE `shop_products` SET `price_month` = '".$output[$count]['price']['monthly']."' 	WHERE `id` = '".$product['pid']."' ");
	    $update = $conn->exec("UPDATE `shop_products` SET `price_year` = '".$output[$count]['price']['annually']."' 	WHERE `id` = '".$product['pid']."' ");
	    $update = $conn->exec("UPDATE `shop_products` SET `category_id` = '".$output[$count]['gid']."' 					WHERE `id` = '".$product['pid']."' ");

		$output[$count]['checkbox']						= '<center><input type="checkbox" class="chk" id="checkbox_'.$product['pid'].'" name="product_ids[]" value="'.$product['pid'].'" onclick="multi_options();"></center>';

		// get product category
		$query 											= $conn->query("SELECT * FROM `whmcs`.`tblproductgroups` WHERE `id` = '".$product['gid']."' ");
		$product_category 								= $query->fetch(PDO::FETCH_ASSOC);
		$output[$count]['category']						= stripslashes($product_category['name']);

		// get description
		$query 											= $conn->query("SELECT * FROM `shop_products` WHERE `id` = '".$product['pid']."' ");
		$product_details 								= $query->fetch(PDO::FETCH_ASSOC);

		$output[$count]['description']					= stripslashes($product_details['description']);

		// set recurring or not
		if($product['paytype'] == 'onetime'){
			$output[$count]['recurring']				= 'One Time';
		}else{
			$output[$count]['recurring']				= 'Recurring';
		}

		$output[$count]['price']['monthly']				= '£'.$output[$count]['price']['monthly'];
		$output[$count]['price']['quarterly']			= '£'.$output[$count]['price']['quarterly'];
		$output[$count]['price']['annually']			= '£'.$output[$count]['price']['monthly'];

		// build the actions menu options
		$output[$count]['actions'] 						= '
			<div class="btn-group">
				<span class="pull-right">
					<a title="View / Edit Product" class="btn btn-info btn-flat btn-xs" href="dashboard.php?c=product&id='.$product['pid'].'"><i class="fa fa-eye"></i></a>
					<a title="View WHMCS Product" class="btn btn-primary btn-flat btn-xs" href="https://ublo.club/billing/admin/configproducts.php?action=edit&id='.$product['pid'].'" target="_blank"><i class="fa fa-dollar"></i></a>
				</span>
			</div>';

		// $count loop
		$count++;
	}

	if(isset($output)) {
		$data['data'] = array_values($output);
	}else{
		$data['data'] = array();
	}

	json_output($data);
}

function ajax_all_commissions()
{
	global $conn, $global_settings;

	$count 				= 0;

	header("Content-Type:application/json; charset=utf-8");

	// get all commissions
	$query 				= $conn->query("SELECT * FROM `commissions` ");
	$commissions 		= $query->fetchAll(PDO::FETCH_ASSOC);

	// get all customers
	$query 				= $conn->query("SELECT `id`,`added`,`status`,`first_name`,`last_name`,`email`,`tel`,`expire_date`,`internal_notes`,`upline_id`,`total_downline` FROM `users` ");
	$customers 			= $query->fetchAll(PDO::FETCH_ASSOC);
	
	// work with commissions
	foreach($commissions as $commission){
		$output[$count]							= $commission;

		$output[$count]['checkbox']				= '<center><input type="checkbox" class="chk" id="checkbox_'.$commission['id'].'" name="commission_ids[]" value="'.$commission['id'].'" onclick="multi_options();"></center>';

		$output[$count]['added'] 				= $commission['added'];
		$output[$count]['order_date'] 			= date("Y-m-d", $commission['added']);
		$pending_commissions_period				= 2592000;
		$output[$count]['release_date'] 		= date("Y-m-d", $commission['added'] + $pending_commissions_period);

		// status
		if($commission['status'] == 'approved') {
			$output[$count]['status'] 					= '<span class="label label-warning full-width" style="width: 100%;">Approved</span>';
		}elseif($commission['status'] == 'pending' && $commission['qualified'] == 'yes'){
			$output[$count]['status']					= '<span class="label label-info full-width" style="width: 100%;">Pending</span>';
		}elseif($commission['status'] == 'pending' && $commission['qualified'] == 'no'){
			$output[$count]['status']					= '<span class="label label-default full-width" style="width: 100%;">N/A</span>';
		}elseif($commission['status'] == 'paid') {
			$output[$count]['status'] 					= '<span class="label label-success full-width" style="width: 100%;">Paid</span>';
		}elseif($commission['status'] == 'rejected') {
			$output[$count]['status'] 					= '<span class="label label-danger full-width" style="width: 100%;">Rejected</span>';
		}else{
			$output[$count]['status'] 					= '<span class="label label-warning full-width" style="width: 100%;">'.ucfirst($commission['status']).'</span>';
		}

		// get customer data
		if($commission['user_id'] == 0){
			$output[$count]['member']					= 'Company Account';
		}else{
			foreach($customers as $customer){
				if($commission['user_id'] == $customer['id']){
					$output[$count]['member']			= '<a href="dashboard.php?c=member&id='.$customer['id'].'">'.$customer['first_name'].' '.$customer['last_name'].'</a>';
					break;
				}
			}
		}
		if(!isset($output[$count]['member'])){
			$output[$count]['member']					= 'Unknown ID: '.$commission['user_id'];
		}

		// commission amount
		$output[$count]['amount'] 						= '£'.number_format($commission['amount'], 2);

		// order_id
		$output[$count]['order_id'] 					= $commission['int_order_id'];
		$output[$count]['order_id_hidden']				= '<span class="hidden">'.stripslashes($commission['int_order_id']).'</span>';

		// qualified
		if($commission['qualified'] == 'yes') {
			$output[$count]['qualified'] 				= '<span class="label label-success full-width" style="width: 100%;">Yes</span>';
		}elseif($commission['qualified'] == 'no') {
			$output[$count]['qualified']				= '<span class="label label-danger full-width" style="width: 100%;">No</span>';
		}

		// build the actions menu options
		$output[$count]['actions'] 						= '
			<div class="btn-group">
				<span class="pull-right">
					<!-- 
					<a title="View MLM Profile" class="btn btn-info btn-flat btn-xs" href="dashboard.php?c=member&id='.$commission['id'].'"><i class="fa fa-eye"></i></a>
					<a title="View Billing Profile" class="btn btn-primary btn-flat btn-xs" href="https://ublo.club/billing/admin/clientssummary.php?userid='.$commission['id'].'" target="_blank"><i class="fa fa-dollar"></i></a>
					-->
		';

		if($commission['status'] == 'pending'){
			$output[$count]['actions'] 					.= '
					<span class="hidden-xs">
						<a title="Manually Approve Commission" class="btn btn-success btn-flat btn-xs" href="actions.php?a=commission_approve&id='.$commission['id'].'"><i class="fa fa-check"></i></a>
					</span>
			';
		}elseif($commission['status'] != 'paid'){
			$output[$count]['actions'] 					.= '
					<span class="hidden-xs">
						<a title="Reset Commission" class="btn btn-warning btn-flat btn-xs" onclick="return confirm(\'The commission will be reset. Are you sure?\')" href="actions.php?a=commission_reset&id='.$commission['id'].'"><i class="fa fa-recycle"></i></a>
					</span>
			';
		}else{
			$output[$count]['actions'] 					.= '
					<span class="hidden-xs">
						<a title="Not Available" class="btn btn-default btn-flat btn-xs" href="#" disabled><i class="fa fa-recycle"></i></a>
					</span>
			';
		}

		$output[$count]['actions'] 						.= '
					<span class="hidden-xs">
						<a title="View Order" class="btn btn-info btn-flat btn-xs" href="https://ublo.club/billing/admin/orders.php?action=view&id='.$commission['int_order_id'].'" target="_blank"><i class="fa fa-shopping-cart"></i></a>
					</span>

					<a title="Reject Commission" class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'This will reject this commission for this member. Are you sure?\')" href="actions.php?a=commission_reject&id='.$commission['id'].'"><i class="fa fa-times"></i></a>
				</span>
			</div>';

		// $count loop
		$count++;
	}

	if(isset($output)) {
		$data['data'] = array_values($output);
	}else{
		$data['data'] = array();
	}

	json_output($data);
}

function ajax_withdrawal_requests()
{
	global $conn, $global_settings;

	$count 				= 0;

	header("Content-Type:application/json; charset=utf-8");

	// get all commissions
	$query 						= $conn->query("SELECT * FROM `withdrawal_requests` ");
	$withdrawal_requests 		= $query->fetchAll(PDO::FETCH_ASSOC);

	// get all customers
	$query 						= $conn->query("SELECT `id`,`added`,`status`,`first_name`,`last_name`,`email`,`tel`,`expire_date`,`internal_notes`,`upline_id`,`total_downline` FROM `users` ");
	$customers 					= $query->fetchAll(PDO::FETCH_ASSOC);
	
	// work with commissions
	foreach($withdrawal_requests as $withdrawal_request){
		$output[$count]							= $withdrawal_request;

		$output[$count]['checkbox']				= '<center><input type="checkbox" class="chk" id="checkbox_'.$withdrawal_request['id'].'" name="withdrawal_requests_ids[]" value="'.$withdrawal_request['id'].'" onclick="multi_options();"></center>';

		$output[$count]['added'] 				= $withdrawal_request['added'];
		$output[$count]['request_date'] 		= date("Y-m-d", $withdrawal_request['added']);

		// status
		if($withdrawal_request['status'] == 'approved') {
			$output[$count]['status'] 					= '<span class="label label-warning full-width" style="width: 100%;">Approved</span>';
		}elseif($withdrawal_request['status'] == 'pending'){
			$output[$count]['status']					= '<span class="label label-warning full-width" style="width: 100%;">Pending</span>';
		}elseif($withdrawal_request['status'] == 'paid') {
			$output[$count]['status'] 					= '<span class="label label-success full-width" style="width: 100%;">Paid</span>';
		}elseif($withdrawal_request['status'] == 'rejected') {
			$output[$count]['status'] 					= '<span class="label label-danger full-width" style="width: 100%;">Rejected</span>';
		}elseif($withdrawal_request['status'] == 'cancelled') {
			$output[$count]['status'] 					= '<span class="label label-danger full-width" style="width: 100%;">Cancelled</span>';
		}else{
			$output[$count]['status'] 					= '<span class="label label-warning full-width" style="width: 100%;">'.ucfirst($withdrawal_request['status']).'</span>';
		}

		// get customer data
		if($withdrawal_request['user_id'] == 0){
			$output[$count]['member']					= 'Company Account';
		}else{
			foreach($customers as $customer){
				if($withdrawal_request['user_id'] == $customer['id']){
					$output[$count]['member']			= '<a href="dashboard.php?c=member&id='.$customer['id'].'">'.$customer['first_name'].' '.$customer['last_name'].'</a>';
					break;
				}
			}
		}
		if(!isset($output[$count]['member'])){
			$output[$count]['member']					= 'Unknown ID: '.$withdrawal_request['user_id'];
		}

		// commission amount
		$output[$count]['amount'] 						= '£'.number_format($withdrawal_request['amount'], 2);

		// order_id
		$output[$count]['request_id'] 					= $withdrawal_request['id'];
		$output[$count]['request_id_hidden']			= '<span class="hidden">'.stripslashes($withdrawal_request['id']).'</span>';

		// build the actions menu options
		$output[$count]['actions'] 						= '
			<div class="btn-group">
				<span class="pull-right">
		';

		if($withdrawal_request['status'] == 'rejected'){
			$output[$count]['actions'] 					.= '
					<a title="Reset Withdrawal Request" class="btn btn-warning btn-flat btn-xs" onclick="return confirm(\'Are you sure?\')" href="actions.php?a=withdrawal_request_status&id='.$withdrawal_request['id'].'&status=pending"><i class="fa fa-times"></i></a>
				</span>
			</div>';
		}elseif($withdrawal_request['status'] == 'pending'){
			$output[$count]['actions'] 					.= '
					<a title="Reject withdrawal Request" class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Are you sure?\')" href="actions.php?a=withdrawal_request_status&id='.$withdrawal_request['id'].'&status=rejected"><i class="fa fa-times"></i></a>
				</span>
			</div>';
		}else{
			$output[$count]['actions'] 					.= '
				</span>
			</div>';
		}

		// $count loop
		$count++;
	}

	if(isset($output)) {
		$data['data'] = array_values($output);
	}else{
		$data['data'] = array();
	}

	json_output($data);
}

function withdrawal_request_status()
{
	global $conn, $global_settings;

	$id 		= get('id');
	$status 	= get('status');

	$update = $conn->exec("UPDATE `withdrawal_requests` SET `status` = '".$status."' WHERE `id` = '".$id."' ");
	
    status_message('success',"withdrawal Request has been updated.");

	go($_SERVER['HTTP_REFERER']);
}

function member_update()
{
	global $conn, $global_settings;

	$member_id 			= post('member_id');

	$upline_id 			= post('upline_id');

	$update = $conn->exec("UPDATE `users` SET `upline_id` = '".$upline_id."' WHERE `id` = '".$member_id."' ");

    status_message('success',"Updates have been saved.");
    go($_SERVER['HTTP_REFERER']);
}

function ajax_withdrawals()
{
	global $conn, $global_settings;

	$count 				= 0;

	$user_id 			= $_SESSION['account']['id'];

	header("Content-Type:application/json; charset=utf-8");

	// get all commissions
	$query 						= $conn->query("SELECT * FROM `withdrawal_requests` WHERE `user_id` = '".$user_id."' ");
	$withdrawal_requests 		= $query->fetchAll(PDO::FETCH_ASSOC);

	
	// work with commissions
	foreach($withdrawal_requests as $withdrawal_request){
		$output[$count]							= $withdrawal_request;

		$output[$count]['checkbox']				= '<center><input type="checkbox" class="chk" id="checkbox_'.$withdrawal_request['id'].'" name="withdrawal_requests_ids[]" value="'.$withdrawal_request['id'].'" onclick="multi_options();"></center>';

		$output[$count]['added'] 				= $withdrawal_request['added'];
		$output[$count]['request_date'] 		= date("Y-m-d", $withdrawal_request['added']);

		if(!is_null($withdrawal_request['paid_date'])){
			$output[$count]['paid_date'] 			= date("Y-m-d", $withdrawal_request['paid_date']);
		}else{
			$output[$count]['paid_date'] 			= '';
		}

		// status
		if($withdrawal_request['status'] == 'approved') {
			$output[$count]['status'] 					= '<span class="label label-warning full-width" style="width: 100%;">Approved</span>';
		}elseif($withdrawal_request['status'] == 'pending'){
			$output[$count]['status']					= '<span class="label label-warning full-width" style="width: 100%;">Pending</span>';
		}elseif($withdrawal_request['status'] == 'paid') {
			$output[$count]['status'] 					= '<span class="label label-success full-width" style="width: 100%;">Paid</span>';
		}elseif($withdrawal_request['status'] == 'rejected') {
			$output[$count]['status'] 					= '<span class="label label-danger full-width" style="width: 100%;">Rejected</span>';
		}elseif($withdrawal_request['status'] == 'cancelled') {
			$output[$count]['status'] 					= '<span class="label label-danger full-width" style="width: 100%;">Cancelled</span>';
		}else{
			$output[$count]['status'] 					= '<span class="label label-warning full-width" style="width: 100%;">'.ucfirst($withdrawal_request['status']).'</span>';
		}

		// commission amount
		$output[$count]['amount'] 						= '£'.number_format($withdrawal_request['amount'], 2);

		// order_id
		$output[$count]['request_id'] 					= $withdrawal_request['id'];
		$output[$count]['request_id_hidden']			= '<span class="hidden">'.stripslashes($withdrawal_request['id']).'</span>';

		// build the actions menu options
		$output[$count]['actions'] 						= '
			<div class="btn-group">
				<span class="pull-right">
		';

		if($withdrawal_request['status'] == 'pending'){
			$output[$count]['actions'] 					.= '
					<a title="Cancel Withdrawal Request" class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Are you sure?\')" href="actions.php?a=withdrawal_request_cancel&id='.$withdrawal_request['id'].'"><i class="fa fa-times"></i></a>
				</span>
			</div>';
		}else{
			$output[$count]['actions'] 					.= '
				</span>
			</div>';
		}

		$output[$count]['comment'] 					= stripslashes($withdrawal_request['comment']);

		$output[$count]['blank'] 						= '';

		// $count loop
		$count++;
	}

	if(isset($output)) {
		$data['data'] = array_values($output);
	}else{
		$data['data'] = array();
	}

	json_output($data);
}

function withdrawal_request_add()
{
	global $conn, $global_settings;
		
	$member_id 			= $_SESSION['account']['id'];
	$amount 			= post('amount');
	$available 			= post('available');

	if($amount > $available){
		$insert = $conn->exec("INSERT INTO `withdrawal_requests` 
	        (`added`,`user_id`,`status`,`amount`,`comment`)
	        VALUE
	        ('".time()."',
	        '".$member_id."',
	        'rejected',
	        '".$amount."',
	        'You requested a £".$amount." withdrawal which is more than your available balance of £".$available."'
	    )");

		status_message('danger',"You requested a £".$amount." withdrawal which is more than your available balance of £".$available);
		go($_SERVER['HTTP_REFERER']);
	}

	if($amount < $global_settings['payout_min']){
		$insert = $conn->exec("INSERT INTO `withdrawal_requests` 
	        (`added`,`user_id`,`status`,`amount`,`comment`)
	        VALUE
	        ('".time()."',
	        '".$member_id."',
	        'rejected',
	        '".$amount."',
	        'You requested a £".$amount." withdrawal which is less than the system minimum of £".$global_settings['payout_min']."'
	    )");

		status_message('danger',"You requested a £".$amount." withdrawal which is less than the system minimum of £".$global_settings['payout_min']);
		go($_SERVER['HTTP_REFERER']);
	}

	$insert = $conn->exec("INSERT INTO `withdrawal_requests` 
	   	(`added`,`user_id`,`status`,`amount`,`comment`)
        VALUE
        ('".time()."',
        '".$member_id."',
        'pending',
        '".$amount."',
        'Your withdrawal request has been submitted and will be paid shortly'
    )");

    status_message('success',"Your withdrawal request has been submitted and will be paid shortly.");
	go($_SERVER['HTTP_REFERER']);
}

function withdrawal_request_cancel()
{
	global $conn, $global_settings;
		
	$member_id 			= $_SESSION['account']['id'];
	$id 				= get('id');

	$delete = $conn->query("UPDATE `withdrawal_requests` SET `status` = 'cancelled' WHERE `id` = '".$id."' AND `user_id` = '".$member_id."' ");
	$delete = $conn->query("UPDATE `withdrawal_requests` SET `comment` = 'Request cancelled on ".date("Y-m-d", time())." by member' WHERE `id` = '".$id."' AND `user_id` = '".$member_id."' ");

    status_message('success',"Your withdrawal request has been cancelled and the funds transferred back to your available balance.");
	go($_SERVER['HTTP_REFERER']);
}

function product_image_upload(){
	global $conn, $whmcs, $site;

	$fileName = $_FILES["file1"]["name"]; // The file name
	
	$fileName = str_replace('"', '', $fileName);
	$fileName = str_replace("'", '', $fileName);
	$fileName = str_replace(' ', '_', $fileName);
	$fileName = str_replace(array('!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '+', '+', ';', ':', '\\', '|', '~', '`', ',', '<', '>', '/', '?', '§', '±',), '', $fileName);
	// $fileName = $fileName . '.' . $fileExt;
	
	$fileTmpLoc = $_FILES["file1"]["tmp_name"]; // File in the PHP tmp folder
	$fileType = $_FILES["file1"]["type"]; // The type of file it is
	$fileSize = $_FILES["file1"]["size"]; // File size in bytes
	$fileErrorMsg = $_FILES["file1"]["error"]; // 0 for false... and 1 for true
	if (!$fileTmpLoc) { // if file not chosen
		echo "Please select a photo to upload first.";
		exit();
	}

	
	// handle the uploaded file
	if(move_uploaded_file($fileTmpLoc, "uploads/".$fileName)){
		
		// insert into the database
		$insert = $conn->exec("INSERT INTO `shop_product_images` 
	        (`path`)
	        VALUE
	        ('uploads/".$fileName."'
	    )");
		
		// report
		echo "<font color='#18B117'><b>Upload Complete</b></font>";
		
	}else{
		echo "ERROR: Oops, something went very wrong. Please try again or contact support for more help.";
		exit();
	}	
}

function product_image_delete()
{
	global $conn, $global_settings;

	$image_id = get('id');

	// delete the database record
	$delete = $conn->query("DELETE FROM `shop_product_images` WHERE `id` = '".$image_id."' ");

	status_message('success',"Product image has been deleted.");
	go($_SERVER['HTTP_REFERER']);
}

function product_update()
{
	global $conn, $global_settings;

	$product_id 		= post('product_id');

	$category_id 		= post('category_id');

	$stars 				= post('stars');

	$sale_icon 			= post('sale_icon');

	$homepage 			= post('homepage');

	$image_main 		= post('image_main');
	
	$title 				= post('title');
	$title 				= addslashes($title);

	$title_2 			= post('title_2');
	$title_2 			= addslashes($title_2);

	$description 		= post('description');
	$description 		= addslashes($description);

	$update = $conn->exec("UPDATE `shop_products` SET `category_id` = '".$category_id."' 			WHERE `id` = '".$product_id."' ");
	$update = $conn->exec("UPDATE `whmcs`.`tblproducts` SET `gid` = '".$category_id."' 				WHERE `id` = '".$product_id."' ");

	$update = $conn->exec("UPDATE `shop_products` SET `stars` = '".$stars."' 						WHERE `id` = '".$product_id."' ");

	$update = $conn->exec("UPDATE `shop_products` SET `sale_icon` = '".$sale_icon."' 				WHERE `id` = '".$product_id."' ");

	$update = $conn->exec("UPDATE `shop_products` SET `homepage` = '".$homepage."' 					WHERE `id` = '".$product_id."' ");

	$update = $conn->exec("UPDATE `shop_products` SET `title` = '".$title."' 						WHERE `id` = '".$product_id."' ");
	$update = $conn->exec("UPDATE `whmcs`.`tblproducts` SET `name` = '".$title."' 					WHERE `id` = '".$product_id."' ");
	
	$update = $conn->exec("UPDATE `shop_products` SET `title_2` = '".$title_2."' 					WHERE `id` = '".$product_id."' ");
	
	$update = $conn->exec("UPDATE `shop_products` SET `image_main` = 'https://ukmarketingclub.com/dashboard/".$image_main."' 				WHERE `id` = '".$product_id."' ");

	$update = $conn->exec("UPDATE `shop_products` SET `description` = '".$description."' 			WHERE `id` = '".$product_id."' ");
	$update = $conn->exec("UPDATE `whmcs`.`tblproducts` SET `description` = '".$description."' 		WHERE `id` = '".$product_id."' ");

    // log_add("[".$name."] has been updated.");
    status_message('success',"Product details have been updated and published.");
    go($_SERVER['HTTP_REFERER']);
}

function product_linked_add()
{
	global $conn, $global_settings;

	$product_id 		= post('product_id');
	$secondary_id 		= post('secondary_id');

	$insert = $conn->exec("INSERT INTO `shop_products_linked` 
        (`primary`,`secondary`)
        VALUE
        ('".$product_id."','".$secondary_id."')"
    );

    status_message('success',"Product has been linked.");
    go($_SERVER['HTTP_REFERER']);
}

function product_linked_delete()
{
	global $conn, $global_settings;

	$product_id = get('id');

	// delete the database record
	$delete = $conn->query("DELETE FROM `shop_products_linked` WHERE `id` = '".$product_id."' ");

	status_message('success',"Linked product has been deleted.");
	go($_SERVER['HTTP_REFERER']);
}

function faq_add()
{
	global $conn, $global_settings;

	$title 				= post('title');
	$description 		= post('description');
	$website 			= post('website');

	$insert = $conn->exec("INSERT INTO `shop_faq` 
        (`title`,`description`,`website`)
        VALUE
        ('".$title."','".$description."','".$website."')"
    );

    status_message('success',"FAQ has been added.");
    go($_SERVER['HTTP_REFERER']);
}

function faq_update()
{
	global $conn, $global_settings;

	$faq_id 			= post('faq_id');

	$title 				= post('title');
	$description 		= post('description');
	$website 			= post('website');

	$update = $conn->exec("UPDATE `shop_faq` SET `title` = '".$title."' 							WHERE `id` = '".$faq_id."' ");
	$update = $conn->exec("UPDATE `shop_faq` SET `description` = '".$description."' 				WHERE `id` = '".$faq_id."' ");
	$update = $conn->exec("UPDATE `shop_faq` SET `website` = '".$website."' 						WHERE `id` = '".$faq_id."' ");

    // log_add("[".$name."] has been updated.");
    status_message('success',"FAQ has been updated and published.");
    go($_SERVER['HTTP_REFERER']);
}

function faq_delete()
{
	global $conn, $global_settings;

	$faq_id = get('faq_id');

	// delete the database record
	$delete = $conn->query("DELETE FROM `shop_faq` WHERE `id` = '".$faq_id."' ");

	status_message('success',"FAQ has been deleted.");
	go($_SERVER['HTTP_REFERER']);
}