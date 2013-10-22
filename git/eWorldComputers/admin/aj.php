<?php
define ('IN_SYSTEM', 1);

session_start();
error_reporting(false);

$sid = isset($_POST['sid']) ? $_POST['sid'] : '';
if ($sid != md5(session_id())) {
	die('');
}

require_once '../config/db.php';
require_once '../libs/db.php';
require_once '../libs/function.php';
require_once '../libs/io/io.class.php';
require_once '../libs/mymodel/mymodel.class.php';
require_once '../libs/loadAnyDataClass/loadAnyDataClass.class.php';
require_once '../config/aj_admin.php';

$db = new DB(USER, PASS, DBNAME, HOST);
$db->connect();
$db->set_utf8();

header('content-type: text/html; charset=utf-8');

//module
$mid = (isset($_POST['mid'])) ? $_POST['mid'] : '';
$mid = preg_replace('([^a-z0-9\-]*)', '', $mid);

if (!in_array($mid, $config['aj_admin'])) {
	die('');
}

require "coreaj/{$mid}.php";

//done
$db->disconnect();
?>