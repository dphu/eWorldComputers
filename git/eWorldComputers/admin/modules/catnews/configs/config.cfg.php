<?php if(!defined('IN_SYSTEM')) die('Acces Denied!');

//file config cac thong so cua module
//chi can thay doi tai day

//cho phep trung ten category hay khong? (TRUE/FALSE)
define ('ALLOW_DUPPLICATE_TITLE', FALSE); 

//cho phep hien thi combo filter tren view hay khong? (TRUE/FALSE)
define ('ALLOW_SHOW_DROPDOWNLIST_FILTER_VIEW', FALSE); 

//modules name
define ('MODULE_CAT_NAME', 'menus'); 
define ('MODULE_NAME', 'catnews'); 
define ('MODULE_CHILD_NAME', 'news'); 

//module description
define ('MODULE_DESC_VIEW', 'Press & News :: Category Manager');
define ('MODULE_DESC_INSERT', MODULE_DESC_VIEW);
define ('MODULE_DESC_EDIT', MODULE_DESC_VIEW);

//titles
define ('TITLE_VIEW', 'List');
define ('TITLE_INSERT', 'Add New Category');
define ('TITLE_EDIT', 'Edit Category');

//menu cat filters text
define ('TITLE_FILTER_VIEW', 'Group name filter:&nbsp;&nbsp;');
define ('TITLE_FILTER_INSERT', 'Group:&nbsp;');
define ('TITLE_FILTER_EDIT', 'Group:&nbsp;');

//database
define ('TABLE_CAT_NAME', 'tbl_menu'); 
define ('TABLE_NAME', 'tbl_cat_news'); 
define ('TABLE_CHILD_NAME', 'tbl_news'); 

//error mesage
define ('EMPTY_NAME', 'Invalid');
define ('DUPLICATE_NAME', 'Duplicated!');

//pm
define ('ALI', FALSE); //i
define ('ALD', FALSE); //d
define ('ALSD', FALSE); //thay doi display
define ('ALSS', FALSE); //thay doi sort

?>