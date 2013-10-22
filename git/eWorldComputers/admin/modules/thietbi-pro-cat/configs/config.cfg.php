<?php if(!defined('IN_SYSTEM')) die('Acces Denied!');

//file config cac thong so cua module
//chi can thay doi tai day

//prefix 
define ('PREFIX', 'thietbi');
define ('MAIN_NAME', 'Eworld Computer');

//modules name
define ('PRO_CAT_MODULE_NAME', PREFIX.'-pro-cat'); //ten cua module 
define ('PRO_MODULE_NAME', PREFIX.'-product'); //quan li sp

//module description
define ('PRO_CAT_MODULE_DESC', 'Eworld Computer');
define ('PRO_CAT_MODULE_DESC_VIEW', 'CATEGORY MANAGER');
define ('PRO_CAT_MODULE_DESC_NEW', 'ADD NEW CATEGORY');
define ('PRO_CAT_MODULE_DESC_EDIT', 'EDIT CATEGORY');

//database
define ('PRO_CAT_TABLE_NAME', 'tbl_cat_products');
define ('PRO_CAT_TABLE_PRODUCTS_NAME', 'product'); 
define ('PRO_CAT_TABLE_IMAGES_NAME', 'tbl_products_images'); 

//msg
define ('MSG_DUPLICATE', 'Duplicate');
define ('MSG_INVALID', 'Invalid');

//allow show sub product list
define ('PRO_CAT_SHOW_SUB_PRODUCT_LIST', TRUE);

//so luong menu con da cap (mac dinh la 0 - khong co cap con)
define ('MULTI_LEVEL_CATS', 1);

//rewrite url
define ('REWRITE_URL_REALPATH_TEMPLATE_ROOT', 'category/{id}');
define ('REWRITE_URL_REALPATH_TEMPLATE', 'category/{id}');

//folder
define ('UPLOAD_PRODUCT_PATH', '../upload/'.PREFIX.'/thumb'); 

?>