<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

if(isset($_GET['type'])){
	$t = $_GET['type'];
	$short = $t;
	switch($t){
		case 'config':
			$short = 'conf';
			$msg = 'Запрос конфигурации';
			break;
		case 'update':
			$msg = 'Запрос обновления ПО';
			break;
		case 'setting': 
			$msg = 'Запрос настроек';
			break;
		case 'firmware':
			$msg = 'Запрос прошивки';
			if(isset($_GET['model'])){
				$model = $_GET['model'];
			}
			break;
		default:
			die();
	}
	//Указываем заголовки
	if($t == 'firmware'){header('Content-type: text/xml; charset=utf-8');}
	else{header('Content-type: text/plain; charset=utf-8');	}
	error_reporting(0);
	//Подключаем базу
	$config = include('../../config/db.php');
    $host = explode('=', explode(';', $config['dsn'])[0])[1];
    $dbname = explode('=', explode(';', $config['dsn'])[1])[1];
    $user = $config['username'];
    $pas = $config['password'];
	$db = new mysqli($host, $user, $pas, $dbname);
	$db->set_charset("utf8");
	
	function ipIn($Tip, $Tnet, $Tmask) {
		$lnet = ip2long($Tnet);
		$lip = ip2long($Tip);
		$binnet = str_pad(decbin($lnet), 32, "0", STR_PAD_LEFT);
		$fPart = substr($binnet, 0, $Tmask);
		$binip = str_pad(decbin($lip), 32, "0", STR_PAD_LEFT);
		$fIp = substr($binip, 0, $Tmask);
		return(strcmp($fPart, $fIp)==0);
	}
	//Определяем IP клиента
	if(!empty($_SERVER['HTTP_X_REAL_IP'])){ $ip=$_SERVER['HTTP_X_REAL_IP'];}
	else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){ $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];}
	else{ $ip=$_SERVER['REMOTE_ADDR'];}
	//Получаем MAC от приставки
	$mac = '';
	if(isset($_GET['mac'])){
		if($_GET['mac'] != ''){
			$mac = strtolower($_GET['mac']);
			$macor = "LOWER(mac)='".$mac."' OR";
		}
	}
	//Получаем от приставки версию ПО
	if(isset($_GET['version'])){
		$version = $_GET['version'];
	}
	//Ищем пользователя по MAC или IP
	$query = 'SELECT * FROM `clients` WHERE '.$macor.' ip="'.$ip.'" LIMIT 1';

	$result = $db->query($query);
	if($result){
		if($result->num_rows == 0){
			$result = false;
		}
	}

	if($result) {
		$user = $result->fetch_assoc();
		$conf_id = $user[$short];
	}
	else{ //Если не нашли - ищем по маске
		$query = 'SELECT * FROM `clients`';
		$result = $db->query($query);

		if($result) {
			$maxmask = 0;
			while ($user = $result->fetch_assoc()) {
				$confIp = $user['ip'];
				if(strpos($confIp, '/') !== false) {
					list($net, $mask) = explode("/", $confIp);
					if (!empty($mask)) {
						if (ipIn($ip, $net, $mask)) {
							if ($mask == 32) {
								$conf_id = $user[$short];
								break;
							} else if ($mask > $maxmask) {
								$maxmask = $mask;
								$conf_id = $user[$short];
							}
						}
					}
				}
			}
		}
	}

	//Если пользователя нет в базе - добавляем
	if(empty($conf_id)){
		if($t == 'firmware'){
			switch($model){
				case 'HD100':
					$conf_id = 4;
					break;
				case 'UHD200':
					$defdevq = 'SELECT * FROM `configs` WHERE name="UHD200_default" LIMIT 1';
					$defdev = $db->query($defdevq);
					$defdev = $defdev->fetch_assoc();
					$conf_id = $defdev['id'];
					break;
				default:
					$conf_id = 4;
					break;
			}
			$query = 'INSERT INTO `clients` (`name`, `mac`, `ip`, `conf`, `setting`, `update`, `firmware`) VALUES ("user_' . $ip . '", "' . $mac . '", "' . $ip . '", "1", "2", "3", "'.$conf_id.'");';
		}
		else{
			$query = 'INSERT INTO `clients` (`name`, `mac`, `ip`, `conf`, `setting`, `update`, `firmware`) VALUES ("user_' . $ip . '", "' . $mac . '", "' . $ip . '", "1", "2", "3", "4");';
			$conf_id = 1;
		}
		$db->query($query);
	}
	else{
		if($t == 'firmware' && $model == 'UHD200'){
			$query = 'SELECT * FROM `configs` WHERE id='.$conf_id.' LIMIT 1';
			$result = $db->query($query);
			$result = $result->fetch_assoc();
			$conf_res = $result['name'];
			$conf_ar = explode('_', $conf_res);
			if(count($conf_ar) > 1){
				if($conf_ar[0] != 'UHD200'){
					$query = 'SELECT * FROM `configs` WHERE name="UHD200_'.$conf_res.'" Limit 1';
					$result = $db->query($query);
					$result = $result->fetch_assoc();
					if(empty($result)){
						$defdevq = 'SELECT * FROM `configs` WHERE name="UHD200_default" LIMIT 1';
						$defdev = $db->query($defdevq);
						$defdev = $defdev->fetch_assoc();
						$conf_id = $defdev['id'];
					}
					else{
						$conf_id = $result['id'];
					}
				}
			}
			else{
				$query = 'SELECT * FROM `configs` WHERE name="UHD200_'.$conf_res.'" Limit 1';
				$result = $db->query($query);
				$result = $result->fetch_assoc();
				if(empty($result)){
					$defdevq = 'SELECT * FROM `configs` WHERE name="UHD200_default" LIMIT 1';
					$defdev = $db->query($defdevq);
					$defdev = $defdev->fetch_assoc();
					$conf_id = $defdev['id'];
				}
				else{
					$conf_id = $result['id'];
				}
			}
		}
	}
//Получаем параметры конфигурации
	$print_conf = '';
	$where = "conf='".$conf_id."'";
	$query = 'SELECT * FROM `params` WHERE '.$where;
	$result = $db->query($query);
	if($result) {
		while($conf = $result->fetch_assoc()){
			switch($t){
				case 'config':
					$print_conf .= $conf['name'] . "=" . $conf['value'] . "\r\n";
					break;
				case 'update':
					$print_conf .= $conf['name'] . "=" . $conf['value'] . "\r\n";
					break;
				default:
					if(!empty($conf['name'])){
						$print_conf .= "<" . $conf['name'] . ">" . $conf['value'] . "</" . $conf['name'] . ">\r\n";
					}
					break;
			}
		}
	}
	switch($t){
		case 'firmware':
			echo  "<update>\r\n".$print_conf."</update>";
			break;
		case 'setting':
			echo "<config>\r\n".$print_conf."</config>";
			break;
		default:
			echo $print_conf;
			break;		
	}
	
//Сохраняем лог запрос и ответ
	$db->query("INSERT INTO `requests_monitor` (ip, mac, version, type, response) VALUES ('$ip', '$mac', '$version', '$msg', '$print_conf')");
}
?>
