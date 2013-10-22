<?php if(!defined('IN_SYSTEM')) die('Acces Denied!');

//file config cac thong so cua module
//chi can thay doi tai day

//modules name
define ('MODULE_NAME', 'banggia'); //ten cua module 
define ('MODULE_IMAGES_NAME', MODULE_NAME.'images'); //quan li ds hinh anh kem theo module (neu co)

//module description
define ('MODULE_DESC', 'FILES DOWNLOAD MANAGEMENT');

//database
define ('TABLE_NAME', 'tbl_'.MODULE_NAME); //table luu tru noi dung
define ('TABLE_NAME_IMAGE', 'tbl_'.MODULE_NAME.'_img'); //table luu tru hinh anh kem theo

//images folder
define ('UPLOAD_IMAGES_PATH', '../upload/'.MODULE_NAME.'/'); //thu muc chua hinh anh kem theo

?>