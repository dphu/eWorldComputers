<?php if(!defined('IN_SYSTEM')) die('Acces Denied!');

//file config cac thong so cua module
//chi can thay doi tai day

//cho phep trung ten category hay khong? (TRUE/FALSE)
define ('ALLOW_DUPPLICATE_TITLE', FALSE); 

//cho phep hien thi combo filter tren view hay khong? (TRUE/FALSE)
define ('ALLOW_SHOW_DROPDOWNLIST_FILTER_VIEW', FALSE); 

//modules name
define ('MODULE_CAT_NAME', ''); 
define ('MODULE_NAME', 'state'); 
define ('MODULE_CHILD_NAME', ''); 

//module description
define ('MODULE_DESC_VIEW', 'State Manager');
define ('MODULE_DESC_INSERT', MODULE_DESC_VIEW);
define ('MODULE_DESC_EDIT', MODULE_DESC_VIEW);

//titles
define ('TITLE_VIEW', 'List');
define ('TITLE_INSERT', 'Add New State');
define ('TITLE_EDIT', 'Edit State');

//menu cat filters text
define ('TITLE_FILTER_VIEW', 'Country filter:&nbsp;&nbsp;');
define ('TITLE_FILTER_INSERT', 'Country:&nbsp;');
define ('TITLE_FILTER_EDIT', 'Country:&nbsp;');

//database
define ('TABLE_CAT_NAME', 'tbl_menustate'); 
define ('TABLE_NAME', 'tbl_state'); 
define ('TABLE_CHILD_NAME', ''); 

//error mesage
define ('EMPTY_NAME', 'Invalid');
define ('DUPLICATE_NAME', 'Duplicated!');

//pm
define ('ALI', TRUE); //i
define ('ALD', TRUE); //d
define ('ALSD', TRUE); //thay doi display
define ('ALSS', FALSE); //thay doi sort

?>