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
//переименовываем старые таблицы

//создаем таблицы
try{
	$q = 'SELECT * FROM `confToIp`';
	$result = $mysqli->query($q);
	while($cti = $result->fetch_assoc()){
		var_dump($cti['conf']);
		$q = "SELECT * FROM `configs` WHERE name='".$cti['conf']."' LIMIT 1";
		$r = $mysqli->query($q);
		if(!$r || $r->num_rows == 0){
			$q = "INSERT INTO `configs` (name) VALUES ('".$cti['conf']."')";
			$mysqli->query($q);
			$cid = $mysqli->insert_id;
			$q = "SELECT * FROM `configs_old` WHERE name='".$cti['conf']."' LIMIT 1";
			var_dump($q);
			$r = $mysqli->query($q);
			$r = $r->fetch_assoc();
			$bstr = explode("\n", str_replace("\r", "", $r['conf']));
			foreach($bstr as $str){
				if($str != ""){
					if(substr($str, 0, 1) === '#'){}
					else{
						$par = explode("=", $str);
						$q = "INSERT INTO `params` (conf, conf_type, name, value) VALUES ('".$cid."', 'config', '".$par[0]."', '".$par[1]."')";
						$mysqli->query($q);
					}
				}
			}
		}
		else{
			$con = $r->fetch_assoc();
			$cid = $con['id'];
		}
		$q = "SELECT * FROM `settings` WHERE name='".$cti['settings']."' LIMIT 1";
		$r = $mysqli->query($q);
		if(!$r || $r->num_rows == 0){
			$q = "INSERT INTO `settings` (name) VALUES ('".$cti['settings']."')";
			$mysqli->query($q);
			$sid = $mysqli->insert_id;
			$q = "SELECT * FROM `settings_old` WHERE name='".$cti['settings']."' LIMIT 1";
			$r = $mysqli->query($q);
			if($r){
				if($r->num_rows != 0){
					$r = $r->fetch_assoc();
					$ar = json_decode(json_encode(simplexml_load_string($r['sett'])), true);
					foreach($ar as $key => $val) {
						$q = "INSERT INTO `params` (conf, conf_type, name, value) VALUES ('" . $sid . "', 'setting', '" . $key . "', '" . $val . "')";
						$mysqli->query($q);
					}
				}
			}
		}
		else{
			$con = $r->fetch_assoc();
			$sid = $con['id'];
		}
		$q = "SELECT * FROM `updates` WHERE name='".$cti['update']."' LIMIT 1";
		$r = $mysqli->query($q);
		if(!$r || $r->num_rows == 0){
			$q = "INSERT INTO `updates` (name) VALUES ('".$cti['update']."')";
			$mysqli->query($q);
			$uid = $mysqli->insert_id;
			$q = "SELECT * FROM `updates_old` WHERE name='".$cti['update']."' LIMIT 1";
			$r = $mysqli->query($q);
			$r = $r->fetch_assoc();
			$bstr = explode("\n", str_replace("\r", "", $r['upd']));
			foreach($bstr as $str){
				if($str != ""){
					if(substr($str, 0, 1) === '#'){}
					else{
						$par = explode("=", $str);
						$q = "INSERT INTO `params` (conf, conf_type, name, value) VALUES ('".$uid."', 'update', '".$par[0]."', '".$par[1]."')";
						$mysqli->query($q);
					}
				}
			}
		}
		else{
			$con = $r->fetch_assoc();
			$uid = $con['id'];
		}
		$q = "SELECT * FROM `firmwares` WHERE name='".$cti['fwupdate']."' LIMIT 1";
		$r = $mysqli->query($q);
		if(!$r || $r->num_rows == 0){
			$q = "INSERT INTO `firmwares` (name) VALUES ('".$cti['fwupdate']."')";
			$mysqli->query($q);
			$fid = $mysqli->insert_id;
			$q = "SELECT * FROM `fwupdates` WHERE name='".$cti['fwupdate']."' LIMIT 1";
			$r = $mysqli->query($q);
			if($r){
				if($r->num_rows != 0){
					$r = $r->fetch_assoc();
					$ar = json_decode(json_encode(simplexml_load_string($r['fwup']), 1));
					foreach($ar as $key => $val) {
						$q = "INSERT INTO `params` (conf, conf_type, name, value) VALUES ('" . $fid . "', 'firmware', '" . $key . "', '" . $val . "')";
						$mysqli->query($q);
					}
				}
			}
		}
		else{
			$con = $r->fetch_assoc();
			$fid = $con['id'];
		}
		$q = "INSERT INTO `clients` (name, mac, ip, conf, setting, `update`, firmware) VALUES ('user_".$cti['ip']."', '".$cti['mac']."', '".$cti['ip']."', '".$cid."', '".$sid."', '".$uid."', '".$fid."')";
		$mysqli->query($q);
	}
}catch(Exception $e){
	echo ":\r\n";
	var_dump($e); die();
}

try{	
	$q = 'DROP TABLE `configs_old`';
	$mysqli->query($q);
}
catch (Exception $e){
	echo ":\r\n";
	var_dump($e); die();
}

try{
	$q = 'DROP TABLE `settings_old`';
	$mysqli->query($q);
}
catch (Exception $e){
	echo ":\r\n";
	var_dump($e); die();
}

try{
	$q = 'DROP TABLE `updates_old`';
	$mysqli->query($q);
}
catch (Exception $e){
	echo ":\r\n";
	var_dump($e); die();
}

try{
	$q = 'DROP TABLE `confToIp`';
	$mysqli->query($q);
}
catch (Exception $e){
	echo ":\r\n";
	var_dump($e); die();
}
