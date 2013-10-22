<?php if(!defined('IN_SYSTEM')) die('Acces Denied!');

//file config cac thong so cua module
//chi can thay doi tai day

define ('GENERAL_DEFAULT_LANG_CODE', 'en');

//modules name
define ('MODULE_NAME', 'thietbi-productimages'); //ten cua module 
define ('MODULE_CAT_NAME', 'thietbi-product'); //ten cua module 

//module description
define ('MODULE_DESC', 'PRODUCT IMAGES LIST');

//database
define ('TABLE_CAT_NAME', 'product');
define ('TABLE_NAME', 'tbl_products_images'); 

//folder
define ('UPLOAD_PATH', '../attachment/image/');

//width hien thi image (read only) ?
define ('WIDTH_SHOW', 150);

define ('ALLOW_DELETE_IMAGE_SOURCE_WHEN_DELETE_RECORD', FALSE);
?>