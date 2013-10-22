<?php
defined('IN_SYSTEM') or die('<hr>');

require_once 'pro_cat.class.php';

$pro_cat = new pro_cat($db);

if(!method_exists($pro_cat, $function)){
    $function = 'view';
}

$pro_cat->$function();
?>