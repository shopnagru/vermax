<?php
//подключаемся к базе
error_reporting(0);
$host = "localhost";
$dbname = "vermax";
$user = "root";
$pas = "ПАРОЛЬ ОТ ВАШЕЙ БД";
$db = mysqli_connect($host, $user, $pas, $dbname);
mysqli_query($db, 'SET NAMES utf8');