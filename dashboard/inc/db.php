<?php

$host			= '167.172.60.74';
$db 			= 'dashboard';
$username 		= 'ublo';
$password 		= 'admin1372Dextor!#&@Mimi!#&@';

$dsn			= "mysql:host=$host;dbname=$db";

try{
	$conn = new PDO($dsn, $username, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch (PDOException $e){
	echo $e->getMessage();
}