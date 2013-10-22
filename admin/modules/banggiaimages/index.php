<?php 
if(!defined('IN_SYSTEM')){$f='die.php';while(!file_exists($f)||!is_file($f))$f='../'.$f;die(header('Location: '.$f));};

require_once 'myclass.class.php';

$obj = new MYCLASS($db);

if(!method_exists($obj, $function)){
	$function = 'view';
}

$obj->$function();

unset($obj);
?>