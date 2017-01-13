<?php
/*
* Copyright (c) 2015 ООО "НАГ"
* developer: Ivan Slyusar (xvanok@nag.ru)
* Выдача уведомлений приставке
*/

//@TODO доделать выдачу по маске

//устанавливаем заголовок
	header('Content-type: text/xml; charset=utf-8');
	echo '<?xml version="1.0" encoding="UTF-8"?>
	<notification_list>';
    /** @var array $config */
    $config = include('../../config/db.php');
    $host = explode('=', explode(';', $config['dsn'])[0])[1];
    $dbname = explode('=', explode(';', $config['dsn'])[1])[1];
    $user = $config['username'];
    $pas = $config['password'];
	$db = new mysqli($host, $user, $pas, $dbname);
	$db->set_charset("utf8");
//преобразование маски
	function ipIn($Tip, $Tnet, $Tmask) {
		$lnet = ip2long($Tnet);
		$lip = ip2long($Tip);
		$binnet = str_pad(decbin($lnet), 32, "0", STR_PAD_LEFT);
		$fPart = substr($binnet, 0, $Tmask);
		$binip = str_pad(decbin($lip), 32, "0", STR_PAD_LEFT);
		$fIp = substr($binip, 0, $Tmask);
		return(strcmp($fPart, $fIp)==0);
	}
//получаем IP пользователя
	if(!empty($_SERVER['HTTP_X_REAL_IP'])){ $ip=$_SERVER['HTTP_X_REAL_IP'];}
	else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){ $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];}
	else{ $ip=$_SERVER['REMOTE_ADDR'];}
//получаем MAC
	if(isset($_GET['mac'])){
		if($_GET['mac'] != ''){
			$mac = strtolower($_GET['mac']);
			$macor = "LOWER(mac)='".$mac."' OR";
		}
	}
//ищем уведомление по MAC или IP
	$user = $db->query("SELECT * FROM `notification` WHERE $macor `ip`='$ip' OR `all`='1'");
	while($notif = $user->fetch_assoc()){
		echo '
		   	 <notification>
		   	 	<id>'.$notif['id'].'</id>
		   	 	<time>'.$notif['date'].'</time>
				<text>'.$notif['message'].'</text>
			</notification>';
	}
	$user = $db->query("SELECT * FROM `notification`");
	$maxmask = 0;
	while ($userconf = $user->fetch_assoc()) {
		$confIp = $userconf['ip'];
		list($net, $mask) = explode("/", $confIp);
		if(!empty($mask)){
			if(ipIn($ip, $net, $mask)){
				if($mask == 32){
					echo '
					   	 <notification>
					   	 	<id>'.$userconf['id'].'</id>
					   	 	<time>'.$userconf['date'].'</time>
							<text>'.$userconf['message'].'</text>
						</notification>';
				}
				else if($mask > $maxmask){
					$maxmask = $mask;
					echo '
					   	 <notification>
					   	 	<id>'.$userconf['id'].'</id>
					   	 	<time>'.$userconf['date'].'</time>
							<text>'.$userconf['message'].'</text>
						</notification>';					
				}
				else{}
			}
			else if(empty($name)){
				$name = '';
			}
			else{}
		}
		else if(empty($name)){
			$name = '';
		}
		else{}
	}

	echo '</notification_list>';
