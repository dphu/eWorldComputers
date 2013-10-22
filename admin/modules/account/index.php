<?php

if(!defined('IN_SYSTEM')) die(header('Location: ../../../die.php'));

require_once 'account.class.php'; 

$activity = new account($db);

if(!method_exists($activity, $function)){
	$function = 'changepass';
}

$activity->$function();
?>