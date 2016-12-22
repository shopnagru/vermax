<?php

//устанавливаем заголовок
header('Content-type: application/json; charset=utf-8');
//

include('config/config.php');
$host = $config['host'];
$dbname = $config['dbname'];
$user = $config['dbuser'];
$pas = $config['dbpass'];
$db = new mysqli($host, $user, $pas, $dbname);
$db->set_charset("utf8");
	
//получаем IP пользователя
if(!empty($_SERVER['HTTP_X_REAL_IP'])){ $ip=$_SERVER['HTTP_X_REAL_IP'];}
else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){ $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];}
else{ $ip=$_SERVER['REMOTE_ADDR'];}

$json = file_get_contents('php://input');
$obj = json_decode($json);
var_dump($obj);
$mac = $obj->mac;
$events = $obj->events;
foreach($events as $event){
    $body = json_encode($event);
    $db->query("INSERT INTO `stat` (`textplain`, `date`, `mac`, `ip`, `type`, `send_date`, `stat_id`, `details`, `url`, `channel`, `time`, `what`, `extra`, `status`, `switch_count`) VALUES ('".$body."', CURRENT_TIMESTAMP, '".$mac."', '".$ip."', '".$event->type."', '".$event->date."', '".$event->id."', '".$event->details."', '".$event->url."', '".$event->channel."', '".$event->time."', '".$event->what."', '".$event->extra."', '".$event->status."', '".$event->switch_count."');");
}
