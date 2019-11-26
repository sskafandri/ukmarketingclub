<?php

if(isset($_GET['dev']) && $_GET['dev'] == 'yes'){
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
}

date_default_timezone_set('UTC');

session_start();

// includes
include('inc/db.php');
include('inc/global_vars.php');
include('inc/functions.php');

// start timer for page loaded var
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

// check is account->id is set, if not then assume user is not logged in correctly and redirect to login page
if(empty($_SESSION['account']['id'])){
	status_message('danger', 'Login Session Timeout');
	go('index.php?c=session_timeout');
}

// get account details for logged in user
if($_SESSION['account']['id'] != 'reseller'){
	$account_details = account_details($_SESSION['account']['id']);

	if($account_details['password'] == 'admin'){
		status_message('danger',"Default password detected. Change it ASAP under CMS Management > My Account");
	}

	// enable / disable modules
	$module['cdn_streams'] 						= false;

	// set some global vars for use later
	$globals['customers']						= total_customers();
	$globals['mags']							= total_mags();
	$globals['resellers']						= total_resellers();
	$globals['servers']['total'] 				= total_servers();
	$globals['servers']['online'] 				= total_online_servers();
	$globals['servers']['offline'] 				= total_offline_servers();
	$globals['servers']['total_bandwidth'] 		= total_bandwidth();
	$globals['streams']['total'] 				= total_streams();
	$globals['vod']['total'] 					= total_vod();
	$globals['tv_series']['total'] 				= total_tv_series();
	$globals['channels']['total'] 				= total_channels();
	$globals['cdn_streams']['total'] 			= total_cdn_streams();
	$globals['clients']['total']				= total_online_clients();
	$globals['firewall_rules']['total']			= total_firewall_rules();
}else{
	die('reseller detected');
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $site['title']; ?></title>

	<link rel="apple-touch-icon" sizes="57x57" href="images/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="images/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="images/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="images/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="images/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="images/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="images/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="images/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="images/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="images/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="images/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">
	<!-- <link rel="manifest" href="manifest.json"> -->
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="images/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    
    <!--
    <link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">
	-->

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    
    <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"> -->
    <link rel="stylesheet" href="css/jquery.dataTables.min.css">

    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="dist/css/skins/skin-blue.css">

    <!-- <link rel="stylesheet" href="dist/css/modern-AdminLTE.min.css"> -->

    <!-- Select2 -->
    <link rel="stylesheet" href="plugins/select2/select2.min.css">

    <!-- bootstrap datepicker -->
  	<link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">

    <?php if(!isset($_GET['c']) || $_GET['c'] == 'home' || $_GET['c'] == 'staging' || $_GET['c'] == 'server') { ?>
    	<!-- jvectormap -->
  		<link rel="stylesheet" href="bower_components/jvectormap/jquery-jvectormap.css">

  		<!-- highcharts -->
  		<script src="https://code.highcharts.com/stock/highstock.js"></script>
	    <!-- <script src="https://code.highcharts.com/highcharts.js"></script> -->
	    <script src="https://code.highcharts.com/maps/modules/map.js"></script>
		<script src="https://code.highcharts.com/maps/modules/data.js"></script>
		<script src="https://code.highcharts.com/maps/modules/exporting.js"></script>
		<script src="https://code.highcharts.com/maps/modules/offline-exporting.js"></script>
		<script src="https://code.highcharts.com/mapdata/custom/world.js"></script>
		<script src="https://code.highcharts.com/modules/sankey.js"></script>
		<script src="https://code.highcharts.com/modules/exporting.js"></script>
		<script src="https://code.highcharts.com/modules/export-data.js"></script>

		<script src="https://www.highcharts.com/media/com_demo/js/highslide-full.min.js"></script>
		<script src="https://www.highcharts.com/media/com_demo/js/highslide.config.js" charset="utf-8"></script>
		<link rel="stylesheet" type="text/css" href="https://www.highcharts.com/media/com_demo/css/highslide.css" />
	<?php } ?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

	<!-- jQuery -->
    <script src="js/jquery-3.4.1.min.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    
    <!-- jQuery 3.3.1 -->
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.js"></script> -->

    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>

	<style>
		#server_locations {
			height: 600px;
			margin: 0px;
			padding: 0px;
			width: 100%;
		}

		#world_map_container {
		    height: 500px; 
		    width: 100%; 
		    margin: 0 auto; 
		}

		.highcharts-tooltip>span {
		    padding: 10px;
		    white-space: normal !important;
		    width: 200px;
		}

		.loading {
		    margin-top: 10em;
		    text-align: center;
		    color: gray;
		}

		.f32 .flag {
		    vertical-align: middle !important;
		}
		#map {
            height: 600px;
            width: 100%;
            margin: 0px;
            padding: 0px
        }

		.center-navbar{
			display: block; 
			text-align: center; 
			color: white; 
			padding: 15px; 
			/* adjust based on your layout */
			margin-left: 50px; 
			margin-right: 300px;
		}
	
		img.b_to_w {
			filter: grayscale(100%);
		}
		
		@-webkit-keyframes invalid {
		  	from { background-color: #FFB6C1; }
		  	to { background-color: inherit; }
		}
		@-moz-keyframes invalid {
		  	from { background-color: #FFB6C1; }
		  	to { background-color: inherit; }
		}
		@-o-keyframes invalid {
		  	from { background-color: #FFB6C1; }
		  	to { background-color: inherit; }
		}
		@keyframes invalid {
		  	from { background-color: #FFB6C1; }
		  	to { background-color: inherit; }
		}
		.invalid {
		  	-webkit-animation: invalid 5s infinite; /* Safari 4+ */
		  	-moz-animation:    invalid 5s infinite; /* Fx 5+ */
		  	-o-animation:      invalid 5s infinite; /* Opera 12+ */
		  	animation:         invalid 5s infinite; /* IE 10+ */
		}
		
		.row_red {
			background-color: #f9d6d4;
		}

		.row_yellow {
			background-color: #f9eed4;
		}

		.row_green {
			background-color: #dcf4de;
		}

		.full-width {
			width: 100%;
			display: block;
		}

		td {
			padding: 0em;
		}
		
		.textshadow .blurry-text {
		   color: transparent;
		   text-shadow: 0 0 5px rgba(0,0,0,0.5);
		}
		
		.example-modal .modal {
			position: relative;
			top: auto;
			bottom: auto;
			right: auto;
			left: auto;
			display: block;
			z-index: 1;
		}

		.example-modal .modal {
			background: transparent !important;
		}
		
		.modal-header {
			background-color: #337AB7;
			padding:16px 16px;
			color:#FFF;
			border-bottom:2px dashed #337AB7;
		}

		.modal.modal-wide .modal-dialog {
			width: 90%;
		}

		.modal-wide1 .modal-body {
			overflow-y: auto;
		}

		.modal-xl {
		    max-width: 90% !important;
		}

		.select2-container{ width: 100% !important; }
	</style>
</head>

<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <header class="main-header">
            <a href="dashboard.php" class="logo">
                <!-- <img src="img/logo_2.png" height="50px"> -->

                <span class="logo-mini"><?php echo $site['name_short']; ?></span>
                <span class="logo-lg"><?php echo $site['name_long']; ?></span>
            </a>

            <nav class="navbar navbar-static-top" role="navigation">
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
					<span class="sr-only">Toggle navigation</span>
				</a>
                
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="<?php echo $account_details['avatar']; ?>" class="user-image" alt="User Image">
                                <span class="hidden-xs">
									<?php echo $account_details['first_name']; ?> <?php echo $account_details['last_name']; ?>
                                </span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="user-header">
                                    <img src="<?php echo $account_details['avatar']; ?>" class="img-circle" alt="User Image">
                                    <p>
                                        <?php echo $account_details['first_name']; ?> <?php echo $account_details['last_name']; ?>
                                        <small><?php echo $account_details['email']; ?></small>
                                    </p>
                                </li>
                                <!-- Menu Body -->
                                <!--
                                <li class="user-body">
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Followers</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Sales</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Friends</a>
                                    </div>
                                </li>
                                -->
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="dashboard.php?c=my_account" class="btn btn-default btn-flat">My Account</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="logout.php" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <!-- Control Sidebar Toggle Button -->
						<li>
							<a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
						</li>
                    </ul>
                </div>
            </nav>
        </header>

        <aside class="main-sidebar">
            <section class="sidebar">
            	<div class="user-panel">
			        <div class="pull-left image">
			          	<img src="<?php echo $account_details['avatar']; ?>" class="img-circle" alt="User Image">
			        </div>
			        <div class="pull-left info">
			          	<p><?php echo $account_details['first_name'].' '.$account_details['last_name']; ?></p>
			          	<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
			        </div>
			    </div>
			    <!--
			    <form id="search_form" class="sidebar-form">
			        <div class="input-group">
			          	<input type="text" id="search_term" name="search_term" class="form-control" placeholder="Search">
			          	<span class="input-group-btn">
				            <button type="submit" id="search_button" name="search_button" class="btn btn-flat">
				            	<i class="fa fa-search"></i>
				            </button>
			            </span>
			        </div>
			    </form>
				-->
                <ul class="sidebar-menu">
                	<?php if($account_details['email'] == 'jamie.whittingham@gmail.com') { ?>
                		<li class="header">ADMIN NAVIGATION</li>
	                    <?php if(get('c') == 'test'){ ?>
	                    	<li class="active">
	                    <?php }else{ ?>
	                    	<li>
	                    <?php } ?>
	                    	<a href="dashboard.php?c=staging">
	                        	<i class="fa fa-globe"></i> 
	                        	<span>Staging Area</span>
	                        	<span class="pull-right-container">
				              		<small class="label pull-right bg-red">BETA</small>
				            	</span>
	                        </a>
	                    </li>
	                <?php } ?>

                	<li class="header">MAIN NAVIGATION</li>
                	<?php if(empty(get('c')) || get('c') == '' || get('c') == 'home'){ ?>
                    	<li class="active">
                    <?php }else{ ?>
                    	<li>
                    <?php } ?>
                    	<a href="dashboard.php?c=home">
                        	<i class="fa fa-home"></i> 
                        	<span>Dashboard</span>
                        </a>
                    </li>

                	<li class="treeview">
						<a href="#">
							<i class="fa fa-question-circle"></i> <span>Support &amp; Billing</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
		                	<li>
		                    	<a href="https://clients.deltacolo.com/cart.php?gid=addons" target="_blank">
		                        	<i class="fa fa-circle"></i> 
		                        	<span>Order New Load Balancer</span>
		                        </a>
		                    </li>
		                    <li>
		                    	<a href="https://clients.deltacolo.com/clientarea.php?action=invoices" target="_blank">
		                        	<i class="fa fa-circle"></i> 
		                        	<span>Billing Portal</span>
		                        </a>
		                    </li>
		                    <li>
		                    	<a href="https://clients.deltacolo.com/submitticket.php" target="_blank">
		                        	<i class="fa fa-circle"></i> 
		                        	<span>Open Support Ticket</span>
		                        </a>
		                    </li>
		                    <li>
		                    	<a href="https://clients.deltacolo.com/supporttickets.php" target="_blank">
		                        	<i class="fa fa-circle"></i> 
		                        	<span>My Support Tickets</span>
		                        </a>
		                    </li>
		                    <li>
		                    	<a href="https://clients.deltacolo.com/index.php?rp=/knowledgebase/1/SlipStreamIPTV-CMS-Panel-Videos-and-Guides" target="_blank">
		                        	<i class="fa fa-circle"></i> 
		                        	<span>Knowledgebase</span>
		                        </a>
		                    </li>
		                    <li>
		                    	<a href="https://clients.deltacolo.com/affiliates.php" target="_blank">
		                        	<i class="fa fa-circle"></i> 
		                        	<span>Affiliate Program</span>
		                        </a>
		                    </li>
		                </ul>
		            </li>

                    <?php if(get('c') == 'global_settings' || get('c') == 'licensing' || get('c') == 'my_account' || get('c') == 'release_notes' || get('c') == 'backup_manager'){ ?>
                    	<li class="active treeview menu-open">
                    <?php }else{ ?>
                    	<li class="treeview">
                    <?php } ?>
						<a href="#">
							<i class="fa fa-cogs"></i> <span>CMS Management</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<!-- <li class="active"><a href="index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li> -->
							<?php if(get('c') == 'global_settings'){ ?>
		                    	<li class="active">
		                    <?php }else{ ?>
		                    	<li>
		                    <?php } ?>
		                    	<a href="dashboard.php?c=global_settings">
		                        	<i class="fa fa-cogs"></i> 
		                        	<span>Global Settings</span>
		                        </a>
		                    </li>

		                    <?php if(get('c') == 'licensing'){ ?>
		                    	<li class="active">
		                    <?php }else{ ?>
		                    	<li>
		                    <?php } ?>
		                    	<a href="dashboard.php?c=licensing">
		                        	<i class="fa fa-scroll"></i> 
		                        	<span>Licenses</span>
		                        </a>
		                    </li>

		                    <?php if(get('c') == 'backup_manager'){ ?>
		                    	<li class="active">
		                    <?php }else{ ?>
		                    	<li>
		                    <?php } ?>
		                    	<a href="dashboard.php?c=backup_manager">
		                        	<i class="fa fa-database"></i> 
		                        	<span>Backup &amp; Restore</span>
		                        </a>
		                    </li>

		                    <?php if(get('c') == 'my_account'){ ?>
		                    	<li class="active">
		                    <?php }else{ ?>
		                    	<li>
		                    <?php } ?>
		                    	<a href="dashboard.php?c=my_account">
		                        	<i class="fa fa-user"></i> 
		                        	<span>My Account</span>
		                        </a>
		                    </li>

		                    <?php if(get('c') == 'release_notes'){ ?>
		                    	<li class="active">
		                    <?php }else{ ?>
		                    	<li>
		                    <?php } ?>
		                    	<a href="dashboard.php?c=release_notes">
		                        	<i class="fa fa-sticky-note"></i> 
		                        	<span>Release Notes</span>
		                        </a>
		                    </li>
						</ul>
					</li>

					<?php if(get('c') == 'current_connections' || get('c') == 'servers' || get('c') == 'server' || get('c') == 'transcoding_profiles' || get('c') == 'transcoding_profile'){ ?>
                    	<li class="active treeview menu-open">
                    <?php }else{ ?>
                    	<li class="treeview">
                    <?php } ?>
						<a href="#">
							<i class="fa fa-server"></i> <span>Server Management</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
		                    <?php if(get('c') == 'servers' || get('c') == 'server'){ ?>
		                    	<li id="menu_servers" class="active">
		                    <?php }else{ ?>
		                    	<li id="menu_servers">
		                    <?php } ?>
		                    	<a href="dashboard.php?c=servers">
		                        	<i class="fa fa-server"></i> 
		                        	<span>Servers</span>
		                        	<span class="pull-right-container">
		                        		<small class="label pull-right bg-green"><?php echo $globals['servers']['total']; ?></small>
					            	</span>
		                        </a>
		                    </li>

		                    <?php if(get('c') == 'transcoding_profiles' || get('c') == 'transcoding_profile'){ ?>
		                    	<li class="active">
		                    <?php }else{ ?>
		                    	<li>
		                    <?php } ?>
		                    	<a href="dashboard.php?c=transcoding_profiles">
		                        	<i class="fa fa-file-video"></i> 
		                        	<span>Transcoding Profiles</span>
		                        </a>
		                    </li>

		                    <?php if(get('c') == 'current_connections'){ ?>
			                    	<li class="active">
			                    <?php }else{ ?>
			                    	<li>
			                    <?php } ?>
			                    	<a href="dashboard.php?c=current_connections">
			                        	<i class="fa fa-network-wired"></i> 
			                        	<span>Connection Log</span>
			                        	<!--
			                        	<span class="pull-right-container">
						              		<small class="label pull-right bg-green"><?php echo $globals['clients']['total']; ?></small>
						            	</span>
						            	-->
			                        </a>
			                    </li>
		                </ul>
					</li>

	                <?php if($globals['servers']['total'] > 0) { ?>
	                    <?php if(get('c') == 'customers' || get('c') == 'customer' || get('c') == 'mags' || get('c') == 'mag' || get('c') == 'resellers' || get('c') == 'reseller' || get('c') == 'stream_bouquets' || get('c') == 'stream_bouquet' || get('c') == 'packages' || get('c') == 'package'){ ?>
	                    	<li class="active treeview menu-open">
	                    <?php }else{ ?>
	                    	<li class="treeview">
	                    <?php } ?>
							<a href="#">
								<i class="fa fa-users"></i> <span>Customer Management</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">
				                <?php if(get('c') == 'customers' || get('c') == 'customer'){ ?>
			                    	<li class="active">
			                    <?php }else{ ?>
			                    	<li>
			                    <?php } ?>
			                    	<a href="dashboard.php?c=customers">
			                        	<i class="fa fa-users"></i> 
			                        	<span>Customers</span>
			                        	<span class="pull-right-container">
						              		<?php if($globals['customers'] > 0) {?>
			                        			<small class="label pull-right bg-green"><?php echo $globals['customers']; ?></small>
			                        		<?php } ?>
						            	</span>
			                        </a>
			                    </li>

			                    <?php if(get('c') == 'mags' || get('c') == 'mag'){ ?>
			                    	<li class="active">
			                    <?php }else{ ?>
			                    	<li>
			                    <?php } ?>
			                    	<a href="dashboard.php?c=mags">
			                        	<i class="fa fa-th"></i> 
			                        	<span>MAG Devices</span>
			                        	<span class="pull-right-container">
						              		<?php if($globals['mags'] > 0) {?>
			                        			<small class="label pull-right bg-green"><?php echo $globals['mags']; ?></small>
			                        		<?php } ?>
						            	</span>
			                        </a>
			                    </li>

			                    <?php if(get('c') == 'stream_bouquets' || get('c') == 'stream_bouquet'){ ?>
			                    	<li class="active">
			                    <?php }else{ ?>
			                    	<li>
			                    <?php } ?>
			                    	<a href="dashboard.php?c=stream_bouquets">
			                        	<i class="fa fa-book"></i> 
			                        	<span>Bouquets</span>
			                        </a>
			                    </li>

			                    <?php if(get('c') == 'packages' || get('c') == 'package'){ ?>
			                    	<li class="active">
			                    <?php }else{ ?>
			                    	<li>
			                    <?php } ?>
			                    	<a href="dashboard.php?c=packages">
			                        	<i class="fa fa-columns"></i> 
			                        	<span>Packages</span>
			                        </a>
			                    </li>

			                    <?php if(get('c') == 'resellers' || get('c') == 'reseller'){ ?>
			                    	<li class="active">
			                    <?php }else{ ?>
			                    	<li>
			                    <?php } ?>
			                    	<a href="dashboard.php?c=resellers">
			                        	<i class="fa fa-dollar-sign"></i> 
			                        	<span>Resellers</span>
			                        	<span class="pull-right-container">
						              		<small class="label pull-right bg-green"><?php echo $globals['resellers']; ?></small>
						            	</span>
			                        </a>
			                    </li>
							</ul>
						</li>

	                	<?php if(get('c') == 'streams' || get('c') == 'stream' || get('c') == 'stream_categories' || get('c') == 'stream_category' || get('c') == 'epg_sources' || get('c') == 'epg_source'){ ?>
	                    	<li class="active treeview menu-open">
	                    <?php }else{ ?>
	                    	<li class="treeview">
	                    <?php } ?>
							<a href="#">
								<i class="fa fa-tv"></i> <span>Stream Management</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">
								<?php if(get('c') == 'streams' || get('c') == 'stream'){ ?>
			                    	<li class="active">
			                    <?php }else{ ?>
			                    	<li>
			                    <?php } ?>
			                    	<a href="dashboard.php?c=streams">
			                        	<i class="fa fa-tv"></i> 
			                        	<span>Live TV</span>
			                        	<span class="pull-right-container">
						              		<small class="label pull-right bg-green"><?php echo $globals['streams']['total']; ?></small>
						            	</span>
			                        </a>
			                    </li>

			                    <?php if(get('c') == 'stream_categories' || get('c') == 'stream_category'){ ?>
			                    	<li class="active">
			                    <?php }else{ ?>
			                    	<li>
			                    <?php } ?>
			                    	<a href="dashboard.php?c=stream_categories">
			                        	<i class="fa fa-list-alt"></i> 
			                        	<span>Categories</span>
			                        </a>
			                    </li>

			                    <?php if(get('c') == 'epg_sources' || get('c') == 'epg_source'){ ?>
			                    	<li class="active">
			                    <?php }else{ ?>
			                    	<li>
			                    <?php } ?>
			                    	<a href="dashboard.php?c=epg_sources">
			                        	<i class="fa fa-list-ul"></i> 
			                        	<span>EPG Sources</span>
			                        </a>
			                    </li>
							</ul>
						</li>

						<?php if(get('c') == 'channels' || get('c') == 'channel_edit'){ ?>
	                    	<li class="active treeview menu-open">
	                    <?php }else{ ?>
	                    	<li class="treeview">
	                    <?php } ?>
							<a href="#">
								<i class="fa fa-share-alt"></i> <span>Channel Management</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">
			                    <?php if(get('c') == 'channels' || get('c') == 'channel_edit'){ ?>
			                    	<li class="active">
			                    <?php }else{ ?>
			                    	<li>
			                    <?php } ?>
			                    	<a href="dashboard.php?c=channels">
			                        	<i class="fa fa-share-alt"></i> 
			                        	<span>24/7 TV Channels</span>
			                        	<span class="pull-right-container">
						              		<small class="label pull-right bg-green"><?php echo $globals['channels']['total']; ?></small>
						            	</span>
			                        </a>
			                    </li>

			                    <?php if($module['cdn_streams'] == true || $account_details['type'] == 'admin') { ?>
				                    <?php if(get('c') == 'cdn_streams'){ ?>
				                    	<!-- <li class="active"> -->
				                    <?php }else{ ?>
				                    	<!-- <li> -->
				                    <?php } ?>
				                    	<!-- 
				                    	<a href="dashboard.php?c=cdn_streams">
				                        	<i class="fa fa-cloud"></i> 
				                        	<span>Premium Streams</span>
				                        	<span class="pull-right-container">
							              		<small class="label pull-right bg-green"><?php echo $globals['cdn_streams']['total']; ?></small>
							            	</span>
				                        </a>
				                    </li>
				                	-->
				                <?php } ?>

			                    <?php if($account_details['email'] == 'jamie.whittingham@gmail.com') { ?>
			                		<?php if(empty(get('c')) || get('c') == '' || get('c') == 'premium_dns'){ ?>
				                    	<li class="active">
				                    <?php }else{ ?>
				                    	<li>
				                    <?php } ?>
				                    	<a href="dashboard.php?c=premium_dns">
				                        	<i class="fa fa-at"></i> 
				                        	<span>Premium DNS</span>
				                        </a>
				                    </li>
				                <?php } ?>
							</ul>
						</li>

						<?php if(get('c') == 'vod' || get('c') == 'vod_edit' || get('c') == 'vod_categories' || get('c') == 'vod_category'){ ?>
	                    	<li class="active treeview menu-open">
	                    <?php }else{ ?>
	                    	<li class="treeview">
	                    <?php } ?>
							<a href="#">
								<i class="fa fa-film"></i> <span>VoD Management</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">
								<?php if(get('c') == 'vod' || get('c') == 'vod_edit'){ ?>
			                    	<li class="active">
			                    <?php }else{ ?>
			                    	<li>
			                    <?php } ?>
			                    	<a href="dashboard.php?c=vod">
			                        	<i class="fa fa-film"></i> 
			                        	<span>Video on Demand</span>
			                        	<span class="pull-right-container">
						              		<small class="label pull-right bg-green"><?php echo $globals['vod']['total']; ?></small>
						            	</span>
			                        </a>
			                    </li>

			                    <?php if(get('c') == 'vod_categories' || get('c') == 'vod_category'){ ?>
			                    	<li class="active">
			                    <?php }else{ ?>
			                    	<li>
			                    <?php } ?>
			                    	<a href="dashboard.php?c=vod_categories">
			                        	<i class="fa fa-list-alt"></i> 
			                        	<span>Categories</span>
			                        </a>
			                    </li>
							</ul>
						</li>

						<?php if(get('c') == 'tv_series' || get('c') == 'tv_series_edit'){ ?>
	                    	<li class="active treeview menu-open">
	                    <?php }else{ ?>
	                    	<li class="treeview">
	                    <?php } ?>
							<a href="#">
								<i class="fa fa-video"></i> <span>TV Series Management</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">
								<?php if(get('c') == 'tv_series' || get('c') == 'tv_series_edit'){ ?>
			                    	<li class="active">
			                    <?php }else{ ?>
			                    	<li>
			                    <?php } ?>
			                    	<a href="dashboard.php?c=tv_series">
			                        	<i class="fa fa-video"></i> 
			                        	<span>TV Series</span>
			                        	<span class="pull-right-container">
						              		<small class="label pull-right bg-green"><?php echo $globals['tv_series']['total']; ?></small>
						            	</span>
			                        </a>
			                    </li>
							</ul>
						</li>

		                <!-- 
	                    <?php if(get('c') == 'firewall'){ ?>
	                    	<li class="active">
	                    <?php }else{ ?>
	                    	<li>
	                    <?php } ?>
	                    	<a href="dashboard.php?c=security">
	                        	<i class="fa fa-lock"></i> 
	                        	<span>Security</span>
	                        </a>
	                    </li>
	                	-->

	                	<?php if(get('c') == 'stream_icons' || get('c') == 'xc_import' || get('c') == 'roku_devices' || get('c') == 'roku_device' || get('c') == 'remote_playlists' || get('c') == 'remote_playlist' || get('c') == 'playlist_checker'){ ?>
	                    	<li class="active treeview menu-open">
	                    <?php }else{ ?>
	                    	<li class="treeview">
	                    <?php } ?>
							<a href="#">
								<i class="fa fa-plus"></i> <span>Extras</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">
			                    <?php if(get('c') == 'stream_icons'){ ?>
			                    	<li class="active">
			                    <?php }else{ ?>
			                    	<li>
			                    <?php } ?>
			                    	<a href="dashboard.php?c=stream_icons">
			                        	<i class="fa fa-solar-panel"></i> 
			                        	<span>Stream Icons</span>
			                        </a>
			                    </li>

			                    <?php if(get('c') == 'xc_import'){ ?>
			                    	<li class="active">
			                    <?php }else{ ?>
			                    	<li>
			                    <?php } ?>
			                    	<a href="dashboard.php?c=xc_import">
			                        	<i class="fa fa-file-import"></i> 
			                        	<span>Xtream-Codes v1 &amp; v2 Import</span>
			                        </a>
			                    </li>

			                    <?php if(get('c') == 'remote_playlists' || get('c') == 'remote_playlist'){ ?>
			                    	<li class="active">
			                    <?php }else{ ?>
			                    	<li>
			                    <?php } ?>
			                    	<a href="dashboard.php?c=remote_playlists">
			                        	<i class="fa fa-ethernet"></i> 
			                        	<span>Source Playlist Manager</span>
			                        </a>
			                    </li>

			                    <?php if(get('c') == 'playlist_checker'){ ?>
			                    	<li class="active">
			                    <?php }else{ ?>
			                    	<li>
			                    <?php } ?>
			                    	<a href="dashboard.php?c=playlist_checker">
			                        	<i class="fa fa-list"></i> 
			                        	<span>Playlist Checker</span>
			                        </a>
			                    </li>

			                    <?php if(get('c') == 'roku_devices' || get('c') == 'roku_device'){ ?>
			                    	<li class="active">
			                    <?php }else{ ?>
			                    	<li>
			                    <?php } ?>
			                    	<a href="dashboard.php?c=roku_devices">
			                        	<i class="fa fa-poll-h"></i> 
			                        	<span>Roku Devices</span>
			                        	<span class="pull-right-container">
			                        		<small class="label pull-right bg-red">BETA</small>
			                        	</span>
			                        </a>
			                    </li>
							</ul>
						</li>
	                <?php } ?>

                    <li>
                    	<a href="logout.php">
                        	<i class="fa fa-times"></i> 
                        	<span>Log Out</span>
                        </a>
                    </li>
                </ul>
            </section>

            <div class="user-panel">
            	
			</div>
        </aside>
		
        <?php
			$c = $_GET['c'];
			switch ($c){
				// my_account
				case "my_account":
					my_account();
					break;

				// global_settings
				case "global_settings":
					global_settings();
					break;

				// transcoding_profiles
				case "transcoding_profiles":
					transcoding_profiles();
					break;

				// transcoding_profile
				case "transcoding_profile":
					transcoding_profile();
					break;

				// customers
				case "customers":
					customers();
					break;

				// customer
				case "customer":
					customer();
					break;

				// servers
				case "servers":
					servers();
					break;

				// server
				case "server":
					server();
					break;

				// streams_dev
				case "streams_dev":
					streams_dev();
					break;

				// streams
				case "streams":
					streams();
					break;

				// stream
				case "stream":
					stream();
					break;

				// cdn_streams
				case "cdn_streams":
					cdn_streams();
					break;

				// stream_categories
				case "stream_categories":
					stream_categories();
					break;

				// stream_category
				case "stream_category":
					stream_category();
					break;

				// current_connections
				case "current_connections":
					current_connections();
					break;

				// security
				case "security":
					security();
					break;

				// staging
				case "staging":
				if($_SERVER['REMOTE_ADDR'] == '86.4.171.7'){
					staging();
				}else{
					home();
				}
					break;

				// downloads
				case "downloads":
					downloads();
					break;

				// stream_icons
				case "stream_icons":
					stream_icons();
					break;

				// channels
				case "channels":
					channels();
					break;

				case "channel_edit":
					channel_edit();
					break;

				case "tv_series":
					tv_series();
					break;

				case "tv_series_edit":
					tv_series_edit();
					break;

				// vod
				case "vod":
					vod();
					break;

				case "vod_edit":
					vod_edit();
					break;

				// vod_categories
				case "vod_categories":
					vod_categories();
					break;

				// vod_category
				case "vod_category":
					vod_category();
					break;

				// premium_dns
				case "premium_dns":
					premium_dns();
					break;

				// remote_playlists
				case "remote_playlists":
					remote_playlists();
					break;
				
				// remote_playlist
				case "remote_playlist":
					remote_playlist();
					break;

				// roku management
				case "roku_devices":
					roku_devices();
					break;

				case "roku_device":
					roku_device();
					break;

				// playlist checker
				case "playlist_checker":
					playlist_checker();
					break;

				case "playlist_checker_results":
					playlist_checker_results();
					break;

				case "resellers":
					resellers();
					break;

				case "reseller":
					reseller();
					break;

				case "xc_import":
					xc_import();
					break;

				case "stream_bouquets":
					stream_bouquets();
					break;

				case "stream_bouquet":
					stream_bouquet();
					break;

                case "licensing":
                    licensing();
                    break;

                case "release_notes":
                    release_notes();
                    break;

                case "mags":
                    mags();
                    break;
				
				case "mag":
                    mag();
                    break;

                // backup_manager
                case "backup_manager":
                    backup_manager();
                    break;

				// packages
				case "packages":
					packages();
					break;

				case "package":
					package();
					break;

				case "epg_sources":
					epg_sources();
					break;

				// home
				default:
					home();
					break;
			}
		?>
        
        <?php function home(){ ?>
        	<?php 
        		global $conn, $globals, $global_settings, $account_details, $site;

        		sanity_check();
        	?>

            <div class="content-wrapper">
				
                <div id="status_message"></div>
                            	
                <section class="content-header">
                    <h1>Dashboard <!-- <small>Optional description</small> --></h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="dashboard.php">Dashboard</a></li>
                        <!-- <li class="active">Here</li> -->
                    </ol>
                </section>

                <!-- Main content -->
				<section class="content">
					<?php if($globals['servers']['total'] > 0) { ?>
						<div class="row">
							<div class="col-lg-2 col-xs-6">
								<div class="small-box bg-green">
									<div class="inner">
										<h3><?php echo $globals['servers']['total']; ?></h3>
										<p>Servers</p>
									</div>
									<div class="icon">
										<i class="fa fa-server"></i>
									</div>
									<a href="?c=servers" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
								</div>
							</div>

							<div class="col-lg-2 col-xs-6">
								<div class="small-box bg-blue">
									<div class="inner">
										<h3><?php echo $globals['streams']['total']; ?></h3>
										<p>Streams</p>
									</div>
									<div class="icon">
										<i class="fa fa-tv"></i>
									</div>
									<a href="?c=streams" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
								</div>
							</div>

							<!-- 
							<div class="col-lg-2 col-xs-6">
								<div class="small-box bg-teal">
									<div class="inner">
										<h3><?php echo $globals['cdn_streams']['total']; ?></h3>
										<p>Premium Streams</p>
									</div>
									<div class="icon">
										<i class="fa fa-cloud"></i>
									</div>
									<a href="?c=cdn_streams" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
								</div>
							</div>
							-->

							<div class="col-lg-2 col-xs-6">
								<div class="small-box bg-maroon">
									<div class="inner">
										<h3>
											<?php echo $globals['servers']['total_bandwidth']['bandwidth_down']; ?> <i class="fas fa-download fa-xs"></i> / <?php echo $globals['servers']['total_bandwidth']['bandwidth_up']; ?> <i class="fas fa-upload fa-xs"></i>
										</h3>
										<p>Total Bandwidth (Mbit)</p>
									</div>
									<div class="icon">
										<i class="fa fa-download"></i>
									</div>
									<a href="?c=servers" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
								</div>
							</div>

							<div class="col-lg-2 col-xs-6">
								<div class="small-box bg-light-blue">
									<div class="inner">
										<h3><?php echo $globals['clients']['total']; ?></h3>
										<p>Current Connections</p>
									</div>
									<div class="icon">
										<i class="fa fa-network-wired"></i>
									</div>
									<a href="?c=current_connections" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
								</div>
							</div>

							<div class="col-lg-2 col-xs-6">
								<div class="small-box bg-yellow">
									<div class="inner">
										<h3><?php echo $globals['customers']; ?></h3>
										<p>Customers</p>
									</div>
									<div class="icon">
										<i class="fa fa-users"></i>
									</div>
									<a href="?c=customers" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
								</div>
							</div>

							<div class="col-lg-2 col-xs-6">
								<div class="small-box bg-teal">
									<div class="inner">
										<h3><?php echo $globals['resellers']; ?></h3>
										<p>Resellers</p>
									</div>
									<div class="icon">
										<i class="fa fa-dollar-sign"></i>
									</div>
									<a href="?c=resellers" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
								</div>
							</div>
	          			</div>

						<div class="row">
							<div class="col-lg-9 col-xs-12">
								<div class="box box-primary no-padding">
									<div class="box-header with-border">
										<h3 class="box-title">
											Server Locations 
											<a href="#" data-toggle="modal" data-target="#help_dashboard_map">
												<i class="fas fa-question-circle"></i>
											</a>
										</h3> 
										<small>(estimated)</small>
									</div>
									<div class="box-body">
						                <!-- Map will be created here -->
						                <div id="world-map-markers" style="height: 500px;"></div>
									</div>
								</div>
							</div>

							<div class="col-lg-3 col-xs-12">
								<div class="box box-primary">
									<div class="box-header with-border">
										<h3 class="box-title">Servers Overview</h3>
									</div>
									<div class="box-body">
										<?php if($globals['servers']['offline'] > 0) { ?>
											<table class="table table-bordered table-striped">
												<thead>
													<tr>
														<th>Server</th>													<!-- 0 -->
														<th>Status</th>													<!-- 1 -->
													</tr>
												</thead>
												<tbody>
													<?php
														$query = $conn->query("SELECT * FROM `headend_servers` WHERE `user_id` = '".$_SESSION['account']['id']."' AND `status` = 'offline' ORDER BY `name` ASC");
														$headends = $query->fetchAll(PDO::FETCH_ASSOC);
														foreach($headends as $headend) {
															echo '
																<tr>
																	<td>
																		'.stripslashes($headend['name']).'
																	</td>
																	<td>
																		Offline
																	</td>
																<tr>
															';
														}
													?>
												</tbody>
											</table>
										<?php }else{ ?>
											<div class="callout callout-ok">
												<p class="lead"><i class="icon fa fa-check text-green"></i> 
													Hooray! All servers are healthy.
												</p>
											</div>
										<?php } ?>					
									</div>
								</div>
							</div>
						</div>
					<?php }else{ ?>
						<div class="callout callout-warning">
							To get started, go to <a href="dashboard.php?c=servers">Servers</a> and add your first server.
						</div>
					<?php } ?>
				</section>
            </div>
        <?php } ?>
        
        <?php function my_account(){ ?>
        	<?php 
        		global $conn, $wp, $global_settings, $account_details, $site, $whmcs, $product_ids;
            
            	sanity_check();
            ?>

            <div class="content-wrapper">
				
                <div id="status_message"></div>
                            	
                <section class="content-header">
                    <h1>My Account <!-- <small>Optional description</small> --></h1>
                    <ol class="breadcrumb">
                        <li><a href="dashboard.php">Dashboard</a></li>
                        <li class="active">My Account</li>
                    </ol>
                </section>

                <section class="content">
                	<div class="row">
						<div class="col-lg-6">
							<div class="box box-primary">
		            			<div class="box-header">
		              				<h3 class="box-title">
		              					Profile Details
		              				</h3>
		            			</div>
								<div class="box-body">
									<form action="actions.php?a=my_account_update" method="post" class="form-horizontal">
	                                    <div class="form-group">
	                                        <label for="firstname" class="col-sm-3 control-label">First name</label>
	                                        <div class="col-sm-9">
	                                            <input type="text" name="firstname" id="firstname" class="form-control" value="<?php echo $account_details['first_name']; ?>">
	                                        </div>
	                                    </div>
	                                    
	                                    <div class="form-group">
	                                        <label for="lastname" class="col-sm-3 control-label">Last name</label>
	                                        <div class="col-sm-9">
	                                            <input type="text" name="lastname" id="lastname" class="form-control" value="<?php echo $account_details['last_name']; ?>">
	                                        </div>
	                                    </div>
	                                    	                                    
	                                    <div class="form-group">
	                                        <label for="email" class="col-sm-3 control-label">Email</label>
	                                        <div class="col-sm-9">
	                                            <input type="text" name="email" id="email" class="form-control" value="<?php echo $account_details['email']; ?>">
	                                        </div>
	                                    </div>

	                                    <hr>

	                                    <div class="form-group">
	                                        <label for="email" class="col-sm-3 control-label">Username</label>
	                                        <div class="col-sm-9">
	                                            <input type="text" name="username" id="username" class="form-control" value="<?php echo $account_details['username']; ?>">
	                                        </div>
	                                    </div>

	                                    <div class="form-group">
	                                        <label for="email" class="col-sm-3 control-label">Password</label>
	                                        <div class="col-sm-9">
	                                            <input type="password" name="password" id="password" class="form-control">
	                                            <small>Leave blank to keep the same password.</small>
	                                        </div>
	                                    </div>

	                                    <div class="form-group">
	                                        <label for="email" class="col-sm-3 control-label">Confirm Password</label>
	                                        <div class="col-sm-9">
	                                            <input type="password" name="password2" id="password2" class="form-control">
	                                            <small>Leave blank to keep the same password.</small>
	                                        </div>
	                                    </div>
	                                    
	                                    <div class="form-group">
	                                        <div class="col-sm-12">
	                                            <button type="submit" class="btn btn-success pull-right">Save Changes</button>
	                                        </div>
	                                    </div>
	                                </form>
	                            </div>
	                        </div>
	                    </div>

	                    <div class="col-lg-6">
							<div class="box box-primary">
		            			<div class="box-header">
		              				<h3 class="box-title">
		              					Reset Account Sections
		              				</h3>
		            			</div>
								<div class="box-body">
									<table class="table table-striped mb-none">
										<thead>
											<tr>
												<th class="text-center">Entire Account</th>
												<th class="text-center">Packages</th>
												<th class="text-center">Bouquets</th>
												<th class="text-center">Streams</th>
												<th class="text-center">Customers</th>
												<th class="text-center">MAG Devices</th>
												<th class="text-center">Resellers</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>
													<center>
														<a title="Reset Account" class="btn btn-danger btn-flat btn-xl" onclick="return confirm('This action cannot be reversed. Are you sure?')" href="actions.php?a=reset_account&type=account">
															<i class="fa fa-exclamation-circle"> Go</i>
														</a>
													</center>
												</td>
												<td>
													<center>
														<a title="Reset Account" class="btn btn-danger btn-flat btn-xl" onclick="return confirm('This action cannot be reversed. Are you sure?')" href="actions.php?a=reset_account&type=packages">
															<i class="fa fa-exclamation-circle"> Go</i>
														</a>
													</center>
												</td>
												<td>
													<center>
														<a title="Reset Account" class="btn btn-danger btn-flat btn-xl" onclick="return confirm('This action cannot be reversed. Are you sure?')" href="actions.php?a=reset_account&type=bouquets">
															<i class="fa fa-exclamation-circle"> Go</i>
														</a>
													</center>
												</td>
												<td>
													<center>
														<a title="Reset Account" class="btn btn-danger btn-flat btn-xl" onclick="return confirm('This action cannot be reversed. Are you sure?')" href="actions.php?a=reset_account&type=streams">
															<i class="fa fa-exclamation-circle"> Go</i>
														</a>
													</center>
												</td>
												<td>
													<center>
														<a title="Reset Account" class="btn btn-danger btn-flat btn-xl" onclick="return confirm('This action cannot be reversed. Are you sure?')" href="actions.php?a=reset_account&type=customers">
															<i class="fa fa-exclamation-circle"> Go</i>
														</a>
													</center>
												</td>
												<td>
													<center>
														<a title="Reset Account" class="btn btn-danger btn-flat btn-xl" onclick="return confirm('This action cannot be reversed. Are you sure?')" href="actions.php?a=reset_account&type=resellers">
															<i class="fa fa-exclamation-circle"> Go</i>
														</a>
													</center>
												</td>
												<td>
													<center>
														<a title="Reset Account" class="btn btn-danger btn-flat btn-xl" onclick="return confirm('This action cannot be reversed. Are you sure?')" href="actions.php?a=reset_account&type=mag_devices">
															<i class="fa fa-exclamation-circle"> Go</i>
														</a>
													</center>
												</td>
											</tr>
										</tbody>
									</table>
	                            </div>
	                        </div>
	                    </div>
	                </div>
                </section>
            </div>
        <?php } ?>

       	<?php function global_settings(){ ?>
        	<?php 
        		global $conn, $wp, $global_settings, $account_details, $site, $whmcs, $product_ids;
            
            	sanity_check();
            ?>

            <div class="content-wrapper">
				
                <div id="status_message"></div>
                            	
                <section class="content-header">
                    <h1>Global Settings <!-- <small>Optional description</small> --></h1>
                    <ol class="breadcrumb">
                        <li><a href="dashboard.php">Dashboard</a></li>
                        <li class="active">Global Settings</li>
                    </ol>
                </section>
    
                <section class="content">
                	<div class="row">
						<div class="col-lg-12">
							<div class="box box-primary">
		            			<div class="box-header">
		              				<h3 class="box-title">
		              					Global Settings
		              				</h3>
		            			</div>
								<div class="box-body">
									<form action="actions.php?a=global_settings" method="post" class="form-horizontal">
	                                    <div class="form-group">
	                                        <label for="firstname" class="col-sm-2 control-label">CMS Brand Name</label>
	                                        <div class="col-sm-10">
	                                            <input type="text" name="cms_name" id="cms_name" class="form-control" value="<?php echo $global_settings['cms_name']; ?>">
	                                            <small>This will change the display name that you, your resellers and customers will see.</small>
	                                        </div>
	                                    </div>

	                                    <div class="form-group">
	                                        <label for="firstname" class="col-sm-2 control-label">CMS Domain Name</label>
                  							<div class="col-sm-10">
	                                            <input type="text" name="cms_domain_name" id="cms_domain_name" class="form-control" value="<?php echo $global_settings['cms_domain_name']; ?>">
	                                            <small>The will change the customer lines so that a domain name is used instead of displaying your main server IP address.</small>
	                                        </div>
	                                    </div>
	                                    
	                                    <div class="form-group">
	                                        <label for="firstname" class="col-sm-2 control-label">CMS Main IP</label>
	                                        <div class="col-sm-10">
	                                            <input type="text" name="cms_ip" id="cms_ip" class="form-control" value="<?php echo $global_settings['cms_ip']; ?>" required >
	                                            <small>This should only be changed if you are moving your main server to a new IP address.</small>
	                                        </div>
	                                    </div>

	                                    <div class="form-group">
	                                        <label for="firstname" class="col-sm-2 control-label">CMS Port Number</label>
	                                        <div class="col-sm-10">
	                                            <input type="text" name="cms_port" id="cms_port" class="form-control" value="<?php echo $global_settings['cms_port']; ?>" readonly>
	                                            <small>This is also your default streaming port that customers connect to.</small>
	                                        </div>
	                                    </div>

	                                    <div class="form-group">
	                                        <label for="firstname" class="col-sm-2 control-label">Security Token</label>
	                                        <div class="col-sm-10">
	                                            <input type="text" name="master_token" id="master_token" class="form-control" value="<?php echo $global_settings['master_token']; ?>">
	                                            <small>This is used to secure your streams from outsite attack, it should be updated often. This token can be any alpha-numeric string without special chars or spaces. Leave blank to have the CMS generate one at random for you.</small>
	                                        </div>
	                                    </div>
	                                    
	                                    <div class="form-group">
	                                        <div class="col-sm-12">
	                                            <button type="submit" class="btn btn-success pull-right">Save Changes</button>
	                                        </div>
	                                    </div>
	                                </form>
	                            </div>
	                        </div>
	                    </div>
	                </div>
                </section>
            </div>
        <?php } ?>

        <?php function customers(){ ?>
        	<?php 
        		global $conn, $wp, $global_settings, $account_details, $site, $whmcs, $product_ids;
            
            	sanity_check();

        		$query = $conn->query("SELECT `id`,`name` FROM `bouquets` WHERE `user_id` = '".$_SESSION['account']['id']."' ORDER BY `name` ");
				$bouquets = $query->fetchAll(PDO::FETCH_ASSOC);

				$query = $conn->query("SELECT `id`,`name` FROM `packages` ORDER BY `name` ");
				$packages = $query->fetchAll(PDO::FETCH_ASSOC);
			?>

			<style>
				td.details-control {
				    background: url('img/details_open.png') no-repeat center center;
				    cursor: pointer;
				}
				tr.shown td.details-control {
				    background: url('img/details_close.png') no-repeat center center;
				}
			</style>

            <div class="content-wrapper">
				
                <div id="status_message"></div>   
                            	
                <section class="content-header">
                    <h1>Customers <!-- <small>Optional description</small> --></h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="dashboard.php">Dashboard</a></li>
                        <li class="active">Customers</li>
                    </ol>
                </section>

                <!-- Main content -->
				<section class="content">
					<!-- customer line -->
					<div class="modal fade" id="customer_line" role="dialog">
					    <div class="modal-dialog modal-lg">
					        <div class="modal-content">
					            <div class="modal-header">
					                <button type="button" class="close" data-dismiss="modal">&times;</button>
					                <h4 class="modal-title">Customer Line / Playlist Download</h4>
					            </div>
					            <div class="modal-body">
					                <div class="row">
								    	<div class="col-lg-12">
								    		<iframe id="customer_line_iframe" src="" width="100%" height="150px" frameborder="0"></iframe>
										</div>
									</div>
					            </div>
					            <div class="modal-footer">
					                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					            </div>
					        </div>
					    </div>
					</div>

					<!-- customer_add -->
					<form action="actions.php?a=customer_add" class="form-horizontal form-bordered" method="post">
						<div class="modal fade" id="new_customer_modal" role="dialog">
						    <div class="modal-dialog">
						        <div class="modal-content">
						            <div class="modal-header">
						                <button type="button" class="close" data-dismiss="modal">&times;</button>
						                <h4 class="modal-title">Add New Customer</h4>
						            </div>
						            <div class="modal-body">
						                <div class="row">
									    	<div class="col-lg-12">
											    <div class="form-group">
													<label class="col-md-2 control-label" for="first_name">Name</label>
													<div class="col-md-5">
														<input type="text" class="form-control" id="first_name" name="first_name" placeholder="Joe">
													</div>
													<div class="col-md-5">
														<input type="text" class="form-control" id="last_name" name="last_name" placeholder="Bloggs">
													</div>
												</div>

												<div class="form-group">
													<label class="col-md-2 control-label" for="email">Email</label>
													<div class="col-md-10">
														<input type="text" class="form-control" id="email" name="email" value="" placeholder="joe.bloggs@gmail.com">
													</div>
												</div>
											</div>
										</div>
						            </div>
						            <div class="modal-footer">
						                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						                <button type="submit" class="btn btn-success">Add Customer</button>
						            </div>
						        </div>
						    </div>
						</div>
					</form>

					<!-- customer multi update -->
					<form id="customer_update_multi" action="actions.php?a=customer_multi_options" method="post">
						<div class="row">
							<div id="multi_options_show" class="col-md-4 hidden">
								<div class="box box-default">
									<div class="box-header with-border">
										<h3 class="box-title">
											Multi Customer Options / Update
										</h3>

										<div class="box-tools pull-right">
											<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
											</button>
										</div>
									</div>
									<div class="box-body">
										<div class="row">
											<div class="col-lg-12">
												<div class="form-group">
													<label class="col-sm-3 control-label">Action</label>
													<div class="col-sm-9">
														<select id="multi_options_action" name="multi_options_action" class="form-control" onchange="multi_options_select_customer(this.value);">
															<optgroup label="Enable / Disable">
																<option value="enable">Enabled Selected Customers</option>
																<option value="disable">Disable Selected Customers</option>
															</optgroup>
															<optgroup label="Delete">
																<option value="delete">Delete Selected Customers</option>
															</optgroup>
															<optgroup label="Modify">
																<option value="change_package">Assign New Package</option>
																<option value="change_expire_date">Change Expire Date</option>
															</optgroup>
														</select>
													</div>
												</div>
											</div>
										</div>

										<div class="row hidden" id="multi_options_change_package">
											<hr>
											<div class="col-lg-12">
												<div class="form-group">
													<label class="col-sm-3 control-label">New Package</label>
													<div class="col-sm-9">
														<select id="package_id" name="package_id" class="form-control">
															<?php
																foreach($packages as $package) {
																	echo '<option value="'.$package['id'].'">'.stripslashes($package['name']).'</option>';
																}
															?>
														</select>
														<small>This will override any existing bouquets assigned to this customer.</small>
													</div>
												</div>
											</div>
										</div>
										<div class="row hidden" id="multi_options_change_expire_date">
											<hr>
											<div class="col-lg-12">
												<div class="form-group">
													<label class="col-sm-3 control-label">New Expire Date</label>
													<div class="col-sm-9">
														<div class="col-md-9">
															<input type="date" class="form-control pull-right datepicker" id="expire_date" name="expire_date">
														</div>
														<small>This will override the existing expiration date assigned to this customer.</small>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="box-footer">
										<button type="submit" class="btn btn-success pull-right">Go</button>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-12">
								<div class="box box-primary">
			            			<div class="box-header">
			              				<h3 class="box-title">
			              					Customers
			              				</h3>
			              				<div class="pull-right">
			              					<button type="button" class="btn btn-success btn-xs btn-flat" data-toggle="modal" data-target="#new_customer_modal">Add Customer</button>
										</div>
			            			</div>
									<div class="box-body">
										<table id="example" class="display" style="width:100%">
									        <thead>
									            <tr>
									                <th class="no-sort" width="1px">
									                	<input type="checkbox" id="checkAll" />
									                </th>
									                <th class="no-sort" width="1px">Expand</th>
									                <th class="no-sort" width="1px">ID</th>
									                <th style="white-space: nowrap;" width="1px">Status</th>
									                <th style="white-space: nowrap;" width="100px">Username</th>
									                <th class="no-sort" style="white-space: nowrap;" width="100px">Expires</th>
									                <th class="no-sort" style="white-space: nowrap;" width="1px">Connections</th>
									                <th class="no-sort" style="white-space: nowrap;" width="100px">Owner</th>
									                <th class="no-sort" style="white-space: nowrap;" width="50px">Actions</th>
									            </tr>
									        </thead>
									        <tfoot>
									            <tr>
									                <th class="no-sort" width="1px">
									                	<input type="checkbox" id="checkAll" />
									                </th>
									                <th class="no-sort" width="1px">Expand</th>
									                <th class="no-sort" width="1px">ID</th>
									                <th style="white-space: nowrap;" width="1px">Status</th>
									                <th style="white-space: nowrap;" width="100px">Username</th>
									                <th class="no-sort" style="white-space: nowrap;" width="100px">Expires</th>
									                <th class="no-sort" style="white-space: nowrap;" width="1px">Connections</th>
									                <th class="no-sort" style="white-space: nowrap;" width="100px">Owner</th>
									                <th class="no-sort" style="white-space: nowrap;" width="50px">Actions</th>
									            </tr>
									        </tfoot>
									    </table>
									</div>
								</div>
							</div>
						</div>
					</form>
				</section>
            </div>
        <?php } ?>

        <?php function customer(){ ?>
        	<?php 
        		global $conn, $wp, $global_settings, $account_details, $site, $whmcs, $product_ids;
            
            	sanity_check();
            
            	$customer_id 			= get('customer_id');

				$query 					= $conn->query("SELECT * FROM `customers` WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
				$customer 				= $query->fetch(PDO::FETCH_ASSOC);
				$customer_bouquets 		= explode(",", $customer['bouquet']);

				$query 					= $conn->query("SELECT * FROM `packages` ORDER BY `name` ");
				$packages 				= $query->fetchAll(PDO::FETCH_ASSOC);

        		$query 					= $conn->query("SELECT `id`,`name`,`type` FROM `bouquets` WHERE `user_id` = '".$_SESSION['account']['id']."' ORDER BY `type`,`name` ");
				$bouquets 				= $query->fetchAll(PDO::FETCH_ASSOC);

				$query 					= $conn->query("SELECT `mag_id`,`mac` FROM `mag_devices` WHERE `customer_id` = '".$customer_id."' ORDER BY `mac` ");
				$mags 					= $query->fetchAll(PDO::FETCH_ASSOC);

				$query 					= $conn->query("SELECT * FROM `resellers` ORDER BY `username` ");
				$resellers 				= $query->fetchAll(PDO::FETCH_ASSOC);

				$query 					= $conn->query("SELECT * FROM `customers_ips` WHERE `customer_id` = '".$customer_id."' ");
				$customer_ips 			= $query->fetchAll(PDO::FETCH_ASSOC);
			?>

            <div class="content-wrapper">
				
                <div id="status_message"></div>
                            	
                <section class="content-header">
                    <h1>Customer <!-- <small>Optional description</small> --></h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="dashboard.php">Dashboard</a></li>
                        <li class="active"><a href="dashboard.php?c=customers">Customers</a></li>
                        <li class="active">Customer</li>
                    </ol>
                </section>

                <!-- Main content -->
                <?php if($customer['user_id'] != $_SESSION['account']['id']) { ?>
					<section class="content">
						<div class="row">
							<div class="col-lg-12">
								<div class="box box-danger">
			            			<div class="box-header">
			              				<h3 class="box-title">
			              					ERROR
			              				</h3>
			            			</div>
									<div class="box-body">
										<h3>There was an error loading this content.</h3>
										You don't own this customer. This security breach has been reported to our security team.

										<?php if(isset($_GET['dev'])) { ?>
											<hr>
												<?php debug($customer); ?>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</section>
				<?php }else{ ?>

					<form action="actions.php?a=customer_ip_add" class="form-horizontal form-bordered" method="post">
						<input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>">
						<div class="modal fade" id="new_customer_ip_modal" role="dialog">
						    <div class="modal-dialog">
						        <div class="modal-content">
						            <div class="modal-header">
						                <button type="button" class="close" data-dismiss="modal">&times;</button>
						                <h4 class="modal-title">Add New Customer IP Address</h4>
						            </div>
						            <div class="modal-body">
						                <div class="row">
									    	<div class="col-lg-12">
											    <div class="form-group">
													<label class="col-md-2 control-label" for="ip_address">IP Address</label>
													<div class="col-md-10">
														<input type="text" class="form-control" id="ip_address" name="ip_address" placeholder="214.114.5.123">
														<small>This must be the customers public / WAN IP address and not their devices internal / LAN IP address.</small>
													</div>
												</div>
											</div>
										</div>
						            </div>
						            <div class="modal-footer">
						                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						                <button type="submit" class="btn btn-success">Add IP Address</button>
						            </div>
						        </div>
						    </div>
						</div>
					</form>

					<section class="content">
						<div class="row">
							<div class="col-lg-10">
								<div class="box box-primary">
			            			<div class="box-header">
			              				<h3 class="box-title">
			              					Customer > <?php echo stripslashes($customer['username']); ?>
			              				</h3>
			            			</div>
									<div class="box-body">
										<form action="actions.php?a=customer_update" class="form-horizontal form-bordered" method="post">
											<input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>">
											<input type="hidden" name="existing_username" value="<?php echo $customer['username']; ?>">
											<div class="row">
												<div class="col-lg-12">
													<section class="panel">
														<div class="panel-body">
															<?php if(isset($_GET['dev']) && $_GET['dev'] == 'yes') { ?>
																	<?php debug($customer); ?>
																	<?php debug($customer_bouquets); ?>
																	<?php debug($bouquets); ?>
															<?php } ?>

															<div class="form-group">
																<label class="col-md-2 control-label" for="status">Account Status</label>
																<div class="col-md-4">
																	<select id="status" name="status" class="form-control select2">
																		<option <?php if($customer['status']=='enabled'){echo"selected";} ?> value="enabled">Enabled</option>
																		<option <?php if($customer['status']=='disable'){echo"selected";} ?> value="disable">Disabled</option>
																		<option <?php if($customer['status']=='expired'){echo"selected";} ?> value="expired">Expired</option>
																		<option <?php if($customer['status']=='suspended'){echo"selected";} ?> value="suspended">Suspended</option>
																	</select>
																</div>

																<label class="col-md-2 control-label" for="reseller_id">Owner / Reseller</label>
																<div class="col-md-4">
																	<select id="reseller_id" name="reseller_id" class="form-control select2">
																		<option value="0" <?php if($customer['reseller_id']=='0'){echo"selected";} ?>>Main Account</option>
																		<?php if(is_array($resellers) && isset($resellers[0])){ foreach($resellers as $reseller){ ?>
																			<option value="<?php echo $reseller['id']; ?>" <?php if($reseller['id'] == $customer['reseller_id']){ echo 'selected'; } ?>>
																				<?php echo stripslashes($reseller['username'].' | '.$reseller['email'].' | '.$reseller['first_name'].' | '.$reseller['last_name']); ?>
																			</option>
																		<?php } } ?>
																	</select>
																</div>
															</div>

															<!-- name -->
															<div class="form-group">
																<label class="col-md-2 control-label" for="first_name">Name</label>
																<div class="col-md-5">
																	<input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo stripslashes($customer['first_name']); ?>">
																</div>
																<div class="col-md-5">
																	<input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo stripslashes($customer['last_name']); ?>">
																</div>
															</div>

															<!-- email -->
															<div class="form-group">
																<label class="col-md-2 control-label" for="email">Email</label>
																<div class="col-md-10">
																	<input type="text" class="form-control" id="email" name="email" value="<?php echo stripslashes($customer['email']); ?>">
																</div>
															</div>

															<!-- login -->
															<div class="form-group">
																<label class="col-md-2 control-label" for="username">Login</label>
																<div class="col-md-5">
																	<input type="text" class="form-control" id="username" name="username" value="<?php echo stripslashes($customer['username']); ?>" placeholder="username" required>
																</div>
																<div class="col-md-5">
																	<input type="text" class="form-control" id="password" name="password" value="<?php echo stripslashes($customer['password']); ?>" placeholder="password" required>
																</div>
															</div>

															<!-- email -->
															<div class="form-group">
																<label class="col-md-2 control-label" for="max_connections">Connections</label>
																<div class="col-md-4">
																	<input type="text" class="form-control" id="max_connections" name="max_connections" value="<?php echo stripslashes($customer['max_connections']); ?>" required>
																	<small>How many simultaneous connections can this client make.</small>
																</div>

																<label class="col-md-2 control-label" for="expire_date">Expire Date</label>
																<div class="col-md-4">
																	<input type="date" class="form-control pull-right datepicker" id="expire_date" name="expire_date" value="<?php echo stripslashes($customer['expire_date']); ?>">
																	<small>Setting 01-01-1970 = Unlimited / No Expire Date.</small>
																</div>
															</div>

															<div class="form-group">
																<label class="col-md-2 control-label" for="package_id">Set New Package</label>
																<div class="col-md-10">
																	<select id="package_id" name="package_id" class="form-control select2">
																		<option value="0">Select a Package to set Bouquet(s) or manually select bouquets below.</option>
																		<?php foreach($packages as $package){ ?>
																			<option value="<?php echo $package['id']; ?>"><?php echo stripslashes($package['name']); ?></option>
																		<?php } ?>
																	</select>
																</div>
															</div>

															<div class="form-group">
																<label class="col-md-2 control-label" for="bouquets">Current Bouquets</label>
																<div class="col-md-10">
																	<select id="bouquets" name="bouquets[]" class="form-control" multiple="" size="10">
																		<?php if(is_array($bouquets)){ foreach($bouquets as $bouquet){ ?>
																			<option value="<?php echo $bouquet['id']; ?>" <?php if(in_array($bouquet['id'], $customer_bouquets)){ echo 'selected'; } ?>>
																				<?php
																					if($bouquet['type'] == 'live'){
																						$bouquet['type']		= 'Live TV Streams';
																					}
																					if($bouquet['type'] == 'channel'){
																						$bouquet['type']		= '24/7 TV Channels';
																					}
																					if($bouquet['type'] == 'vod'){
																						$bouquet['type']		= 'VoD';
																					}
																					if($bouquet['type'] == 'series'){
																						$bouquet['type']		= 'TV Series';
																					}
																				?>
																				<?php echo stripslashes($bouquet['type'].' | '.$bouquet['name']); ?>
																			</option>
																		<?php } } ?>
																	</select>
																	<small>Use the SHIFT key and left mouse button to select multiple bouquets from the list above.</small>
																</div>
															</div>

															<!-- mag devices -->
															<div class="form-group">
																<label class="col-md-2 control-label" for="max_connections">MAG Devices</label>
																<div class="col-md-4">
																	<?php if(is_array($mags) && isset($mags[0])){ ?>
																		<select id="bouquets" name="bouquets[]" class="form-control" multiple="">
																			<?php foreach($mags as $mag){ ?>
																				<option>
																					<?php echo base64_decode($mag['mac']); ?>
																				</option>
																			<?php } ?>
																		</select>
																	<?php }else{ ?>
																		<input type="text" class="form-control" id="nothing" name="nothing" value="No MAG Devices" disabled>
																	<?php } ?>
																</div>
															</div>

															<div class="form-group">
																<label class="col-md-2 control-label" for="notes">Admin Notes</label>
																<div class="col-md-10">
																	<textarea class="form-control" id="notes" name="notes"><?php echo stripslashes($customer['notes']); ?></textarea>
																</div>
															</div>

															<div class="form-group">
																<label class="col-md-2 control-label" for="reseller_notes">Reseller Notes</label>
																<div class="col-md-10">
																	<textarea class="form-control" id="reseller_notes" name="reseller_notes"><?php echo stripslashes($customer['reseller_notes']); ?></textarea>
																</div>
															</div>
														</div>
													</section>
												</div>
											</div>

											<footer class="panel-footer">
												<a href="dashboard.php?c=customers" class="btn btn-default">Back</a>
												<button type="submit" class="btn btn-success pull-right">Save Changes</button>
											</footer>
										</form>
									</div>
								</div>
							</div>

							<div class="col-lg-2">
								<div class="box box-primary">
			            			<div class="box-header">
			              				<h3 class="box-title">
			              					Customer IPs
			              				</h3>

										<div class="pull-right">
			              					<button type="button" class="btn btn-success btn-xs btn-flat" data-toggle="modal" data-target="#new_customer_ip_modal">Add IP Address</button>
										</div>
									</div>
									<div class="box-body">
										<table id="customer_ips" class="table table-bordered table-striped">
											<thead>
												<tr>
													<th class="no-sort" style="white-space: nowrap;">IP</th>
									                <th class="no-sort" style="white-space: nowrap;" width="1px">Actions</th>
												</tr>
											</thead>
											<tbody>
												<?php
													foreach($customer_ips as $customer_ip) {
														echo '
															<tr>
																<td>
																	'.$customer_ip['ip_address'].'
																</td>
																<td style="vertical-align: middle;">
																	<a title="Delete" class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Are you sure?\')" href="actions.php?a=customer_ip_delete&customer_ip_id='.$customer_ip['id'].'">
																		<i class="fa fa-times"></i>
																	</a>
																</td>
															</tr>
														';
													}
												?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</section>
				<?php } ?>
            </div>
        <?php } ?>

        <?php function mags(){ ?>
        	<?php 
        		global $conn, $wp, $global_settings, $account_details, $site, $whmcs, $product_ids;
            
            	sanity_check();

				$query 		= $conn->query("SELECT `id`,`username`,`first_name`,`last_name`,`email` FROM `customers` WHERE `user_id` = '".$_SESSION['account']['id']."' ORDER BY `username` ");
				$customers 	= $query->fetchAll(PDO::FETCH_ASSOC);

				$query 		= $conn->query("SELECT `mag_id`,`customer_id`,`mac` FROM `mag_devices` ");
				$mags 		= $query->fetchAll(PDO::FETCH_ASSOC);
			?>

			<style>
				td.details-control {
				    background: url('img/details_open.png') no-repeat center center;
				    cursor: pointer;
				}
				tr.shown td.details-control {
				    background: url('img/details_close.png') no-repeat center center;
				}
			</style>

            <div class="content-wrapper">
				
                <div id="status_message"></div>   
                            	
                <section class="content-header">
                    <h1>MAG Devices <!-- <small>Optional description</small> --></h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="dashboard.php">Dashboard</a></li>
                        <li class="active">MAG Devices</li>
                    </ol>
                </section>

                <!-- Main content -->
				<section class="content">
					<div class="row">
						<div class="col-lg-12">
							<div class="box box-primary">
		            			<div class="box-header">
		              				<h3 class="box-title">
		              					MAG Devices
		              				</h3>
		              				<div class="pull-right">
		              					<button type="button" class="btn btn-success btn-xs btn-flat" data-toggle="modal" data-target="#new_mag_modal">Add MAG Device</button>
									</div>
		            			</div>
								<div class="box-body">
									<form action="actions.php?a=mag_add" class="form-horizontal form-bordered" method="post">
										<div class="modal fade" id="new_mag_modal" role="dialog">
										    <div class="modal-dialog">
										        <div class="modal-content">
										            <div class="modal-header">
										                <button type="button" class="close" data-dismiss="modal">&times;</button>
										                <h4 class="modal-title">Add MAG Device</h4>
										            </div>
										            <div class="modal-body">
										                <div class="row">
													    	<div class="col-lg-12">
																<div class="form-group">
																	<label class="col-md-3 control-label" for="customer_id">Customer</label>
																	<div class="col-md-9">
																		<select class="form-control select2" id="customer_id" name="customer_id" style="width: 100%;">
																			<?php if(is_array($customers)){ foreach($customers as $customer){ ?>
																				<option value="<?php echo $customer['id']; ?>"><?php echo stripslashes($customer['username']); ?></option>
																			<?php } } ?>
																		</select>
																	</div>
																</div>

																<div class="form-group">
																	<label class="col-md-3 control-label" for="mac_address">MAC Address</label>
																	<div class="col-md-9">
																		<input type="text" class="form-control" id="mac_address" name="mac_address" placeholder="00:11:22:33:44:55">
																	</div>
																</div>
															</div>
														</div>
										            </div>
										            <div class="modal-footer">
										                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										                <button type="submit" class="btn btn-success">Add MAG Device</button>
										            </div>
										        </div>
										    </div>
										</div>
									</form>

								    <table id="mag_devices" class="table table-bordered table-striped">
										<thead>
											<tr>
												<th class="no-sort" width="1px">ID</th>
								                <th style="white-space: nowrap;" width="200px">Customer</th>
								                <th style="white-space: nowrap;" width="200px"></th>
								                <th style="white-space: nowrap;" width="200px"></th>
								                <th style="white-space: nowrap;">MAC Address</th>
								                <th class="no-sort" style="white-space: nowrap;" width="100px">Actions</th>
											</tr>
										</thead>
										<tbody>
											<?php
												foreach($mags as $mag) {

													$customer = array();

													$customer_key = array_search($mag['customer_id'], array_column($customers, 'id'));

													$customer['username'] 		= $customers[$customer_key]['username'];
													$customer['first_name'] 	= $customers[$customer_key]['first_name'];
													$customer['last_name'] 		= $customers[$customer_key]['last_name'];
													$customer['email'] 			= $customers[$customer_key]['email'];

													echo '
														<tr>
															<td>
																'.$mag['mag_id'].'
															</td>
															<td>
																'.$customer['username'].'
															</td>
															<td>
																'.(!empty($customer['first_name'])?$customer['first_name']:'').' '.(!empty($customer['last_name'])?$customer['last_name']:'').'
															</td>
															<td>
																'.(!empty($customer['email'])?$customer['email']:'').'
															</td>
															<td>
																'.base64_decode($mag['mac']).'
															</td>
															<td style="vertical-align: middle;">
																<a title="View / Edit" class="btn btn-info btn-flat btn-xs" href="dashboard.php?c=mag&mag_id='.$mag['mag_id'].'">
																	<i class="fa fa-eye" aria-hidden="true"></i>
																</a>

																<a title="Delete" class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Are you sure?\')" href="actions.php?a=mag_delete&mag_id='.$mag['mag_id'].'">
																	<i class="fa fa-times"></i>
																</a>
															</td>
														</tr>
													';
												}
											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</section>
            </div>
        <?php } ?>

        <?php function mag(){ ?>
        	<?php 
        		global $conn, $wp, $global_settings, $account_details, $site, $whmcs, $product_ids;
            
            	sanity_check();

            	$query 		= $conn->query("SELECT `id`,`username`,`first_name`,`last_name`,`email` FROM `customers` WHERE `user_id` = '".$_SESSION['account']['id']."' ORDER BY `username` ");
				$customers 	= $query->fetchAll(PDO::FETCH_ASSOC);
            
            	$mag_id = get('mag_id');

        		$query 			= $conn->query("SELECT * FROM `mag_devices` WHERE `mag_id` = '".$mag_id."' LIMIT 1");
				$mag 			= $query->fetch(PDO::FETCH_ASSOC);
				$mag['mac'] 	= base64_decode($mag['mac']);
			?>

            <div class="content-wrapper">
				
                <div id="status_message"></div>
                            	
                <section class="content-header">
                    <h1>MAG Device <!-- <small>Optional description</small> --></h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="dashboard.php">Dashboard</a></li>
                        <li class="active"><a href="dashboard.php?c=mags">MAG Devices</a></li>
                        <li class="active">MAG Device</li>
                    </ol>
                </section>

                <!-- Main content -->
				<section class="content">
					<div class="row">
						<div class="col-lg-12">
							<div class="box box-primary">
		            			<div class="box-header">
		              				<h3 class="box-title">
		              					MAG Device > <?php echo $mag['mac']; ?>
		              				</h3>
		            			</div>
								<div class="box-body">
									<form action="actions.php?a=mag_update" class="form-horizontal form-bordered" method="post">
										<input type="hidden" name="mag_id" value="<?php echo $mag_id; ?>">
										<div class="row">
											<div class="col-lg-12">
												<section class="panel">
													<div class="panel-body">
														<?php if(isset($_GET['dev']) && $_GET['dev'] == 'yes') { ?>
															<pre>
																<?php print_r($mag); ?>
															</pre>
														<?php } ?>

														<div class="form-group">
															<label class="col-md-3 control-label" for="customer_id">Customer</label>
															<div class="col-md-9">
																<select class="form-control select2" id="customer_id" name="customer_id" style="width: 100%;">
																	<?php 
																	if(is_array($customers)){ foreach($customers as $customer){ ?>
																		<option value="<?php echo $customer['id']; ?>" <?php if($customer['id'] == $mag['customer_id']){ echo "selected";} ?>><?php echo stripslashes($customer['username']); ?></option>
																	<?php } } ?>
																</select>
															</div>
														</div>

														<div class="form-group">
															<label class="col-md-3 control-label" for="mac_address">MAC Address</label>
															<div class="col-md-9">
																<input type="text" class="form-control" id="mac_address" name="mac_address" value="<?php echo $mag['mac']; ?>" placeholder="00:11:22:33:44:55">
															</div>
														</div>
													</div>
												</section>
											</div>
										</div>

										<footer class="panel-footer">
											<a href="dashboard.php?c=mags" class="btn btn-default">Back</a>
											<button type="submit" class="btn btn-success pull-right">Save Changes</button>
										</footer>
									</form>
								</div>
							</div>
						</div>
					</div>
				</section>
            </div>
        <?php } ?>

        <?php function resellers(){ ?>
        	<?php 
        		global $conn, $wp, $global_settings, $account_details, $site, $whmcs, $product_ids;
            
            	sanity_check();
            
            	$reseller_modals = '';
            ?>

            <div class="content-wrapper">
				
                <div id="status_message"></div>   
                            	
                <section class="content-header">
                    <h1>Resellers <!-- <small>Optional description</small> --></h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="dashboard.php">Dashboard</a></li>
                        <li class="active">Resellers</li>
                    </ol>
                </section>

                <!-- Main content -->
				<section class="content">
					<div class="row">
						<div class="col-lg-12">
							<div class="box box-primary">
		            			<div class="box-header">
		              				<h3 class="box-title">
		              					Resellers
		              				</h3>
		              				<div class="pull-right">
		              					<button type="button" class="btn btn-success btn-xs btn-flat" data-toggle="modal" data-target="#new_reseller_modal">Add Reseller</button>
									</div>
		            			</div>
								<div class="box-body">
									<form action="actions.php?a=reseller_add" class="form-horizontal form-bordered" method="post">
										<div class="modal fade" id="new_reseller_modal" role="dialog">
										    <div class="modal-dialog">
										        <div class="modal-content">
										            <div class="modal-header">
										                <button type="button" class="close" data-dismiss="modal">&times;</button>
										                <h4 class="modal-title">Add New Reseller</h4>
										            </div>
										            <div class="modal-body">
										                <div class="row">
													    	<div class="col-lg-12">
															    <div class="form-group">
																	<label class="col-md-2 control-label" for="first_name">Name</label>
																	<div class="col-md-5">
																		<input type="text" class="form-control" id="first_name" name="first_name" placeholder="Joe">
																	</div>
																	<div class="col-md-5">
																		<input type="text" class="form-control" id="last_name" name="last_name" placeholder="Bloggs">
																	</div>
																</div>

																<div class="form-group">
																	<label class="col-md-2 control-label" for="email">Email</label>
																	<div class="col-md-10">
																		<input type="text" class="form-control" id="email" name="email" value="" placeholder="joe.bloggs@gmail.com">
																	</div>
																</div>

																<div class="form-group">
																	<label class="col-md-2 control-label" for="email">Login</label>
																	<div class="col-md-5">
																		<input type="text" class="form-control" id="username" name="username" value="username<?php echo rand('11111','99999'); ?>" placeholder="username12345" required="">
																	</div>
																	<div class="col-md-5">
																		<input type="text" class="form-control" id="password" name="password" value="password<?php echo rand('11111','99999'); ?>" placeholder="password12345" required="">
																	</div>
																</div>

																<div class="form-group">
																	<label class="col-md-2 control-label" for="credits">Credits</label>
																	<div class="col-md-4">
																		<input type="text" class="form-control" id="credits" name="credits" value="10" required="">
																	</div>

																	<!-- 
																	<label class="col-md-2 control-label" for="expire_date">Expire Date</label>
																	<div class="col-md-4">
																		<input type="date" class="form-control pull-right datepicker" id="expire_date" name="expire_date">
																	</div>
																	-->
																</div>

																<div class="form-group">
																	<label class="col-md-2 control-label" for="notes">Notes</label>
																	<div class="col-md-10">
																		<textarea class="form-control" id="notes" name="notes"></textarea>
																	</div>
																</div>
															</div>
														</div>
										            </div>
										            <div class="modal-footer">
										                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										                <button type="submit" class="btn btn-success">Add Reseller</button>
										            </div>
										        </div>
										    </div>
										</div>
									</form>

									<table id="resellers" class="table table-bordered table-striped">
										<thead>
											<tr>
												<th class="no-sort" width="10px">Status</th>
												<th width="10px">ID</th>
												<th>Name</th>
												<th>Email</th>
												<th class="no-sort">Username</th>
												<th class="no-sort" width="1px">Credits</th>
												<th class="no-sort" width="75px">Actions</th>
											</tr>
										</thead>
										<tbody>
											<?php

												$time_shift = time() - 10;
												$query = $conn->query("SELECT * FROM `resellers` WHERE `user_id` = '".$_SESSION['account']['id']."' ");
												if($query !== FALSE) {
													$resellers = $query->fetchAll(PDO::FETCH_ASSOC);
													foreach($resellers as $reseller) {

														if($reseller['status'] == 'enabled') {
															$status = '<span class="label label-success full-width" style="width: 100%;">Enabled</span>';
														}elseif($reseller['status'] == 'disabled') {
															$status = '<span class="label label-danger full-width" style="width: 100%;">Disabled</span>';
														}else{
															$status = '<span class="label label-warning full-width" style="width: 100%;">'.ucfirst($reseller['status']).'</span>';
														}

														echo '
															<tr>
																<td>
																	'.$status.'
																</td>
																<td>
																	'.$reseller['id'].'
																</td>
																<td>
																	'.stripslashes($reseller['first_name']).' '.stripslashes($reseller['last_name']).'
																</td>
																<td>
																	'.stripslashes($reseller['email']).'
																</td>
																<td>
																	'.stripslashes($reseller['username']).'
																</td>
																<td>
																	'.number_format($reseller['credits']).'
																</td>
																<td style="vertical-align: middle;">

																	<button title="View / Edit" type="button" class="btn btn-info btn-flat btn-xs" data-toggle="modal" data-target="#reseller_modal_edit_'.$reseller['id'].'">
																			<i class="fa fa-eye" aria-hidden="true"></i>
																	</button>

																	<a title="Delete" class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'This will delete the reseller and all their customers. \nAre you sure?\')" href="actions.php?a=reseller_delete&reseller_id='.$reseller['id'].'">
																		<i class="fa fa-times"></i>
																	</a>
																</td>
															</tr>
														';

														$reseller_modals .= '
															<form action="actions.php?a=reseller_update" class="form-horizontal form-bordered" method="post">
																<input type="hidden" id="reseller_id" name="reseller_id" value="'.$reseller['id'].'">
																<div class="modal fade" id="reseller_modal_edit_'.$reseller['id'].'" role="dialog">
																    <div class="modal-dialog">
																        <div class="modal-content">
																            <div class="modal-header">
																                <button type="button" class="close" data-dismiss="modal">&times;</button>
																                <h4 class="modal-title">Update Reseller</h4>
																            </div>
																            <div class="modal-body">
																                <div class="row">
																			    	<div class="col-lg-12">
																			    		<div class="form-group">
																							<label class="col-md-2 control-label" for="status">Status</label>
																							<div class="col-md-10">
																								<select id="status" name="status" class="form-control">
																									<option value="disable" '.($reseller['status']=='disabled'?'selected':'').'>Disabled</option>
																									<option value="enabled" '.($reseller['status']=='enabled'?'selected':'').'>Enabled</option>
																								</select>
																							</div>
																						</div>
																					    <div class="form-group">
																							<label class="col-md-2 control-label" for="first_name">Name</label>
																							<div class="col-md-5">
																								<input type="text" class="form-control" id="first_name" name="first_name" 
																								value="'.stripslashes($reseller['first_name']).'">
																							</div>
																							<div class="col-md-5">
																								<input type="text" class="form-control" id="last_name" name="last_name" 
																								value="'.stripslashes($reseller['last_name']).'">
																							</div>
																						</div>

																						<div class="form-group">
																							<label class="col-md-2 control-label" for="username">Email</label>
																							<div class="col-md-10">
																								<input type="text" class="form-control" id="email" name="email" 
																								value="'.stripslashes($reseller['email']).'" required="">
																							</div>
																						</div>

																						<div class="form-group">
																							<label class="col-md-2 control-label" for="username">Login</label>
																							<div class="col-md-5">
																								<input type="text" class="form-control" id="username" name="username" 
																								value="'.stripslashes($reseller['username']).'">
																							</div>
																							<div class="col-md-5">
																								<input type="text" class="form-control" id="password" name="password" 
																								value="'.stripslashes($reseller['password']).'" required="">
																							</div>
																						</div>

																						<div class="form-group">
																							<label class="col-md-2 control-label" for="credits">Credits</label>
																							<div class="col-md-4">
																								<input type="text" class="form-control" id="credits" name="credits" value="'.stripslashes($reseller['credits']).'" required="">
																							</div>
																						</div>

																						<div class="form-group">
																							<label class="col-md-2 control-label" for="notes">Notes</label>
																							<div class="col-md-10">
																								<textarea class="form-control" id="notes" name="notes">'.stripslashes($reseller['notes']).'</textarea>
																							</div>
																						</div>
																					</div>
																				</div>
																            </div>
																            <div class="modal-footer">
																                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																                <button type="submit" class="btn btn-success">Save Changes</button>
																            </div>
																        </div>
																    </div>
																</div>
															</form>
														';
													}
												}
											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</section>
            </div>

            <?php echo $reseller_modals; ?>
        <?php } ?>

        <?php function servers(){ ?>
        	<?php 
        		global $conn, $global_settings, $account_details, $site, $config;
        	
        		$server_modals = '';
        	
        		$reinstall_modals = '';
        	?>

            <div class="content-wrapper">
				
                <div id="status_message"></div>   
                            	
                <section class="content-header">
                    <h1>Servers <!-- <small>Optional description</small> --></h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="dashboard.php">Dashboard</a></li>
                        <li class="active">Servers</li>
                    </ol>
                </section>

                <!-- Main content -->
				<section class="content">
					<?php if(total_servers() > $account_details['max_servers']) { ?>
						<div class="row">
							<div class="col-lg-12">
								<div class="box box-danger">
			            			<div class="box-header">
			              				<h3 class="box-title">
			              					ERROR
			              				</h3>
			            			</div>
									<div class="box-body">
										Server cheat, you have too many servers in your account. Contact support ASAP.
									</div>
								</div>
							</div>
						</div>
					<?php }else{ ?>
						<div class="row">
							<div class="col-lg-12">
								<div class="box box-primary">
			            			<div class="box-header">
			              				<h3 class="box-title">
			              					Servers
			              				</h3>
			              				<div class="pull-right">
			              					<?php if(total_servers() >= $account_details['max_servers']) { ?>
							                	<button type="button" class="btn btn-success btn-xs btn-flat" data-toggle="modal" data-target="#upgrade_account_modal">Add New Server</button>
							                <?php }else{ ?>
							                	<button type="button" class="btn btn-success btn-xs btn-flat" data-toggle="modal" data-target="#new_server_modal">Add New Server</button>
							                <?php } ?>
										</div>
			            			</div>
									<div class="box-body">
										<div class="modal fade" id="upgrade_account_modal" role="dialog">
										    <div class="modal-dialog">
										        <div class="modal-content">
										            <div class="modal-header">
										                <button type="button" class="close" data-dismiss="modal">&times;</button>
										                <h4 class="modal-title">Add New Server</h4>
										            </div>
										            <div class="modal-body">
										            	<center>
										            		<img src="assets/images/thumbs_up.png" width="250px" alt="">
										            	</center>
										            	<br><br>
												    	<p>
											    			You are so awesome, you have maxed out all your licenses.
											    		</p>
											    		<p>
											    			To add another server, you need to purchase another license which is quick and easy.
											    		</p>
											    		<p>
											    			<center>
												    			<a href="https://clients.deltacolo.com/cart.php?a=add&pid=62" class="btn btn-success" target="_blank">Lets Upgrade Now</button>
												    		</a>
											    		</p>
										            </div>
										            <div class="modal-footer">
										                <button type="button" class="btn btn-default" data-dismiss="modal">Maybe Later</button>
										            </div>
										        </div>
										    </div>
										</div>

										<div class="modal fade" id="new_server_modal" role="dialog">
										    <div class="modal-dialog">
										        <div class="modal-content">
										            <div class="modal-header">
										                <button type="button" class="close" data-dismiss="modal">&times;</button>
										                <h4 class="modal-title">Add New Server</h4>
										            </div>
										            <div class="modal-body">
										                <div class="row">
													    	<div id="add_server_step_1">
													    		<div class="col-lg-12">
														    		<p>To add a new load balancer, please give it a name and click on 'Add Server'. Please make sure you have enough load balancer licenses to cover this new server. If you add this server and don't yet have a license then the CMS will lock down until you purchase an additional license.</p>
														    	</div>
													    		<div class="col-lg-6">
														    		<p>0-500 Streams</p>
														    		<p>
														    			<strong><u>System Requirements:</u></strong><br>
														    			Intel / AMD CPU Octo Core 2.2Ghz<br>
														    			16 GB RAM <br>
														    			32 GB HDD or SDD <br>
														    			1,000 Mbit Internet Connection <br>
														    			Ubuntu 18.04 LTS Minimal<br>
														    		</p>
														    	</div>
														    	<div class="col-lg-6">
														    		<p>500-2500 Streams</p>
														    		<p>
														    			<strong><u>System Requirements:</u></strong><br>
														    			4 x Intel / AMD CPU Octo Core 2.2Ghz<br>
														    			128 GB RAM <br>
														    			4 x 480 GB HDD or SDD <br>
														    			10,000 Mbit Internet Connection <br>
														    			Ubuntu 18.04 LTS Minimal<br>
														    		</p>
														    	</div>
														    	<div class="col-lg-12">
														    		<p></p>
														    	</div>
															    <div class="form-group">
																	<label class="col-md-4 control-label" for="name">Load Balancer Name</label>
																	<div class="col-md-8">
																		<input type="text" class="form-control" id="add_server_name" name="add_server_name" placeholder="Server Name" required="">
																	</div>
																</div>
															</div>

															<div id="add_server_step_2" class="col-lg-12 hidden">
																<p>Please run the following command as <strong><u>root</u></strong> to install or reinstall SlipStream on your server.</p>
												                <div class="row">
															    	<div class="col-lg-12">
																	    <span id="new_server_results"></span>
																	</div>
																</div>
															</div>
														</div>
										            </div>
										            <div class="modal-footer">
										                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										                <button id="add_server_button" onclick="add_server()" type="button" class="btn btn-success">Add Server</button>
										            </div>
										        </div>
										    </div>
										</div>

										<table id="servers" class="table table-bordered table-striped">
											<thead>
												<tr>
													<th width="10px">Status</th>
													<th>Name</th>
													<th>IP</th>
													<th class="no-sort" width="1px">CPU</th>
													<th class="no-sort" width="1px">RAM</th>
													<th class="no-sort" width="1px">DISK</th>
													<th class="no-sort" width="100px">Bandwidth</th>
													<th class="no-sort" width="80px">Uptime</th>
													<th class="no-sort" width="1px">Streams</th>
													<th class="no-sort" width="100px">Version</th>
													<th class="no-sort" width="140px">Actions</th>
												</tr>
											</thead>
											<tbody>
												<?php
													$query = $conn->query("SELECT * FROM `headend_servers` WHERE `user_id` = '".$_SESSION['account']['id']."' ");
													if($query !== FALSE) {
														$cluster['headends'] = $query->fetchAll(PDO::FETCH_ASSOC);

														foreach($cluster['headends'] as $headend) {
															$query = $conn->query("SELECT `id` FROM `streams` WHERE `server_id` = '".$headend['id']."' AND `stream_type` = 'output' ");
															$headend['streams'] = $query->fetchAll(PDO::FETCH_ASSOC);
															$headend['total_streams'] = count($headend['streams']);

															if($headend['status'] == 'online') {
																$status = '<span class="label label-success full-width" style="width: 100%;">Online</span>';
																
																$headend['version_raw'] = @file_get_contents("http://".$headend['wan_ip_address'].":".$headend['http_stream_port']."/api.php?c=get_version");
																$headend['version_raw'] = json_decode($headend['version_raw'], true);
																$headend['version']		= $headend['version_raw']['version'];

																if(empty($headend['version'])){
																	$headend['version'] = '<font color="red"><strong>UPDATE REQUIRED</strong></font>';
																}elseif($headend['version'] >= $config['version']){
																	$headend['version'] = $headend['version'].' <br>(<font color="green"><strong>Up To Date</strong></font>)';
																}else{
																	$headend['version'] = $headend['version'].' <br>(<font color="red">Update Available</font>)';
																}
															}elseif($headend['status'] == 'offline') {
																$status = '<span class="label label-danger full-width" style="width: 100%;">Offline</span>';
															}elseif($headend['status'] == 'installing') {
																$status = '<span class="label label-info full-width" style="width: 100%;">Installing</span>';
															}else{
																$status = '<span class="label label-warning full-width" style="width: 100%;">'.ucfirst($headend['status']).'</span>';
															}

															$headend['bandwidth_down'] 		= number_format($headend['bandwidth_down'] / 125, 0);
															$headend['bandwidth_up'] 		= number_format($headend['bandwidth_up'] / 125, 0);

															// last seen math
															$last_seen 						= (time() - $headend['updated']);

															echo '
																<tr>
																	<td>
																		'.$status.'
																	</td>
																	<td>
																		'.stripslashes($headend['name']).' <br>
																		'.stripslashes($headend['os_version']).'
																	</td>
																	<td>
																		'.$headend['ip_address'].' 
																		'.(!empty($headend['public_hostname'])?'<br>'.stripslashes($headend['public_hostname']):'').'
																	</td>
																	<td>
																		'.($headend['status'] == 'online'?'
																			'.$headend['cpu_usage'].'%
																		':'').'
																	</td>
																	<td>
																		'.($headend['status'] == 'online'?'
																			'.$headend['ram_usage'].'%
																		':'').'
																	</td>
																	<td>
																		'.($headend['status'] == 'online'?'
																			'.$headend['disk_usage'].'%
																		':'').'
																	</td>
																	<td>
																		'.($headend['status'] == 'online'?'
																			'.$headend['bandwidth_down'].' / '.$headend['bandwidth_up'].' Mbit
																		':'').'
																	</td>
																	<td>
																		'.($headend['status'] == 'online'?
																			uptime($headend['uptime'])
																			:
																			''
																			).'
																	</td>
																	<td>
																		'.($headend['status'] == 'online'?'
																			'.$headend['total_streams'].'
																		':'').'
																	</td>
																	<td>
																		'.($headend['status'] == 'online'?'
																			'.$headend['version'].'
																		':'').'
																	</td>
																	<td style="vertical-align: middle;">
																		<button title="Install / Reinstall" type="button" class="btn btn-warning btn-flat btn-xs" data-toggle="modal" data-target="#reinstall_server_modal_'.$headend['id'].'">
																			<i class="fa fa-desktop" aria-hidden="true"></i>
																		</button>

																		<button title="Reboot" onclick="server_reboot('.$headend['id'].')" class="btn btn-success btn-flat btn-xs" '.($headend['status'] == 'offline'?'disabled':'').'>
																			<i class="fa fa-refresh" aria-hidden="true"></i>
																		</button>

																		<a href="http://'.$headend['ip_address'].':4200" title="Web Console" class="btn btn-primary btn-flat btn-xs" '.($headend['status'] == 'offline'?'disabled':'').' target="_blank">
																			<i class="fa fa-terminal" aria-hidden="true"></i>
																		</a>

																		<button title="Speedtest" type="button" class="btn btn-purple btn-flat btn-xs" '.($headend['status'] == 'offline'?'disabled':'').' data-toggle="modal" data-target="#speedtest_server_modal_'.$headend['id'].'">
																			<i class="fa fa-tachometer-alt" aria-hidden="true"></i>
																		</button>

																		<a title="View" class="btn btn-info btn-flat btn-xs" href="dashboard.php?c=server&server_id='.$headend['id'].'">
																			<i class="fa fa-eye"></i>
																		</a>

																		<a title="Delete" class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Are you sure?\')" href="actions.php?a=server_delete&server_id='.$headend['id'].'">
																			<i class="fa fa-times"></i>
																		</a>
																	</td>
																</tr>
															';

															$reinstall_modals .= '
																<div class="modal fade" id="reinstall_server_modal_'.$headend['id'].'" role="dialog">
																    <div class="modal-dialog">
																        <div class="modal-content">
																            <div class="modal-header">
																                <button type="button" class="close" data-dismiss="modal">&times;</button>
																                <h4 class="modal-title">Reinstall Server</h4>
																            </div>
																            <div class="modal-body">
																            	<p>Please run the following command as <strong><u>root</u></strong> to install or reinstall SlipStream on server "'.$headend['name'].'"</p>
																				<div class="row">
																			    	<div class="col-lg-12">
																					 	Node Server Install:<br>
																					 	<code>bash <(curl -s -L http://slipstreamiptv.com/downloads/install_node.sh)</code>
																					 	<br>
																					 	<br>
																					 	<br>
																					</div>
																					<div class="form-group">
																						<label class="col-md-4 control-label" for="cms_server_address">CMS Server Address:</label>
																						<div class="col-md-8">
																							<input type="text" class="form-control" id="cms_server_address" name="cms_server_address" value="'.$global_settings['cms_access_url_raw'].'" readonly>
																						</div>
																					</div>
																					<div class="form-group">
																						<label class="col-md-4 control-label" for="cms_server_port">CMS Server Port:</label>
																						<div class="col-md-8">
																							<input type="text" class="form-control" id="cms_server_port" name="cms_server_port" value="'.$global_settings['cms_port'].'" readonly>
																						</div>
																					</div>
																					<div class="form-group">
																						<label class="col-md-4 control-label" for="server_uuid">Server UUID:</label>
																						<div class="col-md-8">
																							<input type="text" class="form-control" id="server_uuid" name="server_uuid" value="'.$headend['uuid'].'" readonly>
																						</div>
																					</div>
																				</div>
																            </div>
																            <div class="modal-footer">
																                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																            </div>
																        </div>
																    </div>
																</div>

																<div class="modal fade" id="speedtest_server_modal_'.$headend['id'].'" role="dialog">
																    <div class="modal-dialog modal-lg">
																        <div class="modal-content">
																            <div class="modal-header">
																                <button type="button" class="close" data-dismiss="modal">&times;</button>
																                <h4 class="modal-title">Speedtest</h4>
																            </div>
																            <div class="modal-body">
																            	<p>
																            		This speedtest is between the selected server and your computer.
																            	</p>

																            	<br>

																            	'.($headend['status']=='online'?'<iframe frameBorder="0" class="embed-responsive-item" src="http://'.$headend['wan_ip_address'].':'.$headend['http_stream_port'].'/speedtest/" allowfullscreen style="width: 100%; height: 450px;"></iframe>':'').'
																                
																            </div>
																            <div class="modal-footer">
																                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																            </div>
																        </div>
																    </div>
																</div>
															';
														}
													}
												?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
				</section>
            </div>

            <?php echo $reinstall_modals; ?>
        <?php } ?>

        <?php function server(){ ?>
        	<?php 
        		global $conn, $wp, $global_settings, $account_details, $site, $whmcs, $product_ids;
            
            	sanity_check();
            
            	$server_id	 	= get('server_id');
			
				$query 					= $conn->query("SELECT * FROM `headend_servers` WHERE `id` = '".$server_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
				$headend 				= $query->fetchAll(PDO::FETCH_ASSOC);
				$headend[0]['gpu_stats'] 			= json_decode($headend[0]['gpu_stats'], true);
				$headend[0]['nginx_stats'] 			= json_decode($headend[0]['nginx_stats'], true);
				$headend[0]['astra_config_file'] 	= json_decode($headend[0]['astra_config_file'], true);

				$show_capture_card 		= false;
				$show_dvbc 				= false;
				$show_dvbs 				= false;
				$show_dvbt 				= false;
				
				if(isset($headend[0]['sources']) && is_array($headend[0]['sources'])) {
					foreach($headend[0]['sources'] as $source) {
						if($source['type'] == 'capture_card') {
							$show_capture_card = true;
						}
					}

					foreach($headend[0]['sources'] as $source) {
						if($source['type'] == 'dvb_card' && $source['dvb_type'] == 'dvbc') {
							$show_dvbc = true;
						}
					}

					foreach($headend[0]['sources'] as $source) {
						if($source['type'] == 'dvb_card' && $source['dvb_type'] == 'dvbs' || $source['type'] == 'dvb_card' && $source['dvb_type'] == 'dvbs2') {
							$show_dvbs = true;
						}
					}

					foreach($headend[0]['sources'] as $source) {
						if($source['type'] == 'dvb_card' && $source['dvb_type'] == 'dvbt' || $source['type'] == 'dvb_card' && $source['dvb_type'] == 'dvbt2') {
							$show_dvbt = true;
						}
					}
				}
			?>

            <div class="content-wrapper">
				
                <div id="status_message"></div>
                            	
                <section class="content-header">
                    <h1>Server: <?php echo stripslashes($headend[0]['name']); ?> <!-- <small>Optional description</small> --></h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="dashboard.php">Dashboard</a></li>
                        <li class="active"><a href="dashboard.php?c=servers">Servers</a></li>
                        <li class="active">Server: <?php echo stripslashes($headend[0]['name']); ?></li>
                    </ol>
                </section>

                <!-- Main content -->
                <?php if($headend[0]['user_id'] != $_SESSION['account']['id']) { ?>
					<section class="content">
						<div class="row">
							<div class="col-lg-12">
								<div class="box box-danger">
			            			<div class="box-header">
			              				<h3 class="box-title">
			              					ERROR
			              				</h3>
			            			</div>
									<div class="box-body">
										<h3>There was an error loading this content.</h3>
										You don't own this server. This security breach has been reported to our security team.

										<?php if(get('dev') == 'yes') { ?>
											<pre>
												<?php print_r($headend); ?>
											</pre>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</section>
				<?php }else{ ?>
					<section class="content">
						<div class="row">
							<div class="col-lg-8 no-padding">
								<div class="col-lg-12">
									<section class="panel">
										<header class="panel-heading">
											<div class="panel-actions"></div>
											<h2 class="panel-title">
												Realtime Stats 
												<a href="#" data-toggle="modal" data-target="#help_server_stats">
													<i class="fas fa-question-circle"></i>
												</a>
											</h2>
										</header>
										<div class="panel-body">
											<div class="row">
												<div class="col-lg-6">
													<div id="server_stats_cpu_usage" style="height: 300px; min-width: 100%"></div>
												</div>

												<div class="col-lg-6">
													<div id="server_stats_ram_usage" style="height: 300px; min-width: 100%"></div>
												</div>
											</div>

											<div class="row">
												<div class="col-lg-6">
													<div id="server_stats_bandwidth_down" style="height: 300px; min-width: 100%"></div>
												</div>

												<div class="col-lg-6">
													<div id="server_stats_bandwidth_up" style="height: 300px; min-width: 100%"></div>
												</div>
											</div>
										</div>
									</section>
								</div>

								<!-- gpu cards -->
								<?php if(isset($headend[0]['gpu_stats']['gpu'][0]['uuid'])) { ?>
									<div class="col-lg-12">
										<section class="panel">
											<header class="panel-heading">
												<div class="panel-actions"></div>
												<h2 class="panel-title">
													GPU Cards 
													<a href="#" data-toggle="modal" data-target="#help_server_gpus">
														<i class="fas fa-question-circle"></i>
													</a>
												</h2>
											</header>
											<div class="panel-body">
												<div class="table-responsive">
													<table class="table table-striped mb-none">
														<thead>
															<tr>
																<th width="1px">ID</th>						<!-- 0 -->
																<th>Name</th>								<!-- 1 -->
																<th width="125px">GPU Clock</th>			<!-- 2 -->
																<th width="125px">Total RAM</th>			<!-- 3 -->
																<th width="100px">Used RAM</th>				<!-- 4 -->
																<th width="75px">Free RAM</th>				<!-- 5 -->
																<th width="75px">Utilization</th>			<!-- 6 -->
																<th width="50px">Temp</th>					<!-- 7 -->
																<th width="100px">Fan Speed</th>			<!-- 8 -->
																<th width="1px">Processes</th>				<!-- 9 -->
															</tr>
														</thead>
														<tbody>
															<?php
																foreach($headend[0]['gpu_stats']['gpu'] as $gpu) {
																	echo '
																		<tr">
																			<td id="'.$gpu['id'].'_row_0_col_0">
																				'.$gpu['id'].'
																			</td>
																			<td id="'.$gpu['id'].'_row_0_col_1">
																				'.$gpu['gpu_name'].'
																			</td>
																			<td id="'.$gpu['id'].'_row_0_col_2">
																				'.$gpu['graphics_clock'].' 
																			</td>
																			<td id="'.$gpu['id'].'_row_0_col_3">
																				'.$gpu['total_ram'].' 
																			</td>
																			<td id="'.$gpu['id'].'_row_0_col_4">
																				'.$gpu['used_ram'].' 
																			</td>
																			<td id="'.$gpu['id'].'_row_0_col_5">
																				'.$gpu['free_ram'].' 
																			</td>
																			<td id="'.$gpu['id'].'_row_0_col_6">
																				'.percentage($gpu['used_ram'], $gpu['total_ram'], 2).'%
																			</td>
																			<td id="'.$gpu['id'].'_row_0_col_7">
																				'.$gpu['gpu_temp'].'
																			</td>
																			<td id="'.$gpu['id'].'_row_0_col_8">
																				'.$gpu['fan_speed'].'
																			</td>
																			<td id="'.$gpu['id'].'_row_0_col_9">
																				'.count($gpu['processes']).'
																			</td>
																		</tr>
																	';
																}
															?>
														</tbody>
													</table>
												</div>
											</div>
										</section>
									</div>
								<?php } ?>

								<!-- capture card sources -->
								<?php if($show_capture_card == true) { ?>
									<div class="col-lg-12">
										<section class="panel">
											<header class="panel-heading">
												<div class="panel-actions"></div>
												<h2 class="panel-title">
													Capture Card Sources 
													<a href="#" data-toggle="modal" data-target="#help_server_sources">
														<i class="fas fa-question-circle"></i>
													</a>
												</h2>
											</header>
											<div class="panel-body">
												<div class="table-responsive">
													<table class="table table-striped mb-none">
														<thead>
															<tr>
																<th width="50px">Status</th>		<!-- 0 -->
																<th width="60px">Device</th>		<!-- 1 -->
																<th>Name</th>						<!-- 2 -->
																<th width="75px">V Codec</th>		<!-- 3 -->
																<th width="50px">Bitrate</th>		<!-- 4 -->
																<th width="100px">Stream Type</th>	<!-- 5 -->
																<th width="50px">Uptime</th>		<!-- 6 -->
																<th width="100px">Used By</th>		<!-- 7 -->
																<th width="100px">Actions</th>		<!-- 8 -->
															</tr>
														</thead>
														<tbody>
															<?php
																foreach($headend[0]['sources'] as $source) {
																	if($source['type'] == 'capture_card') {
																		if($source['status'] == 'available') {
																			$status = '<span class="label label-success full-width" style="width: 100%;">Available</span>';
																			$actions = '
																			<button onclick="source_start(\''.$source['id'].'\')" class="btn btn-success btn-flat btn-xs"><i class="fa fa-check"></i></button> 

																			<!-- <button class="btn btn-primary btn-flat btn-xs"><i class="fa fa-refresh"></i></button> -->
																			';
																		}elseif($source['status'] == 'busy'){
																			$status = '<span class="label label-info full-width" style="width: 100%;">In Use</span>';
																			$actions = '
																			<button onclick="source_stop(\''.$source['id'].'\')" class="btn btn-danger btn-flat btn-xs"><i class="fa fa-pause"></i></button> 

																			<!-- <button onclick="source_restart(\''.$source['id'].'\')" class="btn btn-success btn-flat btn-xs"><i class="fa fa-refresh"></i></button> -->
																			';
																		}elseif($source['status'] == 'missing'){
																			$status = '<span class="label label-warning full-width" style="width: 100%;">Missing</span>';
																			$actions = '
																			<button class="btn btn-danger btn-flat btn-xs"><i class="fa fa-times"></i></button> 

																			<!-- <button onclick="source_restart(\''.$source['id'].'\')" class="btn btn-success btn-flat btn-xs"><i class="fa fa-refresh"></i></button> -->
																			';
																		}elseif($source['status'] == 'offline'){
																			$status = '<span class="label label-danger full-width" style="width: 100%;">Offline</span>';
																			$actions = '
																			<button class="btn btn-danger btn-flat btn-xs"><i class="fa fa-times"></i></button> 

																			<!-- <button onclick="source_restart(\''.$source['id'].'\')" class="btn btn-success btn-flat btn-xs"><i class="fa fa-refresh"></i></button> -->
																			';
																		}

																		if($source['video_codec'] == 'libx264') {
																			$source['video_codec'] = 'H.264';
																		}else{
																			$source['video_codec'] = 'H.265';
																		}

																		$source_name_bits			= explode(":", $source['name']);
																		$source['name']				= $source_name_bits[0];

																		if($source['used_by'] == 'obs') {
																			$source['used_by'] = 'OBS';
																		}

																		if($source['used_by'] == 'mumudvb') {
																			$source['used_by'] = 'MuMuDVB';
																		}

																		if($source['used_by'] == 'ffmpeg') {
																			$source['used_by'] = 'FFMPEG';

																			if($source['output_type'] == "rtmp") {
																				$publish_url = '<strong>RTMP Publish URL:</strong> ' . $source['rtmp_server'];
																			}else{
																				$publish_url = '<strong>HTTP Stream URL:</strong> http://'.$headend[0]['ip_address'] . ':9000/' . $source['video_device'] . '/index.m3u8';
																			}
																		}

																		echo '
																			<tr id="'.$source['id'].'_row_0">
																				<td id="'.$source['id'].'_row_0_col_0">'.$status.'</td>
																				<td id="'.$source['id'].'_row_0_col_1">'.$source['video_device'].'</td>
																				<td id="'.$source['id'].'_row_0_col_2">'.$source['name'].'</td>
																				<td id="'.$source['id'].'_row_0_col_3">'.$source['video_codec'].'</td>
																				<td id="'.$source['id'].'_row_0_col_4">'.$source['bitrate'].'k</td>
																				<td id="'.$source['id'].'_row_0_col_5">'.strtoupper($source['output_type']).'</td>
																				<td id="'.$source['id'].'_row_0_col_6">'.$source['stream_uptime'].'</td>
																				<td id="'.$source['id'].'_row_0_col_7">'.$source['used_by'].'</td>
																				<td id="'.$source['id'].'_row_0_col_8">
																				'.$actions.'

																				<a title="Edit" class="btn btn-info btn-flat btn-xs" href="dashboard.php?c=source&source_id='.$source['id'].'"><i class="fa fa-gears"></i></a></td>
																			</tr>
																		';

																		if($source['status'] == 'busy') {
																			echo '
																				<tr id="'.$source['id'].'_row_1">
																					<td colspan="9">'.$publish_url.'</td>
																				</tr>
																			';
																		}else{
																			echo '
																				<tr id="'.$source['id'].'_row_1">
																					<td id="'.$source['id'].'_row_1_col_0" colspan="9"><strong>Not Streaming.</strong></td>
																				</tr>
																			';
																		}
																	}else{
																		
																	}
																}
															?>
														</tbody>
													</table>
												</div>
											</div>
										</section>
									</div>
								<?php } ?>

								<!-- dvb-c sources -->
								<?php if($show_dvbc == true) { ?>
									<div class="col-lg-12">
										<section class="panel">
											<header class="panel-heading">
												<div class="panel-actions"></div>
												<h2 class="panel-title">
													DVB-C/C2 Card Sources 
													<a href="#" data-toggle="modal" data-target="#help_server_sources">
														<i class="fas fa-question-circle"></i>
													</a>
												</h2>
											</header>
											<div class="panel-body">
												<div class="table-responsive">
													<table class="table table-striped mb-none">
														<thead>
															<tr>
																<th width="50px">Status</th>		<!-- 0 -->
																<th width="60px">Device</th>		<!-- 1 -->
																<th>Name</th>						<!-- 2 -->
																<th width="10px">Freq</th>			<!-- 3 -->
																<th width="10px">Pol</th>			<!-- 4 -->
																<th width="10px">SR</th>			<!-- 5 -->
																<th width="80px">Signal</th>		<!-- 6 -->
																<th width="80px">SNR</th>			<!-- 7 -->
																<th width="100px">Uptime</th>		<!-- 8 -->
																<th width="100px">Used By</th>		<!-- 9 -->
															</tr>
														</thead>
														<tbody>
															<?php
																foreach($headend[0]['sources'] as $source) {
																	if($source['type'] == 'dvb_card' && $source['dvb_type'] == 'dvbc') {
																		if($source['status'] == 'available') {
																			$status = '<span class="label label-success full-width" style="width: 100%;">Available</span>';
																			$actions = '
																			<button onclick="source_start(\''.$source['id'].'\')" class="btn btn-success btn-flat btn-xs"><i class="fa fa-check"></i></button> 

																			<!-- <button class="btn btn-primary btn-flat btn-xs"><i class="fa fa-refresh"></i></button> -->
																			';
																		}elseif($source['status'] == 'busy'){
																			$status = '<span class="label label-info full-width" style="width: 100%;">In Use</span>';
																			$actions = '
																			<button onclick="source_stop(\''.$source['id'].'\')" class="btn btn-danger btn-flat btn-xs"><i class="fa fa-pause"></i></button> 

																			<!-- <button onclick="source_restart(\''.$source['id'].'\')" class="btn btn-success btn-flat btn-xs"><i class="fa fa-refresh"></i></button> -->
																			';
																		}elseif($source['status'] == 'missing'){
																			$status = '<span class="label label-warning full-width" style="width: 100%;">Missing</span>';
																			$actions = '
																			<button class="btn btn-danger btn-flat btn-xs"><i class="fa fa-times"></i></button> 

																			<!-- <button onclick="source_restart(\''.$source['id'].'\')" class="btn btn-success btn-flat btn-xs"><i class="fa fa-refresh"></i></button> -->
																			';
																		}elseif($source['status'] == 'offline'){
																			$status = '<span class="label label-danger full-width" style="width: 100%;">Offline</span>';
																			$actions = '
																			<button class="btn btn-danger btn-flat btn-xs"><i class="fa fa-times"></i></button> 

																			<!-- <button onclick="source_restart(\''.$source['id'].'\')" class="btn btn-success btn-flat btn-xs"><i class="fa fa-refresh"></i></button> -->
																			';
																		}

																		if($source['used_by'] == 'tvheadend') {
																			$source['used_by'] = 'TVHeadend';

																			$tvheadend = build_mumudvb_stream_list($headend, $source);

																			$publish_url 		= $mumudvb['publish_url'];

																			$frequency 			= $mumudvb['frequency'];
																			$polarization 		= $mumudvb['polarization'];
																			$symbolrate 		= $mumudvb['symbolrate'];
																		}

																		if($source['used_by'] == 'mumudvb' || $source['used_by'] == 'femon') {
																			$source['used_by'] = 'MuMuDVB';

																			$mumudvb = build_mumudvb_stream_list($headend, $source);

																			$publish_url 		= $mumudvb['publish_url'];

																			$frequency 			= $mumudvb['frequency'];
																			$polarization 		= $mumudvb['polarization'];
																			$symbolrate 		= $mumudvb['symbolrate'];
																		}

																		if($source['used_by'] == 'astra') {
																			$source['used_by'] = 'CESBO ASTRA';

																			$dvb_adapter_id = str_replace("adapter", "", $source['video_device']);

																			$publish_url = '';

																			foreach($headend[0]['astra_config_file']['dvb_tune'] as $tuner) {
																				if($tuner['adapter'] == $dvb_adapter_id) {
																					// echo 'ID: ' . $tuner['id'] . '<br>';
																					// echo 'Frequency: ' . $tuner['frequency'] . '<br>';
																					// echo 'Polarization: ' . $tuner['polarization'] . '<br>';
																					// echo 'Symbolrate: ' . $tuner['symbolrate'] . '<br>';

																					$frequency 			= $tuner['frequency'];;
																					$polarization 		= $tuner['polarization'];
																					$symbolrate 		= $tuner['symbolrate'];
																					
																					// lets search for channels on this frequency
																					foreach($headend[0]['astra_config_file']['make_stream'] as $stream) {
																						if (strpos($stream['input'][0], $tuner['id']) !== false) {
																							$publish_url .= '

																							<div class="col-lg-2">
																								'.$stream['name'].'
																							</div>
																							<div class="col-lg-10 text-right">
																								<strong>Stream URL:</strong> http://'.$headend[0]['ip_address'].':'.$headend[0]['astra_port'].'/play/' . $stream['id'].'<br>
																							</div>
																							';
																						}
																					}
																				}
																			}
																		}

																		if($source['dvb_signal'] == 'no_signal') {
																			$source['dvb_signal'] = ucwords(str_replace("_", " ", $source['dvb_signal']));
																		}elseif(!empty($source['dvb_signal'])){
																			$source['dvb_signal'] = $source['dvb_signal'].'%';
																		}

																		if($source['dvb_snr'] == 'no_signal') {
																			$source['dvb_snr'] = ucwords(str_replace("_", " ", $source['dvb_snr']));
																		}elseif(!empty($source['dvb_snr'])){
																			$source['dvb_snr'] = $source['dvb_snr'].'%';
																		}

																		echo '
																			<tr id="'.$source['id'].'_row_0">
																				<td id="'.$source['id'].'_row_0_col_0">'.$status.'</td>
																				<td id="'.$source['id'].'_row_0_col_1">'.$source['video_device'].'</td>
																				<td id="'.$source['id'].'_row_0_col_2">'.$source['name'].'</td>
																				<td id="'.$source['id'].'_row_0_col_3">'.$frequency.'</td>
																				<td id="'.$source['id'].'_row_0_col_4">'.$polarization.'</td>
																				<td id="'.$source['id'].'_row_0_col_5">'.$symbolrate.'</td>
																				<td id="'.$source['id'].'_row_0_col_6">'.$source['dvb_signal'].'</td>
																				<td id="'.$source['id'].'_row_0_col_7">'.$source['dvb_snr'].'</td>
																				<td id="'.$source['id'].'_row_0_col_8">'.$source['stream_uptime'].'</td>
																				<td id="'.$source['id'].'_row_0_col_9">'.$source['used_by'].'</td>
																			</tr>
																		';

																		if($source['status'] == 'busy') {
																			echo '
																				<tr id="'.$source['id'].'_row_1">
																					<td id="'.$source['id'].'_row_1_col_0" colspan="10"><div class="">'.$publish_url.'</div></td>
																				</tr>
																			';
																		}else{
																			echo '
																				<tr id="'.$source['id'].'_row_1">
																					<td id="'.$source['id'].'_row_1_col_0" colspan="10"><strong>Not Streaming.</strong></td>
																				</tr>
																			';
																		}
																	}else{
																		
																	}
																}
															?>
														</tbody>
													</table>
												</div>
											</div>
										</section>
									</div>
								<?php } ?>

								<!-- dvb-s sources -->
								<?php if($show_dvbs == true) { ?>
									<div class="col-lg-12">
										<section class="panel">
											<header class="panel-heading">
												<div class="panel-actions"></div>
												<h2 class="panel-title">
													DVB-S/S2 Card Sources 
													<a href="#" data-toggle="modal" data-target="#help_server_sources">
														<i class="fas fa-question-circle"></i>
													</a>
												</h2>
											</header>
											<div class="panel-body">
												<div class="table-responsive">
													<table class="table table-striped mb-none">
														<thead>
															<tr>
																<th width="50px">Status</th>		<!-- 0 -->
																<th width="60px">Device</th>		<!-- 1 -->
																<th>Name</th>						<!-- 2 -->
																<th width="10px">Freq</th>			<!-- 3 -->
																<th width="10px">Pol</th>			<!-- 4 -->
																<th width="10px">SR</th>			<!-- 5 -->
																<th width="80px">Signal</th>		<!-- 6 -->
																<th width="80px">SNR</th>			<!-- 7 -->
																<th width="100px">Uptime</th>		<!-- 8 -->
																<th width="100px">Used By</th>		<!-- 9 -->
															</tr>
														</thead>
														<tbody>
															<?php
																foreach($headend[0]['sources'] as $source) {
																	if($source['type'] == 'dvb_card' && $source['dvb_type'] == 'dvbs') {
																		if($source['status'] == 'available') {
																			$status = '<span class="label label-success full-width" style="width: 100%;">Available</span>';
																			$actions = '
																			<button onclick="source_start(\''.$source['id'].'\')" class="btn btn-success btn-flat btn-xs"><i class="fa fa-check"></i></button> 

																			<!-- <button class="btn btn-primary btn-flat btn-xs"><i class="fa fa-refresh"></i></button> -->
																			';
																		}elseif($source['status'] == 'busy'){
																			$status = '<span class="label label-info full-width" style="width: 100%;">In Use</span>';
																			$actions = '
																			<button onclick="source_stop(\''.$source['id'].'\')" class="btn btn-danger btn-flat btn-xs"><i class="fa fa-pause"></i></button> 

																			<!-- <button onclick="source_restart(\''.$source['id'].'\')" class="btn btn-success btn-flat btn-xs"><i class="fa fa-refresh"></i></button> -->
																			';
																		}elseif($source['status'] == 'missing'){
																			$status = '<span class="label label-warning full-width" style="width: 100%;">Missing</span>';
																			$actions = '
																			<button class="btn btn-danger btn-flat btn-xs"><i class="fa fa-times"></i></button> 

																			<!-- <button onclick="source_restart(\''.$source['id'].'\')" class="btn btn-success btn-flat btn-xs"><i class="fa fa-refresh"></i></button> -->
																			';
																		}elseif($source['status'] == 'offline'){
																			$status = '<span class="label label-danger full-width" style="width: 100%;">Offline</span>';
																			$actions = '
																			<button class="btn btn-danger btn-flat btn-xs"><i class="fa fa-times"></i></button> 

																			<!-- <button onclick="source_restart(\''.$source['id'].'\')" class="btn btn-success btn-flat btn-xs"><i class="fa fa-refresh"></i></button> -->
																			';
																		}

																		if($source['used_by'] == 'tvheadend') {
																			$source['used_by'] = 'TVHeadend';
																		}

																		if($source['used_by'] == 'mumudvb' || $source['used_by'] == 'femon') {
																			$source['used_by'] = 'MuMuDVB';

																			$mumudvb = build_mumudvb_stream_list($headend, $source);

																			$publish_url 		= $mumudvb['publish_url'];

																			$frequency 			= $mumudvb['frequency'];
																			$polarization 		= $mumudvb['polarization'];
																			$symbolrate 		= $mumudvb['symbolrate'];
																		}

																		if($source['used_by'] == 'astra') {
																			$source['used_by'] = 'CESBO ASTRA';

																			$dvb_adapter_id = str_replace("adapter", "", $source['video_device']);

																			$publish_url = '';

																			foreach($headend[0]['astra_config_file']['dvb_tune'] as $tuner) {
																				if($tuner['adapter'] == $dvb_adapter_id) {
																					// echo 'ID: ' . $tuner['id'] . '<br>';
																					// echo 'Frequency: ' . $tuner['frequency'] . '<br>';
																					// echo 'Polarization: ' . $tuner['polarization'] . '<br>';
																					// echo 'Symbolrate: ' . $tuner['symbolrate'] . '<br>';

																					$frequency 			= $tuner['frequency'];;
																					$polarization 		= $tuner['polarization'];
																					$symbolrate 		= $tuner['symbolrate'];
																					
																					// lets search for channels on this frequency
																					foreach($headend[0]['astra_config_file']['make_stream'] as $stream) {
																						if (strpos($stream['input'][0], $tuner['id']) !== false) {
																							$publish_url .= '

																							<div class="col-lg-2">
																								'.$stream['name'].'
																							</div>
																							<div class="col-lg-10 text-right">
																								<strong>Stream URL:</strong> http://'.$headend[0]['ip_address'].':'.$headend[0]['astra_port'].'/' . $stream['id'].'<br>
																							</div>
																							';
																						}
																					}
																				}
																			}
																		}

																		if($source['dvb_signal'] == 'no_signal') {
																			$source['dvb_signal'] = ucwords(str_replace("_", " ", $source['dvb_signal']));
																		}elseif(!empty($source['dvb_signal'])){
																			$source['dvb_signal'] = $source['dvb_signal'].'%';
																		}

																		if($source['dvb_snr'] == 'no_signal') {
																			$source['dvb_snr'] = ucwords(str_replace("_", " ", $source['dvb_snr']));
																		}elseif(!empty($source['dvb_snr'])){
																			$source['dvb_snr'] = $source['dvb_snr'].'%';
																		}

																		echo '
																			<tr id="'.$source['id'].'_row_0">
																				<td id="'.$source['id'].'_row_0_col_0">'.$status.'</td>
																				<td id="'.$source['id'].'_row_0_col_1">'.$source['video_device'].'</td>
																				<td id="'.$source['id'].'_row_0_col_2">'.$source['name'].'</td>
																				<td id="'.$source['id'].'_row_0_col_3">'.$frequency.'</td>
																				<td id="'.$source['id'].'_row_0_col_4">'.$polarization.'</td>
																				<td id="'.$source['id'].'_row_0_col_5">'.$symbolrate.'</td>
																				<td id="'.$source['id'].'_row_0_col_6">'.$source['dvb_signal'].'</td>
																				<td id="'.$source['id'].'_row_0_col_7">'.$source['dvb_snr'].'</td>
																				<td id="'.$source['id'].'_row_0_col_8">'.$source['stream_uptime'].'</td>
																				<td id="'.$source['id'].'_row_0_col_9">'.$source['used_by'].'</td>
																			</tr>
																		';

																		if($source['status'] == 'busy') {
																			echo '
																				<tr id="'.$source['id'].'_row_1">
																					<td id="'.$source['id'].'_row_1_col_0" colspan="10"><div class="">'.$publish_url.'</div></td>
																				</tr>
																			';
																		}else{
																			echo '
																				<tr id="'.$source['id'].'_row_1">
																					<td id="'.$source['id'].'_row_1_col_0" colspan="10"><strong>Not Streaming.</strong></td>
																				</tr>
																			';
																		}
																	}else{
																		
																	}
																}
															?>
														</tbody>
													</table>
												</div>
											</div>
										</section>
									</div>
								<?php } ?>

								<!-- dvb-t sources -->
								<?php if($show_dvbt == true) { ?>
									<div class="col-lg-12">
										<section class="panel">
											<header class="panel-heading">
												<div class="panel-actions"></div>
												<h2 class="panel-title">
													DVB-T/T2 Card Sources 
													<a href="#" data-toggle="modal" data-target="#help_server_sources">
														<i class="fas fa-question-circle"></i>
													</a>
												</h2>
											</header>
											<div class="panel-body">
												<div class="table-responsive">
													<table class="table table-striped mb-none">
														<thead>
															<tr>
																<th width="50px">Status</th>		<!-- 0 -->
																<th width="60px">Device</th>		<!-- 1 -->
																<th>Name</th>						<!-- 2 -->
																<th width="10px">Freq</th>			<!-- 3 -->
																<th width="80px">Signal</th>		<!-- 4 -->
																<th width="80px">SNR</th>			<!-- 5 -->
																<th width="100px">Uptime</th>		<!-- 6 -->
																<th width="100px">Used By</th>		<!-- 7 -->
																<th width="100px">Actions</th>		<!-- 8 -->
															</tr>
														</thead>
														<tbody>
															<?php
																foreach($headend[0]['sources'] as $source) {
																	if($source['type'] == 'dvb_card' && $source['dvb_type'] == 'dvbt') {
																		if($source['status'] == 'available') {
																			$status = '<span class="label label-success full-width" style="width: 100%;">Available</span>';
																			$actions = '
																			<button title="Scan for channels" onclick="source_scan(\''.$source['id'].'\')" class="btn btn-success btn-flat btn-xs"><i class="fa fa-signal"></i></button> 

																			<!-- <button class="btn btn-primary btn-flat btn-xs"><i class="fa fa-refresh"></i></button> -->
																			';
																		}elseif($source['status'] == 'busy'){
																			$status = '<span class="label label-info full-width" style="width: 100%;">In Use</span>';
																			$actions = '
																			<!-- <button onclick="source_stop(\''.$source['id'].'\')" class="btn btn-danger btn-flat btn-xs"><i class="fa fa-pause"></i></button>  -->

																			<!-- <button onclick="source_restart(\''.$source['id'].'\')" class="btn btn-success btn-flat btn-xs"><i class="fa fa-refresh"></i></button> -->
																			';
																		}elseif($source['status'] == 'missing'){
																			$status = '<span class="label label-warning full-width" style="width: 100%;">Missing</span>';
																			$actions = '
																			<!-- <button class="btn btn-danger btn-flat btn-xs"><i class="fa fa-times"></i></button>  -->

																			<!-- <button onclick="source_restart(\''.$source['id'].'\')" class="btn btn-success btn-flat btn-xs"><i class="fa fa-refresh"></i></button> -->
																			';
																		}elseif($source['status'] == 'offline'){
																			$status = '<span class="label label-danger full-width" style="width: 100%;">Offline</span>';
																			$actions = '
																			<!-- <button class="btn btn-danger btn-flat btn-xs"><i class="fa fa-times"></i></button>  -->

																			<!-- <button onclick="source_restart(\''.$source['id'].'\')" class="btn btn-success btn-flat btn-xs"><i class="fa fa-refresh"></i></button> -->
																			';
																		}

																		if($source['used_by'] == 'tvheadend') {
																			$source['used_by'] = 'TVHeadend';
																		}

																		if($source['used_by'] == 'w_scan') {
																			$source['used_by'] = 'SCANNER';

																			$status = '<span class="label label-warning full-width" style="width: 100%;">Scanning</span>';
																		}

																		if($source['used_by'] == 'mumudvb' || $source['used_by'] == 'femon') {
																			$source['used_by'] = 'MuMuDVB';

																			$mumudvb = build_mumudvb_stream_list($headend, $source);

																			$publish_url 		= $mumudvb['publish_url'];

																			$frequency 			= $mumudvb['frequency'];
																			$polarization 		= $mumudvb['polarization'];
																			$symbolrate 		= $mumudvb['symbolrate'];
																		}

																		if($source['used_by'] == 'astra') {
																			$source['used_by'] = 'CESBO ASTRA';

																			$dvb_adapter_id = str_replace("adapter", "", $source['video_device']);

																			$publish_url = '';

																			foreach($headend[0]['astra_config_file']['dvb_tune'] as $tuner) {
																				if($tuner['adapter'] == $dvb_adapter_id) {
																					// echo 'ID: ' . $tuner['id'] . '<br>';
																					// echo 'Frequency: ' . $tuner['frequency'] . '<br>';
																					// echo 'Polarization: ' . $tuner['polarization'] . '<br>';
																					// echo 'Symbolrate: ' . $tuner['symbolrate'] . '<br>';

																					$frequency 			= $tuner['frequency'];;
																					$polarization 		= $tuner['polarization'];
																					$symbolrate 		= $tuner['symbolrate'];
																					
																					// lets search for channels on this frequency
																					foreach($headend[0]['astra_config_file']['make_stream'] as $stream) {
																						if (strpos($stream['input'][0], $tuner['id']) !== false) {
																							$publish_url .= '

																							<div class="col-lg-2">
																								'.$stream['name'].'
																							</div>
																							<div class="col-lg-10 text-right">
																								<strong>Stream URL:</strong> http://'.$headend[0]['ip_address'].':'.$headend[0]['astra_port'].'/' . $stream['id'].'<br>
																							</div>
																							';
																						}
																					}
																				}
																			}
																		}

																		if($source['dvb_signal'] == 'no_signal') {
																			$source['dvb_signal'] = ucwords(str_replace("_", " ", $source['dvb_signal']));
																		}elseif(!empty($source['dvb_signal'])){
																			$source['dvb_signal'] = $source['dvb_signal'].'%';
																		}

																		if($source['dvb_snr'] == 'no_signal') {
																			$source['dvb_snr'] = ucwords(str_replace("_", " ", $source['dvb_snr']));
																		}elseif(!empty($source['dvb_snr'])){
																			$source['dvb_snr'] = $source['dvb_snr'].'%';
																		}

																		echo '
																			<tr id="'.$source['id'].'_row_0">
																				<td id="'.$source['id'].'_row_0_col_0">'.$status.'</td>
																				<td id="'.$source['id'].'_row_0_col_1">'.$source['video_device'].'</td>
																				<td id="'.$source['id'].'_row_0_col_2">'.$source['name'].'</td>
																				<td id="'.$source['id'].'_row_0_col_3">'.$frequency.'</td>
																				<td id="'.$source['id'].'_row_0_col_4">'.$source['dvb_signal'].'</td>
																				<td id="'.$source['id'].'_row_0_col_5">'.$source['dvb_snr'].'</td>
																				<td id="'.$source['id'].'_row_0_col_6">'.$source['stream_uptime'].'</td>
																				<td id="'.$source['id'].'_row_0_col_7">'.$source['used_by'].'</td>
																				<td id="'.$source['id'].'_row_0_col_8">'.$actions.'</td>
																			</tr>
																		';

																		if($source['status'] == 'busy') {
																			echo '
																				<tr id="'.$source['id'].'_row_1">
																					<td id="'.$source['id'].'_row_1_col_0" colspan="10"><div class="">'.$publish_url.'</div></td>
																				</tr>
																			';
																		}else{
																			echo '
																				<tr id="'.$source['id'].'_row_1">
																					<td id="'.$source['id'].'_row_1_col_0" colspan="10"><strong>Not Streaming.</strong></td>
																				</tr>
																			';
																		}
																	}else{
																		
																	}																
																}
															?>
														</tbody>
													</table>
												</div>
											</div>
										</section>
									</div>
								<?php } ?>
							</div>

							<div class="col-lg-4 nopadding">
								<div class="col-lg-12">
									<!--
									<div class="row">
										<section class="panel">
											<header class="panel-heading">
												<div class="panel-actions"></div>
												<h2 class="panel-title">Ssystem Stats</h2>
											</header>
											<div class="panel-body">
												<div class="col-lg-4">
													<span id="cpu_usage_gage" class="gauge_none text-center">
					                                    <img src="assets/images/loading.gif" alt="" height="100%">
					                                </span>
												</div>

												<div class="col-lg-4">
													<span id="ram_usage_gage" class="gauge_none text-center">
					                                    <img src="assets/images/loading.gif" alt="" height="100%">
					                                </span>
												</div>

												<div class="col-lg-4">
													<span id="disk_usage_gage" class="gauge_none text-center">
					                                    <img src="assets/images/loading.gif" alt="" height="100%">
					                                </span>
												</div>
											</div>
										</section>
									</div>
									-->

									<div class="row">
										<div class="box box-primary">
											<div class="box-header">
												Server Info 

												<a href="#" data-toggle="modal" data-target="#help_server_info">
													<i class="fas fa-question-circle"></i>
												</a>
											</div>
											<div class="box-body">
												<table id="servers" class="table table-striped table-hover">
	            									<tbody>
	            										<tr>
	            											<td><b>Hostname</b></td>
	            											<td><?php echo stripslashes($headend[0]['public_hostname']); ?></td>
	            										</tr>
	            										<tr>
	            											<td><b>OS</b></td>
	            											<td><?php echo stripslashes($headend[0]['os_version']); ?></td>
	            										</tr>
	            										<tr>
	            											<td><b>Kernel</b></td>
	            											<td><?php echo stripslashes($headend[0]['kernel']); ?></td>
	            										</tr>
	            										<tr>
	            											<td><b>CPU Model</b></td>
	            											<td><?php echo stripslashes($headend[0]['cpu_model']); ?></td>
	            										</tr>
	            										<tr>
	            											<td><b>CPU Cores</b></td>
	            											<td><?php echo stripslashes($headend[0]['cpu_cores']); ?> Cores @ <?php echo stripslashes($headend[0]['cpu_speed']); ?> MHz </td>
	            										</tr>
	            										<tr>
	            											<td><b>RAM</b></td>
	            											<td><?php echo formatbytes($headend[0]['ram_total'], 0); ?> GB</td>
	            										</tr>
	            										<tr>
	            											<td><b>IP Address</b></td>
	            											<td><?php echo $headend[0]['ip_address']; ?></td>
	            										</tr>
	            										<tr>
	            											<td><b>WAN IP Address</b></td>
	            											<td><?php echo $headend[0]['wan_ip_address']; ?></td>
	            										</tr>
	            										<tr>
	            											<td><b>Active Connections</b></td>
	            											<td><?php echo $headend[0]['active_connections']; ?></td>
	            										</tr>
	            									</tbody>
	            								</table>
											</div>
										</div>
									</div>

									<div class="row">
										<form action="actions.php?a=headend_update&server_id=<?php echo $headend[0]['id']; ?>" class="form-horizontal form-bordered" method="post">
											<input type="hidden" id="server_id" name="server_id" value="<?php echo $headend[0]['id']; ?>">
											<div class="box box-primary">
												<div class="box-header">
													Settings 

													<a href="#help_server_settings" data-toggle="modal" data-target="#help_server_settings">
														<i class="fas fa-question-circle"></i>
													</a>
												</div>
												<div class="box-body">
													<div class="form-group">
														<label class="col-md-4 control-label" for="name">Name</label>
														<div class="col-md-8">
															<input type="text" class="form-control" id="name" name="name" value="<?php echo stripslashes($headend[0]['name']); ?>">
														</div>
													</div>

													<!--
													<div class="form-group">
														<label class="col-md-4 control-label" for="ssh_port">SSH Port</label>
														<div class="col-md-8">
															<input type="text" class="form-control" id="ssh_port" name="ssh_port" value="<?php echo $headend[0]['ssh_port']; ?>">
														</div>
													</div>

													<div class="form-group">
														<label class="col-md-4 control-label" for="ssh_password">SSH Password</label>
														<div class="col-md-8">
															<input type="password" class="form-control" id="ssh_password" name="ssh_password" value="<?php echo $headend[0]['ssh_password']; ?>">
														</div>
													</div>
													-->

													<div class="form-group">
														<label class="col-md-4 control-label" for="http_stream_port">Streaming Port</label>
														<div class="col-md-8">
															<input type="text" class="form-control" id="http_stream_port" name="http_stream_port" value="<?php echo $headend[0]['http_stream_port']; ?>" readonly>
														</div>
													</div>

													<div class="form-group">
														<label class="col-md-4 control-label" for="public_hostname">Hostname</label>
														<div class="col-md-8">
															<input type="text" class="form-control" id="public_hostname" name="public_hostname" value="<?php echo $headend[0]['public_hostname']; ?>">
															<small>This an optional hostname for internal use only. Customers do <strong>NOT</strong> see this.</small>
														</div>
													</div>
												</div>
												<div class="box-footer">
													<button type="submit" class="pull-right btn btn-success">Save Changes</button>
												</div>
											</div>
										</form>
									</div>

									<!-- active connections -->
									<div class="row">
										<div class="box box-primary">
											<div class="box-header">
												Active Streams
											</div>
											<div class="box-body">
												<table id="current_connections" class="table table-bordered table-striped">
													<thead>
														<tr>
															<th>Stream</th>
															<th>Conn</th>
															<th>Bandwidth (Est)</th>					
														</tr>
													</thead>
													<tbody>
														<?php
															$time_shift = time() - 60;
															
													        $sql = "
													            SELECT * FROM `streams_connection_logs` 
													            WHERE `server_id` = '".$server_id."'
													            AND `timestamp` > '".$time_shift."' 
													            GROUP BY `stream_id`, `stream_id` 
													        ";
													        $query = $conn->query($sql);
															$current_connections = $query->fetchAll(PDO::FETCH_ASSOC);

															foreach($current_connections as $current_connection) {
																// $query = $conn->query("SELECT * FROM `headend_servers` WHERE `id` = '".$current_connection['server_id']."' ");
																// $headend = $query->fetch(PDO::FETCH_ASSOC);

																$query = $conn->query("SELECT `id`,`name`,`bitrate` FROM `streams` WHERE `id` = '".$current_connection['stream_id']."' ");
																$stream = $query->fetch(PDO::FETCH_ASSOC);

																$query = $conn->query("SELECT `id` FROM `streams_connection_logs` WHERE `stream_id` = '".$current_connection['stream_id']."' AND `timestamp` > '".$time_shift."' ");
																$connections = $query->fetchAll(PDO::FETCH_ASSOC);
																$total_connections = count($connections);

																// calc bandwidth per stream
																$bandwidth = ($stream['bitrate'] / 1024) * $total_connections;

																echo '
																	<tr>
																		<td>
																			'.stripslashes($stream['name']).'
																		</td>
																		<td>
																			'.number_format($total_connections).'
																		</td>
																		<td>
																			'.number_format($bandwidth, 2).' MBit
																		</td>
																	</tr>
																';

																// unset($headend);
																// unset($stream);
															}
														?>
													</tbody>
												</table>

											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-12">
								<section class="panel">
									<footer class="panel-footer">
										<a href="dashboard.php?c=servers" class="btn btn-default">Back</a>
									</footer>
								</section>
							</div>
						</div>
					</section>
				<?php } ?>
            </div>
        <?php } ?>

        <?php function streams(){ ?>
        	<?php 
        		global $conn, $wp, $global_settings, $account_details, $site, $whmcs, $product_ids;
            
            	sanity_check();

        		$modal_streams 		= '';
        		$reinstall_modals 	= '';
        		$web_player_links 	= '';
        		$server_id 			= get('server_id');
        		$source_domain 		= get('source_domain');

	        	$query = $conn->query("SELECT `id`,`name` FROM `headend_servers` WHERE `user_id` = '".$_SESSION['account']['id']."' ORDER BY `name` ASC");
				$headends = $query->fetchAll(PDO::FETCH_ASSOC);

				if($server_id){
					$query = $conn->query("SELECT `id`,`source`,`name` FROM `streams` WHERE `user_id` = '".$_SESSION['account']['id']."' AND `stream_type` = 'input' AND `server_id` = '".$server_id."' ");
				}else{
					$query = $conn->query("SELECT `id`,`source`,`name` FROM `streams` WHERE `user_id` = '".$_SESSION['account']['id']."' AND `stream_type` = 'input' ");
				}
				if($query !== FALSE) {
					$streams = $query->fetchAll(PDO::FETCH_ASSOC);
				}

				$query = $conn->query("SELECT * FROM `stream_categories` WHERE `user_id` = '".$_SESSION['account']['id']."' ORDER BY `name` ASC");
				if($query !== FALSE) {
					$categories = $query->fetchAll(PDO::FETCH_ASSOC);
				}

				$query = $conn->query("SELECT * FROM `remote_playlists` WHERE `user_id` = '".$_SESSION['account']['id']."' ORDER BY `name` ASC");
				if($query !== FALSE) {
					$playlists = $query->fetchAll(PDO::FETCH_ASSOC);
				}

				// get epg source
				$query 							= $conn->query("SELECT * FROM `epg_xml_ids` ");
				$epg_xml_ids 					= $query->fetchAll(PDO::FETCH_ASSOC);
			?>

			<style>
				td.details-control {
				    background: url('img/details_open.png') no-repeat center center;
				    cursor: pointer;
				}
				tr.shown td.details-control {
				    background: url('img/details_close.png') no-repeat center center;
				}

				.player-frame-wrapper {
					position: relative;
					width: 100%;
				}
				.player-frame-wrapper-ratio {
					/* same as player ratio */
					padding-top: 41.67%;
				}

				.player-frame {
					/* make iframe fill wrapper */
					position: absolute;
					top: 0;
					left: 0;
					width: 100%;
					height: 400px;
					border: none;
				}
			</style>

            <div class="content-wrapper">
            	<div class="modal fade" id="analyse_stream_modal" role="dialog">
				    <div class="modal-dialog modal-lg">
				        <div class="modal-content">
				            <div class="modal-header">
				                <button type="button" class="close" data-dismiss="modal">&times;</button>
				                <h4 class="modal-title">Analyse Stream</h4>
				            </div>
				            <div class="modal-body">
				            	<span id="analyse_stream_working" class="hidden">
				            		<center>
				            			<img src="assets/images/ajax-loader.gif" alt="" height="25px">
				            		</center>
				            	</span>

				            	<span id="analyse_stream_form" class="">
					                <center>
					                	<p>Enter your full source URL below and we will analyse it for you.</p>
					                </center>
					                <div class="row">
								    	<div class="col-lg-12">
										    <div class="form-group">
												<!-- <label class="col-md-2 control-label" for="analyse_stream_url">URL</label> -->
												<div class="col-md-12">
													<input type="text" class="form-control" id="analyse_stream_url" name="analyse_stream_url" placeholder="Enter full stream URL. Example: http://server.com/stream_id" required="">
												</div>
											</div>
										</div>
									</div>
									<br><br>
									<div class="row">
										<div class="col-lg-12">
											<center>
												<button onclick="analyse_stream()" type="button" class="btn btn-success">Analyse Stream</button>
											</center>
										</div>
									</div>
								</span>

								<span id="analyse_stream_results" class="hidden">
									<div class="row">
										<div id="analyse_stream_results_left" class="col-lg-6">

										</div>

										<div id="analyse_stream_results_right" class="col-lg-6">

										</div>
									</div>
								</span>

								<span id="analyse_stream_reset" class="hidden">
									<hr>
									<center>
										<button onclick="analyse_stream_reset()" type="button" class="btn btn-success">Analyse Another Stream</button>
									</center>
								</span>

				            </div>
				            <div class="modal-footer">
				                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				            </div>
				        </div>
				    </div>
				</div>

				<div class="modal fade" id="web_player" role="dialog">
				    <div class="modal-dialog modal-lg">
				        <div class="modal-content">
				            <div class="modal-header">
				                <button type="button" class="close" data-dismiss="modal">&times;</button>
				                <h4 class="modal-title"></h4>
				            </div>
				            <div class="modal-body">
				            	<span id="web_player_loading" class="hidden">
				            		<center>
				            			<img src="assets/images/ajax-loader.gif" alt="" height="25px">
				            		</center>
				            	</span>

				            	<span id="web_player_live" class="">
					                <div class="row">
								    	<div class="col-lg-12">
								    		<div class="player-frame-wrapper">
 
												<iframe id="web_player_iframe" src=""
												class="player-frame"
												allowfullscreen></iframe>

												<div class="player-frame-wrapper-ratio"></div>
											</div>
										    <!-- <iframe class="embed-responsive-item" src="test.php" allowfullscreen style="width: 100%; height: 300px;"></iframe> -->
										</div>
									</div>
								</span>
				            </div>
				            <div class="modal-footer">
				                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				            </div>
				        </div>
				    </div>
				</div>

				<form action="actions.php?a=bulk_update_sources" class="form-horizontal form-bordered" method="post">
					<div class="modal fade" id="bulk_update_sources" role="dialog">
					    <div class="modal-dialog modal-lg">
					        <div class="modal-content">
					            <div class="modal-header">
					                <button type="button" class="close" data-dismiss="modal">&times;</button>
					                <h4 class="modal-title">Bulk Source URL Update</h4>
					            </div>
					            <div class="modal-body">
									<div class="row">
						            	<div class="col-lg-12">
							            	<div class="form-group">
												<label class="col-md-2 control-label" for="old_source_url">Old Source URL</label>
												<div class="col-md-10">
													<input type="text" class="form-control" id="old_source_url" name="old_source_url" placeholder="old.domain.com" required="">
													<small>
														<strong>Be careful!</strong> Only enter 'old.domain.com' no need to enter 'http://'. ANYTHING entered here will be replaced including port numbers and channel details or username and passwords.
													</small>
												</div>
											</div>
										</div>
									</div>
									
									<div class="row">
						            	<div class="col-lg-12">
							            	<div class="form-group">
												<label class="col-md-2 control-label" for="new_source_url">New Source URL</label>
												<div class="col-md-10">
													<input type="text" class="form-control" id="new_source_url" name="new_source_url" placeholder="new.domain.com" required="">
													<small>
														<strong>Be careful!</strong> Only enter 'new.domain.com' no need to enter 'http://'. ANYTHING entered here will replace what you entered for the old source url including port numbers, username and passwords. This cannot be undone.
													</small>
												</div>
											</div>
										</div>
									</div>
					            </div>
					            <div class="modal-footer">
					                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					                <button type="submit" class="btn btn-success">Update</button>
					            </div>
					        </div>
					    </div>
					</div>
				</form>

				<form action="actions.php?a=stream_add" class="form-horizontal form-bordered" method="post">
					<div class="modal fade" id="new_stream_modal" role="dialog">
					    <div class="modal-dialog modal-lg">
					        <div class="modal-content">
					            <div class="modal-header">
					                <button type="button" class="close" data-dismiss="modal">&times;</button>
					                <h4 class="modal-title">Add New Input Stream</h4>
					            </div>
					            <div class="modal-body">
					            	<div class="row">
										<div class="col-lg-12">
											<div class="form-group">
												<label class="col-sm-2 control-label">Select Server</label>
												<div class="col-sm-10">
													<select id="server" name="server" class="form-control select2">
														<option value="" disabled selected>Choose a server</option>
														<?php
															foreach($headends as $headend) {
																echo '<option value="'.$headend['id'].'">'.$headend['name'].'</option>';
															}
														?>
													</select>
												</div>
											</div>
										</div>
									</div>

									<?php if(count($playlists) > 0){ ?>
										<div class="row">
							            	<div class="col-lg-12">
								            	<div class="form-group">
													<label class="col-md-2 control-label" for="remote_playlist">Remote Playlist</label>
													<div class="col-md-10">
														<select id="remote_playlist" name="remote_playlist" class="form-control select2" onchange="stream_add_playlist_get(this.value);">
															<option value="manual">Enter Source URL Manually</option>
															<?php
																foreach($playlists as $playlist) {
																	echo '<option value="'.$playlist['id'].'">'.$playlist['name'].'</option>';
																}
															?>
														</select>
													</div>
												</div>
											</div>
										</div>
									<?php }else{ ?>
										<input type="hidden" name="remote_playlist" value="manual">
									<?php } ?>

									<div class="row">
						            	<div class="col-lg-12">
							            	<div class="form-group">
												<label class="col-md-2 control-label" for="add_stream_url">Source URL</label>
												<div class="col-md-10">
													<span id="manual_source_select">
														<input type="text" class="form-control" id="add_stream_url" name="add_stream_url" placeholder="http://server.com/stream_id">
													</span>
													
													<span id="remote_playlist_source_select" class="hidden">
														<select id="add_stream_url_list" name="add_stream_url_list" class="form-control select2">
														</select>
													</span>
												</div>
											</div>
										</div>
									</div>
									
									<div class="row">
						            	<div class="col-lg-12">
											<div class="form-group">
												<label class="col-md-2 control-label" for="name">Stream Name</label>
												<div class="col-md-10">
													<input type="text" class="form-control" id="name" name="name" placeholder="Stream Name." required="required">
												</div>
											</div>
										</div>
									</div>

									<?php if(count($epg_xml_ids) > 0){ ?>
										<div class="form-group">
											<label class="col-md-2 control-label" for="epg_xml_id">EPG</label>
											<div class="col-md-10">
												<select id="epg_xml_id" name="epg_xml_id" class="form-control select2">
													<option <?php if($stream[0]['epg_xml_id']==''){echo"selected";} ?> value="">None</option>
													<?php
														foreach($epg_xml_ids as $epg_xml_id) {
															echo '<option value="'.$epg_xml_id['xml_id'].'">'.$epg_xml_id['xml_name'].' ( '.$epg_xml_id['xml_id'].' )</option>';
														}
													?>
												</select>
											</div>
										</div>
									<?php }else{ ?>
										<input type="hidden" name="epg_xml_id" value="">
									<?php } ?>

									<div class="row">
						            	<div class="col-lg-12">
											<div class="form-group">
												<label class="col-md-2 control-label" for="channel_icon">Stream Icon</label>
												<div class="col-md-10">
													<input type="text" class="form-control" id="channel_icon" name="channel_icon" placeholder="http://domain.com/channel_icon.png">
												</div>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-lg-12">
											<div class="form-group">
												<label class="col-sm-2 control-label">Select a Category</label>
												<div class="col-sm-10">
													<select id="category_id" name="category_id" class="form-control select2">
														<option value="0">None</option>
														<?php
															foreach($categories as $category) {
																echo '<option value="'.$category['id'].'">'.stripslashes($category['name']).'</option>';
															}
														?>
													</select>
												</div>
											</div>
										</div>
									</div>

									<div class="form-group">
										<label class="col-md-2 control-label" for="ffmpeg_re">Video Read-Native</label>
										<div class="col-md-10">
											<select id="ffmpeg_re" name="ffmpeg_re" class="form-control">
												<option value="no">No</option>
												<option value="yes">Yes</option>
											</select>
										</div>
									</div>
					            </div>
					            <div class="modal-footer">
					                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					                <button type="submit" class="btn btn-success">Add</button>
					            </div>
					        </div>
					    </div>
					</div>
				</form>

				<form action="actions.php?a=import_streams" class="form-horizontal form-bordered" method="post" enctype="multipart/form-data">
					<div class="modal fade" id="import_streams_modal" role="dialog">
					    <div class="modal-dialog modal-lg">
					        <div class="modal-content">
					            <div class="modal-header">
					                <button type="button" class="close" data-dismiss="modal">&times;</button>
					                <h4 class="modal-title">Import Streams</h4>
					            </div>
					            <div class="modal-body">
					            	<div class="row">
						            	<div class="col-lg-12">
							            	<div class="form-group">
												<label class="col-md-2 control-label" for="analyse_stream_url">Playlist File</label>
												<div class="col-md-10">
													<input type="file" id="m3u_file" name="m3u_file" required="" class="form-control">
												</div>
											</div>
										</div>
									</div>
									
									<div class="row">
										<div class="col-lg-12">
											<div class="form-group">
												<label class="col-sm-2 control-label">Select Server</label>
												<div class="col-sm-10">
													<select id="server" name="server" class="form-control">
														<option>Select a Server</option>
														<?php
															foreach($headends as $headend) {
																echo '<option value="'.$headend['id'].'">'.$headend['name'].'</option>';
															}
														?>
													</select>
												</div>
											</div>

											<div class="row">
												<div class="col-lg-12">
													<div class="form-group">
														<label class="col-sm-2 control-label">Select a Category</label>
														<div class="col-sm-10">
															<select id="category_id" name="category_id" class="form-control select2">
																<option value="0">None</option>
																<?php
																	foreach($categories as $category) {
																		echo '<option value="'.$category['id'].'">'.stripslashes($category['name']).'</option>';
																	}
																?>
															</select>
														</div>
													</div>
												</div>
											</div>

											<div class="form-group">
												<label class="col-md-2 control-label" for="ffmpeg_re">Video Read-Native</label>
												<div class="col-md-10">
													<select id="ffmpeg_re" name="ffmpeg_re" class="form-control">
														<option value="no">No</option>
														<option value="yes">Yes</option>
													</select>
												</div>
											</div>
										</div>
									</div>
					            </div>
					            <div class="modal-footer">
					                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					                <button type="submit" class="btn btn-success">Import Streams</button>
					            </div>
					        </div>
					    </div>
					</div>
				</form>

				<form action="actions.php?a=stream_add_output" class="form-horizontal form-bordered" method="post">
					<div class="modal fade" id="new_output_stream_modal" role="dialog">
					    <div class="modal-dialog modal-lg">
					        <div class="modal-content">
					            <div class="modal-header">
					                <button type="button" class="close" data-dismiss="modal">&times;</button>
					                <h4 class="modal-title">Add New Output Stream</h4>
					            </div>
					            <div class="modal-body">
					            	<div class="row">
										<div class="col-lg-12">
											<div class="form-group">
												<label class="col-sm-2 control-label">Source</label>
												<div class="col-sm-10">
													<select id="source_id" name="source_id" class="form-control select2">
														<option>Select a Source</option>
														<?php
															$query = $conn->query("SELECT `id`,`name`,`server_id`,`source_type` FROM `streams` WHERE `user_id` = '".$_SESSION['account']['id']."' AND `stream_type` = 'input' ORDER BY `source_type`,`name` ASC");
															if($query !== FALSE) {
																$add_streams = $query->fetchAll(PDO::FETCH_ASSOC);
																foreach($add_streams as $stream) {
																	// get headend name
																	$query = $conn->query("SELECT `id`,`name` FROM `headend_servers` WHERE `id` = '".$stream['server_id']."' ");
																	$stream['headend'] = $query->fetch(PDO::FETCH_ASSOC);
																	echo '<option value="'.$stream['id'].'">'.strtoupper($stream['source_type']).' | '.stripslashes($stream['name']).' on '.$stream['headend']['name'].'</option>';
																}
															}
														?>
													</select>
												</div>
											</div>
										</div>
									</div>
									
									<div class="row">
						            	<div class="col-lg-12">
											<div class="form-group">
												<label class="col-md-2 control-label" for="name">Stream Name</label>
												<div class="col-md-10">
													<input type="text" class="form-control" id="name" name="name" placeholder="Stream Name." required="required">
												</div>
											</div>
										</div>
									</div>
					            </div>
					            <div class="modal-footer">
					                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					                <button type="submit" class="btn btn-success">Add</button>
					            </div>
					        </div>
					    </div>
					</div>
				</form>
				
                <div id="status_message"></div>
                            	
                <section class="content-header">
                    <h1>Live TV Streams <!-- <small>Optional description</small> --></h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="dashboard.php">Dashboard</a></li>
                        <li class="active">Live TV Streams</li>
                    </ol>
                </section>

                <!-- Main content -->
				<section class="content">
					<div class="row">
						<div class="col-lg-12">
							<div class="box box-primary">
								<div class="box-body">
									<div class="form-inline pull-right">
										<!-- 
										<a href="actions.php?a=export_m3u" class="btn btn-primary btn-flat">
											<i class="fas fa-download"></i> Download Playlist
										</a>
										-->

										<a href="actions.php?a=streams_restart_all" class="btn btn-warning btn-flat btn-xs" onclick="return confirm('Are you sure? \nPlease allow up to 5 minutes for all streams to restart.')">
											<i class="fas fa-sync"></i> Restart All Streams
										</a>
										<a href="actions.php?a=streams_stop_all" class="btn btn-danger btn-flat btn-xs" onclick="return confirm('Are you sure? \nPlease allow up to 2 minutes for all streams to stop.')">
											<i class="fas fa-pause"></i> Stop All Streams
										</a>
										<a href="actions.php?a=streams_start_all" class="btn btn-success btn-flat btn-xs" onclick="return confirm('Are you sure? \nPlease allow up to 5 minutes for all streams to start.')">
											<i class="fas fa-play"></i> Start All Streams
										</a>
										<!-- <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#analyse_stream_modal">Analyse Stream</button> -->
										<select id="server" name="server" class="form-control" onchange="streams_set_server(this);">
											<option value="">Filter by Server / Reset</option>
											<?php
												foreach($headends as $headend) {
													echo '<option value="'.$headend['id'].'" '.($server_id==$headend['id'] ? 'selected' : '').'>'.$headend['name'].'</option>';
												}
											?>
										</select>
										<select id="source_domain" name="source_domain" class="form-control" onchange="streams_set_domain(this);">
											<option value="">Filter by Source Domain / Reset</option>
											<?php
												if(is_array($streams)) {
													$source_urls = array();
													foreach($streams as $stream) {
														$source_url 	= parse_url($stream['source'], PHP_URL_HOST);
														$source_urls[] 	= $source_url;
													}

													if(isset($source_urls[0])) {
														$source_urls_count = array_count_values($source_urls);

														foreach($source_urls_count as $key => $value) {
															echo '<option value="'.$key.'" '.($source_domain==$key ? 'selected' : '').'>'.$key.'</option>';
												        }
													}
											    }
											?>
										</select>
										<a href="dashboard.php?c=streams&source_domain=&server_id=" class="btn btn-warning btn-flat btn-xs">
											Reset Filters
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>

					<form id="stream_update_multi" action="actions.php?a=stream_multi_options" method="post">
						<div class="row">
							<div id="multi_options_show" class="col-md-4 hidden">
								<div class="box box-default">
									<div class="box-header with-border">
										<h3 class="box-title">
											Multi Stream Options
										</h3>

										<div class="box-tools pull-right">
											<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
											</button>
										</div>
									</div>
									<div class="box-body">
										<div class="row">
											<div class="col-lg-12">
												<div class="form-group">
													<label class="col-sm-3 control-label">Action</label>
													<div class="col-sm-9">
														<select id="multi_options_action" name="multi_options_action" class="form-control" onchange="multi_options_select(this.value);">
															<optgroup label="Start / Stop">
																<option value="start">Start Selected Streams</option>
																<option value="restart">Restart Selected Streams</option>
																<option value="stop">Stop Selected Streams</option>
															</optgroup>
															<optgroup label="Delete">
																<option value="delete">Delete Selected Streams</option>
															</optgroup>
															<optgroup label="Modify">
																<option value="change_server">Change Streaming Server</option>
																<option value="change_category">Change Category</option>
																<option value="enable_ondemand">Set to On-Demand</option>
																<option value="enable_always_on">Set to Always On</option>
															</optgroup>
														</select>

														<small>This action inlcudes both Input and Output streams.</small>
													</div>
												</div>
											</div>
										</div>

										<div class="row hidden" id="multi_options_change_server">
											<hr>
											<div class="col-lg-12">
												<div class="form-group">
													<label class="col-sm-3 control-label">Server</label>
													<div class="col-sm-9">
														<select id="server" name="server" class="form-control">
															<option>Select a Server</option>
															<?php
																foreach($headends as $headend) {
																	echo '<option value="'.$headend['id'].'">'.$headend['name'].'</option>';
																}
															?>
														</select>
														<small>Please note that this will assign both input and output streams to the selected server.</small>
													</div>
												</div>
											</div>
										</div>

										<div class="row hidden" id="multi_options_change_category">
											<hr>
											<div class="col-lg-12">
												<div class="form-group">
													<label class="col-sm-3 control-label">Category</label>
													<div class="col-sm-9">
														<select id="category_id" name="category_id" class="form-control select2">
															<option value="0">No Category</option>
															<?php
																foreach($categories as $category) {
																	echo '<option value="'.$category['id'].'">'.$category['name'].'</option>';
																}
															?>
														</select>
														<small>This will update the category for each selected stream and its related output streams.</small>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="box-footer">
										<button type="submit" class="btn btn-success pull-right">Go</button>
									</div>
								</div>
							</div>

							<div class="col-md-3">
								<div class="box box-default collapsed-box">
									<div class="box-header with-border">
										<h3 class="box-title">
											Source Tools 
											<a href="#" data-toggle="modal" data-target="#help_streams_source_summary">
												<i class="fas fa-question-circle"></i>
											</a>
										</h3>

										<div class="box-tools pull-right">
											<button type="button" class="btn btn-success btn-xs btn-flat" data-toggle="modal" data-target="#bulk_update_sources">Bulk Update Source</button>
											<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
											</button>
										</div>
									</div>
									<div class="box-body">
										<?php
											if(is_array($streams)) {
												$source_url = '';
												foreach($streams as $stream) {
													$source_url = parse_url($stream['source'], PHP_URL_HOST);
													$source_urls[] = $source_url;
												}

												// print_r($source_urls);

												$source_urls_count = array_count_values($source_urls);
											}
										?>
										
										<table id="stream_sources" class="table table-bordered table-striped" style="width:100%">
									        <thead>
									            <tr>
									                <th width="1px">Total</th>
									                <th>Source Domain</th>
									            </tr>
									        </thead>
									        <tbody>
									        	<?php
									        		foreach($source_urls_count as $key => $value) {
												        echo '<tr>
												                <td class="no-sort" width="1px">'.number_format($value / 2).'</td>
												                <td>'.$key.'</td>    
												            </tr>';
											        }
											    ?>
									        </tbody>
									    </table>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-12">
								<div class="box box-primary">
			            			<div class="box-header">
			              				<h3 class="box-title">
			              					Live TV Streams 
			              					<a href="#" data-toggle="modal" data-target="#help_streams">
												<i class="fas fa-question-circle"></i>
											</a>
			              				</h3>
			              				<div class="pull-right">
			              					<a href="actions.php?a=delete_all&type=streams" class="btn btn-danger btn-xs btn-flat" onclick="return confirm('Are you sure?')">Delete All</a>
											<button type="button" class="btn btn-success btn-xs btn-flat" data-toggle="modal" data-target="#new_stream_modal">New Input Stream</button>
											<button type="button" class="btn btn-default btn-xs btn-flat" data-toggle="modal" data-target="#import_streams_modal">Import Input Streams</button>
											<button type="button" class="btn btn-primary btn-xs btn-flat" data-toggle="modal" data-target="#new_output_stream_modal">New Output Stream</button>
										</div>
			            			</div>
									<div class="box-body">
										<table id="example" class="display" style="width:100%">
									        <thead>
									            <tr>
									                <th class="no-sort" width="1px">
									                	<input type="checkbox" id="checkAll" />
									                </th>
									                <th class="no-sort" width="1px"></th>
									                <th width="1px">Type</th>
									                <th style="white-space: nowrap;">Stream Name</th>
									                <th style="white-space: nowrap;" width="100px">Category</th>
									                <th class="no-sort" width="1px">Uptime</th>
									                <th class="no-sort" width="1px">FPS</th>
									                <th class="no-sort" width="1px">Speed</th>
									                <th class="no-sort" width="50px">Bitrate</th>
									                <th class="no-sort" width="1px">Aspect</th>
									                <th class="no-sort" width="1px">Audio</th>
									                <th class="no-sort" width="1px">Video</th>
									                <th class="no-sort" width="1px">Outputs</th>
									                <th class="no-sort" width="1px">Status</th>
									            </tr>
									        </thead>
									        <tfoot>
									            <tr>
									                <th class="no-sort" width="1px">
									                	<input type="checkbox" id="checkAll" />
									                </th>
									                <th class="no-sort" width="1px"></th>
									                <th width="1px">Type</th>
									                <th style="white-space: nowrap;">Stream Name</th>
									                <th style="white-space: nowrap;" width="100px">Category</th>
									                <th class="no-sort" width="1px">Uptime</th>
									                <th class="no-sort" width="1px">FPS</th>
									                <th class="no-sort" width="1px">Speed</th>
									                <th class="no-sort" width="50px">Bitrate</th>
									                <th class="no-sort" width="1px">Aspect</th>
									                <th class="no-sort" width="1px">Audio</th>
									                <th class="no-sort" width="1px">Video</th>
									                <th class="no-sort" width="1px">Outputs</th>
									                <th class="no-sort" width="1px">Status</th>
									            </tr>
									        </tfoot>
									    </table>
									</div>
								</div>
							</div>
						</div>
					</form>
				</section>
            </div>
        <?php } ?>

        <?php function stream(){ ?>
        	<?php 
        		global $conn, $wp, $global_settings, $account_details, $site, $whmcs, $product_ids;
            
            	sanity_check();
            
            	$stream_id 						= get('stream_id');

				$query 							= $conn->query("SELECT * FROM `streams` WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
				$stream 						= $query->fetchAll(PDO::FETCH_ASSOC);

				if($stream[0]['stream_type'] == 'input'){
					$sources 					= explode(",", $stream[0]['source']);
				}

				$query 							= $conn->query("SELECT `id`,`name`,`wan_ip_address` FROM `headend_servers` ORDER BY `name` ");
				$headends 						= $query->fetchAll(PDO::FETCH_ASSOC);

				if($stream[0]['stream_type'] == 'output'){ 
					$query 						= $conn->query("SELECT `id`,`name` FROM `streams` WHERE `id` = '".$stream[0]['source_stream_id']."' ");
					$source_stream 				= $query->fetch(PDO::FETCH_ASSOC);

					$query 						= $conn->query("SELECT * FROM `transcoding_profiles` WHERE `user_id` = '".$_SESSION['account']['id']."' ORDER BY `name` ");
					$transcoding_profiles 		= $query->fetchAll(PDO::FETCH_ASSOC);
				}

				$query 							= $conn->query("SELECT * FROM `headend_servers` WHERE `id` = '".$stream[0]['server_id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
				$headend 						= $query->fetchAll(PDO::FETCH_ASSOC);
				$headend[0]['gpu_stats'] 		= json_decode($headend[0]['gpu_stats'], true);

				$dehash_padding 				= explode('-', $stream[0]['dehash_padding']);
				$stream[0]['dehash_padding']	= '';
				$stream[0]['dehash_padding']	= $dehash_padding;

				$dehash_scale 					= explode('-', $stream[0]['dehash_scale']);
				$stream[0]['dehash_scale']		= '';
				$stream[0]['dehash_scale']		= $dehash_scale;

				// get epg source
				$query 							= $conn->query("SELECT * FROM `epg_xml_ids` ");
				$epg_xml_ids 					= $query->fetchAll(PDO::FETCH_ASSOC);
			?>

            <div class="content-wrapper">
				
                <div id="status_message"></div>
                            	
                <section class="content-header">
                    <h1>Stream <!-- <small>Optional description</small> --></h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="dashboard.php">Dashboard</a></li>
                        <li class="active"><a href="dashboard.php?c=streams">Streams</a></li>
                        <li class="active">Stream</li>
                    </ol>
                </section>

                <!-- Main content -->
                <?php if($stream[0]['user_id'] != $_SESSION['account']['id']) { ?>
					<section class="content">
						<div class="row">
							<div class="col-lg-12">
								<div class="box box-danger">
			            			<div class="box-header">
			              				<h3 class="box-title">
			              					ERROR
			              				</h3>
			            			</div>
									<div class="box-body">
										<h3>There was an error loading this content.</h3>
										You don't own this stream. This security breach has been reported to our security team.

										<?php if(isset($_GET['dev'])) { ?>
											<hr>
											<pre>
												<?php print_r($stream_raw); ?>
											</pre>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</section>
				<?php }else{ ?>
					<section class="content">
						<div class="row">
							<?php if($stream[0]['pending_changes'] == 'yes') { ?>
								<div class="col-lg-12">
									<div class="callout callout-warning">
										You have pending changes that need to be applied. Please use the 'Apply Changes' button to apply your changes.
									</div>
								</div>
							<?php } ?>
							
							<div class="col-lg-6">
								<div class="box box-primary">
			            			<div class="box-header">
			              				<h3 class="box-title">
			              					Stream > <?php echo stripslashes($stream[0]['name']); ?>
			              				</h3>
			              				<div class="pull-right">
			              					<?php if($stream[0]['pending_changes'] == 'yes') { ?>
			              						<a href="actions.php?a=stream_restart&stream_id=<?php echo $stream_id; ?>" class="btn btn-primary btn-xs btn-flat" onclick="return confirm('Please allow up to 5 minutes for stream to restart and your changes to take effect.')">
													<i class="fas fa-sync"></i> 
													Apply Changes
												</a>
			              					<?php }else{ ?>
			              						<a href="actions.php?a=stream_restart&stream_id=<?php echo $stream_id; ?>" class="btn btn-warning btn-xs btn-flat" onclick="return confirm('Are you sure? \nPlease allow up to 5 minutes for stream to restart.')">
													<i class="fas fa-sync"></i> 
													Restart Stream
												</a>
			              					<?php } ?>
											<a href="actions.php?a=stream_stop&stream_id=<?php echo $stream_id; ?>" class="btn btn-danger btn-xs btn-flat" onclick="return confirm('Please allow up to 2 minutes for stream to stop.')">
												<i class="fas fa-pause"></i> 
												Stop Stream
											</a>
											<a href="actions.php?a=stream_start&stream_id=<?php echo $stream_id; ?>" class="btn btn-success btn-xs btn-flat" onclick="return confirm('Please allow up to 5 minutes for stream to start.')">
												<i class="fas fa-play"></i> 
												Start Stream
											</a>
										</div>
			            			</div>
									<div class="box-body">
										<form action="actions.php?a=stream_update" class="form-horizontal form-bordered" method="post">
											<input type="hidden" name="stream_id" value="<?php echo $stream_id; ?>">
											<input type="hidden" name="stream_type" value="<?php echo $stream[0]['stream_type']; ?>">
											<div class="row">
												<div class="col-lg-12">
													<section class="panel">
														<header class="panel-heading">
															<div class="panel-actions"></div>
															<h2 class="panel-title">General Settings</h2>
														</header>
														<div class="panel-body">
															<?php if(isset($_GET['dev']) && $_GET['dev'] == 'yes') { ?>
																<pre>
																	<?php print_r($stream); ?>
																	<?php print_r($headend); ?>
																	<?php print_r($headends); ?>
																</pre>
															<?php } ?>

															<!-- status -->
															<div class="form-group">
																<label class="col-md-3 control-label" for="enable">Stream Status</label>
																<div class="col-md-9">
																	<select id="enable" name="enable" class="form-control">
																		<option <?php if($stream[0]['enable']=='no'){echo"selected";} ?> value="no">Disable Stream</option>
																		<option <?php if($stream[0]['enable']=='yes'){echo"selected";} ?> value="yes">Enable Stream</option>
																	</select>
																</div>
															</div>

															<!-- server -->
															<input type="hidden" name="server_id" value="<?php echo $stream[0]['server_id']; ?>">
															<!-- 
															<div class="row">
																<div class="col-lg-12">
																	<div class="form-group">
																		<label class="col-md-3 control-label" for="server_id">Server</label>
																		<div class="col-sm-9">
																			<select id="server_id" name="server_id" class="form-control">
																				<?php foreach($headends as $select_headend){ ?>
																					<option <?php if($stream[0]['server_id']==$select_headend['id']){echo"selected";} ?> value="<?php echo $select_headend['id']; ?>"><?php echo stripslashes($select_headend['name']).' ('.$select_headend['wan_ip_address'].')'; ?></option>
																				<?php } ?>
																			</select>
																		</div>
																	</div>
																</div>
															</div>
															-->

															<!-- name -->
															<div class="form-group">
																<label class="col-md-3 control-label" for="name">Name</label>
																<div class="col-md-9">
																	<input type="text" class="form-control" id="name" name="name" value="<?php echo stripslashes($stream[0]['name']); ?>" required>
																</div>
															</div>

															<!-- play direct or restream -->
															<div class="form-group">
																<label class="col-md-3 control-label" for="direct">Direct to Source</label>
																<div class="col-md-9">
																	<select id="direct" name="direct" class="form-control" onchange="direct_or_restream(this);">
																		<option <?php if($stream[0]['direct']=='no'){echo"selected";} ?> value="no">No (restream this source)</option>
																		<option <?php if($stream[0]['direct']=='yes'){echo"selected";} ?> value="yes">Yes (forward customer to source directly)</option>
																	</select>
																</div>
															</div>

															<span id="restream_options_1" class="<?php if($stream[0]['direct']=='yes'){echo"hidden"; } ?>">
																<!-- user agent -->
																<div class="form-group">
																	<label class="col-md-3 control-label" for="user_agent">User Agent</label>
																	<div class="col-md-9">
																		<input type="text" class="form-control" id="user_agent" name="user_agent" value="<?php echo stripslashes($stream[0]['user_agent']); ?>" placeholder="Leave blank for system default.">
																	</div>
																</div>

																<div class="form-group">
																	<label class="col-md-3 control-label" for="ffmpeg_re">Video Read-Native</label>
																	<div class="col-md-9">
																		<select id="ffmpeg_re" name="ffmpeg_re" class="form-control">
																			<option <?php if($stream[0]['ffmpeg_re']=='no'){echo"selected";} ?> value="no">No</option>
																			<option <?php if($stream[0]['ffmpeg_re']=='yes'){echo"selected";} ?> value="yes">Yes</option>
																		</select>
																	</div>
																</div>

																<div class="form-group">
																	<label class="col-md-3 control-label" for="deint">De-Interlace</label>
																	<div class="col-md-9">
																		<select id="deint" name="deint" class="form-control">
																			<option <?php if($stream[0]['deint']=='no'){echo"selected";} ?> value="no">No</option>
																			<option <?php if($stream[0]['deint']=='yes'){echo"selected";} ?> value="yes">Yes</option>
																		</select>
																	</div>
																</div>
															</span>

															<?php if($stream[0]['stream_type'] == 'input') { ?>
																<!-- ondemand -->
																<div class="form-group">
																	<label class="col-md-3 control-label" for="ondemand">On-Demand</label>
																	<div class="col-md-9">
																		<select id="ondemand" name="ondemand" class="form-control">
																			<option <?php if($stream[0]['ondemand']=='no'){echo"selected";} ?> value="no">No</option>
																			<option <?php if($stream[0]['ondemand']=='yes'){echo"selected";} ?> value="yes">Yes</option>
																		</select>
																	</div>
																</div>

																<!-- source type -->
																<div class="form-group">
																	<label class="col-md-3 control-label" for="source_type">Source Type</label>
																	<div class="col-md-9">
																		<select id="source_type" name="source_type" class="form-control">
																			<!-- <option <?php if($stream[0]['source_type']=='hidden'){echo"selected";} ?> value="hidden">Hide from Customers</option> -->
																			<option <?php if($stream[0]['source_type']=='restream'){echo"selected";} ?> value="restream">Restream</option>
																			<option <?php if($stream[0]['source_type']=='direct'){echo"selected";} ?> value="direct">Direct</option>
																			<option <?php if($stream[0]['source_type']=='cdn'){echo"selected";} ?> value="cdn">CDN</option>
																		</select>
																	</div>
																</div>

																<!-- epg -->
																<div class="form-group">
																	<label class="col-md-3 control-label" for="epg_xml_id">EPG</label>
																	<div class="col-md-9">
																		<select id="epg_xml_id" name="epg_xml_id" class="form-control select2">
																			<option <?php if($stream[0]['epg_xml_id']==''){echo"selected";} ?> value="">None</option>
																			<?php
																			foreach($epg_xml_ids as $epg_xml_id) {
																				echo '<option '.($stream[0]['epg_xml_id']==$epg_xml_id['xml_id']?'selected':'').' value="'.$epg_xml_id['xml_id'].'">'.$epg_xml_id['xml_name'].' ( '.$epg_xml_id['xml_id'].' )</option>';
																			}
																			?>
																		</select>
																	</div>
																</div>

																<!-- category -->
																<div class="form-group">
																	<label class="col-sm-3 control-label" for="category_id">Category</label>
																	<div class="col-sm-9">
																		<select id="category_id" name="category_id" class="form-control select2">
																			<option <?php if($stream[0]['category_id']=='0'){echo"selected";} ?> value="0">None</option>
																			<?php
																			$query = $conn->query("SELECT * FROM `stream_categories` WHERE `user_id` = '".$_SESSION['account']['id']."' ORDER BY `name` ASC");
																			if($query !== FALSE) {
																				$categories = $query->fetchAll(PDO::FETCH_ASSOC);
																				foreach($categories as $category) {
																					echo '<option '.($stream[0]['category_id']==$category['id']?'selected':'').' value="'.$category['id'].'">'.$category['name'].'</option>';
																				}
																			}
																			?>
																		</select>
																	</div>
																</div>

																<!-- icon -->
																<div class="form-group">
																	<label class="col-md-3 control-label" for="logo">Stream Icon</label>
																	<div class="col-md-9">
																		<input type="text" class="form-control" id="logo" name="logo" value="<?php echo stripslashes($stream[0]['logo']); ?>">
																	</div>
																</div>

																<?php if(!empty($stream[0]['logo'])) { ?>
																	<div class="form-group">
																	<label class="col-md-3 control-label" for="logo">Stream Icon Demo</label>
																	<div class="col-md-9">
																		<center>
																			<img src="<?php echo $stream[0]['logo']; ?>" width="250px" alt="">
																		</center>
																	</div>
																</div>
																<?php } ?>
															<?php }else{ ?>
																<!-- source -->
																<div class="form-group">
																	<label class="col-sm-3 control-label" for="source_stream_id">Source Stream</label>
																	<div class="col-sm-9">
																		<select id="source_stream_id" name="source_stream_id" class="form-control">
																			<?php
																			$query = $conn->query("SELECT `id`,`name`,`server_id`,`source_type` FROM `streams` WHERE `user_id` = '".$_SESSION['account']['id']."' AND `stream_type` = 'input' ORDER BY `source_type`,`name` ASC");
																			if($query !== FALSE) {
																				$streams = $query->fetchAll(PDO::FETCH_ASSOC);
																				foreach($streams as $source_stream) {
																					// get headend name
																					$query = $conn->query("SELECT `id`,`name` FROM `headend_servers` WHERE `id` = '".$source_stream['server_id']."'  ");
																					$source_stream['headend'] = $query->fetch(PDO::FETCH_ASSOC);
																					echo '<option '.($stream[0]['source_stream_id']==$source_stream['id']?'selected':'').' value="'.$source_stream['id'].'">'.stripslashes($source_stream['name']).' on '.$source_stream['headend']['name'].'</option>';
																				}
																			}
																			?>
																		</select>
																	</div>
																</div>

																<span id="restream_options_2" class="<?php if($stream[0]['direct']=='yes'){echo"hidden"; } ?>">
																	<header class="panel-heading">
																		<div class="panel-actions"></div>
																		<h2 class="panel-title">Restream / Transcoding Settings</h2>
																	</header>
																	<div class="panel-body">
																		<div class="form-group">
																			<label class="col-md-3 control-label" for="transcoding_profile_id">Choose One</label>
																			<div class="col-md-9">
																				<select id="transcoding_profile_id" name="transcoding_profile_id" class="form-control" onchange="stream_set_transcode_or_restream(this);">
																					<option <?php if($stream[0]['transcoding_profile_id']=='0'){echo"selected";} ?> value="0">Manual Settings</option>
																					<?php 
																						if(is_array($transcoding_profiles)) {
																							foreach ($transcoding_profiles as $transcoding_profile) {
																								$transcoding_profile['data'] = json_decode($transcoding_profile['data'], true);

																								if($transcoding_profile['data']['bitrate'] == 0){
																									$transcoding_profile['data']['bitrate'] = 'Copy Bitrate';
																								}else{
																									$transcoding_profile['data']['bitrate'] = ($transcoding_profile['data']['bitrate'] / 1024) . ' Mbit';
																								}
																								?>
																									<option <?php if($transcoding_profile['id']==$stream[0]['transcoding_profile_id']){echo"selected";} ?> value="<?php echo $transcoding_profile['id']; ?>"><?php echo $transcoding_profile['name']; ?> @ <?php echo $transcoding_profile['data']['bitrate']; ?></option>
																								<?php
																							}
																						}
																					?>
																				</select>
																			</div>
																		</div>

																		<div id="manual_transcoding_options" class="<?php if($stream[0]['transcoding_profile_id'] != '0'){echo 'hidden';} ?>">
																			<header class="panel-heading">
																				<div class="panel-actions"></div>
																				<h2 class="panel-title">Video Settings</h2>
																			</header>
																			<div class="panel-body">
																				<div class="form-group">
																					<label class="col-md-3 control-label" for="cpu_gpu">Copy or Transcode</label>
																					<div class="col-md-9">
																						<select id="cpu_gpu" name="cpu_gpu" class="form-control" onchange="stream_set_transcode_hardware(this);">
																							<option <?php if($stream[0]['cpu_gpu']=='copy'){echo"selected";} ?> value="copy">Copy / Pass-Through</option>
																							<option <?php if($stream[0]['cpu_gpu']=='cpu'){echo"selected";} ?> value="cpu">CPU / Processor</option>
																							<?php 
																								if(is_array($headend[0]['gpu_stats'])) {
																									?>
																										<option <?php if($stream[0]['cpu_gpu']=='gpu'){echo"selected";} ?> value="gpu">NVIDIA GPU</option>
																									<?php
																								}
																							?>
																						</select>
																					</div>
																				</div>

																				<div id="stream_cpu_options" class="<?php if($stream[0]['cpu_gpu'] != 'cpu'){ echo 'hidden'; } ?>">
																					<div class="form-group">
																						<label class="col-md-3 control-label" for="cpu_video_codec">Video Codec</label>
																						<div class="col-md-9">
																							<select id="cpu_video_codec" name="cpu_video_codec" class="form-control">
																								<option <?php if($stream[0]['video_codec']=='libx264'){echo"selected";} ?> value="libx264">H.264 (libx264)</option>
																								<option <?php if($stream[0]['video_codec']=='libx265'){echo"selected";} ?> value="libx265">H.265 (libx265)</option>
																							</select>
																						</div>
																					</div>
																				</div>

																				<div id="stream_gpu_options" class="<?php if($stream[0]['cpu_gpu'] != 'gpu'){ echo 'hidden'; } ?>">
																					<div class="form-group">
																						<label class="col-md-3 control-label" for="gpu">GPU Selection</label>
																						<div class="col-md-9">
																							<select id="gpu" name="gpu" class="form-control">
																								<?php 
																									foreach($headend[0]['gpu_stats']['gpu'] as $gpu){
																										// $gpu['used_ram'] = str_replace(" MiB", "", $gpu['used_ram']);
																										// $gpu['total_ram'] = str_replace(" MiB", "", $gpu['total_ram']);
																										?>
																											<option <?php if($gpu['id']==$stream[0]['gpu']){echo"selected";} ?> value="<?php echo $gpu['id']; ?>">GPU: <?php echo $gpu['id']; ?> - <?php echo $gpu['gpu_name']; ?> 
																												(<?php echo percentage($gpu['used_ram'], $gpu['total_ram'], 2); ?>% used)
																											</option>
																										<?php
																									}
																								?>
																							</select>
																						</div>
																					</div>

																					<div class="form-group">
																						<label class="col-md-3 control-label" for="gpu_video_codec">Video Codec</label>
																						<div class="col-md-9">
																							<select id="gpu_video_codec" name="gpu_video_codec" class="form-control">
																								<option <?php if($stream[0]['video_codec']=='h264_nvenc'){echo"selected";} ?> value="h264_nvenc">H.264 (h264_nvenc)</option>
																								<option <?php if($stream[0]['video_codec']=='hevc_nvenc'){echo"selected";} ?> value="hevc_nvenc">H.265 (hevc_nvenc)</option>
																							</select>
																						</div>
																					</div>

																					<div class="form-group">
																						<label class="col-md-3 control-label" for="surfaces">Video Surfaces</label>
																						<div class="col-md-9">
																							<input type="text" class="form-control" id="surfaces" name="surfaces" value="<?php echo stripslashes($stream[0]['surfaces']); ?>" placeholder="Leave blank for system default.">
																						</div>
																					</div>
																				</div>

																				<div id="transcode_options" class="<?php if($stream[0]['cpu_gpu']=='copy') {echo 'hidden'; } ?>">
																					<div class="form-group">
																						<label class="col-md-3 control-label" for="framerate">Video Framerate</label>
																						<div class="col-md-9">
																							<input type="text" class="form-control" id="framerate" name="framerate" value="<?php echo $stream[0]['framerate']; ?>" placeholder="Leave blank to copy source">
																						</div>
																					</div>

																					<div class="form-group">
																						<label class="col-md-3 control-label" for="preset">Video Preset</label>
																						<div class="col-md-9">
																							<select id="preset" name="preset" class="form-control">
																								<option <?php if($stream[0]['preset']=='0'){echo"selected";} ?> value="0">Default</option>
																								
																								<option <?php if($stream[0]['preset']=='1'){echo"selected";} ?> value="1">Slow</option>
																								<option <?php if($stream[0]['preset']=='2'){echo"selected";} ?> value="2">Medium</option>
																								<option <?php if($stream[0]['preset']=='3'){echo"selected";} ?> value="3">Fast</option>

																								<option <?php if($stream[0]['preset']=='4'){echo"selected";} ?> value="4">High Performance</option>
																								<option <?php if($stream[0]['preset']=='5'){echo"selected";} ?> value="5">High Quality</option>
																								<!-- <option <?php if($stream[0]['preset']=='6'){echo"selected";} ?> value="6">bd</option> -->
																								<option <?php if($stream[0]['preset']=='7'){echo"selected";} ?> value="7">Low Latency</option>
																								<option <?php if($stream[0]['preset']=='8'){echo"selected";} ?> value="8">Low Latency High Quality</option>
																								<option <?php if($stream[0]['preset']=='9'){echo"selected";} ?> value="9">Low Latency High Performance</option>
																								<option <?php if($stream[0]['preset']=='10'){echo"selected";} ?> value="10">Lossless</option>
																								<option <?php if($stream[0]['preset']=='11'){echo"selected";} ?> value="11">Lossless High Quality</option>
																							</select>
																						</div>
																					</div>
																					
																					<div class="form-group">
																						<label class="col-md-3 control-label" for="profile">Video Profile</label>
																						<div class="col-md-9">
																							<select id="profile" name="profile" class="form-control">
																								<optgroup label="H264 Profiles">
																									<option <?php if($stream[0]['profile']=='baseline'){echo"selected";} ?> value="baseline">Baseline</option>
																									<option <?php if($stream[0]['profile']=='main'){echo"selected";} ?> value="main">Main</option>
																									<option <?php if($stream[0]['profile']=='high'){echo"selected";} ?> value="high">High</option>
																									<option <?php if($stream[0]['profile']=='high444p'){echo"selected";} ?> value="high444p">High444p</option>
																								</optgroup>
																								<optgroup label="H265 Profiles">
																									<option <?php if($stream[0]['profile']=='main'){echo"selected";} ?> value="main">Main</option>
																									<option <?php if($stream[0]['profile']=='main10'){echo"selected";} ?> value="main10">Main10</option>
																									<option <?php if($stream[0]['profile']=='rext'){echo"selected";} ?> value="rext">Rext</option>
																								</optgroup>
																							</select>
																							<!-- <small>Please Note: 'baseline' is not available for H.265 video codec for either CPU or GPU.</small> -->
																						</div>
																					</div>

																					<div class="form-group">
																						<label class="col-md-3 control-label" for="screen_resolution">Screen Resolution</label>
																						<div class="col-md-9">
																							<select id="screen_resolution" name="screen_resolution" class="form-control" >
																								<option <?php if($stream[0]['screen_resolution']=='copy'){echo"selected";} ?> value="copy">Copy Source</option>
																								<!--
																								<option <?php if($stream[0]['screen_resolution']=='1920x1080'){echo"selected";} ?> value="1920x1080">1920x1080</option>
															                                    <option <?php if($stream[0]['screen_resolution']=='1680x1056'){echo"selected";} ?> value="1680x1056">1680x1056</option>
															                                    <option <?php if($stream[0]['screen_resolution']=='1280x720'){echo"selected";} ?> value="1280x720">1280x720</option>
															                                    <option <?php if($stream[0]['screen_resolution']=='1024x576'){echo"selected";} ?> value="1024x576">1024x576</option>
															                                    <option <?php if($stream[0]['screen_resolution']=='850x480'){echo"selected";} ?> value="850x480">850x480</option>
															                                    <option <?php if($stream[0]['screen_resolution']=='720x576'){echo"selected";} ?> value="720x576">720x576</option>
															                                    <option <?php if($stream[0]['screen_resolution']=='720x540'){echo"selected";} ?> value="720x540">720x540</option>
															                                    <option <?php if($stream[0]['screen_resolution']=='720x480'){echo"selected";} ?> value="720x480">720x480</option>
															                                    <option <?php if($stream[0]['screen_resolution']=='720x404'){echo"selected";} ?> value="720x404">720x404</option>
															                                    <option <?php if($stream[0]['screen_resolution']=='704x576'){echo"selected";} ?> value="704x576">704x576</option>
															                                    <option <?php if($stream[0]['screen_resolution']=='640x480'){echo"selected";} ?> value="640x480">640x480</option>
															                                    <option <?php if($stream[0]['screen_resolution']=='640x360'){echo"selected";} ?> value="640x360">640x360</option>
															                                    <option <?php if($stream[0]['screen_resolution']=='320x240'){echo"selected";} ?> value="320x240">320x240</option>
															                                    <option <?php if($stream[0]['screen_resolution']=='1600x1200'){echo"selected";} ?> value="1600x1200">1600x1200</option>
															                                    <option <?php if($stream[0]['screen_resolution']=='1280x960'){echo"selected";} ?> value="1280x960">1280x960</option>
															                                    <option <?php if($stream[0]['screen_resolution']=='1152x864'){echo"selected";} ?> value="1152x864">1152x864</option>
															                                    <option <?php if($stream[0]['screen_resolution']=='1024x768'){echo"selected";} ?> value="1024x768">1024x768</option>
															                                    <option <?php if($stream[0]['screen_resolution']=='800x600'){echo"selected";} ?> value="800x600">800x600</option>
															                                    --> 

															                                    <option <?php if($stream[0]['screen_resolution']=='3840x2160'){echo"selected";} ?> value="7680x4320">8k - 7680x4320</option>
															                                    <option <?php if($stream[0]['screen_resolution']=='3840x2160'){echo"selected";} ?> value="4096x2160">4K - 4096x2160</option>
															                                    <option <?php if($stream[0]['screen_resolution']=='3840x2160'){echo"selected";} ?> value="3840x2160">4K - 3840x2160</option>
															                                    <option <?php if($stream[0]['screen_resolution']=='1920x1080'){echo"selected";} ?> value="1920x1080">FHD - 1920x1080</option>
															                                    <option <?php if($stream[0]['screen_resolution']=='1280x720'){echo"selected";} ?> value="1280x720">HD - 1280x720</option>
															                                    <option <?php if($stream[0]['screen_resolution']=='768x576'){echo"selected";} ?> value="768x576">SD - 768x576</option>
															                                    <option <?php if($stream[0]['screen_resolution']=='640x480'){echo"selected";} ?> value="640x480">SD - 640x480</option>
																							</select>
																						</div>
																					</div>

																					<div class="form-group">
																						<label class="col-md-3 control-label" for="bitrate">Video Bitrate (k)</label>
																						<div class="col-md-9">
																							<input type="number" class="form-control" id="bitrate" name="bitrate" value="<?php echo $stream[0]['bitrate']; ?>" placeholder="2000">
																						</div>
																					</div>
																				</div>
																			</div>

																			<?php if($stream[0]['stream_type'] == 'output') { ?>
																				
																			<?php } ?>

																			<header class="panel-heading">
																				<div class="panel-actions"></div>
																				<h2 class="panel-title">Audio Settings</h2>
																			</header>
																			<div class="panel-body">
																				<div class="form-group">
																					<label class="col-md-3 control-label" for="audio_codec">Audio Codec</label>
																					<div class="col-md-9">
																						<select id="audio_codec" name="audio_codec" class="form-control" onchange="stream_set_transcode_audio(this);">
																							<optgroup label="Passthrough / Copy">
																								<option <?php if($stream[0]['audio_codec']=='copy'){echo"selected";} ?> value="copy">Copy Pass-Through</option>
																							</optgroup>
																							<optgroup label="Transcoding">
																								<option <?php if($stream[0]['audio_codec']=='aac'){echo"selected";} ?> value="aac">AAC</option>
																								<option <?php if($stream[0]['audio_codec']=='libfdk_aac'){echo"selected";} ?> value="libfdk_aac">LibFDK AAC</option>
																								<option <?php if($stream[0]['audio_codec']=='ac3'){echo"selected";} ?> value="ac3">AC3</option>
																								<option <?php if($stream[0]['audio_codec']=='mp2'){echo"selected";} ?> value="mp2">MP2</option>
																								<option <?php if($stream[0]['audio_codec']=='mp3'){echo"selected";} ?> value="mp3">MP3</option>
																							</optgroup>
																						</select>
																					</div>
																				</div>

																				<div id="stream_audio_options" class="<?php if($stream[0]['audio_codec'] == 'copy'){ echo 'hidden'; } ?>">
																					<div class="form-group">
																						<label class="col-md-3 control-label" for="audio_bitrate">Audio Bitrate (k)</label>
																						<div class="col-md-9">
																							<input type="number" class="form-control" id="audio_bitrate" name="audio_bitrate" value="<?php echo $stream[0]['audio_bitrate']; ?>" placeholder="128">
																						</div>
																					</div>

																					<div class="form-group">
																						<label class="col-md-3 control-label" for="audio_sample_rate">Audio Sample Rate</label>
																						<div class="col-md-9">
																							<input type="number" class="form-control" id="audio_sample_rate" name="audio_sample_rate" value="<?php echo $stream[0]['audio_sample_rate']; ?>" placeholder="44100">
																						</div>
																					</div>

																					<div class="form-group">
																						<label class="col-md-3 control-label" for="ac">Audio Channels</label>
																						<div class="col-md-9">
																							<input type="number" class="form-control" id="ac" name="ac" value="<?php echo $stream[0]['ac']; ?>" placeholder="2">
																						</div>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																</span>
															<?php } ?>
														</div>
													</section>
												</div>
											</div>

											<footer class="panel-footer">
												<a href="dashboard.php?c=streams" class="btn btn-default">Back</a>
												<button type="submit" class="btn btn-success pull-right">Save Changes</button>
											</footer>
										</form>
									</div>
								</div>
							</div>

							<!-- source options -->
							<!-- dehash options -->
							<?php if($stream[0]['stream_type'] == 'input') { ?>
								<!-- dehash options -->
								<div class="col-lg-6">
									<div class="box box-primary">
				            			<div class="box-header">
				              				<h3 class="box-title">
				              					Stream Sources
				              				</h3>
				              				<div class="pull-right">
				              					<button type="button" class="btn btn-success btn-xs btn-flat" data-toggle="modal" data-target="#stream_source_add_modal">Add New Source</button>
											</div>
				            			</div>
										<div class="box-body">
											<form action="actions.php?a=stream_source_update" class="form-horizontal form-bordered" method="post">
												<input type="hidden" name="stream_id" value="<?php echo $stream_id; ?>">
												<div class="row">
													<div class="col-lg-12">
														<section class="panel">
															<div class="panel-body">
																<!-- source -->
																<?php foreach($sources as $source){ ?>
																	<div class="form-group">
																		<label class="col-md-3 control-label" for="source">Source URL</label>
																		<div class="col-md-9">
																			<input type="text" class="form-control" id="source" name="sources[]" value="<?php echo stripslashes($source); ?>">
																		</div>
																	</div>
																<?php } ?>

															</div>
														</section>
													</div>
												</div>

												<footer class="panel-footer">
													<a href="dashboard.php?c=streams" class="btn btn-default">Back</a>
													<button type="submit" class="btn btn-success pull-right">Save Changes</button>
												</footer>
											</form>
										</div>
									</div>
								</div>
							<?php } ?>

							<!-- watermark / logo  options -->
							<!--
							<div class="col-lg-6">
								<div class="box box-primary">
			            			<div class="box-header">
			              				<h3 class="box-title">
			              					Watermark / Logo Options
			              				</h3>
			              				<div class="pull-right">
			              					
										</div>
			            			</div>
									<div class="box-body">
										<form action="actions.php?a=stream_update_watermark" class="form-horizontal form-bordered" method="post">
											<input type="hidden" name="stream_id" value="<?php echo $stream_id; ?>">
											<div class="row">
												<div class="col-lg-12">
													<section class="panel">
														<div class="panel-body">
															<div class="form-group">
																<label class="col-md-2 control-label" for="fingerprint">Status</label>
																<div class="col-md-10">
																	<select id="fingerprint" name="fingerprint" class="form-control" onchange="set_fingerprint_status(this);">
																		<option <?php if($stream[0]['fingerprint']=='disable'){echo"selected";} ?> value="disable">Disable</option>
																		<option <?php if($stream[0]['fingerprint']=='enable'){echo"selected";} ?> value="enable">Enable</option>
																	</select>
																</div>
															</div>

															<span id="fingerprint_options" class="<?php if($stream[0]['fingerprint']=='disable'){echo"hidden";} ?>">
																<div class="form-group">
																	<label class="col-md-2 control-label" for="fingerprint_type">Type</label>
																	<div class="col-md-10">
																		<select id="fingerprint_type" name="fingerprint_type" class="form-control" onchange="set_fingerprint_type(this);">
																			<option <?php if($stream[0]['fingerprint_type']=='static_text'){echo"selected";} ?> value="static_text">Display Static Text)</option>
																			<?php if($stream[0]['stream_type'] == 'output'){ ?>
																				<option <?php if($stream[0]['fingerprint_type']=='username'){echo"selected";} ?> value="username">Display Username</option>
																			<?php } ?>
																		</select>
																	</div>
																</div>

																<div id="fingerprint_options_static_text" class="<?php if($stream[0]['fingerprint_type']!='static_text'){echo"hidden";} ?>">
																	<div class="form-group">
																		<label class="col-md-2 control-label" for="fingerprint_text">Text</label>
																		<div class="col-md-10">
																			<input type="text" id="fingerprint_text" name="fingerprint_text" class="form-control" value="<?php echo stripslashes($stream[0]['fingerprint_text']); ?>">
																			<small>(Max 500 chars)</small>
																		</div>
																	</div>
																</div>

																<div class="form-group">
																	<label class="col-md-2 control-label" for="fingerprint_fontsize">Text Size</label>
																	<div class="col-md-10">
																		<input type="text" class="form-control" id="fingerprint_fontsize" name="fingerprint_fontsize" value="<?php echo stripslashes($stream[0]['fingerprint_fontsize']); ?>">
																	</div>
																</div>

																<div class="form-group">
																	<label class="col-md-2 control-label" for="fingerprint_color">Text Color</label>
																	<div class="col-md-10">
																		<select id="fingerprint_color" name="fingerprint_color" class="form-control">
																			<option <?php if($stream[0]['fingerprint_color']=='white'){echo"selected";} ?> value="white">White</option>
																			<option <?php if($stream[0]['fingerprint_color']=='black'){echo"selected";} ?> value="black">Black</option>
																			<option <?php if($stream[0]['fingerprint_color']=='blue'){echo"selected";} ?> value="blue">Blue</option>
																			<option <?php if($stream[0]['fingerprint_color']=='green'){echo"selected";} ?> value="green">Green</option>
																		</select>
																	</div>
																</div>

																<div class="form-group">
																	<label class="col-md-2 control-label" for="fingerprint_location">Position</label>
																	<div class="col-md-10">
																		<select id="fingerprint_location" name="fingerprint_location" class="form-control">
																			<option <?php if($stream[0]['fingerprint_location']=='top_left'){echo"selected";} ?> value="top_left">Top Left</option>
																			<option <?php if($stream[0]['fingerprint_location']=='top_right'){echo"selected";} ?> value="top_right">Top Right</option>
																			<option <?php if($stream[0]['fingerprint_location']=='bottom_left'){echo"selected";} ?> value="bottom_left">Bottom Left</option>
																			<option <?php if($stream[0]['fingerprint_location']=='bottom_right'){echo"selected";} ?> value="bottom_right">Bottom Right</option>
																		</select>
																	</div>
																</div>
															</span>
														</div>
													</section>
												</div>
											</div>

											<footer class="panel-footer">
												<a href="dashboard.php?c=streams" class="btn btn-default">Back</a>
												<button type="submit" class="btn btn-success pull-right">Save Changes</button>
											</footer>
										</form>
									</div>
								</div>
							</div>
							-->

							<!-- fingerprint options -->
							<div class="col-lg-6">
								<div class="box box-primary">
			            			<div class="box-header">
			              				<h3 class="box-title">
			              					<small class="label bg-red">BETA</small> Fingerprint Options
			              				</h3>
			              				<div class="pull-right">
			              					
										</div>
			            			</div>
									<div class="box-body">
										<form action="actions.php?a=stream_update_fingerprint" class="form-horizontal form-bordered" method="post">
											<input type="hidden" name="stream_id" value="<?php echo $stream_id; ?>">
											<div class="row">
												<div class="col-lg-12">
													<section class="panel">
														<div class="panel-body">
															<div class="form-group">
																<label class="col-md-2 control-label" for="fingerprint">Status</label>
																<div class="col-md-10">
																	<select id="fingerprint" name="fingerprint" class="form-control" onchange="set_fingerprint_status(this);">
																		<option <?php if($stream[0]['fingerprint']=='disable'){echo"selected";} ?> value="disable">Disable</option>
																		<option <?php if($stream[0]['fingerprint']=='enable'){echo"selected";} ?> value="enable">Enable</option>
																	</select>
																</div>
															</div>

															<span id="fingerprint_options" class="<?php if($stream[0]['fingerprint']=='disable'){echo"hidden";} ?>">
																<!-- status -->
																<div class="form-group">
																	<label class="col-md-2 control-label" for="fingerprint_type">Type</label>
																	<div class="col-md-10">
																		<select id="fingerprint_type" name="fingerprint_type" class="form-control" onchange="set_fingerprint_type(this);">
																			<option <?php if($stream[0]['fingerprint_type']=='static_text'){echo"selected";} ?> value="static_text">Display Static Text)</option>
																			<?php if($stream[0]['stream_type'] == 'output'){ ?>
																				<option <?php if($stream[0]['fingerprint_type']=='username'){echo"selected";} ?> value="username">Display Username</option>
																			<?php } ?>
																		</select>
																	</div>
																</div>

																<div id="fingerprint_options_static_text" class="<?php if($stream[0]['fingerprint_type']!='static_text'){echo"hidden";} ?>">
																	<div class="form-group">
																		<label class="col-md-2 control-label" for="fingerprint_text">Text</label>
																		<div class="col-md-10">
																			<input type="text" id="fingerprint_text" name="fingerprint_text" class="form-control" value="<?php echo stripslashes($stream[0]['fingerprint_text']); ?>">
																			<small>(Max 500 chars)</small>
																		</div>
																	</div>
																</div>

																<div class="form-group">
																	<label class="col-md-2 control-label" for="fingerprint_fontsize">Text Size</label>
																	<div class="col-md-10">
																		<input type="text" class="form-control" id="fingerprint_fontsize" name="fingerprint_fontsize" value="<?php echo stripslashes($stream[0]['fingerprint_fontsize']); ?>">
																	</div>
																</div>

																<div class="form-group">
																	<label class="col-md-2 control-label" for="fingerprint_color">Text Color</label>
																	<div class="col-md-10">
																		<select id="fingerprint_color" name="fingerprint_color" class="form-control">
																			<option <?php if($stream[0]['fingerprint_color']=='white'){echo"selected";} ?> value="white">White</option>
																			<option <?php if($stream[0]['fingerprint_color']=='black'){echo"selected";} ?> value="black">Black</option>
																			<option <?php if($stream[0]['fingerprint_color']=='blue'){echo"selected";} ?> value="blue">Blue</option>
																			<option <?php if($stream[0]['fingerprint_color']=='green'){echo"selected";} ?> value="green">Green</option>
																		</select>
																	</div>
																</div>

																<div class="form-group">
																	<label class="col-md-2 control-label" for="fingerprint_location">Position</label>
																	<div class="col-md-10">
																		<select id="fingerprint_location" name="fingerprint_location" class="form-control">
																			<option <?php if($stream[0]['fingerprint_location']=='top_left'){echo"selected";} ?> value="top_left">Top Left</option>
																			<option <?php if($stream[0]['fingerprint_location']=='top_right'){echo"selected";} ?> value="top_right">Top Right</option>
																			<option <?php if($stream[0]['fingerprint_location']=='bottom_left'){echo"selected";} ?> value="bottom_left">Bottom Left</option>
																			<option <?php if($stream[0]['fingerprint_location']=='bottom_right'){echo"selected";} ?> value="bottom_right">Bottom Right</option>
																		</select>
																	</div>
																</div>
															</span>
														</div>
													</section>
												</div>
											</div>

											<footer class="panel-footer">
												<a href="dashboard.php?c=streams" class="btn btn-default">Back</a>
												<button type="submit" class="btn btn-success pull-right">Save Changes</button>
											</footer>
										</form>
									</div>
								</div>
							</div>

							<!-- dehash options -->
							<?php if($stream[0]['stream_type'] == 'input') { ?>
								<!-- dehash options -->
								<div class="col-lg-6">
									<div class="box box-primary">
				            			<div class="box-header">
				              				<h3 class="box-title">
				              					<small class="label bg-red">BETA</small> Dehashing Options
				              				</h3>
				              				<div class="pull-right">
				              					
											</div>
				            			</div>
										<div class="box-body">
											<form action="actions.php?a=stream_update_dehash" class="form-horizontal form-bordered" method="post">
												<input type="hidden" name="stream_id" value="<?php echo $stream_id; ?>">
												<div class="row">
													<div class="col-lg-12">
														<section class="panel">
															<div class="panel-body">
																<div class="form-group">
																	<label class="col-md-4 control-label" for="dehash">Status</label>
																	<div class="col-md-8">
																		<select id="dehash" name="dehash" class="form-control" onchange="set_dehash_status(this);">
																			<option <?php if($stream[0]['dehash']=='disable'){echo"selected";} ?> value="disable">Disable</option>
																			<option <?php if($stream[0]['dehash']=='enable'){echo"selected";} ?> value="enable">Enable</option>
																		</select>
																	</div>
																</div>

																<span id="dehash_options" class="<?php if($stream[0]['dehash']=='disable'){echo"hidden";} ?>">

																	<div class="form-group">
																		<label class="col-md-4 control-label" for="dehash_file_path">Dehash Image</label>
																		<div class="col-md-8">
																			<input type="text" class="form-control" id="dehash_file_path" name="dehash_file_path" value="<?php echo $stream[0]['dehash_file_path']; ?>">
																		</div>
																	</div>

																	<div class="form-group">
																		<label class="col-md-4 control-label" for="dehash_dedect_interval">Detect Interval</label>
																		<div class="col-md-8">
																			<input type="text" class="form-control" id="dehash_dedect_interval" name="dehash_dedect_interval" value="<?php echo $stream[0]['dehash_dedect_interval']; ?>">
																		</div>
																	</div>

																	<div class="form-group">
																		<label class="col-md-4 control-label" for="dehash_buffer_queue_size">Buffer Queue Size</label>
																		<div class="col-md-8">
																			<input type="text" class="form-control" id="dehash_buffer_queue_size" name="dehash_buffer_queue_size" value="<?php echo $stream[0]['dehash_buffer_queue_size']; ?>">
																		</div>
																	</div>

																	<div class="form-group">
																		<label class="col-md-4 control-label" for="dehash_score_min">Min Score</label>
																		<div class="col-md-8">
																			<input type="text" class="form-control" id="dehash_score_min" name="dehash_score_min" value="<?php echo $stream[0]['dehash_score_min']; ?>">
																		</div>
																	</div>

																	<div class="form-group">
																		<label class="col-md-4 control-label" for="dehash_scale_0">Scale</label>
																		<div class="col-md-4">
																			<input type="text" class="form-control" id="dehash_scale_0" name="dehash_scale_0" value="<?php echo $stream[0]['dehash_scale'][0]; ?>">
																		</div>
																		<div class="col-md-4">
																			<input type="text" class="form-control" id="dehash_scale_1" name="dehash_scale_1" value="<?php echo $stream[0]['dehash_scale'][1]; ?>">
																		</div>
																	</div>

																	<div class="form-group">
																		<label class="col-md-4 control-label" for="dehash_padding_0">Padding</label>
																		<div class="col-md-2">
																			<input type="text" class="form-control" id="dehash_padding_0" name="dehash_padding_0" value="<?php echo $stream[0]['dehash_padding'][0]; ?>">
																		</div>
																		<div class="col-md-2">
																			<input type="text" class="form-control" id="dehash_padding_1" name="dehash_padding_1" value="<?php echo $stream[0]['dehash_padding'][1]; ?>">
																		</div>
																		<div class="col-md-2">
																			<input type="text" class="form-control" id="dehash_padding_2" name="dehash_padding_2" value="<?php echo $stream[0]['dehash_padding'][2]; ?>">
																		</div>
																		<div class="col-md-2">
																			<input type="text" class="form-control" id="dehash_padding_3" name="dehash_padding_3" value="<?php echo $stream[0]['dehash_padding'][3]; ?>">
																		</div>
																	</div>
																</span>
															</div>
														</section>
													</div>
												</div>

												<footer class="panel-footer">
													<a href="dashboard.php?c=streams" class="btn btn-default">Back</a>
													<button type="submit" class="btn btn-success pull-right">Save Changes</button>
												</footer>
											</form>
										</div>
									</div>
								</div>
							<?php } ?>
						</div>
					</section>
				<?php } ?>
            </div>

            <form action="actions.php?a=stream_source_add" class="form-horizontal form-bordered" method="post">
				<input type="hidden" name="stream_id" value="<?php echo $stream_id; ?>">
				<div class="modal fade" id="stream_source_add_modal" role="dialog">
				    <div class="modal-dialog modal-lg">
				        <div class="modal-content">
				            <div class="modal-header">
				                <button type="button" class="close" data-dismiss="modal">&times;</button>
				                <h4 class="modal-title">Add New Source</h4>
				            </div>
				            <div class="modal-body">
								<div class="row">
					            	<div class="col-lg-12">
						            	<div class="form-group">
											<label class="col-md-2 control-label" for="source_url">Source URL</label>
											<div class="col-md-10">
												<input type="text" class="form-control" id="source_url" name="source_url" placeholder="http://domain.com/live/user/pass/stream_id.m3u8" required="">
											</div>
										</div>
									</div>
								</div>
				            </div>
				            <div class="modal-footer">
				                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				                <button type="submit" class="btn btn-success">Add Source</button>
				            </div>
				        </div>
				    </div>
				</div>
			</form>
        <?php } ?>

        <?php function cdn_streams(){ ?>
        	<?php global $conn, $global_settings, $account_details, $site; ?>
        	
        	<?php sanity_check(); ?>

        	<?php $modal_streams = ''; ?>
			<?php $server_id = get('server_id'); ?>
			<?php $category_name = get('category'); ?>
			<?php 
				if($server_id != 0) {
					$query = $conn->query("SELECT * FROM `headend_servers` WHERE `id` = '".$server_id."' ");
					$server['headend'] = $query->fetchAll(PDO::FETCH_ASSOC);
					$server['headend'][0]['geoip'] = geoip($server['headend'][0]['wan_ip_address']);
				}
			?>

            <div class="content-wrapper">
				
                <div id="status_message"></div>
                            	
                <section class="content-header">
                    <h1>Premium Streams <!-- <small>Optional description</small> --></h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="dashboard.php">Dashboard</a></li>
                        <li class="active">Premium Streams</li>
                    </ol>
                </section>

                <!-- Main content -->
				<section class="content">
					<div class="row">
						<div class="col-lg-12">
							<div class="box box-primary">
		            			<div class="box-header">
		              				<h3 class="box-title">
		              					Premium Streams
		              				</h3>
		              				<div class="pull-right">
										<select id="server" name="server" class="form-control" onchange="cdn_streams_set_server(this);">
											<option value="0">Select a Server</option>
											<?php
											$query = $conn->query("SELECT `id`,`name` FROM `headend_servers` WHERE `user_id` = '".$_SESSION['account']['id']."' ORDER BY `name` ASC");
											if($query !== FALSE) {
												$headends = $query->fetchAll(PDO::FETCH_ASSOC);
												foreach($headends as $headend) {
													echo '<option value="'.$headend['id'].'" '.($server_id==$headend['id'] ? 'selected' : '').'>'.$headend['name'].'</option>';
												}
											}
											?>
										</select>
									</div>
		            			</div>
								<div class="box-body">
									<?php if(empty($server_id) && $server_id == 0) { ?>
										<center><h3>Select a server to begin.</h3></center>
									<?php }else{ ?>
										<?php if(isset($_GET['dev']) && $_GET['dev'] == 'yes') { ?>
											<pre>
												<?php print_r($server['headend'][0]['geoip']); ?>
											</pre>
										<?php } ?>
										<div class="alert alert-warning">
											<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
											<strong>These streams are provided by Content Delivery Networks directly. SlipStreamIPTV has no control over their content and/or availability. They are provided AS-IS.</a>
										</div>
										<h4>The following streams are available based upon your selected servers location "<?php echo $server['headend'][0]['geoip']['country_name']; ?>".</h4>
										<div class="table-responsive">
											<table id="cdn_streams" class="table table-bordered table-striped">
												<thead>
													<tr>
														<th width="75px">Geo Lock</th>											<!-- 0 -->
														<th width="100px">Category</th>											<!-- 1 -->
														<th>Name</th>															<!-- 2 -->
														<th class="no-sort" width="100px">Status</th>							<!-- 3 -->
														<th class="no-sort" width="75px">Actions</th>							<!-- 4 -->
													</tr>
												</thead>
												<tbody>
													<?php
														if(isset($_GET['category'])) {
															$category_filter = "AND `category` = '".$category_name."' ";
														}else{
															$category_filter = "";
														}

														$query = $conn->query("SELECT * FROM `cdn_streams` WHERE `enable` = 'yes' AND `country` = '".strtolower($server['headend'][0]['geoip']['country_code'])."' $category_filter OR `enable` = 'yes' AND `country` = 'any' $category_filter ");
														if($query !== FALSE) {
															$data['streams'] = $query->fetchAll(PDO::FETCH_ASSOC);

															foreach($data['streams'] as $stream) {
																$stream_status = '<button type="button" class="btn btn-danger btn-xs" style="width: 100%;">Offline</button>';

																// check if channel is setup on this server
																$query = $conn->query("SELECT * FROM `cdn_streams_servers` WHERE `stream_id` = '".$stream['id']."' AND `server_id` = '".$server_id."' ");
																$stream['stream_headend'] = $query->fetchAll(PDO::FETCH_ASSOC);

																// running stream found
																if(isset($stream['stream_headend'][0])) {
																	$display_pid = '<strong>PID:</strong> '.$stream['stream_headend'][0]['running_pid'].' | ';

																	if($stream['stream_headend'][0]['status'] == 'online') {
																		$stream_status = '<button type="button" class="btn btn-success btn-xs" style="width: 100%;">Online</button>';
																	}
																	if($stream['stream_headend'][0]['status'] == 'offline') {
																		$stream_status = '<button type="button" class="btn btn-danger btn-xs" style="width: 100%;">Offline</button>';
																	}
																	if($stream['stream_headend'][0]['status'] == 'loading') {
																		$stream_status = '<button type="button" class="btn btn-info btn-xs" style="width: 100%;">Loading</button>';
																	}

																	// build stream_url
																	$stream_url = 'http://'.$global_settings['cms_access_url'].'/cdn_streams/'.$stream['stream_headend'][0]['server_id'].'/'.$stream['stream_headend'][0]['id'];
																}else{
																	$display_pid = '';
																}

																echo '
																	<tr id="'.$stream['id'].'_col">
																		<td id="'.$stream['id'].'_col_0">
																			<center>
																				<img src="assets/images/flags/'.$stream['country'].'.svg" height="15px" alt="Locked to '.strtoupper($stream['country']).'">
																			</center>
																		</td>
																		<td id="'.$stream['id'].'_col_1">
																			'.ucfirst($stream['category']).'
																		</td>
																		<td id="'.$stream['id'].'_col_2">
																			'.stripslashes($stream['name']).' 
																			'.($_GET['dev']=='yes' ? '<br>'.$display_pid.'<strong>Source:</strong> '.$stream['source_url'] : '').'
																		</td>
																		<td id="'.$stream['id'].'_col_3">
																			'.$stream_status.'
																		</td>
																		<td style="vertical-align: middle;" class="text-right">
																			<span id="online_stream_'.$stream['id'].'" class="'.($stream['stream_headend'][0]['status']=='online' ? '' : 'hidden').'">
																				<button type="button" class="btn btn-warning btn-xs btn-flat" data-toggle="modal" data-target="#modal_stream_'.$stream['id'].'">
																					<i class="fa fa-globe" aria-hidden="true"></i>
																				</button>

																				<a href="actions.php?a=cdn_stream_stop&stream_id='.$stream['id'].'&server_id='.$server_id.'" class="btn btn-danger btn-flat btn-xs btn-flat"><i class="fa fa-pause"></i></a>
																			</span>

																			<span id="offline_stream_'.$stream['id'].'" class="'.($stream['stream_headend'][0]['status']=='offline' ? '' : 'hidden').'">
																				<!-- <button onclick="stream_start('.$stream['id'].', '.$server_id.')" class="btn btn-success btn-flat btn-xs btn-flat"><i class="fa fa-play"></i></button> -->
																				<a href="actions.php?a=cdn_stream_stop&stream_id='.$stream['id'].'&server_id='.$server_id.'" class="btn btn-danger btn-flat btn-xs btn-flat"><i class="fa fa-pause"></i></a>
																			</span>

																			'.(!isset($stream['stream_headend'][0]['status']) ? '<span id="offline_stream_'.$stream['id'].'" class="">
																				<a href="actions.php?a=cdn_stream_start&stream_id='.$stream['id'].'&server_id='.$server_id.'" class="btn btn-success btn-flat btn-xs"><i class="fa fa-play"></i></a>
																			</span>' : '').'
																		</td>
																	</tr>
																';

																echo '
																<div class="modal fade" id="modal_stream_'.$stream['id'].'" role="dialog">
																	<div class="modal-dialog modal-lg">
																		<div class="modal-content">
																			<div class="modal-header">
																				<button type="button" class="close" data-dismiss="modal">&times;</button>
																				<h4 class="modal-title">'.$stream['name'].'</h4>
																			</div>
																			<div class="modal-body">
																				<!--
																				<strong>Server: </strong> '.$stream['name'].' <br>
																				<strong>Source URL: </strong> '.$stream['source'].' <br>
																				-->
																				<div class="form-group">
																                  	<label for="exampleInputEmail1">Stream URL:</label>
																                  	<input type="text" class="form-control" value="'.$stream_url.'">
																                </div>
																			</div>
																			<div class="modal-footer">
																				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																			</div>
																		</div>
																	</div>
																</div>
															';
															}
														}
													?>
												</tbody>
											</table>
										</div>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</section>
            </div>
        <?php } ?>

        <?php function transcoding_profiles(){ ?>
        	<?php 
        		global $conn, $wp, $global_settings, $account_details, $site, $whmcs, $product_ids;
            
            	sanity_check();
            ?>

        	<div class="content-wrapper">
				
                <div id="status_message"></div>
                            	
                <section class="content-header">
                    <h1>Transcoding Profiles <!-- <small>Optional description</small> --></h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="dashboard.php">Dashboard</a></li>
                        <li class="active">Transcoding Profiles</li>
                    </ol>
                </section>

                <!-- Main content -->
				<section class="content">
					<div class="row">
						<div class="col-lg-12">
							<div class="box box-primary">
		            			<div class="box-header">
		              				<h3 class="box-title">
		              					Transcoding Profiles
		              				</h3>
		              				<div class="pull-right">
										<button type="button" class="btn btn-success btn-xs btn-flat" data-toggle="modal" data-target="#new_profile_modal">New Profile</button>
									</div>
		            			</div>
								<div class="box-body">
									<form action="actions.php?a=transcoding_profile_add" class="form-horizontal form-bordered" method="post">
										<div class="modal fade" id="new_profile_modal" role="dialog">
										    <div class="modal-dialog modal-lg">
										        <div class="modal-content">
										            <div class="modal-header">
										                <button type="button" class="close" data-dismiss="modal">&times;</button>
										                <h4 class="modal-title">New Transcoding Profile</h4>
										            </div>
										            <div class="modal-body">
														<div class="row">
															<div class="col-lg-12">
																<div class="form-group">
																	<label class="col-md-2 control-label" for="name">Profile Name: </label>
																	<div class="col-md-10">
																		<input type="text" class="form-control" id="name" name="name" placeholder="Profile Name." required="required">
																	</div>
																</div>
															</div>
														</div>
										            </div>
										            <div class="modal-footer">
										                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										                <button type="submit" class="btn btn-success">Add</button>
										            </div>
										        </div>
										    </div>
										</div>
									</form>
									<div class="table">
										<table id="transcoding_profiles" class="table table-bordered table-striped">
											<thead>
												<tr>
													<th>Name</th>
													<th width="100px">Type</th>
													<th width="100px">HW</th>
													<th width="100px">V Codec</th>
													<th width="100px">Res</th>
													<th width="100px">BW</th>
													<th class="no-sort" width="75px">Actions</th>
												</tr>
											</thead>
											<tbody>
												<?php
													$sql = "
														SELECT * FROM `transcoding_profiles` WHERE `user_id` = '".$_SESSION['account']['id']."'
													";
													$query = $conn->query($sql);
													if($query !== FALSE) {
														$profiles = $query->fetchAll(PDO::FETCH_ASSOC);

														foreach($profiles as $profile) {
															$profile_data = json_decode($profile['data'], true);

															if($profile_data['cpu_gpu'] == 'copy'){
																$type = 'Re-Stream';
															}else{
																$type = 'Transcode';
															}

															if($profile_data['cpu_gpu'] == 'copy'){
																$hardware = 'N/A';
															}else{
																$hardware = strtoupper($profile_data['cpu_gpu']);
															}
														
															echo '
																<tr>
																	<td>
																		'.stripslashes($profile['name']).'
																	</td>
																	<td>
																		'.$type.'
																	</td>
																	<td>
																		'.$hardware.'
																	</td>
																	<td>
																		'.strtoupper($profile_data['video_codec']).'
																	</td>
																	<td>
																		'.strtoupper($profile_data['screen_resolution']).'
																	</td>
																	<td>
																	'.number_format(($profile_data['bitrate'] / 1024), 2).' Mbit
																	</td>
																	<td style="vertical-align: middle;" class="text-right">
																		<a href="dashboard.php?c=transcoding_profile&profile_id='.$profile['id'].'" class="btn btn-info btn-flat btn-xs btn-flat"><i class="fa fa-eye"></i></a>

																		<a href="actions.php?a=transcoding_profile_delete&profile_id='.$profile['id'].'" class="btn btn-danger btn-flat btn-xs btn-flat"><i class="fa fa-cross"></i></a>
																	</td>
																</tr>
															';
														}
													}
												?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
            </div>
        <?php } ?>

        <?php function transcoding_profile(){ ?>
        	<?php 
        		global $conn, $wp, $global_settings, $account_details, $site, $whmcs, $product_ids;
            
            	sanity_check();
            
            	$profile_id = get('profile_id');

        		$query 				= $conn->query("SELECT * FROM `transcoding_profiles` WHERE `id` = '".$profile_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
				$profile 			= $query->fetch(PDO::FETCH_ASSOC);
				$profile['data'] 	= json_decode($profile['data'], true);
			?>

            <div class="content-wrapper">
				
                <div id="status_message"></div>
                            	
                <section class="content-header">
                    <h1>Transcoding Profiles <!-- <small>Optional description</small> --></h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="dashboard.php">Dashboard</a></li>
                        <li class="active"><a href="dashboard.php?c=transcoding_profiles">Transcoding Profiles</a></li>
                        <li class="active">Profile</li>
                    </ol>
                </section>

                <!-- Main content -->
                <?php if($profile['user_id'] != $_SESSION['account']['id']) { ?>
					<section class="content">
						<div class="row">
							<div class="col-lg-12">
								<div class="box box-danger">
			            			<div class="box-header">
			              				<h3 class="box-title">
			              					ERROR
			              				</h3>
			            			</div>
									<div class="box-body">
										<h3>There was an error loading this content.</h3>
										You don't own this profile. This security breach has been reported to our security team.
									</div>
								</div>
							</div>
						</div>
					</section>
				<?php }else{ ?>
					<form action="actions.php?a=transcoding_profile_update" class="form-horizontal form-bordered" method="post">
						<section class="content">
							<div class="row">
								<div class="col-lg-6">
									<div class="box box-primary">
				            			<div class="box-header">
				              				<h3 class="box-title">
				              					Profile > <?php echo stripslashes($profile['name']); ?>
				              				</h3>
				              				<div class="pull-right">
				              					<a href="actions.php?a=restart_transcoding_profile_streams&profile_id=<?php echo $profile_id; ?>" class="btn btn-warning btn-xs btn-flat" onclick="return confirm('Are you sure? \nThis will restart every channel using this profile. Please allow up to 5 minutes for all streams to restart.')">
													<i class="fas fa-sync"></i> 
													Apply &amp; Restart Streams
												</a>
											</div>
				            			</div>
										<div class="box-body">
											<input type="hidden" name="profile_id" value="<?php echo $profile_id; ?>">
											<div class="row">
												<div class="col-lg-12">
													<section class="panel">
														<header class="panel-heading">
															<div class="panel-actions"></div>
															<h2 class="panel-title">General Settings</h2>
														</header>
														<div class="panel-body">
															<?php if(isset($_GET['dev']) && $_GET['dev'] == 'yes') { ?>
																<pre>
																	<?php print_r($profile); ?>
																</pre>
															<?php } ?>

															<!-- name -->
															<div class="form-group">
																<label class="col-md-3 control-label" for="name">Name</label>
																<div class="col-md-9">
																	<input type="text" class="form-control" id="name" name="name" value="<?php echo stripslashes($profile['name']); ?>" required>
																</div>
															</div>

															<!-- user agent -->
															<div class="form-group">
																<label class="col-md-3 control-label" for="user_agent">User Agent</label>
																<div class="col-md-9">
																	<input type="text" class="form-control" id="user_agent" name="data[user_agent]" value="<?php echo stripslashes($profile['data']['user_agent']); ?>" placeholder="Leave blank for system default.">
																</div>
															</div>

															<div class="form-group">
																<label class="col-md-3 control-label" for="ffmpeg_re">Video Read-Native</label>
																<div class="col-md-9">
																	<select id="ffmpeg_re" name="data[ffmpeg_re]" class="form-control">
																		<option <?php if($profile['data']['ffmpeg_re']=='no'){echo"selected";} ?> value="no">No</option>
																		<option <?php if($profile['data']['ffmpeg_re']=='yes'){echo"selected";} ?> value="yes">Yes</option>
																	</select>
																</div>
															</div>

															<header class="panel-heading">
																<div class="panel-actions"></div>
																<h2 class="panel-title">Video Settings</h2>
															</header>
															<div class="panel-body">
																<div class="form-group">
																	<label class="col-md-3 control-label" for="cpu_gpu">Copy or Transcode</label>
																	<div class="col-md-9">
																		<select id="cpu_gpu" name="data[cpu_gpu]" class="form-control" onchange="stream_set_transcode_hardware(this);">
																			<option <?php if($profile['data']['cpu_gpu']=='copy'){echo"selected";} ?> value="copy">Copy / Pass-Through</option>
																			<option <?php if($profile['data']['cpu_gpu']=='cpu'){echo"selected";} ?> value="cpu">CPU / Processor</option>
																			<option <?php if($profile['data']['cpu_gpu']=='gpu'){echo"selected";} ?> value="gpu">GPU / NVIDIA</option>
																		</select>
																	</div>
																</div>

																<!-- cpu only settings -->
																<div id="stream_cpu_options" class="<?php if($profile['data']['cpu_gpu'] != 'cpu'){ echo 'hidden'; } ?>">
																	<div class="form-group">
																		<label class="col-md-3 control-label" for="cpu_video_codec">Video Codec</label>
																		<div class="col-md-9">
																			<select id="cpu_video_codec" name="data[cpu_video_codec]" class="form-control">
																				<option <?php if($profile['data']['video_codec']=='libx264'){echo"selected";} ?> value="libx264">H.264 (libx264)</option>
																				<option <?php if($profile['data']['video_codec']=='libx265'){echo"selected";} ?> value="libx265">H.265 (libx265)</option>
																			</select>
																		</div>
																	</div>
																</div>

																<!-- gpu only settings -->
																<div id="stream_gpu_options" class="<?php if($profile['data']['cpu_gpu'] != 'gpu'){ echo 'hidden'; } ?>">
																	<input type="hidden" name="data[gpu]" value="0">

																	<div class="form-group">
																		<label class="col-md-3 control-label" for="gpu_video_codec">Video Codec</label>
																		<div class="col-md-9">
																			<select id="gpu_video_codec" name="data[gpu_video_codec]" class="form-control">
																				<option <?php if($profile['data']['video_codec']=='h264_nvenc'){echo"selected";} ?> value="h264_nvenc">H.264 (h264_nvenc)</option>
																				<option <?php if($profile['data']['video_codec']=='hevc_nvenc'){echo"selected";} ?> value="hevc_nvenc">H.265 (hevc_nvenc)</option>
																			</select>
																		</div>
																	</div>

																	<div class="form-group">
																		<label class="col-md-3 control-label" for="surfaces">Video Surfaces</label>
																		<div class="col-md-9">
																			<input type="text" class="form-control" id="surfaces" name="data[surfaces]" value="<?php echo stripslashes($profile['data']['surfaces']); ?>" placeholder="Leave blank for system default = 10.">
																		</div>
																	</div>
																</div>

																<div id="transcode_options" class="<?php if($profile['data']['cpu_gpu']=='copy') {echo 'hidden'; } ?>">
																	<div class="form-group">
																		<label class="col-md-3 control-label" for="framerate">Video Framerate</label>
																		<div class="col-md-9">
																			<select id="framerate" name="data[framerate]" class="form-control">
																				<option <?php if($profile['data']['framerate']=='0'){echo"selected";} ?> value="0">Copy Source</option>
																				<option <?php if($profile['data']['framerate']=='1'){echo"selected";} ?> value="1">1 FPS</option>
																				<option <?php if($profile['data']['framerate']=='2'){echo"selected";} ?> value="2">2 FPS</option>
																				<option <?php if($profile['data']['framerate']=='3'){echo"selected";} ?> value="3">3 FPS</option>
																				<option <?php if($profile['data']['framerate']=='4'){echo"selected";} ?> value="4">4 FPS</option>
																				<option <?php if($profile['data']['framerate']=='5'){echo"selected";} ?> value="5">5 FPS</option>
																				<option <?php if($profile['data']['framerate']=='6'){echo"selected";} ?> value="6">6 FPS</option>
																				<option <?php if($profile['data']['framerate']=='7'){echo"selected";} ?> value="7">7 FPS</option>
																				<option <?php if($profile['data']['framerate']=='8'){echo"selected";} ?> value="8">8 FPS</option>
																				<option <?php if($profile['data']['framerate']=='9'){echo"selected";} ?> value="9">9 FPS</option>
																				<option <?php if($profile['data']['framerate']=='10'){echo"selected";} ?> value="10">10 FPS</option>
																				<option <?php if($profile['data']['framerate']=='11'){echo"selected";} ?> value="11">11 FPS</option>
																				<option <?php if($profile['data']['framerate']=='12'){echo"selected";} ?> value="12">12 FPS</option>
																				<option <?php if($profile['data']['framerate']=='13'){echo"selected";} ?> value="13">13 FPS</option>
																				<option <?php if($profile['data']['framerate']=='14'){echo"selected";} ?> value="14">14 FPS</option>
																				<option <?php if($profile['data']['framerate']=='15'){echo"selected";} ?> value="15">15 FPS</option>
																				<option <?php if($profile['data']['framerate']=='16'){echo"selected";} ?> value="16">16 FPS</option>
																				<option <?php if($profile['data']['framerate']=='17'){echo"selected";} ?> value="17">17 FPS</option>
																				<option <?php if($profile['data']['framerate']=='18'){echo"selected";} ?> value="18">18 FPS</option>
																				<option <?php if($profile['data']['framerate']=='19'){echo"selected";} ?> value="19">19 FPS</option>
																				<option <?php if($profile['data']['framerate']=='20'){echo"selected";} ?> value="20">20 FPS</option>
																				<option <?php if($profile['data']['framerate']=='21'){echo"selected";} ?> value="21">21 FPS</option>
																				<option <?php if($profile['data']['framerate']=='22'){echo"selected";} ?> value="22">22 FPS</option>
																				<option <?php if($profile['data']['framerate']=='23'){echo"selected";} ?> value="23">23 FPS</option>
																				<option <?php if($profile['data']['framerate']=='24'){echo"selected";} ?> value="24">24 FPS</option>
																				<option <?php if($profile['data']['framerate']=='25'){echo"selected";} ?> value="25">25 FPS</option>
																				<option <?php if($profile['data']['framerate']=='26'){echo"selected";} ?> value="26">26 FPS</option>
																				<option <?php if($profile['data']['framerate']=='27'){echo"selected";} ?> value="27">27 FPS</option>
																				<option <?php if($profile['data']['framerate']=='28'){echo"selected";} ?> value="28">28 FPS</option>
																				<option <?php if($profile['data']['framerate']=='29'){echo"selected";} ?> value="29">29 FPS</option>
																				<option <?php if($profile['data']['framerate']=='30'){echo"selected";} ?> value="30">30 FPS</option>
																				<option <?php if($profile['data']['framerate']=='31'){echo"selected";} ?> value="31">31 FPS</option>
																				<option <?php if($profile['data']['framerate']=='32'){echo"selected";} ?> value="32">32 FPS</option>
																				<option <?php if($profile['data']['framerate']=='33'){echo"selected";} ?> value="33">33 FPS</option>
																				<option <?php if($profile['data']['framerate']=='34'){echo"selected";} ?> value="34">34 FPS</option>
																				<option <?php if($profile['data']['framerate']=='35'){echo"selected";} ?> value="35">35 FPS</option>
																				<option <?php if($profile['data']['framerate']=='36'){echo"selected";} ?> value="36">36 FPS</option>
																				<option <?php if($profile['data']['framerate']=='37'){echo"selected";} ?> value="37">37 FPS</option>
																				<option <?php if($profile['data']['framerate']=='38'){echo"selected";} ?> value="38">38 FPS</option>
																				<option <?php if($profile['data']['framerate']=='39'){echo"selected";} ?> value="39">39 FPS</option>
																				<option <?php if($profile['data']['framerate']=='40'){echo"selected";} ?> value="40">40 FPS</option>
																				<option <?php if($profile['data']['framerate']=='41'){echo"selected";} ?> value="41">41 FPS</option>
																				<option <?php if($profile['data']['framerate']=='42'){echo"selected";} ?> value="42">42 FPS</option>
																				<option <?php if($profile['data']['framerate']=='43'){echo"selected";} ?> value="43">43 FPS</option>
																				<option <?php if($profile['data']['framerate']=='44'){echo"selected";} ?> value="44">44 FPS</option>
																				<option <?php if($profile['data']['framerate']=='45'){echo"selected";} ?> value="45">45 FPS</option>
																				<option <?php if($profile['data']['framerate']=='46'){echo"selected";} ?> value="46">46 FPS</option>
																				<option <?php if($profile['data']['framerate']=='47'){echo"selected";} ?> value="47">47 FPS</option>
																				<option <?php if($profile['data']['framerate']=='48'){echo"selected";} ?> value="48">48 FPS</option>
																				<option <?php if($profile['data']['framerate']=='49'){echo"selected";} ?> value="49">49 FPS</option>
																				<option <?php if($profile['data']['framerate']=='50'){echo"selected";} ?> value="50">50 FPS</option>
																				<option <?php if($profile['data']['framerate']=='51'){echo"selected";} ?> value="51">51 FPS</option>
																				<option <?php if($profile['data']['framerate']=='52'){echo"selected";} ?> value="52">52 FPS</option>
																				<option <?php if($profile['data']['framerate']=='53'){echo"selected";} ?> value="53">53 FPS</option>
																				<option <?php if($profile['data']['framerate']=='54'){echo"selected";} ?> value="54">54 FPS</option>
																				<option <?php if($profile['data']['framerate']=='55'){echo"selected";} ?> value="55">55 FPS</option>
																				<option <?php if($profile['data']['framerate']=='56'){echo"selected";} ?> value="56">56 FPS</option>
																				<option <?php if($profile['data']['framerate']=='57'){echo"selected";} ?> value="57">57 FPS</option>
																				<option <?php if($profile['data']['framerate']=='58'){echo"selected";} ?> value="58">58 FPS</option>
																				<option <?php if($profile['data']['framerate']=='59'){echo"selected";} ?> value="59">59 FPS</option>
																				<option <?php if($profile['data']['framerate']=='60'){echo"selected";} ?> value="60">60 FPS</option>
																			</select>
																		</div>
																	</div>

																	<div class="form-group">
																		<label class="col-md-3 control-label" for="preset">Video Preset</label>
																		<div class="col-md-9">
																			<select id="preset" name="data[preset]" class="form-control">
																				<option <?php if($profile['data']['preset']=='0'){echo"selected";} ?> value="0">Default</option>
																				
																				<option <?php if($profile['data']['preset']=='1'){echo"selected";} ?> value="1">Slow</option>
																				<option <?php if($profile['data']['preset']=='2'){echo"selected";} ?> value="2">Medium</option>
																				<option <?php if($profile['data']['preset']=='3'){echo"selected";} ?> value="3">Fast</option>

																				<option <?php if($profile['data']['preset']=='4'){echo"selected";} ?> value="4">High Performance</option>
																				<option <?php if($profile['data']['preset']=='5'){echo"selected";} ?> value="5">High Quality</option>
																				<!-- <option <?php if($stream[0]['preset']=='6'){echo"selected";} ?> value="6">bd</option> -->
																				<option <?php if($profile['data']['preset']=='7'){echo"selected";} ?> value="7">Low Latency</option>
																				<option <?php if($profile['data']['preset']=='8'){echo"selected";} ?> value="8">Low Latency High Quality</option>
																				<option <?php if($profile['data']['preset']=='9'){echo"selected";} ?> value="9">Low Latency High Performance</option>
																				<option <?php if($profile['data']['preset']=='10'){echo"selected";} ?> value="10">Lossless</option>
																				<option <?php if($profile['data']['preset']=='11'){echo"selected";} ?> value="11">Lossless High Quality</option>
																			</select>
																		</div>
																	</div>
																	
																	<div class="form-group">
																		<label class="col-md-3 control-label" for="profile">Video Profile</label>
																		<div class="col-md-9">
																			<select id="profile" name="data[profile]" class="form-control">
																				<optgroup label="H264 Profiles">
																					<option <?php if($profile['data']['profile']=='baseline'){echo"selected";} ?> value="baseline">Baseline</option>
																					<option <?php if($profile['data']['profile']=='main'){echo"selected";} ?> value="main">Main</option>
																					<option <?php if($profile['data']['profile']=='high'){echo"selected";} ?> value="high">High</option>
																					<option <?php if($profile['data']['profile']=='high444p'){echo"selected";} ?> value="high444p">High444p</option>
																				</optgroup>
																				<optgroup label="H265 Profiles">
																					<option <?php if($profile['data']['profile']=='main'){echo"selected";} ?> value="main">Main</option>
																					<option <?php if($profile['data']['profile']=='main10'){echo"selected";} ?> value="main10">Main10</option>
																					<option <?php if($profile['data']['profile']=='rext'){echo"selected";} ?> value="rext">Rext</option>
																				</optgroup>
																			</select>
																			<!-- <small>Please Note: 'baseline' is not available for H.265 video codec for either CPU or GPU.</small> -->
																		</div>
																	</div>

																	<div class="form-group">
																		<label class="col-md-3 control-label" for="screen_resolution">Screen Resolution</label>
																		<div class="col-md-9">
																			<select id="screen_resolution" name="data[screen_resolution]" class="form-control" >
																				<option <?php if($profile['data']['screen_resolution']=='copy'){echo"selected";} ?> value="copy">Copy Source</option>
											                                    <option <?php if($profile['data']['screen_resolution']=='3840x2160'){echo"selected";} ?> value="7680x4320">8k - 7680x4320</option>
											                                    <option <?php if($profile['data']['screen_resolution']=='3840x2160'){echo"selected";} ?> value="4096x2160">4K - 4096x2160</option>
											                                    <option <?php if($profile['data']['screen_resolution']=='3840x2160'){echo"selected";} ?> value="3840x2160">4K - 3840x2160</option>
											                                    <option <?php if($profile['data']['screen_resolution']=='1920x1080'){echo"selected";} ?> value="1920x1080">FHD - 1920x1080</option>
											                                    <option <?php if($profile['data']['screen_resolution']=='1280x720'){echo"selected";} ?> value="1280x720">HD - 1280x720</option>
											                                    <option <?php if($profile['data']['screen_resolution']=='768x576'){echo"selected";} ?> value="768x576">SD - 768x576</option>
											                                    <option <?php if($profile['data']['screen_resolution']=='640x480'){echo"selected";} ?> value="640x480">SD - 640x480</option>
																			</select>
																		</div>
																	</div>

																	<div class="form-group">
																		<label class="col-md-3 control-label" for="bitrate">Video Bitrate (k)</label>
																		<div class="col-md-9">
																			<select id="bitrate" name="data[bitrate]" class="form-control">
																				<option <?php if($profile['data']['bitrate']=='0'){echo"selected";} ?> value="0">Copy Source</option>
																				<option <?php if($profile['data']['bitrate']==128){echo"selected";} ?> value="128">128 KBit</option>
																				<option <?php if($profile['data']['bitrate']==256){echo"selected";} ?> value="256">256 KBit</option>
																				<option <?php if($profile['data']['bitrate']==512){echo"selected";} ?> value="512">512 KBit</option>
																				<option <?php if($profile['data']['bitrate']==640){echo"selected";} ?> value="640">640 KBit</option>
																				<option <?php if($profile['data']['bitrate']==768){echo"selected";} ?> value="768">768 KBit</option>
																				<option <?php if($profile['data']['bitrate']==896){echo"selected";} ?> value="896">896 KBit</option>
																				<option <?php if($profile['data']['bitrate']==1024){echo"selected";} ?> value="1024">1 MBit</option>
																				<option <?php if($profile['data']['bitrate']==2048){echo"selected";} ?> value="2048">2 MBit</option>
																				<option <?php if($profile['data']['bitrate']==3072){echo"selected";} ?> value="3072">3 MBit</option>
																				<option <?php if($profile['data']['bitrate']==4096){echo"selected";} ?> value="4096">4 MBit</option>
																				<option <?php if($profile['data']['bitrate']==5120){echo"selected";} ?> value="5120">5 MBit</option>
																				<option <?php if($profile['data']['bitrate']==6144){echo"selected";} ?> value="6144">6 MBit</option>
																				<option <?php if($profile['data']['bitrate']==7168){echo"selected";} ?> value="7168">7 MBit</option>
																				<option <?php if($profile['data']['bitrate']==8192){echo"selected";} ?> value="8192">8 MBit</option>
																				<option <?php if($profile['data']['bitrate']==9216){echo"selected";} ?> value="9216">9 MBit</option>
																				<option <?php if($profile['data']['bitrate']==10240){echo"selected";} ?> value="10240">10 MBit</option>
																				<option <?php if($profile['data']['bitrate']==11264){echo"selected";} ?> value="11264">11 MBit</option>
																				<option <?php if($profile['data']['bitrate']==12288){echo"selected";} ?> value="12288">12 MBit</option>
																				<option <?php if($profile['data']['bitrate']==13312){echo"selected";} ?> value="13312">13 MBit</option>
																				<option <?php if($profile['data']['bitrate']==14336){echo"selected";} ?> value="14336">14 MBit</option>
																				<option <?php if($profile['data']['bitrate']==15360){echo"selected";} ?> value="15360">15 MBit</option>
																				<option <?php if($profile['data']['bitrate']==16384){echo"selected";} ?> value="16384">16 MBit</option>
																				<option <?php if($profile['data']['bitrate']==17408){echo"selected";} ?> value="17408">17 MBit</option>
																				<option <?php if($profile['data']['bitrate']==18432){echo"selected";} ?> value="18432">18 MBit</option>
																				<option <?php if($profile['data']['bitrate']==19456){echo"selected";} ?> value="19456">19 MBit</option>
																				<option <?php if($profile['data']['bitrate']==20480){echo"selected";} ?> value="20480">20 MBit</option>
																			</select>
																		</div>
																	</div>
																</div>
															</div>

															<header class="panel-heading">
																<div class="panel-actions"></div>
																<h2 class="panel-title">Audio Settings</h2>
															</header>
															<div class="panel-body">
																<div class="form-group">
																	<label class="col-md-3 control-label" for="audio_codec">Audio Codec</label>
																	<div class="col-md-9">
																		<select id="audio_codec" name="data[audio_codec]" class="form-control" onchange="stream_set_transcode_audio(this);">
																			<optgroup label="Passthrough / Copy">
																				<option <?php if($profile['data']['audio_codec']=='copy'){echo"selected";} ?> value="copy">Copy Pass-Through</option>
																			</optgroup>
																			<optgroup label="Transcoding">
																				<option <?php if($profile['data']['audio_codec']=='aac'){echo"selected";} ?> value="aac">AAC</option>
																				<option <?php if($profile['data']['audio_codec']=='libfdk_aac'){echo"selected";} ?> value="libfdk_aac">LibFDK AAC</option>
																				<option <?php if($profile['data']['audio_codec']=='ac3'){echo"selected";} ?> value="ac3">AC3</option>
																				<option <?php if($profile['data']['audio_codec']=='mp2'){echo"selected";} ?> value="mp2">MP2</option>
																				<option <?php if($profile['data']['audio_codec']=='mp3'){echo"selected";} ?> value="mp3">MP3</option>
																			</optgroup>
																		</select>
																	</div>
																</div>

																<div id="stream_audio_options" class="<?php if(!isset($profile['data']['audio_codec']) ||  $profile['data']['audio_codec'] == 'copy'){ echo 'hidden'; } ?>">
																	<div class="form-group">
																		<label class="col-md-3 control-label" for="audio_bitrate">Audio Bitrate (k)</label>
																		<div class="col-md-9">
																			<select id="audio_bitrate" name="data[audio_bitrate]" class="form-control">
																				<option <?php if($profile['data']['audio_bitrate']==64){echo"selected";} ?> value="64">64 kbps</option>
																				<option <?php if($profile['data']['audio_bitrate']==96){echo"selected";} ?> value="96">96 kpbs</option>
																				<option <?php if($profile['data']['audio_bitrate']==128){echo"selected";} ?> value="128">128 kpbs</option>
																				<option <?php if($profile['data']['audio_bitrate']==160){echo"selected";} ?> value="160">160 kpbs</option>
																				<option <?php if($profile['data']['audio_bitrate']==192){echo"selected";} ?> value="192">192 kpbs</option>
																				<option <?php if($profile['data']['audio_bitrate']==256){echo"selected";} ?> value="256">256 kpbs</option>
																			</select>
																		</div>
																	</div>

																	<div class="form-group">
																		<label class="col-md-3 control-label" for="audio_sample_rate">Audio Sample Rate</label>
																		<div class="col-md-9">
																			<input type="number" class="form-control" id="audio_sample_rate" name="data[audio_sample_rate]" value="<?php echo $profile['data']['audio_sample_rate']; ?>" placeholder="44100">
																		</div>
																	</div>

																	<div class="form-group">
																		<label class="col-md-3 control-label" for="ac">Audio Channels</label>
																		<div class="col-md-9">
																			<input type="number" class="form-control" id="ac" name="data[ac]" value="<?php echo $profile['data']['ac']; ?>" placeholder="2">
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
												</div>
											</div>

											<footer class="panel-footer">
												<a href="dashboard.php?c=transcoding_profiles" class="btn btn-default">Back</a>
												<button type="submit" class="btn btn-success pull-right">Save Changes</button>
											</footer>
										</div>
									</div>
								</div>

								<!-- watermark / logo  options -->
								<!--
								<div class="col-lg-6">
									<div class="box box-primary">
				            			<div class="box-header">
				              				<h3 class="box-title">
				              					Watermark / Logo Options
				              				</h3>
				              				<div class="pull-right">
				              					
											</div>
				            			</div>
										<div class="box-body">
											<form action="actions.php?a=stream_update_watermark" class="form-horizontal form-bordered" method="post">
												<input type="hidden" name="stream_id" value="<?php echo $stream_id; ?>">
												<div class="row">
													<div class="col-lg-12">
														<section class="panel">
															<div class="panel-body">
																<div class="form-group">
																	<label class="col-md-2 control-label" for="fingerprint">Status</label>
																	<div class="col-md-10">
																		<select id="fingerprint" name="fingerprint" class="form-control" onchange="set_fingerprint_status(this);">
																			<option <?php if($stream[0]['fingerprint']=='disable'){echo"selected";} ?> value="disable">Disable</option>
																			<option <?php if($stream[0]['fingerprint']=='enable'){echo"selected";} ?> value="enable">Enable</option>
																		</select>
																	</div>
																</div>

																<span id="fingerprint_options" class="<?php if($stream[0]['fingerprint']=='disable'){echo"hidden";} ?>">
																	<div class="form-group">
																		<label class="col-md-2 control-label" for="fingerprint_type">Type</label>
																		<div class="col-md-10">
																			<select id="fingerprint_type" name="fingerprint_type" class="form-control" onchange="set_fingerprint_type(this);">
																				<option <?php if($stream[0]['fingerprint_type']=='static_text'){echo"selected";} ?> value="static_text">Display Static Text)</option>
																				<?php if($stream[0]['stream_type'] == 'output'){ ?>
																					<option <?php if($stream[0]['fingerprint_type']=='username'){echo"selected";} ?> value="username">Display Username</option>
																				<?php } ?>
																			</select>
																		</div>
																	</div>

																	<div id="fingerprint_options_static_text" class="<?php if($stream[0]['fingerprint_type']!='static_text'){echo"hidden";} ?>">
																		<div class="form-group">
																			<label class="col-md-2 control-label" for="fingerprint_text">Text</label>
																			<div class="col-md-10">
																				<input type="text" id="fingerprint_text" name="fingerprint_text" class="form-control" value="<?php echo stripslashes($stream[0]['fingerprint_text']); ?>">
																				<small>(Max 500 chars)</small>
																			</div>
																		</div>
																	</div>

																	<div class="form-group">
																		<label class="col-md-2 control-label" for="fingerprint_fontsize">Text Size</label>
																		<div class="col-md-10">
																			<input type="text" class="form-control" id="fingerprint_fontsize" name="fingerprint_fontsize" value="<?php echo stripslashes($stream[0]['fingerprint_fontsize']); ?>">
																		</div>
																	</div>

																	<div class="form-group">
																		<label class="col-md-2 control-label" for="fingerprint_color">Text Color</label>
																		<div class="col-md-10">
																			<select id="fingerprint_color" name="fingerprint_color" class="form-control">
																				<option <?php if($stream[0]['fingerprint_color']=='white'){echo"selected";} ?> value="white">White</option>
																				<option <?php if($stream[0]['fingerprint_color']=='black'){echo"selected";} ?> value="black">Black</option>
																				<option <?php if($stream[0]['fingerprint_color']=='blue'){echo"selected";} ?> value="blue">Blue</option>
																				<option <?php if($stream[0]['fingerprint_color']=='green'){echo"selected";} ?> value="green">Green</option>
																			</select>
																		</div>
																	</div>

																	<div class="form-group">
																		<label class="col-md-2 control-label" for="fingerprint_location">Position</label>
																		<div class="col-md-10">
																			<select id="fingerprint_location" name="fingerprint_location" class="form-control">
																				<option <?php if($stream[0]['fingerprint_location']=='top_left'){echo"selected";} ?> value="top_left">Top Left</option>
																				<option <?php if($stream[0]['fingerprint_location']=='top_right'){echo"selected";} ?> value="top_right">Top Right</option>
																				<option <?php if($stream[0]['fingerprint_location']=='bottom_left'){echo"selected";} ?> value="bottom_left">Bottom Left</option>
																				<option <?php if($stream[0]['fingerprint_location']=='bottom_right'){echo"selected";} ?> value="bottom_right">Bottom Right</option>
																			</select>
																		</div>
																	</div>
																</span>
															</div>
														</section>
													</div>
												</div>

												<footer class="panel-footer">
													<a href="dashboard.php?c=streams" class="btn btn-default">Back</a>
													<button type="submit" class="btn btn-success pull-right">Save Changes</button>
												</footer>
											</form>
										</div>
									</div>
								</div>
								-->
								
								<!-- fingerprint options -->
								<div class="col-lg-6">
									<div class="box box-primary">
				            			<div class="box-header">
				              				<h3 class="box-title">
				              					Fingerprint Options
				              				</h3>
				              				<div class="pull-right">
				              					
											</div>
				            			</div>
										<div class="box-body">
											<div class="row">
												<div class="col-lg-12">
													<section class="panel">
														<div class="panel-body">
															<div class="form-group">
																<label class="col-md-2 control-label" for="fingerprint">Status</label>
																<div class="col-md-10">
																	<select id="fingerprint" name="data[fingerprint]" class="form-control" onchange="set_fingerprint_status(this);">
																		<option <?php if($profile['data']['fingerprint']=='disable'){echo"selected";} ?> value="disable">Disable</option>
																		<option <?php if($profile['data']['fingerprint']=='enable'){echo"selected";} ?> value="enable">Enable</option>
																	</select>
																</div>
															</div>

															<span id="fingerprint_options" class="<?php if(!isset($profile['data']) || $profile['data']['fingerprint']=='disable'){echo"hidden";} ?>">
																<!-- status -->
																<div class="form-group">
																	<label class="col-md-2 control-label" for="fingerprint_type">Type</label>
																	<div class="col-md-10">
																		<select id="fingerprint_type" name="data[fingerprint_type]" class="form-control" onchange="set_fingerprint_type(this);">
																			<option <?php if($profile['data']['fingerprint_type']=='static_text'){echo"selected";} ?> value="static_text">Display Static Text)</option>
																			<option <?php if($profile['data']['fingerprint_type']=='username'){echo"selected";} ?> value="username">Display Username</option>
																		</select>
																	</div>
																</div>

																<div id="fingerprint_options_static_text" class="<?php if($profile['data']['fingerprint_type']!='static_text'){echo"hidden";} ?>">
																	<div class="form-group">
																		<label class="col-md-2 control-label" for="fingerprint_text">Text</label>
																		<div class="col-md-10">
																			<input type="text" id="fingerprint_text" name="data[fingerprint_text]" class="form-control" value="<?php echo stripslashes($profile['data']['fingerprint_text']); ?>">
																			<small>(Max 500 chars)</small>
																		</div>
																	</div>
																</div>

																<div class="form-group">
																	<label class="col-md-2 control-label" for="fingerprint_fontsize">Text Size</label>
																	<div class="col-md-10">
																		<input type="text" class="form-control" id="fingerprint_fontsize" name="data[fingerprint_fontsize]" value="<?php echo stripslashes($profile['data']['fingerprint_fontsize']); ?>">
																	</div>
																</div>

																<div class="form-group">
																	<label class="col-md-2 control-label" for="fingerprint_color">Text Color</label>
																	<div class="col-md-10">
																		<select id="fingerprint_color" name="data[fingerprint_color]" class="form-control">
																			<option <?php if($profile['data']['fingerprint_color']=='white'){echo"selected";} ?> value="white">White</option>
																			<option <?php if($profile['data']['fingerprint_color']=='black'){echo"selected";} ?> value="black">Black</option>
																			<option <?php if($profile['data']['fingerprint_color']=='blue'){echo"selected";} ?> value="blue">Blue</option>
																			<option <?php if($profile['data']['fingerprint_color']=='green'){echo"selected";} ?> value="green">Green</option>
																		</select>
																	</div>
																</div>

																<div class="form-group">
																	<label class="col-md-2 control-label" for="fingerprint_location">Position</label>
																	<div class="col-md-10">
																		<select id="fingerprint_location" name="data[fingerprint_location]" class="form-control">
																			<option <?php if($profile['data']['fingerprint_location']=='top_left'){echo"selected";} ?> value="top_left">Top Left</option>
																			<option <?php if($profile['data']['fingerprint_location']=='top_right'){echo"selected";} ?> value="top_right">Top Right</option>
																			<option <?php if($profile['data']['fingerprint_location']=='bottom_left'){echo"selected";} ?> value="bottom_left">Bottom Left</option>
																			<option <?php if($profile['data']['fingerprint_location']=='bottom_right'){echo"selected";} ?> value="bottom_right">Bottom Right</option>
																		</select>
																	</div>
																</div>
															</span>
														</div>
													</section>
												</div>
											</div>

											<footer class="panel-footer">
												<a href="dashboard.php?c=transcoding_profiles" class="btn btn-default">Back</a>
												<button type="submit" class="btn btn-success pull-right">Save Changes</button>
											</footer>
										</div>
									</div>
								</div>

								<!-- streams using this profile -->
								<div class="col-lg-6">
									<div class="box box-primary">
				            			<div class="box-header">
				              				<h3 class="box-title">
				              					Assigned Live Streams
				              				</h3>
				              				<div class="pull-right">
				              					
											</div>
				            			</div>
										<div class="box-body">
											<div class="row">
												<div class="col-lg-12">
													<section class="panel">
														<div class="panel-body">
															<div class="table">
																<table id="transcoding_profiles_streams" class="table table-bordered table-striped">
																	<thead>
																		<tr>
																			<th>Name</th>
																		</tr>
																	</thead>
																	<tbody>
																		<?php
																			$sql = "
																				SELECT `id`,`name` FROM `streams` WHERE `transcoding_profile_id` = '".$profile_id."'
																			";
																			$query = $conn->query($sql);
																			$streams = $query->fetchAll(PDO::FETCH_ASSOC);
																			foreach($streams as $stream) {
																				echo '
																					<tr>
																						<td>
																							'.stripslashes($stream['name']).'
																						</td>
																					</tr>
																				';
																			}
																		?>
																	</tbody>
																</table>
															</div>
														</div>
													</section>
												</div>
											</div>
										</div>
									</div>
								</div>

								<!-- channels using this profile -->
								<div class="col-lg-6">
									<div class="box box-primary">
				            			<div class="box-header">
				              				<h3 class="box-title">
				              					Assigned 24/7 TV Channels
				              				</h3>
				              				<div class="pull-right">
				              					
											</div>
				            			</div>
										<div class="box-body">
											<div class="row">
												<div class="col-lg-12">
													<section class="panel">
														<div class="panel-body">
															<div class="table">
																<table id="transcoding_profiles_channels" class="table table-bordered table-striped">
																	<thead>
																		<tr>
																			<th>Name</th>
																		</tr>
																	</thead>
																	<tbody>
																		<?php
																			$sql = "
																				SELECT `id`,`name` FROM `channels` WHERE `transcoding_profile_id` = '".$profile_id."'
																			";
																			$query = $conn->query($sql);
																			$channels = $query->fetchAll(PDO::FETCH_ASSOC);
																			foreach($channels as $channel) {
																				echo '
																					<tr>
																						<td>
																							'.stripslashes($channel['name']).'
																						</td>
																					</tr>
																				';
																			}
																		?>
																	</tbody>
																</table>
															</div>
														</div>
													</section>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</section>
					</form>
				<?php } ?>
            </div>
        <?php } ?>

        <?php function stream_categories(){ ?>
        	<?php 
        		global $conn, $wp, $global_settings, $account_details, $site, $whmcs, $product_ids;
            
            	sanity_check();
            ?>

        	<div class="content-wrapper">
				
                <div id="status_message"></div>
                            	
                <section class="content-header">
                    <h1>Stream Categories <!-- <small>Optional description</small> --></h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="dashboard.php">Dashboard</a></li>
                        <li class="active">Stream Categories</li>
                    </ol>
                </section>

                <!-- Main content -->
				<section class="content">
					
					<div class="row">
						<div class="col-lg-12">
							<div class="box box-primary">
		            			<div class="box-header">
		              				<h3 class="box-title">
		              					Stream Categories
		              				</h3>
		              				<div class="pull-right">
		              					<button type="button" class="btn btn-success btn-xs btn-flat" data-toggle="modal" data-target="#new_category">New Category</button>
									</div>
		            			</div>
								<div class="box-body">
									<div class="modal fade" id="new_category" role="dialog">
									    <div class="modal-dialog">
									        <div class="modal-content">
									        	<form action="actions.php?a=stream_category_add" class="form-horizontal form-bordered" method="post">
										            <div class="modal-header">
										                <button type="button" class="close" data-dismiss="modal">&times;</button>
										                <h4 class="modal-title">Add New Category</h4>
										            </div>
										            <div class="modal-body">
										                <div class="row">
													    	<div id="add_server_step_1" class="col-lg-12">
																<div class="form-group">
																	<label class="col-md-1 control-label" for="name">Name</label>
																	<div class="col-md-11">
																		<input type="text" class="form-control" id="name" name="name" value="" placeholder="Entertainment" required>
																	</div>
																</div>
															</div>
														</div>
										            </div>
										            <div class="modal-footer">
										                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										                <button type="submit" class="btn btn-success">Add Category</button>
										            </div>
										        </form>
									        </div>
									    </div>
									</div>

									<table id="stream_categories_table" class="table table-bordered table-striped">
										<thead>
											<tr>
												<th>Name</th>														<!-- 0 -->
												<th class="no-sort" width="50px">Actions</th>						<!-- 3 -->
											</tr>
										</thead>
										<tbody>
											<?php
												$query = $conn->query("SELECT * FROM `stream_categories` WHERE `user_id` = '".$_SESSION['account']['id']."' ORDER BY `name` ASC");
												if($query !== FALSE) {
													$categories = $query->fetchAll(PDO::FETCH_ASSOC);

													foreach($categories as $category) {

														echo '
															<tr>
																<td>'.stripslashes($category['name']).'</td>

																<td style="vertical-align: middle;">
																	<a title="Delete Category" onclick="return confirm(\'Are you sure?\')" class="btn btn-danger btn-flat btn-xs" href="actions.php?a=stream_category_delete&category_id='.$category['id'].'"><i class="fa fa-times"></i></a>
																</td>
															</tr>
														';
													}
												}
											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</section>
            </div>
        <?php } ?>

        <?php function current_connections(){ ?>
        	<?php 
        		global $conn, $wp, $global_settings, $account_details, $site, $whmcs, $product_ids;
            
            	sanity_check();

            	$servers 		= get_all_servers_ids();

            	$query 			= $conn->query("SELECT `id`,`name`,`wan_ip_address` FROM `headend_servers` ");
				$headends 		= $query->fetchAll(PDO::FETCH_ASSOC);

				$query 			= $conn->query("SELECT `id`,`name` FROM `streams` WHERE `stream_type` = 'output' AND `enable` = 'yes' ");
				$streams 		= $query->fetchAll(PDO::FETCH_ASSOC);

				$query 			= $conn->query("SELECT `id`,`name` FROM `channels` WHERE `enable` = 'yes' ");
				$channels 		= $query->fetchAll(PDO::FETCH_ASSOC);

				$query 			= $conn->query("SELECT `id`,`name` FROM `vod` ");
				$vods 			= $query->fetchAll(PDO::FETCH_ASSOC);

				$query 			= $conn->query("SELECT `id`,`name`,`tv_series_id`,`season`,`episode` FROM `tv_series_files` ");
				$series_files 	= $query->fetchAll(PDO::FETCH_ASSOC);
				$count = 0;
				foreach($series_files as $series_file){
					$series[$count]['id']					= $series_file['id'];
					$series[$count]['name']					= $series_file['name'];
					$series[$count]['tv_series_id']			= $series_file['tv_series_id'];
					$series[$count]['season']				= $series_file['season'];
					$series[$count]['episode']				= $series_file['episode'];

					$query 			= $conn->query("SELECT `name` FROM `tv_series` WHERE `id` = '".$series_file['tv_series_id']."' ");
					$tv_series 		= $query->fetch(PDO::FETCH_ASSOC);
					$series[$count]['show']					= $tv_series['name'];
				}

				$query 			= $conn->query("SELECT `id`,`username` FROM `customers` WHERE `status` = 'enabled' ");
				$customers 		= $query->fetchAll(PDO::FETCH_ASSOC);
            ?>

        	<div class="content-wrapper">
				
                <div id="status_message"></div>
                            	
                <section class="content-header">
                    <h1>Current Connections <!-- <small>Optional description</small> --></h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="dashboard.php">Dashboard</a></li>
                        <li class="active">Current Connections</li>
                    </ol>
                </section>

                <!-- Main content -->
				<section class="content">
					<div class="row">
						<div class="col-lg-12">
							<div class="box box-primary">
		            			<div class="box-header">
		              				<h3 class="box-title">
		              					Current Connections
		              				</h3>
		              				<div class="pull-right">
		              					
									</div>
		            			</div>
								<div class="box-body">
									<table id="current_connections" class="table table-bordered table-striped">
										<thead>
											<tr>
												<th>Server</th>
												<th>Customer</th>
												<th>Watching</th>
												<th width="75px">IP</th>
												<th>Location</th>
												<th>Last Seen</th>
												<th class="no-sort" width="50px">Actions</th>						
											</tr>
										</thead>
										<tbody>
											<?php
												$time_shift = time() - 30;

											    foreach($servers as $server) {
											        $ids[] = $server['id'];
											    }

											    if(is_array($ids)) {
											        $ids = implode(',', $ids);

											        // show connections for live tv
											        $sql = "
											            SELECT * FROM `streams_connection_logs` 
											            WHERE `server_id` 
											            IN (".$ids.") 
											            AND `timestamp` > '".$time_shift."' 
											            GROUP BY `client_ip`, `stream_id` 
											        ";
											        $query = $conn->query($sql);
													$current_connections = $query->fetchAll(PDO::FETCH_ASSOC);

													foreach($current_connections as $current_connection) {
														$geoip 			= geoip_all($current_connection['client_ip']);
														$last_seen 		= time() - $current_connection['timestamp'];

														foreach($headends as $headend){
															if($headend['id'] == $current_connection['server_id']){
																break;
															}
														}

														foreach($streams as $stream){
															if($stream['id'] == $current_connection['stream_id']){
																break;
															}
														}

														if($current_connection['customer_id'] != 0){
															foreach($customers as $customer){
																if($customer['id'] == $current_connection['customer_id']){
																	break;
																}
															}
														}else{
															$customer['username'] = 'Unknown Customer';
														}

														echo '
															<tr>
																<td>
																	<a href="dashboard.php?c=server&server_id='.$headend['id'].'">'.stripslashes($headend['name']).'</a>
																</td>
																<td>
																	<a href="dashboard.php?c=customer&customer_id='.$customer['id'].'">'.$customer['username'].'</a>
																</td>
																<td>
																	<strong>Live:</strong> '.stripslashes($stream['name']).'
																</td>
																<td>
																	'.$current_connection['client_ip'].'
																</td>
																<td>
																	<img src="assets/images/flags/'.strtolower($geoip['country_code']).'.svg" height="15px" alt="">
																	'.(!empty($geoip['city'])?$geoip['city'].', ':'').$geoip['country_name'].'
																</td>
																<td>
																	'.$last_seen.'s ago
																</td>
																<td style="vertical-align: middle;">
																	<a title="Delete Access" onclick="return confirm(\'Are you sure?\')" class="btn btn-danger btn-flat btn-xs" href="actions.php?a=acl_rule_delete&rule_id='.$current_connection['id'].'"><i class="fa fa-times"></i></a>
																</td>
															</tr>
														';

														unset($headend);
														unset($stream);
														unset($customer);
													}

													// show connections for 24/7 TV Channels
													$sql = "
											            SELECT * FROM `channel_connection_logs` 
											            WHERE `server_id` 
											            IN (".$ids.") 
											            AND `timestamp` > '".$time_shift."' 
											            GROUP BY `client_ip`, `channel_id` 
											        ";
											        $query = $conn->query($sql);
													$current_connections = $query->fetchAll(PDO::FETCH_ASSOC);

													foreach($current_connections as $current_connection) {
														$geoip 			= geoip_all($current_connection['client_ip']);
														$last_seen 		= time() - $current_connection['timestamp'];

														foreach($headends as $headend){
															if($headend['id'] == $current_connection['server_id']){
																break;
															}
														}

														foreach($channels as $channel){
															if($channel['id'] == $current_connection['channel_id']){
																break;
															}
														}

														if($current_connection['customer_id'] != 0){
															foreach($customers as $customer){
																if($customer['id'] == $current_connection['customer_id']){
																	break;
																}
															}
														}else{
															$customer['username'] = 'Unknown Customer';
														}

														echo '
															<tr>
																<td>
																	<a href="dashboard.php?c=server&server_id='.$headend['id'].'">'.stripslashes($headend['name']).'</a>
																</td>
																<td>
																	<a href="dashboard.php?c=customer&customer_id='.$customer['id'].'">'.$customer['username'].'</a>
																</td>
																<td>
																	<strong>Channel:</strong> '.stripslashes($channel['name']).'
																</td>
																<td>
																	'.$current_connection['client_ip'].'
																</td>
																<td>
																	<img src="assets/images/flags/'.strtolower($geoip['country_code']).'.svg" height="15px" alt="">
																	'.(!empty($geoip['city'])?$geoip['city'].', ':'').$geoip['country_name'].'
																</td>
																<td>
																	'.$last_seen.'s ago
																</td>
																<td style="vertical-align: middle;">
																	<a title="Block IP Address" onclick="return confirm(\'Are you sure?\')" class="btn btn-danger btn-flat btn-xs" href="actions.php?a=acl_rule_delete&rule_id='.$current_connection['id'].'"><i class="fa fa-times"></i></a>
																</td>
															</tr>
														';

														unset($headend);
														unset($channel);
														unset($customer);
													}

													// show connections for vod
													$sql = "
											            SELECT * FROM `vod_connection_logs` 
											            WHERE `server_id` 
											            IN (".$ids.") 
											            AND `timestamp` > '".$time_shift."' 
											            GROUP BY `client_ip`, `vod_id` 
											        ";
											        $query = $conn->query($sql);
													$current_connections = $query->fetchAll(PDO::FETCH_ASSOC);

													foreach($current_connections as $current_connection) {
														$geoip 			= geoip_all($current_connection['client_ip']);
														$last_seen 		= time() - $current_connection['timestamp'];

														foreach($headends as $headend){
															if($headend['id'] == $current_connection['server_id']){
																break;
															}
														}

														foreach($vods as $vod){
															if($vod['id'] == $current_connection['vod_id']){
																break;
															}
														}

														if($current_connection['customer_id'] != 0){
															foreach($customers as $customer){
																if($customer['id'] == $current_connection['customer_id']){
																	break;
																}
															}
														}else{
															$customer['username'] = 'Unknown Customer';
														}

														echo '
															<tr>
																<td>
																	<a href="dashboard.php?c=server&server_id='.$headend['id'].'">'.stripslashes($headend['name']).'</a>
																</td>
																<td>
																	<a href="dashboard.php?c=customer&customer_id='.$customer['id'].'">'.$customer['username'].'</a>
																</td>
																<td>
																	<strong>VoD:</strong> '.stripslashes($vod['name']).'
																</td>
																<td>
																	'.$current_connection['client_ip'].'
																</td>
																<td>
																	<img src="assets/images/flags/'.strtolower($geoip['country_code']).'.svg" height="15px" alt="">
																	'.(!empty($geoip['city'])?$geoip['city'].', ':'').$geoip['country_name'].'
																</td>
																<td>
																	'.$last_seen.'s ago
																</td>
																<td style="vertical-align: middle;">
																	<a title="Block IP Address" onclick="return confirm(\'Are you sure?\')" class="btn btn-danger btn-flat btn-xs" href="actions.php?a=acl_rule_delete&rule_id='.$current_connection['id'].'"><i class="fa fa-times"></i></a>
																</td>
															</tr>
														';

														unset($headend);
														unset($vod);
														unset($customer);
													}

													// show connections for series
													$sql = "
											            SELECT * FROM `series_connection_logs` 
											            WHERE `server_id` 
											            IN (".$ids.") 
											            AND `timestamp` > '".$time_shift."' 
											            GROUP BY `client_ip`, `series_id` 
											        ";
											        $query = $conn->query($sql);
													$current_connections = $query->fetchAll(PDO::FETCH_ASSOC);

													foreach($current_connections as $current_connection) {
														$geoip 			= geoip_all($current_connection['client_ip']);
														$last_seen 		= time() - $current_connection['timestamp'];

														foreach($headends as $headend){
															if($headend['id'] == $current_connection['server_id']){
																break;
															}
														}

														foreach($series as $show){
															if($show['id'] == $current_connection['series_id']){
																break;
															}
														}

														if($current_connection['customer_id'] != 0){
															foreach($customers as $customer){
																if($customer['id'] == $current_connection['customer_id']){
																	break;
																}
															}
														}else{
															$customer['username'] = 'Unknown Customer';
														}

														echo '
															<tr>
																<td>
																	<a href="dashboard.php?c=server&server_id='.$headend['id'].'">'.stripslashes($headend['name']).'</a>
																</td>
																<td>
																	<a href="dashboard.php?c=customer&customer_id='.$customer['id'].'">'.$customer['username'].'</a>
																</td>
																<td>
																	<strong>TV Series:</strong> '.stripslashes($show['show']).' '.$show['season'].'x'.$show['episode'].' '.stripslashes($show['name']).'
																</td>
																<td>
																	'.$current_connection['client_ip'].'
																</td>
																<td>
																	<img src="assets/images/flags/'.strtolower($geoip['country_code']).'.svg" height="15px" alt="">
																	'.(!empty($geoip['city'])?$geoip['city'].', ':'').$geoip['country_name'].'
																</td>
																<td>
																	'.$last_seen.'s ago
																</td>
																<td style="vertical-align: middle;">
																	<a title="Block IP Address" onclick="return confirm(\'Are you sure?\')" class="btn btn-danger btn-flat btn-xs" href="actions.php?a=acl_rule_delete&rule_id='.$current_connection['id'].'"><i class="fa fa-times"></i></a>
																</td>
															</tr>
														';

														unset($headend);
														unset($show);
														unset($customer);
													}
												}
											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</section>
            </div>
        <?php } ?>

        <?php function security(){ ?>
        	<?php 
        		global $conn, $wp, $global_settings, $account_details, $site, $whmcs, $product_ids;
            
            	sanity_check();
            
            	$acl_rules_modals = '';
            ?>

            <div class="content-wrapper">
				
                <div id="status_message"></div>
                            	
                <section class="content-header">
                    <h1>Security / Firewall Rules <!-- <small>Optional description</small> --></h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="dashboard.php">Dashboard</a></li>
                        <li class="active">Security / Firewall Rules</li>
                    </ol>
                </section>

                <!-- Main content -->
				<section class="content">
					<?php if(total_servers() > $account_details['max_servers']) { ?>
						<div class="row">
							<div class="col-lg-12">
								<div class="box box-danger">
			            			<div class="box-header">
			              				<h3 class="box-title">
			              					ERROR
			              				</h3>
			            			</div>
									<div class="box-body">
										Server cheat, you have too many servers in your account. Contact support ASAP.
									</div>
								</div>
							</div>
						</div>
					<?php }else{ ?>
						<div class="row">
							<div class="col-lg-12">
								<div class="box box-primary">
			            			<div class="box-header">
			              				<h3 class="box-title">
			              					Security / Firewall Rules
			              				</h3>
			              				<div class="pull-right">
			              					<button type="button" class="btn btn-success btn-xs btn-flat" data-toggle="modal" data-target="#new_firewall_rule_modal">New Firewall Rule</button>
										</div>
			            			</div>
									<div class="box-body">
										<div class="modal fade" id="new_firewall_rule_modal" role="dialog">
										    <div class="modal-dialog">
										        <div class="modal-content">
										        	<form action="actions.php?a=acl_rule_add" class="form-horizontal form-bordered" method="post">
											            <div class="modal-header">
											                <button type="button" class="close" data-dismiss="modal">&times;</button>
											                <h4 class="modal-title">Add New Firewall Rule</h4>
											            </div>
											            <div class="modal-body">
											                <div class="row">
														    	<div id="add_server_step_1" class="col-lg-12">
														    		<p>Select the server to apply this new firewall rule to and enter the remote IP address for the client server.</p>
																    <div class="form-group">
																		<label class="col-md-3 control-label" for="server_id">Server</label>
																		<div class="col-md-9">
																			<select id="server_id" name="server_id" class="form-control">
																				<?php
																				$query = $conn->query("SELECT `id`,`name` FROM `headend_servers` WHERE `user_id` = '".$_SESSION['account']['id']."' ");
																				if($query !== FALSE) {
																					$headends = $query->fetchAll(PDO::FETCH_ASSOC);
																					foreach($headends as $headend) {
																						echo '<option value="'.$headend['id'].'" '.($server_id==$headend['id'] ? 'selected' : '').'>'.$headend['name'].'</option>';
																					}
																				}
																				?>
																			</select>
																		</div>
																	</div>

																	<div class="form-group">
																		<label class="col-md-3 control-label" for="ip_address">IP Address</label>
																		<div class="col-md-9">
																			<input type="text" class="form-control" id="ip_address" name="ip_address" value="" placeholder="192.168.1.10" required="">
																		</div>
																	</div>

																	<div class="form-group">
																		<label class="col-md-3 control-label" for="comment">Comment</label>
																		<div class="col-md-9">
																			<input type="text" class="form-control" id="comment" name="comment">
																		</div>
																	</div>
																</div>
															</div>
											            </div>
											            <div class="modal-footer">
											                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											                <button type="submit" class="btn btn-success">Add Firewall Rule</button>
											            </div>
											        </form>
										        </div>
										    </div>
										</div>

										<table id="security_rules" class="table table-bordered table-striped">
											<table class="table table-striped mb-none">
												<thead>
													<tr>
														<th>Stream Server</th>								<!-- 0 -->
														<th width="400px">Remote IP</th>					<!-- 1 -->
														<th class="no-sort">Comment</th>									<!-- 2 -->
														<th class="no-sort" width="50px">Actions</th>						<!-- 3 -->
													</tr>
												</thead>
												<tbody>
													<?php
														$query = $conn->query("SELECT * FROM `streams_acl_rules` WHERE `user_id` = '".$_SESSION['account']['id']."' ORDER BY `server_id` ASC");
														if($query !== FALSE) {
															$acl_rules['rules'] = $query->fetchAll(PDO::FETCH_ASSOC);

															foreach($acl_rules['rules'] as $rule) {
																$query = $conn->query("SELECT * FROM `headend_servers` WHERE `id` = '".$rule['server_id']."' ");
																$headend = $query->fetch(PDO::FETCH_ASSOC);

																// check if remote_ip is one of our servers
																$query = $conn->query("SELECT * FROM `headend_servers` WHERE `ip_address` = '".$rule['ip_address']."' OR `wan_ip_address` = '".$rule['ip_address']."' ");
																if($query !== FALSE) {
																	$remote_headend = $query->fetch(PDO::FETCH_ASSOC);

																	if(isset($remote_headend['name'])) {
																		$remote_headend_name = ' <strong>('.stripslashes($remote_headend['name']).')</strong>';
																	}else{
																		$remote_headend_name = '';
																	}
																}else{
																	$remote_headend_name = '';
																}

																echo '
																	<tr id="'.$rule['id'].'_col">
																		<td id="'.$rule['id'].'_col_0">'.stripslashes($headend['name']).'</td>
																		<td id="'.$rule['id'].'_col_1">'.stripslashes($rule['ip_address']).$remote_headend_name.'</td>
																		<td id="'.$rule['id'].'_col_2">'.stripslashes($rule['comment']).'</td>
																		<td id="'.$rule['id'].'_col_3">
																			<a title="Delete Firewall Rule" onclick="return confirm(\'Are you sure?\')" class="btn btn-danger btn-flat btn-xs" href="actions.php?a=acl_rule_delete&rule_id='.$rule['id'].'"><i class="fa fa-times"></i></a>
																		</td>
																	</tr>
																';
															}
														}
													?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
				</section>
            </div>

            <?php echo $reinstall_modals; ?>
        <?php } ?>

        <?php function downloads(){ ?>
        	<?php 
        		global $conn, $wp, $global_settings, $account_details, $site, $whmcs, $product_ids;
            
            	sanity_check();
            ?>

        	<div class="content-wrapper">
				
                <div id="status_message"></div>   
                            	
                <section class="content-header">
                    <h1>Downloads <!-- <small>Optional description</small> --></h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="dashboard.php">Dashboard</a></li>
                        <li class="active">Downloads</li>
                    </ol>
                </section>

                <!-- Main content -->
				<section class="content">
					<div class="row">
						<div class="col-lg-12">
							<div class="box box-primary">
		            			<div class="box-header">
		              				<h3 class="box-title">
		              					Downloads
		              				</h3>
		            			</div>
								<div class="box-body">
									<table id="downloads" class="table table-bordered table-striped">
										<thead>
											<tr>
												<th>Name</th>													<!-- 0 -->
												<th class="no-sort">Description</th>							<!-- 1 -->
												<th class="no-sort" width="1px"></th>							<!-- 2 -->
											</tr>
										</thead>
										<tbody>
											<?php
												$query = $conn->query("SELECT * FROM `downloads` WHERE `enable` = 'yes' ");
												if($query !== FALSE) {
													$downloads = $query->fetchAll(PDO::FETCH_ASSOC);
													foreach($downloads as $download) {
														echo '
															<tr id="'.$download['id'].'_col">
																<td id="'.$download['id'].'_col_0">
																	'.stripslashes($download['name']).'
																</td>
																<td id="'.$download['id'].'_col_1">
																	'.stripslashes($download['description']).'
																</td>
																<td id="'.$headend['id'].'_col_9">
																	<a title="Download" class="btn btn-primary btn-flat btn-xs" href="actions.php?a=download&download_id='.$download['id'].'">
																		<i class="fa fa-download"></i>
																	</a>
																</td>
															</tr>
														';

														$reinstall_modals .= '
														<div class="modal fade" id="reinstall_server_modal_'.$headend['id'].'" role="dialog">
														    <div class="modal-dialog">
														        <div class="modal-content">
														            <div class="modal-header">
														                <button type="button" class="close" data-dismiss="modal">&times;</button>
														                <h4 class="modal-title">Reinstall Server</h4>
														            </div>
														            <div class="modal-body">
														            	<p>Please run the following command as <strong><u>root</u></strong> to install or reinstall SlipStream on server "'.$headend['name'].'"</p>
														                <div class="row">
																	    	<div class="col-lg-12">
																			    <code>wget -N --no-check-certificate http://'.$global_settings['cms_access_url'].'/downloads/install.sh && bash install.sh '.$headend['uuid'].'</code>
																			</div>
																		</div>
														            </div>
														            <div class="modal-footer">
														                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
														            </div>
														        </div>
														    </div>
														</div>';
													}
												}
											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</section>
            </div>

            <?php echo $reinstall_modals; ?>
        <?php } ?>

        <?php function stream_icons(){ ?>
        	<?php 
        		global $conn, $wp, $global_settings, $account_details, $site, $whmcs, $product_ids;
            
            	sanity_check();
            ?>

        	<div class="content-wrapper">
				
                <div id="status_message"></div>   
                            	
                <section class="content-header">
                    <h1>Stream Icons <!-- <small>Optional description</small> --></h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="dashboard.php">Dashboard</a></li>
                        <li class="active">Stream Icons</li>
                    </ol>
                </section>

                <!-- Main content -->
				<section class="content">
					<div class="row">
						<div class="col-lg-12">
							<div class="box box-primary">
		            			<div class="box-header">
		              				<h3 class="box-title">
		              					Stream Icons
		              				</h3>
		              				<div class="pull-right">
		              					
									</div>
		            			</div>
								<div class="box-body">
									<table id="stream_icons" class="table table-bordered table-striped">
										<thead>
											<tr>
												<th>Name</th>
												<th class="no-sort" width="250px">Details</th>
												<th class="no-sort">URL</th>
												<th class="no-sort" width="1px">Action</th>
											</tr>
										</thead>
										<tbody>
											<?php
												// get all channel icons
												foreach (glob("/var/www/html/portal/content/channel_icons/*.png") as $filename) {
												    // echo "$filename size " . filesize($filename) . "\n";

												    $filename_short 	= str_replace('/var/www/html/portal/content/channel_icons/', '', $filename);
													$filesize 			= filesize($filename);
													$filesize 			= formatSizeUnits($filesize);

													list($width, $height, $type, $attr) = getimagesize($filename);

													echo '
														<tr>
															<td>
																'.$filename_short.'
															</td>
															<td>
																Size: '.$filesize.' | Dimensions: '.$width.'px x '.$height.'px
															</td>
															<td>
																<code>http://'.$global_settings['cms_access_url'].'/content/channel_icons/'.$filename_short.'</code>
															</td>
															<td>
																<a href="http://'.$global_settings['cms_access_url'].'/content/channel_icons/'.$filename_short.'" target="_blank">View</a>
															</td>
														</tr>
													';														
												}
											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</section>
            </div>
        <?php } ?>

        <?php function channels(){ ?>
        	<?php 
        		global $conn, $wp, $global_settings, $account_details, $site, $whmcs, $product_ids;
            
            	sanity_check();
            
            	$server_id = get('server_id'); 

	        	$query = $conn->query("SELECT `id`,`name`,`gpu_stats` FROM `headend_servers` WHERE `user_id` = '".$_SESSION['account']['id']."' ORDER BY `name` ASC");
				$headends = $query->fetchAll(PDO::FETCH_ASSOC);

				$query = $conn->query("SELECT * FROM `stream_categories` WHERE `user_id` = '".$_SESSION['account']['id']."' ");
				$categories = $query->fetchAll(PDO::FETCH_ASSOC);

				$query = $conn->query("SELECT * FROM `transcoding_profiles` WHERE `user_id` = '".$_SESSION['account']['id']."' ORDER BY `name` ");
				$transcoding_profiles = $query->fetchAll(PDO::FETCH_ASSOC);
			?>

            <div class="content-wrapper">
				
                <div id="status_message"></div>   
                            	
                <section class="content-header">
                    <h1>24/7 TV Channels <!-- <small>Optional description</small> --></h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="dashboard.php">Dashboard</a></li>
                        <li class="active">24/7 TV Channels</li>
                    </ol>
                </section>

                <!-- Main content -->
				<section class="content">
					<?php if(total_servers() > $account_details['max_servers']) { ?>
						<div class="row">
							<div class="col-lg-12">
								<div class="box box-danger">
			            			<div class="box-header">
			              				<h3 class="box-title">
			              					ERROR
			              				</h3>
			            			</div>
									<div class="box-body">
										Server cheat, you have too many servers in your account. Contact support ASAP.
									</div>
								</div>
							</div>
						</div>
					<?php }else{ ?>
						<div class="row">
							<div class="col-lg-12">
								<div class="box box-primary">
									<div class="box-body">
										<div class="form-inline pull-right">
											<!-- 
											<a href="actions.php?a=export_m3u" class="btn btn-primary btn-flat">
												<i class="fas fa-download"></i> Download Playlist
											</a>
											-->

											<!-- 
											<a href="actions.php?a=streams_restart_all" class="btn btn-warning btn-flat" onclick="return confirm('Are you sure? \nPlease allow up to 5 minutes for all streams to restart.')">
												<i class="fas fa-sync"></i> Restart All Channels
											</a>
											-->
											<a href="actions.php?a=channels_stop_all" class="btn btn-danger btn-flat" onclick="return confirm('Are you sure? \nPlease allow up to 2 minutes for all channels to stop.')">
												<i class="fas fa-pause"></i> Stop All Channels
											</a>
											<a href="actions.php?a=channels_start_all" class="btn btn-success btn-flat" onclick="return confirm('Are you sure? \nPlease allow up to 5 minutes for all channels to start.')">
												<i class="fas fa-play"></i> Start All Channels
											</a>
											<select id="server" name="server" class="form-control" onchange="channels_set_server(this);">
												<option value="0">Filter by Server / Reset</option>
												<?php
													foreach($headends as $headend) {
														echo '<option value="'.$headend['id'].'" '.($server_id==$headend['id'] ? 'selected' : '').'>'.$headend['name'].'</option>';
													}
												?>
											</select>
										</div>
									</div>
								</div>
							</div>
						</div>

						<form id="customer_update_multi" action="actions.php?a=channel_multi_options" method="post">
							<div class="row">
								<div id="multi_options_show" class="col-md-4 hidden">
									<div class="box box-default">
										<div class="box-header with-border">
											<h3 class="box-title">
												Multi Channel Options / Update
											</h3>

											<div class="box-tools pull-right">
												<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
												</button>
											</div>
										</div>
										<div class="box-body">
											<div class="row">
												<div class="col-lg-12">
													<div class="form-group">
														<label class="col-sm-3 control-label">Action</label>
														<div class="col-sm-9">
															<select id="multi_options_action" name="multi_options_action" class="form-control" onchange="multi_options_select_channel(this.value);">
																<optgroup label="Enable / Disable">
																	<option value="enable">Enabled Selected Channels</option>
																	<option value="disable">Disable Selected Channels</option>
																</optgroup>
																<optgroup label="Delete">
																	<option value="delete">Delete Selected Channels</option>
																</optgroup>
																<optgroup label="Modify">
																	<option value="change_transcoding_profile">Set Transcoding Profile</option>
																</optgroup>
															</select>
														</div>
													</div>
												</div>
											</div>

											<div class="row hidden" id="multi_options_change_transcoding_profile">
												<hr>
												<div class="col-lg-12">
													<div class="form-group">
														<label class="col-sm-3 control-label">New Profile</label>
														<div class="col-sm-9">
															<select id="transcoding_profile_id" name="transcoding_profile_id" class="form-control">
																<option calue="0">None / Copy Source</option>
																<?php
																	foreach ($transcoding_profiles as $transcoding_profile) {
																		$transcoding_profile['data'] = json_decode($transcoding_profile['data'], true);

																		if($transcoding_profile['data']['bitrate'] == 0){
																			$transcoding_profile['data']['bitrate'] = 'Copy Bitrate';
																		}else{
																			$transcoding_profile['data']['bitrate'] = ($transcoding_profile['data']['bitrate'] / 1024) . ' Mbit';
																		}
																		?>
																			<option value="<?php echo $transcoding_profile['id']; ?>"><?php echo $transcoding_profile['name']; ?> @ <?php echo $transcoding_profile['data']['bitrate']; ?></option>
																		<?php
																	}
																?>
															</select>
															<small>This will stop the selected channels and you will need to start them again manually</small>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="box-footer">
											<button type="submit" class="btn btn-success pull-right">Go</button>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-12">
									<div class="box box-primary">
				            			<div class="box-header">
				              				<h3 class="box-title">
				              					24/7 TV Channels
				              				</h3>
				              				<div class="pull-right">
				              					<a href="actions.php?a=delete_all&type=channels" class="btn btn-danger btn-xs btn-flat" onclick="return confirm('Are you sure?')">Delete All</a>
				              					<button type="button" class="btn btn-success btn-xs btn-flat" data-toggle="modal" data-target="#new_channel_modal">Add New Channel</button>
				              					<button type="button" class="btn btn-success btn-xs btn-flat" data-toggle="modal" data-target="#new_channels_modal">Add Multiple Channels</button>
											</div>
				            			</div>
										<div class="box-body">
											<table id="channels" class="table table-bordered table-striped">
												<thead>
													<tr>
														<th class="no-sort" width="1px">
										                	<input type="checkbox" id="checkAll" />
										                </th>
														<th>Name</th>
														<th class="no-sort" width="200px">Server</th>
														<th class="no-sort" width="1px">Episodes</th>
														<th width="1px">Uptime</th>
														<th width="1px">Conn</th>
														<th width="1px">Status</th>
														<th class="no-sort" width="50px">Actions</th>
													</tr>
												</thead>
												<tbody>
													<?php
														if(isset($_GET['server_id']) && !empty($_GET['server_id'])){
															$query = $conn->query("SELECT * FROM `channels` WHERE `server_id` = '".$server_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
														}else{
															$query = $conn->query("SELECT * FROM `channels` WHERE `user_id` = '".$_SESSION['account']['id']."' ");
														}
														if($query !== FALSE) {
															$channels = $query->fetchAll(PDO::FETCH_ASSOC);

															foreach($channels as $channel) {

																if(empty($channel['cover_photo']) || is_null($channel['cover_photo'])){
																	$channel['cover_photo'] = '';
																}

																foreach($headends as $headend) {
																	if($headend['id'] == $channel['server_id']){
																		$server['name'] = stripslashes($headend['name']);
																	}
																}

																$channel['total_online_clients'] = 0;
																$time_shift = time() - 60;
																$query = $conn->query("SELECT `id` FROM `channel_connection_logs` WHERE `channel_id` = '".$channel['id']."' AND `timestamp` > '".$time_shift."' ");
																$channel['online_clients'] = $query->fetchAll(PDO::FETCH_ASSOC);
																$channel['total_online_clients'] = count($channel['online_clients']);

																if($channel['status'] == 'online') {
																	$status = '<small class="label bg-green full-width">Online</small>';
																}
																if($channel['status'] == 'offline') {
																	$status = '<small class="label bg-red full-width">Offline</small>';
																}
																if($channel['status'] == 'starting') {
																	$status = '<small class="label bg-orange full-width">Starting</small>';
																}

																echo '
																	<tr>
																		<td>
																			<center><input type="checkbox" class="chk" id="checkbox_'.$channel['id'].'" name="channel_ids[]" value="'.$channel['id'].'" onclick="multi_options();"></center>
																		</td>
																		<td>
																			'.stripslashes($channel['name']).' 
																		</td>
																		<td>
																			'.$server['name'].' 
																		</td>
																		<td>
																			'.number_format($channel['total_episodes']).'
																		</td>
																		<td>
																			'.($channel['status']=='online'?$channel['uptime']:'').'
																		</td>
																		<td>
																			'.($channel['status']=='online'?$channel['total_online_clients']:'').'
																		</td>
																		<td>
																			'.$status.'
																		</td>
																		<td style="vertical-align: middle;">
																			<span class="'.($channel['status']=='online' ? '' : 'hidden').'">
																				<a title="Stop Stream" class="btn btn-danger btn-xs btn-flat" href="actions.php?a=channel_stop&id='.$channel['id'].'">
																					<i class="fa fa-pause" aria-hidden="true"></i>
																				</a>
																			</span>

																			<span class="'.($channel['status']=='starting' ? '' : 'hidden').'">
																				<a title="Stop Stream" class="btn btn-danger btn-xs btn-flat" href="actions.php?a=channel_stop&id='.$channel['id'].'">
																					<i class="fa fa-pause" aria-hidden="true"></i>
																				</a>
																			</span>

																			<span class="'.($channel['status']=='offline' ? '' : 'hidden').'">
																				<a title="Start Stream" class="btn btn-success btn-xs btn-flat" href="actions.php?a=channel_start&id='.$channel['id'].'">
																					<i class="fa fa-play" aria-hidden="true"></i>
																				</a>
																			</span>

																			<a title="View / Edit" class="btn btn-info btn-flat btn-xs" href="dashboard.php?c=channel_edit&id='.$channel['id'].'">
																				<i class="fa fa-cogs"></i>
																			</a>

																			<a title="Delete" class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Are you sure?\')" href="actions.php?a=channel_delete&id='.$channel['id'].'">
																				<i class="fa fa-times"></i>
																			</a>
																		</td>
																	</tr>
																';
															}
														}
													?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</form>
					<?php } ?>
				</section>
            </div>

            <form action="actions.php?a=channel_add&type=single" class="form-horizontal form-bordered" method="post">
				<div class="modal fade" id="new_channel_modal" role="dialog">
				    <div class="modal-dialog modal-lg">
				        <div class="modal-content">
				            <div class="modal-header">
				                <button type="button" class="close" data-dismiss="modal">&times;</button>
				                <h4 class="modal-title">Add New Channel</h4>
				            </div>
				            <div class="modal-body">
				            	<div class="row">
									<div class="col-lg-12">
										<div class="form-group">
											<label class="col-sm-2 control-label">Select Server</label>
											<div class="col-sm-10">
												<select id="server_id" name="server_id" class="form-control select2">
													<option>Select a Server</option>
													<?php
														foreach($headends as $headend) {
															echo '<option value="'.$headend['id'].'">'.$headend['name'].'</option>';
														}
													?>
												</select>
											</div>
										</div>
									</div>
								</div>
								
								<div class="row">
					            	<div class="col-lg-12">
										<div class="form-group">
											<label class="col-md-2 control-label" for="name">Channel Name</label>
											<div class="col-md-10">
												<input type="text" class="form-control" id="name" name="name" placeholder="Awesome TV Show" required="required">
											</div>
										</div>
									</div>
								</div>

								<div class="row">
					            	<div class="col-lg-12">
										<div class="form-group">
											<label class="col-md-2 control-label" for="folder">Folder</label>
											<div class="col-md-10">
												<input type="text" class="form-control" id="folder" name="folder" placeholder="/path/to/channels" required="required">
												<small>
													This is the full path to the folder containing this channels episodes.
												</small>
											</div>
										</div>
									</div>
								</div>
				            </div>
				            <div class="modal-footer">
				                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				                <button type="submit" class="btn btn-success">Add Now</button>
				            </div>
				        </div>
				    </div>
				</div>
			</form>

			<form action="actions.php?a=channel_add&type=multi" class="form-horizontal form-bordered" method="post">
				<div class="modal fade" id="new_channels_modal" role="dialog">
				    <div class="modal-dialog modal-lg">
				        <div class="modal-content">
				            <div class="modal-header">
				                <button type="button" class="close" data-dismiss="modal">&times;</button>
				                <h4 class="modal-title">Add Multiple Channels</h4>
				            </div>
				            <div class="modal-body">
				            	<div class="row">
									<div class="col-lg-12">
										<div class="form-group">
											<label class="col-sm-2 control-label">Select Server</label>
											<div class="col-sm-10">
												<select id="server_id" name="server_id" class="form-control select2">
													<option>Select a Server</option>
													<?php
														foreach($headends as $headend) {
															echo '<option value="'.$headend['id'].'">'.$headend['name'].'</option>';
														}
													?>
												</select>
											</div>
										</div>
									</div>
								</div>
								
								<div class="row">
					            	<div class="col-lg-12">
										<div class="form-group">
											<label class="col-md-2 control-label" for="folder">Folder to Scan</label>
											<div class="col-md-10">
												<input type="text" class="form-control" id="folder" name="folder" placeholder="/path/to/channels" required="required">
												<small>
													This is the parent folder containing all your content, not just one specific channel but all channels.<br><br>

													<strong>Please Note:</strong> The initial scan may take a while depending on the number of folders to scan. DO NOT STOP the scan or leave this page!<br><br>
													Once your shows have been added it can take up to 2 hours for episodes to show up in this view. This is because the indexer is working hard in the background to locate and index your media files.
												</small>
											</div>
										</div>
									</div>
								</div>
				            </div>
				            <div class="modal-footer">
				                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				                <button type="submit" class="btn btn-success">Scan Now</button>
				            </div>
				        </div>
				    </div>
				</div>
			</form>
        <?php } ?>

        <?php function channel_edit(){ ?>
        	<?php 
        		global $conn, $wp, $global_settings, $account_details, $site, $whmcs, $product_ids;
            
            	sanity_check();
            
            	$id = get('id');

				$query = $conn->query("SELECT * FROM `channels` WHERE `id` = '".$id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
				if($query !== FALSE) {
					$channel = $query->fetch(PDO::FETCH_ASSOC);
				}

				$query = $conn->query("SELECT * FROM `headend_servers` WHERE `id` = '".$channel['server_id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
				if($query !== FALSE) {
					$headend = $query->fetch(PDO::FETCH_ASSOC);
				}

				$query = $conn->query("SELECT * FROM `channels_files` WHERE `channel_id` = '".$id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
				$episodes = $query->fetchAll(PDO::FETCH_ASSOC);
				$channel['total_episodes'] = count($episodes);

				$query = $conn->query("SELECT * FROM `transcoding_profiles` WHERE `user_id` = '".$_SESSION['account']['id']."' ORDER BY `name` ");
				$transcoding_profiles = $query->fetchAll(PDO::FETCH_ASSOC);
			?>

            <div class="content-wrapper">
				
                <div id="status_message"></div>
                            	
                <section class="content-header">
                    <h1>24/7 Channel > <?php echo stripslashes($channel['name']); ?> <!-- <small>Optional description</small> --></h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="dashboard.php">Dashboard</a></li>
                        <li class="active"><a href="dashboard.php?c=tv_series">TV Series</a></li>
                        <li class="active"><?php echo stripslashes($channel['name']); ?></li>
                    </ol>
                </section>

                <!-- Main content -->
                <?php if($channel['user_id'] != $_SESSION['account']['id']) { ?>
					<section class="content">
						<div class="row">
							<div class="col-lg-12">
								<div class="box box-danger">
			            			<div class="box-header">
			              				<h3 class="box-title">
			              					ERROR
			              				</h3>
			            			</div>
									<div class="box-body">
										<h3>There was an error loading this content.</h3>
										You don't own this content. This security breach has been reported to our security team.
									</div>
								</div>
							</div>
						</div>
					</section>
				<?php }else{ ?>
					<section class="content">
						<div class="row">
							<!-- add episodes -->
							<form action="actions.php?a=channel_episode_add" class="form-horizontal form-bordered" method="post">
								<input type="hidden" name="server_id" value="<?php echo $channel['server_id']; ?>">
								<input type="hidden" name="id" value="<?php echo $id; ?>">
								<div class="modal fade" id="new_episode_modal" role="dialog">
								    <div class="modal-dialog modal-lg">
								        <div class="modal-content">
								            <div class="modal-header">
								                <button type="button" class="close" data-dismiss="modal">&times;</button>
								                <h4 class="modal-title">Add New Episode</h4>
								            </div>
								            <div class="modal-body">
												<div class="row">
									            	<div class="col-lg-12">
														<div class="form-group">
															<label class="col-md-2 control-label" for="name">Episode Name</label>
															<div class="col-md-10">
																<input type="text" class="form-control" id="name" name="name" placeholder="Episode Name." required="required">
															</div>
														</div>
													</div>
												</div>
								            
												<div class="row">
									            	<div class="col-lg-12">
														<div class="form-group">
															<label class="col-md-2 control-label" for="file_location">Full Path</label>
															<div class="col-md-10">
																<input type="text" class="form-control" id="file_location" name="file_location" placeholder="/media/tv_series/The.Simpson.S31E01.mp4" required="required">
																<small>Copy &amp; Paste the full folder path. Example: /media/tv_series/The.Simpson.S31E01.mp4</small>
															</div>
														</div>
													</div>
												</div>
								            </div>

								            <div class="modal-footer">
								                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								                <button type="submit" class="btn btn-success">Add</button>
								            </div>
								        </div>
								    </div>
								</div>
							</form>

							<!-- scan folder -->
							<form action="actions.php?a=channel_episode_scan_folder" class="form-horizontal form-bordered" method="post">
								<input type="hidden" name="server_id" value="<?php echo $channel['server_id']; ?>">
								<input type="hidden" name="id" value="<?php echo $id; ?>">
								<div class="modal fade" id="scan_folder_modal" role="dialog">
								    <div class="modal-dialog modal-lg">
								        <div class="modal-content">
								            <div class="modal-header">
								                <button type="button" class="close" data-dismiss="modal">&times;</button>
								                <h4 class="modal-title">Scan Folder for Media Files</h4>
								            </div>
								            <div class="modal-body">
												<div class="row">
									            	<div class="col-lg-12">
														<div class="form-group">
															<label class="col-md-2 control-label" for="folder_path">Folder Path</label>
															<div class="col-md-10">
																<input type="text" class="form-control" id="folder_path" name="folder_path" placeholder="/media/tv_shows/show/season.01" required="required">
																<small>Enter the full path to the folder you wish to scan. This will only scan for *.avi *.mkv and *.mp4 files. Spaces in folder names are not allowed. Please rename your folder on the server before scanning. We suggest replacing a space with either a <strong>-</strong> or <strong>_</strong> characters.</small>s
															</div>
														</div>
													</div>
												</div>
								            </div>

								            <div class="modal-footer">
								                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								                <button type="submit" class="btn btn-success">Scan & Add</button>
								            </div>
								        </div>
								    </div>
								</div>
							</form>

							<!-- channel settings / options -->
							<div class="col-lg-4">
								<div class="box box-primary">
			            			<form action="actions.php?a=channel_update" class="form-horizontal form-bordered" method="post">
			            				<div class="box-header">
				              				<h3 class="box-title">
				              					24/7 Channel Info / Metadata
				              				</h3>
				              				<div class="pull-right">
				              					<a href="actions.php?a=grab_metadata&type=247_channel&id=<?php echo $id; ?>" class="btn btn-success btn-xs btn-flat">Grab Metadata</a>
											</div>
				            			</div>
										<div class="box-body">
											<input type="hidden" name="id" value="<?php echo $id; ?>">
											<div class="row">
												<div class="col-lg-12">
													<!-- server -->
													<div class="form-group">
														<label class="col-sm-3 control-label">Server</label>
														<div class="col-sm-9">
															<input type="text" class="form-control" id="server_name" name="server_name" value="<?php echo stripslashes($headend['name']); ?>" disabled>
														</div>
													</div>

													<!-- transcoding profile -->
													<div class="form-group">
														<label class="col-md-3 control-label" for="transcoding_profile_id">Transcoding</label>
														<div class="col-md-9">
															<select id="transcoding_profile_id" name="transcoding_profile_id" class="form-control">
																<option <?php if($channel['transcoding_profile_id']=='0'){echo"selected";} ?> value="0">No Transcoding</option>
																<?php 
																	if(is_array($transcoding_profiles)) {
																		foreach ($transcoding_profiles as $transcoding_profile) {
																			$transcoding_profile['data'] = json_decode($transcoding_profile['data'], true);

																			if($transcoding_profile['data']['bitrate'] == 0){
																				$transcoding_profile['data']['bitrate'] = 'Copy Bitrate';
																			}else{
																				$transcoding_profile['data']['bitrate'] = ($transcoding_profile['data']['bitrate'] / 1024) . ' Mbit';
																			}
																			?>
																				<option <?php if($transcoding_profile['id']==$channel['transcoding_profile_id']){echo"selected";} ?> value="<?php echo $transcoding_profile['id']; ?>"><?php echo $transcoding_profile['name']; ?> @ <?php echo $transcoding_profile['data']['bitrate']; ?></option>
																			<?php
																		}
																	}
																?>
															</select>
														</div>
													</div>

													<!-- name -->
													<div class="form-group">
														<label class="col-md-3 control-label" for="name">Name</label>
														<div class="col-md-9">
															<input type="text" class="form-control" id="name" name="name" value="<?php echo stripslashes($channel['name']); ?>" required>
														</div>
													</div>

													<!-- description -->
													<div class="form-group">
														<label class="col-md-3 control-label" for="description">Description</label>
														<div class="col-md-9">
															<textarea id="description" name="description" class="form-control" rows="5"><?php echo stripslashes($channel['description']); ?></textarea>
														</div>
													</div>

													<!-- cover photo -->
													<div class="form-group">
														<label class="col-md-3 control-label" for="cover_photo">Cover Photo</label>
														<div class="col-md-9">
															<input type="text" class="form-control" id="cover_photo" name="cover_photo" value="<?php echo stripslashes($channel['cover_photo']); ?>">
															<small>Leave blank for system default or enter a full valid HTTP URL.</small>
														</div>
													</div>

													<?php if(!empty($channel['cover_photo'])){ ?>
														<div class="form-group">
															<label class="col-md-3 control-label" for="cover_photo_demo"></label>
															<div class="col-md-9">
																<center>
																	<img src="<?php echo stripslashes($channel['cover_photo']); ?>" width="250px" alt="">
																</center>
															</div>
														</div>
													<?php } ?>
												</div>
											</div>
										</div>
										<div class="box-footer">
											<a href="dashboard.php?c=channels" class="btn btn-default">Back</a>
											<button type="submit" class="btn btn-success pull-right">Save Changes</button>
										</div>
									</form>
								</div>
							</div>

							<!-- list existing episodes -->
							<div class="col-lg-8">
								<form action="actions.php?a=channel_update_order" class="form-horizontal form-bordered" method="post">
									<div class="box box-primary">
				            			<div class="box-header">
				              				<h3 class="box-title">
				              					Video Files
				              				</h3>
				              				<div class="pull-right">
				              					<a href="actions.php?a=channel_episode_delete_all&id=<?php echo $id; ?>" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-xs btn-flat">Delete All Episodes</a>
				              					<!--
				              					<button type="button" class="btn btn-success btn-xs btn-flat" data-toggle="modal" data-target="#new_episode_modal">Add Episode</button>
				              					<button type="button" class="btn btn-success btn-xs btn-flat" data-toggle="modal" data-target="#scan_folder_modal">Scan Folder</button>
				              					-->
											</div>
				            			</div>
										<div class="box-body">
											<table id="episodes" class="table table-bordered table-striped">
												<thead>
													<tr>
														<th class="no-sort" width="1px">Season</th>
														<th class="no-sort" width="1px">Episode</th>
														<th>Name</th>
														<th class="no-sort" width="1px"></th>
													</tr>
												</thead>
												<tbody>
													<?php
														foreach($episodes as $episode) {
															echo '
																<tr>
																	<td>
																		<span>'.$episode['season'].'</span>
																	</td>
																	<td>
																		<span>'.$episode['episode'].'</span>
																	</td>
																	<td>
																		<input type="text" class="form-control" id="'.$episode['id'].'_name" name="name['.$episode['id'].']" placeholder="0" value="'.stripslashes($episode['name']).'" required="required" style="width: 100%;">
																		<span class="hidden">'.stripslashes($episode['name']).'</spoan>
																	</td>
																	<td style="vertical-align: middle;">
																		<a title="Delete" class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Are you sure?\')" href="actions.php?a=channel_episode_delete&id='.$episode['id'].'">
																			<i class="fa fa-times"></i>
																		</a>
																	</td>
																</tr>
															';
														}
													?>
												</tbody>
											</table>
										</div>
										<div class="box-footer">
											<button type="submit" class="btn btn-success pull-right">Save Changes</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</section>
				<?php } ?>
            </div>
        <?php } ?>

        <?php function vod(){ ?>
        	<?php 
        		global $conn, $wp, $global_settings, $account_details, $site, $whmcs, $product_ids;
            
            	sanity_check();
           
	        	$query = $conn->query("SELECT `id`,`name`,`gpu_stats` FROM `headend_servers` WHERE `user_id` = '".$_SESSION['account']['id']."' ORDER BY `name` ASC");
				if($query !== FALSE) {
					$headends = $query->fetchAll(PDO::FETCH_ASSOC);
				}

				$query = $conn->query("SELECT * FROM `vod_categories` WHERE `user_id` = '".$_SESSION['account']['id']."' ");
				if($query !== FALSE) {
					$categories = $query->fetchAll(PDO::FETCH_ASSOC);
				}
			?>

            <div class="content-wrapper">
				
                <div id="status_message"></div>   
                            	
                <section class="content-header">
                    <h1>Video on Demand <!-- <small>Optional description</small> --></h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="dashboard.php">Dashboard</a></li>
                        <li class="active">Video on Demand</li>
                    </ol>
                </section>

                <!-- Main content -->
				<section class="content">
					<?php if(total_servers() > $account_details['max_servers']) { ?>
						<div class="row">
							<div class="col-lg-12">
								<div class="box box-danger">
			            			<div class="box-header">
			              				<h3 class="box-title">
			              					ERROR
			              				</h3>
			            			</div>
									<div class="box-body">
										Server cheat, you have too many servers in your account. Contact support ASAP.
									</div>
								</div>
							</div>
						</div>
					<?php }else{ ?>
						<div class="row">
							<div class="col-lg-12">
								<div class="box box-primary">
			            			<div class="box-header">
			              				<h3 class="box-title">
			              					VoD Watch Folders
			              				</h3>
			              				<div class="pull-right">
			              					<button type="button" class="btn btn-success btn-xs btn-flat" data-toggle="modal" data-target="#new_vod_watch_modal">New VoD Watch Folder</button>
										</div>
			            			</div>
									<div class="box-body">
										<form action="actions.php?a=vod_watch_add" class="form-horizontal form-bordered" method="post">
											<div class="modal fade" id="new_vod_watch_modal" role="dialog">
											    <div class="modal-dialog modal-lg">
											        <div class="modal-content">
											            <div class="modal-header">
											                <button type="button" class="close" data-dismiss="modal">&times;</button>
											                <h4 class="modal-title">Add New VoD Watch Folder</h4>
											            </div>
											            <div class="modal-body">
											            	<div class="row">
																<div class="col-lg-12">
																	<div class="form-group">
																		<label class="col-sm-2 control-label">Select Server</label>
																		<div class="col-sm-10">
																			<select id="server_id" name="server_id" class="form-control">
																				<option>Select a Server</option>
																				<?php
																					foreach($headends as $headend) {
																						echo '<option value="'.$headend['id'].'">'.$headend['name'].'</option>';
																					}
																				?>
																			</select>
																		</div>
																	</div>
																</div>
															</div>
															
															<div class="row">
												            	<div class="col-lg-12">
																	<div class="form-group">
																		<label class="col-md-2 control-label" for="folder">Folder Path</label>
																		<div class="col-md-10">
																			<input type="text" class="form-control" id="folder" name="folder" placeholder="/home/downloads" required="required">
																			<small>This must be the absolute path for the folder you wish to monitor. SlipStream will check for new items every 60 minutes.</small>
																		</div>
																	</div>
																</div>
															</div>
											            </div>
											            <div class="modal-footer">
											                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											                <button type="submit" class="btn btn-success">Add</button>
											            </div>
											        </div>
											    </div>
											</div>
										</form>

										<table id="vod_folders" class="table table-bordered table-striped">
											<thead>
												<tr>
													<th>Server</th>
													<th class="no-sort">Folder</th>
													<th class="no-sort" width="50px">Actions</th>
												</tr>
											</thead>
											<tbody>
												<?php
													$query = $conn->query("SELECT * FROM `vod_watch` WHERE `user_id` = '".$_SESSION['account']['id']."' ");
													$vod_folders = $query->fetchAll(PDO::FETCH_ASSOC);

													foreach($vod_folders as $vod_folder) {
														foreach($headends as $headend) {
															if($headend['id'] == $vod_folder['server_id']){
																$server['name'] = stripslashes($headend['name']);
															}
														}

														echo '
															<tr>
																<td>
																	'.$server['name'].'
																</td>
																<td>
																	'.$vod_folder['folder'].'
																</td>
																<td style="vertical-align: middle;">
																	<a title="Delete" class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Are you sure?\')" href="actions.php?a=vod_watch_delete&id='.$vod_folder['id'].'">
																		<i class="fa fa-times"></i>
																	</a>
																</td>
															</tr>
														';
													}
												?>
											</tbody>
										</table>
									</div>
								</div>
							</div>

							<div class="col-lg-12">
								<div class="box box-primary">
			            			<div class="box-header">
			              				<h3 class="box-title">
			              					Video on Demand
			              				</h3>
			              				<div class="pull-right">
			              					<!-- <button type="button" class="btn btn-success btn-xs btn-flat" data-toggle="modal" data-target="#new_vod_modal">New VoD</button> -->
			              					<a href="actions.php?a=delete_all&type=vod" class="btn btn-danger btn-xs btn-flat" onclick="return confirm('Are you sure?')">Delete All</a>
										</div>
			            			</div>
									<div class="box-body">
										<form action="actions.php?a=vod_add" class="form-horizontal form-bordered" method="post">
											<div class="modal fade" id="new_vod_modal" role="dialog">
											    <div class="modal-dialog modal-lg">
											        <div class="modal-content">
											            <div class="modal-header">
											                <button type="button" class="close" data-dismiss="modal">&times;</button>
											                <h4 class="modal-title">Add New Video on Demand</h4>
											            </div>
											            <div class="modal-body">
											            	<div class="row">
																<div class="col-lg-12">
																	<div class="form-group">
																		<label class="col-sm-2 control-label">Select Server</label>
																		<div class="col-sm-10">
																			<select id="server_id" name="server_id" class="form-control">
																				<option>Select a Server</option>
																				<?php
																					foreach($headends as $headend) {
																						echo '<option value="'.$headend['id'].'">'.$headend['name'].'</option>';
																					}
																				?>
																			</select>
																		</div>
																	</div>
																</div>
															</div>
															
															<div class="row">
												            	<div class="col-lg-12">
																	<div class="form-group">
																		<label class="col-md-2 control-label" for="name">Name</label>
																		<div class="col-md-10">
																			<input type="text" class="form-control" id="name" name="name" placeholder="Vodeo on Demand Name." required="required">
																		</div>
																	</div>
																</div>
															</div>
											            </div>
											            <div class="modal-footer">
											                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											                <button type="submit" class="btn btn-success">Add</button>
											            </div>
											        </div>
											    </div>
											</div>
										</form>

										<table id="vod" class="table table-bordered table-striped">
											<thead>
												<tr>
													<th>Name</th>
													<th class="no-sort" width="50px">Actions</th>
												</tr>
											</thead>
											<tbody>
												<?php
													$query = $conn->query("SELECT `id`,`name` FROM `vod` WHERE `user_id` = '".$_SESSION['account']['id']."' ");
													if($query !== FALSE) {
														$vods = $query->fetchAll(PDO::FETCH_ASSOC);

														if(is_array($vods)){
															foreach($vods as $vod) {
																/*
																foreach($headends as $headend) {
																	if($headend['id'] == $vod['server_id']){
																		$server['name'] = stripslashes($headend['name']);
																	}
																}
																*/

																echo '
																	<tr>
																		<td>
																			'.stripslashes($vod['name']).' 
																		</td>
																		<td style="vertical-align: middle;">
																			<a title="View / Edit" class="btn btn-info btn-flat btn-xs" href="dashboard.php?c=vod_edit&id='.$vod['id'].'">
																				<i class="fa fa-eye"></i>
																			</a>

																			<a title="Delete" class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Are you sure?\')" href="actions.php?a=vod_delete&vod_id='.$vod['id'].'">
																				<i class="fa fa-times"></i>
																			</a>
																		</td>
																	</tr>
																';
															}
														}
													}
												?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
				</section>
            </div>
        <?php } ?>

        <?php function vod_edit(){ ?>
        	<?php 
        		global $conn, $wp, $global_settings, $account_details, $site, $whmcs, $product_ids;
            
            	sanity_check();
            
            	$vod_id = get('id');

				$query = $conn->query("SELECT * FROM `vod` WHERE `id` = '".$vod_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
				if($query !== FALSE) {
					$vod = $query->fetch(PDO::FETCH_ASSOC);
				}

				$query = $conn->query("SELECT * FROM `headend_servers` WHERE `id` = '".$vod['server_id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
				if($query !== FALSE) {
					$headend = $query->fetch(PDO::FETCH_ASSOC);
				}
			?>

            <div class="content-wrapper">
				
                <div id="status_message"></div>
                            	
                <section class="content-header">
                    <h1>Video on Demand > <?php echo stripslashes($vod['name']); ?> <!-- <small>Optional description</small> --></h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="dashboard.php">Dashboard</a></li>
                        <li class="active"><a href="dashboard.php?c=vod">Video on Demand</a></li>
                        <li class="active"><?php echo stripslashes($vod['name']); ?></li>
                    </ol>
                </section>

                <!-- Main content -->
                <?php if($vod['user_id'] != $_SESSION['account']['id']) { ?>
					<section class="content">
						<div class="row">
							<div class="col-lg-12">
								<div class="box box-danger">
			            			<div class="box-header">
			              				<h3 class="box-title">
			              					ERROR
			              				</h3>
			            			</div>
									<div class="box-body">
										<h3>There was an error loading this content.</h3>
										You don't own this video on demand. This security breach has been reported to our security team.
									</div>
								</div>
							</div>
						</div>
					</section>
				<?php }else{ ?>
					<section class="content">
						<div class="row">
							<!-- add episodes -->
							<form action="actions.php?a=tv_series_episode_add" class="form-horizontal form-bordered" method="post">
								<input type="hidden" name="server_id" value="<?php echo $series['server_id']; ?>">
								<input type="hidden" name="series_id" value="<?php echo $series_id; ?>">
								<div class="modal fade" id="new_episode_modal" role="dialog">
								    <div class="modal-dialog modal-lg">
								        <div class="modal-content">
								            <div class="modal-header">
								                <button type="button" class="close" data-dismiss="modal">&times;</button>
								                <h4 class="modal-title">Add New Episode</h4>
								            </div>
								            <div class="modal-body">
												<div class="row">
									            	<div class="col-lg-12">
														<div class="form-group">
															<label class="col-md-2 control-label" for="name">Episode Name</label>
															<div class="col-md-10">
																<input type="text" class="form-control" id="name" name="name" placeholder="Stream Name." required="required">
															</div>
														</div>
													</div>
												</div>
								            </div>

								            <div class="modal-body">
												<div class="row">
									            	<div class="col-lg-12">
														<div class="form-group">
															<label class="col-md-2 control-label" for="file_location">Full Path</label>
															<div class="col-md-10">
																<input type="text" class="form-control" id="file_location" name="file_location" placeholder="/home/downloads/file.name.here.mp4" required="required">
																<small>This is the full path to the VoD file. Only update this if you move the file on the server.</small>
															</div>
														</div>
													</div>
												</div>
								            </div>

								            <div class="modal-footer">
								                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								                <button type="submit" class="btn btn-success">Add</button>
								            </div>
								        </div>
								    </div>
								</div>
							</form>

							<!-- vod settings / options -->
							<div class="col-lg-12">
								<div class="box box-primary">
			            			<form action="actions.php?a=vod_update" class="form-horizontal form-bordered" method="post">
			            				<div class="box-header">
				              				<h3 class="box-title">
				              					Video on Demand Info / Metadata
				              				</h3>
				              				<div class="pull-right">
				              					
											</div>
				            			</div>
										<div class="box-body">
											<input type="hidden" name="vod_id" value="<?php echo $vod_id; ?>">
											<div class="row">
												<div class="col-lg-9 col-sm-12">
													<!-- server -->
													<div class="form-group">
														<label class="col-sm-3 control-label">Server</label>
														<div class="col-sm-9">
															<input type="text" class="form-control" id="server_name" name="server_name" value="<?php echo stripslashes($headend['name']); ?>" disabled>
														</div>
													</div>

													<!-- category -->
													<div class="form-group">
														<label class="col-sm-3 control-label" for="category_id">Category</label>
														<div class="col-sm-9">
															<select id="category_id" name="category_id" class="form-control select2">
																<option <?php if($stream[0]['category_id']=='0'){echo"selected";} ?> value="0">None</option>
																<?php
																$query = $conn->query("SELECT * FROM `vod_categories` WHERE `user_id` = '".$_SESSION['account']['id']."' ORDER BY `name` ASC");
																if($query !== FALSE) {
																	$categories = $query->fetchAll(PDO::FETCH_ASSOC);
																	foreach($categories as $category) {
																		echo '<option '.($vod['category_id']==$category['id']?'selected':'').' value="'.$category['id'].'">'.$category['name'].'</option>';
																	}
																}
																?>
															</select>
														</div>
													</div>

													<!-- name -->
													<div class="form-group">
														<label class="col-md-3 control-label" for="name">Name</label>
														<div class="col-md-9">
															<input type="text" class="form-control" id="name" name="name" value="<?php echo stripslashes($vod['name']); ?>" required>
														</div>
													</div>

													<!-- description -->
													<div class="form-group">
														<label class="col-md-3 control-label" for="description">Description</label>
														<div class="col-md-9">
															<textarea id="description" name="description" class="form-control" rows="5"><?php echo stripslashes($vod['description']); ?></textarea>
														</div>
													</div>

													<!-- year -->
													<div class="form-group">
														<label class="col-md-3 control-label" for="year">Year</label>
														<div class="col-md-9">
															<input type="text" class="form-control" id="year" name="year" value="<?php echo stripslashes($vod['year']); ?>">
														</div>
													</div>

													<!-- genre -->
													<div class="form-group">
														<label class="col-md-3 control-label" for="genre">Genre</label>
														<div class="col-md-9">
															<input type="text" class="form-control" id="genre" name="genre" value="<?php echo stripslashes($vod['genre']); ?>">
														</div>
													</div>

													<!-- runtime -->
													<div class="form-group">
														<label class="col-md-3 control-label" for="runtime">Run Time</label>
														<div class="col-md-9">
															<input type="text" class="form-control" id="runtime" name="runtime" value="<?php echo stripslashes($vod['runtime']); ?>">
														</div>
													</div>

													<!-- runtime -->
													<div class="form-group">
														<label class="col-md-3 control-label" for="language">Language</label>
														<div class="col-md-9">
															<input type="text" class="form-control" id="language" name="language" value="<?php echo stripslashes($vod['language']); ?>">
														</div>
													</div>

													<!-- cover photo -->
													<div class="form-group">
														<label class="col-md-3 control-label" for="file_location">File Location</label>
														<div class="col-md-9">
															<input type="text" class="form-control" id="file_location" name="file_location" value="<?php echo stripslashes($vod['file_location']); ?>">
															<small>This is the full path to the VoD file. Only update this if you move the file on the server.</small>

														</div>
													</div>

													<!-- cover photo -->
													<div class="form-group">
														<label class="col-md-3 control-label" for="cover_photo">Cover Photo</label>
														<div class="col-md-9">
															<input type="text" class="form-control" id="cover_photo" name="cover_photo" value="<?php echo stripslashes($vod['cover_photo']); ?>">
															<small>Leave blank for system default or enter a full valid HTTP URL.</small>
														</div>
													</div>
												</div>
												<?php if(!empty($vod['cover_photo'])){ ?>
													<div class="col-lg-3 col-sm-0">
														<center>
															<img src="<?php echo stripslashes($vod['cover_photo']); ?>" width="100%" alt="">
														</center>
													</div>
												<?php } ?>
											</div>
										</div>
										<div class="box-footer">
											<a href="dashboard.php?c=vod" class="btn btn-default">Back</a>
											<button type="submit" class="btn btn-success pull-right">Save Changes</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</section>
				<?php } ?>
            </div>
        <?php } ?>

        <?php function tv_series(){ ?>
        	<?php 
        		global $conn, $wp, $global_settings, $account_details, $site, $whmcs, $product_ids;
            
            	sanity_check();
           
	        	$query = $conn->query("SELECT `id`,`name`,`gpu_stats` FROM `headend_servers` WHERE `user_id` = '".$_SESSION['account']['id']."' ORDER BY `name` ASC");
				if($query !== FALSE) {
					$headends = $query->fetchAll(PDO::FETCH_ASSOC);
				}

				$query = $conn->query("SELECT * FROM `vod_categories` WHERE `user_id` = '".$_SESSION['account']['id']."' ");
				if($query !== FALSE) {
					$categories = $query->fetchAll(PDO::FETCH_ASSOC);
				}
			?>

            <div class="content-wrapper">
				
                <div id="status_message"></div>   
                            	
                <section class="content-header">
                    <h1>TV Series <!-- <small>Optional description</small> --></h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="dashboard.php">Dashboard</a></li>
                        <li class="active">TV Series</li>
                    </ol>
                </section>

                <!-- Main content -->
				<section class="content">
					<?php if(total_servers() > $account_details['max_servers']) { ?>
						<div class="row">
							<div class="col-lg-12">
								<div class="box box-danger">
			            			<div class="box-header">
			              				<h3 class="box-title">
			              					ERROR
			              				</h3>
			            			</div>
									<div class="box-body">
										Server cheat, you have too many servers in your account. Contact support ASAP.
									</div>
								</div>
							</div>
						</div>
					<?php }else{ ?>
						<div class="row">
							<div class="col-lg-12">
								<div class="box box-primary">
			            			<div class="box-header">
			              				<h3 class="box-title">
			              					TV Series
			              				</h3>
			              				<div class="pull-right">
			              					<a href="actions.php?a=delete_all&type=tv_series" class="btn btn-danger btn-xs btn-flat" onclick="return confirm('Are you sure?')">Delete All</a>
			              					<button type="button" class="btn btn-success btn-xs btn-flat" data-toggle="modal" data-target="#new_tv_series_modal">Add New TV Series</button>
										</div>
			            			</div>
									<div class="box-body">
										<form action="actions.php?a=tv_series_add" class="form-horizontal form-bordered" method="post">
											<div class="modal fade" id="new_tv_series_modal" role="dialog">
											    <div class="modal-dialog modal-lg">
											        <div class="modal-content">
											            <div class="modal-header">
											                <button type="button" class="close" data-dismiss="modal">&times;</button>
											                <h4 class="modal-title">Add New TV Series</h4>
											            </div>
											            <div class="modal-body">
											            	<div class="row">
																<div class="col-lg-12">
																	<div class="form-group">
																		<label class="col-sm-2 control-label">Select Server</label>
																		<div class="col-sm-10">
																			<select id="server_id" name="server_id" class="form-control select2">
																				<option>Select a Server</option>
																				<?php
																					foreach($headends as $headend) {
																						echo '<option value="'.$headend['id'].'">'.$headend['name'].'</option>';
																					}
																				?>
																			</select>
																		</div>
																	</div>
																</div>
															</div>
															
															<div class="row">
												            	<div class="col-lg-12">
																	<div class="form-group">
																		<label class="col-md-2 control-label" for="folder">Folder to Scan</label>
																		<div class="col-md-10">
																			<input type="text" class="form-control" id="folder" name="folder" placeholder="/path/to/channels" required="required">
																			<small>
																				This is the parent folder containing all your content, not just one specific show / item but all content.<br><br>

																				<strong>Please Note:</strong> The initial scan may take a while depending on the number of folders to scan. DO NOT STOP the scan or leave this page!
																			</small>
																		</div>
																	</div>
																</div>
															</div>
											            </div>
											            <div class="modal-footer">
											                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											                <button type="submit" class="btn btn-success">Add</button>
											            </div>
											        </div>
											    </div>
											</div>
										</form>

										<table id="tv_series" class="table table-bordered table-striped">
											<thead>
												<tr>
													<th>Name</th>
													<th class="no-sort" width="200px">Server</th>
													<th class="no-sort" width="1px">Episodes</th>
													<!-- <th class="no-sort" width="1px">Status</th> -->
													<th class="no-sort" width="50px">Actions</th>
												</tr>
											</thead>
											<tbody>
												<?php
													$query = $conn->query("SELECT * FROM `tv_series` WHERE `user_id` = '".$_SESSION['account']['id']."' ");
													if($query !== FALSE) {
														$tv_series = $query->fetchAll(PDO::FETCH_ASSOC);

														foreach($tv_series as $series) {
															if(empty($series['cover_photo']) || is_null($series['cover_photo'])){
																$series['cover_photo'] = 'http://'.$global_settings['cms_access_url'].'/no_image_available.jpg';
															}

															foreach($headends as $headend) {
																if($headend['id'] == $series['server_id']){
																	$server['name'] = stripslashes($headend['name']);
																}
															}

															if($series['status'] == 'online') {
																$status = '<small class="label bg-green full-width">Online</small>';
															}
															if($series['status'] == 'offline') {
																$status = '<small class="label bg-red full-width">Ofline</small>';
															}
															if($series['status'] == 'starting') {
																$status = '<small class="label bg-orange full-width">Starting</small>';
															}

															echo '
																<tr>
																	<td>
																		'.stripslashes($series['name']).' 
																	</td>
																	<td>
																		'.$server['name'].' 
																	</td>
																	<td>
																		'.number_format($series['total_episodes']).'
																	</td>
																	<!--
																	<td>
																		'.$status.'
																	</td>
																	-->
																	<td style="vertical-align: middle;">
																		<!-- 
																		<span class="'.($series['status']=='online' ? '' : 'hidden').'">
																			<a title="Stop Stream" class="btn btn-danger btn-xs btn-flat" href="actions.php?a=tv_series_stop&id='.$series['id'].'">
																				<i class="fa fa-pause" aria-hidden="true"></i>
																			</a>
																		</span>

																		<span class="'.($series['status']=='offline' ? '' : 'hidden').'">
																			<a title="Start Stream" class="btn btn-success btn-xs btn-flat" href="actions.php?a=tv_series_start&id='.$series['id'].'">
																				<i class="fa fa-play" aria-hidden="true"></i>
																			</a>
																		</span>
																		-->

																		<a title="View / Edit" class="btn btn-info btn-flat btn-xs" href="dashboard.php?c=tv_series_edit&id='.$series['id'].'">
																			<i class="fa fa-eye"></i>
																		</a>

																		<a title="Delete" class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Are you sure?\')" href="actions.php?a=tv_series_delete&series_id='.$series['id'].'">
																			<i class="fa fa-times"></i>
																		</a>
																	</td>
																</tr>
															';
														}
													}
												?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
				</section>
            </div>
        <?php } ?>

        <?php function tv_series_edit(){ ?>
        	<?php 
        		global $conn, $wp, $global_settings, $account_details, $site, $whmcs, $product_ids;
            
            	sanity_check();
            	
            	$series_id = get('id'); 

				$query = $conn->query("SELECT * FROM `tv_series` WHERE `id` = '".$series_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
				if($query !== FALSE) {
					$series = $query->fetch(PDO::FETCH_ASSOC);
				}

				$query = $conn->query("SELECT * FROM `headend_servers` WHERE `id` = '".$series['server_id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
				if($query !== FALSE) {
					$headend = $query->fetch(PDO::FETCH_ASSOC);
				}

				$query = $conn->query("SELECT * FROM `tv_series_files` WHERE `tv_series_id` = '".$series_id."' AND `user_id` = '".$_SESSION['account']['id']."' ORDER BY `order` ASC");
				if($query !== FALSE) {
					$episodes = $query->fetchAll(PDO::FETCH_ASSOC);
					$series['total_episodes'] = count($episodes);
				}
			?>

            <div class="content-wrapper">
				
                <div id="status_message"></div>
                            	
                <section class="content-header">
                    <h1>TV Series > <?php echo stripslashes($series['name']); ?> <!-- <small>Optional description</small> --></h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="dashboard.php">Dashboard</a></li>
                        <li class="active"><a href="dashboard.php?c=tv_series">TV Series</a></li>
                        <li class="active"><?php echo stripslashes($series['name']); ?></li>
                    </ol>
                </section>

                <!-- Main content -->
                <?php if($series['user_id'] != $_SESSION['account']['id']) { ?>
					<section class="content">
						<div class="row">
							<div class="col-lg-12">
								<div class="box box-danger">
			            			<div class="box-header">
			              				<h3 class="box-title">
			              					ERROR
			              				</h3>
			            			</div>
									<div class="box-body">
										<h3>There was an error loading this content.</h3>
										You don't own this series. This security breach has been reported to our security team.
									</div>
								</div>
							</div>
						</div>
					</section>
				<?php }else{ ?>
					<section class="content">
						<div class="row">
							<!-- add episodes -->
							<form action="actions.php?a=tv_series_episode_add" class="form-horizontal form-bordered" method="post">
								<input type="hidden" name="server_id" value="<?php echo $series['server_id']; ?>">
								<input type="hidden" name="series_id" value="<?php echo $series_id; ?>">
								<div class="modal fade" id="new_episode_modal" role="dialog">
								    <div class="modal-dialog modal-lg">
								        <div class="modal-content">
								            <div class="modal-header">
								                <button type="button" class="close" data-dismiss="modal">&times;</button>
								                <h4 class="modal-title">Add New Episode</h4>
								            </div>
								            <div class="modal-body">
												<div class="row">
									            	<div class="col-lg-12">
														<div class="form-group">
															<label class="col-md-2 control-label" for="name">Episode Name</label>
															<div class="col-md-10">
																<input type="text" class="form-control" id="name" name="name" placeholder="Stream Name." required="required">
															</div>
														</div>
													</div>
												</div>
								            </div>

								            <div class="modal-body">
												<div class="row">
									            	<div class="col-lg-12">
														<div class="form-group">
															<label class="col-md-2 control-label" for="file_location">Full Path</label>
															<div class="col-md-10">
																<input type="text" class="form-control" id="file_location" name="file_location" placeholder="/var/www/html/play/tv_series/file.name.here.mp4" required="required">
																<small>Copy and Paste the 'Full Path' from the list below. EG: /var/www/html/play/tv_series/The.Simpson.S31E01.mp4</small>
															</div>
														</div>
													</div>
												</div>
								            </div>

								            <iframe class="embed-responsive-item" src="http://<?php echo $headend['wan_ip_address']; ?>:<?php echo $headend['http_stream_port']; ?>/play/tv_series/filebrowser.php" allowfullscreen style="width: 100%; height: 300px;"></iframe>

								            <div class="modal-footer">
								                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								                <button type="submit" class="btn btn-success">Add</button>
								            </div>
								        </div>
								    </div>
								</div>
							</form>

							<!-- tv series settings / options -->
							<div class="col-lg-4">
								<div class="box box-primary">
			            			<form action="actions.php?a=tv_series_update" class="form-horizontal form-bordered" method="post">
			            				<div class="box-header">
				              				<h3 class="box-title">
				              					TV Series Info / Metadata
				              				</h3>
				              				<div class="pull-right">
				              					<a href="actions.php?a=grab_metadata&type=tv_series&id=<?php echo $series_id; ?>" class="btn btn-success btn-xs btn-flat">Grab Metadata</a>
											</div>
				            			</div>
										<div class="box-body">
											<input type="hidden" name="series_id" value="<?php echo $series_id; ?>">
											<div class="row">
												<div class="col-lg-12">
													<!-- server -->
													<div class="form-group">
														<label class="col-sm-3 control-label">Server</label>
														<div class="col-sm-9">
															<input type="text" class="form-control" id="server_name" name="server_name" value="<?php echo stripslashes($headend['name']); ?>" disabled>
														</div>
													</div>

													<!-- name -->
													<div class="form-group">
														<label class="col-md-3 control-label" for="name">Name</label>
														<div class="col-md-9">
															<input type="text" class="form-control" id="name" name="name" value="<?php echo stripslashes($series['name']); ?>" required>
														</div>
													</div>

													<!-- description -->
													<div class="form-group">
														<label class="col-md-3 control-label" for="description">Description</label>
														<div class="col-md-9">
															<textarea id="description" name="description" class="form-control" rows="5"><?php echo stripslashes($series['description']); ?></textarea>
														</div>
													</div>

													<!-- cover photo -->
													<div class="form-group">
														<label class="col-md-3 control-label" for="cover_photo">Cover Photo</label>
														<div class="col-md-9">
															<input type="text" class="form-control" id="cover_photo" name="cover_photo" value="<?php echo stripslashes($series['cover_photo']); ?>">
															<small>Leave blank for system default or enter a full valid HTTP URL.</small>
														</div>
													</div>

													<?php if(!empty($series['cover_photo'])){ ?>
														<div class="form-group">
															<label class="col-md-3 control-label" for="cover_photo_demo"></label>
															<div class="col-md-9">
																<center>
																	<img src="<?php echo stripslashes($series['cover_photo']); ?>" width="250px" alt="">
																</center>
															</div>
														</div>
													<?php } ?>
												</div>
											</div>
										</div>
										<div class="box-footer">
											<a href="dashboard.php?c=tv_series" class="btn btn-default">Back</a>
											<button type="submit" class="btn btn-success pull-right">Save Changes</button>
										</div>
									</form>
								</div>
							</div>

							<!-- list existing episodes -->
							<div class="col-lg-8">
								<form action="actions.php?a=tv_series_update_order" class="form-horizontal form-bordered" method="post">
									<div class="box box-primary">
				            			<div class="box-header">
				              				<h3 class="box-title">
				              					Video Files
				              				</h3>
				              				<div class="pull-right">
				              					<!-- <button type="button" class="btn btn-success btn-xs btn-flat" data-toggle="modal" data-target="#new_episode_modal">Add Episode</button> -->
				              					<a href="actions.php?a=tv_series_episode_delete_all&id=<?php echo $series_id; ?>" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-xs btn-flat">Delete All Episodes</a>
											</div>
				            			</div>
										<div class="box-body">
											<table id="episodes" class="table table-bordered table-striped">
												<thead>
													<tr>
														<th class="no-sort" width="1px">Season</th>
														<th class="no-sort" width="1px">Episode</th>
														<th>Name</th>
														<th class="no-sort" width="20px">Release</th>
														<th class="no-sort" width="1px"></th>
													</tr>
												</thead>
												<tbody>
													<?php
														foreach($episodes as $episode) {
															echo '
																<tr>
																	<td>
																		<span>'.$episode['season'].'</span>
																	</td>
																	<td>
																		<span>'.$episode['episode'].'</span>
																	</td>
																	<td>
																		<input type="text" class="form-control" id="'.$episode['id'].'_name" name="name['.$episode['id'].']" placeholder="0" value="'.stripslashes($episode['name']).'" required="required" style="width: 100%;">
																		<span class="hidden">'.stripslashes($episode['name']).'</spoan>
																	</td>
																	<td>
																		<input type="text" class="form-control" id="'.$episode['id'].'_release_date" name="release['.$episode['id'].']" placeholder="0" value="'.$episode['release_date'].'">
																	</td>
																	<td style="vertical-align: middle;">
																		<a title="Delete" class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Are you sure?\')" href="actions.php?a=tv_series_episode_delete&id='.$episode['id'].'">
																			<i class="fa fa-times"></i>
																		</a>
																	</td>
																</tr>
															';
														}
													?>
												</tbody>
											</table>
										</div>
										<div class="box-footer">
											<button type="submit" class="btn btn-success pull-right">Save Changes</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</section>
				<?php } ?>
            </div>
        <?php } ?>

        <?php function premium_dns(){ ?>
        	<?php 
        		global $conn, $wp, $global_settings, $account_details, $site, $whmcs, $product_ids;
            
            	sanity_check();
            
            	$dns_modals = '';

        		$query = $conn->query("SELECT `id`,`name`,`gpu_stats`,`wan_ip_address` FROM `headend_servers` WHERE `user_id` = '".$_SESSION['account']['id']."' ORDER BY `name` ASC");
				if($query !== FALSE) {
					$headends = $query->fetchAll(PDO::FETCH_ASSOC);
				}
			?>

            <div class="content-wrapper">
				
                <div id="status_message"></div>   
                            	
                <section class="content-header">
                    <h1>Premium DNS Manager<!-- <small>Optional description</small> --></h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="dashboard.php">Dashboard</a></li>
                        <li class="active">Premium DNS Manager</li>
                    </ol>
                </section>

                <!-- Main content -->
                <?php if($account_details['addon_dns'] == 'no'){ ?>
                	<section class="content">
						<div class="row">
							<div class="col-lg-12">
								<div class="box box-danger">
			            			<div class="box-header">
			              				<h3 class="box-title">
			              					ERROR
			              				</h3>
			            			</div>
									<div class="box-body">
										<h3>Premium Addon: Premium DNS Manager</h3>
										You do not own this addon yet. You can purchase this addon for a one-time price of $99 in our online store.

										<?php if(isset($_GET['dev'])) { ?>
											<hr>
											<pre>
												<?php print_r($account_details); ?>
											</pre>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</section>
                <?php }else{ ?>
					<section class="content">
						<div class="row">
							<div class="col-lg-12">
								<div class="box box-primary">
			            			<div class="box-header">
			              				<h3 class="box-title">
			              					Premium DNS Manager
			              				</h3>
			              				<div class="pull-right">
			              					<button type="button" class="btn btn-success btn-xs btn-flat" data-toggle="modal" data-target="#new_host_modal">Add DNS Host</button>
										</div>
			            			</div>
									<div class="box-body">
										<form action="actions.php?a=dns_add" class="form-horizontal form-bordered" method="post">
											<div class="modal fade" id="new_host_modal" role="dialog">
											    <div class="modal-dialog">
											        <div class="modal-content">
											            <div class="modal-header">
											                <button type="button" class="close" data-dismiss="modal">&times;</button>
											                <h4 class="modal-title">Add DNS Record</h4>
											            </div>
											            <div class="modal-body">
											            	<div class="row">
																<div class="col-lg-12">
																	<div class="form-group">
																		<label class="col-sm-2 control-label">Server</label>
																		<div class="col-sm-10">
																			<select id="server_id" name="server_id" class="form-control">
																				<?php
																					foreach($headends as $headend) {
																						echo '<option value="'.$headend['id'].'">'.$headend['name'].'</option>';
																					}
																				?>
																			</select>
																		</div>
																	</div>
																</div>
															</div>

															<div class="row">
																<div class="col-lg-6">
																	<div class="form-group">
																		<label class="col-md-4 control-label" for="hostname">Hostname</label>
																		<div class="col-md-8">
																			<input type="text" class="form-control" id="hostname" name="hostname" value="awesome-server-1" required="">
																		</div>
																	</div>
																</div>
																<div class="col-lg-6">
																	<div class="form-group">
																		<label class="col-sm-4 control-label">Domain</label>
																		<div class="col-sm-8">
																			<select id="domain" name="domain" class="form-control">
																				<option value="akamaihdcdn.com">akamaihdcdn.com</option>
																				<option value="slipdns.com">slipdns.com</option>
																				<option value="streamcdn.com">streamcdn.com</option>
																			</select>
																		</div>
																	</div>
																</div>
															</div>
											            </div>
											            <div class="modal-footer">
											                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											                <button type="submit" class="btn btn-success">Add DNS Record</button>
											            </div>
											        </div>
											    </div>
											</div>
										</form>

										<table id="premium_dns" class="table table-bordered table-striped">
											<thead>
												<tr>
													<th width="10px">ID</th>										<!-- 1 -->
													<th>Host</th>													<!-- 2 -->
													<th>IP</th>														<!-- 3 -->
													<th>Server</th>													<!-- 4 -->
													<th class="no-sort" width="75px">Actions</th>					<!-- 5 -->
												</tr>
											</thead>
											<tbody>
												<?php

													$time_shift = time() - 60;
													$query = $conn->query("SELECT * FROM `addon_dns` WHERE `user_id` = '".$_SESSION['account']['id']."' ");
													if($query !== FALSE) {
														$dns_records = $query->fetchAll(PDO::FETCH_ASSOC);

														foreach($dns_records as $dns_record) {
															/*
															if($customer['status'] == 'enabled') {
																$status = '<span class="label label-success full-width" style="width: 100%;">Enabled</span>';
															}elseif($customer['status'] == 'disabled') {
																$status = '<span class="label label-danger full-width" style="width: 100%;">Disabled</span>';
															}elseif($customer['status'] == 'expired') {
																$status = '<span class="label label-info full-width" style="width: 100%;">Expired</span>';
															}else{
																$status = '<span class="label label-warning full-width" style="width: 100%;">'.ucfirst($customer['status']).'</span>';
															}
															*/

															foreach($headends as $headend) {
																if($dns_record['server_id'] == $headend['id']) {
																	$dns_record['server_name'] 			= stripslashes($headend['name']);
																	$dns_record['server_ip_address'] 	= stripslashes($headend['wan_ip_address']);
																}
															}
															echo '
																<tr>
																	<td>
																		'.$dns_record['id'].'
																	</td>
																	<td>
																		'.$dns_record['hostname'].'.'.$dns_record['domain'].'
																	</td>
																	<td>
																		'.$dns_record['server_ip_address'].'
																	</td>
																	<td>
																		'.$dns_record['server_name'].'
																	</td>
																	<td style="vertical-align: middle;">
																		<a title="Delete" class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'If you delete this record, any stream links using this hostname will stop working. \nAre you sure?\')" href="actions.php?a=dns_delete&id='.$dns_record['id'].'">
																			<i class="fa fa-times"></i>
																		</a>
																	</td>
																</tr>
															';
														}
													}
												?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</section>
				<?php } ?>
            </div>
        <?php } ?>

        <?php function remote_playlists(){ ?>
        	<?php 
        		global $conn, $wp, $global_settings, $account_details, $site, $whmcs, $product_ids;
            
            	sanity_check();
            
            	$playlists_modals = ''; 

        		$query = $conn->query("SELECT * FROM `remote_playlists` WHERE `user_id` = '".$_SESSION['account']['id']."' ");
				if($query !== FALSE) {
					$playlists = $query->fetchAll(PDO::FETCH_ASSOC);
				}
			?>

            <div class="content-wrapper">
				
                <div id="status_message"></div>   
                            	
                <section class="content-header">
                    <h1>Remote Playlist Manager <!-- <small>Optional description</small> --></h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="dashboard.php">Dashboard</a></li>
                        <li class="active">Remote Playlist Manager</li>
                    </ol>
                </section>

                <!-- Main content -->
                <?php if($account_details['addon_playlist_manager'] == 'no'){ ?>
                	<section class="content">
						<div class="row">
							<div class="col-lg-12">
								<div class="box box-danger">
			            			<div class="box-header">
			              				<h3 class="box-title">
			              					ERROR
			              				</h3>
			            			</div>
									<div class="box-body">
										<h3>Premium Addon: Remote Playlist Manager</h3>
										You do not own this addon yet. You can purchase this addon for a one-time price of $99 in our online store.

										<?php if(isset($_GET['dev'])) { ?>
											<hr>
											<pre>
												<?php print_r($account_details); ?>
											</pre>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</section>
                <?php }else{ ?>
					<section class="content">
						<div class="row">
							<div class="col-lg-12">
								<div class="box box-primary">
			            			<div class="box-header">
			              				<h3 class="box-title">
			              					Remote Playlist Manager
			              				</h3>
			              				<div class="pull-right">
			              					<button type="button" class="btn btn-success btn-xs btn-flat" data-toggle="modal" data-target="#new_platlist_modal">Add Remote Playlist</button>
										</div>
			            			</div>
									<div class="box-body">
										<?php if(isset($_GET['dev'])) { ?>
											<hr>
											<pre>
												<?php print_r($playlists); ?>
											</pre>
										<?php } ?>
										<form action="actions.php?a=remote_playlist_add" class="form-horizontal form-bordered" method="post">
											<div class="modal fade" id="new_platlist_modal" role="dialog">
											    <div class="modal-dialog">
											        <div class="modal-content">
											            <div class="modal-header">
											                <button type="button" class="close" data-dismiss="modal">&times;</button>
											                <h4 class="modal-title">Add New Remote Playlist</h4>
											            </div>
											            <div class="modal-body">
															<div class="row">
																<div class="col-lg-12">
																	<div class="form-group">
																		<label class="col-md-2 control-label" for="name">Name</label>
																		<div class="col-md-10">
																			<input type="text" class="form-control" id="name" name="name" placeholder="IPTV Providor" required="">
																		</div>
																	</div>
																</div>
																<div class="col-lg-12">
																	<div class="form-group">
																		<label class="col-md-2 control-label" for="url">URL</label>
																		<div class="col-md-10">
																			<input type="text" class="form-control" id="url" name="url" placeholder="http://iptv.ddns.org/get.php?user=......." required="">
																		</div>
																	</div>
																</div>
															</div>
											            </div>
											            <div class="modal-footer">
											                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											                <button type="submit" class="btn btn-success">Add Remote Playlist</button>
											            </div>
											        </div>
											    </div>
											</div>
										</form>

										<table id="remote_playlists" class="table table-bordered table-striped">
											<thead>
												<tr>
													<th width="10px">ID</th>
													<th>Name</th>
													<th>URL</th>
													<th>Streams</th>
													<th>Status</th>
													<th class="no-sort" width="75px">Actions</th>
												</tr>
											</thead>
											<tbody>
												<?php
													foreach($playlists as $playlist) {
														/*
														if($customer['status'] == 'enabled') {
															$status = '<span class="label label-success full-width" style="width: 100%;">Enabled</span>';
														}elseif($customer['status'] == 'disabled') {
															$status = '<span class="label label-danger full-width" style="width: 100%;">Disabled</span>';
														}elseif($customer['status'] == 'expired') {
															$status = '<span class="label label-info full-width" style="width: 100%;">Expired</span>';
														}else{
															$status = '<span class="label label-warning full-width" style="width: 100%;">'.ucfirst($customer['status']).'</span>';
														}
														*/

														/*
														$ch = curl_init($playlist['url']);
														curl_setopt($ch, CURLOPT_HEADER, true);    // we want headers
														curl_setopt($ch, CURLOPT_NOBODY, true);    // we don't need body
														curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
														curl_setopt($ch, CURLOPT_TIMEOUT,10);
														$output = curl_exec($ch);
														$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
														curl_close($ch);
														*/
														// echo 'HTTP code: ' . $httpcode;

														// $remote_playlist_content = remote_content($playlist['url']);

														$remote_playlist_content 		= @file_get_contents("http://".$global_settings['cms_access_url']."/actions.php?a=inspect_m3u_encoded&url=".base64_encode($playlist['url']));
				  										$remote_playlist_content 		= json_decode($remote_playlist_content, true);

														if(!isset($remote_playlist_content['status'])) {
															$playlist['status'] = '<span class="label label-success full-width" style="width: 100%;">Online</span>';
															$playlist['total_streams'] = count($remote_playlist_content);
														}else{
															$playlist['status'] = '<span class="label label-danger full-width" style="width: 100%;">Offline</span>';
															$playlist['total_streams'] = 0;
														}

														echo '
															<tr>
																<td>
																	'.$playlist['id'].'
																</td>
																<td>
																	'.stripslashes($playlist['name']).'
																</td>
																<td>
																	'.$playlist['url'].'																
																</td>
																<td>
																	'.number_format($playlist['total_streams']).'
																</td>
																<td>
																	'.$playlist['status'].'
																</td>
																<td style="vertical-align: middle;">
																	'.($remote_playlist_content?'
																		<a title="View Playlist" class="btn btn-info btn-flat btn-xs" href="dashboard.php?c=remote_playlist&playlist_id='.$playlist['id'].'">
																			<i class="fa fa-gears"></i>
																		</a>':
																		'<a title="View Playlist" class="btn btn-info btn-flat btn-xs disabled" href="">
																			<i class="fa fa-gears"></i>
																		</a>'
																	).'
																	<a title="Delete" class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Are you sure?\')" href="actions.php?a=remote_playlist_delete&id='.$playlist['id'].'">
																		<i class="fa fa-times"></i>
																	</a>
																</td>
															</tr>
														';
													}
												?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</section>
				<?php } ?>
            </div>
        <?php } ?>

        <?php function remote_playlist(){ ?>
        	<?php 
        		global $conn, $wp, $global_settings, $account_details, $site, $whmcs, $product_ids;
            
            	sanity_check();
				
				$playlist_id = get('playlist_id');

        		$query = $conn->query("SELECT * FROM `remote_playlists` WHERE `id` = '".$playlist_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
				if($query !== FALSE) {
					$playlist = $query->fetch(PDO::FETCH_ASSOC);
				}

				if($playlist){
					// parse the playlist
					$streams_raw 		= @file_get_contents("http://".$global_settings['cms_access_url']."/actions.php?a=inspect_m3u_encoded&url=".base64_encode($playlist['url']));
				  	$streams 			= json_decode($streams_raw, true);
				  	asort($streams);
				}
			?>

            <div class="content-wrapper">
				
                <div id="status_message"></div>   
                            	
                <section class="content-header">
                    <h1>Playlist: <?php echo stripslashes($playlist['name']); ?> <!-- <small>Optional description</small> --></h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="dashboard.php">Dashboard</a></li>
                        <li class="active"><a href="dashboard.php?c=remote_playlists">Remote Playlist Manager</a></li>
                        <li class="active">Playlist: <?php echo stripslashes($playlist['name']); ?></li>
                    </ol>
                </section>

                <!-- Main content -->
                <?php if($account_details['addon_playlist_manager'] == 'no'){ ?>
                	<section class="content">
						<div class="row">
							<div class="col-lg-12">
								<div class="box box-danger">
			            			<div class="box-header">
			              				<h3 class="box-title">
			              					ERROR
			              				</h3>
			            			</div>
									<div class="box-body">
										<h3>Premium Addon: Remote Playlist Manager</h3>
										You do not own this addon yet. You can purchase this addon for a one-time price of $99 in our online store.

										<?php if(isset($_GET['dev'])) { ?>
											<hr>
											<pre>
												<?php print_r($account_details); ?>
											</pre>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</section>
                <?php }else{ ?>
					<section class="content">
						<div class="row">
							<div class="col-lg-12">
								<div class="box box-primary">
			            			<div class="box-header">
			              				<h3 class="box-title">
			              					Playlist: <?php echo stripslashes($playlist['name']); ?>
			              				</h3>
			              				<div class="pull-right">
			              					
										</div>
			            			</div>
									<div class="box-body">
										<table id="remote_playlist" class="table table-bordered table-striped">
											<thead>
												<tr>
													<th width="200px">Name</th>
													<th width="200px">Category</th>
													<th>URL</th>
													<th width="40px">In Use</th>
												</tr>
											</thead>
											<tbody>
												<?php
													foreach($streams as $stream) {
														// ready name
														$name 				= $stream['title'];
														$name 				= str_replace(array(':',';'), '', $name);
														$name 				= trim($name);

														// ready source
														$source 			= $stream['url'];
														$source 			= trim($source);
														$source 			= str_replace(' ', '', $source);

														// is source in use
														$sql = "
													        SELECT count(id) as total_streams 
													        FROM `streams` 
													        WHERE `stream_type` = 'input' AND `source` = '".$source."' AND `user_id` = '".$_SESSION['account']['id']."' 
													    ";
													    $query      		= $conn->query($sql);
													    $results    		= $query->fetchAll(PDO::FETCH_ASSOC);
													    $total_streams      = $results[0]['total_streams'];

													    if($total_streams == 0){
													    	$stream_in_use = '<span class="label label-danger full-width" style="width: 100%;">'.$total_streams.'</span>';
													    }else{
													    	$stream_in_use = '<span class="label label-success full-width" style="width: 100%;">'.$total_streams.'</span>';
													    }

													    if(!isset($stream['tvgroup']) || empty($stream['tvgroup'])) {
													    	$stream['tvgroup'] = 'None';
													    }

														echo '
															<tr>
																<td>
																	'.$name.'
																</td>
																<td>
																	'.$stream['tvgroup'].'
																</td>
																<td>
																	<input type="text" class="form-control input-sm" style="width: 100%;" value="'.$source.'" onClick="this.select();">
																	<span class="hidden">'.$source.'</span>
																</td>
																<td>
																	'.$stream_in_use.'
																</td>
															</tr>
														';
													}
												?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</section>
				<?php } ?>
            </div>
        <?php } ?>

        <?php function roku_devices(){ ?>
        	<?php 
        		global $conn, $wp, $global_settings, $account_details, $site, $whmcs, $product_ids;
            
            	sanity_check();
            
            	$devices_modals = '';

        		$query = $conn->query("SELECT `id`,`name` FROM `headend_servers` WHERE `user_id` = '".$_SESSION['account']['id']."' ORDER BY `name` ASC");
				if($query !== FALSE) {
					$headends = $query->fetchAll(PDO::FETCH_ASSOC);
				}

        		$query = $conn->query("SELECT * FROM `roku_devices` WHERE `user_id` = '".$_SESSION['account']['id']."' ");
				if($query !== FALSE) {
					$devices = $query->fetchAll(PDO::FETCH_ASSOC);
				}
			?>

            <div class="content-wrapper">
				
                <div id="status_message"></div>   
                            	
                <section class="content-header">
                    <h1>Roku Device Manager <!-- <small>Optional description</small> --></h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="dashboard.php">Dashboard</a></li>
                        <li class="active">Roku Device Manager</li>
                    </ol>
                </section>

                <!-- Main content -->
                <?php if($account_details['addon_roku_manager'] == 'no'){ ?>
                	<section class="content">
						<div class="row">
							<div class="col-lg-12">
								<div class="box box-danger">
			            			<div class="box-header">
			              				<h3 class="box-title">
			              					ERROR
			              				</h3>
			            			</div>
									<div class="box-body">
										<h3>Premium Addon: Roku Device Manager</h3>
										You do not own this addon yet. You can purchase this addon for a one-time price of $99 in our online store.

										<?php if(isset($_GET['dev'])) { ?>
											<hr>
											<pre>
												<?php print_r($account_details); ?>
											</pre>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</section>
                <?php }else{ ?>
					<section class="content">
						<div class="row">
							<div class="col-lg-12">
								<div class="box box-primary">
			            			<div class="box-header">
			              				<h3 class="box-title">
			              					Roku Device Manager
			              				</h3>
			              				<div class="pull-right">
			              					<button type="button" class="btn btn-success btn-xs btn-flat" data-toggle="modal" data-target="#new_device_modal">Add Roku Device</button>
										</div>
			            			</div>
									<div class="box-body">
										<form action="actions.php?a=roku_device_add" class="form-horizontal form-bordered" method="post">
											<div class="modal fade" id="new_device_modal" role="dialog">
											    <div class="modal-dialog">
											        <div class="modal-content">
											            <div class="modal-header">
											                <button type="button" class="close" data-dismiss="modal">&times;</button>
											                <h4 class="modal-title">Add New Roku Device</h4>
											            </div>
											            <div class="modal-body">
															<div class="row">
																<div class="col-lg-12">
																	<div class="form-group">
																		<label class="col-sm-3 control-label">Select Server</label>
																		<div class="col-sm-9">
																			<select id="server" name="server" class="form-control">
																				<?php
																					foreach($headends as $headend) {
																						echo '<option value="'.$headend['id'].'">'.$headend['name'].'</option>';
																					}
																				?>
																			</select>
																			<small><strong>NOTE:</strong> This server <strong>MUST</strong> be on the same network as the Roku / NowTV device or nothing will happen.</small>
																		</div>
																	</div>
																</div>
																<div class="col-lg-12">
																	<div class="form-group">
																		<label class="col-sm-3 control-label">Select Device Type</label>
																		<div class="col-sm-9">
																			<select id="device_brand" name="device_brand" class="form-control">
																				<option value="roku">Roku</option>
																				<option value="nowtv">NowTV branded Roku</option>
																			</select>
																		</div>
																	</div>
																</div>
																<div class="col-lg-12">
																	<div class="form-group">
																		<label class="col-sm-3 control-label">Select App</label>
																		<div class="col-sm-9">
																			<select id="app" name="app" class="form-control">
																				<option value="NowTV">NowTV</option>
																			</select>
																		</div>
																	</div>
																</div>
																<div class="col-lg-12">
																	<div class="form-group">
																		<label class="col-md-3 control-label" for="name">Name</label>
																		<div class="col-md-9">
																			<input type="text" class="form-control" id="name" name="name" placeholder="Roku Box 001" required="">
																		</div>
																	</div>
																</div>
																<div class="col-lg-12">
																	<div class="form-group">
																		<label class="col-md-3 control-label" for="ip_address">IP Address</label>
																		<div class="col-md-9">
																			<input type="text" class="form-control" id="ip_address" name="ip_address" placeholder="192.168.1.159" required="">
																		</div>
																	</div>
																</div>
															</div>
											            </div>
											            <div class="modal-footer">
											                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											                <button type="submit" class="btn btn-success">Add Device</button>
											            </div>
											        </div>
											    </div>
											</div>
										</form>

										<table id="roku_devices" class="table table-bordered table-striped">
											<thead>
												<tr>
													<th width="1px">ID</th>
													<th>Name</th>
													<th width="100px">IP</th>
													<th>Device</th>
													<th>App</th>
													<th>Channel</th>
													<th width="100px">Uptime</th>
													<th width="100px">Status</th>
													<th class="no-sort" width="75px">Actions</th>
												</tr>
											</thead>
											<tbody>
												<?php
													foreach($devices as $device) {
														if($device['status'] == 'online') {
															$status = '<span class="label label-success full-width" style="width: 100%;">Online</span>';
														}elseif($device['status'] == 'offline') {
															$status = '<span class="label label-danger full-width" style="width: 100%;">Offline</span>';
														}elseif($device['status'] == 'pending_adoption') {
															$status = '<span class="label label-info full-width" style="width: 100%;">Pending Adoption</span>';
														}else{
															$status = '<span class="label label-warning full-width" style="width: 100%;">Unknown</span>';
														}

														/*
														$ch = curl_init($playlist['url']);
														curl_setopt($ch, CURLOPT_HEADER, true);    // we want headers
														curl_setopt($ch, CURLOPT_NOBODY, true);    // we don't need body
														curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
														curl_setopt($ch, CURLOPT_TIMEOUT,10);
														$output = curl_exec($ch);
														$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
														curl_close($ch);
														*/
														// echo 'HTTP code: ' . $httpcode;

														// $remote_playlist_content = remote_content($playlist['url']);

														$device['app'] 				= str_replace('_', ' ', $device['app']);
														$device['app'] 				= strtoupper($device['app']);

														$device['channel_raw'] 		= $device['channel'];
														$device['channel'] 			= str_replace('_', ' ', $device['channel']);
														$device['channel'] 			= strtolower($device['channel']);
														$device['channel'] 			= ucwords($device['channel']);

														$device['uptime']			= uptime($device['uptime']);

														echo '
															<tr>
																<td>
																	'.$device['id'].'
																</td>
																<td>
																	'.stripslashes($device['name']).'
																</td>
																<td>
																	'.$device['ip_address'].'																
																</td>
																<td>
																	'.$device['model_name'].' '.$device['model_number'].'
																</td>
																<td>
																	'.$device['app'].'
																</td>
																<td>
																	'.$device['channel'].'
																</td>
																<td>
																	'.($device['status']=='online'?$device['uptime']:'').'
																</td>
																<td>
																	'.$status.'
																</td>
																<td style="vertical-align: middle;">
																	<button title="Edit Device" type="button" class="btn btn-info btn-flat btn-xs" data-toggle="modal" data-target="#roku_device_modal_edit_'.$device['id'].'">
																			<i class="fa fa-gears" aria-hidden="true"></i>
																	</button>

																	<a title="Delete Device" class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Are you sure?\')" href="actions.php?a=roku_device_delete&id='.$device['id'].'">
																		<i class="fa fa-times"></i>
																	</a>
																</td>
															</tr>
														';

														$devices_modals .= '
															<form action="actions.php?a=roku_device_update" class="form-horizontal form-bordered" method="post">
																<input type="hidden" id="device_id" name="device_id" value="'.$device['id'].'">
																<div class="modal fade" id="roku_device_modal_edit_'.$device['id'].'" role="dialog">
																    <div class="modal-dialog">
																        <div class="modal-content">
																            <div class="modal-header">
																                <button type="button" class="close" data-dismiss="modal">&times;</button>
																                <h4 class="modal-title">Update Roku Device</h4>
																            </div>
																            <div class="modal-body">
																                <div class="row">
																					<div class="col-lg-12">
																						<div class="form-group">
																							<label class="col-sm-3 control-label">Select Server</label>
																							<div class="col-sm-9">
																								<select id="server_id" name="server_id" class="form-control">
																			';
																										foreach($headends as $headend) {
																											$devices_modals .= '<option value="'.$headend['id'].'" '.($device['server_id']==$headend['id']?'selected':'').'>'.$headend['name'].'</option>';
																										}
														$devices_modals .= '
																								</select>
																								<small><strong>NOTE:</strong> This server <strong>MUST</strong> be on the same network as the Roku / NowTV device or nothing will happen.</small>
																							</div>
																						</div>
																					</div>
																					<div class="col-lg-12">
																						<div class="form-group">
																							<label class="col-sm-3 control-label">Device Type</label>
																							<div class="col-sm-9">
																								<select id="device_brand" name="device_brand" class="form-control">
																									<option value="roku" '.($device['device_brand']=='roku'?'selected':'').'>Roku</option>
																									<option value="nowtv" '.($device['device_brand']=='nowtv'?'selected':'').'>NowTV branded Roku</option>
																								</select>
																							</div>
																						</div>
																					</div>
																					<div class="col-lg-12">
																						<div class="form-group">
																							<label class="col-md-3 control-label" for="name">Name</label>
																							<div class="col-md-9">
																								<input type="text" class="form-control" id="name" name="name" placeholder="Roku Box 001" value="'.stripslashes($device['name']).'" required="">
																							</div>
																						</div>
																					</div>
																					<div class="col-lg-12">
																						<div class="form-group">
																							<label class="col-md-3 control-label" for="ip_address">IP Address</label>
																							<div class="col-md-9">
																								<input type="text" class="form-control" id="ip_address" name="ip_address" placeholder="192.168.1.159" value="'.stripslashes($device['ip_address']).'" required="">
																							</div>
																						</div>
																					</div>
																					<div class="col-lg-12">
																						<div class="form-group">
																							<label class="col-sm-3 control-label">Streaming App</label>
																							<div class="col-sm-9">
																								<select id="app" name="app" class="form-control">
																									<option value="nowtv" '.($device['app']=='nowtv'?'selected':'').'>NowTV branded Roku</option>
																								</select>
																							</div>
																						</div>
																					</div>
																					<div class="col-lg-12">
																						<div class="form-group">
																							<label class="col-sm-3 control-label">Channel</label>
																							<div class="col-sm-9">
																								<select id="channel" name="channel" class="form-control">
																									<optgroup label="UK Sky / NowTV">
																										<option value="sky_one" '.($device['channel_raw']=='sky_one'?'selected':'').'>Sky One</option>
																										<option value="sky_witness" '.($device['channel_raw']=='sky_witness'?'selected':'').'>Sky Witness</option>
																										<option value="sky_witness" '.($device['channel_raw']=='sky_witness'?'selected':'').'>Sky Atlantic</option>
																										<option value="gold" '.($device['channel_raw']=='gold'?'selected':'').'>Gold</option>
																										<option value="comedy_central" '.($device['channel_raw']=='comedy_central'?'selected':'').'>Comedy Central</option>
																										<option value="sky_arts" '.($device['channel_raw']=='sky_arts'?'selected':'').'>Sky Arts</option>
																										<option value="syfy" '.($device['channel_raw']=='syfy'?'selected':'').'>SYFY</option>
																										<option value="fox" '.($device['channel_raw']=='fox'?'selected':'').'>FOX</option>
																										<option value="discovery_channel" '.($device['channel_raw']=='discovery_channel'?'selected':'').'>Discovery Channel</option>
																										<option value="mtv" '.($device['channel_raw']=='mtv'?'selected':'').'>MTV</option>
																										<option value="wild" '.($device['channel_raw']=='wild'?'selected':'').'>WILD</option>
																										<option value="cartoon_network" '.($device['channel_raw']=='cartoon_network'?'selected':'').'>Cartoon Network</option>
																										<option value="boomerang" '.($device['channel_raw']=='boomerang'?'selected':'').'>Boomerang</option>
																										<option value="nickelodean" '.($device['channel_raw']=='nickelodean'?'selected':'').'>Nickelodean</option>
																										<option value="nick_toons" '.($device['channel_raw']=='nick_toons'?'selected':'').'>Nick Toons</option>
																										<option value="nick_jr" '.($device['channel_raw']=='nick_jr'?'selected':'').'>Nick Jr</option>
																										<option value="cartoonito" '.($device['channel_raw']=='cartoonito'?'selected':'').'>Cartoonito</option>
																										<option value="sky_cinema_premiere" '.($device['channel_raw']=='sky_cinema_premiere'?'selected':'').'>Sky Cinema Premiere</option>
																										<option value="sky_cinema_hits" '.($device['channel_raw']=='sky_cinema_hits'?'selected':'').'>Sky Cinema Hits</option>
																										<option value="sky_cinema_greats" '.($device['channel_raw']=='sky_cinema_greats'?'selected':'').'>Sky Cinema Greats</option>
																										<option value="sky_cinema_disney" '.($device['channel_raw']=='sky_cinema_disney'?'selected':'').'>Sky Cinema Disney</option>
																										<option value="sky_cinema_family" '.($device['channel_raw']=='sky_cinema_family'?'selected':'').'>Sky Cinema Family</option>
																										<option value="sky_cinema_action" '.($device['channel_raw']=='sky_cinema_action'?'selected':'').'>Sky Cinema Action</option>
																										<option value="sky_cinema_comedy" '.($device['channel_raw']=='sky_cinema_comedy'?'selected':'').'>Sky Cinema Comedy</option>
																										<option value="sky_cinema_thriler" '.($device['channel_raw']=='sky_cinema_thriller'?'selected':'').'>Sky Cinema Thriller</option>
																										<option value="sky_cinema_drama" '.($device['channel_raw']=='sky_cinema_drama'?'selected':'').'>Sky Cinema Drama</option>
																										<option value="sky_cinema_scifi" '.($device['channel_raw']=='sky_cinema_scifi'?'selected':'').'>Sky Cinema SciFi</option>
																										<option value="sky_cinema_select" '.($device['channel_raw']=='sky_cinema_select'?'selected':'').'>Sky Cinema Select</option>
																										<option value="sky_sports_news" '.($device['channel_raw']=='sky_sports_news'?'selected':'').'>Sky Sports News</option>
																										<option value="sky_sports_football" '.($device['channel_raw']=='sky_sports_football'?'selected':'').'>Sky Sports Football</option>
																										<option value="sky_sports_premier_league" '.($device['channel_raw']=='sky_sports_premier_league'?'selected':'').'>Sky Sports Premier League</option>
																										<option value="sky_sports_action" '.($device['channel_raw']=='sky_sports_action'?'selected':'').'>Sky Sports Action</option>
																										<option value="sky_sports_arena" '.($device['channel_raw']=='sky_sports_arena'?'selected':'').'>Sky Sports Arena</option>
																										<option value="sky_sports_racing" '.($device['channel_raw']=='sky_sports_racing'?'selected':'').'>Sky Sports racing</option>
																										<option value="sky_sports_main_event" '.($device['channel_raw']=='sky_sports_main_event'?'selected':'').'>Sky Sports Main Event</option>
																										<option value="sky_sports_f1" '.($device['channel_raw']=='sky_sports_f1'?'selected':'').'>Sky Sports F1</option>
																										<option value="sky_sports_cricket" '.($device['channel_raw']=='sky_sports_cricket'?'selected':'').'>Sky Sports Cricket</option>
																										<option value="sky_sports_mix" '.($device['channel_raw']=='sky_sports_mix'?'selected':'').'>Sky Sports Mix</option>
																										<option value="sky_sports_golf" '.($device['channel_raw']=='sky_sports_golf'?'selected':'').'>Sky Sports Golf</option>
																									</optgroup>
																								</select>
																							</div>
																						</div>
																					</div>
																				</div>
																            </div>
																            <div class="modal-footer">
																                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																                <button type="submit" class="btn btn-success">Save Changes</button>
																            </div>
																        </div>
																    </div>
																</div>
															</form>
														';
													}
												?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</section>
				<?php } ?>
            </div>
            <?php echo $devices_modals; ?>
        <?php } ?>

        <?php function roku_device(){ ?>
        	<?php 
        		global $conn, $wp, $global_settings, $account_details, $site, $whmcs, $product_ids;
            
            	sanity_check();
            
            	$playlist_id = get('playlist_id');

        		$query = $conn->query("SELECT * FROM `remote_playlists` WHERE `id` = '".$playlist_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
				if($query !== FALSE) {
					$playlist = $query->fetch(PDO::FETCH_ASSOC);
				}

				if($playlist){
					// parse the playlist
					$streams_raw 		= @file_get_contents("http://".$global_settings['cms_access_url']."/actions.php?a=inspect_m3u_encoded&url=".base64_encode($playlist['url']));
				  	$streams 			= json_decode($streams_raw, true);
				  	asort($streams);
				}
			?>

            <div class="content-wrapper">
				
                <div id="status_message"></div>   
                            	
                <section class="content-header">
                    <h1>Playlist: <?php echo stripslashes($playlist['name']); ?> <!-- <small>Optional description</small> --></h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="dashboard.php">Dashboard</a></li>
                        <li class="active"><a href="dashboard.php?c=remote_playlists">Remote Playlist Manager</a></li>
                        <li class="active">Playlist: <?php echo stripslashes($playlist['name']); ?></li>
                    </ol>
                </section>

                <!-- Main content -->
                <?php if($account_details['addon_playlist_manager'] == 'no'){ ?>
                	<section class="content">
						<div class="row">
							<div class="col-lg-12">
								<div class="box box-danger">
			            			<div class="box-header">
			              				<h3 class="box-title">
			              					ERROR
			              				</h3>
			            			</div>
									<div class="box-body">
										<h3>Premium Addon: Remote Playlist Manager</h3>
										You do not own this addon yet. You can purchase this addon for a one-time price of $99 in our online store.

										<?php if(isset($_GET['dev'])) { ?>
											<hr>
											<pre>
												<?php print_r($account_details); ?>
											</pre>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</section>
                <?php }else{ ?>
					<section class="content">
						<div class="row">
							<div class="col-lg-12">
								<div class="box box-primary">
			            			<div class="box-header">
			              				<h3 class="box-title">
			              					Playlist: <?php echo stripslashes($playlist['name']); ?>
			              				</h3>
			              				<div class="pull-right">
			              					
										</div>
			            			</div>
									<div class="box-body">
										<table id="remote_playlist" class="table table-bordered table-striped">
											<thead>
												<tr>
													<th>Name</th>
													<th>URL</th>
													<th width="40px">In Use</th>
												</tr>
											</thead>
											<tbody>
												<?php
													foreach($streams as $stream) {
														// ready name
														$name 				= $stream['title'];
														$name 				= str_replace(array(':',';'), '', $name);
														$name 				= trim($name);

														// ready source
														$source 			= $stream['url'];
														$source 			= trim($source);
														$source 			= str_replace(' ', '', $source);

														// is source in use
														$sql = "
													        SELECT count(id) as total_streams 
													        FROM `streams` 
													        WHERE `stream_type` = 'input' AND `source` = '".$source."' AND `user_id` = '".$_SESSION['account']['id']."' 
													    ";
													    $query      		= $conn->query($sql);
													    $results    		= $query->fetchAll(PDO::FETCH_ASSOC);
													    $total_streams      = $results[0]['total_streams'];

													    if($total_streams == 0){
													    	$stream_in_use = '<span class="label label-danger full-width" style="width: 100%;">'.$total_streams.'</span>';
													    }else{
													    	$stream_in_use = '<span class="label label-success full-width" style="width: 100%;">'.$total_streams.'</span>';
													    }

														echo '
															<tr>
																<td>
																	'.$name.'
																</td>
																<td>
																	<input type="text" class="form-control input-sm" style="width: 100%;" value="'.$source.'" onClick="this.select();">
																	<span class="hidden">'.$source.'</span>
																</td>
																<td>
																	'.$stream_in_use.'
																</td>
															</tr>
														';
													}
												?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</section>
				<?php } ?>
            </div>
        <?php } ?>
        
        <?php function playlist_checker(){ ?>
        	<?php 
        		global $conn, $wp, $global_settings, $account_details, $site, $whmcs, $product_ids;
            
            	sanity_check();
            ?>

        	<div class="content-wrapper">
				
                <div id="status_message"></div>   
                            	
                <section class="content-header">
                    <h1>Playlist Checker <!-- <small>Optional description</small> --></h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="dashboard.php">Dashboard</a></li>
                        <li class="active">Playlist Checker</li>
                    </ol>
                </section>

                <!-- Main content -->
				<section class="content">
					<div class="row">
						<div class="col-lg-12">
							<form action="actions.php?a=playlist_checker" class="form-horizontal form-bordered" method="post">
								<div class="box box-primary">
			            			<div class="box-header">
			              				<h3 class="box-title">
			              					Playlist Checker
			              				</h3>
			            			</div>
									<div class="box-body">
										<div class="col-lg-12">
											<div class="form-group">
												<label class="col-md-1 control-label" for="playlist_url">Playlist URL</label>
												<div class="col-md-11">
													<input type="text" class="form-control" id="playlist_url" name="playlist_url" placeholder="http://example.com/playlist.m3u8" required="">

													<small><strong>NOTE:</strong> We suggest that you do NOT use this checker for Xtream-Codes or Flussonic playlists as it will flood the server and could result in your account being blocked / banned due to their strict security settings. This tool is intended for public playlists your find around the internet only. Use at your own risk.</small>
												</div>
											</div>
										</div>
									</div>
									<div class="box-footer">
										<button type="submit" class="pull-right btn btn-success">Continue</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</section>
            </div>
        <?php } ?>

        <?php function playlist_checker_results(){ ?>
        	<?php 
        		global $conn, $wp, $global_settings, $account_details, $site, $whmcs, $product_ids;
            
            	sanity_check();
            
            	$url = base64_decode(get('url'));

        		$playlist = file_get_contents("http://slipstreamiptv.com/actions.php?a=inspect_m3u_encoded&url=".$_GET['url']);
        		$playlist = json_decode($playlist, true);
        	?>

            <div class="content-wrapper">
				
                <div id="status_message"></div>   
                            	
                <section class="content-header">
                    <h1>Playlist Checker Results<!-- <small>Optional description</small> --></h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="dashboard.php">Dashboard</a></li>
                        <li class="active">Playlist Checker Results</li>
                    </ol>
                </section>

                <!-- Main content -->
				<section class="content">
					<div class="row">
						<div class="col-lg-12">
							<div class="box box-primary">
		            			<div class="box-header">
		              				<h3 class="box-title">
		              					Playlist Checker Results
		              				</h3>
		            			</div>
								<div class="box-body">
									<!-- <strong>Encoded Playlist URL:</strong> <?php echo get('url'); ?> <br> -->
									<strong>Playlist URL:</strong> <?php echo $url; ?> <br>
									<!-- <strong>Scan URL:</strong> http://slipstreamiptv.com/actions.php?a=inspect_m3u_encoded&url=<?php echo get('url'); ?> -->
									<br>
									<strong>Please Note:</strong> The streams are checked from a USA IP address and therefor geo-locking might return a false negative.
									<table id="playlist_checker_results" class="table table-bordered table-striped">
										<thead>
											<tr>
												<th width="1px">ID</th>
												<th width="25px">PICON</th>
												<th>Channel</th>
												<th width="150px">Category</th>
												<th width="75px">Status</th>
											</tr>
										</thead>
										<tbody>
											<?php
												$count = 1;
												foreach($playlist as $playlist_item) {
													
													if(!empty($playlist_item['tvlogo'])){
														$playlist_item['picon'] = '<img src="'.$playlist_item['tvlogo'].'" width="100%" height="35px" alt="'.stripslashes($playlist_item['title']).'">';
													}else{
														$playlist_item['picon'] = '';
													}

													if(!empty($playlist_item['tvgroup'])){
														$playlist_item['category'] = $playlist_item['tvgroup'];
													}else{
														$playlist_item['category'] = '';
													}

													echo '
														<tr>
															<td>
																'.$count.'
															</td>
															<td>
																'.$playlist_item['picon'].'
															</td>
															<td>
																<strong>Channel:</strong> '.stripslashes($playlist_item['title']).' <br>
																<strong>URL:</strong> <a href="'.$playlist_item['url'].'" target="_blank">click here</a>
															</td>
															<td>
																'.$playlist_item['category'].'
															</td>
															<td id="playlist_status_id_'.$count.'">
																<img src="assets/images/ajax-loader.gif" width="100%" alt="">
															</td>
														</tr>
													';

													$count++;
												}
											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</section>
            </div>
        <?php } ?>

        <?php function xc_import(){ ?>
        	<?php 
        		global $conn, $wp, $global_settings, $account_details, $site, $whmcs, $product_ids;
            
            	sanity_check();
            ?>

        	<div class="content-wrapper">
				
                <div id="status_message"></div>
                            	
                <section class="content-header">
                    <h1>Xtream-Codes Import <!-- <small>Optional description</small> --></h1>
                    <ol class="breadcrumb">
                        <li><a href="dashboard.php">Dashboard</a></li>
                        <li class="active">Xtream-Codes Import</li>
                    </ol>
                </section>
    
                <section class="content">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                        	<li><a href="dashboard.php?c=xc_import">Xtream-Codes Import</a></li>
                        </ul>
                        <div class="tab-content">
                            <form name="upload_form" id="upload_form" enctype="multipart/form-data" method="post">
                                This is an experimental import function only. We offer <strong>NO WARRANTY</strong> or promise of it working.<br><br>
                                Please upload your Xtream-Codes v1 or v2 database backup. Files can be up to 1GB. The larger the file, the longer the process will take. Even when the upload reports 100%, please do not close or navigate away from this window. Either wait for the green text to say UPLOAD COMPLETE or an error is reported on screen. If there is an error then please copy and paste it and open a support ticket. <br><br>
                                <H4>How to shrink and export your database.</H4><br>
                                SSH into your server and then copy &amp; paste the following commands one at a time.<br>
                                <br>
                                <code>mysql -u root -p</code><br>
                                <code>USE xtream_iptvpro;</code><br>
                                <code>TRUNCATE TABLE client_logs;</code><br>
                                <code>TRUNCATE TABLE user_activity;</code><br>
                                <code>exit;</code><br>
                                <code>mysqldump -u root -p xtream_iptvpro > /home/XtreamBackup.sql</code><br>
                                <br>
                                Now transfer the file to your local computer using FTP and select Browse and navigate to your downloaded copy of your database backup.<br>
                                <br>
                                Once your have uploaded your SQL file and it shows below as "pending". You will need to SSH into your server as the root user and run the following command. <br><br>
                                <code>php -q /var/www/html/portal/console/console.php xc_imports</code>
                                <br>
                                <br>

                                <input type="hidden" name="uid" id="uid" value="<?php echo $account_details['id']; ?>">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <div class="col-lg-12">
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                        <span class="btn btn-primary btn-file">
                                                            Browse&hellip; <input type="file" name="file1" id="file1" accept=".txt,.sql,.zip">
                                                        </span>
                                                    </span>
                                                    <input type="text" class="form-control" readonly>
                                                </div>
                                                <br>
                                                <center>
                                                    <progress id="progressBar" value="0" max="100" style="width:100%;"></progress>
                                                    <span id="loaded_n_total"></span> <span id="status"></span>
                                                </center>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <br>
                                
                                <div class="row">
                                    <div class="col-lg-12">
                                    	<center>
	                                        <input type="button" class="btn btn-success" value="Upload File" onclick="uploadFile()">
    									</center>
                                    </div>
                                </div>
                            </form>

                            <br><br>

                            <table id="xc_import_uploads" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th width="1px">ID</th>
										<th width="50px">Status</th>
										<th width="300px" class="nowrap" style="white-space: nowrap;">Filename</th>
										<th width="100px" class="nowrap" style="white-space: nowrap;">Size</th>
										<th></th>
										<th class="no-sort" width="75px">Actions</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$query = $conn->query("SELECT * FROM `xc_import_jobs` WHERE `user_id` = '".$_SESSION['account']['id']."' ");
										$imports = $query->fetchAll(PDO::FETCH_ASSOC);

										foreach($imports as $import) {

											if($import['status'] == 'pending') {
															$status = '<span class="label label-warning full-width" style="width: 100%;">Pending</span>';
											}elseif($import['status'] == 'error') {
												$status = '<span class="label label-danger full-width" style="width: 100%;">Error</span>';
											}elseif($import['status'] == 'complete') {
												$status = '<span class="label label-success full-width" style="width: 100%;">Complete</span>';
											}elseif($import['status'] == 'importing') {
												$status = '<span class="label label-info full-width" style="width: 100%;">Importing</span>';
											}else{
												$status = '<span class="label label-info full-width" style="width: 100%;">'.ucfirst($import['status']).'</span>';
											}

											if(file_exists("/var/www/html/portal/xc_uploads/".$_SESSION['account']['id']."/".$import['filename'])){
												$filesize = filesize("/var/www/html/portal/xc_uploads/".$_SESSION['account']['id']."/".$import['filename']);
												$filesize = formatSizeUnits($filesize);
											}else{
												$filesize = '';
											}

											echo '
												<tr>
													<td>
														'.$import['id'].'
													</td>
													<td>
														'.$status.'																
													</td>
													<td>
														'.stripslashes($import['filename']).'
													</td>
													<td>
														'.$filesize.'
													</td>
													<td>
														'.stripslashes($import['error_message']).'
													</td>
													<td style="vertical-align: middle;">
														<a title="Delete" class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Are you sure?\')" href="actions.php?a=xc_import_delete&id='.$import['id'].'">
															<i class="fa fa-times"></i>
														</a>
													</td>
												</tr>
											';
										}
									?>
								</tbody>
							</table>
                        </div>
                    </div>

                    <?php if(get('dev') == 'yes'){ ?>
	                    <div class="row">
		                    <div class="col-lg-12">
								<div class="box box-primary">
			            			<div class="box-header">
			              				<h3 class="box-title">
			              					Account Details Dev
			              				</h3>
			              				<div class="pull-right">

										</div>
			            			</div>
									<div class="box-body">
										<?php debug($account_details); ?>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
                </section>
            </div>
        <?php } ?>

        <?php function stream_bouquets(){ ?>
        	<?php 
        		global $conn, $wp, $global_settings, $account_details, $site, $whmcs, $product_ids;
            
            	sanity_check();
            
				$bouquets_modals = '';

        		$query = $conn->query("SELECT * FROM `bouquets` WHERE `user_id` = '".$_SESSION['account']['id']."' ");
				$bouquets = $query->fetchAll(PDO::FETCH_ASSOC);
			?>

            <div class="content-wrapper">
				
                <div id="status_message"></div>   
                            	
                <section class="content-header">
                    <h1>Bouquets  <!-- <small>Optional description</small> --></h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="dashboard.php">Dashboard</a></li>
                        <li class="active">Bouquets</li>
                    </ol>
                </section>

                <!-- Main content -->
				<section class="content">
					<div class="row">
						<div class="col-lg-12">
							<div class="box box-primary">
		            			<div class="box-header">
		              				<h3 class="box-title">
		              					Bouquets
		              				</h3>
		              				<div class="pull-right">
		              					<button type="button" class="btn btn-success btn-xs btn-flat" data-toggle="modal" data-target="#new_bouquet_modal">Add Bouquet</button>
									</div>
		            			</div>
								<div class="box-body">
									<form action="actions.php?a=bouquet_add" class="form-horizontal form-bordered" method="post">
										<div class="modal fade" id="new_bouquet_modal" role="dialog">
										    <div class="modal-dialog">
										        <div class="modal-content">
										            <div class="modal-header">
										                <button type="button" class="close" data-dismiss="modal">&times;</button>
										                <h4 class="modal-title">Add New Bouquet</h4>
										            </div>
										            <div class="modal-body">
										                <div class="row">
													    	<div class="col-lg-6">
															    <div class="form-group">
																	<label class="col-md-2 control-label" for="name">Name</label>
																	<div class="col-md-10">
																		<input type="text" class="form-control" id="name" name="name" placeholder="Awesome Bouquet">
																	</div>
																</div>
															</div>

															<div class="col-lg-6">
																<div class="form-group">
																	<label class="col-sm-2 control-label">Type</label>
																	<div class="col-sm-10">
																		<select id="bouquet_type" name="bouquet_type" class="form-control">
																			<option value="live">Live TV Streams</option>
																			<option value="channel">24/7 TV Channels</option>
																			<option value="vod">Video on Demand</option>
																			<option value="series">TV Series</option>
																		</select>
																	</div>
																</div>
															</div>
														</div>
										            </div>
										            <div class="modal-footer">
										                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										                <button type="submit" class="btn btn-success">Add Bouquet</button>
										            </div>
										        </div>
										    </div>
										</div>
									</form>

									<table id="bouquets" class="table table-bordered table-striped">
										<thead>
											<tr>
												<th width="10px">ID</th>
												<th class="nowrap" style="white-space: nowrap;" width="75px">Type</th>
												<th class="nowrap" style="white-space: nowrap;">Name</th>
												<th class="no-sort" width="75px">Actions</th>
											</tr>
										</thead>
										<tbody>
											<?php
												foreach($bouquets as $bouquet){

													if($bouquet['type'] == 'live'){
														$bouquet['type']		= 'Live TV Streams';
													}
													if($bouquet['type'] == 'channel'){
														$bouquet['type']		= '24/7 TV Channels';
													}
													if($bouquet['type'] == 'vod'){
														$bouquet['type']		= 'VoD';
													}
													if($bouquet['type'] == 'series'){
														$bouquet['type']		= 'TV Series';
													}

													if(empty($bouquet['streams']) || $bouquet['streams'] == NULL){
														$total_streams = 0;
													}else{
														$total_streams = explode(',', $bouquet['streams']);
														$total_streams = count($total_streams);
														$total_streams = number_format($total_streams);
													}

													echo '
														<tr>
															<td>
																'.$bouquet['id'].'
															</td>
															<td>
																'.$bouquet['type'].'
															</td>
															<td>
																'.stripslashes($bouquet['name']).'
															</td>
															<td style="vertical-align: middle;">
																<a title="View / Edit" class="btn btn-info btn-flat btn-xs" href="dashboard.php?c=stream_bouquet&bouquet_id='.$bouquet['id'].'">
																	<i class="fa fa-eye"></i>
																</a>

																<a title="Delete" class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Are you sure?\')" href="actions.php?a=bouquet_delete&bouquet_id='.$bouquet['id'].'">
																	<i class="fa fa-times"></i>
																</a>
															</td>
														</tr>
													';
												}
											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</section>
            </div>
        <?php } ?>

        <?php function stream_bouquet(){ ?>
        	<?php 
        		global $conn, $wp, $global_settings, $account_details, $site, $whmcs, $product_ids;
            
            	sanity_check();
	            
	            $bouquet_id = get('bouquet_id'); 

				$query = $conn->query("SELECT * FROM `bouquets` WHERE `id` = '".$bouquet_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
				$bouquet = $query->fetch(PDO::FETCH_ASSOC);
				$bouquet['streams'] = array();

				$query = $conn->query("SELECT * FROM `bouquets_content` WHERE `bouquet_id` = '".$bouquet_id."' ORDER BY `order`,`content_id` ASC ");
				$bouquet_contents = $query->fetchAll(PDO::FETCH_ASSOC);

				foreach($bouquet_contents as $bouquet_content){
					$bouquet['streams'][] = $bouquet_content['content_id'];
				}
			
				if($bouquet['type'] == 'live'){
        			$query = $conn->query("SELECT `id`,`name` FROM `streams` WHERE `stream_type` = 'output' AND `user_id` = '".$_SESSION['account']['id']."' ORDER BY `name` ");
					$streams = $query->fetchAll(PDO::FETCH_ASSOC);
				}

				if($bouquet['type'] == 'channel'){
        			$query = $conn->query("SELECT `id`,`name` FROM `channels` WHERE `user_id` = '".$_SESSION['account']['id']."' ORDER BY `name` ");
					$streams = $query->fetchAll(PDO::FETCH_ASSOC);
				}

				if($bouquet['type'] == 'vod'){
        			$query = $conn->query("SELECT `id`,`name` FROM `vod` WHERE `user_id` = '".$_SESSION['account']['id']."' ORDER BY `name` ");
					$streams = $query->fetchAll(PDO::FETCH_ASSOC);
				}

				if($bouquet['type'] == 'series'){
        			$query = $conn->query("SELECT `id`,`name` FROM `tv_series` WHERE `user_id` = '".$_SESSION['account']['id']."' ORDER BY `name` ");
					$streams = $query->fetchAll(PDO::FETCH_ASSOC);
				}

				// build left hand menu

				// build right hand menu
				$count = 0;
				foreach($bouquet['streams'] as $key => $value){
        			if(!empty($value)){
        				$key = array_search($value, array_column($streams, 'id'));
        				
        				$bouquet_streams[$count]['id']	= $streams[$key]['id'];
        				$bouquet_streams[$count]['name']	= $streams[$key]['name'];
        				$count++;
        			}
            	}

            	if(isset($bouquet_streams)){
            		$bouquet_streams = multi_unique($bouquet_streams);
            	}
			?>

            <div class="content-wrapper">
				
                <div id="status_message"></div>
                            	
                <section class="content-header">
                    <h1>Bouquet: <?php echo stripslashes($bouquet['name']); ?> <!-- <small>Optional description</small> --></h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="dashboard.php">Dashboard</a></li>
                        <li class="active"><a href="dashboard.php?c=stream_bouquets">Bouquets</a></li>
                        <li class="active">Bouquet</li>
                    </ol>
                </section>

                <!-- Main content -->
                <?php if($bouquet['user_id'] != $_SESSION['account']['id']) { ?>
					<section class="content">
						<div class="row">
							<div class="col-lg-12">
								<div class="box box-danger">
			            			<div class="box-header">
			              				<h3 class="box-title">
			              					ERROR
			              				</h3>
			            			</div>
									<div class="box-body">
										<h3>There was an error loading this content.</h3>
										You don't own this stream bouquet. This security breach has been reported to our security team.
									</div>
								</div>
							</div>
						</div>
					</section>
				<?php }else{ ?>
					<section class="content">
						<div class="row">
							<div class="col-lg-12">
								<div class="box box-primary">
			            			<div class="box-header">
			              				<h3 class="box-title">
			              					Bouquet > <?php echo stripslashes($bouquet['name']); ?>
			              				</h3>
			            			</div>
									<div class="box-body">
										<form action="actions.php?a=bouquet_update" class="form-horizontal form-bordered" method="post">
											<input type="hidden" name="bouquet_id" value="<?php echo $bouquet_id; ?>">
											<div class="row">
												<div class="col-lg-12">
													<section class="panel">
														<div class="panel-body">
															<!-- name -->
															<div class="form-group">
																<label class="col-md-2 control-label" for="name">Name</label>
																<div class="col-md-10">
																	<input type="text" class="form-control" id="name" name="name" value="<?php echo stripslashes($bouquet['name']); ?>">
																</div>
															</div>
														</div>
													</section>
												</div>
											</div>

											<footer class="panel-footer">
												<a href="dashboard.php?c=stream_bouquets" class="btn btn-default">Back</a>
												<button type="submit" class="btn btn-success pull-right">Save Changes</button>
											</footer>
										</form>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-12 col-sm-12">
								<div class="box box-primary">
			            			<div class="box-header">
			              				<h3 class="box-title">
			              					Add / Remove Content
			              				</h3>
			            			</div>
									<div class="box-body">
										<p>
											In this section, you can add or remove content from this bouquet. Items on the left are not displayed to your customers whereas items on the right will be available to them. Simply highlight one or more items and click either the left or right arrow to move items around. Clicking on 'Save Changes' once you are happy with the available content and then proceed to scroll down the page so you can then choose your own custom order for your content.
										</p>
										<form action="actions.php?a=bouquet_streams_update" class="form-horizontal form-bordered" method="post">
											<input type="hidden" name="bouquet_id" value="<?php echo $bouquet_id; ?>">
										    <div class="row">
										        <div class="col-lg-5">
										            <select name="from[]" id="multiselect" class="form-control" size="20" multiple="multiple">
										                <?php foreach ($streams as $stream) { ?>
										                	<?php if(!in_array($stream['id'], $bouquet['streams'])){ ?>
															  	<option value="<?php echo $stream['id']; ?>"><?php echo stripslashes($stream['name']) ?></option>
															<?php } ?>
										                <?php } ?>
										            </select>
										        </div>
										        
										        <div class="col-lg-2">
										            <button type="button" id="multiselect_rightAll" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
										            <button type="button" id="multiselect_rightSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
										            <button type="button" id="multiselect_leftSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
										            <button type="button" id="multiselect_leftAll" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
										        </div>
										        
										        <div class="col-lg-5">
										            <select name="to[]" id="multiselect_to" class="form-control" size="20" multiple="multiple">
										            	<?php 

										            		if(isset($bouquet_streams)){
											            		foreach($bouquet_streams as $bouquet_stream){
										            				?>
										            					<option value="<?php echo stripslashes($bouquet_stream['id']); ?>"><?php echo stripslashes($bouquet_stream['name']); ?></option>
										            				<?php
											                	}
											                }
										                ?>
										            </select>
										        </div>
										    </div>

										    <br><br>

											<footer class="panel-footer">
												<a href="dashboard.php?c=stream_bouquets" class="btn btn-default">Back</a>
												<button type="submit" class="btn btn-success pull-right">Save Changes</button>
											</footer>
										</form>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-12">
								<div class="box box-primary">
			            			<div class="box-header">
			              				<h3 class="box-title">
			              					Arrange Bouquet Order
			              				</h3>
			            			</div>
									<div class="box-body">
										<p>
											To change the order in which your streams will appear, simply drag and drop the streams below into your desired order. Changes are saved automatically and will render to your customers within 60 seconds of updates being saved.
										</p>
								        <table id="bouquet_streams" class="table table-bordered table-striped">
											<thead>
												<tr>
													<th class="hidden" width="1px">Order</th>
													<th width="10px">ID</th>
													<th class="nowrap" style="white-space: nowrap;">Name</th>
												</tr>
											</thead>
											<tbody class="row_position">
												<?php
								            		foreach($bouquet['streams'] as $key => $value){
								            			if(!empty($value)){
								            				$key = array_search($value, array_column($streams, 'id'));
								            				
															echo '
																<tr id="'.$streams[$key]['id'].'">
																	<td class="hidden">
																		'.$key.'
																	</td>
																	<td>
																		'.$streams[$key]['id'].'
																	</td>
																	<td>
																		'.stripslashes($streams[$key]['name']).'
																	</td>
																</tr>
															';
														}
													}
												?>
											</tbody>
										</table>

										<footer class="panel-footer">
											<a href="dashboard.php?c=stream_bouquets" class="btn btn-default">Back</a>
											<!-- <button type="submit" class="btn btn-success pull-right">Save Changes</button> -->
										</footer>
									</div>
								</div>
							</div>
						</div>
					</section>
				<?php } ?>
            </div>
        <?php } ?>

        <?php function staging(){ ?>
        	<?php 
        		global $conn, $wp, $global_settings, $account_details, $site, $whmcs, $product_ids;
            ?>

        	<?php if($_SERVER['REMOTE_ADDR'] == '86.4.171.7'){ ?>
	            <div class="content-wrapper">
	            
	            	<div id="status_message"></div>
	                
	                <section class="content-header">
	                    <h1>Staging Area <!-- <small>Optional description</small> --></h1>
	                    <ol class="breadcrumb">
	                        <li><a href="dashboard">Dashboard</a></li>
	                        <li class="active">Staging Area</li>
	                    </ol>
	                </section>
	    
	                <section class="content">
	                    <h4><strong>$_GET</strong></h4>
	                    	<?php debug($_GET); ?>
	                    	
	                    <h4><strong>$_POST</strong></h4>
	                        <?php debug($_POST); ?>
	                        
	                    <h4><strong>$_SESSION</strong></h4>
	                        <?php debug($_SESSION); ?>
	                        
	                    <h4><strong>$account_details</strong></h4>
	                        <?php debug($account_details); ?>

	                    <h4><strong>$global_settings</strong></h4>
	                        <?php debug($global_settings); ?>

	                    <h4><strong>$globals</strong></h4>
	                        <?php debug($globals); ?>

						<hr>

						<style type="text/css">
							#github-link {
							  position: fixed;
							  top: 0px;
							  right: 10px;
							  font-size: 3em;
							  color: #fff;
							}

							#headline {
							  background-color: rgba(0, 0, 0, 0.5);
							  text-align: center;
							}

							.demo-heading {
							  padding: 40px 10px 0px 10px;
							  margin: 0px;
							  font-size: 3em;
							  color: #fff;
							}

							.demo-container {
							  position: relative;
							  display: inline-block;
							  top: 10px;
							  left: 10px;
							  height: 420px;
							  width: calc(100% - 24px);
							  border: 2px dashed #eee;
							  border-radius: 5px;
							  overflow: auto;
							  text-align: center;
							}

							.orgchart {
							  background: rgba(0, 0, 0, 0.5);
							}

							.orgchart>.spinner {
							  color: rgba(255, 255, 0, 0.75);
							}

							.orgchart .node .title {
							  background-color: #fff;
							  color: #000;
							}

							.orgchart .node .content {
							  border-color: transparent;
							  border-top-color: #333;
							}

							.orgchart .node>.spinner {
							  color: rgba(184, 0, 54, 0.75);
							}

							.orgchart .node:hover {
							  background-color: rgba(255, 255, 0, 0.6);
							}

							.orgchart .node.focused {
							  background-color: rgba(255, 255, 0, 0.6);
							}

							.orgchart .node .edge {
							  color: rgba(0, 0, 0, 0.6);
							}

							.orgchart .edge:hover {
							  color: #000;
							}

							.orgchart td.left,
							.orgchart td.top,
							.orgchart td.right {
							  border-color: #fff;
							}

							.orgchart td>.down {
							  background-color: #fff;
							}
						</style>

						<div id="chart-container"></div>
	                </section>
	            </div>
	        <?php } ?>
        <?php } ?>

        <?php function licensing(){ ?>
        	<?php 
        		global $conn, $wp, $global_settings, $account_details, $site, $whmcs, $product_ids;
            
        		$query 		= $conn->query("SELECT * FROM `global_settings` WHERE `config_name` = 'bGljZW5zZV9rZXk=' ");
				$licenses 	= $query->fetchAll(PDO::FETCH_ASSOC);
			?>

	        <style>
	            td.details-control {
	                background: url('img/details_open.png') no-repeat center center;
	                cursor: pointer;
	            }
	            tr.shown td.details-control {
	                background: url('img/details_close.png') no-repeat center center;
	            }
	        </style>

	        <div class="content-wrapper">

	            <div id="status_message"></div>

	            <section class="content-header">
	                <h1>Licensing <!-- <small>Optional description</small> --></h1>
	                <ol class="breadcrumb">
	                    <li class="active"><a href="dashboard.php">Dashboard</a></li>
	                    <li class="active">Licensing</li>
	                </ol>
	            </section>

	            <!-- Main content -->
				<section class="content">
					<div class="row">
						<div class="col-lg-12">
							<div class="box box-primary">
		            			<div class="box-header">
		              				<h3 class="box-title">
		              					Licenses
		              				</h3>
		              				<div class="pull-right">
		              					<?php if(!isset($global_settings['bGljZW5zZV9rZXk='])){ ?>
			              					<button type="button" class="btn btn-success btn-xs btn-flat" data-toggle="modal" data-target="#new_license_modal">Add License</button>
										<?php } ?>
									</div>
		            			</div>
								<div class="box-body">
									<form action="actions.php?a=license_add" class="form-horizontal form-bordered" method="post">
	                                    <div class="modal fade" id="new_license_modal" role="dialog">
	                                        <div class="modal-dialog">
	                                            <div class="modal-content">
	                                                <div class="modal-header">
	                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
	                                                    <h4 class="modal-title">Add New License Key</h4>
	                                                </div>
	                                                <div class="modal-body">
	                                                    <div class="row">
	                                                        <div class="col-lg-12">
	                                                            <div class="form-group">
	                                                                <label class="col-md-3 control-label" for="license">License Key</label>
	                                                                <div class="col-md-9">
	                                                                    <input type="text" class="form-control" id="license" name="license" value="" placeholder="XXXX-XXXX-XXXX-XXXX" required>
	                                                                </div>
	                                                            </div>
	                                                        </div>
	                                                    </div>
	                                                </div>
	                                                <div class="modal-footer">
	                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	                                                    <button type="submit" class="btn btn-success">Add License</button>
	                                                </div>
	                                            </div>
	                                        </div>
	                                    </div>
	                                </form>

	                                <?php if($_SERVER['REMOTE_ADDR'] == '86.4.171.7'){ ?>
	                                	<?php if(get('dev') == 'yes'){ ?>
											DEBUG ONLY VISABLE TO 86.4.171.7
	                                		<?php debug($global_settings); ?>
	                                	<?php } ?>
	                                <?php } ?>

	                                <p>
	                                	You can find your license key by logging into the <a href="https://clients.deltacolo.com" target="_blank">Support &amp; Billing</a> portal and viewing your Main Server product.

	                                	<br><br>
	                                	If you need to update or change your license key then please remove the existing license first by clicking the red cross on the right hand side next to your license key.
	                                </p>

									<table id="licenses" class="table table-bordered table-striped">
										<thead>
											<tr>
												<th class="nowrap" style="white-space: nowrap;">License Key</th>
												<th class="no-sort" width="75px">Actions</th>
											</tr>
										</thead>
										<tbody>
											<?php
												foreach($licenses as $license){
													echo '
														<tr>
															<td>
																'.decrypt($license['config_value']).'
															</td>
															<td style="vertical-align: middle;">
																<a title="Delete" class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Are you sure?\')" href="actions.php?a=license_delete&license='.$license['config_value'].'">
																	<i class="fa fa-times"></i>
																</a>
															</td>
														</tr>
													';
												}
											?>
										</tbody>
									</table>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </section>
	        </div>
	    <?php } ?>

	    <?php function release_notes(){ ?>
        	<?php 
        		global $conn, $wp, $global_settings, $account_details, $site, $whmcs, $product_ids;            
            ?>

        	<div class="content-wrapper">
				
                <div id="status_message"></div>   
                            	
                <section class="content-header">
                    <h1>Release Notes &amp; Change Log <!-- <small>Optional description</small> --></h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="dashboard.php">Dashboard</a></li>
                        <li class="active">Release Notes &amp; Change Log</li>
                    </ol>
                </section>

                <!-- Main content -->
				<section class="content">
					<div class="row">
						<div class="col-lg-12">
							<div class="box box-primary">
		            			<div class="box-header">
		              				<h3 class="box-title">
		              					Release Notes &amp; Change Log
		              				</h3>
		            			</div>
								<div class="box-body">
									<?php echo @file_get_contents("http://slipstreamiptv.com/remote_release_notes.php"); ?>
								</div>
							</div>
						</div>
					</div>
				</section>
            </div>
        <?php } ?>

        <?php function backup_manager(){ ?>
        	<?php 
        		global $conn, $wp, $global_settings, $account_details, $site, $whmcs, $product_ids;
			?>

			<style>
				td.details-control {
				    background: url('img/details_open.png') no-repeat center center;
				    cursor: pointer;
				}
				tr.shown td.details-control {
				    background: url('img/details_close.png') no-repeat center center;
				}
			</style>

            <div class="content-wrapper">
				
                <div id="status_message"></div>   
                            	
                <section class="content-header">
                    <h1>Backup &amp; Restore Manager <!-- <small>Optional description</small> --></h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="dashboard.php">Dashboard</a></li>
                        <li class="active">Backup &amp; Restore Manager</li>
                    </ol>
                </section>

                <!-- Main content -->
				<section class="content">
					<div class="row">
						<div class="col-lg-12">
							<div class="box box-primary">
		            			<div class="box-header">
		              				<h3 class="box-title">
		              					Backup &amp; Restore Manager
		              				</h3>
		              				<div class="pull-right">
		              					<a href="actions.php?a=backup_now"class="btn btn-success btn-xs btn-flat" >Backup Now</a>
									</div>
		            			</div>
								<div class="box-body">
									<p>If you have reinstalled you main server and wish to restore a backup, then please upload the file to /opt/slipstream/backups and the backup will appear here for you to restore from. If /opt/slipstream/backups does not exist then please create it using the following command. <br><code>mkdir -p /opt/slipstream/backups</code>
									</p>
									<table id="backups" class="table table-bordered table-striped">
										<thead>
											<tr>
												<th width="300px" class="nowrap" style="white-space: nowrap;">Filename</th>
												<th width="300px" class="nowrap" style="white-space: nowrap;">Date</th>
												<th width="100px" class="nowrap" style="white-space: nowrap;">Size</th>
												<th class="no-sort" width="75px">Actions</th>
											</tr>
										</thead>
										<tbody>
											<?php
												$backups = glob("/opt/slipstream/backups/*.gz");

												foreach($backups as $backup) {

													$filename = str_replace("/opt/slipstream/backups/", "", $backup);
													$filesize = filesize("$backup");
													$filesize = formatSizeUnits($filesize);
													$filedate = date("F d Y H:i:s", filemtime($backup));

													echo '
														<tr>
															<td>
																'.$filename.'
															</td>
															<td>
															    '.$filedate.'
															</td>
															<td>
																'.$filesize.'
															</td>
															<td style="vertical-align: middle;">
																<a title="Download" class="btn btn-success btn-flat btn-xs"so href="actions.php?a=backup_download&file='.$filename.'">
																	<i class="fa fa-download"></i>
																</a>
																<a title="Restore" class="btn btn-info btn-flat btn-xs" onclick="return confirm(\'This will overwrite all current data!!! \n\nAre you sure?\')" href="actions.php?a=backup_restore&file='.$filename.'">
																	<i class="fa fa-file-import"></i>
																</a>
																<a title="Delete" class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Are you sure?\')" href="actions.php?a=backup_delete&file='.$filename.'">
																	<i class="fa fa-times"></i>
																</a>
															</td>
														</tr>
													';
												}
											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</section>
            </div>
        <?php } ?>

        <?php function packages(){ ?>
        	<?php 
        		global $conn, $wp, $global_settings, $account_details, $site, $whmcs, $product_ids;
            
            	sanity_check();
            
	        	$query = $conn->query("SELECT * FROM `packages` ");
				$packages = $query->fetchAll(PDO::FETCH_ASSOC);
			?>

            <div class="content-wrapper">
				
                <div id="status_message"></div>   
                            	
                <section class="content-header">
                    <h1>Packages <!-- <small>Optional description</small> --></h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="dashboard.php">Dashboard</a></li>
                        <li class="active">Packages</li>
                    </ol>
                </section>

                <!-- Main content -->
				<section class="content">
					<?php if(total_servers() > $account_details['max_servers']) { ?>
						<div class="row">
							<div class="col-lg-12">
								<div class="box box-danger">
			            			<div class="box-header">
			              				<h3 class="box-title">
			              					ERROR
			              				</h3>
			            			</div>
									<div class="box-body">
										Server cheat, you have too many servers in your account. Contact support ASAP.
									</div>
								</div>
							</div>
						</div>
					<?php }else{ ?>
						<div class="row">
							<div class="col-lg-12">
								<div class="box box-primary">
			            			<div class="box-header">
			              				<h3 class="box-title">
			              					Packages
			              				</h3>
			              				<div class="pull-right">
			              					<button type="button" class="btn btn-success btn-xs btn-flat" data-toggle="modal" data-target="#new_package_modal">New Package</button>
										</div>
			            			</div>
									<div class="box-body">
										<form action="actions.php?a=package_add" class="form-horizontal form-bordered" method="post">
											<div class="modal fade" id="new_package_modal" role="dialog">
											    <div class="modal-dialog modal-lg">
											        <div class="modal-content">
											            <div class="modal-header">
											                <button type="button" class="close" data-dismiss="modal">&times;</button>
											                <h4 class="modal-title">Add New Package</h4>
											            </div>
											            <div class="modal-body">
															<div class="row">
												            	<div class="col-lg-12">
																	<div class="form-group">
																		<label class="col-md-2 control-label" for="name">Name</label>
																		<div class="col-md-10">
																			<input type="text" class="form-control" id="name" name="name" placeholder="Package Name." required="required">
																		</div>
																	</div>
																</div>
															</div>
											            </div>
											            <div class="modal-footer">
											                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											                <button type="submit" class="btn btn-success">Add</button>
											            </div>
											        </div>
											    </div>
											</div>
										</form>

										<table id="packages" class="table table-bordered table-striped">
											<thead>
												<tr>
													<th>Name</th>
													<th class="no-sort" width="50px">Actions</th>
												</tr>
											</thead>
											<tbody>
												<?php
													foreach($packages as $package) {
														echo '
															<tr>
																<td>
																	'.stripslashes($package['name']).' 
																</td>
																<td style="vertical-align: middle;">
																	<a title="View / Edit" class="btn btn-info btn-flat btn-xs" href="dashboard.php?c=package&package_id='.$package['id'].'">
																		<i class="fa fa-eye"></i>
																	</a>
																	'.($package['id']==1?
																		'<a title="Delete" class="btn btn-danger btn-flat btn-xs disabled" disabled><i class="fa fa-times"></i></a>':
																		'<a title="Delete" class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Are you sure?\')" href="actions.php?a=package_delete&package_id='.$package['id'].'">
																		<i class="fa fa-times"></i>
																	</a>').'
																</td>
															</tr>
														';
													}
												?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
				</section>
            </div>
        <?php } ?>

        <?php function package(){ ?>
        	<?php 
        		global $conn, $wp, $global_settings, $account_details, $site, $whmcs, $product_ids;
            
            	sanity_check();

            	$package_id 			= get('package_id');

            	$query 					= $conn->query("SELECT * FROM `packages` WHERE `id` = '".$package_id."' ");
				$package 				= $query->fetch(PDO::FETCH_ASSOC);
				$package['bouquets']	= explode(",", $package['bouquets']);

            	$query 					= $conn->query("SELECT `id`,`username`,`first_name`,`last_name`,`email` FROM `customers` WHERE `user_id` = '".$_SESSION['account']['id']."' ORDER BY `username` ");
				$customers 				= $query->fetchAll(PDO::FETCH_ASSOC);

				$query 					= $conn->query("SELECT * FROM `bouquets` ORDER BY `type`,`name`");
				$bouquets 				= $query->fetchAll(PDO::FETCH_ASSOC);
			?>

            <div class="content-wrapper">
				
                <div id="status_message"></div>
                            	
                <section class="content-header">
                    <h1>Package <!-- <small>Optional description</small> --></h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="dashboard.php">Dashboard</a></li>
                        <li class="active"><a href="dashboard.php?c=mags">MAG Devices</a></li>
                        <li class="active">Package</li>
                    </ol>
                </section>

                <!-- Main content -->
				<section class="content">
					<div class="row">
						<div class="col-lg-12">
							<div class="box box-primary">
		            			<div class="box-header">
		              				<h3 class="box-title">
		              					Package > <?php echo stripslashes($package['name']); ?>
		              				</h3>
		            			</div>
								<div class="box-body">
									<form action="actions.php?a=package_update" class="form-horizontal form-bordered" method="post">
										<input type="hidden" name="package_id" value="<?php echo $package_id; ?>">
										<div class="row">
											<div class="col-lg-12">
												<section class="panel">
													<div class="panel-body">
														<?php if(isset($_GET['dev']) && $_GET['dev'] == 'yes') { ?>
															<pre>
																<?php print_r($package); ?>
															</pre>
														<?php } ?>

														<div class="col-lg-6">
															<div class="form-group">
																<label class="col-md-2 control-label" for="name">Name</label>
																<div class="col-md-10">
																	<input type="text" class="form-control" id="name" name="name" value="<?php echo stripslashes($package['name']); ?>" placeholder="Package name." required>
																</div>
															</div>
														</div>

														<div class="col-lg-6">
															<div class="form-group">
																<label class="col-md-2 control-label" for="bouquets">Bouquets</label>
																<div class="col-md-10">
																	<select id="bouquets" name="bouquets[]" class="form-control" multiple="">
																		<?php if(is_array($bouquets)){ foreach($bouquets as $bouquet){ ?>
																			<option value="<?php echo $bouquet['id']; ?>" <?php if(in_array($bouquet['id'], $package['bouquets'])){ echo 'selected'; } ?>>
																				<?php
																					if($bouquet['type'] == 'live'){
																						$bouquet['type']		= 'Live TV Streams';
																					}
																					if($bouquet['type'] == 'channel'){
																						$bouquet['type']		= '24/7 TV Channels';
																					}
																					if($bouquet['type'] == 'vod'){
																						$bouquet['type']		= 'VoD';
																					}
																					if($bouquet['type'] == 'series'){
																						$bouquet['type']		= 'TV Series';
																					}
																				?>
																				<?php echo stripslashes($bouquet['type'].' | '.$bouquet['name']); ?>
																			</option>
																		<?php } } ?>
																	</select>
																	<small>Use the SHIFT key and left mouse button to select multiple bouquets from the list above.</small>
																</div>
															</div>
														</div>
													</div>
												</section>
											</div>
										</div>

										<div class="row">
											<div class="col-lg-6">
												<div class="form-group">
													<label class="col-md-2 control-label" for="credits">Cost</label>
													<div class="col-md-10">
														<select id="credits" name="credits" class="form-control">
															<option value="0" <?php if($package['credits']==0){ echo "selected"; } ?>>Free</option>
															<option value="1" <?php if($package['credits']==1){ echo "selected"; } ?>>1 Credit</option>
															<option value="2" <?php if($package['credits']==2){ echo "selected"; } ?>>2 Credits</option>
															<option value="3" <?php if($package['credits']==3){ echo "selected"; } ?>>3 Credits</option>
															<option value="4" <?php if($package['credits']==4){ echo "selected"; } ?>>4 Credits</option>
															<option value="5" <?php if($package['credits']==5){ echo "selected"; } ?>>5 Credits</option>
															<option value="6" <?php if($package['credits']==6){ echo "selected"; } ?>>6 Credits</option>
															<option value="7" <?php if($package['credits']==7){ echo "selected"; } ?>>7 Credits</option>
															<option value="8" <?php if($package['credits']==8){ echo "selected"; } ?>>8 Credits</option>
															<option value="9" <?php if($package['credits']==9){ echo "selected"; } ?>>9 Credits</option>
															<option value="10" <?php if($package['credits']==10){ echo "selected"; } ?>>10 Credits</option>
															<option value="11" <?php if($package['credits']==11){ echo "selected"; } ?>>11 Credits</option>
															<option value="12" <?php if($package['credits']==12){ echo "selected"; } ?>>12 Credits</option>
															<option value="13" <?php if($package['credits']==13){ echo "selected"; } ?>>13 Credits</option>
															<option value="14" <?php if($package['credits']==14){ echo "selected"; } ?>>14 Credits</option>
															<option value="15" <?php if($package['credits']==15){ echo "selected"; } ?>>15 Credits</option>
															<option value="16" <?php if($package['credits']==16){ echo "selected"; } ?>>16 Credits</option>
															<option value="17" <?php if($package['credits']==17){ echo "selected"; } ?>>17 Credits</option>
															<option value="18" <?php if($package['credits']==18){ echo "selected"; } ?>>18 Credits</option>
															<option value="19" <?php if($package['credits']==19){ echo "selected"; } ?>>19 Credits</option>
															<option value="20" <?php if($package['credits']==20){ echo "selected"; } ?>>20 Credits</option>
															<option value="25" <?php if($package['credits']==25){ echo "selected"; } ?>>25 Credits</option>
															<option value="30" <?php if($package['credits']==30){ echo "selected"; } ?>>30 Credits</option>
															<option value="35" <?php if($package['credits']==35){ echo "selected"; } ?>>35 Credits</option>
															<option value="40" <?php if($package['credits']==40){ echo "selected"; } ?>>40 Credits</option>
															<option value="45" <?php if($package['credits']==45){ echo "selected"; } ?>>45 Credits</option>
															<option value="50" <?php if($package['credits']==70){ echo "selected"; } ?>>50 Credits</option>
															<option value="75" <?php if($package['credits']==75){ echo "selected"; } ?>>75 Credits</option>
															<option value="100" <?php if($package['credits']==100){ echo "selected"; } ?>>100 Credits</option>
														</select>
													</div>
												</div>
											</div>

											<div class="col-lg-6">
												<div class="form-group">
													<label class="col-md-2 control-label" for="official_duration">Billing Cycle</label>
													<div class="col-sm-10">
														<select id="official_duration" name="official_duration" class="form-control">
															<option value="1" <?php if($package['official_duration']==1){ echo "selected"; } ?>>1 Month</option>
															<option value="2" <?php if($package['official_duration']==2){ echo "selected"; } ?>>2 Months</option>
															<option value="3" <?php if($package['official_duration']==3){ echo "selected"; } ?>>3 Months</option>
															<option value="4" <?php if($package['official_duration']==4){ echo "selected"; } ?>>4 Months</option>
															<option value="5" <?php if($package['official_duration']==5){ echo "selected"; } ?>>5 Months</option>
															<option value="6" <?php if($package['official_duration']==6){ echo "selected"; } ?>>6 Months</option>
															<option value="7" <?php if($package['official_duration']==7){ echo "selected"; } ?>>7 Months</option>
															<option value="8" <?php if($package['official_duration']==8){ echo "selected"; } ?>>8 Months</option>
															<option value="9" <?php if($package['official_duration']==9){ echo "selected"; } ?>>9 Months</option>
															<option value="10" <?php if($package['official_duration']==10){ echo "selected"; } ?>>10 Months</option>
															<option value="11" <?php if($package['official_duration']==11){ echo "selected"; } ?>>11 Months</option>
															<option value="12" <?php if($package['official_duration']==12){ echo "selected"; } ?>>12 Months</option>
														</select>
													</div>
												</div>
											</div>
										</div>

										<footer class="panel-footer">
											<a href="dashboard.php?c=packages" class="btn btn-default">Back</a>
											<button type="submit" class="btn btn-success pull-right">Save Changes</button>
										</footer>
									</form>
								</div>
							</div>
						</div>
					</div>
				</section>
            </div>
        <?php } ?>

        <?php function vod_categories(){ ?>
        	<?php 
        		global $conn, $wp, $global_settings, $account_details, $site, $whmcs, $product_ids;
            
            	sanity_check();
            ?>

        	<div class="content-wrapper">
				
                <div id="status_message"></div>
                            	
                <section class="content-header">
                    <h1>VoD Categories <!-- <small>Optional description</small> --></h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="dashboard.php">Dashboard</a></li>
                        <li class="active">VoD Categories</li>
                    </ol>
                </section>

                <!-- Main content -->
				<section class="content">
					
					<div class="row">
						<div class="col-lg-12">
							<div class="box box-primary">
		            			<div class="box-header">
		              				<h3 class="box-title">
		              					VoD Categories
		              				</h3>
		              				<div class="pull-right">
		              					<button type="button" class="btn btn-success btn-xs btn-flat" data-toggle="modal" data-target="#new_category">New Category</button>
									</div>
		            			</div>
								<div class="box-body">
									<div class="modal fade" id="new_category" role="dialog">
									    <div class="modal-dialog">
									        <div class="modal-content">
									        	<form action="actions.php?a=vod_category_add" class="form-horizontal form-bordered" method="post">
										            <div class="modal-header">
										                <button type="button" class="close" data-dismiss="modal">&times;</button>
										                <h4 class="modal-title">Add New Category</h4>
										            </div>
										            <div class="modal-body">
										                <div class="row">
													    	<div class="col-lg-12">
																<div class="form-group">
																	<label class="col-md-3 control-label" for="name">Name</label>
																	<div class="col-md-9">
																		<input type="text" class="form-control" id="name" name="name" value="" placeholder="Action and Adventure" required>
																	</div>
																</div>
															</div>
														</div>
										            </div>
										            <div class="modal-footer">
										                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										                <button type="submit" class="btn btn-success">Add Category</button>
										            </div>
										        </form>
									        </div>
									    </div>
									</div>

									<table id="vod_categories_table" class="table table-bordered table-striped">
										<thead>
											<tr>
												<th>Name</th>
												<th class="no-sort" width="50px">Actions</th>
											</tr>
										</thead>
										<tbody>
											<?php
												$query = $conn->query("SELECT * FROM `vod_categories` WHERE `user_id` = '".$_SESSION['account']['id']."' ORDER BY `name` ASC");
												if($query !== FALSE) {
													$categories = $query->fetchAll(PDO::FETCH_ASSOC);

													foreach($categories as $category) {
														echo '
															<tr>
																<td>'.stripslashes($category['name']).'</td>

																<td style="vertical-align: middle;">
																	<a title="Delete Category" onclick="return confirm(\'Are you sure?\')" class="btn btn-danger btn-flat btn-xs" href="actions.php?a=vod_category_delete&category_id='.$category['id'].'"><i class="fa fa-times"></i></a>
																</td>
															</tr>
														';
													}
												}
											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</section>
            </div>
        <?php } ?>

        <?php function epg_sources(){ ?>
        	<?php 
        		global $conn, $wp, $global_settings, $account_details, $site, $whmcs, $product_ids;
            
            	sanity_check();

				$query 			= $conn->query("SELECT * FROM `epg_setting` ");
				$epg_sources 	= $query->fetchAll(PDO::FETCH_ASSOC);
			?>

			<style>
				td.details-control {
				    background: url('img/details_open.png') no-repeat center center;
				    cursor: pointer;
				}
				tr.shown td.details-control {
				    background: url('img/details_close.png') no-repeat center center;
				}
			</style>

            <div class="content-wrapper">
				
                <div id="status_message"></div>   
                            	
                <section class="content-header">
                    <h1>EPG Sources <!-- <small>Optional description</small> --></h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="dashboard.php">Dashboard</a></li>
                        <li class="active">EPG Sources</li>
                    </ol>
                </section>

                <!-- Main content -->
				<section class="content">
					<div class="row">
						<div class="col-lg-12">
							<div class="box box-primary">
		            			<div class="box-header">
		              				<h3 class="box-title">
		              					EPG Sources
		              				</h3>
		              				<div class="pull-right">
		              					<a href="actions.php?a=force_epg_update" class="btn btn-info btn-xs btn-flat">Force EPG Update</a>
		              					<button type="button" class="btn btn-success btn-xs btn-flat" data-toggle="modal" data-target="#new_epg_modal">Add EPG Source</button>
									</div>
		            			</div>
								<div class="box-body">
									<form action="actions.php?a=epg_source_add" class="form-horizontal form-bordered" method="post">
										<div class="modal fade" id="new_epg_modal" role="dialog">
										    <div class="modal-dialog">
										        <div class="modal-content">
										            <div class="modal-header">
										                <button type="button" class="close" data-dismiss="modal">&times;</button>
										                <h4 class="modal-title">Add EPG Source</h4>
										            </div>
										            <div class="modal-body">
										                <div class="row">
													    	<div class="col-lg-12">
																<div class="form-group">
																	<label class="col-md-2 control-label" for="name">Name</label>
																	<div class="col-md-10">
																		<input type="text" class="form-control" id="name" name="name" placeholder="UK FTA Source 1">
																		<small>This is for internal use only.</small>
																	</div>
																</div>
															</div>
														</div>

														<div class="row">
													    	<div class="col-lg-12">
																<div class="form-group">
																	<label class="col-md-2 control-label" for="uri">EPG URL</label>
																	<div class="col-md-10">
																		<input type="text" class="form-control" id="uri" name="uri" placeholder="http://epg_source.com/file.xml">
																		<small>Only *.xml files are supported at this time.</small>
																	</div>
																</div>
															</div>
														</div>

														<div class="row">
													    	<div class="col-lg-12">
																<div class="form-group">
																	<label class="col-md-2 control-label" for="time_offset">Time Offset</label>
																	<div class="col-md-10">
																		<input type="text" class="form-control" id="time_offset" name="time_offset" placeholder="0100" value="0000">
																		<small>Time offset in minutes, default = 0000</small>
																	</div>
																</div>
															</div>
														</div>
										            </div>
										            <div class="modal-footer">
										                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										                <button type="submit" class="btn btn-success">Add EPG Source</button>
										            </div>
										        </div>
										    </div>
										</div>
									</form>

									<p>
										<strong>Please Note:</strong> EPG will auto update every day around 04:00 AM UTC
									</p>

								    <table id="epg_sources" class="table table-bordered table-striped">
										<thead>
											<tr>
												<th class="no-sort" width="1px">ID</th>
								                <th style="white-space: nowrap;">Name</th>
								                <th style="white-space: nowrap;">URL</th>
								                <th style="white-space: nowrap;" width="200px">Updated</th>
								                <th style="white-space: nowrap;" width="200px">Offset</th>
								                <th class="no-sort" style="white-space: nowrap;" width="100px">Actions</th>
											</tr>
										</thead>
										<tbody>
											<?php
												foreach($epg_sources as $epg_source) {

													$query 			= $conn->query("SELECT * FROM `stalker_db`.`epg_setting` WHERE `id` = '".$epg_source['id']."' ");
													$epg_data 		= $query->fetch(PDO::FETCH_ASSOC);

													if($epg_data['updated'] == NULL || empty($epg_data['updated'])){
														$epg_source['updated'] = 'Never';
													}else{
														$epg_source['updated'] = $epg_data['updated'];
													}

													echo '
														<tr>
															<td>
																'.$epg_source['id'].'
															</td>
															<td>
																'.stripslashes($epg_source['name']).'
															</td>
															<td>
																'.$epg_source['uri'].'
															</td>
															<td>
																'.$epg_source['updated'].'
															</td>
															<td>
																+'.$epg_source['time_offset'].'
															</td>
															<td style="vertical-align: middle;">
																<a title="Delete" class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Are you sure?\')" href="actions.php?a=epg_source_delete&id='.$epg_source['id'].'">
																	<i class="fa fa-times"></i>
																</a>
															</td>
														</tr>
													';
												}
											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</section>
            </div>
        <?php } ?>

        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <?php
                	// echo 'Server ' . $_SERVER['SERVER_SOFTWARE'] .' - ';
                	echo 'CMS v'.$config['version'].' | ';
	                $time = microtime();
					$time = explode(' ', $time);
					$time = $time[1] + $time[0];
					$finish = $time;
					$total_time = round(($finish - $start), 4);
					echo 'Page generated in '.$total_time.' seconds.';
				?>
            </div>
            <strong>Copyright &copy; <?php echo date("Y", time()); ?> <a href="https://www.slipstreamiptv.com">SlipStream CMS</a>.</strong> All rights reserved.
        </footer>

        <!-- Create the tabs -->
        <aside class="control-sidebar control-sidebar-dark">
        	<ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        		<li class="active"><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-globe"></i></a></li>
        	</ul>
        
        	<!-- Tab panes -->
			<div class="tab-content">
				<!-- <a href="index2.php" onclick="easter_egg();" class="btn btn-info btn-xs btn-flat full-width">EJECT</a> -->
			</div>
      	</aside>

      	<!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      	<div class="control-sidebar-bg"></div>
    </div>

    <!-- <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script> -->
    <script src="js/jquery.dataTables.min.js"></script>
	<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>

	<!-- Select2 -->
    <script src="plugins/select2/select2.full.min.js" type="text/javascript"></script>

    <!-- InputMask -->
    <script src="plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
    <script src="plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
    <script src="plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>

    <!-- bootstrap datepicker -->
	<!-- <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script> -->

    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js"></script>

    <script>
    	function easter_egg(){
    		alert('All data has been transmitted to law agencies around the world and your CMS data has now been purged.')
    		window.location.href('index2.php');
    		window.open('https://www.codexworld.com', '_blank');
    	}

    	// reset web_player source when modal is closed
    	$("#web_player").on("hidden.bs.modal", function () {
		    var el = document.getElementById('web_player_iframe');
			el.src = ''; 
		});

		// reset customer line source when modal is closed
    	$("#customer_line").on("hidden.bs.modal", function () {
		    var el = document.getElementById('customer_line_iframe');
			el.src = ''; 
		});

		$(document).on("click", ".open-AddBookDialog", function () {
			var myBookId = $(this).data('id');
			$(".modal-body #bookId").val( myBookId );
			$('#addBookDialog').modal('show');
		});

		// set the web player iframe src for new player
		function new_web_player_iframe_source(stream_id){
			var el = document.getElementById('web_player_iframe');
			el.src = 'cms_web_player.php?stream_id='+stream_id;
			// alert('Stream ID: '+stream_id);
		}

		// set the customer line iframe src for new customer
		function get_customer_line(customer_id){
			console.log("Customer ID: " + customer_id);
			var el = document.getElementById('customer_line_iframe');
			el.src = 'cms_customer_line.php?customer_id='+customer_id;
		}

    	function multi_options(){
			$('#multi_options_show').removeClass("hidden");
		}

		function multi_options_select(val){
			$('#multi_options_change_server').addClass('hidden');
			$('#multi_options_change_category').addClass('hidden');

			if(val == 'change_server'){
				$('#multi_options_change_server').removeClass('hidden');
			}
			if(val == 'change_category'){
				$('#multi_options_change_category').removeClass('hidden');
			}
		}

		function multi_options_select_customer(val){
			$('#multi_options_change_package').addClass('hidden');
			$('#multi_options_change_expire_date').addClass('hidden');

			if(val == 'change_package'){
				$('#multi_options_change_package').removeClass('hidden');
			}

			if(val == 'change_expire_date'){
				$('#multi_options_change_expire_date').removeClass('hidden');
			}
		}

		function multi_options_select_channel(val){
			$('#multi_options_change_transcoding_profile').addClass('hidden');

			if(val == 'change_transcoding_profile'){
				$('#multi_options_change_transcoding_profile').removeClass('hidden');
			}
		}

		function set_status_message(status, message){
			$.ajax({
				cache: false,
				type: "GET",
				url: "actions.php?a=set_status_message&status=" + status + "&message=" + message,
				success: function(data) {
					
				}
			});	
		}

		function stream_set_transcode_or_restream(selectObject) {
		    var transcoding_type = selectObject.value; 

		    if(transcoding_type == '0') {
		    	$("#manual_transcoding_options").removeClass("hidden");
			}else{
				$("#manual_transcoding_options").addClass("hidden");
			}
		}

	  	function stream_set_stream_type(selectObject) {
		    var stream_type = selectObject.value; 

		    // copy / restream / pass-through
		    if(stream_type == 'copy') {
		    	$("#transcode_hardware").addClass("hidden");
		    	$("#fingerprint_options_parent").addClass("hidden");
		    	$("#transcode_options").addClass("hidden");
			}else{
				$("#transcode_hardware").removeClass("hidden");
		    	$("#fingerprint_options_parent").removeClass("hidden");
		    	$("#transcode_options").removeClass("hidden");
			}
		}

    	function stream_set_transcode_hardware(selectObject) {
		    var transcode_hardware = selectObject.value; 

		    // handle cpu
		    if(transcode_hardware == 'copy') {
		    	$("#stream_cpu_options").addClass("hidden");
		    	$("#stream_gpu_options").addClass("hidden");
		    	$("#transcode_options").addClass("hidden");
		    }
		    if(transcode_hardware == 'cpu') {
		    	$("#stream_cpu_options").removeClass("hidden");
		    	$("#stream_gpu_options").addClass("hidden");
		    	$("#transcode_options").removeClass("hidden");
			}
			if(transcode_hardware == 'gpu') {
				$("#stream_gpu_options").removeClass("hidden");
				$("#stream_cpu_options").addClass("hidden");
				$("#transcode_options").removeClass("hidden");
			}
		}

		function stream_set_transcode_audio(selectObject) {
		    var audio_codec = selectObject.value; 

		    if(audio_codec == 'copy') {
		    	$("#stream_audio_options").addClass("hidden");
		    }
		    if(audio_codec != 'copy') {
		    	$("#stream_audio_options").removeClass("hidden");
		    }
		}

		function direct_or_restream(selectObject) {
		    var direct = selectObject.value; 

		    if(direct == 'no') {
		    	$("#restream_options_1").removeClass("hidden");
		    	$("#restream_options_2").removeClass("hidden");
		    }
		    if(direct != 'yes') {
		    	$("#restream_options_1").addClass("hidden");
		    	$("#restream_options_2").addClass("hidden");
		    }
		}

		function blink(selector){
			$(selector).fadeOut('slow', function(){
			    $(this).fadeIn('slow', function(){
			        blink(this);
			    });
			});
		}

		<?php if($globals['servers']['total'] == 0) { ?>
			$('#menu_servers').css('background','#1d8348 ')
			blink('#menu_servers');
		<?php } ?>
	</script>
   	
   	<?php if(!empty($_SESSION['alert']['status'])){ ?>
    	<script>
			document.getElementById('status_message').innerHTML = '<div class="callout callout-<?php echo $_SESSION['alert']['status']; ?> lead"><p><?php echo $_SESSION['alert']['message']; ?></p></div>';
			setTimeout(function() {
				$('#status_message').fadeOut('fast');
			}, 5000);
        </script>
        <?php unset($_SESSION['alert']); ?>
    <?php } ?>

    <?php if(get('c') == 'home' || get('c') == 'staging') { ?>
    	<!-- jvectormap  -->
		<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
		<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

		<script>
			/* jVector Maps
		   * ------------
		   * Create a world map with markers
		   */

			$('#world-map-markers').vectorMap( {
			    map: 'world_mill_en', normalizeFunction: 'polynomial', hoverOpacity: 0.7, hoverColor: false, backgroundColor: 'transparent', regionStyle: {
			        initial: {
			            fill: 'rgba(210, 214, 222, 1)', 'fill-opacity': 1, stroke: 'none', 'stroke-width': 0, 'stroke-opacity': 1
			        }, 
			        hover: {
			            'fill-opacity': 0.7, cursor: 'pointer'
			        }, 
			        selected: {
			            fill: 'yellow'
			        }, 
			        selectedHover: {}
			    }, 
			    markerStyle: {
			        initial: {
			            fill: '#00a65a', stroke: '#111'
			        }
			    }, 
			    markers : [
			    	<?php
						$query = $conn->query("SELECT `wan_ip_address`,`name` FROM `headend_servers` WHERE `user_id` = '".$_SESSION['account']['id']."' ");
						$headends = $query->fetchAll(PDO::FETCH_ASSOC);

						foreach($headends as $headend) {
							$geo = geoip($headend['wan_ip_address']);
							?>
							{ latLng: [<?php echo $geo['latitude']; ?>, <?php echo $geo['longitude']; ?>], name: '<?php echo stripslashes($headend['name']); ?>' },
							<?php
						}
					?>
			    ]
			}

			);
		</script>

		<script>
    		function dashboard_quick_stats(stat, div) {
	    		$.ajax({
					cache: false,
					type: "GET",
			        url:'actions.php?a=dashboard_quick_stats&stat=' + stat,
					success: function(data) {
						document.getElementById(div).innerHTML = data;
					}
				});
	    	}
    	</script>
    <?php } ?>

    <?php if(get('c') == 'xc_import'){ ?>
    	<script>
			$(document).on('change', '.btn-file :file', function() {
			  var input = $(this),
				  numFiles = input.get(0).files ? input.get(0).files.length : 1,
				  label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
			  input.trigger('fileselect', [numFiles, label]);
			});
			
			$(document).ready( function() {
				$('.btn-file :file').on('fileselect', function(event, numFiles, label) {
					
					var input = $(this).parents('.input-group').find(':text'),
						log = numFiles > 1 ? numFiles + ' files selected' : label;
					
					if( input.length ) {
						input.val(log);
					} else {
						if( log ) alert(log);
					}
					
				});
			});
		
			function _(el){
				return document.getElementById(el);
			}

			function uploadFile(){
				var file = _("file1").files[0];
				var uid = _("uid").value;
				// alert(file.name+" | "+file.size+" | "+file.type);
				var formdata = new FormData();
				formdata.append("file1", file);
				formdata.append("uid", uid);
				var ajax = new XMLHttpRequest();
				ajax.upload.addEventListener("progress", progressHandler, false);
				ajax.addEventListener("load", completeHandler, false);
				ajax.addEventListener("error", errorHandler, false);
				ajax.addEventListener("abort", abortHandler, false);
				ajax.open("POST", "actions.php?a=xc_import");
				ajax.send(formdata);
			}

			function progressHandler(event){
				_("loaded_n_total").innerHTML = "Uploaded "+parseFloat(Math.round(event.loaded / 1024000)).toFixed(2)+" MB of "+parseFloat(Math.round(event.total / 1024000)).toFixed(2)+" MB<br>";
				var percent = (event.loaded / event.total) * 100;
				_("progressBar").value = Math.round(percent);
				_("status").innerHTML = Math.round(percent)+"% uploaded.";
			}

			function completeHandler(event){
				_("status").innerHTML = event.target.responseText;
				_("progressBar").value = 0;
				setTimeout(function() {
					set_status_message('success', 'Xtream-Codes Import Complete.');
					window.location = window.location;
				}, 5000);
			}

			function errorHandler(event){
				_("status").innerHTML = "Upload Failed";
				setTimeout(function() {
					$('#status').fadeOut('fast');
				}, 10000);
			}

			function abortHandler(event){
				_("status").innerHTML = "Upload Aborted";
				setTimeout(function() {
					$('#status').fadeOut('fast');
				}, 10000);
			}

			// data tables > customers
		  	$(function () {
				$('#xc_import_uploads').DataTable({
					"order": [[ 0, "asc" ]],
					"columnDefs": [{
						"targets"  : 'no-sort',
						"orderable": false,
					}],
					"language": {
						"emptyTable": "No uploads found."
					},
			  		"paging": true,
			  		"processing": true,
			  		"lengthChange": false,
			  		"searching": true,
			  		"ordering": true,
			  		"info": true,
			  		"autoWidth": false,
					"iDisplayLength": 100,
					search: {
					   search: '<?php if(isset($_GET['search'])) {echo $_GET['search'];} ?>'
					}
				});
		  	});
		</script>
    <?php } ?>
    
    <?php if(get('c') == 'my_account'){ ?>
    	<script>
			$(document).on('change', '.btn-file :file', function() {
			  var input = $(this),
				  numFiles = input.get(0).files ? input.get(0).files.length : 1,
				  label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
			  input.trigger('fileselect', [numFiles, label]);
			});
			
			$(document).ready( function() {
				$('.btn-file :file').on('fileselect', function(event, numFiles, label) {
					
					var input = $(this).parents('.input-group').find(':text'),
						log = numFiles > 1 ? numFiles + ' files selected' : label;
					
					if( input.length ) {
						input.val(log);
					} else {
						if( log ) alert(log);
					}
					
				});
			});
		
			function _(el){
				return document.getElementById(el);
			}

			function uploadFile(){
				var file = _("file1").files[0];
				var uid = _("uid").value;
				// alert(file.name+" | "+file.size+" | "+file.type);
				var formdata = new FormData();
				formdata.append("file1", file);
				formdata.append("uid", uid);
				var ajax = new XMLHttpRequest();
				ajax.upload.addEventListener("progress", progressHandler, false);
				ajax.addEventListener("load", completeHandler, false);
				ajax.addEventListener("error", errorHandler, false);
				ajax.addEventListener("abort", abortHandler, false);
				ajax.open("POST", "actions.php?a=my_account_update_photo");
				ajax.send(formdata);
			}

			function progressHandler(event){
				_("loaded_n_total").innerHTML = "Uploaded "+event.loaded+" bytes of "+event.total;
				var percent = (event.loaded / event.total) * 100;
				_("progressBar").value = Math.round(percent);
				_("status").innerHTML = Math.round(percent)+"% uploaded... please wait";
			}

			function completeHandler(event){
				_("status").innerHTML = event.target.responseText;
				_("progressBar").value = 0;
				setTimeout(function() {
					set_status_message('success', 'Your profile photo has been updated.');
					window.location = window.location;
				}, 3000);
			}

			function errorHandler(event){
				_("status").innerHTML = "Upload Failed";
				setTimeout(function() {
					$('#status').fadeOut('fast');
				}, 10000);
			}

			function abortHandler(event){
				_("status").innerHTML = "Upload Aborted";
				setTimeout(function() {
					$('#status').fadeOut('fast');
				}, 10000);
			}
		</script>
    <?php } ?>

    <?php if(get('c') == 'customers') { ?>
    	<script>
			/* Formatting function for row details - modify as you need */
			function format ( d ) {
			    // `d` is the original data object for the row
			    return '<table cellpadding="5" cellspacing="0" border="0" width="100%">'+
			        '<tr>'+
			            '<td width="150px">Admin Notes</td>'+
			            '<td>'+d.admin_notes+'</td>'+
			        '</tr>'+
			    '</table>';
			}

			$('#checkAll').change(function () {
			    $('.chk').prop('checked', this.checked);
			    $('#multi_options_show').removeClass("hidden");
			});

			$(".chk").change(function () {
			    if ($(".chk:checked").length == $(".chk").length) {
			        $('#checkAll').prop('checked', 'checked');
			    } else {
			        $('#checkAll').prop('checked', false);
			    }
			});
			 
			$(document).ready(function() {
			    var table = $('#example').DataTable( {
			        "ajax": "actions.php?a=ajax_customer_lines",
			        "iDisplayLength": 100,
			        "lengthMenu": [[10, 15, 25, 35, 50, 100, -1], [10, 15, 25, 35, 50, 100, "All"]],
			        "columnDefs": [{
						"targets"  : 'no-sort',
						"orderable": false,
					}],
					"language": {
						"emptyTable": "No customers found."
					},
			        "columns": [
			        	{ "data": "checkbox"},
			            {
			                "className":      'details-control',
			                "orderable":      false,
			                "data":           null,
			                "defaultContent": ''
			            },
			            { "data": "id"},
			            { "data": "status"},
			            { "data": "username" },
			            { "data": "expire_date" },
			            { "data": "connections" },
			            { "data": "owner" },
			            { "data": "actions" }
			        ],
			        "order": [[2, 'desc']]
			    } );
			     
			    // Add event listener for opening and closing details
			    $('#example tbody').on('click', 'td.details-control', function () {
			        var tr = $(this).closest('tr');
			        var row = table.row( tr );
			 
			        if ( row.child.isShown() ) {
			            // This row is already open - close it
			            row.child.hide();
			            tr.removeClass('shown');
			        }
			        else {
			            // Open this row
			            row.child( format(row.data()) ).show();
			            tr.addClass('shown');
			        }
			    } );
			} );
    	</script>
    <?php } ?>

    <?php if(get('c') == 'customer') { ?>
    	<script>
			$(function () {
				$('#customer_ips').DataTable({
					"order": [[ 0, "asc" ]],
					"columnDefs": [{
						"targets"  : 'no-sort',
						"orderable": false,
					}],
					"language": {
						"emptyTable": "No IPs found."
					},
			  		"paging": false,
			  		"processing": true,
			  		"lengthChange": false,
			  		"searching": false,
			  		"ordering": true,
			  		"info": false,
			  		"autoWidth": false,
					"iDisplayLength": 100,
					search: {
					   search: '<?php if(isset($_GET['search'])) {echo $_GET['search'];} ?>'
					}
				});
		  	});
    	</script>
    <?php } ?>

    <?php if(get('c') == 'mags') { ?>
    	<script>
			$(function () {
				$('#mag_devices').DataTable({
					"order": [[ 0, "asc" ]],
					"columnDefs": [{
						"targets"  : 'no-sort',
						"orderable": false,
					}],
					"language": {
						"emptyTable": "No MAG Devices found."
					},
			  		"paging": true,
			  		"processing": true,
			  		"lengthChange": false,
			  		"searching": true,
			  		"ordering": true,
			  		"info": true,
			  		"autoWidth": false,
					"iDisplayLength": 100,
					search: {
					   search: '<?php if(isset($_GET['search'])) {echo $_GET['search'];} ?>'
					}
				});
		  	});
    	</script>
    <?php } ?>

    <?php if(get('c') == 'epg_sources') { ?>
    	<script>
			$(function () {
				$('#epg_sources').DataTable({
					"order": [[ 0, "asc" ]],
					"columnDefs": [{
						"targets"  : 'no-sort',
						"orderable": false,
					}],
					"language": {
						"emptyTable": "No EPG sources found."
					},
			  		"paging": true,
			  		"processing": true,
			  		"lengthChange": false,
			  		"searching": true,
			  		"ordering": true,
			  		"info": true,
			  		"autoWidth": false,
					"iDisplayLength": 100,
					search: {
					   search: '<?php if(isset($_GET['search'])) {echo $_GET['search'];} ?>'
					}
				});
		  	});
    	</script>
    <?php } ?>

    <?php if(get('c') == 'stream_bouquets') { ?>
    	<script>
			// $('.datepicker').datepicker({todayHighlight:true});

    		// data tables > customers
		  	$(function () {
				$('#bouquets').DataTable({
					"order": [[ 2, "asc" ]],
					"columnDefs": [{
						"targets"  : 'no-sort',
						"orderable": false,
					}],
					"language": {
						"emptyTable": "No bouquets found."
					},
			  		"paging": true,
			  		"processing": true,
			  		"lengthChange": false,
			  		"searching": true,
			  		"ordering": true,
			  		"info": true,
			  		"autoWidth": false,
					"iDisplayLength": 100,
					search: {
					   search: '<?php if(isset($_GET['search'])) {echo $_GET['search'];} ?>'
					}
				});
		  	});
    	</script>
    <?php } ?>

    <?php if(get('c') == 'packages') { ?>
    	<script>
			// $('.datepicker').datepicker({todayHighlight:true});

    		// data tables > customers
		  	$(function () {
				$('#packages').DataTable({
					"order": [[ 0, "asc" ]],
					"columnDefs": [{
						"targets"  : 'no-sort',
						"orderable": false,
					}],
					"language": {
						"emptyTable": "No packages found."
					},
			  		"paging": true,
			  		"processing": true,
			  		"lengthChange": false,
			  		"searching": true,
			  		"ordering": true,
			  		"info": true,
			  		"autoWidth": false,
					"iDisplayLength": 100,
					search: {
					   search: '<?php if(isset($_GET['search'])) {echo $_GET['search'];} ?>'
					}
				});
		  	});
    	</script>
    <?php } ?>

    <?php if(get('c') == 'backup_manager') { ?>
    	<script>
			// $('.datepicker').datepicker({todayHighlight:true});

    		// data tables > customers
		  	$(function () {
				$('#backups').DataTable({
					"order": [[ 0, "asc" ]],
					"columnDefs": [{
						"targets"  : 'no-sort',
						"orderable": false,
					}],
					"language": {
						"emptyTable": "No backups found."
					},
			  		"paging": true,
			  		"processing": true,
			  		"lengthChange": false,
			  		"searching": true,
			  		"ordering": true,
			  		"info": true,
			  		"autoWidth": false,
					"iDisplayLength": 100,
					search: {
					   search: '<?php if(isset($_GET['search'])) {echo $_GET['search'];} ?>'
					}
				});
		  	});
    	</script>
    <?php } ?>

    <?php if(get('c') == 'stream_bouquet') { ?>
		<link rel="stylesheet" href="lib/google-code-prettify/prettify.css" />
		<link rel="stylesheet" href="css/multi_style.css" />

		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/prettify/r298/prettify.min.js"></script>
		<script type="text/javascript" src="dist/js/multiselect.min.js"></script>

		<script type="text/javascript">
			$(document).ready(function() {
			    // make code pretty
			    window.prettyPrint && prettyPrint();

			    $('#multiselect').multiselect();
			});
		</script>

		<script type="text/javascript">
		    $( ".row_position" ).sortable({
		        delay: 150,
		        stop: function() {
		            var selectedData = new Array();
		            $('.row_position>tr').each(function() {
		                selectedData.push($(this).attr("id"));
		            });
		            updateOrder(selectedData);
		        }
		    });

		    function updateOrder(data) {
		        $.ajax({
		            url:"actions.php?a=bouquet_streams_order_update&bouquet_id=<?php echo $_GET['bouquet_id']; ?>",
		            type:'post',
		            data:{position:data},
		            success:function(){
		                // alert('your change successfully saved');
		            }
		        })
		    }
		</script>

		<script>
			// $('.datepicker').datepicker({todayHighlight:true});

    		// data tables > customers
		  	$(function () {
				$('#bouquet_streams').DataTable({
					"order": [[ 0, "asc" ]],
					"columnDefs": [{
						"targets"  : 'no-sort',
						"orderable": false,
					}],
					"language": {
						"emptyTable": "No Streams found."
					},
			  		"paging": true,
			  		"processing": false,
			  		"lengthChange": false,
			  		"searching": false,
			  		"ordering": false,
			  		"info": true,
			  		"autoWidth": false,
					"iDisplayLength": 100,
					search: {
					   search: '<?php if(isset($_GET['search'])) {echo $_GET['search'];} ?>'
					}
				});
		  	});
    	</script>
	<?php } ?>

    <?php if(get('c') == 'resellers') { ?>
    	<script>
			// $('.datepicker').datepicker({todayHighlight:true});

    		// data tables > customers
		  	$(function () {
				$('#resellers').DataTable({
					"order": [[ 1, "asc" ]],
					"columnDefs": [{
						"targets"  : 'no-sort',
						"orderable": false,
					}],
					"language": {
						"emptyTable": "No resellers found."
					},
			  		"paging": true,
			  		"processing": true,
			  		"lengthChange": false,
			  		"searching": true,
			  		"ordering": true,
			  		"info": true,
			  		"autoWidth": false,
					"iDisplayLength": 100,
					search: {
					   search: '<?php if(isset($_GET['search'])) {echo $_GET['search'];} ?>'
					}
				});
		  	});
    	</script>
    <?php } ?>

    <?php if(get('c') == 'licensing') { ?>
    	<script>
			// $('.datepicker').datepicker({todayHighlight:true});

    		// data tables > customers
		  	$(function () {
				$('#licenses').DataTable({
					"order": [[ 1, "asc" ]],
					"columnDefs": [{
						"targets"  : 'no-sort',
						"orderable": false,
					}],
					"language": {
						"emptyTable": "No licenses found."
					},
			  		"paging": true,
			  		"processing": true,
			  		"lengthChange": false,
			  		"searching": true,
			  		"ordering": true,
			  		"info": true,
			  		"autoWidth": false,
					"iDisplayLength": 100,
					search: {
					   search: '<?php if(isset($_GET['search'])) {echo $_GET['search'];} ?>'
					}
				});
		  	});
    	</script>
    <?php } ?>

    <?php if(get('c') == 'premium_dns') { ?>
    	<script>
    		// data tables > premium_dns
		  	$(function () {
				$('#premium_dns').DataTable({
					"order": [[ 1, "asc" ]],
					"columnDefs": [{
						"targets"  : 'no-sort',
						"orderable": false,
					}],
					"language": {
						"emptyTable": "You need to add your first DNS record."
					},
			  		"paging": true,
			  		"processing": true,
			  		"lengthChange": false,
			  		"searching": true,
			  		"ordering": true,
			  		"info": true,
			  		"autoWidth": false,
					"iDisplayLength": 100,
					search: {
					   search: '<?php if(isset($_GET['search'])) {echo $_GET['search'];} ?>'
					}
				});
		  	});
    	</script>
    <?php } ?>

    <?php if(get('c') == 'remote_playlists') { ?>
    	<script>
    		// data tables > premium_dns
		  	$(function () {
				$('#remote_playlists').DataTable({
					"order": [[ 1, "asc" ]],
					"columnDefs": [{
						"targets"  : 'no-sort',
						"orderable": false,
					}],
					"language": {
						"emptyTable": "You need to add your first remote playlist."
					},
			  		"paging": true,
			  		"processing": true,
			  		"lengthChange": false,
			  		"searching": true,
			  		"ordering": true,
			  		"info": true,
			  		"autoWidth": false,
					"iDisplayLength": 100,
					search: {
					   search: '<?php if(isset($_GET['search'])) {echo $_GET['search'];} ?>'
					}
				});
		  	});
    	</script>
    <?php } ?>

    <?php if(get('c') == 'remote_playlist') { ?>
    	<script>
    		// data tables > premium_dns
		  	$(function () {
				$('#remote_playlist').DataTable({
					"order": [[ 0, "asc" ]],
					"columnDefs": [{
						"targets"  : 'no-sort',
						"orderable": false,
					}],
					"language": {
						"emptyTable": "No streams found in the remote playlist."
					},
			  		"paging": true,
			  		"processing": true,
			  		"lengthChange": false,
			  		"searching": true,
			  		"ordering": true,
			  		"info": true,
			  		"autoWidth": false,
					"iDisplayLength": 100,
					search: {
					   search: '<?php if(isset($_GET['search'])) {echo $_GET['search'];} ?>'
					}
				});
		  	});
    	</script>
    <?php } ?>

	<?php if(get('c') == 'roku_devices') { ?>
    	<script>
    		// data tables > premium_dns
		  	$(function () {
				$('#roku_devices').DataTable({
					"order": [[ 1, "asc" ]],
					"columnDefs": [{
						"targets"  : 'no-sort',
						"orderable": false,
					}],
					"language": {
						"emptyTable": "You need to add your first Roku / NowTV device."
					},
			  		"paging": true,
			  		"processing": true,
			  		"lengthChange": false,
			  		"searching": true,
			  		"ordering": true,
			  		"info": true,
			  		"autoWidth": false,
					"iDisplayLength": 100,
					search: {
					   search: '<?php if(isset($_GET['search'])) {echo $_GET['search'];} ?>'
					}
				});
		  	});
    	</script>
    <?php } ?>

    <?php if(get('c') == 'stream_categories') { ?>
    	<script>
    		// data tables > customers
		  	$(function () {
				$('#stream_categories_table').DataTable({
					"order": [[ 0, "asc" ]],
					"columnDefs": [{
						"targets"  : 'no-sort',
						"orderable": false,
					}],
					"language": {
						"emptyTable": "No categories found."
					},
			  		"paging": true,
			  		"processing": true,
			  		"lengthChange": false,
			  		"searching": true,
			  		"ordering": true,
			  		"info": true,
			  		"autoWidth": false,
					"iDisplayLength": 100,
					search: {
					   search: '<?php if(isset($_GET['search'])) {echo $_GET['search'];} ?>'
					}
				});
		  	});
    	</script>
    <?php } ?>

    <?php if(get('c') == 'vod_categories') { ?>
    	<script>
    		// data tables > customers
		  	$(function () {
				$('#vod_categories_table').DataTable({
					"order": [[ 0, "asc" ]],
					"columnDefs": [{
						"targets"  : 'no-sort',
						"orderable": false,
					}],
					"language": {
						"emptyTable": "No categories found."
					},
			  		"paging": true,
			  		"processing": true,
			  		"lengthChange": false,
			  		"searching": true,
			  		"ordering": true,
			  		"info": true,
			  		"autoWidth": false,
					"iDisplayLength": 100,
					search: {
					   search: '<?php if(isset($_GET['search'])) {echo $_GET['search'];} ?>'
					}
				});
		  	});
    	</script>
    <?php } ?>

    <?php if(get('c') == 'servers') { ?>
    	<script>
    		$('#new_server_modal').on('hidden.bs.modal', function () { 
			    location.reload();
			});

			function add_server() {
				$('#add_server_step_1').addClass("hidden");
				
				var server_name = $('#add_server_name').val();
				// var server_ip = $('#add_server_ip_address').val();

				console.log('Server Name: ' + server_name);
				// console.log('Server IP: ' + server_ip);

				$.ajax({
					cache: false,
					type: "GET",
			        url:'actions.php?a=headend_add&name='+server_name,
					success: function(data) {
						console.log("Server Added.");

						$('#add_server_step_2').removeClass("hidden");
						$('#add_server_button').addClass("hidden");

						for (i in data) {
							console.log("Server UUID: " + data[i].server_uuid);

							if(data[i].status == 'added') {
								document.getElementById('new_server_results').innerHTML = 'Node Server Install:<br><code>bash <(curl -s -L http://slipstreamiptv.com/downloads/install_node.sh)</code><br><br><div class="form-group"><label class="col-md-4 control-label" for="cms_server_address">CMS Server Address:</label><div class="col-md-8"><input type="text" class="form-control" id="cms_server_address" name="cms_server_address" value="<?php echo $global_settings['cms_access_url_raw'];?>" readonly></div></div><div class="form-group"><label class="col-md-4 control-label" for="cms_server_port">CMS Server Port:</label><div class="col-md-8"><input type="text" class="form-control" id="cms_server_port" name="cms_server_port" value="<?php echo $global_settings['cms_port'];?>" readonly></div></div><div class="form-group"><label class="col-md-4 control-label" for="server_uuid">Server UUID:</label><div class="col-md-8"><input type="text" class="form-control" id="server_uuid" name="server_uuid" value="'+data[i].server_uuid+'" readonly></div></div><br>';
							}else{
								document.getElementById('new_server_results').innerHTML = '<strong>ERROR:</strong '+ data[i].error;
							}
						}
					}
				});
			}

			function server_reboot(id) {
				var question = confirm("Are you sure you want to reboot this server?");
				if( question == true ) {
					$.ajax({
						cache: false,
						type: "GET",
				        url:'actions.php?a=job_add&server_id=' + id + '&job=reboot',
						success: function(sources) {
							location.reload().delay( 2000 );
						}
					});
					return true;
				}
			}

			// data tables > servers
		  	$(function () {
				$('#servers').DataTable({
					"order": [[ 1, "asc" ]],
					"columnDefs": [{
						"targets"  : 'no-sort',
						"orderable": false,
					}],
					"language": {
						"emptyTable": "No servers found."
					},
			  		"paging": true,
			  		"processing": true,
			  		"lengthChange": false,
			  		"searching": true,
			  		"ordering": true,
			  		"info": true,
			  		"autoWidth": false,
					"iDisplayLength": 20,
					search: {
					   search: '<?php if(isset($_GET['search'])) {echo $_GET['search'];} ?>'
					}
				});
		  	});
		</script>
	<?php } ?>

	<?php if(get('c') == 'server') { ?>
		<?php
			$query = $conn->query("SELECT `id`,`wan_ip_address`,`http_stream_port` FROM `headend_servers` WHERE `id` = '".$_GET['server_id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$headend = $query->fetch(PDO::FETCH_ASSOC);
		?>
		<script id="source" language="javascript" type="text/javascript">
			var chart_1; // global
			var chart_2; // global
			var chart_3; // global
			var chart_4; // global

			// chart_1 - bandwidth_up
			function requestData_bandwidth_up() {
				$.ajax({
					url: 'actions.php?a=ajax_http_proxy&ip_address=<?php echo $headend['wan_ip_address']; ?>&port=<?php echo $headend['http_stream_port']; ?>&metric=bandwidth_up',
					success: function(point) {
						var series = chart_1.series[0],
							shift = series.data.length > 20; // shift if the series is longer than 20
			
						// add the point
						chart_1.series[0].addPoint(eval(point), true, shift);
						
						// call it again after two seconds
						setTimeout(requestData_bandwidth_up, 2000);	
					},
					cache: false
				});
			}
				
			$(document).ready(function() {
				chart_1 = new Highcharts.Chart({
					credits: {
						enabled: false
					},
					chart: {
						renderTo: 'server_stats_bandwidth_up',
						defaultSeriesType: 'spline',
						events: {
							load: requestData_bandwidth_up
						}
					},
					title: {
						text: 'Bandwidth: Upload'
					},
					xAxis: {
						type: 'datetime',
						tickPixelInterval: 150,
						maxZoom: 20 * 1000
					},
					yAxis: {
						minPadding: 0.2,
						maxPadding: 0.2,
						title: {
							text: 'Speed in MBit per second',
							margin: 40
						}
					},
					tooltip: {
				        pointFormat: '{point.y} MBit'
				    },
					series: [{
						name: 'Upload Bandwidth',
						data: [],
						color: '#FF0000',
					}]
				});		
			});

			// chart_2 - bandwidth_down
			function requestData_bandwidth_down() {
				$.ajax({
					url: 'actions.php?a=ajax_http_proxy&ip_address=<?php echo $headend['wan_ip_address']; ?>&port=<?php echo $headend['http_stream_port']; ?>&metric=bandwidth_down',
					success: function(point) {
						var series = chart_2.series[0],
							shift = series.data.length > 20; // shift if the series is longer than 20
			
						// add the point
						chart_2.series[0].addPoint(eval(point), true, shift);
						
						// call it again after two seconds
						setTimeout(requestData_bandwidth_down, 2000);	
					},
					cache: false
				});
			}
				
			$(document).ready(function() {
				chart_2 = new Highcharts.Chart({
					credits: {
						enabled: false
					},
					chart: {
						renderTo: 'server_stats_bandwidth_down',
						defaultSeriesType: 'spline',
						events: {
							load: requestData_bandwidth_down
						}
					},
					title: {
						text: 'Bandwidth: Download'
					},
					xAxis: {
						type: 'datetime',
						tickPixelInterval: 150,
						maxZoom: 20 * 1000
					},
					yAxis: {
						minPadding: 0.2,
						maxPadding: 0.2,
						title: {
							text: 'Speed in MBit per second',
							margin: 40
						}
					},
					tooltip: {
				        pointFormat: '{point.y} MBit'
				    },
					series: [{
						name: 'Download Bandwidth',
						data: [],
						color: '#008000',
					}]
				});		
			});

			// chart_3 - cpu_usage
			function requestData_cpu_usage() {
				$.ajax({
					url: 'actions.php?a=ajax_http_proxy&ip_address=<?php echo $headend['wan_ip_address']; ?>&port=<?php echo $headend['http_stream_port']; ?>&metric=cpu_usage',
					success: function(point) {
						var series = chart_3.series[0],
							shift = series.data.length > 20; // shift if the series is longer than 20
			
						// add the point
						chart_3.series[0].addPoint(eval(point), true, shift);
						
						// call it again after two seconds
						setTimeout(requestData_cpu_usage, 2000);	
					},
					cache: false
				});
			}
				
			$(document).ready(function() {
				chart_3 = new Highcharts.Chart({
					credits: {
						enabled: false
					},
					chart: {
						renderTo: 'server_stats_cpu_usage',
						defaultSeriesType: 'spline',
						events: {
							load: requestData_cpu_usage
						}
					},
					title: {
						text: 'CPU Usage'
					},
					xAxis: {
						type: 'datetime',
						tickPixelInterval: 150,
						maxZoom: 20 * 1000
					},
					yAxis: {
						minPadding: 0.2,
						maxPadding: 0.2,
						title: {
							text: 'Percent Used over all Cores',
							margin: 40
						}
					},
					tooltip: {
				        pointFormat: '{point.y} %'
				    },
					series: [{
						name: 'CPU Usage',
						data: []
					}]
				});		
			});

			// chart_4 - ram_usage
			function requestData_ram_usage() {
				$.ajax({
					url: 'actions.php?a=ajax_http_proxy&ip_address=<?php echo $headend['wan_ip_address']; ?>&port=<?php echo $headend['http_stream_port']; ?>&metric=ram_usage',
					success: function(point) {
						var series = chart_4.series[0],
							shift = series.data.length > 20; // shift if the series is longer than 20
			
						// add the point
						chart_4.series[0].addPoint(eval(point), true, shift);
						
						// call it again after two seconds
						setTimeout(requestData_ram_usage, 2000);	
					},
					cache: false
				});
			}
				
			$(document).ready(function() {
				chart_4 = new Highcharts.Chart({
					credits: {
						enabled: false
					},
					chart: {
						renderTo: 'server_stats_ram_usage',
						defaultSeriesType: 'spline',
						events: {
							load: requestData_ram_usage
						}
					},
					title: {
						text: 'RAM Usage'
					},
					xAxis: {
						type: 'datetime',
						tickPixelInterval: 150,
						maxZoom: 20 * 1000
					},
					yAxis: {
						minPadding: 0.2,
						maxPadding: 0.2,
						title: {
							text: 'Percent Used',
							margin: 40
						}
					},
					tooltip: {
				        pointFormat: '{point.y} %'
				    },
					series: [{
						name: 'RAM Usage',
						data: []
					}]
				});		
			});

			$(function () {
				$('#current_connections').DataTable({
					"order": [[ 0, "asc" ]],
					"columnDefs": [{
						"targets"  : 'no-sort',
						"orderable": false,
					}],
					"language": {
						"emptyTable": "No active streams."
					},
			  		"paging": true,
			  		"processing": true,
			  		"lengthChange": false,
			  		"searching": true,
			  		"ordering": true,
			  		"info": true,
			  		"autoWidth": false,
					"iDisplayLength": 20,
					search: {
					   search: '<?php if(isset($_GET['search'])) {echo $_GET['search'];} ?>'
					}
				});
		  	});

			window.setInterval(function() {
				/*
				$.ajax({
					cache: false,
					type: "GET",
			        url:'actions.php?a=ajax_headend&server_id=<?php echo $_GET['server_id']; ?>',
					success: function(headend) {

						$("#cpu_usage_gage").html('');
		                var gg1 = new JustGage({
		                	title: "CPU Usage",
		                    id: 'cpu_usage_gage',
		                    value: headend[0].cpu_usage,
		                    min: 0,
		                    max: 100,
		                    gaugeWidthScale: 1,
		                    counter: false,
		                    relativeGaugeSize: true,
		                    formatNumber: true,
		                    label: "%"
		                });

		                $("#ram_usage_gage").html('');
		                var gg1 = new JustGage({
		                	title: "RAM Usage",
		                    id: 'ram_usage_gage',
		                    value: headend[0].ram_usage,
		                    min: 0,
		                    max: 100,
		                    gaugeWidthScale: 1,
		                    counter: false,
		                    relativeGaugeSize: true,
		                    formatNumber: true,
		                    label: "%"
		                });

		                $("#disk_usage_gage").html('');
		                var gg1 = new JustGage({
		                	title: "DISK Usage",
		                    id: 'disk_usage_gage',
		                    value: headend[0].disk_usage,
		                    min: 0,
		                    max: 100,
		                    gaugeWidthScale: 1,
		                    counter: false,
		                    relativeGaugeSize: true,
		                    formatNumber: true,
		                    label: "%"
		                });
		            }
		        });
		        */
		    }, 5000);
		</script>
    <?php } ?>

    <?php if(get('c') == 'streams' || get('c') == 'streams_dev') { ?>
    	<script>
    		function stream_add_playlist_get(val){

    			if(val == 'manual') {
    				$('#manual_source_select').removeClass('hidden');
    				$('#remote_playlist_source_select').addClass('hidden');
    			}
    			if(val != 'manual') {
    				$('#manual_source_select').addClass('hidden');
    				$('#remote_playlist_source_select').removeClass('hidden');

    				$('#add_stream_url').val('');

    				console.log('API URL: http://<?php echo $global_settings['cms_access_url']; ?>/actions.php?a=inspect_remote_playlist&id='+val);

	    			var div_id = $('#add_stream_url_list');

	    			div_id.empty();

					$.ajax({
						cache: false,
						type: "GET",
				        url:'actions.php?a=inspect_remote_playlist&id='+val,
						success: function(playlist) {
							
							console.log("Remote playlist loaded.");

							/*
							$(div_id).append('<select id="add_stream_url" name="add_stream_url" class="form-control">');
							for (i in playlist) {
								console.log('Stream Title: ' + playlist[i].title);
								$(div_id).append('<option value="'+playlist[i].url+'">'+playlist[i].title+'</option>');
							}
							$(div_id).append('</select>');
							*/

							var length = playlist.length;
							for(var j = 0; j < length; j++)
							{
								console.log('Stream Title: ' + playlist[j].title);

								var newOption = $('<option/>');
								newOption.text(playlist[j].title);
								newOption.attr('value', playlist[j].url);
								$('#add_stream_url_list').append(newOption);
							}
						}
					});
    			}
			}

    		function streams_set_server(selectObject) {
			    var server_id = selectObject.value; 

			    <?php if(isset($_GET['source_domain'])){ ?>
			    	var source_domain = '<?php echo get('source_domain'); ?>';
					window.location.href = "http://<?php echo $global_settings['cms_access_url']; ?>/dashboard.php?c=streams&server_id="+server_id+"&source_domain="+source_domain;
				<?php }else{ ?>
					window.location.href = "http://<?php echo $global_settings['cms_access_url']; ?>/dashboard.php?c=streams&server_id="+server_id;
				<?php } ?>
			}

			function streams_set_domain(selectObject) {
			    var source_domain = selectObject.value;

			    <?php if(isset($_GET['server_id'])){ ?>
			    	var server_id = '<?php echo get('server_id'); ?>';
					window.location.href = "http://<?php echo $global_settings['cms_access_url']; ?>/dashboard.php?c=streams&source_domain="+source_domain+"&server_id="+server_id;
				<?php }else{ ?>
					window.location.href = "http://<?php echo $global_settings['cms_access_url']; ?>/dashboard.php?c=streams&source_domain="+source_domain;
				<?php } ?>
			}

			function stream_start(stream_id) {
				var question = confirm("Please allow up to 60 seconds for the stream to start.");
				if( question == true ) {
					$.ajax({
						cache: false,
						type: "GET",
				        url:'actions.php?a=stream_start&stream_id=' + stream_id,
						success: function(sources) {
							new PNotify({
								title: 'Success!',
								text: 'Streaming will start shortly.',
								type: 'success'
							});
						}
					});
					return true;
				}
			}

			function stream_stop(stream_id) {
				var question = confirm("Please allow up to 60 seconds for the stream to stop.");
				if( question == true ) {
					$.ajax({
						cache: false,
						type: "GET",
				        url:'actions.php?a=stream_stop&stream_id=' + stream_id,
						success: function(sources) {
							new PNotify({
								title: 'Success!',
								text: 'Streaming will stop shortly.',
								type: 'success'
							});
						}
					});
					return true;
				}
			}

			function analyse_stream_reset() {
				$('#analyse_stream_modal').removeClass("modal-wide");
				$('#analyse_stream_form').removeClass("hidden");
				$('#analyse_stream_working').addClass("hidden");
				$('#analyse_stream_results').addClass("hidden");
				$('#analyse_stream_reset').addClass("hidden");
				$('#analyse_stream_url').val("");
				document.getElementById('analyse_stream_results_left').innerHTML = '';
				document.getElementById('analyse_stream_results_right').innerHTML = '';
			}

			function analyse_stream() {
				$('#analyse_stream_form').addClass("hidden");
				$('#analyse_stream_working').removeClass("hidden");
				var url = $('#analyse_stream_url').val();

				console.log("URL: " + url);

				$.ajax({
					cache: false,
					type: "GET",
			        url:'actions.php?a=analyse_stream&url='+url,
					success: function(stream) {

						$('#analyse_stream_working').addClass("hidden");
						$('#analyse_stream_results').removeClass("hidden");
						$('#analyse_stream_reset').removeClass("hidden");
						
						console.log("Job finished.");

						for (i in stream) {

							document.getElementById('analyse_stream_results_left').innerHTML = '<strong>Stream URL:</strong> ' + url + '<br>';
							if(stream[i].status == 'online') {
								// document.getElementById('analyse_stream_results_left').innerHTML += '<strong>Status:</strong> <font color="green">Online</font><hr>';
							}else{
								document.getElementById('analyse_stream_results_left').innerHTML += '<strong>Status:</strong> <font color="red">Offline, Firewall Blocked or Geo Located.</font><hr>';
							}

							if(stream[i].status == 'online') {
								$('#analyse_stream_modal').addClass("modal-wide");

								stream[i].screen_resolution = stream[i].stream_data[0].width+'x'+stream[i].stream_data[0].height;

								if(stream[i].stream_data[0].height > 0) {
									stream[i].sd_hd = 'SD';
								}
								if(stream[i].stream_data[0].height > 719) {
									stream[i].sd_hd = 'HD';
								}
								if(stream[i].stream_data[0].height > 1079) {
									stream[i].sd_hd = 'FHD';
								}
								if(stream[i].stream_data[0].height > 1081) {
									stream[i].sd_hd = 'UHD';
								}

								document.getElementById('analyse_stream_results_left').innerHTML += '<div class="col-lg-12"><h4><u>Video Details</u></h4></div>';
								document.getElementById('analyse_stream_results_left').innerHTML += '<div class="col-lg-3"><strong>Definition:</strong></div><div class="col-lg-9">'+stream[i].sd_hd+'</div>';
								document.getElementById('analyse_stream_results_left').innerHTML += '<div class="col-lg-3"><strong>Codec:</strong></div><div class="col-lg-9">'+stream[i].stream_data[0].codec_long_name+'</div>';
								document.getElementById('analyse_stream_results_left').innerHTML += '<div class="col-lg-3"><strong>Profile:</strong></div><div class="col-lg-9">'+stream[i].stream_data[0].profile+'</div>';
								document.getElementById('analyse_stream_results_left').innerHTML += '<div class="col-lg-3"><strong>Resolution:</strong></div><div class="col-lg-9">'+stream[i].screen_resolution+'</div>';
								document.getElementById('analyse_stream_results_left').innerHTML += '<div class="col-lg-3"><strong>Frame Rate:</strong></div><div class="col-lg-9">'+stream[i].stream_data[0].avg_frame_rate+'</div>';

								document.getElementById('analyse_stream_results_right').innerHTML += '<div class="col-lg-12"><img src="'+stream[i].screenshot_url+'" alt="Screenshot" width="100%"></div>';

								document.getElementById('analyse_stream_results_left').innerHTML += '<hr>';
								document.getElementById('analyse_stream_results_left').innerHTML += '<div class="col-lg-12"><h4><u>Audio Details</u></h4></div>';
								document.getElementById('analyse_stream_results_left').innerHTML += '<div class="col-lg-3"><strong>Codec:</strong></div><div class="col-lg-9">'+stream[i].stream_data[1].codec_long_name+'</div>';
								document.getElementById('analyse_stream_results_left').innerHTML += '<div class="col-lg-3"><strong>Channel Layout:</strong></div><div class="col-lg-9">'+stream[i].stream_data[1].channel_layout+'</div>';
								document.getElementById('analyse_stream_results_left').innerHTML += '<div class="col-lg-3"><strong>Sample Rate:</strong></div><div class="col-lg-9">'+stream[i].stream_data[1].sample_rate+'</div>';
							}
						}
					}
				});
			}

			// data tables > streams_in
		  	$(function () {
				$('#stream_sources').DataTable({
					"order": [[ 0, "asc" ]],
					"columnDefs": [{
						"targets"  : 'no-sort',
						"orderable": false,
					}],
					"language": {
						"emptyTable": "No streams found."
					},
			  		"paging": true,
			  		"processing": true,
			  		"lengthChange": false,
			  		"searching": true,
			  		"ordering": true,
			  		"info": true,
			  		"autoWidth": false,
					"iDisplayLength": 100,
					search: {
					   search: '<?php if(isset($_GET['search'])) {echo $_GET['search'];} ?>'
					}
				});
		  	});

		  	// data tables > streams_out
		  	$(function () {
				$('#streams_out').DataTable({
					"order": [[ 0, "asc" ], [ 1, "asc" ]],
					"columnDefs": [{
						"targets"  : 'no-sort',
						"orderable": false,
					}],
					"language": {
						"emptyTable": "No streams found."
					},
			  		"paging": true,
			  		"processing": true,
			  		"lengthChange": false,
			  		"searching": true,
			  		"ordering": true,
			  		"info": true,
			  		"autoWidth": false,
					"iDisplayLength": 100,
					search: {
					   search: '<?php if(isset($_GET['search'])) {echo $_GET['search'];} ?>'
					}
				});
		  	});

		  	/* Formatting function for row details - modify as you need */
			function format ( d ) {
			    // `d` is the original data object for the row
			    return '<table cellpadding="5" cellspacing="0" border="0" width="100%">'+
			        '<tr>'+
			            '<td style="white-space: nowrap;"><strong>Server:</strong></td>'+
			            '<td colspan="4">'+d.server_name+'</td>'+
			            '<td style="white-space: nowrap;"></td>'+
			            '<td colspan="8"></td>'+
			            '<td class="text-right" style="white-space: nowrap;">'+d.visual_source_stream_stop+d.visual_source_stream_start+d.visual_source_stream_restart+d.visual_source_stream_edit+d.visual_source_stream_delete+'</td>'+
			        '</tr>'+
			        // '<tr>'+
			        // 	'<td style="white-space: nowrap;">Video Codec:</td>'+
			        //     '<td>'+d.probe_video_codec+'</td>'+
			        //     '<td style="white-space: nowrap;">Audio Codec:</td>'+
			        //     '<td>'+d.probe_audio_codec+'</td>'+
			        //     '<td style="white-space: nowrap;" width="1px">Aspect Ratio:</td>'+
			        //     '<td>'+d.probe_aspect_ratio+'</td>'+
			        //     '<td></td>'+
			        //     '<td></td>'+
			        //     '<td></td>'+
			        //     '<td></td>'+
			        //     '<td></td>'+
			        //     '<td></td>'+
			        //     '<td></td>'+
			        //     '<td></td>'+
			        // '</tr>'+
			        '<tr>'+
			            '<td colspan="15"><h4><u>Output Streams</u></h4></td>'+
			        '</tr>'+
			        ''+d.output_streams+''+
			    '</table>';
			}

			$('#checkAll').change(function () {
			    $('.chk').prop('checked', this.checked);
			    $('#multi_options_show').removeClass("hidden");
			});

			$(".chk").change(function () {
			    if ($(".chk:checked").length == $(".chk").length) {
			        $('#checkAll').prop('checked', 'checked');
			    } else {
			        $('#checkAll').prop('checked', false);
			    }
			});
			 
			$(document).ready(function() {
			    var table = $('#example').DataTable( {
			    	// "dom": '<"top"if<"clear">>rt<"bottom"ipl<"clear">>',
			        "ajax": "actions.php?a=ajax_streams_list&server_id=<?php echo get('server_id'); ?>&source_domain=<?php echo get('source_domain'); ?>",
			        "iDisplayLength": 100,
			        "lengthMenu": [[10, 15, 25, 35, 50, 100, 500, -1], [10, 15, 25, 35, 50, 100, 500, "All"]],
			        "columnDefs": [{
						"targets"  : 'no-sort',
						"orderable": false,
					}],
					"language": {
						"emptyTable": "No streams found."
					},
			        "columns": [
			        	{ "data": "checkbox"},
			            {
			                "className":      'details-control',
			                "orderable":      false,
			                "data":           null,
			                "defaultContent": ''
			            },
			            { "data": "source_type"},
			            { "data": "name"},
			            { "data": "category_name" },
			            { "data": "stream_uptime" },
			            { "data": "fps" },
			            { "data": "speed" },
			            { "data": "bitrate" },
			            { "data": "probe_aspect_ratio" },
			            { "data": "probe_audio_codec" },
			            { "data": "probe_video_codec" },
			            { "data": "total_output_streams" },
			            { "data": "visual_stream_status"}
			        ],
			        "order": [[3, 'asc']]
			    } );
			     
			    // Add event listener for opening and closing details
			    $('#example tbody').on('click', 'td.details-control', function () {
			        var tr = $(this).closest('tr');
			        var row = table.row( tr );
			 
			        if ( row.child.isShown() ) {
			            // This row is already open - close it
			            row.child.hide();
			            tr.removeClass('shown');
			        }
			        else {
			            // Open this row
			            row.child( format(row.data()) ).show();
			            tr.addClass('shown');
			        }
			    } );
			} );
		</script>

		<script src="assets/javascripts/add_stream.js"></script>
	<?php } ?>

	<?php if(get('c') == 'stream' || get('c') == 'transcoding_profile') { ?>
		<script>
			function set_dehash_status(selectObject) {
			    var dehash_status = selectObject.value; 

			    if(dehash_status == 'enable') {
				    $('#dehash_options').removeClass('hidden');
				}
				if(dehash_status == 'disable') {
				    $('#dehash_options').addClass('hidden');
				}
			}

			function set_fingerprint_status(selectObject) {
			    var fingerprint_status = selectObject.value; 

			    if(fingerprint_status == 'enable') {
				    $('#fingerprint_options').removeClass('hidden');
				}
				if(fingerprint_status == 'disable') {
				    $('#fingerprint_options').addClass('hidden');
				}
			}

			function set_fingerprint_type(selectObject) {
			    var fingerprint_type = selectObject.value; 

			    if(fingerprint_type == 'static_text') {
				    $('#fingerprint_options_static_text').removeClass('hidden');
				}else{
				    $('#fingerprint_options_static_text').addClass('hidden');
				}
			}
		</script>
	<?php } ?>

	<?php if(get('c') == 'cdn_streams') { ?>
		<script>
			function stream_start(stream_id, server_id) {
				var question = confirm("Please allow up to 60 seconds for the stream to start.");
				if( question == true ) {

					alert('actions.php?a=cdn_stream_start&stream_id=' + stream_id + '&server_id=' + server_id);

					$.ajax({
						cache: false,
						type: "GET",
				        url:'http://'.$global_settings['cms_access_url'].'/actions.php?a=cdn_stream_start&stream_id=' + stream_id + '&server_id=' + server_id,
						success: function(sources) {
							new PNotify({
								title: 'Success!',
								text: 'Streaming will start shortly.',
								type: 'success'
							});
						}
					});

					location.reload().delay( 2000 );
					return true;
				}
			}

			function stream_stop(stream_id, server_id) {
				var question = confirm("Please allow up to 60 seconds for the stream to stop.");
				if( question == true ) {
					$.ajax({
						cache: false,
						type: "GET",
				        url:'actions.php?a=cdn_stream_stop&stream_id=' + stream_id + '&server_id=' + server_id,
						success: function(sources) {
							new PNotify({
								title: 'Success!',
								text: 'Streaming will stop shortly.',
								type: 'success'
							});
						}
					});

					location.reload().delay( 2000 );
					return true;
				}
			}

			function cdn_streams_set_server(selectObject) {
			    var server_id = selectObject.value; 

			    window.location.href = "http://".$global_settings['cms_access_url']."/dashboard.php?c=cdn_streams&server_id=" + server_id;
			}

			// data tables > cdn_streams
		  	$(function () {
				$('#cdn_streams').DataTable({
					"order": [[ 2, "asc" ]],
					"columnDefs": [{
						"targets"  : 'no-sort',
						"orderable": false,
					}],
			  		"paging": true,
			  		"processing": true,
			  		"lengthChange": false,
			  		"searching": true,
			  		"ordering": true,
			  		"info": true,
			  		"autoWidth": false,
					"iDisplayLength": 100,
					search: {
					   search: '<?php if(isset($_GET['search'])) {echo $_GET['search'];} ?>'
					}
				});
		  	});
		</script>
	<?php } ?>

	<?php if(get('c') == 'current_connections') { ?>
		<script>
			// data tables > current_connections
		  	$(function () {
				$('#current_connections').DataTable({
					"order": [[ 1, "asc" ]],
					"columnDefs": [{
						"targets"  : 'no-sort',
						"orderable": false,
					}],
					"language": {
						"emptyTable": "There are currently no connections to your servers / streams."
					},
			  		"paging": true,
			  		"processing": true,
			  		"lengthChange": false,
			  		"searching": true,
			  		"ordering": true,
			  		"info": true,
			  		"autoWidth": false,
					"iDisplayLength": 100,
					search: {
					   search: '<?php if(isset($_GET['search'])) {echo $_GET['search'];} ?>'
					}
				});
		  	});
		</script>
	<?php } ?>

	<?php if(get('c') == 'transcoding_profiles') { ?>
		<script>
			// data tables > current_connections
		  	$(function () {
				$('#transcoding_profiles').DataTable({
					"order": [[ 0, "asc" ]],
					"columnDefs": [{
						"targets"  : 'no-sort',
						"orderable": false,
					}],
					"language": {
						"emptyTable": "No profiles found."
					},
			  		"paging": true,
			  		"processing": true,
			  		"lengthChange": false,
			  		"searching": true,
			  		"ordering": true,
			  		"info": true,
			  		"autoWidth": false,
					"iDisplayLength": 100,
					search: {
					   search: '<?php if(isset($_GET['search'])) {echo $_GET['search'];} ?>'
					}
				});
		  	});
		</script>
	<?php } ?>

	<?php if(get('c') == 'transcoding_profile') { ?>
		<script>
			// data tables > transcoding_profiles_streams
		  	$(function () {
				$('#transcoding_profiles_streams').DataTable({
					"order": [[ 0, "asc" ]],
					"columnDefs": [{
						"targets"  : 'no-sort',
						"orderable": false,
					}],
					"language": {
						"emptyTable": "No streams are using this profile."
					},
			  		"paging": true,
			  		"processing": true,
			  		"lengthChange": false,
			  		"searching": true,
			  		"ordering": true,
			  		"info": true,
			  		"autoWidth": false,
					"iDisplayLength": 100,
					search: {
					   search: '<?php if(isset($_GET['search'])) {echo $_GET['search'];} ?>'
					}
				});
		  	});

		  	$(function () {
				$('#transcoding_profiles_channels').DataTable({
					"order": [[ 0, "asc" ]],
					"columnDefs": [{
						"targets"  : 'no-sort',
						"orderable": false,
					}],
					"language": {
						"emptyTable": "No 247 tv channels are using this profile."
					},
			  		"paging": true,
			  		"processing": true,
			  		"lengthChange": false,
			  		"searching": true,
			  		"ordering": true,
			  		"info": true,
			  		"autoWidth": false,
					"iDisplayLength": 100,
					search: {
					   search: '<?php if(isset($_GET['search'])) {echo $_GET['search'];} ?>'
					}
				});
		  	});
		</script>
	<?php } ?>

	<?php if(get('c') == 'downloads') { ?>
		<script>
			// data tables > downloads
		  	$(function () {
				$('#downloads').DataTable({
					"order": [[ 0, "asc" ]],
					"columnDefs": [{
						"targets"  : 'no-sort',
						"orderable": false,
					}],
			  		"paging": true,
			  		"processing": true,
			  		"lengthChange": false,
			  		"searching": true,
			  		"ordering": true,
			  		"info": true,
			  		"autoWidth": false,
					"iDisplayLength": 100,
					search: {
					   search: '<?php if(isset($_GET['search'])) {echo $_GET['search'];} ?>'
					}
				});
		  	});
		</script>
	<?php } ?>

	<?php if(get('c') == 'security_rules') { ?>
		<script>
			// data tables > security_rules
		  	$(function () {
				$('#security_rules').DataTable({
					"order": [[ 0, "asc" ]],
					"columnDefs": [{
						"targets"  : 'no-sort',
						"orderable": false,
					}],
					"language": {
						"emptyTable": "You need to add your first security profile."
					},
			  		"paging": true,
			  		"processing": true,
			  		"lengthChange": false,
			  		"searching": true,
			  		"ordering": true,
			  		"info": true,
			  		"autoWidth": false,
					"iDisplayLength": 100,
					search: {
					   search: '<?php if(isset($_GET['search'])) {echo $_GET['search'];} ?>'
					}
				});
		  	});
		</script>
	<?php } ?>

	<?php if(get('c') == 'playlist_checker_results') { ?>
    	<script>
    		// data tables > premium_dns
		  	$(function () {
				$('#playlist_checker_results').DataTable({
					"order": [[ 2, "asc" ]],
					"columnDefs": [{
						"targets"  : 'no-sort',
						"orderable": false,
					}],
					"language": {
						"emptyTable": "No results were found for this playlist."
					},
			  		"paging": true,
			  		"processing": true,
			  		"lengthChange": false,
			  		"searching": true,
			  		"ordering": true,
			  		"info": true,
			  		"autoWidth": false,
					"iDisplayLength": 1000,
					search: {
					   search: '<?php if(isset($_GET['search'])) {echo $_GET['search'];} ?>'
					}
				});
		  	});

		  	<?php $url = base64_decode(get('url')); ?>

        	<?php $playlist = file_get_contents("http://slipstreamiptv.com/actions.php?a=inspect_m3u_encoded&url=".$_GET['url']); ?>
        	<?php $playlist = json_decode($playlist, true); ?>
        	<?php $playlist_checker_count = 1; ?>
        	<?php foreach($playlist as $playlist_item) { ?>
        		<?php $playlist_item['encoded_url'] = base64_encode($playlist_item['url']); ?>
        		// console.log("URL: <?php echo $playlist_item['url']; ?>");
        		// console.log("Encoded URL: <?php echo $playlist_item['encoded_url']; ?>");
        		// console.log();
        		$.ajax({
					cache: false,
					type: "GET",
			        url:"actions.php?a=ajax_stream_checker&url=<?php echo $playlist_item['encoded_url']; ?>",
					success: function(playlist) {
						console.log("Channel: <?php echo $playlist_item['title']; ?>");
						console.log(" - Channel Status: "+playlist.status);
						// console.log(" - Channel Probe Command: "+playlist.probe_command);
						if(playlist.status == 'online'){
							$('#playlist_status_id_'+<?php echo $playlist_checker_count; ?>).html('<span class="label label-success full-width" style="width: 100%;">Online</span>');
						}
						if(playlist.status == 'offline'){
							$('#playlist_status_id_'+<?php echo $playlist_checker_count; ?>).html('<span class="label label-danger full-width" style="width: 100%;">Offline</span>');
						}
					}
				});
				<?php $playlist_checker_count++; ?>
        	<?php } ?>
    	</script>
    <?php } ?>

	<?php if(get('c') == 'staging') { ?>
		<script>
			(function($) {
			  $(function() {
			   var ds = {
			     'name': 'Lao Lao',
			     'title': 'general manager',
			     'children': [
			       { 'name': 'Bo Miao', 'title': 'department manager' },
			       { 'name': 'Su Miao', 'title': 'department manager',
			         'children': [
			           { 'name': 'Tie Hua', 'title': 'senior engineer' },
			           { 'name': 'Hei Hei', 'title': 'senior engineer',
			             'children': [
			               { 'name': 'Pang Pang', 'title': 'engineer' },
			               { 'name': 'Xiang Xiang', 'title': 'UE engineer' }
			             ]
			            }
			          ]
			        },
			        { 'name': 'Hong Miao', 'title': 'department manager' },
			        { 'name': 'Chun Miao', 'title': 'department manager' }
			      ]
			    };

			    $('#chart-container').orgchart({
			      'data' : ds,
			      'nodeContent': 'title',
			      'draggable': true
			    });

			  });
			})(jQuery);
		</script>
	<?php } ?>

	<?php if(get('c') == 'stream_icons') { ?>
    	<script>
    		// data tables > customers
		  	$(function () {
				$('#stream_icons').DataTable({
					"order": [[ 0, "asc" ]],
					"columnDefs": [{
						"targets"  : 'no-sort',
						"orderable": false,
					}],
			  		"paging": true,
			  		"processing": true,
			  		"lengthChange": false,
			  		"searching": true,
			  		"ordering": true,
			  		"info": true,
			  		"autoWidth": false,
					"iDisplayLength": 100,
					search: {
					   search: '<?php if(isset($_GET['search'])) {echo $_GET['search'];} ?>'
					}
				});
		  	});
    	</script>
    <?php } ?>

    <?php if(get('c') == 'channels') { ?>
    	<script>
    		function channels_set_server(selectObject) {
			    var server_id = selectObject.value; 

			    window.location.href = "dashboard.php?c=channels&server_id=" + server_id;
			}

			$('#checkAll').change(function () {
			    $('.chk').prop('checked', this.checked);
			    $('#multi_options_show').removeClass("hidden");
			});

			$(".chk").change(function () {
			    if ($(".chk:checked").length == $(".chk").length) {
			        $('#checkAll').prop('checked', 'checked');
			    } else {
			        $('#checkAll').prop('checked', false);
			    }
			});

    		// data tables > channels
		  	$(function () {
				$('#channels').DataTable({
					"order": [[ 1, "asc" ]],
					"columnDefs": [{
						"targets"  : 'no-sort',
						"orderable": false,
					}],
					"language": {
						"emptyTable": "No channels found."
					},
			  		"paging": true,
			  		"processing": true,
			  		"lengthChange": false,
			  		"searching": true,
			  		"ordering": true,
			  		"info": true,
			  		"autoWidth": false,
					"iDisplayLength": 100,
					search: {
					   search: '<?php if(isset($_GET['search'])) {echo $_GET['search'];} ?>'
					}
				});
		  	});
    	</script>
    <?php } ?>

    <?php if(get('c') == 'tv_series') { ?>
    	<script>

    		// data tables > channels
		  	$(function () {
				$('#tv_series').DataTable({
					"order": [[ 0, "asc" ]],
					"columnDefs": [{
						"targets"  : 'no-sort',
						"orderable": false,
					}],
					"language": {
						"emptyTable": "No TV Series found."
					},
			  		"paging": true,
			  		"processing": true,
			  		"lengthChange": false,
			  		"searching": true,
			  		"ordering": true,
			  		"info": true,
			  		"autoWidth": false,
					"iDisplayLength": 100,
					search: {
					   search: '<?php if(isset($_GET['search'])) {echo $_GET['search'];} ?>'
					}
				});
		  	});
    	</script>
    <?php } ?>

    <?php if(get('c') == 'tv_series_edit' || get('c') == 'channel_edit') { ?>
    	<script>
    		// data tables > customers
		  	$(function () {
				$('#episodes').DataTable({
					"order": [[ 0, "desc" ], [ 1, "desc" ]],
					"columnDefs": [{
						"targets"  : 'no-sort',
						"orderable": false,
					}],
					"language": {
						"emptyTable": "No episodes found."
					},
			  		"paging": true,
			  		"processing": true,
			  		"lengthChange": false,
			  		"searching": true,
			  		"ordering": false,
			  		"info": true,
			  		"autoWidth": false,
					"iDisplayLength": 100,
					search: {
					   search: '<?php if(isset($_GET['search'])) {echo $_GET['search'];} ?>'
					}
				});
		  	});
    	</script>
    <?php } ?>

    <?php if(get('c') == 'vod') { ?>
    	<script>
    		// data tables > vod
		  	$(function () {
				$('#vod').DataTable({
					"order": [[ 0, "asc" ]],
					"columnDefs": [{
						"targets"  : 'no-sort',
						"orderable": false,
					}],
					"language": {
						"emptyTable": "No VoD found."
					},
			  		"paging": true,
			  		"processing": true,
			  		"lengthChange": false,
			  		"searching": true,
			  		"ordering": true,
			  		"info": true,
			  		"autoWidth": false,
					"iDisplayLength": 100,
					search: {
					   search: '<?php if(isset($_GET['search'])) {echo $_GET['search'];} ?>'
					}
				});
		  	});

		  	// data tables > vod
		  	$(function () {
				$('#vod_folders').DataTable({
					"order": [[ 0, "asc" ]],
					"columnDefs": [{
						"targets"  : 'no-sort',
						"orderable": false,
					}],
					"language": {
						"emptyTable": "No Data found."
					},
			  		"paging": true,
			  		"processing": true,
			  		"lengthChange": false,
			  		"searching": true,
			  		"ordering": true,
			  		"info": true,
			  		"autoWidth": false,
					"iDisplayLength": 100,
					search: {
					   search: '<?php if(isset($_GET['search'])) {echo $_GET['search'];} ?>'
					}
				});
		  	});

    		// data tables > tv_series
		  	$(function () {
				$('#tv_series').DataTable({
					"order": [[ 1, "asc" ]],
					"columnDefs": [{
						"targets"  : 'no-sort',
						"orderable": false,
					}],
			  		"paging": true,
			  		"processing": true,
			  		"lengthChange": false,
			  		"searching": true,
			  		"ordering": true,
			  		"info": true,
			  		"autoWidth": false,
					"iDisplayLength": 100,
					search: {
					   search: '<?php if(isset($_GET['search'])) {echo $_GET['search'];} ?>'
					}
				});
		  	});
    	</script>
    <?php } ?>

    <?php if(get('c') == 'release_notes') { ?>
		<script>
			// data tables > downloads
		  	$(function () {
				$('#release_notes').DataTable({
					"order": [[ 2, "desc" ]],
					"columnDefs": [{
						"targets"  : 'no-sort',
						"orderable": false,
					}],
			  		"paging": true,
			  		"processing": true,
			  		"lengthChange": false,
			  		"searching": true,
			  		"ordering": false,
			  		"info": false,
			  		"autoWidth": false,
					"iDisplayLength": 100,
					search: {
					   search: '<?php if(isset($_GET['search'])) {echo $_GET['search'];} ?>'
					}
				});
		  	});
		</script>
	<?php } ?>

    <?php include('inc/help_modals.php'); ?>

    <?php if($global_settings['cms_terms_accepted'] == 'no'){ ?>
		<script>
			$(window).on('load',function(){
		        $('#modal-terms').modal({backdrop: 'static', keyboard: false});
		    });
		</script>
	<?php } ?>

	<?php if($global_settings['lockdown'] == true){ ?>
		<script>
			$(window).on('load',function(){
		        $('#party').modal(
		        	{backdrop: 'static', keyboard: false});
		    });
		</script>
	<?php } ?>

	<script>
		$(function() {
	    //Initialize Select2 Elements
	    $('.select2').select2()

	    //Datemask dd/mm/yyyy
	    $('#datemask').inputmask('dd/mm/yyyy', {
            'placeholder': 'dd/mm/yyyy'
        })
	    
	    //Datemask2 mm/dd/yyyy
	    $('#datemask2').inputmask('mm/dd/yyyy', {
            'placeholder': 'mm/dd/yyyy'
        })
	    
	    //Money Euro
	    $('[data-mask]').inputmask()

	    //Date picker
	    $('#datepicker').datepicker({
	        autoclose: true
	    })
	})
	</script>
</body>
</html>