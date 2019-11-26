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
$account_details = account_details($_SESSION['account']['id']);

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
                		<li class="header">DEV NAVIGATION</li>
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

	                <?php if($account_details['type'] == 'admin') { ?>
                		<li class="header">ADMIN NAVIGATION</li>
	                    <?php if(get('c') == 'customers'){ ?>
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
								<!-- <li class="active"><a href="index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li> -->
								<?php if(get('c') == 'customers'){ ?>
			                    	<li class="active">
			                    <?php }else{ ?>
			                    	<li>
			                    <?php } ?>
			                    	<a href="dashboard.php?c=customers">
			                        	<i class="fa fa-circle"></i> 
			                        	<span>Customers</span>
			                        </a>
			                    </li>
							</ul>
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
		                    	<a href="dashboard.php?c=billing">
		                        	<i class="fa fa-circle"></i> 
		                        	<span>Billing</span>
		                        </a>
		                    </li>
		                    <li>
		                    	<a href="dashboard.php?c=support">
		                        	<i class="fa fa-circle"></i> 
		                        	<span>Support Tickets</span>
		                        </a>
		                    </li>
		                    <li>
		                    	<a href="dashboard.php?c=knowledgebase">
		                        	<i class="fa fa-circle"></i> 
		                        	<span>Knowledgebase</span>
		                        </a>
		                    </li>
		                </ul>
		            </li>

                    <?php if(get('c') == 'my_network'){ ?>
                    	<li class="active treeview menu-open">
                    <?php }else{ ?>
                    	<li class="treeview">
                    <?php } ?>
						<a href="#">
							<i class="fa fa-network-wired"></i> <span>Business Manager</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<!-- <li class="active"><a href="index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li> -->
							<?php if(get('c') == 'downline'){ ?>
		                    	<li class="active">
		                    <?php }else{ ?>
		                    	<li>
		                    <?php } ?>
		                    	<a href="dashboard.php?c=downline">
		                        	<i class="fa fa-circle"></i> 
		                        	<span>My Downline</span>
		                        </a>
		                    </li>
						</ul>
					</li>

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
				// staging
				case "staging":
					if($_SERVER['REMOTE_ADDR'] == '86.4.171.7'){
						staging();
					}else{
						home();
					}
					break;


				// staff
				case "customers":
					if($account_details['type'] == 'admin'){
						customers();
					}else{
						home();
					}
					break;


				// my_account
				case "my_account":
					my_account();
					break;

				// business manager
				case "downline":
					downline();
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
					<div class="callout callout-warning">
						Content will go here
					</div>
				</section>
            </div>
        <?php } ?>
        
        <?php function my_account(){ ?>
        	<?php 
        		global $conn, $globals, $global_settings, $account_details, $site;
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
        		global $conn, $globals, $global_settings, $account_details, $site;       
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
        		global $conn, $globals, $global_settings, $account_details, $site;
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
														</select>
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
									                <th style="white-space: nowrap;" width="100px">Name</th>
									                <th class="no-sort" style="white-space: nowrap;" width="1px">Downline</th>
									                <th class="no-sort" style="white-space: nowrap;" width="100px">Upline</th>
									                <th class="no-sort" style="white-space: nowrap;" width="100px">Expires</th>
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
									                <th style="white-space: nowrap;" width="100px">Name</th>
									                <th class="no-sort" style="white-space: nowrap;" width="1px">Downline</th>
									                <th class="no-sort" style="white-space: nowrap;" width="100px">Upline</th>
									                <th class="no-sort" style="white-space: nowrap;" width="100px">Expires</th>
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

        <?php function downline(){ ?>
        	<?php 
        		global $conn, $globals, $global_settings, $account_details, $site;

        		// get customers
				$query 				= $conn->query("SELECT `id`,`status`,`avatar`,`first_name`,`last_name`,`email`,`tel`,`expire_date`,`internal_notes`,`upline_id`,`total_downline` FROM `users` ");
				$customers 			= $query->fetchAll(PDO::FETCH_ASSOC);
			?>

			<link href="css/reset-html5.css" rel="stylesheet" media="screen" />
			<link href="css/micro-clearfix.css" rel="stylesheet" media="screen" />
			<link href="css/stiff-chart.css" rel="stylesheet" media="screen" />
			<link href="css/custom.css" rel="stylesheet" media="screen" />

            <div class="content-wrapper">
				
                <div id="status_message"></div>   
                            	
                <section class="content-header">
                    <h1>Downline <!-- <small>Optional description</small> --></h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="dashboard.php">Dashboard</a></li>
                        <li class="active">Downline</li>
                    </ol>
                </section>

                <!-- Main content -->
				<section class="content">
					<div class="row">
						<div class="col-md-12">
							<div class="chart-container">
							    <div id="your-chart-name">
							        <div class="stiff-chart-inner">

							            <!-- downline level 1 -->
							            <div class="stiff-chart-level" data-level="01">
							                <div class="stiff-main-parent">
							                    <ul>
							                    	<?php 
							                    		foreach($customers as $customer){
							                    			if($customer['upline_id'] == $_SESSION['account']['id']){
							                    				echo '
								                    				<li data-parent="1_'.$customer['id'].'">
											                            <div class="the-chart">
											                                <img src="'.$customer['avatar'].'" width="100px" height="100px" alt="">
											                                <p>
											                                	<strong>Level 1</strong><br>
											                                	'.stripslashes($customer['first_name']).' '.stripslashes($customer['last_name']).' <br>
											                                	'.stripslashes($customer['email']).'
											                                </p>
											                            </div>
											                        </li>
							                    				';
							                    				$downline[1][] = $customer['id'];
							                    			}
							                    		}
							                    	?>
							                    </ul>
							                </div>
							            </div>

							            <!-- downline level 2 -->
							            <div class="stiff-chart-level" data-level="02">
							            	<?php foreach($downline[1] as $level_1){ ?>
								                <div class="stiff-child" data-child-from="1_<?php echo $level_1; ?>">
								                	<ul>
									                    <?php 
								                    		foreach($customers as $customer){
								                    			if($customer['upline_id'] == $level_1){
								                    				echo '
												                        <li data-parent="2_'.$customer['id'].'">
												                            <div class="the-chart">
												                                <img src="'.$customer['avatar'].'" width="100px" height="100px" alt="">
												                                <p>
												                                	<strong>Level 2</strong><br>
												                                	'.stripslashes($customer['first_name']).' '.stripslashes($customer['last_name']).' <br>
												                                	'.stripslashes($customer['email']).'
												                                </p>
												                            </div>
												                        </li>
								                    				';
								                    			}
								                    		}
								                    	?>
								                    </ul>
								                </div>
								            <?php } ?>
							            </div>

							            <div class="stiff-chart-level" data-level="02">
							                <div class="stiff-child" data-child-from="1_2">
							                    <ul>
							                        <li data-parent="b01">
							                            <div class="the-chart">
							                                <img src="https://placeimg.com/100/100/animals" alt="">
							                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing.</p>
							                            </div>
							                        </li>
							                        <li data-parent="b02">
							                            <div class="the-chart">
							                                <img src="https://placeimg.com/100/100/animals" alt="">
							                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing.</p>
							                            </div>
							                        </li>
							                        <li data-parent="b03">
							                            <div class="the-chart">
							                                <img src="https://placeimg.com/100/100/animals" alt="">
							                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing.</p>
							                            </div>
							                        </li>
							                        <li data-parent="b04">
							                            <div class="the-chart">
							                                <img src="https://placeimg.com/100/100/animals" alt="">
							                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing.</p>
							                            </div>
							                        </li>
							                        <li data-parent="b05">
							                            <div class="the-chart">
							                                <img src="https://placeimg.com/100/100/animals" alt="">
							                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing.</p>
							                            </div>
							                        </li>
							                        <li data-parent="b06">
							                            <div class="the-chart">
							                                <img src="https://placeimg.com/100/100/animals" alt="">
							                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing.</p>
							                            </div>
							                        </li>
							                        <li data-parent="b07">
							                            <div class="the-chart">
							                                <img src="https://placeimg.com/100/100/animals" alt="">
							                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing.</p>
							                            </div>
							                        </li>

							                    </ul>
							                </div>
							            </div>

							            <div class="stiff-chart-level" data-level="02">
							                <div class="stiff-child" data-child-from="c">
							                    <ul>

							                        <li data-parent="c01">
							                            <div class="the-chart">
							                                <img src="https://placeimg.com/100/100/animals" alt="">
							                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing.</p>
							                            </div>
							                        </li>

							                    </ul>
							                </div>
							            </div>

							            <div class="stiff-chart-level" data-level="03">
							                <div class="stiff-child" data-child-from="c07">
							                    <ul>

							                        <li data-parent="c0701">
							                            <div class="the-chart">
							                                <img src="https://placeimg.com/100/100/animals" alt="">
							                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing.</p>
							                            </div>
							                        </li>
							                        <li data-parent="c0702">
							                            <div class="the-chart">
							                                <img src="https://placeimg.com/100/100/animals" alt="">
							                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing.</p>
							                            </div>
							                        </li>
							                        <li data-parent="c0703">
							                            <div class="the-chart">
							                                <img src="https://placeimg.com/100/100/animals" alt="">
							                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing.</p>
							                            </div>
							                        </li>
							                        <li data-parent="c0704">
							                            <div class="the-chart">
							                                <img src="https://placeimg.com/100/100/animals" alt="">
							                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing.</p>
							                            </div>
							                        </li>
							                        <li data-parent="c0705">
							                            <div class="the-chart">
							                                <img src="https://placeimg.com/100/100/animals" alt="">
							                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing.</p>
							                            </div>
							                        </li>
							                        <li data-parent="c0706">
							                            <div class="the-chart">
							                                <img src="https://placeimg.com/100/100/animals" alt="">
							                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing.</p>
							                            </div>
							                        </li>
							                        <li data-parent="c0707">
							                            <div class="the-chart">
							                                <img src="https://placeimg.com/100/100/animals" alt="">
							                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing.</p>
							                            </div>
							                        </li>

							                    </ul>
							                </div>
							            </div>

							            <div class="stiff-chart-level" data-level="03">
							                <div class="stiff-child" data-child-from="b01">
							                    <ul>

							                        <li data-parent="b0101">
							                            <div class="the-chart">
							                                <img src="https://placeimg.com/100/100/animals" alt="">
							                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing.</p>
							                            </div>
							                        </li>

							                    </ul>
							                </div>
							            </div>

							        </div>
							    </div>
							</div>
						</div>
					</div>
				</section>
            </div>

            <script src="js/stiffChart.js"></script>
			<script>
				$(document).ready(function() {
				  $('#your-chart-name').stiffChart({
				    
				  });
				});
			</script>
        <?php } ?>

        <?php function staging(){ ?>
        	<?php 
        		global $conn, $global_settings, $account_details, $site;
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
            <strong>Copyright &copy; <?php echo date("Y", time()); ?> <a href="https://www.ubloclub.co.uk">UBlo Club</a>.</strong> All rights reserved.
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
			    return '<table cellpadding="1" cellspacing="0" border="0" width="100%">'+
			        '<tr>'+
			            '<td width="150px" valign="top">Contact Details</td>'+
			            '<td valign="top">'+
			            	'<strong>Email:</strong> '+d.email+' <br>'+
			            	'<strong>Tel:</strong> '+d.tel+' <br>'+
			            '</td>'+
			        '</tr>'+
			        '<tr>'+
			            '<td width="150px" valign="top">Internal Notes</td>'+
			            '<td valign="top">'+d.internal_notes+'</td>'+
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
			        "ajax": "actions.php?a=ajax_customers",
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
			            { "data": "full_name" },
			            { "data": "total_downline" },
			            { "data": "upline" },
			            { "data": "expire_date" },
			            { "data": "actions" }
			        ],
			        "order": [[4, 'asc']]
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