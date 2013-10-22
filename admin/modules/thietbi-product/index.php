<?php 
defined('IN_SYSTEM') or die('<hr>');

require_once 'product.class.php';

$product = new Product($db);

if(!method_exists($product, $function)){
	$function = 'view';
}

$product->$function();
?>