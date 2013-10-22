<?php if(!defined('IN_SYSTEM')) die('Acces Denied!');

require_once 'configs/config.cfg.php';
require_once 'global/editanydata/model.class.php';
require_once 'global/editanydata/myclass.class.php';

$obj = new MYCLASS($db);

if(!method_exists($obj, $function)) {
	$function = 'view';
}

$obj->$function();

unset($obj);
?>