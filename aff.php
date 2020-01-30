<?php
session_start();

// get affiliate username
$_SESSION['affiliate_username'] 		= $_GET['username'];

header("HTTP/1.1 301 Moved Permanently");
header("Location: https://ukmarketingclub.com/index.php",true,301);
?>