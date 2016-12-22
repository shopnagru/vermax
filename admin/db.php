<?php
//подключаемся к базе
error_reporting(0);
$host = "localhost";
$dbname = "vermax";
$user = "root";
$pas = "ПАРОЛЬ ОТ ВАШЕЙ БД";
$db = mysql_connect($host, $user, $pas);
mysql_select_db($dbname, $db);
mysql_query('SET NAMES utf8');
?>