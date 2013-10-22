<?php
define( 'IN_SYSTEM', 1 );

session_start();
error_reporting(E_ALL);

if (!isset( $_SESSION['logged'] ) || !$_SESSION['logged'] ){
	header( "Location: login.php" );
	exit;
}

require_once ( '../config/db.php' );
require_once ( '../config/upload.php' );
require_once ( '../config/modules.php' );
require_once ( '../libs/db.php' );
require_once ( '../libs/user.class.php' );
require_once ( '../libs/thumbnail.php' );
require_once ( '../libs/function.php' );
require_once ( '../libs/upload.php' );
require_once ( '../libs/image.php' );
require_once ( '../clients/javascript/fckeditor/fckeditor.php' ) ;
require_once (  '../libs/base.class.php' );
require_once ( '../libs/multi-language/multi-language.class.php' );//MY~ test ho tro da ngon ngu~
require_once ( '../libs/io/io.class.php' ); //MY~ test format input POST & GET
require_once ( '../libs/paging/paging.class.php' ); 
require_once ( '../libs/error/error.class.php' ); //MY~ test errors controller class
require_once ( '../config/langdefault.php'); //MY~ test lang
require_once ( '../config/modules_clients.php' ); //MY~ for load auto cac module client (set language)
require_once '../libs/mymodel/mymodel.class.php';
require_once '../libs/loadAnyDataClass/loadAnyDataClass.class.php';
require_once '../libs/stack/stackstatic.class.php';
require_once '../libs/rewriteurl/class.php';

//for AJAX
require_once '../libs/AJAXSECURITY/AJAXSECURITY.class.php';
AJAXSECURITY::CreateKey();

$db = new DB(USER, PASS, DBNAME, HOST);
$db->connect();
$db->set_utf8();

$user = new user( $db );

//kiem tra timeout
if (isTimeout($db)) {
	require 'logout.php';
	exit;
}	
//end of kiem tra timeout

// bat dau vao trang home tai day!!!
$module = (isset($_GET['module'])) ? $_GET['module'] : '';
$module = preg_replace('([^a-z0-9_A-Z\-]*)', '', $module);

$function = (isset($_GET['function'])) ? $_GET['function'] : '';
$function = preg_replace('([^a-z0-9_]*)', '', $function);

if(!in_array($module, $config['modules'])){
	$module = 'main';
}

if($module=='logout')
{ 
	require 'logout.php';	
}

if(isset($_POST)){
	$_POST = IO::formatInput($_POST);
}	
if(isset($_GET)){
	$_GET = IO::formatInput($_GET);
}	

$isPopup = (IO::getKey('mode') == 'popup') ? TRUE : FALSE; 
require_once 'admin_header.php';

//clear error
ERROR::clearAllError();

$db->disconnect();
die();
?>

<?php
//MY~ check timeout
function isTimeout(&$db){$db->query("SELECT `config_value` AS `m` FROM `tbl_config` WHERE `config_name` ='timeout' LIMIT 1");if($db->numRows()){$r=$db->fetchRow();$m=intval($r->m);}else{$m=60;$db->query("INSERT INTO `tbl_config` (`id`,`config_name`, `config_value`) VALUES (NULL, 'timeout', {$m})");return false;}$s=$m*60;if($s){if(!isset($_SESSION['o'])){$_SESSION['o']=time();return false;}else {$sw=time()-$_SESSION['o'];if($sw>$s){return true;}else{$_SESSION['o']=time();return false;}}}else{return false;}}
//end function	
?>