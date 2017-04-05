<?php
/*
* Copyright (c) 2015 ООО "НАГ"
*/
if(isset($_GET['type'])){
	$t = $_GET['type'];
	if($t == 'conf'){$tb = 'configs'; $pr = 'conf'; $msg = 'Запрос конфигурации';}
	else if($t == 'update'){$tb = 'updates'; $pr = 'upd'; $msg = 'Запрос обновления ПО';}
	else if($t == 'settings'){$tb = 'settings'; $pr = 'sett'; $msg = 'Запрос настроек';}
	else if($t == 'fwupdate'){$tb = 'fwupdates'; $pr = 'fwup'; $msg = 'Запрос прошивки';}
	else{die();}
//устанавливаем заголовок
	if($t == 'fwupdate'){header('Content-type: text/xml; charset=utf-8');}
	else{header('Content-type: text/plain; charset=utf-8');	}
	include(getcwd()."/admin/db.php");
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
    $mac = '';
	$macor = '';
	$version = '';
	if(isset($_GET['mac'])){
		if($_GET['mac'] != ''){
			$mac = strtolower($_GET['mac']);
			$macor = "LOWER(mac)='".$mac."' OR";
		}
	}
//получаем версию ПО
	if(isset($_GET['version'])){
		$version = $_GET['version'];
	}
//ищем конфиг по MAC или IP
	$user = mysqli_query($db, "SELECT * FROM `confToIp` WHERE $macor ip='$ip'");
	$userconf = mysqli_fetch_array($user);
	if(!empty($userconf[$t])){
		$name = $userconf[$t];
	}
//иначе ищем конфиг по маске
	else{
		$user = mysqli_query($db, "SELECT * FROM `confToIp`");
		$maxmask = 0;
		while ($userconf = mysqli_fetch_assoc($user)) {
			$confIp = $userconf['ip'];
			list($net, $mask) = explode("/", $confIp);
			if(!empty($mask)){
				if(ipIn($ip, $net, $mask)){
					if($mask == 32){
						$name = $userconf[$t];
						break;
					}
					else if($mask > $maxmask){
						$maxmask = $mask;
						$name = $userconf[$t];					
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
	}
//если ничего не нашли - дефолтный конфиг
	if(empty($name)){ $wherename = "name='default'"; $name='default';}
//иначе конфиг пользователя
	else{ $wherename = "name='".$name."'";}
//отдаем конфиг
	$confinfo = mysqli_query($db, "SELECT * FROM `$tb` WHERE $wherename");
	$conf = mysqli_fetch_array($confinfo);
	echo $conf[$pr];
//логируем запрос в базу
	mysqli_query($db, "INSERT INTO `requests` (ip, mac, version, type, response) VALUES ('$ip', '$mac', '$version', '$msg', '$name')");
}
