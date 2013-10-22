<?php
define( 'IN_SYSTEM', 1 );
session_start();
error_reporting(E_ALL);

require_once '../config/db.php';
require_once '../libs/io/io.class.php'; 
require_once '../libs/function.php'; 

//ajax
require_once '../libs/AJAXSECURITY/AJAXSECURITY.class.php';
if (!AJAXSECURITY::IsSecurity(TRUE))
{
	die('Invalid');
}

$latitude = '';
$longitude = '';

$address = IO::getPOST('address');
$city = IO::getPOST('city');
$state = IO::getPOST('state');
$zip = IO::getPOST('zip');
$url = "http://maps.google.com/maps/geo?q={$address},+{$city},+{$state}+{$zip}&output=csv&oe=utf8&sensor=false&key=".GOOGLE_DEALER_LOCATOR_KEY;
$url = str_replace(' ', '%20',$url);
$s = @file_get_contents($url);
if ($s)
{
	$s = explode(',', $s);
	if (count($s) == 4)
	{
		$status = $s[0];
		if ($status == '200')
		{
			$latitude = $s[2];
			$longitude = $s[3];
		}
	}
}

die ($latitude.','.$longitude);
?>