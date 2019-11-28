<?php

$host			= '64.62.133.56';
$db 			= 'ubloclub_dashboard';
$username 		= 'ubloclub';
$password 		= 'admin1372admin1372';

$dsn			= "mysql:host=$host;dbname=$db";

try{
	$conn = new PDO($dsn, $username, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch (PDOException $e){
	echo $e->getMessage();
}