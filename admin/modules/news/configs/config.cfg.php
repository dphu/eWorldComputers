<?php if(!defined('IN_SYSTEM')) die('Acces Denied!');

//file config cac thong so cua module
//chi can thay doi tai day

//cho phep trung ten category hay khong? (TRUE/FALSE)
define ('ALLOW_DUPPLICATE_TITLE', FALSE); 

//modules name
define ('MODULE_CAT_NAME', 'catnews'); 
define ('MODULE_NAME', 'news'); 

//module description
define ('MODULE_DESC_VIEW', 'Press & News :: News Manager');
define ('MODULE_DESC_INSERT', MODULE_DESC_VIEW);
define ('MODULE_DESC_EDIT', MODULE_DESC_VIEW);

//titles
define ('TITLE_VIEW', 'List of Items');
define ('TITLE_INSERT', 'Add New Items');
define ('TITLE_EDIT', 'Edit Item');

//database
define ('TABLE_GRAND_FATHER_NAME', 'tbl_menu'); 
define ('TABLE_CAT_NAME', 'tbl_cat_news'); 
define ('TABLE_NAME', 'tbl_news'); 
define ('TABLE_TINH_NAME', 'tbl_tinh'); 

//error mesage
define ('EMPTY_TITLE', 'Invalid');
define ('DUPLICATE_TITLE', 'Duplicated');

//cho phep hien thi combo filter tren view hay khong? (TRUE/FALSE)
define ('ALLOW_SHOW_DROPDOWNLIST_FILTER_VIEW', FALSE); 

//use summary
define ('USE_SUMMERY', FALSE); 

//use date/time
define ('USE_DATETIME', FALSE); 

//use hide title
define ('USE_HIDDENTTLE', FALSE);

//use new
define ('USE_NEW', FALSE);

//rewrite url template
define ('REWRITE_URL_REALPATH_TEMPLATE', 'pressandnews/{id}');

?>