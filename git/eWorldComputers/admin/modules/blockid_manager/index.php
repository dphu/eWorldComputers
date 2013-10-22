<?php if(!defined('IN_SYSTEM')) die('Acces Denied!');

require_once 'configs/config.cfg.php';
require_once 'global/editanydata/myclassmanager.class.php';

$obj = new MYCLASS($db);

if(!method_exists($obj, $function)) {
	$function = 'edit';
}

$obj->$function();

unset($obj);
?>