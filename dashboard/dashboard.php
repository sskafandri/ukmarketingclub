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
	go($site['url'].'?c=login');
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

	<!-- Favicon -->
	<link rel="apple-touch-icon" sizes="57x57" href="../assets/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="../assets/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="../assets/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="../assets/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="../assets/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="../assets/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="../assets/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="../assets/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="../assets/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="../assets/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="../assets/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="../assets/favicon-16x16.png">
	<link rel="manifest" href="../assets/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="../assets/ms-icon-144x144.png">
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
		td.details-control {
		    background: url('img/details_open.png') no-repeat center center;
		    cursor: pointer;
		}
		tr.shown td.details-control {
		    background: url('img/details_close.png') no-repeat center center;
		}

		#vcenter {
			display: inline-block;
			vertical-align: middle;
			float: none;
		}

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

		/* FACEBOOK */
		.btn_shareFB{
			font-family: helvetica,arial,sans-serif;
			background: rgba(0, 0, 0, 0) linear-gradient(#4c69ba, #3b55a0) repeat scroll 0 0;
			border: medium none;
			border-radius: 2px;
			color: #fff;
			cursor: pointer;
			font-weight: bold;
			height: 22px;
			line-height: 22px;
			padding: 0;
			text-shadow: 0 -1px 0 #354c8c;
			white-space: nowrap;
		}

		.btn_shareFB span{
			padding: 0 5px 0 0;
			position: relative;
			vertical-align: top;
		}

		.btn_shareFB i{
			background-image: url("https://fbstatic-a.akamaihd.net/rsrc.php/v2/y5/r/KxVPs0eEy36.png");
			background-position: 0 -42px;
			background-repeat: no-repeat;
			background-size: 30px 72px;
			display: inline-block;
			height: 14px;
			width: 14px;
			left: 0;
			margin: 0 4px;
			position: relative;
			top: 3px;
			vertical-align: top;
		}

		.btn_shareFB:hover{
			background: rgba(0,0,0,0) linear-gradient(#5b7bd5, #4864b1) repeat scroll 0 0;
			border-color: #5874c3 #4961a8 #41599f;
			box-shadow: 0 0 1px #607fd6 inset;
		}

		/* TWITTER */
		.btn_shareTWI{
			background-color: #eee;
			background-image: linear-gradient(#fff, #dedede);
			border: 1px solid #ccc;
			border-radius: 3px;
			color: #333;
			cursor: pointer;
			font-weight: bold;
			width: 65px;
			height: 22px;
			padding: 0;
			position: relative;
			text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);
			display: inline-block;
			vertical-align: top;
		}

		.btn_shareTWI i{
		background-image: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFoAAABQCAYAAACZM2JkAAANzElEQVR42u1cW0wbVxo+6q72ZVkp2pVWbV/KQ5SX7gPavKyq1Za8pauVWlV5W6nK63YViUqVyjU4QEgaIA4kIdeNIVzM3RBIQiHgBCeljekaEgEFmpiEgBNMcDChTuJoz/7fmZnWNraZMbZxwUi/8GVmPOc73/n+y5lzGOecRctYpjGVZdbtJdNJZkyP5vU3ypjOsI1l1WeQmcjMwjKNBvr/UTgs/N77XSy7Li3iG8EPZzdyltfK2X4T/W/jLKeZs6wGl+8N4TXLpBuN8Lc03Rd+i+5tXdfIJuLkNLrYfmrPgQ7OCjol07VTG1s4y26wKW35uUOM9kCS+VzQqCNQbFpvTFw8p4nOo5s43MfZ0VuclX/L2bFvOCu9wVnRVQl0XBugoyPyTea4MBEAZTcYIgeZMMkn0hzqoTYNcnbKxtmZO5KdHOKsbIDadwWAu0T7chq5OL7gEtr3ZlCgf13QMcAKujjLbbFpYRvLbjKx4q84O0E/bJjirOYhZ3WzZI84uzjN2dkxzvRfc3FMcQ//3fGvJ7vuLdS+U95XETi8ojvcTemsuJuzQmoT7lErgXKN6QQYEYbu/T/fU3tmOGtwcNb0RDK8rpmWQAeh0L4v+/jvzwzZHSve1r8brZ/R76atZnSZhbPjVomVuS2ucPrjp8kEHjt9RwK3eYGzlkV/a5ynG3pANzsh2YVJ6pTviAndGTFlc9GVDFb5X4l5B2lUYdRpIRCxklXQyLxoJ2CpDa2Lq63lKbXvMWfV96ld1LaqH/iOtgfL7CS172C3LSij/1A1uiTYeHaUsyNmSWezGkzhWEc3kyFAq58jkJ+uBlkxfIdOaHIKxr9dNYrhvDdweEXT/lwzVCIAABNPDUvDXwzx+gwVo2GbYGn1Pbr/heAg+wG+IBk6hDrmjcqhka/nlnbTtbavAnrX5RmnAKLhscQ6DHdICRwaHF2QCOKPFZZSZvghOJNDAF72/fNxOhcatieWjN4/OJMvQAYARiLCOSJQ6XXJiWU32OHkQgJd2JnOTo9IbF0LZF9rdvJ3Lz+Zm/e8ttB1zgVldOM9d58AWhnu0NfKYYndBy7JEYTwpgbhWXOb09+9OGxmtTPqQIbR9WWQ/x0HZ7gnpfGR12+Iw4dADqDdiCIAeFa9PlBS3qm8+YE4FudpAZo6VW4fQE4JCvRD98uSDwcWHT+zD0wgwa+i4VNJ3rZ0ALrDRXSBKAIhDjQdsqEWaHKQ9Lc7TvFv2r7bT+2BjBMsPzcmOTk4MDA896cw1EyRg/7tU7c6hKPTAjKMHCT96QNB9gP6V2UW94f9jx0ppqde/+EuAw6Gn/9eAh2hG0I4vIfUqAWaOi1uScahq6lPPK+7d3QvLq9yYNDS2odSNHHCKkkKWA7yFF2WQjl8rxHolPoH3pD3o7x4o+T6SFjg4NAgLQAdoRskA6/V6jPZjtYHy/HL5ky631RaV3b1OZ1BJQCfgeHQb7AXUcOZu1KsjA5A+KYR6J2XHrrWBPpf16cnhEwI8J6qZ6lao2t+eG3WES+g/2K4+bFgJiIHAKomclDiY+i5mmgj4Px/9Dx6uCbQcyuvqt9qf+LRwlBNRg62/O7TnjjWKPb+1jD+SkhAqDg4mkad9OmtuetrAo0bs8y/tKaYFr2xADql+TH064s4Ap2279sFuwBZKzsjMRoJFsfzw2qAhqc0zr94bfnE+nwmpd0VVcD33V600/X/GufKW+fOay5XzEEm29H5eDlcbhD4wfa/dU47RDqtxNTRYHPbghcRwAaUOJGUmEGcmAJNjrVs9Nl4uEx31Qd/qrG9J4L1xidRc4p5w+4pudEbUU/Wl40vj5dNesZTOlzeWACd0jbvhY8LGwUF+bCwbHRpPFqM3tnrQsjTGSyIj5el1o5OstoHMXOKecNLU2slYsE+RCHEbHG+su7sW3KtB+S3Op955Lx/z0bOkJQOzX4q4mSEblrT6rW0mRIiNUQK9cVuOWcnwL3WHd1Ly5p1maIXRDFySrrR01F6aZRGl9Ep7Wijx6qGSCG/yBuwv//Paw8HU+oeeEW2qEGv0TFjS95BRDEbKRmBo7R99qVtx1dLy9ECumzix/HAKl1IoKX5PmUyleyLer2YlkE9+ss+SklHpHRbZSLzye3nMwgR5eG0PYEmWf1G6XojERlk1W1U6gJpmMcT812ozmEe7Ei/VJ1DBKKC0dBzMManTPhmAs5ooxx6Ls+2OJXS8tgbaSIjg2zWUolUEhWEXnu/mn72+fttE/3v1E8uiLoHSqBhoo+3up55wAwwRGGLXGtOSTSQMXHB8pr17GC3i5V/IxEItQ0tmkzh4YVpz12tIPtq9HbZaSlgmTH822df2fJGf5zaZ1uxK4Z4FJ/Pv/ifxfd4+fy0hAAVjwgoz19k1btYllGqOaP2fLhXmkdExU5NsUm2XQNupyyJ5khq6oEfvCkz8lwAiKHMKB+/PeEYrDOlsqIug5iYxXwhHg0AwJggrn+kGmQA7COJnZGWEX7xTxGFcXwYYXqk/kiPd/U+cQpdVgEw/A1G8pj79aAPqQrXI4mbFWhldH4ROAoBXvvcK9uF6Zd39w2THA7LckifWRb8fI0vwOuWxM0MtG9VcrcMWKdKSdTLSUjUIqetAHRi+IwkCEmgk0AnLQl0Eugk0EkQkkAngU5aEugk0Emgo3exzMzM1Ozs7L1kOhi9T0+CHAC0TqfbRuBEVKWSzzXk5uby/fv3c3rP8/PzeV5eHqfPXVlZWT8tPMJrMnOkv/WLB5pA0uXk5NgAmlaQ6VxbQUEBP3LkCD927Bg/fvw4r6io4GVlZby4uFiAjmuTueSOMG9ZRhcWFg4UFRWBkTYtbCPWmg4dOsRPnjzJq6qqeF1dHTcajby+vp7X1tby8+fP8/Lyco5jDh8+jOMm79+/X0udUQGp2XJA6/V6ARZYSWD7DfcwbE4FeGfPnhXgtra28ra2Nj9rbm4WgBsMBmHojMrKSjA9Y0sy+uLFi0tgIxhYWloqdJaYbQrHOpKLDIDW0NAQFGTF8B2spaVFMJ6Aj/k6w4QF+urVq04A0dTUJFiH4Q4pkR2aIVgEceLEidLq6uqwIAcCPjExEZd1hgkLtN1u7wPQvsP99OnTgt1wdDLgdgLcQLKSQYxPp2PM0GI1IMNw/TiuM0xMoN1ud8nNmzcdvuxrbGzkJCn81KlT/OjRoyKCAOiIIsh5Ck2HbKgFGp0Sx3WGCesM3Waz2dHR0eENHO4AHAy/cOGCAB2hG0I4vIfUqAUanbblExZi7Eg44BRnBtDBTBheq9VnmMlkWv4lgoRcAXJJZkKyBZMl9KNwWXJQoG/cuDEBxmkFT63hmn19fY54AgQgtCZggYaSAiVkLsglZBOSCTtw4IDIgpGIKXmH0iHwZXRO8B1oVlZWqkk2PLEAWXGwo6Oj8VxniGzXRUAY1nG+DmEucgVEYZBN5Aww+Cf4rYMHD4q8g8C1oQSB46lDQu9Ag7h2fn7eGqjRUWR0XNcZIiqC80aISgCYtDIbjASDATAkVZFKEAam+C2AjlIDMl8ke/TeTqRtpe8/882wV60zfPHihWVoaGjm0qVLUQWcrhnXdYbIPMFAMA+Aox6jpbQAVsLh19TUCGBDySF8GiQXWS9yCvghOfO1hV1n2NXV5UA6rcTU0bD29navx+OJ6zpDAqgEAICJyAcw/DHESUoy1Dg/sBTnq5FSJfNFh6BjCOiRubm54DvQ+Nzge8gMcVK09PrOnTtxX2c4ODiYD5DRBsT6KC0APDgxAtsOJxfqXHJ26WfOnNEUuioJ2eXLl+eIVKF3oPFdZ0hOazxajKZIY6PWGe4hoLy+QxwEghz4lG7tFCXoAyWFGPkBjtVKNBy/5g40gSuYnE6ntb+/37UekKl3PdD8DaprpMEvBDIOLPct3YLhPhMUZnqtJzZ3wNFpbS8c5Jo70IRawbSwsGDt6elZ1vqjiF7QWRu1zpBATIVfoL/lQNZBFlFFRDQBZ6lMUCA+RpSCTsD3WttMvm3tHWgCbWBg4P1r164N4mQMOy3DCB2ztLS0oesMiak6koAVki5nsHtXMl3ot1IvR6iGSAUdAHZqBbqzszP0DjTyfJ9OMWiWPKXFS0pKOJyC4lTU/JjVap2R5WJD1xkScB+DmYgc1PgbhekAWCuxlPN7e3vD70BDoKZhHk/OakS2A5CV6Sk1Pww9p5AmkdYZ7qV7fwUJCBUHRzvzvXXr1nVV6wynp6c/J23tJ7lYABMwrMKx4cqVKx4kN9DxBFxnmHb79m17NMPUtRyhw+FYcweaVesMMfzB0LGxsamRkRG7YlNTU+P4XJaHhFxn6LsDDcLLWIMs67OmHWg2zTpD3x1o4DdiCTJGDHIPTTvQbELTj9Pf5OTkeLTrNz51di+qn1v+2TsK3yYRwsXKKcolht1bHmhy2J8iTo7FpAYSovXsQLPp5AMaGm1GI/tFDX9dO9BsMhP1m9nZWVsk5YRQJj+jom4Hmi00E+1Xv0H8HwWQte1As4VM7EAzPDw8ham1SPUaEUwkO9BsCcMcYH5+vr64uNiF51KUyQ0tACM8pOx5XTvQbCrD7Iny/AUZZqhFzRm1Z/nRYVGx0zK5YbFYnD7Z8Lp3oNk0hkeKi4qKDKgzA1w8GgCAlRlttSADYJ9iWXIHmlA70KD4j9Cut7cXdWmvGoBRiUSNx+12J3egiXQHGoAHhkJrAwtlAVXI5A40yR1okhbS/g/H5BFic8lpAQAAAABJRU5ErkJggg==");
			background-size: 45px 40px;
			margin-top: -6px;
			height: 13px;
			left: 2px;
			position: absolute;
			top: 50%;
			width: 16px;
		}

		.btn_shareTWI span{
			padding: 0 3px 0 19px;
			white-space: nowrap;
			display: inline-block;
			vertical-align: top;
		}

		.btn_shareTWI:hover,
		.btn_shareTWI:focus{
			background-color: #d9d9d9;
			background-image: linear-gradient(#f8f8f8, #d9d9d9);
			border-color: #bbb;
			box-shadow: none;
		}
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
						<!--
							<li>
								<a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
							</li>
						-->
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

	                <?php if($account_details['type'] == 'admin' || $account_details['type'] == 'dev') { ?>
                		<li class="header">STAFF PANEL</li>
	                    <?php if(get('c') == 'members' || get('c') == 'member' || get('c') == 'products' || get('c') == 'product' || get('c') == 'all_commissions' || get('c') == 'all_withdrawal_requests'){ ?>
	                    	<li class="active treeview menu-open">
	                    <?php }else{ ?>
	                    	<li class="treeview">
	                    <?php } ?>
							<a href="#">
								<i class="fa fa-users"></i> <span>Member Management</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">
								<!-- <li class="active"><a href="index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li> -->
								<?php if(get('c') == 'members'){ ?>
			                    	<li class="active">
			                    <?php }else{ ?>
			                    	<li>
			                    <?php } ?>
			                    	<a href="dashboard.php?c=members">
			                        	<i class="fa fa-circle"></i> 
			                        	<span>View All Members</span>
			                        </a>
			                    </li>

			                    <?php if(get('c') == 'products'){ ?>
			                    	<li class="active">
			                    <?php }else{ ?>
			                    	<li>
			                    <?php } ?>
			                    	<a href="dashboard.php?c=products">
			                        	<i class="fa fa-circle"></i> 
			                        	<span>View All Products</span>
			                        </a>
			                    </li>

			                    <?php if(get('c') == 'all_commissions'){ ?>
			                    	<li class="active">
			                    <?php }else{ ?>
			                    	<li>
			                    <?php } ?>
			                    	<a href="dashboard.php?c=all_commissions">
			                        	<i class="fa fa-circle"></i> 
			                        	<span>View All Commissions</span>
			                        </a>
			                    </li>

			                    <?php if(get('c') == 'all_withdrawal_requests'){ ?>
			                    	<li class="active">
			                    <?php }else{ ?>
			                    	<li>
			                    <?php } ?>
			                    	<a href="dashboard.php?c=all_withdrawal_requests">
			                        	<i class="fa fa-circle"></i> 
			                        	<span>View Withdrawal Requests</span>
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

                    <?php if(get('c') == 'visual_downline' || get('c') == 'table_downline' || get('c') == 'my_commissions' || get('c') == 'my_withdrawals' || get('c') == 'marketing_tools'){ ?>
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
							<?php if(get('c') == 'marketing_tools'){ ?>
		                    	<li class="active">
		                    <?php }else{ ?>
		                    	<li>
		                    <?php } ?>
		                    	<a href="dashboard.php?c=marketing_tools">
		                        	<i class="fa fa-circle"></i> 
		                        	<span>Marketing Tools</span>
		                        </a>
		                    </li>

							<?php if(get('c') == 'my_commissions'){ ?>
		                    	<li class="active">
		                    <?php }else{ ?>
		                    	<li>
		                    <?php } ?>
		                    	<a href="dashboard.php?c=my_commissions">
		                        	<i class="fa fa-circle"></i> 
		                        	<span>Commissions</span>
		                        </a>
		                    </li>

		                    <?php if(get('c') == 'my_withdrawals'){ ?>
		                    	<li class="active">
		                    <?php }else{ ?>
		                    	<li>
		                    <?php } ?>
		                    	<a href="dashboard.php?c=my_withdrawals">
		                        	<i class="fa fa-circle"></i> 
		                        	<span>Withdrawals</span>
		                        </a>
		                    </li>

		                    <?php if(get('c') == 'visual_downline'){ ?>
		                    	<li class="active">
		                    <?php }else{ ?>
		                    	<li>
		                    <?php } ?>
		                    	<a href="dashboard.php?c=visual_downline">
		                        	<i class="fa fa-circle"></i> 
		                        	<span>Visual Genealogy</span>
		                        </a>
		                    </li>

		                    <?php if(get('c') == 'table_downline'){ ?>
		                    	<li class="active">
		                    <?php }else{ ?>
		                    	<li>
		                    <?php } ?>
		                    	<a href="dashboard.php?c=table_downline">
		                        	<i class="fa fa-circle"></i> 
		                        	<span>Table Genealogy</span>
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
					staging();
					break;


				// staff
				case "members":
					if($account_details['type'] == 'admin' || $account_details['type'] == 'staff' || $account_details['type'] == 'dev'){
						members();
					}else{
						home();
					}
					break;

				case "member":
					if($account_details['type'] == 'admin' || $account_details['type'] == 'staff' || $account_details['type'] == 'dev'){
						member();
					}else{
						home();
					}
					break;

				case "products":
					if($account_details['type'] == 'admin' || $account_details['type'] == 'staff' || $account_details['type'] == 'dev'){
						products();
					}else{
						home();
					}
					break;

				case "all_commissions":
					if($account_details['type'] == 'admin' || $account_details['type'] == 'staff' || $account_details['type'] == 'dev'){
						all_commissions();
					}else{
						home();
					}
					break;

				case "all_withdrawal_requests":
					if($account_details['type'] == 'admin' || $account_details['type'] == 'staff' || $account_details['type'] == 'dev'){
						all_withdrawal_requests();
					}else{
						home();
					}
					break;


				// my_account
				case "my_account":
					my_account();
					break;

				// business manager
				case "marketing_tools":
					marketing_tools();
					break;

				case "my_commissions":
					my_commissions();
					break;

				case "visual_downline":
					visual_downline();
					break;

				case "table_downline":
					table_downline();
					break;

				case "my_withdrawals":
					my_withdrawals();
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

        		$commissions = get_commissions();
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
					<div class="row">
						<div class="col-lg-12 col-xs-12">
							<div class="box box-primary no-padding">
								<div class="box-header with-border">
									<h3 class="box-title">
										Commissions
									</h3> 
								</div>
								<div class="box-body">
					                <div class="row">
										<div class="col-lg-2 col-xs-6">
											<div class="small-box bg-primary">
												<div class="inner">
													<h3>£<?php echo $commissions['commissions']['total']; ?></h3>
													<p>Total</p>
												</div>
												<div class="icon">
													<i class="fa fa-gbp"></i>
												</div>
												<a href="?c=my_commissions" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
											</div>
										</div>

										<div class="col-lg-2 col-xs-6">
											<div class="small-box bg-yellow">
												<div class="inner">
													<h3>£<?php echo $commissions['commissions']['pending']; ?></h3>
													<p>Pending</p>
												</div>
												<div class="icon">
													<i class="fa fa-gbp"></i>
												</div>
												<a href="?c=my_commissions&search=pending" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
											</div>
										</div>

										<div class="col-lg-2 col-xs-6">
											<div class="small-box bg-maroon">
												<div class="inner">
													<h3>£<?php echo $commissions['commissions']['approved']; ?></h3>
													<p>Approved</p>
												</div>
												<div class="icon">
													<i class="fa fa-gbp"></i>
												</div>
												<a href="?c=my_commissions&search=approved" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
											</div>
										</div>

										<div class="col-lg-2 col-xs-6">
											<div class="small-box bg-red">
												<div class="inner">
													<h3>£<?php echo $commissions['commissions']['missed']; ?></h3>
													<p>Missed</p>
												</div>
												<div class="icon">
													<i class="fa fa-gbp"></i>
												</div>
												<a href="?c=my_commissions&search=missed" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
											</div>
										</div>

										<div class="col-lg-2 col-xs-6">
											<div class="small-box bg-red">
												<div class="inner">
													<h3>£<?php echo $commissions['commissions']['rejected']; ?></h3>
													<p>Rejected</p>
												</div>
												<div class="icon">
													<i class="fa fa-gbp"></i>
												</div>
												<a href="?c=my_commissions&search=rejected" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
											</div>
										</div>

										<div class="col-lg-2 col-xs-6">
											<div class="small-box bg-green">
												<div class="inner">
													<h3>£<?php echo $commissions['commissions']['paid']; ?></h3>
													<p>Paid</p>
												</div>
												<div class="icon">
													<i class="fa fa-gbp"></i>
												</div>
												<a href="?c=my_commissions&search=paid" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
											</div>
										</div>
				          			</div>
								</div>
							</div>
						</div>
					</div>
				</section>
            </div>
        <?php } ?>
        
        <?php function my_account(){ ?>
        	<?php 
        		global $conn, $globals, $global_settings, $account_details, $site;

        		$query 					= $conn->query("SELECT * FROM `bank_details` WHERE `sort_code` = '".$account_details['bank_sort_code']."' ");
				$bank_details 			= $query->fetch(PDO::FETCH_ASSOC);
				if(isset($bank_details['id'])){
					$account_details['bank_name'] 			= $bank_details['name'].', '.$bank_details['branch'];
				}

				$orders = get_whmcs_orders($_SESSION['account']['id']);

				$product_points = products_to_points();
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
                		<form action="actions.php?a=my_account_update" method="post" class="form-horizontal">
							<div class="col-lg-4">
								<!--
								<div class="box box-primary">
			            			<div class="box-header">
			              				<h3 class="box-title">
			              					Login Details
			              				</h3>
			            			</div>
									<div class="box-body">
	                                    <div class="form-group">
	                                        <label for="email" class="col-sm-3 control-label">Username</label>
	                                        <div class="col-sm-9">
	                                            <input type="text" name="username" id="username" class="form-control" value="<?php echo $account_details['username']; ?>">
	                                            <small>Please note: You login using this username, if you change it please make sure to use the updated username the time you login.</small>
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
		                            </div>
		                            <div class="box-footer">
		                            	<div class="col-sm-12">
	                                        <button type="submit" class="btn btn-success pull-right">Save Changes</button>
	                                    </div>
		                            </div>
		                        </div>
		                    	-->

		                    	<!--
		                        <div class="box box-primary">
			            			<div class="box-header">
			              				<h3 class="box-title">
			              					Your Details
			              				</h3>
			            			</div>
									<div class="box-body">
	                                    <div class="form-group">
	                                        <label for="first_name" class="col-sm-3 control-label">First Name</label>
	                                        <div class="col-sm-9">
	                                            <input type="text" name="first_name" id="first_name" class="form-control" value="<?php echo $account_details['first_name']; ?>">
	                                        </div>
	                                    </div>

	                                    <div class="form-group">
	                                        <label for="last_name" class="col-sm-3 control-label">Last Name</label>
	                                        <div class="col-sm-9">
	                                            <input type="text" name="last_name" id="last_name" class="form-control" value="<?php echo $account_details['last_name']; ?>">
	                                        </div>
	                                    </div>

	                                    <div class="form-group">
	                                        <label for="email" class="col-sm-3 control-label">Email</label>
	                                        <div class="col-sm-9">
	                                            <input type="text" name="email" id="email" class="form-control" value="<?php echo $account_details['email']; ?>">
	                                            <small>This is the primary method of communication, please make sure its up-to-date.</small>
	                                        </div>
	                                    </div>

	                                    <div class="form-group">
	                                        <label for="tel" class="col-sm-3 control-label">Phone</label>
	                                        <div class="col-sm-9">
	                                            <input type="text" name="tel" id="tel" class="form-control" value="<?php echo $account_details['tel']; ?>">
	                                        </div>
	                                    </div>

	                                    <div class="form-group">
	                                        <label for="address_1" class="col-sm-3 control-label">Address 1</label>
	                                        <div class="col-sm-9">
	                                            <input type="text" name="address_1" id="address_1" class="form-control" value="<?php echo $account_details['address_1']; ?>">
	                                        </div>
	                                    </div>

	                                    <div class="form-group">
	                                        <label for="address_2" class="col-sm-3 control-label">Address 2</label>
	                                        <div class="col-sm-9">
	                                            <input type="text" name="address_2" id="address_2" class="form-control" value="<?php echo $account_details['address_2']; ?>">
	                                            <small>This field is optional.</small>
	                                        </div>
	                                    </div>

	                                    <div class="form-group">
	                                        <label for="address_city" class="col-sm-3 control-label">City</label>
	                                        <div class="col-sm-9">
	                                            <input type="text" name="address_city" id="address_city" class="form-control" value="<?php echo $account_details['address_city']; ?>">
	                                        </div>
	                                    </div>

	                                    <div class="form-group">
	                                        <label for="address_state" class="col-sm-3 control-label">State</label>
	                                        <div class="col-sm-9">
	                                            <input type="text" name="address_state" id="address_state" class="form-control" value="<?php echo $account_details['address_state']; ?>">
	                                        </div>
	                                    </div>

	                                    <div class="form-group">
	                                        <label for="address_country" class="col-sm-3 control-label">Country</label>
	                                        <div class="col-sm-9">
	                                            <input type="text" name="address_country" id="address_country" class="form-control" value="<?php echo $account_details['address_country']; ?>">
	                                        </div>
	                                    </div>

	                                    <div class="form-group">
	                                        <label for="address_zip" class="col-sm-3 control-label">Post Code</label>
	                                        <div class="col-sm-9">
	                                            <input type="text" name="address_zip" id="address_zip" class="form-control" value="<?php echo $account_details['address_zip']; ?>">
	                                        </div>
	                                    </div>
		                            </div>
		                            <div class="box-footer">
		                            	<div class="col-sm-12">
	                                        <button type="submit" class="btn btn-success pull-right">Save Changes</button>
	                                    </div>
		                            </div>
		                        </div>
		                    	-->

		                        <div class="box box-primary">
			            			<div class="box-header">
			              				<h3 class="box-title">
			              					Public / Affiliate Details
			              				</h3>
			            			</div>
									<div class="box-body">
	                                    <div class="form-group">
	                                        <label for="affiliate_username" class="col-sm-3 control-label">Username</label>
	                                        <div class="col-sm-9">
	                                            <input type="text" name="affiliate_username" id="affiliate_username" class="form-control" value="<?php echo $account_details['affiliate_username']; ?>">
	                                            <small>Please note: If you change this, any existing affiliate links you have given out will no longer work.</small>
	                                        </div>
	                                    </div>

	                                    <div class="form-group">
	                                        <label for="affiliate_first_name" class="col-sm-3 control-label">First Name</label>
	                                        <div class="col-sm-9">
	                                            <input type="text" name="affiliate_first_name" id="affiliate_first_name" class="form-control" value="<?php echo $account_details['affiliate_first_name']; ?>">
	                                        </div>
	                                    </div>

	                                    <div class="form-group">
	                                        <label for="affiliate_last_name" class="col-sm-3 control-label">Last Name</label>
	                                        <div class="col-sm-9">
	                                            <input type="text" name="affiliate_last_name" id="affiliate_last_name" class="form-control" value="<?php echo $account_details['affiliate_last_name']; ?>">
	                                        </div>
	                                    </div>

	                                    <div class="form-group">
	                                        <label for="affiliate_email" class="col-sm-3 control-label">Email</label>
	                                        <div class="col-sm-9">
	                                            <input type="text" name="affiliate_email" id="affiliate_email" class="form-control" value="<?php echo $account_details['affiliate_email']; ?>">
	                                        </div>
	                                    </div>

	                                    <div class="form-group">
	                                        <label for="affiliate_tel" class="col-sm-3 control-label">Phone</label>
	                                        <div class="col-sm-9">
	                                            <input type="text" name="affiliate_tel" id="affiliate_tel" class="form-control" value="<?php echo $account_details['affiliate_tel']; ?>">
	                                        </div>
	                                    </div>
		                            </div>
		                            <div class="box-footer">
		                            	<div class="col-sm-12">
	                                        <button type="submit" class="btn btn-success pull-right">Save Changes</button>
	                                    </div>
		                            </div>
		                        </div>

		                        <div class="box box-primary">
			            			<div class="box-header">
			              				<h3 class="box-title">
			              					Bank / Payout Details
			              				</h3>
			            			</div>
									<div class="box-body">
										<div class="form-group">
	                                        <label for="bank_name" class="col-sm-3 control-label">Bank</label>
	                                        <div class="col-sm-9">
	                                            <input type="text" name="bank_name" id="bank_name" class="form-control" value="<?php echo $account_details['bank_name']; ?>">
	                                        </div>
	                                    </div>

										<div class="form-group">
	                                        <label for="bank_account_name" class="col-sm-3 control-label">Account Name</label>
	                                        <div class="col-sm-9">
	                                            <input type="text" name="bank_account_name" id="bank_account_name" class="form-control" value="<?php echo $account_details['bank_account_name']; ?>">
	                                        </div>
	                                    </div>

	                                    <div class="form-group">
	                                        <label for="bank_account_number" class="col-sm-3 control-label">Account Number</label>
	                                        <div class="col-sm-9">
	                                            <input type="number" name="bank_account_number" id="bank_account_number" class="form-control" maxlength="8" value="<?php echo $account_details['bank_account_number']; ?>">
	                                        </div>
	                                    </div>

	                                    <div class="form-group">
	                                        <label for="bank_sort_code" class="col-sm-3 control-label">Sort Code</label>
	                                        <div class="col-sm-9">
	                                            <input type="number" name="bank_sort_code" id="bank_sort_code" class="form-control" maxlength="6" value="<?php echo $account_details['bank_sort_code']; ?>">
	                                        </div>
	                                    </div>


		                            </div>
		                            <div class="box-footer">
		                            	<div class="col-sm-12">
	                                        <button type="submit" class="btn btn-success pull-right">Save Changes</button>
	                                    </div>
		                            </div>
		                        </div>
		                    </div>
		                </form>

	                    <div class="col-lg-8">
							<div class="box box-primary">
		            			<div class="box-header">
		              				<h3 class="box-title">
		              					Purchase History
		              				</h3>
		            			</div>
								<div class="box-body">
									<table id="purchase_history" class="table table-bordered table-striped">
										<thead>
											<tr>
												<th class="no-sort" style="white-space: nowrap;" width="1px">Points</th>
												<th class="no-sort" style="white-space: nowrap;" width="1px">Date</th>
												<th class="no-sort" style="white-space: nowrap;">Item(s)</th>
												<th class="no-sort" style="white-space: nowrap;" width="1px">Amount</th>
												<th class="no-sort" width="1px">Payment</th>
											</tr>
										</thead>
										<tbody>
											<?php
												foreach($orders as $order) {
													$order_details 		= array();

													$date_bits 			= explode(" ", $order['date']);
													$order['date']		= $date_bits[0];

													if($order['status'] == 'Active') {
														$status = '<span class="label label-success full-width" style="width: 100%;">Active</span>';
													}elseif($order['status'] == 'Pending') {
														$status = '<span class="label label-info full-width" style="width: 100%;">Pending</span>';
													}elseif($order['status'] == 'Completed') {
														$status = '<span class="label label-success full-width" style="width: 100%;">Completed</span>';
													}elseif($order['status'] == 'Suspended') {
														$status = '<span class="label label-danger full-width" style="width: 100%;">Suspended</span>';
													}elseif($order['status'] == 'Terminated') {
														$status = '<span class="label label-danger full-width" style="width: 100%;">Terminated</span>';
													}elseif($order['status'] == 'Cancelled') {
														$status = '<span class="label label-danger full-width" style="width: 100%;">Cancelled</span>';
													}elseif($order['status'] == 'Fraud') {
														$status = '<span class="label label-danger full-width" style="width: 100%;">Fraud</span>';
													}else{
														$status = '<span class="label label-info full-width" style="width: 100%;">'.ucfirst($order['status']).'</span>';
													}

													if($order['paymentstatus'] == 'Paid') {
														$payment_status = '<span class="label label-success full-width" style="width: 100%;">Paid</span>';
													}else{
														$payment_status = '<span class="label label-danger full-width" style="width: 100%;">Unpaid</span>';
													}

													$order_points = 0;

													foreach($order['lineitems']['lineitem'] as $line_item){
														if($line_item['order_details']['product_id'] != 2){
															foreach($product_points as $product_point){
																if($product_point['product_id'] == $line_item['order_details']['product_id']){
																	$product_point_value = $product_point['points'];
																	break;
																}
															}
														}else{
															$product_point_value = 0;
														}

														$order_points = $order_points + $product_point_value;

														$order_details[] =$line_item['product'];
													}

													$order_details = implode('<br>', $order_details);

													echo '
														<tr>
															<td>
																'.$order_points.'
															</td>
															<td>
																'.$order['date'].'
															</td>
															<td>
																'.$order_details.'
															</td>
															<td>
																£'.number_format($order['amount'], 2).'
															</td>
															<td>
																'.$payment_status.'
															</td>
														</tr>
													';
												}
											?>
										</tbody>
									</table>
	                            </div>
	                        </div>

	                        <div class="box box-primary">
		            			<div class="box-header">
		              				<h3 class="box-title">
		              					Badges
		              				</h3>
		            			</div>
								<div class="box-body">
									<?php
										$badge_count 	= 1;
										$query 			= $conn->query("SELECT * FROM `user_badges` WHERE `user_id` = '".$_SESSION['account']['id']."' ");
										$badges 		= $query->fetchAll(PDO::FETCH_ASSOC);

										if(isset($badges[0]['id'])){
											foreach($badges as $badge_bits){

												$query 		= $conn->query("SELECT * FROM `badges` WHERE `id` = '".$badge_bits['badge_id']."' ");
												$badge 		= $query->fetch(PDO::FETCH_ASSOC);
												
												echo '
													<div class="col-sm-2">
														<center>
															<img src="badges/'.$badge['image'].'" alt="'.$badge['name'].'" data-toggle="tooltip" data-placement="bottom" title="'.$badge['description'].'"> <br>
															<h4><strong>'.stripslashes($badge['name']).'</strong></h4>
														</center>
													</div>
												';

												if($badge_count == 6){
													echo '
														<div class="row">
															<br>
															<hr>
														</div>
													';
													$badge_count = 0;
												}else{
													$badge_count++;
												}
											}
										}else{
											echo '<center><h3>:( No Badges Yet</h3></center>';
										}
									?>
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

        <?php function members(){ ?>
        	<?php 
        		global $conn, $globals, $global_settings, $account_details, $site;
			?>

            <div class="content-wrapper">
				
                <div id="status_message"></div>   
                            	
                <section class="content-header">
                    <h1>Staff Panel - View All Members <!-- <small>Optional description</small> --></h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="dashboard.php">Dashboard</a></li>
                        <li class="active">View All Members</li>
                    </ol>
                </section>

                <!-- Main content -->
				<section class="content">
					<!-- customer multi update -->
					<form id="customer_update_multi" action="actions.php?a=customer_multi_options" method="post">
						<div class="row">
							<div id="multi_options_show" class="col-md-4 hidden">
								<div class="box box-default">
									<div class="box-header with-border">
										<h3 class="box-title">
											Multi Member Options / Update
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
																<option value="enable">Enabled Selected Members</option>
																<option value="disable">Disable Selected Members</option>
															</optgroup>
															<optgroup label="Delete">
																<option value="delete">Delete Selected Members</option>
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
			              					View All Members
			              				</h3>
			              				<div class="pull-right">
			              					<button id="search_reset" type="button" class="btn btn-info btn-xs btn-flat" >Show All</button>
			              					<button id="search_active" type="button" class="btn btn-success btn-xs btn-flat" >Active</button>
			              					<button id="search_suspended" type="button" class="btn btn-warning btn-xs btn-flat" >Suspended</button>
			              					<button id="search_terminated" type="button" class="btn btn-danger btn-xs btn-flat" >Terminated</button>
			              					<button id="search_closed" type="button" class="btn btn-danger btn-xs btn-flat" >Closed</button>
										</div>
			            			</div>
									<div class="box-body">
										<table id="example" class="display responsive nowrap" style="width:100%">
									        <thead>
									            <tr>
									                <th class="no-sort" width="1px"></th>
									                <th class="no-sort hidden-xs" width="1px">Status</th>
									                <th style="white-space: nowrap;">Name</th>
									                <th class="hidden-xs" style="white-space: nowrap;" width="1px">Downline</th>
									                <th class="no-sort hidden-xs" style="white-space: nowrap;" width="100px">Upline</th>
									                <th class="no-sort hidden-xs" width="1px">Expires</th>
									                <th class="no-sort" style="white-space: nowrap;" width="50px">Actions</th>
									            </tr>
									        </thead>
									        <tfoot>
									            <tr>
									                <th class="no-sort" width="1px"></th>
									                <th class="no-sort hidden-xs" width="1px">Status</th>
									                <th style="white-space: nowrap;">Name</th>
									                <th class="hidden-xs" style="white-space: nowrap;" width="1px">Downline</th>
									                <th class="no-sort hidden-xs" style="white-space: nowrap;" width="100px">Upline</th>
									                <th class="no-sort hidden-xs" width="1px">Expires</th>
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

        <?php function member(){ ?>
        	<?php 
        		global $conn, $globals, $global_settings, $account_details, $site;
            
            	$member_id 				= get('id');

            	// get member data
				$member 				= account_details($member_id);

				// get all members for upline
				$query 					= $conn->query("SELECT `id`,`first_name`,`last_name`,`email` FROM `users` WHERE `type` = 'affiliate' OR `type` = 'promoter' ORDER BY `first_name`,`last_name` ");
				$all_members 			= $query->fetchAll(PDO::FETCH_ASSOC);

				// get commissions data
				$query 					= $conn->query("SELECT * FROM `commissions` WHERE `user_id` = '".$member_id."' ");
				$commissions 			= $query->fetchAll(PDO::FETCH_ASSOC);

				// get ublo affiliate info
				$whmcsUrl = "https://ublo.club/billing/";
				$username = "api_user";
				$password = md5("admin1372");

				// Set post values
				$postfields = array(
				    'username' 		=> $username,
				    'password' 		=> $password,
				    'action' 		=> 'GetAffiliates',
				    'userid' 		=> $member_id,
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

				// Decode response
				$whmcs_affiliate_details = json_decode($response, true);
				$whmcs_affiliate_details = $whmcs_affiliate_details['affiliates']['affiliate'][0];
			?>

            <div class="content-wrapper">
				
                <div id="status_message"></div>
                            	
                <section class="content-header">
                    <h1>Staff Panel - Member <!-- <small>Optional description</small> --></h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="dashboard.php">Dashboard</a></li>
                        <li class="active"><a href="dashboard.php?c=members">View All Members</a></li>
                        <li class="active">Member</li>
                    </ol>
                </section>

                <!-- Main content -->
				<section class="content">
					<div class="row">
						<div class="col-lg-4">
							<div class="col-lg-12">
								<div class="box box-primary">
			            			<div class="box-header">
			              				<h3 class="box-title">
			              					Basic Details
			              				</h3>
			            			</div>
									<div class="box-body">
										<form action="actions.php?a=member_update" class="form-horizontal form-bordered" method="post">
											<input type="hidden" name="member_id" value="<?php echo $member_id; ?>">
											<div class="row">
												<div class="col-lg-12">
													<section class="panel">
														<div class="panel-body">
															<?php if(isset($_GET['dev']) && $_GET['dev'] == 'yes') { ?>
																	<?php debug($member); ?>
																	<?php debug($commissions); ?>
															<?php } ?>

															<div class="form-group">
																<label class="col-md-2 control-label" for="account_status">Status</label>
																<div class="col-md-10">
																	<span class="vcenter">
																		<?php 
																			if($member['status'] == 'active') {
																				echo '<span class="label label-success full-width" style="width: 100px;">Active</span>';
																			}elseif($member['status'] == 'disabled') {
																				echo '<span class="label label-danger full-width" style="width: 100px%;">Disabled</span>';
																			}elseif($member['status'] == 'suspended') {
																				echo '<span class="label label-danger full-width" style="width: 100px%;">Suspended</span>';
																			}elseif($member['status'] == 'terminated') {
																				echo '<span class="label label-danger full-width" style="width: 100px%;">Terminated</span>';
																			}elseif($member['status'] == 'cancelled') {
																				echo '<span class="label label-danger full-width" style="width: 100px%;">Cancelled</span>';
																			}else{
																				echo '<span class="label label-warning full-width" style="width: 100px%;">'.ucfirst($member['status']).'</span>';
																			}
																		?>
																	</span>
																</div>
															</div>

															<!-- name -->
															<div class="form-group">
																<label class="col-md-2 control-label" for="first_name">Name</label>
																<div class="col-md-5">
																	<input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo stripslashes($member['first_name']); ?>" disabled>
																</div>
																<div class="col-md-5">
																	<input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo stripslashes($member['last_name']); ?>" disabled>
																</div>
															</div>

															<!-- email -->
															<div class="form-group">
																<label class="col-md-2 control-label" for="email">Email</label>
																<div class="col-md-10">
																	<input type="text" class="form-control" id="email" name="email" value="<?php echo stripslashes($member['email']); ?>" disabled>
																</div>
															</div>

															<!-- upline -->
															<div class="form-group">
																<label class="col-md-2 control-label" for="upline_id">Upline</label>
																<div class="col-md-10">
																	<select id="upline_id" name="upline_id" class="form-control select2">
																		<?php foreach($all_members as $all_member){ ?>
																			<option <?php if($member['upline_id']==$all_member['id']){echo"selected";} ?> value="<?php echo $all_member['id'];?>">
																				<?php echo $all_member['first_name'].' '.$all_member['last_name'].' ('.$all_member['email'].')'; ?>
																			</option>
																		<?php } ?>
																	</select>

																	<small>Pleaste note: changing the upline will move this member and their entire downline. All existing commissions will be paid but all commissions generate after the change will be paid to the new upline genealogy.</small>
																</div>
															</div>
														</div>
													</section>
												</div>
											</div>

											<footer class="panel-footer">
												<a href="dashboard.php?c=members" class="btn btn-default">Back</a>
												<a href="https://ublo.club/billing/admin/clientssummary.php?userid=<?php echo $member_id; ?>" target="_blank" class="btn btn-primary">View Full Profile</a>
												<button type="submit" class="btn btn-success pull-right">Save Changes</button>
											</footer>
										</form>
									</div>
								</div>
							</div>

							<div class="col-lg-12">
								<div class="box box-primary">
			            			<div class="box-header">
			              				<h3 class="box-title">
			              					Ublo.club Affiliate Stats
			              				</h3>
			            			</div>
									<div class="box-body">
										<form class="form-horizontal form-bordered">
											<div class="row">
												<div class="col-lg-12">
													<section class="panel">
														<div class="panel-body">
															<div class="form-group">
																<label class="col-md-2 control-label" for="whmcs_visitors">Visitors</label>
																<div class="col-md-10">
																	<input type="text" class="form-control" id="whmcs_visitors" name="whmcs_visitors" value="<?php echo stripslashes($whmcs_affiliate_details['visitors']); ?>" read-only>
																</div>
															</div>
														</div>
													</section>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>

						<div class="col-lg-8">
							<div class="box box-primary">
		            			<div class="box-header">
		              				<h3 class="box-title">
		              					Commissions
		              				</h3>
		            			</div>
								<div class="box-body">
									<div class="row">
										<div class="col-lg-12">
											<table id="member_commissions" class="display" style="width:100%">
										        <thead>
										            <tr>
										            	<th class="no-sort" width="1px"></th>
										                <th class="no-sort" width="1px">Status</th>
										                <th class="no-sort hidden-xs" width="1px">Qualified</th>
										                <th class="no-sort hidden-xs" style="white-space: nowrap;">Release Date</th>
										                <th class="no-sort" style="white-space: nowrap;">Amount</th>
										                <th class="no-sort" style="white-space: nowrap;" width="60px">Actions</th>
										            </tr>
										        </thead>
										        <tfoot>
										            <tr>
										            	<th class="no-sort" width="1px"></th>
										                <th class="no-sort" width="1px">Status</th>
										                <th class="no-sort hidden-xs" width="1px">Qualified</th>
										                <th class="no-sort hidden-xs" style="white-space: nowrap;">Release Date</th>
										                <th class="no-sort" style="white-space: nowrap;">Amount</th>
										                <th class="no-sort" style="white-space: nowrap;" width="60px">Actions</th>
										            </tr>
										        </tfoot>
										    </table>
										</div>
									</div>
								</div>
								<div class="box-footer">
									<a href="actions.php?a=commissions_approve_all&id=<?php echo $member_id; ?>" class="btn btn-primary pull-right" onclick="return confirm('This will approve all pending commissions. Are you sure?')">Approve All</a>
								</div>
							</div>
						</div>

					</div>
				</section>
            </div>
        <?php } ?>

        <?php function products(){ ?>
        	<?php 
        		global $conn, $globals, $global_settings, $account_details, $site;
			?>

            <div class="content-wrapper">
				
                <div id="status_message"></div>   
                            	
                <section class="content-header">
                    <h1>Staff Panel - View All Products <!-- <small>Optional description</small> --></h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="dashboard.php">Dashboard</a></li>
                        <li class="active">View All Products</li>
                    </ol>
                </section>

                <!-- Main content -->
				<section class="content">
					<!-- customer multi update -->
					<form id="customer_update_multi" action="actions.php?a=customer_multi_options" method="post">
						<div class="row">
							<div class="col-lg-12">
								<div class="box box-primary">
			            			<div class="box-header">
			              				<h3 class="box-title">
			              					View All Products
			              				</h3>
			              				<div class="pull-right">
			              					<!-- <button type="button" class="btn btn-success btn-xs btn-flat" data-toggle="modal" data-target="#new_customer_modal">Add Customer</button> -->
										</div>
			            			</div>
									<div class="box-body">
										<table id="example" class="display" style="width:100%">
									        <thead>
									            <tr>
									                <th class="no-sort" width="1px"></th>
									                <th class="no-sort" width="150px" style="white-space: nowrap;">Category</th>
									                <th class="no-sort" style="white-space: nowrap;">Name</th>
									                <th class="no-sort hidden-xs" style="white-space: nowrap;" width="100px">Recurring</th>
									                <th class="no-sort" width="1px">Monthly</th>
									                <th class="no-sort" width="1px">Quarterly</th>
									                <th class="no-sort" width="1px">Annually</th>
									                <th class="no-sort text-right" style="white-space: nowrap;" width="1px">Actions</th>
									            </tr>
									        </thead>
									        <tfoot>
									            <tr>
									                <th class="no-sort" width="1px"></th>
									                <th class="no-sort" width="150px" style="white-space: nowrap;">Category</th>
									                <th class="no-sort" style="white-space: nowrap;">Name</th>
									                <th class="no-sort hidden-xs" style="white-space: nowrap;" width="100px">Recurring</th>
									                <th class="no-sort" width="1px">Monthly</th>
									                <th class="no-sort" width="1px">Quarterly</th>
									                <th class="no-sort" width="1px">Annually</th>
									                <th class="no-sort" style="white-space: nowrap;" width="1px">Actions</th>
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

        <?php function all_commissions(){ ?>
        	<?php 
        		global $conn, $globals, $global_settings, $account_details, $site;
            
            	$commissions = get_all_commissions();
			?>

            <div class="content-wrapper">
				
                <div id="status_message"></div>
                            	
                <section class="content-header">
                    <h1>Staff Panel - View All Commissions <!-- <small>Optional description</small> --></h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="dashboard.php">Dashboard</a></li>
                        <li class="active">View All Commissions</li>
                    </ol>
                </section>

                <!-- Main content -->
				<section class="content">
					<div class="row">
						<div class="col-lg-2 col-xs-6">
							<div class="box box-primary">
		            			<div class="box-header">
		              				<h3 class="box-title">
		              					Total
		              				</h3>
		            			</div>
								<div class="box-body">
									<center>
										<h3>£<?php echo $commissions['commissions']['total']; ?></h3>
									</center>
								</div>
							</div>
						</div>

						<div class="col-lg-2 col-xs-6">
							<div class="box box-warning">
		            			<div class="box-header">
		              				<h3 class="box-title">
		              					Pending
		              				</h3>
		            			</div>
								<div class="box-body">
									<center>
										<h3>£<?php echo $commissions['commissions']['pending']; ?></h3>
									</center>
								</div>
							</div>
						</div>

						<div class="col-lg-2 col-xs-6">
							<div class="box box-warning">
		            			<div class="box-header">
		              				<h3 class="box-title">
		              					Approved
		              				</h3>
		              				<small>Pending Payment</small>
		            			</div>
								<div class="box-body">
									<center>
										<h3>£<?php echo $commissions['commissions']['approved']; ?></h3>
									</center>
								</div>
							</div>
						</div>

						<div class="col-lg-2 col-xs-6">
							<div class="box box-danger">
		            			<div class="box-header">
		              				<h3 class="box-title">
		              					Missed
		              				</h3>
		            			</div>
								<div class="box-body">
									<center>
										<h3>£<?php echo $commissions['commissions']['missed']; ?></h3>
									</center>
								</div>
							</div>
						</div>

						<div class="col-lg-2 col-xs-6">
							<div class="box box-danger">
		            			<div class="box-header">
		              				<h3 class="box-title">
		              					Rejected
		              				</h3>
		            			</div>
								<div class="box-body">
									<center>
										<h3>£<?php echo $commissions['commissions']['rejected']; ?></h3>
									</center>
								</div>
							</div>
						</div>

						<div class="col-lg-2 col-xs-6">
							<div class="box box-success">
		            			<div class="box-header">
		              				<h3 class="box-title">
		              					Paid
		              				</h3>
		            			</div>
								<div class="box-body">
									<center>
										<h3>£<?php echo $commissions['commissions']['paid']; ?></h3>
									</center>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-12">
							<div class="box box-primary">
		            			<div class="box-header">
		              				<h3 class="box-title">
		              					View All Commissions
		              				</h3>
		              				<div class="pull-right">
		              					<button id="search_reset" type="button" class="btn btn-info btn-xs btn-flat" >Show All</button>
		              					<button id="search_pending" type="button" class="btn btn-warning btn-xs btn-flat" >Pending</button>
		              					<button id="search_approved" type="button" class="btn btn-warning btn-xs btn-flat" >Approved</button>
		              					<button id="search_missed" type="button" class="btn btn-danger btn-xs btn-flat" >Missed</button>
		              					<button id="search_rejected" type="button" class="btn btn-danger btn-xs btn-flat" >Rejected</button>
		              					<button id="search_paid" type="button" class="btn btn-success btn-xs btn-flat" >Paid</button>
									</div>
		            			</div>
								<div class="box-body">
									<div class="row">
										<div class="col-lg-12">
											<table id="commissions" class="display " style="width:100%">
										        <thead>
										            <tr>
										            	<th class="no-sort" width="1px"></th>
										                <th class="no-sort" width="1px">Status</th>
										                <th class="no-sort" style="white-space: nowrap;">Member</th>
										                <th class="no-sort hidden-xs" width="1px">Qualified</th>
										                <th class="no-sort hidden-xs" width="100px">Order Date</th>
										                <th class="no-sort hidden-xs" width="100px">Release Date</th>
										                <th class="no-sort" width="100px">Amount</th>
										                <th class="no-sort" style="white-space: nowrap;" width="50px">Actions</th>
										            </tr>
										        </thead>
										        <tfoot>
										            <tr>
										            	<th class="no-sort" width="1px"></th>
										                <th class="no-sort" width="1px">Status</th>
										                <th class="no-sort" style="white-space: nowrap;">Member</th>
										                <th class="no-sort hidden-xs" width="1px">Qualified</th>
										                <th class="no-sort hidden-xs" width="1px">Order Date</th>
										                <th class="no-sort hidden-xs" width="1px">Release Date</th>
										                <th class="no-sort" width="100px">Amount</th>
										                <th class="no-sort" style="white-space: nowrap;" width="50px">Actions</th>
										            </tr>
										        </tfoot>
										    </table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
            </div>
        <?php } ?>

        <?php function all_withdrawal_requests(){ ?>
        	<?php 
        		global $conn, $globals, $global_settings, $account_details, $site;            
			?>

            <div class="content-wrapper">
				
                <div id="status_message"></div>
                            	
                <section class="content-header">
                    <h1>Staff Panel - View All Withdrawal Requests <!-- <small>Optional description</small> --></h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="dashboard.php">Dashboard</a></li>
                        <li class="active">View All Withdrawal Requests</li>
                    </ol>
                </section>

                <!-- Main content -->
				<section class="content">
					<div class="row">
						<div class="col-lg-12">
							<div class="box box-primary">
		            			<div class="box-header">
		              				<h3 class="box-title">
		              					View All Withdrawal Requests
		              				</h3>
		              				<div class="pull-right">
										<button id="search_reset" type="button" class="btn btn-info btn-xs btn-flat" >Show All</button>
		              					<button id="search_rejected" type="button" class="btn btn-danger btn-xs btn-flat" >Rejected</button>
		              					<button id="search_cancelled" type="button" class="btn btn-danger btn-xs btn-flat" >Cancelled</button>
		              					<button id="search_pending" type="button" class="btn btn-warning btn-xs btn-flat" >Pending Payout</button>
										<button id="search_paid" type="button" class="btn btn-success btn-xs btn-flat" >Paid</button>
									</div>
		            			</div>
								<div class="box-body">
									<div class="row">
										<div class="col-lg-12">
											<table id="withdrawal_requests" class="display" style="width:100%">
										        <thead>
										            <tr>
										            	<th class="no-sort" width="1px"></th>
										                <th class="no-sort" width="1px">Status</th>
										                <th class="no-sort" style="white-space: nowrap;">Member</th>
										                <th class="no-sort hidden-xs" width="100px">Request Date</th>
										                <th class="no-sort" width="100px">Amount</th>
										                <th class="no-sort" style="white-space: nowrap;" width="50px">Actions</th>
										            </tr>
										        </thead>
										        <tfoot>
										            <tr>
										            	<th class="no-sort" width="1px"></th>
										                <th class="no-sort" width="1px">Status</th>
										                <th class="no-sort" style="white-space: nowrap;">Member</th>
										                <th class="no-sort hidden-xs" width="100px">Request Date</th>
										                <th class="no-sort" width="100px">Amount</th>
										                <th class="no-sort" style="white-space: nowrap;" width="50px">Actions</th>
										            </tr>
										        </tfoot>
										    </table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
            </div>
        <?php } ?>

        <?php function visual_downline(){ ?>
        	<?php 
        		global $conn, $globals, $global_settings, $account_details, $site;

        		// get customers
				$query 				= $conn->query("SELECT `id`,`status`,`avatar`,`first_name`,`last_name`,`upline_id` FROM `users` ");
				$customers 			= $query->fetchAll(PDO::FETCH_ASSOC);
			?>

			<link href="css/reset-html5.css" rel="stylesheet" media="screen" />
			<link href="css/micro-clearfix.css" rel="stylesheet" media="screen" />
			<link href="css/stiff-chart.css" rel="stylesheet" media="screen" />
			<link href="css/custom.css" rel="stylesheet" media="screen" />

            <div class="content-wrapper">
				
                <div id="status_message"></div>   
                            	
                <section class="content-header">
                    <h1>Visual Genealogy <!-- <small>Optional description</small> --></h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="dashboard.php">Dashboard</a></li>
                        <li class="active">Visual Genealogy</li>
                    </ol>
                </section>

                <!-- Main content -->
				<section class="content">
					<div class="row">
						<div class="col-md-12">
							<div class="chart-container">
							    <div id="downline_chart">
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
											                                	<strong>'.stripslashes($customer['first_name']).' '.stripslashes($customer['last_name']).'</strong> <br>
											                                	Level 1<br>
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
							            <?php if(is_array($downline[1])) {foreach($downline[1] as $level_2){ ?>
							            	<div class="stiff-chart-level" data-level="02">
								                <div class="stiff-child" data-child-from="1_<?php echo $level_2; ?>">
								                	<ul>
									                    <?php 
								                    		foreach($customers as $customer){
								                    			if($customer['upline_id'] == $level_2){
								                    				echo '
												                        <li data-parent="2_'.$customer['id'].'">
												                            <div class="the-chart">
												                                <img src="'.$customer['avatar'].'" width="100px" height="100px" alt="">
												                                <p>
												                                	<strong>'.stripslashes($customer['first_name']).' '.stripslashes($customer['last_name']).'</strong> <br>
											                                		Level 2<br>
												                                </p>
												                            </div>
												                        </li>
								                    				';
								                    				$downline[2][] = $customer['id'];
								                    			}
								                    		}
								                    	?>
								                    </ul>
								                </div>
								            </div>
								        <?php } } ?>

								        <!-- downline level 3 -->
							            <?php if(is_array($downline[2])) {foreach($downline[2] as $level_3){ ?>
							            	<div class="stiff-chart-level" data-level="03">
								                <div class="stiff-child" data-child-from="2_<?php echo $level_3; ?>">
								                	<ul>
									                    <?php 
								                    		foreach($customers as $customer){
								                    			if($customer['upline_id'] == $level_3){
								                    				echo '
												                        <li data-parent="3_'.$customer['id'].'">
												                            <div class="the-chart">
												                                <img src="'.$customer['avatar'].'" width="100px" height="100px" alt="">
												                                <p>
												                                	<strong>'.stripslashes($customer['first_name']).' '.stripslashes($customer['last_name']).'</strong> <br>
											                                		Level 3<br>
												                                </p>
												                            </div>
												                        </li>
								                    				';
								                    				$downline[3][] = $customer['id'];
								                    			}
								                    		}
								                    	?>
								                    </ul>
								                </div>
								            </div>
								        <?php } } ?>

								        <!-- downline level 4 -->
							            <?php if(is_array($downline[3])) {foreach($downline[3] as $level_4){ ?>
							            	<div class="stiff-chart-level" data-level="04">
								                <div class="stiff-child" data-child-from="3_<?php echo $level_4; ?>">
								                	<ul>
									                    <?php 
								                    		foreach($customers as $customer){
								                    			if($customer['upline_id'] == $level_4){
								                    				echo '
												                        <li data-parent="4_'.$customer['id'].'">
												                            <div class="the-chart">
												                                <img src="'.$customer['avatar'].'" width="100px" height="100px" alt="">
												                                <p>
												                                	<strong>'.stripslashes($customer['first_name']).' '.stripslashes($customer['last_name']).'</strong> <br>
											                                		Level 4<br>
												                                </p>
												                            </div>
												                        </li>
								                    				';
								                    				$downline[4][] = $customer['id'];
								                    			}
								                    		}
								                    	?>
								                    </ul>
								                </div>
								            </div>
								        <?php } } ?>

								        <!-- downline level 5 -->
							            <?php if(is_array($downline[4])) {foreach($downline[4] as $level_5){ ?>
							            	<div class="stiff-chart-level" data-level="05">
								                <div class="stiff-child" data-child-from="4_<?php echo $level_5; ?>">
								                	<ul>
									                    <?php 
								                    		foreach($customers as $customer){
								                    			if($customer['upline_id'] == $level_5){
								                    				echo '
												                        <li data-parent="5_'.$customer['id'].'">
												                            <div class="the-chart">
												                                <img src="'.$customer['avatar'].'" width="100px" height="100px" alt="">
												                                <p>
												                                	<strong>'.stripslashes($customer['first_name']).' '.stripslashes($customer['last_name']).'</strong> <br>
											                                		Level 5<br>
												                                </p>
												                            </div>
												                        </li>
								                    				';
								                    				$downline[5][] = $customer['id'];
								                    			}
								                    		}
								                    	?>
								                    </ul>
								                </div>
								            </div>
								        <?php } } ?>

								        <!-- downline level 6 -->
							            <?php if(is_array($downline[5])) {foreach($downline[5] as $level_6){ ?>
							            	<div class="stiff-chart-level" data-level="06">
								                <div class="stiff-child" data-child-from="5_<?php echo $level_6; ?>">
								                	<ul>
									                    <?php 
								                    		foreach($customers as $customer){
								                    			if($customer['upline_id'] == $level_6){
								                    				echo '
												                        <li data-parent="6_'.$customer['id'].'">
												                            <div class="the-chart">
												                                <img src="'.$customer['avatar'].'" width="100px" height="100px" alt="">
												                                <p>
												                                	<strong>'.stripslashes($customer['first_name']).' '.stripslashes($customer['last_name']).'</strong> <br>
											                                		Level 6<br>
												                                </p>
												                            </div>
												                        </li>
								                    				';
								                    				$downline[6][] = $customer['id'];
								                    			}
								                    		}
								                    	?>
								                    </ul>
								                </div>
								            </div>
								        <?php } } ?>

								        <!-- downline level 7 -->
							            <?php if(is_array($downline[6])) {foreach($downline[6] as $level_7){ ?>
							            	<div class="stiff-chart-level" data-level="07">
								                <div class="stiff-child" data-child-from="6_<?php echo $level_7; ?>">
								                	<ul>
									                    <?php 
								                    		foreach($customers as $customer){
								                    			if($customer['upline_id'] == $level_7){
								                    				echo '
												                        <li data-parent="7_'.$customer['id'].'">
												                            <div class="the-chart">
												                                <img src="'.$customer['avatar'].'" width="100px" height="100px" alt="">
												                                <p>
												                                	<strong>'.stripslashes($customer['first_name']).' '.stripslashes($customer['last_name']).'</strong> <br>
											                                		Level 7<br>
												                                </p>
												                            </div>
												                        </li>
								                    				';
								                    				$downline[7][] = $customer['id'];
								                    			}
								                    		}
								                    	?>
								                    </ul>
								                </div>
								            </div>
								        <?php } } ?>
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
				  $('#downline_chart').stiffChart({
				    
				  });
				});
			</script>
        <?php } ?>

        <?php function table_downline(){ ?>
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
                    <h1>Table Genealogy <!-- <small>Optional description</small> --></h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="dashboard.php">Dashboard</a></li>
                        <li class="active">Table Genealogy</li>
                    </ol>
                </section>

                <!-- Main content -->
				<section class="content">
					<div class="row">
						<div class="col-lg-12">
							<div class="box box-primary">
		            			<div class="box-header">
		              				<h3 class="box-title">
		              					Table Genealogy
		              				</h3>
		              				<div class="pull-right">
		              					<!-- <button type="button" class="btn btn-success btn-xs btn-flat" data-toggle="modal" data-target="#new_customer_modal">Add Customer</button> -->
									</div>
		            			</div>
								<div class="box-body">
									<table id="example" class="display" style="width:100%">
								        <thead>
								            <tr>
								                <th class="no-sort" width="1px"></th>
								                <th style="white-space: nowrap;" width="1px">Status</th>
								                <th style="white-space: nowrap;" width="1px">Level</th>
								                <th style="white-space: nowrap;" width="1px">Type</th>
								                <th style="white-space: nowrap;">Name</th>
								                <th class="no-sort" style="white-space: nowrap;" width="1px">Downline</th>
								                <th class="no-sort" style="white-space: nowrap;" width="100px">Upline</th>
								            </tr>
								        </thead>
								        <tfoot>
								            <tr>
								                <th class="no-sort" width="1px"></th>
								                <th style="white-space: nowrap;" width="1px">Status</th>
								                <th style="white-space: nowrap;" width="1px">Level</th>
								                <th style="white-space: nowrap;" width="1px">Type</th>
								                <th style="white-space: nowrap;">Name</th>
								                <th class="no-sort" style="white-space: nowrap;" width="1px">Downline</th>
								                <th class="no-sort" style="white-space: nowrap;" width="100px">Upline</th>
								            </tr>
								        </tfoot>
								    </table>
								</div>
							</div>
						</div>
					</div>
				</section>
            </div>
        <?php } ?>

        <?php function my_commissions(){ ?>
        	<?php 
        		global $conn, $globals, $global_settings, $account_details, $site;
            
            	$commissions = get_commissions();
			?>

            <div class="content-wrapper">
				
                <div id="status_message"></div>
                            	
                <section class="content-header">
                    <h1>Commissions <!-- <small>Optional description</small> --></h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="dashboard.php">Dashboard</a></li>
                        <li class="active">Commissions</li>
                    </ol>
                </section>

                <!-- Main content -->
				<section class="content">
					<div class="row">
						<div class="col-lg-2 col-xs-6">
							<div class="box box-primary">
		            			<div class="box-header">
		              				<h3 class="box-title">
		              					Total
		              				</h3>
		            			</div>
								<div class="box-body">
									<center>
										<h3>£<?php echo $commissions['commissions']['total']; ?></h3>
									</center>
								</div>
							</div>
						</div>

						<div class="col-lg-2 col-xs-6">
							<div class="box box-warning">
		            			<div class="box-header">
		              				<h3 class="box-title">
		              					Pending
		              				</h3>
		            			</div>
								<div class="box-body">
									<center>
										<h3>£<?php echo $commissions['commissions']['pending']; ?></h3>
									</center>
								</div>
							</div>
						</div>

						<div class="col-lg-2 col-xs-6">
							<div class="box box-warning">
		            			<div class="box-header">
		              				<h3 class="box-title">
		              					Approved
		              				</h3>
		            			</div>
								<div class="box-body">
									<center>
										<h3>£<?php echo $commissions['commissions']['approved']; ?></h3>
									</center>
								</div>
							</div>
						</div>

						<div class="col-lg-2 col-xs-6">
							<div class="box box-danger">
		            			<div class="box-header">
		              				<h3 class="box-title">
		              					Missed
		              				</h3>
		            			</div>
								<div class="box-body">
									<center>
										<h3>£<?php echo $commissions['commissions']['missed']; ?></h3>
									</center>
								</div>
							</div>
						</div>

						<div class="col-lg-2 col-xs-6">
							<div class="box box-danger">
		            			<div class="box-header">
		              				<h3 class="box-title">
		              					Rejected
		              				</h3>
		            			</div>
								<div class="box-body">
									<center>
										<h3>£<?php echo $commissions['commissions']['rejected']; ?></h3>
									</center>
								</div>
							</div>
						</div>

						<div class="col-lg-2 col-xs-6">
							<div class="box box-success">
		            			<div class="box-header">
		              				<h3 class="box-title">
		              					Paid
		              				</h3>
		            			</div>
								<div class="box-body">
									<center>
										<h3>£<?php echo $commissions['commissions']['paid']; ?></h3>
									</center>
								</div>
							</div>
						</div>
					</div>

					<!--
					<div class="row">
						<div class="col-lg-6">
							<a href="dashboard.php?c=my_withdrawals" class="btn btn-info btn-flat full-width" >View Withdrawal Requests</a>
						</div>
						<div class="col-lg-6">
							<a href="dashboard.php?c=request_payout" class="btn btn-success btn-flat full-width" >Request a Payout</a>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-12">
							<br>
						</div>
					</div>
					-->

					<div class="row">
						<div class="col-lg-12">
							<div class="box box-primary">
		            			<div class="box-header">
		              				<h3 class="box-title">
		              					Commissions
		              				</h3>
		              				<div class="pull-right">
		              					<button id="search_reset" type="button" class="btn btn-info btn-xs btn-flat" >Show All</button>
		              					<button id="search_pending" type="button" class="btn btn-warning btn-xs btn-flat" >Pending</button>
		              					<button id="search_approved" type="button" class="btn btn-warning btn-xs btn-flat" >Approved</button>
		              					<button id="search_missed" type="button" class="btn btn-danger btn-xs btn-flat" >Missed</button>
		              					<button id="search_rejected" type="button" class="btn btn-danger btn-xs btn-flat" >Rejected</button>
		              					<button id="search_paid" type="button" class="btn btn-success btn-xs btn-flat" >Paid</button>
									</div>
		            			</div>
								<div class="box-body">
									<div class="row">
										<div class="col-lg-12">
											<table id="commissions" class="display responsive nowrap" style="width:100%">
										        <thead>
										            <tr>
										            	<th class="no-sort" width="1px"></th>
										                <th class="no-sort" width="1px">Status</th>
										                <th class="no-sort hidden-xs" width="1px">Qualified</th>
										                <th class="no-sort hidden-xs" width="100px">Order Date</th>
										                <th class="no-sort hidden-xs">Release Date</th>
										                <th class="" width="100px">Amount</th>
										            </tr>
										        </thead>
										        <tfoot>
										            <tr>
										            	<th class="no-sort" width="1px"></th>
										                <th class="no-sort" width="1px">Status</th>
										                <th class="no-sort hidden-xs" width="1px">Qualified</th>
										                <th class="no-sort hidden-xs" width="100px">Order Date</th>
										                <th class="no-sort hidden-xs">Release Date</th>
										                <th class="" width="100px">Amount</th>
										            </tr>
										        </tfoot>
										    </table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
            </div>
        <?php } ?>

        <?php function my_withdrawals(){ ?>
        	<?php 
        		global $conn, $globals, $global_settings, $account_details, $site;
            
            	$withdrawls 	= get_withdrawls();

            	$query 						= $conn->query("SELECT `id` FROM `withdrawal_requests` WHERE `user_id` = '".$_SESSION['account']['id']."' AND `status` = 'pending' ");
				$pending_withdrawal 		= $query->fetch(PDO::FETCH_ASSOC);
			?>

            <div class="content-wrapper">
				
                <div id="status_message"></div>
                            	
                <section class="content-header">
                    <h1>Withdrawals <!-- <small>Optional description</small> --></h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="dashboard.php">Dashboard</a></li>
                        <li class="active">Withdrawal</li>
                    </ol>
                </section>

                <!-- Main content -->
				<section class="content">
					<div class="row">
						<div class="col-lg-3 col-xs-6">
							<div class="box box-primary">
		            			<div class="box-header">
		              				<h3 class="box-title">
		              					Total
		              				</h3>
		            			</div>
								<div class="box-body">
									<center>
										<h3>£<?php echo $withdrawls['total']; ?></h3>
									</center>
								</div>
							</div>
						</div>

						<div class="col-lg-3 col-xs-6">
							<div class="box box-warning">
		            			<div class="box-header">
		              				<h3 class="box-title">
		              					Available Balance
		              				</h3>
		            			</div>
								<div class="box-body">
									<center>
										<h3>£<?php echo $withdrawls['available']; ?></h3>
									</center>
								</div>
							</div>
						</div>

						<div class="col-lg-3 col-xs-6">
							<div class="box box-warning">
		            			<div class="box-header">
		              				<h3 class="box-title">
		              					Pending Payments
		              				</h3>
		            			</div>
								<div class="box-body">
									<center>
										<h3>£<?php echo $withdrawls['pending']; ?></h3>
									</center>
								</div>
							</div>
						</div>

						<div class="col-lg-3 col-xs-6">
							<div class="box box-success">
		            			<div class="box-header">
		              				<h3 class="box-title">
		              					Paid
		              				</h3>
		            			</div>
								<div class="box-body">
									<center>
										<h3>£<?php echo $withdrawls['paid']; ?></h3>
									</center>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-12">
							<?php if(empty($account_details['bank_sort_code']) || empty($account_details['bank_account_number'])){ ?>
								<a href="dashboard.php?c=my_account" class="btn btn-warning btn-flat full-width">Bank details required to process your request</a>
							<?php }elseif($withdrawls['available'] >= $global_settings['payout_min']){ ?>
								<button type="button" class="btn btn-success btn-flat full-width" data-toggle="modal" data-target="#request_payout">Withdrawal Request</button>
							<?php }else{ ?>
								<a href="" class="btn btn-warning btn-flat full-width" disabled>Min withdrawal amount is £<?php echo $global_settings['payout_min']; ?></a>
							<?php } ?>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-12">
							<br>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-12">
							<div class="box box-primary">
		            			<div class="box-header">
		              				<h3 class="box-title">
		              					Withdrawal
		              				</h3>
		              				<div class="pull-right">
		              					<button id="search_reset" type="button" class="btn btn-info btn-xs btn-flat" >Show All</button>
		              					<button id="search_rejected" type="button" class="btn btn-danger btn-xs btn-flat" >Rejected</button>
		              					<button id="search_cancelled" type="button" class="btn btn-danger btn-xs btn-flat" >Cancelled</button>
		              					<button id="search_pending" type="button" class="btn btn-warning btn-xs btn-flat" >Pending Payout</button>
										<button id="search_paid" type="button" class="btn btn-success btn-xs btn-flat" >Paid</button>
									</div>
		            			</div>
								<div class="box-body">
									<div class="row">
										<div class="col-lg-12">
											<table id="withdrawal_requests" class="display" style="width:100%">
										        <thead>
										            <tr>
										            	<th class="no-sort" width="1px"></th>
										                <th class="no-sort" width="1px">Status</th>
										                <th class="no-sort hidden-xs" width="100px">Request Date</th>
										                <th class="no-sort hidden-xs" width="100px">Paid Date</th>
										                <th class="no-sort hidden-xs">Comments</th>
										                <th class="no-sort" width="100px">Amount</th>
										                <th class="no-sort" style="white-space: nowrap;" width="50px">Actions</th>
										            </tr>
										        </thead>
										        <tfoot>
										            <tr>
										            	<th class="no-sort" width="1px"></th>
										                <th class="no-sort" width="1px">Status</th>
										                <th class="no-sort hidden-xs" width="100px">Request Date</th>
										                <th class="no-sort hidden-xs" width="100px">Paid Date</th>
										                <th class="no-sort hidden-xs">Comments</th>
										                <th class="no-sort" width="100px">Amount</th>
										                <th class="no-sort" style="white-space: nowrap;" width="50px">Actions</th>
										            </tr>
										        </tfoot>
										    </table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
            </div>

            <form action="actions.php?a=withdrawal_request_add" class="form-horizontal form-bordered" method="post">
				<input type="hidden" name="available" value="<?php echo $withdrawls['available']; ?>">
				<div class="modal fade" id="request_payout" role="dialog">
				    <?php if(isset($pending_withdrawal['id'])){ ?>
				    	<div class="modal-dialog">
				    <?php }else{ ?>
				    	<div class="modal-dialog modal-lg">
				    <?php } ?>
				        <div class="modal-content">
				            <div class="modal-header">
				                <button type="button" class="close" data-dismiss="modal">&times;</button>
				                <h4 class="modal-title">Withdrawal Request</h4>
				            </div>
				            <div class="modal-body">
				            	<div class="row">
					            	<div class="col-lg-12">
										<?php if(isset($pending_withdrawal['id'])){ ?>
											<p>
												You already have a withdrawal request pending. If you wish to request different payout amount, cancel your existing withdrawal request and submit a new withdrawal request.
										<?php }else{ ?>
											<div class="form-group">
												<label class="col-md-2 control-label" for="amount">Amount £</label>
												<div class="col-md-10">
													<input type="text" class="form-control" id="amount" name="amount" min="<?php echo $global_settings['payout_min']; ?>" placeholder="<?php echo $global_settings['payout_min']; ?>">
													<small>Minimum withdrawal amount is £<?php echo $global_settings['payout_min']; ?></small>
												</div>
											</div>
										<?php } ?>
									</div>
								</div>
				            </div>
				            <div class="modal-footer">
				                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				                <?php if(!isset($pending_withdrawal['id'])){ ?>
				                	<button type="submit" class="btn btn-success">Submit Request</button>
				                <?php } ?>
				            </div>
				        </div>
				    </div>
				</div>
			</form>
        <?php } ?>

        <?php function marketing_tools(){ ?>
        	<?php 
        		global $conn, $globals, $global_settings, $account_details, $site;
			?>

            <div class="content-wrapper">
				
                <div id="status_message"></div>
                            	
                <section class="content-header">
                    <h1>Marketing Tools <!-- <small>Optional description</small> --></h1>
                    <ol class="breadcrumb">
                        <li><a href="dashboard.php">Dashboard</a></li>
                        <li class="active">Marketing Tools</li>
                    </ol>
                </section>

                <section class="content">
                	<?php if(empty($account_details['affiliate_username'])){ ?>
                		<div class="callout callout-danger lead"><p>You need to set your public affiliate username under <a href="dashboard.php?c=my_account">Account Settings</a></p></div>
					<?php }else{ ?>
						<div class="row">
							<div class="col-lg-6">
		                        <div class="box box-primary">
			            			<div class="box-header">
			              				<h3 class="box-title">
			              					Retail Affiliate Links
			              				</h3>
			            			</div>
									<div class="box-body">
										<p>
											These sharing options are for end user / retail customers only and redirects to the www.ublo.club website.
										</p>
										<form class="form-horizontal">
			                                <div class="form-group">
			                                    <label for="affiliate_link_1" class="col-sm-3 control-label">ublo.club</label>
			                                    <div class="col-sm-9">
			                                        <input type="text" name="affiliate_link_1" id="affiliate_link_1" class="form-control" value="https://ublo.club/aff.php?username=<?php echo $account_details['affiliate_username']; ?>">
			                                        <small></small>
			                                    </div>
			                                </div>

			                                <!--
			                                <div class="form-group">
			                                    <label for="affiliate_link_1" class="col-sm-3 control-label">Facebook</label>
			                                    <div class="col-sm-9">
			                                        <button id="btn_shareFB_retail" class="btn_shareFB"><i></i><span>Share</span></button>
			                                        <small></small>
			                                    </div>
			                                </div>

			                                <div class="form-group">
			                                    <label for="affiliate_link_1" class="col-sm-3 control-label">Twitter</label>
			                                    <div class="col-sm-9">
			                                        <button id="btn_shareTWI_retail" class="btn_shareTWI"><i></i><span>Tweet</span></button>
			                                        <small></small>
			                                    </div>
			                                </div>
			                            	-->
			                            </form>
		                            </div>
		                        </div>
		                    </div>

							<div class="col-lg-6">
		                        <div class="box box-primary">
			            			<div class="box-header">
			              				<h3 class="box-title">
			              					Business Builder Affiliate Links
			              				</h3>
			            			</div>
									<div class="box-body">
										<p>
											These sharing options are for business builder members only and redirects to the www.ukmarketingclub.com website.
										</p>
										<form action="" method="post" class="form-horizontal">
			                                <div class="form-group">
			                                    <label for="affiliate_link_2" class="col-sm-3 control-label">ukmarketingclub.com</label>
			                                    <div class="col-sm-9">
			                                        <input type="text" name="affiliate_link_2" id="affiliate_link_2" class="form-control" value="http://ukmarketingclub.com/?ref=<?php echo $account_details['affiliate_username']; ?>">
			                                        <small></small>
			                                    </div>
			                                </div>

			                                <!--
			                                <div class="form-group">
			                                    <label for="affiliate_link_1" class="col-sm-3 control-label">Facebook</label>
			                                    <div class="col-sm-9">
			                                        <button id="btn_shareFB_mlm" class="btn_shareFB"><i></i><span>Share</span></button>
			                                        <small></small>
			                                    </div>
			                                </div>

			                                <div class="form-group">
			                                    <label for="affiliate_link_1" class="col-sm-3 control-label">Twitter</label>
			                                    <div class="col-sm-9">
			                                        <button id="btn_shareTWI_mlm" class="btn_shareTWI"><i></i><span>Tweet</span></button>
			                                        <small></small>
			                                    </div>
			                                </div>
			                            	-->
			                            </form>
		                            </div>
		                        </div>
		                    </div>
		                </div>
					<?php } ?>
	            </section>
	        </div>

	        <div class="modal fade" id="modal_share_facebook" role="dialog">
			    <div class="modal-dialog modal-lg">
			        <div class="modal-content">
			            <div class="modal-header">
			                <button type="button" class="close" data-dismiss="modal">&times;</button>
			                <h4 class="modal-title">Share on Facebook</h4>
			            </div>
			            <div class="modal-body">
			                <div class="row">
						    	<div class="col-lg-12">
						    		<iframe id="share_facebook_iframe" src="" width="100%" height="150px" frameborder="0"></iframe>
								</div>
							</div>
			            </div>
			            <div class="modal-footer">
			                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			            </div>
			        </div>
			    </div>
			</div>
        <?php } ?>

        <?php function staging(){ ?>
        	<?php 
        		global $conn, $global_settings, $account_details, $site;
            ?>

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

                    <h4><strong>whmcs orders</strong></h4>
                        <?php debug(get_whmcs_orders($_SESSION['account']['id'])); ?>

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
            <strong>Copyright &copy; <?php echo date("Y", time()); ?> <a href="https://www.ubloclub.co.uk">UBlo Club</a>.</strong> All rights reserved.
        </footer>

        <!-- Create the tabs -->
        <!--
	        <aside class="control-sidebar control-sidebar-dark">
	        	<ul class="nav nav-tabs nav-justified control-sidebar-tabs">
	        		<li class="active"><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-globe"></i></a></li>
	        	</ul>
	        
				<div class="tab-content">
					<a href="index2.php" onclick="easter_egg();" class="btn btn-info btn-xs btn-flat full-width">EJECT</a>
				</div>
	      	</aside>
	      -->

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
    	function share_on_facebook(){
			var el = document.getElementById('share_facebook_iframe');
			el.src = 'https://www.facebook.com/sharer.php?u=http://www.domain.ro/url.html';
		}

		$(document).ready(function() {
			var width  = 575,
			height = 400,
			left   = ($(window).width()  - width)  / 2,
			top    = ($(window).height() - height) / 2,
			// url    = location.href,
			url_retail   	= 'https://ublo.club/aff.php?username=<?php echo $account_details['affiliate_username']; ?>&quote=<?php echo md5(time()); ?>',
			url_mlm   		= 'http://ukmarketingclub.com/?ref=<?php echo $account_details['affiliate_username']; ?>&quote=<?php echo md5(time()); ?>',
			opts   			= 'status=1' +
			',width='  + width  +
			',height=' + height +
			',top='    + top    +
			',left='   + left;

			$("#btn_shareFB_retail").click(function() {
				window.open('https://www.facebook.com/sharer/sharer.php?u='+url_retail, 
				'facebook-share-dialog', 
				opts); 
			});
			$("#btn_shareTWI_retail").click(function() {
				window.open('https://twitter.com/share?url'+url_retail+'&text=Share%20with%20twitter%20is%20so%20easy', 
				'twitter-sahre-dialog', 
				opts); 
			});

			$("#btn_shareFB_mlm").click(function() {
				window.open('https://www.facebook.com/sharer/sharer.php?u='+url_mlm, 
				'facebook-share-dialog', 
				opts); 
			});
			$("#btn_shareTWI_mlm").click(function() {
				window.open('https://twitter.com/share?url'+url_mlm+'&text=Share%20with%20twitter%20is%20so%20easy', 
				'twitter-sahre-dialog', 
				opts); 
			});
		});
	</script>

    <script>
    	function openURLInPopup(url, width, height, name) {
		    if (typeof(width) == "undefined") {
		        width = 800;
		        height = 600;
		    }
		    if (typeof(height) == "undefined") {
		        height = 600;
		    }
		    popup(url, name || 'window' + Math.floor(Math.random() * 10000 + 1), width, height, 'menubar=0,location=0,toolbar=0,status=0,scrollbars=1');
		}

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

			$(function () {
				$('#purchase_history').DataTable({
					"order": [[ 2, "desc" ]],
					"columnDefs": [{
						"targets"  : 'no-sort',
						"orderable": false,
					}],
					"language": {
						"emptyTable": "No data found."
					},
			  		"paging": true,
			  		"processing": true,
			  		"lengthChange": false,
			  		"searching": true,
			  		"ordering": true,
			  		"info": false,
			  		"autoWidth": false,
					"iDisplayLength": 10,
					search: {
					   search: '<?php if(isset($_GET['search'])) {echo $_GET['search'];} ?>'
					}
				});
		  	});

		  	$(function () {
				$('#payout_history').DataTable({
					"order": [[ 2, "desc" ]],
					"columnDefs": [{
						"targets"  : 'no-sort',
						"orderable": false,
					}],
					"language": {
						"emptyTable": "No data found."
					},
			  		"paging": true,
			  		"processing": true,
			  		"lengthChange": false,
			  		"searching": true,
			  		"ordering": true,
			  		"info": false,
			  		"autoWidth": false,
					"iDisplayLength": 10,
					search: {
					   search: '<?php if(isset($_GET['search'])) {echo $_GET['search'];} ?>'
					}
				});
		  	});
		</script>
    <?php } ?>

    <?php if(get('c') == 'members') { ?>
    	<script>
			/* Formatting function for row details - modify as you need */
			function format ( d ) {
			    // `d` is the original data object for the row
			    return '<table cellpadding="1" cellspacing="0" border="0" width="100%">'+
			        '<tr>'+
			            '<td width="150px" valign="top" class="hidden-xs">Additional Details</td>'+
			            '<td valign="top" align="left">'+
			            	'<strong>User ID:</strong> '+d.id+' <br>'+
			            	'<strong>Join Date:</strong> '+d.join_date+' <br>'+
			            '</td>'+
			        '</tr>'+
			        '<tr>'+
			            '<td width="150px" valign="top" class="hidden-xs">Contact Details</td>'+
			            '<td valign="top" align="left">'+
			            	'<strong>Email:</strong> '+d.email+' <br>'+
			            	'<strong>Tel:</strong> '+d.tel+' <br>'+
			            '</td>'+
			        '</tr>'+
			        '<tr>'+
			            '<td width="150px" valign="top" class="hidden-xs">Commissions</td>'+
			            '<td valign="top" align="left">'+
			            	'<strong>Total:</strong> £'+d.commissions.total+' <br>'+
			            	'<strong>Pending:</strong> £'+d.commissions.pending+' <br>'+
			            	'<strong>Approved:</strong> £'+d.commissions.approved+' <br>'+
			            	'<strong>Paid:</strong> £'+d.commissions.paid+' <br>'+
			            	'<strong>Rejected:</strong> £'+d.commissions.rejected+' <br>'+
			            	'<strong>Missed:</strong> £'+d.commissions.missed+' <br>'+
			            '</td>'+
			        '</tr>'+
			        '<tr>'+
			            '<td width="150px" valign="top" class="hidden-xs">Internal Notes</td>'+
			            '<td valign="top" align="left">'+d.internal_notes+'</td>'+
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
				$("#search_reset").click(function() {
					table.search("").draw();
				});

				$("#search_active").click(function() {
					table.search("Active").draw();
				});

				$("#search_suspended").click(function() {
					table.search("suspended").draw();
				});

				$("#search_terminated").click(function() {
					table.search("Terminated").draw();
				});

				$("#search_closed").click(function() {
					table.search("Closed").draw();
				});

			    var table = $('#example').DataTable( {
			        "order": [[2, 'asc']],
			        "ajax": "actions.php?a=ajax_members",
			        "iDisplayLength": 100,
			        "lengthMenu": [[10, 15, 25, 35, 50, 100, -1], [10, 15, 25, 35, 50, 100, "All"]],
			        "columnDefs": [{
						"targets"  : 'no-sort',
						"orderable": false,
					}],
					"language": {
						"emptyTable": "No members found."
					},
			        "columns": [
			            {
			                "className":      'details-control',
			                "orderable":      false,
			                "data":           "",
			                "defaultContent": ''
			            },
			            {
			            	"className":      'hidden-xs',
			            	"data": "status"
			            },
			            { "data": "full_name" },
			            {
			            	"className":      'hidden-xs',
			            	"data": "total_downline"
			            },
			            {
			            	"className":      'hidden-xs',
			            	"data": "upline"
			            },
			            {
			            	"className":      'hidden-xs',
			            	"data": "expire_date"
			            },
			            { "data": "actions" }
			        ],
			        search: {
					   search: '<?php if(isset($_GET['search'])) {echo $_GET['search'];} ?>'
					}
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

    <?php if(get('c') == 'member') { ?>
    	<script>
			/* Formatting function for row details - modify as you need */
			function format ( d ) {
			    // `d` is the original data object for the row
			    return '<table cellpadding="1" cellspacing="0" border="0" width="100%">'+
			        '<tr>'+
			            '<td width="150px" valign="top" class="hidden-xs">Additional Details</td>'+
			            '<td valign="top" align="left">'+
			            	'<strong>Commission ID:</strong> '+d.id+' <br>'+
			            	'<strong>Order ID:</strong> '+d.int_order_id+' <br>'+
			            	'<strong>Order Date:</strong> '+d.order_date+' <br>'+
			            '</td>'+
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
			    var table = $('#member_commissions').DataTable( {
			        "order": [[0, 'desc']],
			        "search": '<?php if(isset($_GET['search'])) {echo $_GET['search'];} ?>',
					"ajax": "actions.php?a=ajax_member_commissions&id=<?php echo get('id'); ?>",
			        "iDisplayLength": 100,
			        "lengthMenu": [[10, 15, 25, 35, 50, 100, -1], [10, 15, 25, 35, 50, 100, "All"]],
			        "columnDefs": [{
						"targets"  : 'no-sort',
						"orderable": false,
					}],
					"language": {
						"emptyTable": "No commissions found."
					},
			        "columns": [
			        	{
			                "className":      'details-control',
			                "orderable":      false,
			                "data":           "order_id_hidden",
			                "defaultContent": ''
			            },
			            { "data": "status" },
			            {
			            	"className":      'hidden-xs',
			            	"data": "qualified"
			            },
			            {
			            	"className":      'hidden-xs',
			            	"data": "release_date"
			            },
			            { "data": "amount" },
			            { "data": "actions" }
			        ]
			    } );

			    $("#search_pending").click(function() {
					table.search("pending").draw();
				});

				$("#search_missed").click(function() {
					table.search("missed").draw();
				});

				$("#search_paid").click(function() {
					table.search("paid").draw();
				});

				$("#search_reset").click(function() {
					table.search("").draw();
				});
			     
			    // Add event listener for opening and closing details
			    $('#member_commissions tbody').on('click', 'td.details-control', function () {
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

    <?php if(get('c') == 'products') { ?>
    	<script>
			/* Formatting function for row details - modify as you need */
			function format ( d ) {
			    // `d` is the original data object for the row
			    return '<table cellpadding="1" cellspacing="0" border="0" width="100%">'+
			        '<tr>'+
			            '<td width="150px" valign="top" class="hidden-xs">Additional Details</td>'+
			            '<td valign="top" align="left">'+
			            	'<strong>Product ID:</strong> '+d.pid+' <br>'+
			            	'<strong>Product Description:</strong> '+d.description+' <br>'+
			            '</td>'+
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
			        "ajax": "actions.php?a=ajax_products",
			        "iDisplayLength": 100,
			        "lengthMenu": [[10, 15, 25, 35, 50, 100, -1], [10, 15, 25, 35, 50, 100, "All"]],
			        "columnDefs": [{
						"targets"  : 'no-sort',
						"orderable": false,
					}],
					"language": {
						"emptyTable": "No products found."
					},
			        "columns": [
			            {
			                "className":      'details-control',
			                "orderable":      false,
			                "data":           "",
			                "defaultContent": ''
			            },
			            { "data": "category" },
			            { "data": "name" },
			            {
			            	"className":      'hidden-xs',
			            	"data": "recurring"
			            },
			            { "data": "price.monthly" },
			            { "data": "price.quarterly" },
			            { "data": "price.annually" },
			            { "data": "actions" }
			        ],
			        "order": [[1, 'asc'], [2, 'asc']]
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

    <?php if(get('c') == 'table_downline') { ?>
    	<script>
			/* Formatting function for row details - modify as you need */
			function format ( d ) {
			    // `d` is the original data object for the row
			    return d.additional_details;
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
			        "ajax": "actions.php?a=ajax_downline",
			        "iDisplayLength": 100,
			        "lengthMenu": [[10, 15, 25, 35, 50, 100, -1], [10, 15, 25, 35, 50, 100, "All"]],
			        "columnDefs": [{
						"targets"  : 'no-sort',
						"orderable": false,
					}],
					"language": {
						"emptyTable": "No members found."
					},
			        "columns": [
			            {
			                "className":      'details-control',
			                "orderable":      false,
			                "data":           null,
			                "defaultContent": ''
			            },
			            { "data": "status"},
			            { "data": "level"},
			            { "data": "account_type"},
			            { "data": "full_name" },
			            { "data": "total_downline" },
			            { "data": "upline" }
			        ],
			        "order": [[2, "asc" ], [ 3, "asc" ] , [ 4, "asc" ]]
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

    <?php if(get('c') == 'my_commissions') { ?>
    	<script>
			/* Formatting function for row details - modify as you need */
			function format ( d ) {
			    // `d` is the original data object for the row
			    return '<table cellpadding="1" cellspacing="0" border="0" width="100%">'+
			        '<tr>'+
			            '<td width="150px" valign="top" class="hidden-xs">Additional Details</td>'+
			            '<td valign="top" align="left">'+
			            	'<strong>Commission ID:</strong> '+d.id+' <br>'+
			            	'<strong>Order ID:</strong> '+d.int_order_id+' <br>'+
			            	'<strong>Order Date:</strong> '+d.order_date+' <br>'+
			            '</td>'+
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
			    var table = $('#commissions').DataTable( {
			        "ajax": "actions.php?a=ajax_commissions",
			        "order": [[0, 'desc']],
			        search: {
					   search: "<?php echo get('search'); ?>"
					},
			        "iDisplayLength": 100,
			        "lengthMenu": [[10, 15, 25, 35, 50, 100, -1], [10, 15, 25, 35, 50, 100, "All"]],
			        "columnDefs": [{
						"targets"  : 'no-sort',
						"orderable": false,
					}],
					"language": {
						"emptyTable": "No commissions found."
					},
			        "columns": [
			        	{
			                "className":      'details-control',
			                "orderable":      false,
			                "data":           "order_id_hidden",
			                "defaultContent": ''
			            },
			            { "data": "status" },
			            {
			            	"className":      'hidden-xs',
			            	"data": "qualified"
			            },
			            {
			            	"className":      'hidden-xs',
			            	"data": "order_date"
			            },
			            {
			            	"className":      'hidden-xs',
			            	"data": "release_date"
			            },
			            { "data": "amount" },
			        ]
			    } );

			    $("#search_pending").click(function() {
					table.search("pending").draw();
				});

				$("#search_approved").click(function() {
					table.search("approved").draw();
				});

				$("#search_missed").click(function() {
					table.search("missed").draw();
				});

				$("#search_rejected").click(function() {
					table.search("rejected").draw();
				});

				$("#search_paid").click(function() {
					table.search("paid").draw();
				});

				$("#search_reset").click(function() {
					table.search("").draw();
				});
			     
			    // Add event listener for opening and closing details
			    $('#commissions tbody').on('click', 'td.details-control', function () {
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

    <?php if(get('c') == 'all_commissions') { ?>
    	<script>
			/* Formatting function for row details - modify as you need */
			function format ( d ) {
			    // `d` is the original data object for the row
			    return '<table cellpadding="1" cellspacing="0" border="0" width="100%">'+
			        '<tr>'+
			            '<td width="150px" valign="top" class="hidden-xs">Additional Details</td>'+
			            '<td valign="top" align="left">'+
			            	'<strong>Commission ID:</strong> '+d.id+' <br>'+
			            	'<strong>Order ID:</strong> '+d.int_order_id+' <br>'+
			            	'<strong>Order Date:</strong> '+d.order_date+' <br>'+
			            '</td>'+
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
			    var table = $('#commissions').DataTable( {
			        "ajax": "actions.php?a=ajax_all_commissions",
			        "iDisplayLength": 100,
			        "lengthMenu": [[10, 15, 25, 35, 50, 100, -1], [10, 15, 25, 35, 50, 100, "All"]],
			        "columnDefs": [{
						"targets"  : 'no-sort',
						"orderable": false,
					}],
					"language": {
						"emptyTable": "No commissions found."
					},
			        "columns": [
			        	{
			                "className":      'details-control',
			                "orderable":      false,
			                "data":           "order_id_hidden",
			                "defaultContent": ''
			            },
			            { "data": "status" },
			            { "data": "member" },
			            {
			            	"className":      'hidden-xs',
			            	"data": "qualified"
			            },
			            {
			            	"className":      'hidden-xs',
			            	"data": "order_date"
			            },
			            {
			            	"className":      'hidden-xs',
			            	"data": "release_date"
			            },
			            { "data": "amount" },
			            { "data": "actions" },
			        ],
			        "order": [[0, 'desc']]
			    } );

			    $("#search_pending").click(function() {
					table.search("pending").draw();
				});

				$("#search_approved").click(function() {
					table.search("approved").draw();
				});

				$("#search_missed").click(function() {
					table.search("missed").draw();
				});

				$("#search_rejected").click(function() {
					table.search("rejected").draw();
				});

				$("#search_paid").click(function() {
					table.search("paid").draw();
				});

				$("#search_reset").click(function() {
					table.search("").draw();
				});
			     
			    // Add event listener for opening and closing details
			    $('#commissions tbody').on('click', 'td.details-control', function () {
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

    <?php if(get('c') == 'all_withdrawal_requests') { ?>
    	<script>
			/* Formatting function for row details - modify as you need */
			function format ( d ) {
			    // `d` is the original data object for the row
			    return '<table cellpadding="1" cellspacing="0" border="0" width="100%">'+
			        '<tr>'+
			            '<td width="150px" valign="top" class="hidden-xs">Additional Details</td>'+
			            '<td valign="top" align="left">'+
			            	'<strong>Withdrawal ID:</strong> '+d.id+' <br>'+
			            '</td>'+
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
			    var table = $('#withdrawal_requests').DataTable( {
			        "ajax": "actions.php?a=ajax_withdrawal_requests",
			        "iDisplayLength": 100,
			        "lengthMenu": [[10, 15, 25, 35, 50, 100, -1], [10, 15, 25, 35, 50, 100, "All"]],
			        "columnDefs": [{
						"targets"  : 'no-sort',
						"orderable": false,
					}],
					"language": {
						"emptyTable": "No withdrawal requests found."
					},
			        "columns": [
			        	{ "data": "id" },
			            { "data": "status" },
			            { "data": "member" },
			            {
			            	"className":      'hidden-xs',
			            	"data": "request_date"
			            },
			            { "data": "amount" },
			            { "data": "actions" },
			        ],
			        "order": [[0, 'desc']]
			    } );

			    $("#search_rejected").click(function() {
					table.search("rejected").draw();
				});

				$("#search_pending").click(function() {
					table.search("pending").draw();
				});

				$("#search_paid").click(function() {
					table.search("paid").draw();
				});

				$("#search_reset").click(function() {
					table.search("").draw();
				});

				$("#search_cancelled").click(function() {
					table.search("cancelled").draw();
				});
			     
			    // Add event listener for opening and closing details
			    $('#commissions tbody').on('click', 'td.details-control', function () {
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

    <?php if(get('c') == 'my_withdrawals') { ?>
    	<script>
			/* Formatting function for row details - modify as you need */
			function format ( d ) {
			    // `d` is the original data object for the row
			    return '<table cellpadding="1" cellspacing="0" border="0" width="100%">'+
			        '<tr>'+
			            '<td width="150px" valign="top" class="hidden-xs">Additional Details</td>'+
			            '<td valign="top" align="left">'+
			            	'<strong>Withdrawal ID:</strong> '+d.id+' <br>'+
			            '</td>'+
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
				$("#search_reset").click(function() {
					table.search("").draw();
				});

				$("#search_pending").click(function() {
					table.search("pending").draw();
				});

				$("#search_rejected").click(function() {
					table.search("rejected").draw();
				});

				$("#search_paid").click(function() {
					table.search("paid").draw();
				});

				$("#search_cancelled").click(function() {
					table.search("cancelled").draw();
				});
			     
			    var table = $('#withdrawal_requests').DataTable( {
			        "ajax": "actions.php?a=ajax_withdrawals",
			        "iDisplayLength": 100,
			        "lengthMenu": [[10, 15, 25, 35, 50, 100, -1], [10, 15, 25, 35, 50, 100, "All"]],
			        "columnDefs": [{
						"targets"  : 'no-sort',
						"orderable": false,
					}],
					"language": {
						"emptyTable": "No withdrawals found."
					},
			        "columns": [
			        	{ "data": "id" },
			            { "data": "status" },
			            {
			            	"className":      'hidden-xs',
			            	"data": "request_date"
			            },
			            {
			            	"className":      'hidden-xs',
			            	"data": "paid_date"
			            },
			            { "data": "comment" },
			            { "data": "amount" },
			            { "data": "actions" },
			        ],
			        "order": [[0, 'desc']]
			    } );

			    $("#search_rejected").click(function() {
					table.search("rejected").draw();
				});

				$("#search_pending").click(function() {
					table.search("pending").draw();
				});

				$("#search_paid").click(function() {
					table.search("paid").draw();
				});

				$("#search_reset").click(function() {
					table.search("").draw();
				});
			     
			    // Add event listener for opening and closing details
			    $('#commissions tbody').on('click', 'td.details-control', function () {
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

    <?php if($account_details['cms_terms_accepted'] == 'no'){ ?>
		<script>
			// $(window).on('load',function(){
		        // $('#modal-terms').modal({backdrop: 'static', keyboard: false});
		    // });
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