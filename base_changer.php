<?php
//error_reporting(0);
include('config/config.php');
$host = $config['host'];
$dbname = $config['dbname'];
$user = $config['dbuser'];
$pas = $config['dbpass'];
try{
	$mysqli = new mysqli($host, $user, $pas, $dbname);
}catch(Exception $e){
	echo "Не удалось подключится к базе:\r\n";
	var_dump($e); die();
}
$mysqli->set_charset("utf8");


