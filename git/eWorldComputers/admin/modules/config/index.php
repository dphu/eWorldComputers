<?php
defined('IN_SYSTEM') or die('<hr>');


require_once 'config.class.php'; //config

$config = new config($db);

if(!method_exists($config, $function))
{
	$function = 'main';
}

$config->$function();

?>