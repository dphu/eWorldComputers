<?php if(!defined('IN_SYSTEM')) die('Acces Denied!');

require_once 'myclass.class.php';

$obj = new MYCLASS($db);

if(!method_exists($obj, $function)){
	$function = 'view';
}

$obj->$function();

unset($obj);
?>