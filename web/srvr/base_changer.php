<?php
error_reporting(E_ALL ^ E_WARNING);
//error_reporting(0);
echo "Приступаем к обновлению базы данных...\r\n";
/** @var array $config */
$config = include('config/db.php');
$host = explode('=', explode(';', $config['dsn'])[0])[1];
$db_name = explode('=', explode(';', $config['dsn'])[1])[1];
$user = $config['username'];
$pas = $config['password'];
try{
	$mysqli = new mysqli($host, $user, $pas, $db_name);
}catch(Exception $e){
	echo "Не удалось подключится к базе!\r\n";
	var_dump($e); die();
}
$mysqli->set_charset("utf8");

echo "Делаем дамп... ";
//dump
try {
    if(!file_exists('dumps')){
        mkdir('dumps', 0700);
    }
    $dump_date = date('_Ymdhis');
    shell_exec('nohup sh dump.sh '.$host.' '.$user.' '.$pas.' '.$db_name.' '.$dump_date);
    if(file_exists('dumps/' .$db_name. $dump_date . '.sql')){
        if(filesize('dumps/' .$db_name. $dump_date . '.sql')) {
            echo "Дамп создан...";
        }
        else{
            throw new Exception('Дамп пуст');
        }
    }
    else{
        throw new Exception('Дамп не создан');
    }
}catch (Exception $e){
    echo "Ошибка \"".$e->getMessage()."\" в строке ".$e->getLine()." в файле ".$e->getFile()."\r\nTrace:\r\n";
    var_dump($e->getTrace()); die();
}
echo "Готово\r\n";


try{
    $mysqli = new mysqli($host, $user, $pas, $db_name);
}catch(Exception $e){
    echo "Не удалось подключится к базе!\r\n";
    var_dump($e); die();
}
$mysqli->set_charset("utf8");

/**
 * Выполняем SQL запрос
 * @param mysqli $mysqli
 * @param string $query
 */
function executeSql($mysqli, $query){
    try {
        if($mysqli->multi_query($query)){
            do{
                if($result = $mysqli->store_result()){
                    $result->free();
                }
            } while($mysqli->more_results() && $mysqli->next_result());
        }
    }catch (Exception $e){
        var_dump($e); die();
    }
}

$files = scandir('db_updates');
if(file_exists('db_updates/before.sql')){
    echo "Переименовываем таблицы... ";
    $file_content = file_get_contents('db_updates/before.sql');
    executeSql($mysqli, $file_content);
    echo "Готово\r\n";
}
echo "Создаем новые таблицы... ";
foreach ($files as $file){
    if(!in_array($file, array(".", "..", "before.sql", "after.sql"))) {
        $file_content = file_get_contents('db_updates/'.$file);
        executeSql($mysqli, $file_content);
    }
}
echo "Готово\r\n";
// move data
try{
    $confToIps = $mysqli->query('SELECT * FROM `confToIp`');
    echo "Обновляем конфиги... ";
    while ($confToIp = $confToIps->fetch_assoc()){
        // config
        $default = '';
        if($confToIp['conf'] == 'default'){
            $q = $mysqli->query('SELECT * FROM `configs` WHERE name="config_default" AND type="config" LIMIT 1');
            $default = 'config_';
        }
        else{ $q = $mysqli->query('SELECT * FROM `configs` WHERE name="'.$confToIp['conf'].'" AND type="config" LIMIT 1'); }

        if(!$q || $q->num_rows == 0){
            $q = $mysqli->query('SELECT * FROM `configs_old` WHERE name="'.$confToIp['conf'].'" LIMIT 1');
            $bstr = array();
            if(!$q || $q->num_rows == 0){
                $conf_desc = '';
            }
            else{
                $con = $q->fetch_assoc();
                $conf_desc = $con['descript'];
                $bstr = explode("\n", str_replace("\r", "", $con['conf']));
            }
            $mysqli->query('INSERT INTO `configs` (name, description, type) VALUES ("'.$default.$confToIp['conf'].'", "'.$conf_desc.'", "config")');
            $cid = $mysqli->insert_id;
            foreach($bstr as $str){
                if($str != ""){
                    if(substr($str, 0, 1) === '#'){}
                    else{
                        $par = explode("=", $str);
                        $mysqli->query('INSERT INTO `params` (conf, name, value) VALUES ("'.$cid.'", "'.$par[0].'", "'.$par[1].'")');
                    }
                }
            }
        }
        else{
            $con = $q->fetch_assoc();
            $cid = $con['id'];

            $q = $mysqli->query('SELECT * FROM `params` WHERE `conf`='.$cid.' LIMIT 1');
            if($q->num_rows == 0) {
                $q = $mysqli->query('SELECT * FROM `configs_old` WHERE name="' . $confToIp['conf'] . '" LIMIT 1');
                $bstr = array();
                if ($q->num_rows != 0) {
                    $con = $q->fetch_assoc();
                    $bstr = explode("\n", str_replace("\r", "", $con['conf']));
                }
                foreach ($bstr as $str) {
                    if ($str != "") {
                        if (substr($str, 0, 1) === '#') {
                        } else {
                            $par = explode("=", $str);
                            $mysqli->query('INSERT INTO `params` (conf, name, value) VALUES ("' . $cid . '", "' . $par[0] . '", "' . $par[1] . '")');
                        }
                    }
                }
            }
        }
        // end config

        // update
        $default = '';
        if($confToIp['update'] == 'default'){
            $q = $mysqli->query('SELECT * FROM `configs` WHERE name="update_default" AND type="update" LIMIT 1');
            $default = 'update_';
        }
        else{ $q = $mysqli->query('SELECT * FROM `configs` WHERE name="'.$confToIp['update'].'" AND type="update" LIMIT 1'); }

        if(!$q || $q->num_rows == 0){
            $q = $mysqli->query('SELECT * FROM `updates` WHERE name="'.$confToIp['update'].'" LIMIT 1');
            $bstr = array();
            if(!$q || $q->num_rows == 0){
                $conf_desc = '';
            }
            else{
                $con = $q->fetch_assoc();
                $conf_desc = $con['descript'];
                $bstr = explode("\n", str_replace("\r", "", $con['upd']));
            }
            $mysqli->query('INSERT INTO `configs` (name, description, type) VALUES ("'.$default.$confToIp['update'].'", "'.$conf_desc.'", "update")');
            $uid = $mysqli->insert_id;
            foreach($bstr as $str){
                if($str != ""){
                    if(substr($str, 0, 1) === '#'){}
                    else{
                        $par = explode("=", $str);
                        $mysqli->query('INSERT INTO `params` (conf, name, value) VALUES ("'.$uid.'", "'.$par[0].'", "'.$par[1].'")');
                    }
                }
            }
        }
        else{
            $con = $q->fetch_assoc();
            $uid = $con['id'];

            $q = $mysqli->query('SELECT * FROM `params` WHERE `conf`='.$uid.' LIMIT 1');
            if($q->num_rows == 0) {
                $q = $mysqli->query('SELECT * FROM `updates` WHERE name="' . $confToIp['update'] . '" LIMIT 1');
                $bstr = array();
                if ($q->num_rows != 0) {
                    $con = $q->fetch_assoc();
                    $bstr = explode("\n", str_replace("\r", "", $con['upd']));
                }
                foreach ($bstr as $str) {
                    if ($str != "") {
                        if (substr($str, 0, 1) === '#') {
                        } else {
                            $par = explode("=", $str);
                            $mysqli->query('INSERT INTO `params` (conf, name, value) VALUES ("' . $uid . '", "' . $par[0] . '", "' . $par[1] . '")');
                        }
                    }
                }
            }
        }
        // end update

        // setting
        $default = '';
        if($confToIp['settings'] == 'default'){
            $q = $mysqli->query('SELECT * FROM `configs` WHERE name="setting_default" AND type="setting" LIMIT 1');
            $default = 'setting_';
        }
        else{ $q = $mysqli->query('SELECT * FROM `configs` WHERE name="'.$confToIp['settings'].'" AND type="setting" LIMIT 1'); }

        if(!$q || $q->num_rows == 0){
            $q = $mysqli->query('SELECT * FROM `settings` WHERE name="'.$confToIp['settings'].'" LIMIT 1');
            $bstr = array();
            if(!$q || $q->num_rows == 0){
                $conf_desc = '';
            }
            else{
                $con = $q->fetch_assoc();
                $conf_desc = $con['descript'];
                $bstr = json_decode(json_encode(simplexml_load_string($con['sett'])), true);
            }
            $mysqli->query('INSERT INTO `configs` (name, description, type) VALUES ("'.$default.$confToIp['settings'].'", "'.$conf_desc.'", "setting")');
            $sid = $mysqli->insert_id;
            foreach($bstr as $key => $val){
                $mysqli->query('INSERT INTO `params` (conf, name, value) VALUES ("'.$sid.'", "'.$key.'", "'.$val.'")');
            }
        }
        else{
            $con = $q->fetch_assoc();
            $sid = $con['id'];

            $q = $mysqli->query('SELECT * FROM `params` WHERE `conf`='.$sid.' LIMIT 1');
            if($q->num_rows == 0) {
                $q = $mysqli->query('SELECT * FROM `settings` WHERE name="' . $confToIp['settings'] . '" LIMIT 1');
                $bstr = array();
                if ($q->num_rows != 0) {
                    $con = $q->fetch_assoc();
                    $bstr = json_decode(json_encode(simplexml_load_string($con['sett'])), true);
                }
                foreach ($bstr as $key => $val) {
                    $mysqli->query('INSERT INTO `params` (conf, name, value) VALUES ("'.$sid.'", "'.$key.'", "'.$val.'")');
                }
            }
        }
        // end setting

        // fwupdate
        $default = '';
        if($confToIp['fwupdate'] == 'default') {
            $q = $mysqli->query('SELECT * FROM `configs` WHERE name="firmware_default" AND type="firmware" LIMIT 1');
            $default = 'firmware_';
        }
        else{ $q = $mysqli->query('SELECT * FROM `configs` WHERE name="'.$confToIp['fwupdate'].'" AND type="firmware" LIMIT 1'); }

        if(!$q || $q->num_rows == 0){
            $q = $mysqli->query('SELECT * FROM `fwupdates` WHERE name="'.$confToIp['fwupdate'].'" LIMIT 1');
            $bstr = array();
            if(!$q || $q->num_rows == 0){
                $conf_desc = '';
            }
            else{
                $con = $q->fetch_assoc();
                $conf_desc = $con['descript'];
                $bstr = json_decode(json_encode(simplexml_load_string($con['fwup'])), true);
            }
            $mysqli->query('INSERT INTO `configs` (name, description, type) VALUES ("'.$default.$confToIp['fwupdate'].'", "'.$conf_desc.'", "firmware")');
            $fid = $mysqli->insert_id;
            foreach($bstr as $key => $val){
                $mysqli->query('INSERT INTO `params` (conf, name, value) VALUES ("'.$fid.'", "'.$key.'", "'.$val.'")');
            }
        }
        else{
            $con = $q->fetch_assoc();
            $fid = $con['id'];

            $q = $mysqli->query('SELECT * FROM `params` WHERE `conf`='.$fid.' LIMIT 1');
            if($q->num_rows == 0) {
                $q = $mysqli->query('SELECT * FROM `fwupdates` WHERE name="' . $confToIp['fwupdate'] . '" LIMIT 1');
                $bstr = array();
                if ($q->num_rows != 0) {
                    $con = $q->fetch_assoc();
                    $bstr = json_decode(json_encode(simplexml_load_string($con['fwup'])), true);
                }
                foreach ($bstr as $key => $val) {
                    $mysqli->query('INSERT INTO `params` (conf, name, value) VALUES ("'.$fid.'", "'.$key.'", "'.$val.'")');
                }
            }
        }
        // end fwupdate

        // fwupdate uhd200
        $default = '';
        if($confToIp['fwupdate_uhd200'] == 'default'){
            $q = $mysqli->query('SELECT * FROM `configs` WHERE name="UHD200_firmware_default" AND type="firmware" LIMIT 1');
            $default = 'UHD200_firmware_';
        }
        else{ $q = $mysqli->query('SELECT * FROM `configs` WHERE name="'.$confToIp['fwupdate_uhd200'].'" AND type="firmware" LIMIT 1'); }

        if(!$q || $q->num_rows == 0){
            $q = $mysqli->query('SELECT * FROM `fwupdates` WHERE name="'.$confToIp['fwupdate_uhd200'].'" LIMIT 1');
            $bstr = array();
            if(!$q || $q->num_rows == 0){
                $conf_desc = '';
            }
            else{
                $con = $q->fetch_assoc();
                $conf_desc = $con['descript'];
                $bstr = json_decode(json_encode(simplexml_load_string($con['fwup'])), true);
            }
            $mysqli->query('INSERT INTO `configs` (name, description, type) VALUES ("'.$default.$confToIp['fwupdate_uhd200'].'", "'.$conf_desc.'", "firmware")');
            $f2id = $mysqli->insert_id;
            foreach($bstr as $key => $val){
                $mysqli->query('INSERT INTO `params` (conf, name, value) VALUES ("'.$f2id.'", "'.$key.'", "'.$val.'")');
            }
        }
        else{
            $con = $q->fetch_assoc();
            $f2id = $con['id'];
            $q = $mysqli->query('SELECT * FROM `params` WHERE `conf`='.$f2id.' LIMIT 1');
            if($q->num_rows == 0) {
                $q = $mysqli->query('SELECT * FROM `fwupdates` WHERE name="' . $confToIp['fwupdate_uhd200'] . '" LIMIT 1');
                $bstr = array();
                if ($q->num_rows != 0) {
                    $con = $q->fetch_assoc();
                    $bstr = json_decode(json_encode(simplexml_load_string($con['fwup'])), true);
                }
                foreach ($bstr as $key => $val) {
                    $mysqli->query('INSERT INTO `params` (conf, name, value) VALUES ("'.$f2id.'", "'.$key.'", "'.$val.'")');
                }
            }
        }
        // end fwupdate uhd200

        if(!empty($confToIp['descript'])){
            $username = $confToIp['descript'].'_'.(!empty($confToIp['ip']) ? $confToIp['ip'] : $confToIp['mac']);
        }
        else{
            $username = 'user_'.(!empty($confToIp['ip']) ? $confToIp['ip'] : $confToIp['mac']);
        }
        $mysqli->query('INSERT INTO `clients` (`name`, `mac`, `ip`, `conf`, `setting`, `update`, `firmware`) VALUES ("'.$username.'", "'.$confToIp['mac'].'", "'.$confToIp['ip'].'", "'.$cid.'", "'.$sid.'", "'.$uid. '", "'.$fid.'")');
    }
    echo "Готово\r\n";
}catch (Exception $e){
    var_dump($e); die();
}

echo "Обновляем таблицу менеджеров... ";
$mngrs = $mysqli->query("SELECT * FROM `managers_old`");
if($mngrs->num_rows != 0){
    while($manager = $mngrs->fetch_assoc()){
        $mysqli->query('INSERT INTO `managers` (`username`, `password`, `group`, `provider`) VALUES ("'.$manager['user'].'", "'.$manager['password'].'", "'.$manager['group'].'", "provider")');
    }
}
echo "Готово\r\n";

echo "Обновляем статистику... ";
$stats_alpha = $mysqli->query("SELECT * FROM `stats_alpha`");
if($stats_alpha->num_rows != 0){
    while ($alpha = $stats_alpha->fetch_assoc()){
        $json = json_decode($alpha['textplain']);
        $mysqli->query('INSERT INTO `stat` (`textplain`, `date`, `mac`, `ip`, `type`, `send_date`, `stat_id`, `details`, `url`, `channel`, `time`, `what`, `extra`, `status`, `switch_count`) VALUES (\''.$alpha['textplain'].'\', "'.$alpha['date'].'", "'.$alpha['mac'].'", "'.$alpha['ip'].'", "'.(isset($json->type)? $json->type : '').'", "'.(isset($json->date) ? $json->date : '').'", "'.(isset($json->id) ? $json->id : '').'", "'.(isset($json->details) ? $json->details : '').'", "'.(isset($json->url) ? $json->url : '').'", "'.(isset($json->channel) ? $json->channel : '').'", "'.(isset($json->time) ? $json->time : '').'", "'.(isset($json->what) ? $json->what : '').'", "'.(isset($json->extra) ? $json->extra : '').'", "'.(isset($json->status) ? $json->status : '').'", "'.(isset($json->switch_count) ? $json->switch_count : '').'")');
    }
}
echo "Готово\r\n";

// remove tables
if(file_exists('db_updates/after.sql')){
    echo "Удаляем таблицы... ";
    $file_content = file_get_contents('db_updates/after.sql');
    executeSql($mysqli, $file_content);
    echo "Готово\r\n";
}


